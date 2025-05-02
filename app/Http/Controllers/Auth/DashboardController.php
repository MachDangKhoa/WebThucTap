<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\WebsiteConfig;
use App\Models\PaintingDb;
use App\Models\PaintingGoogle;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware để đảm bảo người dùng đã đăng nhập
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Kiểm tra nếu người dùng không là admin
        if (auth()->check() && auth()->user()->username !== 'admin' || auth()->user()->username == 'admin'){
            $config = WebsiteConfig::first();
            $paintingDb = PaintingDb::all();
            $paintingGoogle = PaintingGoogle::all();
            return view('auth.dashboard', compact('config', 'paintingDb', 'paintingGoogle'));  
        }

        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập giao diện người dùng.']);
    }
}
