<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'manager_name',
        'parent_manager_setting_id'
    ];
    public function user_manager_settings()
    {
        return $this->hasMany(User_manager_setting::class);
    }
  
    // Lấy chức năng con
    public function children_manager_setting()
    {
        return $this->hasMany(Manager_setting::class, 'parent_manager_setting_id');
    }
}
