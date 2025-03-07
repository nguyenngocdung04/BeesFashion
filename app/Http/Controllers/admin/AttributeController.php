<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_type;
use App\Models\Attribute_value;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Controllers\Controller;
use League\CommonMark\Extension\Attributes\Node\Attributes;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.attributes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listAttributeTypes = Attribute_type::query()->get();
        $listAttribute = Attribute::query()->get();
        $attributeIds = Attribute_value::whereNotNull('attribute_id')->pluck('id');

        // dd($listAttribute);

        // $type_name = $listAttributeTypes->type_name;

        return view('admin.attributes.create', compact('listAttributeTypes', 'listAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            Attribute::create($params);
            return redirect()->route('admin.attributes.create')->with('statusSuccess', 'Thêm loại thuộc tính thành công');
        }
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
        //
        $AttributesID = Attribute::query()->findOrFail($id);
        $attribute_type = Attribute_type::where('id', $AttributesID->attribute_type_id)->first();
        if ($attribute_type) {
            $type_name = $attribute_type->type_name;
        } else {
            $type_name = '';
        }
        $listAttributeTypes = Attribute_type::query()->get();
        $listAttribute = Attribute::query()->get();
        return view('admin.attributes.edit', compact('listAttribute', 'AttributesID', 'type_name', 'attribute_type', 'listAttributeTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $AttributesID = Attribute::findOrFail($id);
            // dd($AttributesID);
            $AttributesID->update($params);
            return redirect()->route('admin.attributes.create')->with('statusSuccess', 'chỉnh sửa loại thuộc tính thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $attribute = Attribute::findOrFail($id);

        // Kiểm tra xem Attribute có liên kết với bất kỳ Attribute_value nào không
        if ($attribute->attribute_values()->exists()) {
            // Nếu có giá trị thuộc tính liên kết, không cho phép xóa
            return redirect()->back()->with('statusError', 'Không thể xóa thuộc tính vì vẫn còn giá trị thuộc tính liên kết!');
        }

        // Nếu không có giá trị thuộc tính liên kết, tiến hành xóa
        $attribute->delete();

        return redirect()->route('admin.attributes.create')->with('statusSuccess', 'Xóa thuộc tính thành công!');
    }
}
