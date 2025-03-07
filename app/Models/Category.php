<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'description',
        'fixed',
        'is_active',
        'parent_category_id'
    ];

    public function categoryChildrent()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
    public function product_categories()
    {
        return $this->hasMany(Product_category::class);
    }
 
}
