<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\User_ban;
use Illuminate\Http\Request;
use App\Events\UserBannedEvent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::where('role', 'member')
            ->withCount(['orders as successful_orders_count' => function ($query) {
                $query->whereHas('status_orders', function ($subQuery) {
                    $subQuery->where('status_id', 4); // Đếm chỉ những đơn hàng có status_id = 4
                });
            }])
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }


    public function test()
    {
        $customers = User::where('role', 'member')
            ->withCount(['orders as successful_orders_count' => function ($query) {
                $query->whereHas('status_orders', function ($subQuery) {
                    $subQuery->where('status_id', 4); // Đếm chỉ những đơn hàng có status_id = 4
                });
            }])
            ->with('user_bans') // Lấy trạng thái cấm mới nhất
            ->paginate(10);
        return response()->json([
            'customers' => $customers, // Dữ liệu thuộc tính của các biến thể
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $customer = User::with('user_shipping_addresses')->findOrFail($id);
        // return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        $request->validate(
            [
                'full_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($customer->id),
                ],
                'phone' => 'required|regex:/^0\d{9,10}$/',
                'address' => 'nullable',
            ],
            [
                'phone.regex' => 'Phone numbers start at 0 and have 10 or 11 digits'
            ]
        );

        $customer->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route('admin.customers.index')->with('statusSuccess', 'Cập nhật khách hàng thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = User::findOrFail($id);
        // Kiểm tra xem người dùng có địa chỉ giao hàng không
        if ($customer->user_shipping_addresses()->exists()) {
            // Nếu người dùng có địa chỉ giao hàng thì không cho phép xoá
            return back()->with('statusError', 'Bạn phải xoá địa chỉ ship trước khi xoá khách hàng.');
        }
        $customer->delete();
        return back()->with('statusSuccess', 'Xoá khách hàng thành công');
    }
    public function ban(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        // Cập nhật tất cả các bản ghi trước đó của user thành is_active = 0 (không có hiệu lực)
        User_ban::where('user_id', $customer->id)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

            $banRecord = User_ban::create([
            'user_id' => $customer->id,
            'reason' => $request->input('reason'),
            'status' => 0, // 0: inactive (bị khóa)
            'is_active' => 1, //Hiệu lực
        ]);
        $customer->update(['status' => 'banned']);

        broadcast(new UserBannedEvent($customer->id, $request->input('reason')))->toOthers();
        return redirect()->route('admin.customers.index')->with('statusSuccess', 'Khóa khách hàng thành công.');
    }

    public function unban($id)
    {
        $customer = User::findOrFail($id);

        User_ban::where('user_id', $customer->id)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

        User_ban::create([
            'user_id' => $customer->id,
            'reason' => 'Mở khóa tài khoản',
            'status' => 1, // 1: active (mở khóa)
            'is_active' => 1 //Hiệu lực
        ]);

        $customer->update(['status' => 'active']);

        return redirect()->route('admin.customers.index')->with('statusSuccess', 'Mở khóa khách hàng thành công.');
    }
    public function history($id)
    {
        $customerID = User::findOrFail($id);
        $banHistory = User_ban::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.customers.history', compact('customerID', 'banHistory'));
    }
}
