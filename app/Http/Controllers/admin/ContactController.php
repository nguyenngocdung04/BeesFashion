<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index(){
        $contacts = Contact::orderBy('created_at','desc')->get();
        return view('admin.contacts.index', compact('contacts'));
    }
}
