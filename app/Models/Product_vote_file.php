<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_vote_file extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'file_type',
        'product_vote_id'
    ];
    public function product_vote()
    {
        return $this->belongsTo(Product_vote::class);
    }
}
