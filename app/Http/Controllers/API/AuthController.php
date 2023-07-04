<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalTrait;
use App\Rules\MatchOldPassword;

class AuthController extends Controller
{
    use GlobalTrait;
    // SignUp
    public function register(Request $request){
      $validator = Validator::make($request->all(), [
          'email' => 'required|email|unique:users',
          'password' => 'required',
          'user_type' => 'required',
      ]);
      if($validator->fails()){ 
          return response()->json(['status' => false,'message' => $validator->errors()->first(),'data'=>null],409);  
      }
      $user = new User;
      $user->user_type =  $request->user_type;
      $user->password =  Hash::make($request->password);
      $user->email =  $request->email;
      $user->mobile_number =  $request->mobile_no;
      $user->status =  1;
      $user->save(); 
      $data['token'] =  $user->createToken('AfriDish')->accessToken;
      // $data['email'] =  Auth::user()->email;
      // $data['user_type'] =  strval(Auth::user()->user_type);
      return response()->json(['status' => true,'message'=>'User register successfully.', 'data' => $data]);
    }
    // Login
    public function login(Request $request){
       $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required',
      ]);
      if($validator->fails()){ 
          return response()->json(['status' => false,'message' => $validator->errors()->first(),'data'=>null],409);  
      }
      if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
          $data['token'] =  Auth::user()->createToken('AfriDish')->accessToken; 
          $data['email'] =  Auth::user()->email;
          $data['user_type'] =  strval(Auth::user()->user_type);
          return response()->json(['status' => true,'message'=>'User login successfully.', 'data' => $data]);
        }else{ 
          return response()->json(['status' => false,'message'=>'Please enter valid credentials.', 'data' => null],409);
        } 
    }


   public function socialLogin(Request $request){
        $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'social_id' => 'required',
          'social_type' => 'required',
          'user_type' => 'required',
          ]);
        if($validator->fails()){ 
            return response()->json(['status' => false,'message' => $validator->errors()->first(),'data'=>null],409);  
        }
        $user = User::where(['social_id' => $request->social_id])->first();
        $social_status = "";
          if($user){
             if($user->social_id){
               $social_status = 1;
             }else{
               $social_status = 0;
             }
              $user->update([
                  'social_id' => $request->social_id,  
                  'social_type' => $request->social_type,
                  'user_type' => $request->user_type,
              ]);
              $msg = "User login successfully.";
              $user['user_type'] = strval($user->user_type);
          }else{ 
            $social_status = 0;
            $msg = "User login successfully.";
            $user = User::where(['email' => $request->email])->first();
            if($user){}else{
            $user = User::create([
                'email' => $request->email,
                'social_id' => $request->social_id,
                'social_type' => $request->social_type,
                'user_type' => $request->user_type,
            ]);
           }
          }
          $userdata['id'] = $user->id;
          $userdata['email'] = $user->email;
          $userdata['social_id'] = $user->social_id;
          $userdata['social_status'] = $social_status;
          $userdata['token'] = $user->createToken('puffie')->accessToken;
        return response()->json(['status' => true,'message'=>$msg, 'data' => $userdata]);
    }

    
}
