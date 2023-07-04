<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Redirect;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers; 
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
       return view('auth.register');    
    } 
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
                }else{
                    Auth::logout();
                   return redirect('/userLogin')->with('message',"Credentials doesn't match."); 
                }
            }else{
                return redirect()->back()->with('message',"Credentials doesn't match.");
            }
       }else{
          return view('auth.login'); 
       } 
          
    } 
}
