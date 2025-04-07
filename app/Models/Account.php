<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Account extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    // Định nghĩa bảng 'accounts' (Laravel mặc định là bảng 'accounts')
    protected $table = 'accounts';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'username', 'password', 'gender', 'phone', 'email', 'birth_date', 'address',
    ];
    
    // Tắt tính năng timestamps
    public $timestamps = false;
}
