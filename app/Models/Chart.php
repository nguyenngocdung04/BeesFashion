<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chart extends Model
{
    use HasFactory;

    //Thống kê doanh thu, chi phí, lợi nhuận, số lượt order cửa hàng theo thời gian
    public static function getRevenueStatisticsByIntervals($intervals)
    {
        $caseStatements = [];
        $labels = [];

        foreach ($intervals as $index => $range) {
            $label = $range[0]->format('d/m');
            if ($range[0]->format('Y-m-d') !== $range[1]->format('Y-m-d')) {
                $label = $range[0]->format('d/m') . '-' . $range[1]->format('d/m');
            }
            // Xử lý trường hợp tháng
            if (
                $range[0]->format('Y-m') === $range[1]->format('Y-m') &&
                $range[0]->format('d') === '01' &&
                $range[1]->format('d') === $range[1]->copy()->endOfMonth()->format('d')
            ) {
                $label = $range[0]->format('m/Y');
            }

            $labels[] = $label;
            $caseStatements[] = "
        WHEN orders.created_at BETWEEN '{$range[0]->format('Y-m-d')} 00:00:00'
        AND '{$range[1]->format('Y-m-d')} 23:59:59'
        THEN '{$label}'";
        }

        $importIntervals = DB::table('import_histories')
            ->selectRaw('
        product_variant_id,
        import_price,
        created_at as start_time,
        COALESCE(LEAD(created_at) OVER (PARTITION BY product_variant_id ORDER BY created_at), NOW()) as end_time');

        $query = Order::selectRaw("
        CASE " . implode("\n", $caseStatements) . "
        END as label,
        COALESCE(SUM((order_details.original_price* order_details.quantity) - order_details.amount_reduced ), 0) as total_revenue,
        COALESCE(SUM(order_details.quantity * import_intervals.import_price), 0) as total_cost,
        COUNT(DISTINCT orders.id) as total_orders")
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->joinSub($importIntervals, 'import_intervals', function ($join) {
                $join->on('order_details.product_variant_id', '=', 'import_intervals.product_variant_id')
                    ->whereRaw('orders.created_at BETWEEN import_intervals.start_time AND import_intervals.end_time');
            })
            ->where('status_orders.status_id', 4)
            ->whereBetween('orders.created_at', [$intervals[0][0]->startOfDay(), end($intervals)[1]->endOfDay()])
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->label,
                    'total_revenue' => $item->total_revenue, //doanh thu
                    'total_cost' => $item->total_cost, //chi phí nhập
                    'profit' => $item->total_revenue - $item->total_cost, //lợi nhuận
                    'total_orders' => $item->total_orders //số lượng order
                ];
            });

        return $query->toArray();
    }

    //Thống kê doanh thu, chi phí, lợi nhuận, số lượt order của sản phẩm theo thời gian
    public static function getTopSellingProducts($limit = 10, $date, $type = 'day')
    {
        $importIntervals = DB::table('import_histories')
            ->selectRaw('
            product_variant_id,
            import_price,
            created_at as start_time,
            COALESCE(LEAD(created_at) OVER (PARTITION BY product_variant_id ORDER BY created_at), NOW()) as end_time
        ');

        $query = Product::select([
            'products.id',
            'products.name',
            DB::raw('SUM(order_details.quantity) as total_quantity'),
            DB::raw('COALESCE(SUM((order_details.original_price * order_details.quantity)- order_details.amount_reduced) , 0) as total_revenue'),
            DB::raw('SUM(order_details.quantity * import_intervals.import_price) as total_cost')
        ])
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_details', 'product_variants.id', '=', 'order_details.product_variant_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->joinSub($importIntervals, 'import_intervals', function ($join) {
                $join->on('order_details.product_variant_id', '=', 'import_intervals.product_variant_id')
                    ->whereRaw('orders.created_at BETWEEN import_intervals.start_time AND import_intervals.end_time');
            })
            ->where('status_orders.status_id', 4);

        switch ($type) {
            case 'day':
                $query->whereDate('orders.created_at', Carbon::parse($date)->format('Y-m-d'));
                break;
            case 'month':
                $date = Carbon::parse($date);
                $query->whereYear('orders.created_at', $date->year)
                    ->whereMonth('orders.created_at', $date->month);
                break;
            case 'year':
                $query->whereYear('orders.created_at', $date);
                break;
        }

        $query->groupBy('products.id', 'products.name');
        $productsData = $query->get();
        $sortedProducts = $productsData->sortByDesc('total_revenue');

        $topProducts = $sortedProducts->take($limit)->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'total_quantity' => $item->total_quantity,
                'total_revenue' => $item->total_revenue,
                'total_cost' => $item->total_cost,
                'profit' => $item->total_revenue - $item->total_cost
            ];
        })->values();

        $otherProducts = $sortedProducts->slice($limit);
        $others = [
            'id' => null,
            'name' => 'Other products',
            'total_quantity' => $otherProducts->sum('total_quantity'),
            'total_revenue' => $otherProducts->sum('total_revenue'),
            'total_cost' => $otherProducts->sum('total_cost'),
            'profit' => $otherProducts->sum('total_revenue') - $otherProducts->sum('total_cost')
        ];

        $result = $topProducts->toArray();
        if ($others['total_quantity'] > 0) {
            $result[] = $others;
        }

        $overallTotals = [
            'total_revenue' => $productsData->sum('total_revenue'),
            'total_cost' => $productsData->sum('total_cost'),
            'total_profit' => $productsData->sum('total_revenue') - $productsData->sum('total_cost'),
            'total_quantity' => $productsData->sum('total_quantity')
        ];

        return [
            'data' => $result,
            'totals' => $overallTotals,
            'period' => [
                'type' => $type,
                'date' => $date
            ]
        ];
    }

    //Thống kê sản phẩm có trong giỏ hàng
    public static function getCartStatistics()
    {
        $cartData = Cart::select([
            'products.id as product_id',
            'products.name as product_name',
            'products.SKU as product_sku',
            'product_variants.id as variant_id',
            'product_variants.name as variant_name',
            'product_variants.SKU as variant_sku',
            'product_variants.sale_price',
            'product_variants.regular_price',
            'carts.quantity'
        ])
            ->join('product_variants', 'carts.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->where('product_variants.is_active', 1)
            ->where('products.is_active', 1)
            ->get();

        $groupedData = [];

        foreach ($cartData as $item) {
            $productId = $item->product_id;
            $price = $item->sale_price ?? $item->regular_price;
            $totalValue = $price * $item->quantity;

            if (!isset($groupedData[$productId])) {
                $groupedData[$productId] = [
                    'id' => $productId,
                    'product_name' => $item->product_name,
                    'product_sku' => $item->product_sku,
                    'total_quantity' => 0,
                    'min_price' => $price,
                    'max_price' => $price,
                    'total_value' => 0,
                    'variants' => []
                ];
            }

            $groupedData[$productId]['total_quantity'] += $item->quantity;
            $groupedData[$productId]['min_price'] = min($groupedData[$productId]['min_price'], $price);
            $groupedData[$productId]['max_price'] = max($groupedData[$productId]['max_price'], $price);
            $groupedData[$productId]['total_value'] += $totalValue;

            $groupedData[$productId]['variants'][] = [
                'id' => $item->variant_id,
                'variant_name' => $item->variant_name,
                'variant_sku' => $item->variant_sku,
                'quantity' => $item->quantity,
                'price' => $price,
                'total_value' => $totalValue
            ];
        }

        return array_values($groupedData);
    }

    //Thống kê doanh thu theo thương hiệu
    //Phạm vi thời gian thống kê
    private function getTimeRanges(): array
    {
        return [
            'today' => [
                'label' => 'Hôm nay',
                'start' => Carbon::today(),
                'end' => Carbon::now()
            ],
            'this_week' => [
                'label' => 'Tuần này',
                'start' => Carbon::now()->startOfWeek(),
                'end' => Carbon::now()
            ],
            'last_week' => [
                'label' => 'Tuần trước',
                'start' => Carbon::now()->subWeek()->startOfWeek(),
                'end' => Carbon::now()->subWeek()->endOfWeek()
            ],
            'this_month' => [
                'label' => 'Tháng này',
                'start' => Carbon::now()->startOfMonth(),
                'end' => Carbon::now()
            ],
            'last_month' => [
                'label' => 'Tháng trước',
                'start' => Carbon::now()->subMonth()->startOfMonth(),
                'end' => Carbon::now()->subMonth()->endOfMonth()
            ],
            'this_quarter' => [
                'label' => 'Quý này',
                'start' => Carbon::now()->startOfQuarter(),
                'end' => Carbon::now()
            ],
            'last_quarter' => [
                'label' => 'Quý trước',
                'start' => Carbon::now()->subQuarter()->startOfQuarter(),
                'end' => Carbon::now()->subQuarter()->endOfQuarter()
            ],
            'this_year' => [
                'label' => 'Năm nay',
                'start' => Carbon::now()->startOfYear(),
                'end' => Carbon::now()
            ],
            'last_year' => [
                'label' => 'Năm trước',
                'start' => Carbon::now()->subYear()->startOfYear(),
                'end' => Carbon::now()->subYear()->endOfYear()
            ]
        ];
    }

    //Thời gian cụ thể
    private function getTimeRange(string $range): array
    {
        $ranges = $this->getTimeRanges();
        return $ranges[$range] ?? $ranges['this_month'];
    }

    private function getBaseQuery($startDate, $endDate)
    {
        $importIntervals = DB::table('import_histories')
            ->selectRaw('
                product_variant_id,
                import_price,
                created_at as start_time,
                COALESCE(LEAD(created_at) OVER (PARTITION BY product_variant_id ORDER BY created_at), NOW()) as end_time'
            );

        return Brand::query()
            ->select([
                'brands.id',
                'brands.name as brand_name',
                'p.id as product_id',
                'p.name as product_name',
                'pv.id as variant_id',
                'pv.name as variant_name',
                DB::raw('COUNT(DISTINCT o.id) as total_orders'),
                DB::raw('SUM(od.quantity) as total_products_sold'),
                DB::raw('SUM((od.quantity * od.original_price) - COALESCE(od.amount_reduced, 0)) as revenue'),
                DB::raw('SUM(od.quantity * import_intervals.import_price) as cost'),
                DB::raw('SUM((od.quantity * od.original_price) - COALESCE(od.amount_reduced, 0)) - SUM(od.quantity * import_intervals.import_price) as profit')
            ])
            ->leftJoin('products as p', 'brands.id', '=', 'p.brand_id')
            ->leftJoin('product_variants as pv', 'p.id', '=', 'pv.product_id')
            ->leftJoin('order_details as od', 'pv.id', '=', 'od.product_variant_id')
            ->leftJoin('orders as o', 'od.order_id', '=', 'o.id')
            ->leftJoin('status_orders as so', 'o.id', '=', 'so.order_id')
            ->leftJoin('statuses as s', 'so.status_id', '=', 's.id')
            ->joinSub($importIntervals, 'import_intervals', function ($join) {
                $join->on('od.product_variant_id', '=', 'import_intervals.product_variant_id')
                    ->whereRaw('o.created_at BETWEEN import_intervals.start_time AND import_intervals.end_time');
            })
            ->where('s.name', '=', 'Completed')
            ->whereBetween('o.created_at', [$startDate, $endDate])
            ->groupBy('brands.id', 'brands.name', 'p.id', 'p.name', 'pv.id', 'pv.name')
            ->orderBy('brands.name')
            ->orderBy('p.name')
            ->orderBy('revenue', 'desc');
    }

    private function formatVariantStats(Collection $variants): array
    {
        return $variants->map(function ($variant) {
            return [
                'variant_name' => $variant->variant_name,
                'orders' => $variant->total_orders,
                'quantity_sold' => $variant->total_products_sold,
                'revenue' => $variant->revenue,
                'cost' => $variant->cost,
                'profit' => $variant->profit
            ];
        })->toArray();
    }

    private function formatProductStats(Collection $products): array
    {
        return $products->groupBy('product_name')
            ->map(function ($variants) {
                return [
                    'product_name' => $variants->first()->product_name,
                    'total_orders' => $variants->sum('total_orders'),
                    'total_products_sold' => $variants->sum('total_products_sold'),
                    'total_revenue' => $variants->sum('revenue'),
                    'total_cost' => $variants->sum('cost'),
                    'total_profit' => $variants->sum('profit'),
                    'variants' => $this->formatVariantStats($variants)
                ];
            })->values()->toArray();
    }

    private function formatBrandStats(Collection $brandStats): array
    {
        return [
            'brand_name' => $brandStats->first()->brand_name,
            'total_orders' => $brandStats->sum('total_orders'),
            'total_products_sold' => $brandStats->sum('total_products_sold'),
            'total_revenue' => $brandStats->sum('revenue'),
            'total_cost' => $brandStats->sum('cost'),
            'total_profit' => $brandStats->sum('profit'),
            'products' => $this->formatProductStats($brandStats)
        ];
    }

    public function getBrandStatistics(string $timeRange = 'this_month'): array
    {
        $range = $this->getTimeRange($timeRange);
        $stats = $this->getBaseQuery($range['start'], $range['end'])->get();

        return [
            'time_range' => $range,
            'time_ranges' => $this->getTimeRanges(),
            'statistics' => $stats->groupBy('brand_name')
                ->map(fn ($brandStats) => $this->formatBrandStats($brandStats))
                ->values()
                ->toArray()
        ];
    }

    //Thống kê doanh thu theo khách hàng
    public function getRevenueStatistics(string $type = 'monthly')
    {
        $dateRange = $this->getDateRange($type);
        $query = Order::query()
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->join('statuses', 'status_orders.status_id', '=', 'statuses.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('statuses.name', 'Completed');

        if ($type !== 'all') {
            $query->whereBetween('orders.created_at', [$dateRange->start, $dateRange->end]);
        }

        $dateFormat = match ($type) {
            'daily' => '%Y-%m-%d',
            'monthly' => '%Y-%m',
            'yearly' => '%Y',
            'all' => '%Y',
            default => '%Y-%m'
        };

        return $query->select([
            DB::raw("DATE_FORMAT(orders.created_at, '$dateFormat') as period"),
            DB::raw('COUNT(DISTINCT orders.user_id) as total_customers'),
            DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
            DB::raw('SUM(orders.total_payment) as total_revenue'),
            DB::raw('AVG(orders.total_payment) as average_order_value'),
            DB::raw('SUM(orders.total_payment) / COUNT(DISTINCT orders.user_id) as average_customer_spending')
        ])
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(fn($item) => [
                'period' => $item->period,
                'total_customers' => (int)$item->total_customers,
                'total_orders' => (int)$item->total_orders,
                'total_revenue' => (int)$item->total_revenue,
                'average_order_value' => round($item->average_order_value, 2),
                'average_customer_spending' => round($item->average_customer_spending, 2)
            ]);
    }

    public function getCustomerSpendingDetails(string $type = 'monthly')
    {
        $dateRange = $this->getDateRange($type);
        $query = Order::query()
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->join('statuses', 'status_orders.status_id', '=', 'statuses.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('statuses.name', 'Completed');

        if ($type !== 'all') {
            $query->whereBetween('orders.created_at', [$dateRange->start, $dateRange->end]);
        }

        return $query->groupBy('users.id', 'users.full_name', 'users.username', 'users.email')
            ->select([
                'users.id',
                'users.full_name',
                'users.username',
                'users.email',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(orders.total_payment) as total_spending'),
                DB::raw('AVG(orders.total_payment) as average_order_value'),
                DB::raw('MIN(orders.created_at) as first_order_date'),
                DB::raw('MAX(orders.created_at) as last_order_date')
            ])
            ->orderByDesc('total_spending')
            ->get()
            ->map(fn($customer) => [
                'id' => $customer->id,
                'full_name' => $customer->full_name ?: $customer->username,
                'email' => $customer->email,
                'total_orders' => $customer->total_orders,
                'total_spending' => $customer->total_spending,
                'average_order_value' => round($customer->average_order_value, 2),
                'first_order_date' => $customer->first_order_date,
                'last_order_date' => $customer->last_order_date,
                'tier' => $this->getCustomerTier($customer->total_spending)
            ]);
    }

    private function getDateRange(string $type): object
    {
        $now = Carbon::now();

        return match ($type) {
            'daily' => (object)[
                'start' => $now->startOfDay()->format('Y-m-d H:i:s'),
                'end' => $now->endOfDay()->format('Y-m-d H:i:s')
            ],
            'monthly' => (object)[
                'start' => $now->startOfMonth()->format('Y-m-d H:i:s'),
                'end' => $now->endOfMonth()->format('Y-m-d H:i:s')
            ],
            'yearly' => (object)[
                'start' => $now->startOfYear()->format('Y-m-d H:i:s'),
                'end' => $now->endOfYear()->format('Y-m-d H:i:s')
            ],
            'all' => (object)[
                'start' => null,
                'end' => null
            ],
            default => (object)[
                'start' => $now->startOfMonth()->format('Y-m-d H:i:s'),
                'end' => $now->endOfMonth()->format('Y-m-d H:i:s')
            ]
        };
    }

    private function getCustomerTier(int $totalSpending): array
    {
        if ($totalSpending == 0) {
            return ['name' => 'Chưa có', 'class' => 'badge bg-light text-dark'];
        } elseif ($totalSpending < 2000000) {
            return ['name' => 'Đồng', 'class' => 'badge bg-primary text-light'];
        } elseif ($totalSpending < 5000000) {
            return ['name' => 'Bạc', 'class' => 'badge bg-secondary text-light'];
        } elseif ($totalSpending < 10000000) {
            return ['name' => 'Vàng', 'class' => 'badge bg-warning text-light'];
        } else {
            return ['name' => 'Kim cương', 'class' => 'badge bg-danger text-light'];
        }
    }
}
