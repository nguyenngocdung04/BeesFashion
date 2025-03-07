<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_file extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'file_type',
        'product_id',
        'is_default'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
