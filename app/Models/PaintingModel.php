<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaintingModel extends Model
{
    use HasFactory;

    protected $table = 'painting_models';  // Đảm bảo đúng tên bảng trong database

    // Các trường có thể được gán giá trị từ input
    protected $fillable = [
        'name',
        'name_train',  // Giữ nguyên 'name_train' vì trường trong CSDL là 'name_train'
        'model_path',
        'is_active',
    ];

    // Đảm bảo trường 'is_active' mặc định là 0 nếu không được truyền vào
    protected $attributes = [
        'is_active' => 0,  // Trường này mặc định sẽ là 0
    ];
}