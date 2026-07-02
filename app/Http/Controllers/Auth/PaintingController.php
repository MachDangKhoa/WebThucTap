<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Models\PaintingDb;  // Model cho bảng painting_db
use App\Models\PaintingGoogle;  // Model cho bảng painting_google
use App\Models\ApiUsageSummary;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Info(
 *     title="API Painting Recognition",
 *     version="1.0.0",
 *     description="API allows users to upload an image of a painting for prediction using an external Flask API."
 * )
 */

class PaintingController extends Controller
{
    // Áp dụng middleware auth để kiểm tra xem người dùng đã đăng nhập hay chưa
    public function __construct()
    {
        $this->middleware('auth');  // Kiểm tra người dùng đã đăng nhập
    }

    public function redirectToDetail(Request $request)
    {
        $request->validate([
            'type' => 'required|in:db,google'
        ]);

        $userId = auth()->id();

        if ($request->type === 'db') {
            $paintings = PaintingDb::where('account_id', $userId)->orderBy('id_db', 'desc')->take(10)->get();

            if ($paintings->isEmpty()) {
                return back()->withErrors(['Không tìm thấy tranh trong Dataset Cosine']);
            }

            $source = 'Dataset Cosine';
            return view('auth.detail', compact('paintings', 'source'));
        }

        if ($request->type === 'google') {
            $paintings = PaintingGoogle::where('accounts_id', $userId)->orderBy('id_gg', 'desc')->take(10)->get();

            if ($paintings->isEmpty()) {
                return back()->withErrors(['Không tìm thấy tranh trong Google Image']);
            }

            $source = 'Google Image';
            return view('auth.detail', compact('paintings', 'source'));
        }

        abort(404);
    }


    public function showSelectionForm(Request $request)
    {
        $paintings = collect(); // mặc định rỗng

        if ($request->has('type')) {
            if ($request->type === 'db') {
                $paintings = PaintingDb::where('account_id', auth()->id())->get();
            } elseif ($request->type === 'google') {
                $paintings = PaintingGoogle::where('accounts_id', auth()->id())->get();
            }
        }

        $source = null;
        return view('auth.detail', compact('paintings', 'source'));
    }

    public function viewDetail($type, $id)
    {
        if ($type === 'db') {
            $painting = PaintingDb::findOrFail($id);
            $image_url = $painting->img_url_db;
            $source = 'Dataset Cosine';
        } elseif ($type === 'google') {
            $painting = PaintingGoogle::findOrFail($id);
            $image_url = $painting->img_url_gg;
            $source = 'Google Image';
        } else {
            abort(404);
        }

        return view('auth.detail', compact('painting', 'image_url', 'source'))->with('paintings', collect());
    }

    /**
     * @OA\Post(
     *     path="/predict",
     *     summary="Predict a painting using a Flask API",
     *     tags={"Paintings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="The image file to be predicted"
     *                 ),
     *                 required={"image"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
    *         response=200,
    *         description="Successful prediction",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="source", type="string", example="Dataset Cosine or Google Image"),
    *             @OA\Property(
    *                 property="result",
    *                 type="object",
    *                 oneOf={
    *                     @OA\Schema(
    *                         type="object",
    *                         @OA\Property(property="painting_title", type="string"),
    *                         @OA\Property(property="artist", type="string"),
    *                         @OA\Property(property="style", type="string"),
    *                         @OA\Property(property="similarity", type="number", example=0.85),
    *                         @OA\Property(property="description", type="string"),
    *                         @OA\Property(property="photographer", type="string")
    *                     ),
    *                     @OA\Schema(
    *                         type="object",
    *                         @OA\Property(property="title", type="string"),
    *                         @OA\Property(property="artist", type="string"),
    *                         @OA\Property(property="style", type="string"),
    *                         @OA\Property(property="genre", type="string"),
    *                         @OA\Property(property="year", type="string"),
    *                         @OA\Property(property="description", type="string"),
    *                         @OA\Property(property="artistic_features", type="string"),
    *                         @OA\Property(property="additional_info", type="string")
    *                     )
    *                 }
    *             )
    *         )
    *     ),
     *     @OA\Response(response=400, description="Invalid image file provided"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */


    // Xử lý phương thức GET và POST cho dự đoán ảnh
    public function predict(Request $request)
    {
        set_time_limit(300); // Thiết lập thời gian tối đa cho script chạy là 300 giây (5 phút)
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
                $url = 'http://localhost:55020/predict';

                // Gửi file ảnh tới Flask API
                $response = $client->post($url, [
                    'timeout' => 300,
                    'multipart' => [
                        [
                            'name'     => 'image',
                            'contents' => fopen($image->getRealPath(), 'r'),
                            'filename' => $image->getClientOriginalName()
                        ]
                    ],

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
                        'account_id' => $accountId,
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
                        'accounts_id' => $accountId,
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
    // =============================================
    // Các phương thức API cho mobile
    // =============================================

    /**
     * API Nhận diện tranh (POST)
     */
    public function apiPredict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240' // Max 10MB
        ]);

        if (!$request->hasFile('image')) {
            return response()->json([
                'success' => false,
                'message' => 'No image provided'
            ], 400);
        }

        $image = $request->file('image');
        $client = new Client();
        $url = 'http://localhost:55020/predict'; // Đảm bảo Flask API đang chạy tại đúng URL

        try {
            // Gửi yêu cầu đến Flask API
            $response = $client->post($url, [
                'timeout' => 300,
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($image->getRealPath(), 'r'),
                        'filename' => $image->getClientOriginalName()
                    ]
                ],
            ]);

