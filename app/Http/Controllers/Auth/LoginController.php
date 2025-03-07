<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\User_ban;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index()
    {
        return view('user.auth.login');
    }
    // Chuyển hướng đến Google
    public function redirectToGoogle()
    {
        // dd(Socialite::driver('google')->redirect());

        return Socialite::driver('google')->redirect();
    }
    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            // Tìm người dùng qua email
            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user) {
                // Kiểm tra trạng thái tài khoản
                if ($user->status === 'banned') {
                    // Tìm lý do và thời gian ban
                    $bannedUser = User_ban::where('user_id', $user->id)
                        ->where('is_active', 1) // Kiểm tra trạng thái ban
                        ->first();
                    $reason = $bannedUser ? 'Lý do: ' . $bannedUser->reason : 'Không có lý do cụ thể.';
                    return redirect()->route('login')->with('statusError', 'Tài khoản của bạn đã bị khóa! ' . $reason);
                }
            }
            // Nếu tài khoản không tồn tại, tạo mới
            $user = User::createOrFirst(
                ['email' => $googleUser->getEmail()],
                [
                    'full_name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('123456'),
                ]
            );

            // Nếu tài khoản đã tồn tại nhưng chưa có google_id, cập nhật thêm
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            Auth::login($user, true);

            return redirect('/')->with('statusSuccess', 'Đăng nhập thành công! Chào mừng bạn đến với BeesFashion.');
        } catch (\Exception $e) {
            // Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('login')->with('statusError', 'Có lỗi xảy ra khi đăng nhập qua Google. Vui lòng thử lại sau.');
        }
    }

    public function login(Request $request)
    {
        // Kiểm tra xem người dùng nhập username hay email
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = $request->validate([
            'login' => [
                'required',
                'string',
                'max:100',
                'regex:/^\S+$/', // Không cho phép khoảng trắng (cả đầu, giữa và cuối)
                $fieldType === 'email' ? 'email' : 'string',
            ],
            'password' => [
                'required',
                'string',
                'min:6', // Mật khẩu phải có ít nhất 6 ký tự
                'regex:/^\S+$/', // Không cho phép khoảng trắng trong mật khẩu
            ],
        ], [
            'login.required' => 'Vui lòng nhập tên người dùng hoặc email!',
            'login.string' => 'Tên người dùng hoặc email phải là chuỗi ký tự hợp lệ!',
            'login.max' => 'Tên người dùng hoặc email không được vượt quá 100 ký tự!',
            'login.regex' => 'Tên người dùng hoặc email không được chứa khoảng trắng!',
            'login.email' => 'Email không đúng định dạng!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng!',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']], $remember)) {
            // Đăng nhập thành công
            $request->session()->regenerate();

            // Kiểm tra trạng thái tài khoản có bị banned không
            if (Auth::user()->status === 'banned') {
                // Tìm lý do và thời gian ban
                $bannedUser = User_ban::where('user_id', Auth::id())
                    ->where('is_active', 1) // Kiểm tra trạng thái ban
                    ->first();
                $reason = $bannedUser ? 'Lý do: ' . $bannedUser->reason : 'Không có lý do cụ thể.';
                Auth::logout(); // Đăng xuất người dùng
                return redirect()->back()->withErrors([
                    'login' => 'Tài khoản của bạn đã bị khóa! ' . $reason,
                ])->withInput();
            }

            // Kiểm tra vai trò của người dùng
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
                // Điều hướng đến trang quản trị nếu là admin hoặc staff
                session()->flash('statusSuccess', 'Đăng nhập thành công! Chào mừng bạn đến với trang quản trị.');
                return redirect()->intended('/admin');
            } else {
                // Điều hướng đến trang người dùng nếu là member
                session()->flash('statusSuccess', 'Đăng nhập thành công! Chào mừng bạn đến với BeesFashion.');
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'login' => 'Thông tin đăng nhập không chính xác!',
        ])->onlyInput('login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('statusSuccess', 'Đăng xuất thành công!');
    }
}
