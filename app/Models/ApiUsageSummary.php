<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUsageSummary extends Model
{
    use HasFactory;

    // Định nghĩa tên bảng (vì tên bảng là dạng plural, bạn có thể bỏ qua bước này nếu tên bảng tuân theo quy ước Laravel)
    protected $table = 'api_usage_summary';

    // Định nghĩa các trường có thể gán hàng loạt (mass assignable)
    protected $fillable = [
        'account_id',
        'endpoint',
        'call_count',
        'last_called_at',
    ];

    // Nếu bạn muốn sử dụng Carbon để xử lý ngày tháng, bạn có thể thêm:
    protected $dates = ['last_called_at'];

    // Tùy chọn nếu bạn không muốn tự động quản lý timestamps (created_at, updated_at)
    public $timestamps = false; // Vì bảng của bạn không có cột created_at, updated_at
}
