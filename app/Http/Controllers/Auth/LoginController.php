<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Các phương thức web hiện tại (giữ nguyên)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        Auth::logout();

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->username === 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Đăng nhập thành công với tài khoản admin!');
            }

            return redirect()->route('dashboard')->with('message', 'Đăng nhập thành công!');
        }

        return back()->withErrors(['error' => 'Tên đăng nhập hoặc mật khẩu không chính xác, vui lòng nhập lại']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:accounts',
            'password' => 'required|confirmed|min:5',
            'gender' => 'required|in:0,1',
            'phone' => 'nullable|numeric',
            'email' => 'required|email|unique:accounts',
            'birth_date' => 'required|date',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $account = new Account();
        $account->username = $request->username;
        $account->password = Hash::make($request->password);
        $account->gender = $request->gender;
        $account->phone = $request->phone ?? '';
        $account->email = $request->email;
        $account->birth_date = $request->birth_date;
        $account->address = $request->address;
        $account->save();

        return redirect()->route('login')->with('message', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất.');
    }

    // =============================================
    // Các phương thức API mới cho mobile
    // =============================================

    /**
     * Đăng nhập API (trả về JSON)
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'device_name' => 'required|string' // Cần cho Sanctum token
        ]);

        $user = Account::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác'
            ], 401);
        }

        // Tạo token Sanctum
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'is_admin' => $user->username === 'admin' // Thêm trường kiểm tra admin
            ]
        ]);
    }

    /**
     * Đăng ký API (trả về JSON)
     */
    public function apiRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:accounts',
            'password' => 'required|confirmed|min:5',
            'gender' => 'required|in:0,1',
            'phone' => 'nullable|numeric',
            'email' => 'required|email|unique:accounts',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'device_name' => 'required|string' // Cần cho Sanctum token
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $account = new Account();
        $account->username = $request->username;
        $account->password = Hash::make($request->password);
        $account->gender = $request->gender;
        $account->phone = $request->phone ?? '';
        $account->email = $request->email;
        $account->birth_date = $request->birth_date;
        $account->address = $request->address;
        $account->save();

        // Tạo token sau khi đăng ký
        $token = $account->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'username' => $account->username,
                'email' => $account->email
            ],
            'message' => 'Đăng ký thành công'
        ], 201);
    }

    /**
     * Đăng xuất API
     */
    public function apiLogout(Request $request)
    {
        // Xóa token hiện tại
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Đăng xuất thành công'
        ]);
    }
}