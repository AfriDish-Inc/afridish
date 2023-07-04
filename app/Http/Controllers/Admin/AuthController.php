<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\User;
use App\Models\VendorCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;


class AuthController extends Controller
{

   public function login(Request $request){  
       if($request->isMethod('post')){
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){

            if (auth()->user()->user_type == "A") {
                return redirect()->route('admin.home');
            }elseif(auth()->user()->user_type == "V"){
                return redirect()->route('vendor.home');
            }elseif(auth()->user()->user_type == "CH"){
                return redirect()->route('vendor.home');
            }elseif(auth()->user()->user_type == "R"){
                return redirect()->route('vendor.home');
            }else{
                Auth::logout();
               return redirect('/admin/login')->with('message',"Credentials doesn't match."); 
            }
        }else{
            return redirect()->back()->with('message',"Credentials doesn't match.");
        }
      }else{
         return view('admin.login');
      }
          
   }


   public function registerVendor(Request $request)
   {
     if($request->isMethod('post')){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
           // 'vendor_type' => 'required',
            'user_type' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6',
            'date_of_birth' =>'required|date|before:'.Carbon::now()->subYears(18),
            'mobile_number' => 'required|numeric|digits:10'
        ]);
         if($validator->fails()){ 
           return redirect('/vendor/signup')->withInput()->with('message', $validator->errors()->first()); 
         }
 
        if($this->checkemail($request->email)){
         User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'mobile_number' => $request->mobile_number,
            'user_type' => $request->user_type,
            'address' => $request->address,
            'latitude' => $request->lat,
            'longitude' => $request->lon,
           // 'vendor_category_id' => $request->vendor_type,
            'country_id' => "+234",
            'dob' => $request->date_of_birth,
        ]);
        }else{
            return redirect('/vendor/signup')->withInput()->with('message', 'Please enter valid email !');
        }
         return redirect('admin/login')->with('message' , "Register Successfully");
      }else{
          $vendorCategories = VendorCategory::get();
          return view('auth.vendor-signup',compact('vendorCategories')); 
      } 
   }

   public function checkemail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
}
 