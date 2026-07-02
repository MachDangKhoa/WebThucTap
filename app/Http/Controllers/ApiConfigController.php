<?php

namespace App\Http\Controllers;

use App\Models\APIConfig;
use Illuminate\Http\Request;

class APIConfigController extends Controller
{
    // Hiển thị form chọn LLM
    public function showForm()
    {
        $config = APIConfig::first(); // Lấy dữ liệu cấu hình đầu tiên nếu có

        if (auth()->check() && auth()->user()->username === 'admin') {
            return view('admin.form', compact('config'));
        }
        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập trang admin.']);
        
    }

    // Lưu hoặc cập nhật cấu hình LLM
    public function storeOrUpdateConfig(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'llm_name' => 'required|in:Gemini,ChatGPT', // Chọn giữa Gemini hoặc ChatGPT
            'api_key' => 'required|string|max:255',
            'model_name' => 'required|string|max:255',
        ]);

        // Kiểm tra xem có cấu hình nào trong cơ sở dữ liệu chưa
        $config = APIConfig::first();

        if ($config) {
            // Nếu có, cập nhật thông tin
            $config->update([
                'llm_name' => $validated['llm_name'],
                'api_key' => $validated['api_key'],
                'model_name' => $validated['model_name'],
            ]);
        } else {
            // Nếu chưa có, tạo mới thông tin cấu hình
            APIConfig::create([
                'llm_name' => $validated['llm_name'],
                'api_key' => $validated['api_key'],
                'model_name' => $validated['model_name'],
            ]);
        }

        // Quay lại form với thông báo thành công
        return redirect()->route('api.config.form')->with('success', 'Cấu hình đã được lưu thành công.');
    }
}
