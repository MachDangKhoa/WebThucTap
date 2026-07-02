<?php

namespace App\Http\Controllers\Auth;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    // Hiển thị danh sách tất cả tài khoản
    public function index()
    {
        $accounts = Account::all();
        if (auth()->check() && auth()->user()->username === 'admin') {
            return view('accounts.index', compact('accounts'));
        }
        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập trang admin.']);
    }

    // Sửa tài khoản
    public function edit($id)
    {
        $account = Account::find($id);
        if (auth()->check() && auth()->user()->username === 'admin') {
            return view('accounts.edit', compact('account'));
        }
        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập trang admin.']);
    }

    // Cập nhật tài khoản
    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        // Cập nhật thông tin tài khoản
        $account->username = $request->input('username');
        $account->email = $request->input('email');
        $account->phone = $request->input('phone');
        $account->birth_date = $request->input('birth_date');
        $account->address = $request->input('address');
        $account->gender = $request->input('gender');

        // Nếu có mật khẩu mới, cập nhật mật khẩu (đã được mã hóa)
        if ($request->has('password') && !empty($request->password)) {
            $account->password = bcrypt($request->input('password'));
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $account->save();

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully');
    }


    // Xóa tài khoản
    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return redirect()->route('accounts.index')->with('error', 'Account not found');
        }

        if ($account->username === 'admin') {
            return redirect()->route('accounts.index')->with('error', 'Cannot delete admin account');
        }

        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully');
    }

}
