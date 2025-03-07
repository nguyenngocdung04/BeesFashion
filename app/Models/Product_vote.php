<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_vote extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'star',
        'edit',
        'product_variant_id',
        'order_detail_id',
        'user_id',
        'is_active'
    ];
    public function product_variant()
    {
        return $this->belongsTo(Product_variant::class);
    }
    public function order_detail()
    {
        return $this->belongsTo(Order_detail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product_vote_files()
    {
        return $this->hasMany(Product_vote_file::class);
    }
}
