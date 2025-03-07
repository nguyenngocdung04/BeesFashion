<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'attribute_type_id'
    ];
    public function attribute_values()
    {
        return $this->hasMany(Attribute_value::class);
    }
    public function attribute_type()
    {
        return $this->belongsTo(Attribute_type::class);
    }
}
