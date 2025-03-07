<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Lấy danh sách role từ tham số
        $roles = explode('|', $roles);

        // Kiểm tra nếu người dùng đăng nhập và role của họ nằm trong danh sách role được phép
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }
        return redirect('/')->with('statusError', 'Bạn không có quyền truy cập vào chức năng này.');
    }
}
