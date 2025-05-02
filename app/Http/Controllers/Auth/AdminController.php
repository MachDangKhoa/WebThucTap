<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaintingModelController;
use App\Models\Account;
use App\Models\PaintingModel;
use App\Models\PaintingDb;
use App\Models\PaintingGoogle;
use App\Models\ApiUsageSummary;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware để đảm bảo người dùng đã đăng nhập
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Kiểm tra nếu người dùng là admin
        if (auth()->check() && auth()->user()->username === 'admin') {
            $models = PaintingModel::latest()->get();
            $accounts = Account::all();
            $paintingDb = PaintingDb::all();
            $paintingGoogle = PaintingGoogle::all();
            $totalCallCount = ApiUsageSummary::sum('call_count');
            return view('auth.admin', compact('models', 'accounts', 'paintingDb', 'paintingGoogle', 'totalCallCount'));  // Bạn có thể trả về view admin ở đây
            
        }

        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập trang admin.']);
    }
}
