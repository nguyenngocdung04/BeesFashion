<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'value_variants',
        'original_price',
        'amount_reduced',
        'quantity',
        'order_id',
        'product_variant_id'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function product_variant()
    {
        return $this->belongsTo(Product_variant::class, 'product_variant_id', 'id');
    }
    public function product_votes()
    {
        return $this->hasMany(Product_vote::class);
    }
}
