<?php

namespace App\Http\Controllers\Auth;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // Sửa tài khoản
    public function edit($id)
    {
        $account = Account::find($id);
        return view('auth.user_edit', compact('account'));
    }

    // Cập nhật tài khoản
    public function update_user(Request $request, $id)
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

        return redirect()->route('user.edit', ['id' => $account->id])->with('success', 'Account updated successfully');
    }


    // Xóa tài khoản
    public function destroy($id)
    {
        $account = Account::find($id);
        $account->delete();
        return redirect()->route('user.edit')->with('success', 'Account deleted successfully');
    }
}
