<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function status_orders()
    {
        return $this->hasMany(Status_order::class);
    }
}
