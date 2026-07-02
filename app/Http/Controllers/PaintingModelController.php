<?php

// app/Http/Controllers/Admin/PaintingModelController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaintingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PaintingModelController extends Controller
{
    // Phương thức index hiển thị danh sách models
    public function index()
    {
        $models = PaintingModel::latest()->get();
        if (auth()->check() && auth()->user()->username === 'admin') {
            return view('admin.index', compact('models'));
        }
        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập trang admin.']);
        
    }

    // Phương thức store để thêm model mới
    public function store(Request $req)
    {
        // Validate dữ liệu đầu vào
        $req->validate([
            'name' => 'required|string|max:255',
            'train_name' => 'required|file|mimes:txt|max:102400', // Kiểm tra file .txt
            'model_file' => 'required|file|max:512000', // Kiểm tra file model
        ]);

       // Di chuyển file .txt vào thư mục public/storage/train_names
        $train_nameFile = $req->file('train_name');  // Đây là file .txt
        $train_nameFileName = $train_nameFile->getClientOriginalName();  // Lấy tên gốc của file .txt
        $train_namePath = 'D:/LuanVanTotNghiep/NhanDienThongTinTranh/data/' . $train_nameFileName;  // Đặt tên và đường dẫn tương đối cho file .txt

        // Di chuyển file vào thư mục public/storage/train_names
        $train_nameFile->move(('D:/LuanVanTotNghiep/NhanDienThongTinTranh/data'), $train_nameFileName);

        // Di chuyển file model vào thư mục public/storage/models
        $modelFile = $req->file('model_file');  // Đây là file model
        $modelFileName = $modelFile->getClientOriginalName();  // Lấy tên gốc của file model
        $modelFilePath = 'D:/LuanVanTotNghiep/NhanDienThongTinTranh/features/' . $modelFileName;  // Đặt tên và đường dẫn tương đối cho file model

        // Di chuyển file model vào thư mục public/storage/models
        $modelFile->move(('D:/LuanVanTotNghiep/NhanDienThongTinTranh/features'), $modelFileName);
        // Lưu dữ liệu vào database
        PaintingModel::create([
            'name' => $req->name,
            'name_train' => $train_namePath, // Lưu đường dẫn file .txt
            'model_path' => $modelFilePath, // Lưu đường dẫn file model
            'is_active' => 0, // Lưu giá trị mặc định là 0
        ]);

        return redirect()->route('admin.models.index')->with('success', 'Model đã được thêm thành công!');
    }
    
    // Phương thức update để cập nhật tên của model
    public function update(Request $req, $id)
    {
        $m = PaintingModel::findOrFail($id);

        // Validate the name
        $req->validate(['name' => 'required|string|max:255']);

        // Update the model's name
        $m->update(['name' => $req->name]);

        // Redirect back with success message
        return redirect()->route('admin.models.index')->with('success', 'Đã cập nhật thông tin model.');
    }

    // Phương thức destroy để xóa model
    public function destroy($id)
{
    // Lấy model
    $model = PaintingModel::findOrFail($id);

    // Lấy đường dẫn từ các cột đã lưu trong DB
    $trainNamePath = $model->name_train;
    $modelFilePath = $model->model_path;

    // Xóa file .txt nếu tồn tại
    if (File::exists($trainNamePath)) {
        File::delete($trainNamePath);
    }

    // Xóa file model nếu tồn tại
    if (File::exists($modelFilePath)) {
        File::delete($modelFilePath);
    }

    // Xóa record khỏi database
    $model->delete();

    return redirect()->route('admin.models.index')->with('success', 'Đã xóa model và các file liên quan.');
}

// Phương thức để đánh dấu model "đang sử dụng"
public function use($id)
{
    // Tìm model theo ID
    $model = PaintingModel::findOrFail($id);

    // Đánh dấu tất cả các model không sử dụng
    PaintingModel::query()->update(['is_active' => false]);

    // Đánh dấu model được chọn là đang sử dụng
    $model->is_active = true;
    $model->save();

    return back()->with('success', "Đã chọn model “{$model->name}” để sử dụng.");
}

}
