<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_order extends Model
{
    use HasFactory;
    protected $fillable = [
        'status_id',
        'order_id'
    ];
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
