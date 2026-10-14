<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Redirect;
use Auth;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function profileSetting(Request $request)
    {
        if($request->isMethod('post')){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required|numeric|digits:10'
        ]);
       if($validator->fails()){
           return redirect()->back()->with('errors', $validator->errors()->first());
         }
            $userdata = User::where('id',Auth::user()->id)->first();
            if($request->name){
                $userdata->name= $request->name;
            }
            if($request->mobile_number){
                $userdata->mobile_number= $request->mobile_number;
            }
           
            if($request->password){
                $userdata->password= bcrypt($request->password);
            }

            $userdata->save();
            return redirect()->back()->with('message','Great! User profile updated Successfully !');

        }else{
            $userdata = User::where('id',Auth::user()->id)->first();
            return view('Website.user.profile-setting',compact('userdata'));
        }
    }

    public function checkemail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
        
    public function handleGoogleCallback(Request $request){
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('social_id', $user->id)->where('social_type', 1)->first();
            if(!$finduser){
                // Fall back to a verified-email match so someone who already
                // registered with a password doesn't get a second, duplicate
                // account just by logging in with Google using that email.
                $finduser = $user->email ? User::where('email', $user->email)->first() : null;
                if($finduser){
                    $finduser->update([
                        'social_id' => $user->id,
                        'social_type' => 1,
                    ]);
                }
            }
            if($finduser){
                Auth::login($finduser);
                return redirect('/');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> 1, // social_type is an integer column: 1 = google, 2 = facebook
                    'user_type'=> 'C',
                    'password' => Hash::make(Str::random(32)),
                ]);
                Auth::login($newUser);
                return redirect('/');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
