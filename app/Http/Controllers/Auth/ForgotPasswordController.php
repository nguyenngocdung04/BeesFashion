<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function ForgotForm()
    {
        return view('user.auth.forget-password');
    }

    // Xử lý yêu cầu reset mật khẩu
    public function resetPassword(Request $request)
    {
        // Xác thực đầu vào
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email!',
            'email.email' => 'Email không hợp lệ!',
            'email.exists' => 'Email của bạn không tồn tại!',
        ]);

        // Tìm người dùng theo email
        $user = User::where('email', $request->email)->first();

        // Tạo mật khẩu mới ngẫu nhiên
        $newPassword = rand(100000, 999999);

        // Mã hóa mật khẩu mới trước khi lưu vào database
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // Gửi mail mật khẩu mới cho người dùng
        try {
            Mail::to($user->email)->send(new ForgotPassword($newPassword, $user->email));
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Không thể gửi email! Vui lòng thử lại sau.'], 500);
        }
    }
}
