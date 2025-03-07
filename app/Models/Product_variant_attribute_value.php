<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_variant_attribute_value extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'attribute_value_id'
    ];
    public function attribute_value()
    {
        return $this->belongsTo(Attribute_value::class);
    }
    public function attribute_type()
    {
        return $this->belongsTo(Attribute_type::class);
    }
    public function product_variant()
    {
        return $this->belongsTo(Product_variant::class);
    }
}
