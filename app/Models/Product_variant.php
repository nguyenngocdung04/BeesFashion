<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_variant extends Model
{
    use HasFactory;
    protected $fillable = [
        'SKU',
        'name',
        'image',
        'regular_price',
        'sale_price',
        'stock',
        'product_id',
        'is_active'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant_attribute_values()
    {
        return $this->hasMany(Product_variant_attribute_value::class);
    }
    public function import_histories()
    {
        return $this->hasMany(Import_history::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function order_details()
    {
        return $this->hasMany(Order_detail::class);
    }
    public function product_votes()
    {
        return $this->hasMany(Product_vote::class);
    }
}
