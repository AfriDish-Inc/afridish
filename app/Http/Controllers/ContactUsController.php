<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $contactus = ContactUs::paginate(10);
        return view('admin.contact-us.index',compact('contactus'));
    }
}
