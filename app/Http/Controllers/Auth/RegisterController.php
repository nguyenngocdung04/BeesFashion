<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Category;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function index()
    {
        //View trang đăng ký
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        //Xử lý logic đăng ký
        $data = $request->validate([
            'username' => [
                'required',
                'string',
                'unique:users,username',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/', // Chỉ cho phép chữ cái, số và dấu gạch dưới
            ],
            'email' => [
                'required',
                'string',
                'email',
                'unique:users,email',
                'max:100',
            ],
            'password' => [
                'required',
                'string',
                'min:6', // Yêu cầu tối thiểu 6 ký tự
                'max:50', // Giới hạn tối đa 50 ký tự
                'confirmed', // Yêu cầu nhập lại mật khẩu khớp
                'regex:/^\S+$/',
            ],
        ], [
            'username.required' => 'Tên người dùng không được để trống!',
            'username.string' => 'Tên người dùng phải là chuỗi ký tự!',
            'username.unique' => 'Tên người dùng đã tồn tại!',
            'username.max' => 'Tên người dùng không được vượt quá 50 ký tự!',
            'username.regex' => 'Tên người dùng chỉ được chứa chữ cái, số và dấu gạch dưới!',

            'email.required' => 'Email không được để trống!',
            'email.string' => 'Email phải là chuỗi ký tự!',
            'email.email' => 'Email không đúng định dạng!',
            'email.unique' => 'Email đã tồn tại!',
            'email.max' => 'Email không được vượt quá 100 ký tự!',

            'password.required' => 'Mật khẩu không được để trống!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'password.max' => 'Mật khẩu không được vượt quá 50 ký tự!',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp!',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng!',
        ]);

        // Lưu thông tin vào session tạm thời
        $request->session()->put('registration_data', $data);
        // Tạo token xác thực
        $token = base64_encode(json_encode([
            'email' => $data['email'],
            'timestamp' => now()->timestamp,
        ]));
        // Gửi email xác thực
        Mail::to($data['email'])->send(new VerifyEmail($token, $data['email']));

        // Thông báo và yêu cầu xác thực email
        session()->flash('statusSuccess', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
        return redirect()->route('login');
    }

    public function verify($token)
    {
        // Giải mã token
        $decodedToken = json_decode(base64_decode($token), true);
        // Kiểm tra token hợp lệ
        if (!$decodedToken || !isset($decodedToken['email'], $decodedToken['timestamp'])) {
            return redirect()->route('register')->with('statusError', 'Liên kết xác thực không hợp lệ. Vui lòng đăng ký lại.');
        }
        // Kiểm tra thời gian xác thực
        if (now()->timestamp - $decodedToken['timestamp'] > 86400) {
            return redirect()->route('register')->with('statusError', 'Liên kết xác thực của bạn đã hết hạn sau 24 giờ. Vui lòng đăng ký lại.');
        }
        // Lấy thông tin từ session
        $registrationData = session('registration_data');
        // Kiểm tra thông tin trong session
        if (!$registrationData || $registrationData['email'] !== $decodedToken['email']) {
            return redirect()->route('register')->with('statusError', 'Thông tin xác thực không khớp. Vui lòng đăng ký lại.');
        }
        // Lưu thông tin vào database
        $user = User::create([
            'username' => $registrationData['username'],
            'email' => $registrationData['email'],
            'password' => $registrationData['password'],
            'email_verified_at' => now(),
        ]);
        // Xóa thông tin trong session
        session()->forget('registration_data');
        // Tự động đăng nhập sau xác thực
        Auth::login($user);
        // Gen lại token cho session
        session()->regenerate();

        return redirect('/')->with('statusSuccess', 'Xác thực email thành công! Chào mừng bạn đến với BeesFashion.');
    }
}
