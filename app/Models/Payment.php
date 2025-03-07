<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'note',
        'payment_method',
        'response_code',
        'bank_code',
        'transaction_code',
        'pay_type',
        'partner_code',
        'request_id',
        'pay_date',
        'status'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
