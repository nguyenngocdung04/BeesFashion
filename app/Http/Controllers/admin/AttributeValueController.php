<?php

namespace App\Http\Controllers\admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_type;
use App\Models\Attribute_value;
use App\Http\Requests\Attribute_valueRequest;
use App\Http\Controllers\Controller;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả các attributes kèm theo các giá trị của chúng
        $listAttributes = Attribute::with('values')->get(); // Eager loading để giảm số truy vấn

        return view('admin.attribute_values.index', compact('listAttributes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $listAttribute = Attribute::query()->get();
        // $AttributesTypeID = AttributeType::query()->findOrFail($id);
        $listAttributeValue = Attribute_value::query()->get();
        return view('admin.attribute_values.show', compact('listAttributeValue', 'listAttribute'));
    }


    public function store(Attribute_valueRequest $request)
    {
        // Lấy dữ liệu từ request
        $attribute = Attribute::find($request->attribute_id);

        if ($attribute) {
            $query = Attribute_value::where('attribute_id', $request->attribute_id);

            // Kiểm tra nếu loại thuộc tính là 'color' thì tìm theo 'value', ngược lại tìm theo 'name'
            if ($attribute->attribute_type->type_name == 'color') {
                $existingAttributeValue = $query->where('value', $request->value)->first();
            } else {
                $existingAttributeValue = $query->where('name', $request->value)->first();
            }
        }


        $params = $request->except('_token');
        // Kiểm tra xem đã tồn tại giá trị nào có cùng attribute_id và value hay chưa



        // Nếu đã tồn tại, trả về thông báo lỗi
        if ($existingAttributeValue) {
            return redirect()->back()->withErrors(['statusError' => 'Giá trị này đã tồn tại cho thuộc tính này.']);
        }

        // Nếu không trùng lặp, tạo mới attribute_value
        Attribute_value::create($params);

        // Chuyển hướng sau khi tạo thành công
        return redirect()->route('admin.attribute_values.show', $request->input('attribute_id'))->with('statusSuccess', 'Thêm mới thành công  !');

        // return redirect()->route('admin.attribute_values.create')->with('success', 'Thêm giá trị thuộc tính thành công');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lấy attribute và các giá trị liên quan từ bảng attribute_values
        $attribute = Attribute::findOrFail($id); // Tìm attribute theo ID
        $attribute_type = Attribute_type::where('id', $attribute->attribute_type_id)->first();
        $type_name = $attribute_type ->type_name ;
        // dd($type_name);
        // $values = $attribute->values; // Lấy tất cả các giá trị (attribute_values) của thuộc tính
        return view('admin.attribute_values.show', compact('attribute', 'type_name'))->with('statusError', 'Không tìm thấy sản phẩm cần vô hiệu hóa!');;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listAttributeValue = Attribute_value::query()->get();
        $attribute_value = Attribute_value::find($id);
        $attribute = Attribute::find($attribute_value->attribute_id);
        $attribute_type = Attribute_type::where('id', $attribute->attribute_type_id)->first();
        $type_name = $attribute_type->type_name;
        return view('admin.attribute_values.edit', compact('attribute_value', 'type_name', 'attribute', 'attribute_type', 'listAttributeValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $attribute_value = Attribute_value::findOrFail($id);
            // dd($attribute_value);
            $attribute_value->update($params);
            $attribute_id = $attribute_value->attribute_id;
            return redirect()->route('admin.attribute_values.show', $attribute_id)
                ->with('statusSuccess', 'Cập nhật giá trị thuộc tính thành công!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute_valueID = Attribute_value::findOrFail($id);
        $attribute_valueID->delete();
        return redirect()->back()->with('statusSuccess', 'Xóa giá trị thuộc tính thành công!');
    }
}
