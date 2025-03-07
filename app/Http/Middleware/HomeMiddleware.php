<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $firstCategory = Category::where('fixed', 0)->first();
        $search = Product::whereHas('categories', function ($query) use ($firstCategory) {
            $query->where('categories.id', $firstCategory->id);
        })
            ->with(['product_files', 'product_variants', 'product_variants.product_votes.user'])
            ->limit(6)
            ->get()
            ->map(function ($search) {
                $activeImage = $search->product_files->where('is_default', 1)->first();
                $inactiveImage = $search->product_files->where('is_default', 0)->first();
                $search->active_image = $activeImage ? $activeImage->file_name : null;
                $search->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;
                $search->priceRange = $search->getPriceRange();

                return $search;
            });

        // Share the search data globally
        view()->share('search', $search);

        return $next($request);
    }
}
