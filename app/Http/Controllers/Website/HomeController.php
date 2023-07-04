<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
     public function index(Request $request)
     {  if(auth()->user()){
           if(auth()->user()->user_type == "C"){
              $brands = Brand::paginate(10);
              $categories = Category::where('is_active',1)->paginate(10);
              if($request->search){
                $vendors = User::where('name','LIKE', "%$request->search%")->where('user_type','V')->paginate(10);
                return view('Website.vendors.index',compact(['brands','categories','vendors']));
              }

              if($request->latitude && $request->longitude){
                
                $vendors = User::selectRaw("*,
                         ( 6371 * acos( cos( radians(?) ) *
                         cos( radians( latitude ) )
                         * cos( radians( longitude ) - radians(?)
                         ) + sin( radians(?) ) *
                         sin( radians( latitude ) ) )
                         ) AS distance", [$request->latitude, $request->longitude, $request->latitude])->where('user_type', '=', "V")->having('distance', '<=', 10)->get();             
                return view('Website.vendors.index',compact(['brands','categories','vendors']));
              }

              $testimonials = Testimonial::paginate(10);
            //  $value = $request->cookie('name');
            // if(empty($value)){
            //     return view('Website.common.age');
            // }else{
                return view('Website.index',compact(['brands','categories','testimonials']));
           // }
             // return view('Website.index',compact(['brands','categories','testimonials']));
           }else{
              Auth::logout();
              return redirect('/');
           }
        }else{
           $brands = Brand::paginate(10);
           $categories = Category::where('is_active',1)->paginate(10);
           if($request->search){
                $vendors = User::where('name','LIKE', "%$request->search%")->where('user_type','V')->paginate(10);
                return view('Website.vendors.index',compact(['brands','categories','vendors']));
              }
              if($request->latitude && $request->longitude){
                
                $vendors = User::selectRaw("*,
                         ( 6371 * acos( cos( radians(?) ) *
                         cos( radians( latitude ) )
                         * cos( radians( longitude ) - radians(?)
                         ) + sin( radians(?) ) *
                         sin( radians( latitude ) ) )
                         ) AS distance", [$request->latitude, $request->longitude, $request->latitude])->where('user_type', '=', "V")->having('distance', '<=', 10)->get();           
                return view('Website.vendors.index',compact(['brands','categories','vendors']));
              }
            $testimonials = Testimonial::paginate(10);
            // $value = $request->cookie('name');
            // if(empty($value)){
            //     return view('Website.common.age');
            // }else{
                return view('Website.index',compact(['brands','categories','testimonials']));
          //  }
           
        }
     }


    public function storeCache(Request $request)
    {
        if ($request->age_verify == 1) {
          $minutes = 1440;
          //$response = new Response('Set Cookie');
          Cookie::queue('name', 'value', $minutes);
             return redirect('/');
        }else{
           return view('Website.common.age'); 
        }
    }

     public function userRegister(Request $request)
     {
       if($request->isMethod('post')){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6',
            'date_of_birth' =>'required|date|before:'.Carbon::now()->subYears(18),
            'mobile_number' => 'required|numeric|digits:10'
        ]);
         if($validator->fails()){ 
           return redirect('/register')->withInput()->with('message', $validator->errors()->first()); 
         }
 
        if($this->checkemail($request->email)){
         User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'mobile_number' => $request->mobile_number,
            'user_type' => "C",
            'country_id' => "+234",
            'dob' => $request->date_of_birth,
        ]);
        }else{
            return redirect('/register')->withInput()->with('message', 'Please enter valid email !');
        }
         return redirect('login');
      }else{
         return view('auth.register');
      }
     }

     public function checkemail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
}
