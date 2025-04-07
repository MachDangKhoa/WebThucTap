<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Models\ApiUsageSummary;  // Import Model ApiUsageSummary

class PaintingController extends Controller
{
    // Áp dụng middleware auth để kiểm tra xem người dùng đã đăng nhập hay chưa
    public function __construct()
    {
        $this->middleware('auth');  // Kiểm tra người dùng đã đăng nhập
    }

    // Xử lý phương thức GET và POST cho dự đoán ảnh
    public function predict(Request $request)
    {
        if ($request->isMethod('get')) {
            // Hiển thị form upload ảnh nếu phương thức là GET
            return view('auth.upload');  // Tạo một view với form upload
        }

        if ($request->isMethod('post')) {
            // Xử lý upload ảnh nếu phương thức là POST
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $client = new Client();

                // Đường dẫn Flask API
                $url = 'http://localhost:5000/predict';

                // Gửi file ảnh tới Flask API
                $response = $client->post($url, [
                    'multipart' => [
                        [
                            'name'     => 'image',
                            'contents' => fopen($image->getRealPath(), 'r'),
                            'filename' => $image->getClientOriginalName()
                        ]
                    ]
                ]);

                // Nhận kết quả trả về từ Flask API
                $data = json_decode($response->getBody()->getContents(), true);

                // Ghi lại thông tin vào bảng api_usage_summary
                $accountId = auth()->id();  // Lấy account_id của người dùng
                $endpoint = '/predict';  // Đường dẫn API được gọi

                // Cập nhật hoặc tạo mới bản ghi cho việc gọi API
                ApiUsageSummary::updateOrCreate(
                    ['account_id' => $accountId, 'endpoint' => $endpoint],
                    ['call_count' => \DB::raw('call_count + 1'), 'last_called_at' => now()]
                );

                // Trả về kết quả cho người dùng
                return response()->json($data);
            }

            return response()->json(['error' => 'No valid image file provided'], 400);
        }
    }
}

