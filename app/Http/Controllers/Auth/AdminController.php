<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware để đảm bảo người dùng đã đăng nhập
        $this->middleware('auth');
    }

    public function index()
    {
        // Kiểm tra nếu người dùng là admin
        if (Auth::user() && Auth::user()->username === 'admin') {
            return view('auth.admin');  // Trả về giao diện admin.blade.php
        }

        // Nếu không phải admin, chuyển hướng về trang chủ hoặc trang khác
        return redirect()->route('home');
    }
}