            // Nhận kết quả từ Flask API
            $data = json_decode($response->getBody()->getContents(), true);

            // Ghi lại thông tin vào bảng api_usage_summary
            $accountId = auth()->id();
            $endpoint = 'api/predict';

            $record = ApiUsageSummary::where('account_id', $accountId)
                ->where('endpoint', $endpoint)
                ->first();

            if ($record) {
                $record->increment('call_count');
                $record->update(['last_called_at' => now()]);
            } else {
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

            // Lưu thông tin vào bảng tương ứng (painting_db hoặc painting_google)
            if ($data['source'] === 'Dataset Cosine') {
                PaintingDb::create([
                    'account_id' => $accountId,
                    'painting_title' => $data['info']['painting_title'],
                    'artist_db' => $data['info']['artist'],
                    'style_db' => $data['info']['style'],
                    'photographer' => $data['info']['photographer'],
                    'similarity' => $data['info']['similarity'],
                    'description' => $data['info']['description'] ?? null,
                    'img_url_db' => $imageUrl,
                ]);
            } elseif ($data['source'] === 'Google Image') {
                PaintingGoogle::create([
                    'accounts_id' => $accountId,
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

            return response()->json($data); // Trả kết quả về cho người dùng

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Prediction failed: ' . $e->getMessage()
            ], 500); // Log lỗi nếu có ngoại lệ
        }
    }


    /**
     * API Lấy danh sách kết quả (GET)
     */
    public function apiGetPredictions(Request $request)
    {
        $userId = Auth::id();
        
        $dbPaintings = PaintingDb::where('account_id', $userId)
            ->orderBy('id_db', 'desc')
            ->get(['id_db', 'painting_title', 'artist_db', 'img_url_db', 'created_at']);
            
        $googlePaintings = PaintingGoogle::where('accounts_id', $userId)
            ->orderBy('id_gg', 'desc')
            ->get(['id_gg', 'title_gg', 'artist_gg', 'img_url_gg', 'created_at']);

        return response()->json([
            'success' => true,
            'data' => [
                'db_paintings' => $dbPaintings,
                'google_paintings' => $googlePaintings
            ]
        ]);
    }

    /**
     * API Lọc kết quả theo loại (GET)
     */
    public function apiRedirectToDetail(Request $request)
    {
        $request->validate([
            'type' => 'required|in:db,google'
        ]);

        $userId = Auth::id();
        $type = $request->type;

        if ($type === 'db') {
            $paintings = PaintingDb::where('account_id', $userId)
                ->orderBy('id_db', 'desc')
                ->get()
                ->map(function ($p) {
                    return [
                        'id' => $p->id_db,
                        'title' => $p->painting_title,
                        'artist' => $p->artist_db,
                        'style' => $p->style_db,
                        'similarity' => $p->similarity,
                        'description' => $p->description,
                        'image_url' => asset($p->img_url_db),
                        'source' => 'Dataset Cosine'
                    ];
                });
        } else {
            $paintings = PaintingGoogle::where('accounts_id', $userId)
                ->orderBy('id_gg', 'desc')
                ->get()
                ->map(function ($p) {
                    return [
                        'id' => $p->id_gg,
                        'title' => $p->title_gg,
                        'artist' => $p->artist_gg,
                        'style' => $p->style_gg,
                        'genre' => $p->genre_gg,
                        'year' => $p->year_gg,
                        'description' => $p->description_gg,
                        'image_url' => asset($p->img_url_gg),
                        'source' => 'Google Image'
                    ];
                });
        }
        return response()->json([
            'success' => true,
            'data' => [
                'type' => $type,
                'paintings' => $paintings
            ]
        ]);
    }

    /**
     * API Xem chi tiết kết quả (GET)
     */
    public function apiViewDetail($type, $id)
    {
        $userId = Auth::id();

        if ($type === 'db') {
            $painting = PaintingDb::where('id_db', $id)
                ->where('account_id', $userId)
                ->firstOrFail();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'type' => 'db',
                    'painting' => $painting
                ]
            ]);
        } 
        
        if ($type === 'google') {
            $painting = PaintingGoogle::where('id_gg', $id)
                ->where('accounts_id', $userId)
                ->firstOrFail();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'type' => 'google',
                    'painting' => $painting
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid type'
        ], 400);
    }

    // =============================================
    // Các phương thức hỗ trợ
    // =============================================

    private function logApiUsage($accountId, $endpoint)
    {
        $record = ApiUsageSummary::firstOrNew([
            'account_id' => $accountId,
            'endpoint' => $endpoint
        ]);

        $record->call_count = $record->exists ? $record->call_count + 1 : 1;
        $record->last_called_at = now();
        $record->save();
    }

    private function savePredictionResult($accountId, $data, $imageUrl)
    {
        if ($data['source'] === 'Dataset Cosine') {
            return PaintingDb::create([
                'account_id' => $accountId,
                'painting_title' => $data['info']['painting_title'],
                'artist_db' => $data['info']['artist'],
                'style_db' => $data['info']['style'],
                'photographer' => $data['info']['photographer'],
                'similarity' => $data['info']['similarity'],
                'description' => $data['info']['description'] ?? null,
                'img_url_db' => $imageUrl,
            ]);
        } else {
            return PaintingGoogle::create([
                'accounts_id' => $accountId,
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
    }
}



