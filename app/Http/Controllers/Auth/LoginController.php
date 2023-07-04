<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
   
    use AuthenticatesUsers;
                    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
   // protected $redirectTo = '/admin/home';
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {  

        $this->middleware('guest', ['except' => 'logout']);
    }

     public function login(Request $request){  

        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){
            if (auth()->user()->user_type == "A" || auth()->user()->user_type == "V") {
                Auth::logout();
                return redirect()->route('login')->with('message',"Invalid User Type.");
            }else{
                return redirect('/'); 
            }
        }else{
            return redirect()->back()->with('message',"Credentials doesn't match.");
        }
          
    }

    public function logout(Request $request) {
    if (Auth::user()) {
      if(Auth::user()->user_type == "A") {
          Auth::logout();
          return redirect('/admin/login');
        }elseif(Auth::user()->user_type == "V" || Auth::user()->user_type == "CH" || Auth::user()->user_type == "R") {
          Auth::logout();
          return redirect('/admin/login');
        }else{
          Auth::logout();
          return redirect('login');
        }
      }/*else{
          if($request->user_type == 'A'){
             return redirect('/admin/login');
          }elseif(Auth::user()->user_type == "V") {
              Auth::logout();
           return redirect('/admin/login');
          }else{
             return redirect('login');
          } 
          
      } */ 
      
    }


}
