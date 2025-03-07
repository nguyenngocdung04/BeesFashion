<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'SKU',
        'name',
        'view',
        'description',
        'fake_sales',
        'is_active',
        'brand_id'
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'product_vouchers');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function product_variants()
    {
        return $this->hasMany(Product_variant::class);
    }
    public function product_categories()
    {
        return $this->hasMany(Product_category::class);
    }
    public function product_files()
    {
        return $this->hasMany(Product_file::class);
    }
    public function product_gallery()
    {
        return $this->hasMany(Product_file::class)->where('is_default', 0)->where('file_type', 'image');
    }

    public function product_videos()
    {
        return $this->hasMany(Product_file::class)->where('is_default', 0)->where('file_type', 'video');
    }
    public function product_likes()
    {
        return $this->hasMany(Product_like::class);
    }
    public function product_vouchers()
    {
        return $this->hasMany(Product_voucher::class);
    }
    public function favorite_products()
    {
        return $this->hasMany(Favorite_product::class);
    }
    public function product_view_histories()
    {
        return $this->hasMany(Product_view_history::class);
    }
  
    public function getPriceRange()
    {
        $variants = $this->product_variants;

        // Lọc các biến thể có `sale_price` không null
        $variantsWithSalePrice = $variants->filter(function ($variant) {
            return $variant->sale_price !== null;
        });

        // Lọc các biến thể chỉ có `regular_price`
        $variantsWithoutSalePrice = $variants->filter(function ($variant) {
            return $variant->sale_price === null;
        });

        // Tìm giá trị thấp nhất và cao nhất
        if ($variantsWithSalePrice->isNotEmpty()) {
            $minPrice = $variantsWithSalePrice->min('sale_price');
            $maxPrice = $variantsWithoutSalePrice->isNotEmpty()
                ? $variantsWithoutSalePrice->max('regular_price')
                : $variantsWithSalePrice->max('sale_price');
        } else {
            $minPrice = $variantsWithoutSalePrice->min('regular_price');
            $maxPrice = $variantsWithoutSalePrice->max('regular_price');
        }

        // Trả về khoảng giá
        return $minPrice === $maxPrice
            ? number_format($minPrice, 0, ',', '.') . 'đ'
            : number_format($minPrice, 0, ',', '.') . 'đ' . ' - ' . number_format($maxPrice, 0, ',', '.') . 'đ';
    }

    public function getRegularPrice()
    {
        $variants = $this->product_variants;
        return $variants->max('regular_price');
    }

    public function getDiscountPercent()
    {
        $variants = $this->product_variants;
        $maxRegularPrice = $variants->max('regular_price');
        $variantsWithSalePrice = $variants->filter(function ($variant) {
            return $variant->sale_price !== null;
        });

        $minSalePrice = $variantsWithSalePrice->min('sale_price');

        if ($maxRegularPrice && $minSalePrice) {
            $discountPercent = number_format((100 - ($minSalePrice / $maxRegularPrice * 100)), 1, '.', '');
            return '-' . $discountPercent . '%';
        }

        return 'Hot!';
    }

}
