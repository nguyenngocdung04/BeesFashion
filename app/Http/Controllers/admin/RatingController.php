<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_vote;

class RatingController extends Controller
{
    public function index()
    {
        $votes = Product_vote::with('product_variant.product', 'order_detail', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ratings.index', compact('votes'));
    }

    public function toggleVisibility($id)
    {
        $vote = Product_vote::findOrFail($id);
        $vote->is_active = $vote->is_active == 1 ? 0 : 1;
        $vote->save();

        return redirect()->route('admin.ratings.index')->with('statusSuccess', 'Cập nhật trạng thái thành công');
    }
}
