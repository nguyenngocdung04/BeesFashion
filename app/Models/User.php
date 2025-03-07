<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'phone',
        'address',
        'email_verified_at',
        'password',
        'role',
        'status',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function product_likes()
    {
        return $this->hasMany(Product_like::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function user_shipping_addresses()
    {
        return $this->hasMany(User_shipping_address::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function product_votes()
    {
        return $this->hasMany(Product_vote::class);
    }
    public function favorite_products()
    {
        return $this->hasMany(Favorite_product::class);
    }
    public function product_view_histories()
    {
        return $this->hasMany(Product_view_history::class);
    }
    public function user_manager_settings()
    {
        return $this->hasMany(User_manager_setting::class);
    }
    public function user_bans()
    {
        return $this->hasMany(User_ban::class);
    }
    public function import_histories()
    {
        return $this->hasMany(Import_history::class);
    }
    public function user_vouchers()
    {
        return $this->hasMany(User_voucher::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Lấy tất cả quyền của người dùng
    public function permissions()
    {
        return $this->belongsToMany(Manager_setting::class, 'user_manager_settings')
            ->withPivot('is_active')
            ->withTimestamps();
    }

    //Địa chỉ giao hàng mặc định
    public function defaultShippingAddress()
    {
        return $this->hasOne(User_shipping_address::class)->where('is_active', 1);
    }

    // Lấy tổng số tiền đã chi tiêu từ các đơn hàng đã hoàn thành
    public function getTotalSpent()
    {
        return $this->orders()
            ->whereHas('status_orders', function ($query) {
                $query->whereHas('status', function ($q) {
                    $q->where('name', 'Completed');
                });
            })
            ->sum('total_payment');
    }

    // Lấy hạng thành viên dựa trên tổng chi tiêu
    public function getMembershipRank()
    {
        $totalSpent = $this->getTotalSpent();

        if ($totalSpent == 0) {
            return 'Chưa có';
        } elseif ($totalSpent < 2000000) {
            return 'Đồng';
        } elseif ($totalSpent < 5000000) {
            return 'Bạc';
        } elseif ($totalSpent < 10000000) {
            return 'Vàng';
        } else {
            return 'Kinh cương';
        }
    }


    // Lấy tổng số đơn hàng
    public function getTotalOrders()
    {
        return $this->orders()
            ->whereHas('status_orders', function ($query) {
                $query->whereHas('status', function ($q) {
                    $q->where('name', 'Completed');
                });
            })
            ->count();
    }
}
