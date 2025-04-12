<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware để đảm bảo người dùng đã đăng nhập
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Kiểm tra nếu người dùng là admin
        if (auth()->check() && auth()->user()->username !== 'admin') {
            return view('auth.dashboard');  // Bạn có thể trả về view admin ở đây
        }

        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập giao diện người dùng.']);
    }
}
