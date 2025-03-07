<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Chart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    //View dashboard
    public function index()
    {

        $totalProducts = Product::count();
        $totalView = Product::where('is_active', '1')->sum('view');
        $allOrders = Order::with(['status_orders' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(1);  // Lấy trạng thái mới nhất
        }])->orderBy('created_at', 'desc')->get();
        $totalOrders = $allOrders->count();
        $totalUsers = User::where('role', 'member')->count();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalView', 'totalUsers'));
    }

    //Thống kê doanh thu shop theo thời gian
    public function getRevenue(Request $request)
    {
        $timeFrame = $request->get('time_frame', 'this_month');
        [$startDate, $endDate] = $this->getTimeFrameDates($timeFrame);

        $intervals = $this->getIntervalsByTimeFrame($timeFrame, $startDate, $endDate);
        $labels = array_map(function ($interval) {
            return $interval['label'];
        }, $intervals);

        //Lấy doanh thu đổ vào biểu đồ
        $revenue = $this->getRevenueData($intervals, $labels);

        // Tính tổng các chỉ số từ dữ liệu thống kê
        $rawRevenue = Chart::getRevenueStatisticsByIntervals(array_map(function ($interval) {
            return [$interval['start'], $interval['end']];
        }, $intervals));

        $totals = [
            'total_revenue' => 0,
            'total_cost' => 0,
            'profit' => 0,
            'total_orders' => 0
        ];

        foreach ($rawRevenue as $item) {
            $totals['total_revenue'] += $item['total_revenue'];
            $totals['total_cost'] += $item['total_cost'];
            $totals['profit'] += $item['profit'];
            $totals['total_orders'] += $item['total_orders'];
        }

        return response()->json([
            'labels' => $labels,
            'revenue' => array_values($revenue),
            'totals' => $totals
        ]);
    }

    //Lấy khoảng thời gian và doanh thu
    private function getRevenueData(array $intervals, array $labels): array
    {
        $rawRevenue = Chart::getRevenueStatisticsByIntervals(array_map(function ($interval) {
            return [$interval['start'], $interval['end']];
        }, $intervals));

        $revenueByLabels = array_fill_keys($labels, 0);

        foreach ($rawRevenue as $item) {
            if (isset($revenueByLabels[$item['label']])) {
                $revenueByLabels[$item['label']] = $item['total_revenue'];
            }
        }

        return $revenueByLabels;
    }

    //Lấy khoảng thời gian
    private function getIntervalsByTimeFrame(string $timeFrame, Carbon $startDate, Carbon $endDate): array
    {
        if (in_array($timeFrame, ['this_year', 'last_year'])) {
            return $this->getMonthlyIntervals($startDate, $endDate);
        }

        if (in_array($timeFrame, ['this_quarter'])) {
            return $this->getQuarterlyMonthIntervals($startDate, $endDate);
        }

        $daysDifference = $startDate->diffInDays($endDate);
        if ($daysDifference <= 8) {
            return $this->getDailyIntervals($startDate, $endDate);
        }

        return $this->getGroupedIntervals($startDate, $endDate, 7);
    }

    //Lấy ngày cho khoảng thời gian
    private function getTimeFrameDates(string $timeFrame): array
    {
        $today = Carbon::today();
        $dates = match ($timeFrame) {
            'today' => [$today, $today],
            'this_week' => [
                $today->copy()->startOfWeek(Carbon::SUNDAY),
                $today->copy()->endOfWeek(Carbon::SATURDAY)
            ],
            'this_month' => [
                $today->copy()->startOfMonth(),
                $today->copy()->endOfMonth()
            ],
            'this_quarter' => [
                $today->copy()->firstOfQuarter(),
                $today->copy()->lastOfQuarter()
            ],
            'this_year' => [
                $today->copy()->startOfYear(),
                $today->copy()->endOfYear()
            ],
            'last_week' => [
                $today->copy()->subWeek()->startOfWeek(Carbon::SUNDAY),
                $today->copy()->subWeek()->endOfWeek(Carbon::SATURDAY)
            ],
            'last_month' => [
                $today->copy()->subMonth()->startOfMonth(),
                $today->copy()->subMonth()->endOfMonth()
            ],
            'last_year' => [
                $today->copy()->subYear()->startOfYear(),
                $today->copy()->subYear()->endOfYear()
            ],
            'custom' => [
                Carbon::parse(request('start_date'))->startOfDay(),
                Carbon::parse(request('end_date'))->endOfDay()
            ],
            default => [$today, $today]
        };

        return $dates;
    }

    //Lấy khoảng thời gian hằng ngày
    private function getDailyIntervals(Carbon $startDate, Carbon $endDate): array
    {
        $intervals = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $intervals[] = [
                'start' => $current->copy()->startOfDay(),
                'end' => $current->copy()->endOfDay(),
                'label' => $current->format('d/m')
            ];
            $current->addDay();
            if ($current->gt($endDate)) {
                break;
            }
        }

        return $intervals;
    }

    //Lấy khoảng thời gian hàng tháng
    private function getMonthlyIntervals(Carbon $startDate, Carbon $endDate): array
    {
        $intervals = [];
        $current = $startDate->copy()->startOfMonth();

        while ($current->lte($endDate)) {
            $intervals[] = [
                'start' => $current->copy()->startOfMonth(),
                'end' => $current->copy()->endOfMonth(),
                'label' => $current->format('m/Y')
            ];
            $current->addMonth();
        }

        return $intervals;
    }

    //Lấy khoảng thời gian hàng quý
    private function getQuarterlyMonthIntervals(Carbon $startDate, Carbon $endDate): array
    {
        $intervals = [];
        $current = $startDate->copy()->startOfMonth();

        while ($current->lte($endDate)) {
            $intervals[] = [
                'start' => $current->copy()->startOfMonth(),
                'end' => $current->copy()->endOfMonth(),
                'label' => $current->format('m/Y')
            ];
            $current->addMonth();
        }

        return $intervals;
    }

    //Lấy khoảng thời gian được nhóm
    private function getGroupedIntervals(Carbon $startDate, Carbon $endDate, int $groupCount): array
    {
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $daysPerGroup = ceil($totalDays / $groupCount);

        $intervals = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $groupStart = $currentDate->copy();
            $groupEnd = $currentDate->copy()->addDays($daysPerGroup - 1);

            if ($groupEnd->gt($endDate)) {
                $groupEnd = $endDate->copy();
            }

            $intervals[] = [
                'start' => $groupStart->startOfDay(),
                'end' => $groupEnd->endOfDay(),
                'label' => $groupStart->format('d/m') . '-' . $groupEnd->format('d/m')
            ];

            $currentDate = $groupEnd->copy()->addDay();

            if (count($intervals) >= $groupCount || $currentDate->gt($endDate)) {
                break;
            }
        }

        return $intervals;
    }
}
