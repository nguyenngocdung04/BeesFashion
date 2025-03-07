<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_shipping_address extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'phone_number',
        'address',
        'user_id',
        'is_active'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
