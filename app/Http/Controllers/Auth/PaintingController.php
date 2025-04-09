<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Models\PaintingDb;  // Model cho bảng painting_db
use App\Models\PaintingGoogle;  // Model cho bảng painting_google
use App\Models\ApiUsageSummary;
use Illuminate\Support\Facades\Storage;

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
                    ],
                        'timeout' => 9999,
                ]);

                // Nhận kết quả trả về từ Flask API
                $data = json_decode($response->getBody()->getContents(), true);

                // Ghi lại thông tin vào bảng api_usage_summary
                $accountId = auth()->id();
                $endpoint = '/predict';

                // Tìm bản ghi hiện tại
                $record = ApiUsageSummary::where('account_id', $accountId)
                    ->where('endpoint', $endpoint)
                    ->first();

                if ($record) {
                    // Nếu đã tồn tại thì tăng call_count
                    $record->increment('call_count');
                    $record->update(['last_called_at' => now()]);
                } else {
                    // Nếu chưa tồn tại thì tạo mới với call_count = 1
                    ApiUsageSummary::create([
                        'account_id' => $accountId,
                        'endpoint' => $endpoint,
                        'call_count' => 1,
                        'last_called_at' => now()
                    ]);
                }

                // Lưu hình ảnh vào thư mục public/uploads và tạo URL
                $imagePath = $image->store('uploads', 'public');
                $imageUrl = Storage::url($imagePath);

                // Lưu thông tin vào bảng tương ứng
                if ($data['source'] === 'Dataset Cosine') {
                    // Lưu vào bảng painting_db
                    PaintingDb::create([
                        'painting_title' => $data['info']['painting_title'],
                        'artist_db' => $data['info']['artist'],
                        'style_db' => $data['info']['style'],
                        'photographer' => $data['info']['photographer'],
                        'similarity' => $data['info']['similarity'],
                        'description' => $data['info']['description'] ?? null,
                        'img_url_db' => $imageUrl,
                    ]);
                } elseif ($data['source'] === 'Google Image') {
                    // Lưu vào bảng painting_google
                    PaintingGoogle::create([
                        'title_gg' => $data['gemini_info']['title'] ?? null,
                        'artist_gg' => $data['gemini_info']['artist'] ?? null,
                        'style_gg' => $data['gemini_info']['style'] ?? null,
                        'genre_gg' => $data['gemini_info']['genre'] ?? null,
                        'year_gg' => $data['gemini_info']['year'] ?? null,
                        'description_gg' => $data['gemini_info']['description'] ?? null,
                        'artistic_features_gg' => $data['gemini_info']['artistic_features'] ?? null,
                        'additional_info_gg' => $data['gemini_info']['additional_info'] ?? null,
                        'img_url_gg' => $imageUrl,
                    ]);
                }

                // Trả về kết quả cho người dùng
                return response()->json($data);
            }

            return response()->json(['error' => 'No valid image file provided'], 400);
        }
    }
}



