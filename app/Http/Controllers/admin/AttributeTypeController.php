<?php

namespace App\Http\Controllers\admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_type;
use App\Http\Requests\StoreAttribute_typeRequest;
use App\Http\Controllers\Controller;

class AttributeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.attribute_types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $listAttributeTypes = Attribute_type::query()->get();
        return view('admin.attribute_types.create', compact('listAttributeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttribute_typeRequest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            Attribute_type::create($params);
            return redirect()->route('admin.attribute_types.create')->with('success', 'Thêm loại thuộc tính thành công');
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
        $listAttributeTypes = Attribute_type::query()->get();
        $AttributeTypes = Attribute_type::query()->findOrFail($id);
        return view('admin.attribute_types.edit', compact('AttributeTypes', 'listAttributeTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAttribute_typeRequest $request, string $id)
    {
        //
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $AttributeTypes = Attribute_type::findOrFail($id);
            $AttributeTypes->update($params);
            return redirect()->route('admin.attribute_types.create')->with('success', 'Thêm loại thuộc tính thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $AttributeTypes = AttributeType::findOrFail($id);
        // $AttributeTypes->attributes()->delete();
        // $AttributeTypes->delete();

        $AttributeTypes = Attribute_type::findOrFail($id);
        // Kiểm tra xem AttributeType có liên kết với bất kỳ Attribute nào không
        if ($AttributeTypes->attributes()->exists()) {
            // Nếu có thuộc tính liên kết, không cho phép xóa
            return redirect()->back()->with('statusError', 'Không thể xóa loại thuộc tính vì vẫn còn thuộc tính liên kết!');
        }
        // Nếu không có thuộc tính liên kết, tiến hành xóa
        $AttributeTypes->delete();
        return redirect()->route('admin.attribute_types.create')->with('statusSuccess', 'Xóa loại thuộc tính thành côngs!');
    }
}
