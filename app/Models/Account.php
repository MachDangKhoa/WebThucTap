<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Account extends Model implements Authenticatable
{
    use HasFactory, HasApiTokens;

    // Định nghĩa bảng 'accounts' (Laravel mặc định là bảng 'accounts')
    protected $table = 'accounts';

    // Chỉ định khóa chính là 'username' thay vì 'id'
    protected $primaryKey = 'id';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'username', 'password', 'gender', 'phone', 'email', 'birth_date', 'address',
    ];

    // Tắt tính năng timestamps
    public $timestamps = false;

    // =============================================
    // Các phương thức bắt buộc của Authenticatable
    // =============================================

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'id'; // Trả về tên trường khóa chính
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->id; // Trả về giá trị của id
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->password; // Trả về mật khẩu đã mã hóa
    }

    /**
     * Get the remember token for the user.
     */
    public function getRememberToken()
    {
        return null; // Không sử dụng remember token
    }

    /**
     * Set the remember token for the user.
     */
    public function setRememberToken($value)
    {
        // Không sử dụng remember token
    }

    /**
     * Get the remember token name for the user.
     */
    public function getRememberTokenName()
    {
        return null; // Không sử dụng remember token
    }
    /**
     * Get the name of the password column.
     */
    public function getAuthPasswordName()
    {
        return 'password'; // Trả về tên cột chứa mật khẩu
    }
}


