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

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Lấy thông tin đăng nhập
        $credentials = $request->only('username', 'password');

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra nếu là tài khoản admin
            if ($user->username === 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Đăng nhập thành công với tài khoản admin!');
            }

            // Nếu là người dùng bình thường
            return view('auth.dashboard')->with('message', 'Đăng nhập thành công!');
        }

        return back()->withErrors(['error' => 'Tên đăng nhập hoặc mật khẩu không chính xác, vui lòng nhập lại']);
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate dữ liệu nhập vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:accounts',  // Kiểm tra tài khoản đã tồn tại
            'password' => 'required|confirmed|min:5',  // Kiểm tra mật khẩu và xác nhận
            'gender' => 'required|in:0,1',  // Đảm bảo gender là 0 hoặc 1
            'phone' => 'nullable|numeric',  // Kiểm tra nếu có số điện thoại thì phải là số
            'email' => 'required|email|unique:accounts',  // Kiểm tra email đã tồn tại
            'birth_date' => 'required|date',
            'address' => 'required|string',
        ]);

        // Nếu validation thất bại, quay lại và hiển thị lỗi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tạo tài khoản mới
        $account = new Account();  // Sử dụng mô hình Account
        $account->username = $request->username;
        $account->password = Hash::make($request->password);  // Mã hóa mật khẩu trước khi lưu
        $account->gender = $request->gender;
        $account->phone = $request->phone ?? '';  // Nếu không có số điện thoại, lưu là rỗng
        $account->email = $request->email;
        $account->birth_date = $request->birth_date;
        $account->address = $request->address;
        $account->save();  // Lưu người dùng vào cơ sở dữ liệu

        // Quay lại với thông báo thành công
        return redirect()->route('login')->with('message', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất.');
    }
}
