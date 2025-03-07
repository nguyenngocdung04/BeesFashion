<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Manager_setting;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // Nếu người dùng là admin, cho phép truy cập mà không cần kiểm tra quyền
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }
        // Lấy ID của chức năng quản lý từ bảng manager_settings dựa trên tên chức năng
        $managerSetting = Manager_setting::where('manager_name', $permission)->first();
        // Nếu không tìm thấy chức năng quản lý, trả về lỗi 403
        if (!$managerSetting) {
            abort(403, 'Chức năng quản lý không tồn tại.');
        }
        // Kiểm tra xem người dùng hiện tại có được cấp quyền quản lý chức năng này không
        $userHasPermission = Auth::user()->user_manager_settings()
            ->where('manager_setting_id', $managerSetting->id)
            ->where('is_active', 1) // Chỉ lấy những quyền đang active
            ->exists();

        if (!$userHasPermission) {
            return redirect()->route('admin.dashboard')->with(['statusError' => 'Bạn không có quyền truy cập chức năng này.']);
        }


        return $next($request);
    }
}
