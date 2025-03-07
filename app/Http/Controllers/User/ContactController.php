<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.contact');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $data = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u', // Chỉ cho phép chữ cái và khoảng trắng
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'regex:/^0\d{9,10}$/', // Số điện thoại bắt đầu bằng 0 và có 10 hoặc 11 chữ số
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ], [
            'full_name.required' => 'Họ và tên là bắt buộc.',
            'full_name.string' => 'Họ và tên phải là chuỗi ký tự.',
            'full_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'full_name.regex' => 'Họ và tên không được chứa số hoặc ký tự đặc biệt.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có độ dài 10 hoặc 11 chữ số.',

            'subject.required' => 'Tiêu đề là bắt buộc.',
            'subject.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'subject.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'message.required' => 'Nội dung là bắt buộc.',
            'message.string' => 'Nội dung phải là chuỗi ký tự.',
            'message.min' => 'Nội dung phải có ít nhất 10 ký tự.',
            'message.max' => 'Nội dung không được vượt quá 2000 ký tự.',
        ]);
        Contact::create($data);

        return redirect()->back()->with('statusSuccess', 'Tin nhắn của bạn đã được gửi thành công!');
    }
}
