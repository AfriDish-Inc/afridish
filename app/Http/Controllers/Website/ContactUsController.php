<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Mail\ContactUsEmail;
use Illuminate\Support\Str;
use Mail;


class ContactUsController extends Controller
{
    public function index(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
              'full_name' => 'required',
              'user_query' => 'required',
              'email' => 'required|email',
            ]);
            if($validator->fails()){ 
               return redirect()->back()->withInput($request->all())->with('errors', $validator->errors()->first()); 
            }
            $contactus =  ContactUs::firstOrNew(['email' =>  $request->email]);
            $contactus->full_name = $request->full_name;
            $contactus->email = $request->email;
            $contactus->user_query = $request->user_query;
            $contactus->save();
            $data= [
             'email' => $request->email,
            ];
            Mail::to($request->email)->send(new ContactUsEmail($data));
            return redirect()->back()->with('message',"Thanks for connecting us");
        }else{
            return view('Website.contact-us');
        }
     } 


    public function aboutUs(Request $request)
    {
        return view('Website.about-us');
    }

    public function privacy(Request $request)
    {
        return view('Website.privacy-policy');
    }

    public function terms(Request $request)
    {
        return view('Website.term');
    }

     public function businesses(Request $request)
    {
        return view('Website.businesses');
    }      

    public function learn(Request $request)
    {
        return view('Website.learn');
    } 

    public function branch(Request $request)
    {
        return view('Website.branch');
    } 
} 
