<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\User_ban;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Manager_setting;
use App\Models\User_manager_setting;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::where('role', 'staff')->paginate(10);
        return view('admin.staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'full_name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|regex:/^0\d{9,10}$/',
                'address' => 'nullable',
                'password' => 'required|string|min:6|confirmed',
            ],
            [
                'phone.regex' => 'Phone numbers start at 0 and have 10 or 11 digits'
            ]
        );

        User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'role' => 'staff',
        ]);

        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Thêm nhân viên thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staff = User::findOrFail($id);
        return view('admin.staffs.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = User::findOrFail($id);
        $request->validate(
            [
                'full_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($staff->id),
                ],
                'phone' => 'required|regex:/^0\d{9,10}$/',
                'address' => 'nullable',
            ],
            [
                'phone.regex' => 'Phone numbers start at 0 and have 10 or 11 digits'
            ]
        );

        $staff->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Cập nhật nhân viên thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Xóa nhân viên thành công.');
    }

    public function ban(Request $request, $id)
    {
        $staff = User::findOrFail($id);
        // Cập nhật tất cả các bản ghi trước đó của user thành is_active = 0 (không có hiệu lực)
        User_ban::where('user_id', $staff->id)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

        User_ban::create([
            'user_id' => $staff->id,
            'reason' => $request->input('reason'),
            'status' => 0, // 0: inactive (bị khóa)
            'is_active' => 1, //Hiệu lực
        ]);

        $staff->update(['status' => 'banned']);
        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Ban nhân viên thành công.');
    }

    public function unban($id)
    {
        $staff = User::findOrFail($id);

        User_ban::where('user_id', $staff->id)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

        User_ban::create([
            'user_id' => $staff->id,
            'reason' => 'Mở khóa tài khoản',
            'status' => 1, // 1: active (mở khóa)
            'is_active' => 1 //Hiệu lực
        ]);

        $staff->update(['status' => 'active']);

        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Tài khoản đã được mở.');
    }

    public function history($id)
    {
        $staff = User::findOrFail($id);
        $banHistory = User_ban::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.staffs.history', compact('staff', 'banHistory'));
    }

    public function permission(User $user){
        $allPermissions = Manager_setting::whereNull('parent_manager_setting_id')
        ->with('children_manager_setting')
        ->get(); // Lấy tất cả các quyền có sẵn
        $userPermissions = User_manager_setting::where('user_id', $user->id)
            ->where('is_active', 1) // Lấy các quyền đã cấp cho nhân viên
            ->pluck('manager_setting_id')
            ->toArray();
        return view('admin.staffs.permission', compact('user', 'allPermissions', 'userPermissions'));
    }

    public function togglePermission(Request $request, User $user, Manager_setting $managerSetting)
    {
        // Kiểm tra xem quyền đã được cấp chưa
        $userManagerSetting = User_manager_setting::where('user_id', $user->id)
            ->where('manager_setting_id', $managerSetting->id)
            ->first();

        if ($userManagerSetting) {
            // Nếu đã có bản ghi, thì chuyển đổi trạng thái
            $userManagerSetting->toggleActive();
        } else {
            // Nếu chưa có bản ghi, tạo mới với is_active = 1
            User_manager_setting::create([
                'user_id' => $user->id,
                'manager_setting_id' => $managerSetting->id,
                'is_active' => 1,
            ]);
        }

        return redirect()->back()->with('statusSuccess', 'Cập nhật phân quyền thành công!');
    }
}
