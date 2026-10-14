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
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use GlobalTrait;
    // SignUp
    public function register(Request $request){
      $validator = Validator::make($request->all(), [
          'email' => 'required|email|unique:users',
          'password' => 'required',
      ]);
      if($validator->fails()){
          return response()->json(['status' => false,'message' => $validator->errors()->first(),'data'=>null],409);
      }
      $user = new User;
      // Always "C" (customer), never trust a client-submitted user_type here -
      // this endpoint is unauthenticated, so accepting it let anyone register
      // as user_type=A and log into the real admin panel with the password
      // they just set (same users table, same guard, no separate API scope).
      $user->user_type =  'C';
      $user->password =  Hash::make($request->password);
      $user->email =  $request->email;
      $user->mobile_number =  $request->mobile_number;
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
          'access_token' => 'required',
          'social_type' => 'required|in:google,facebook',
          ]);
        if($validator->fails()){
            return response()->json(['status' => false,'message' => $validator->errors()->first(),'data'=>null],409);
        }

        // Verify the token server-side with the provider instead of trusting
        // client-submitted email/social_id - previously any caller could
        // claim to "be" any email/social_id with no proof, which is a full
        // account takeover (and, via user_type, a privilege escalation) on
        // whichever account those values matched.
        try {
            $socialUser = Socialite::driver($request->social_type)->stateless()->userFromToken($request->access_token);
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => 'Invalid or expired social access token.','data'=>null],401);
        }

        $socialTypeCode = $request->social_type === 'google' ? 1 : 2; // matches social_type column comment

        $user = User::where('social_id', $socialUser->getId())
            ->where('social_type', $socialTypeCode)
            ->first();
        $social_status = $user ? 1 : 0;

        if(!$user){
            // Fall back to the provider-verified email so a user who already
            // has a password account doesn't end up with a duplicate one.
            $user = $socialUser->getEmail() ? User::where('email', $socialUser->getEmail())->first() : null;

            if($user){
                $user->update([
                    'social_id' => $socialUser->getId(),
                    'social_type' => $socialTypeCode,
                ]);
            }else{
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'social_id' => $socialUser->getId(),
                    'social_type' => $socialTypeCode,
                    // Always "C" - same reasoning as register(): user_type
                    // must never come from unauthenticated client input.
                    'user_type' => 'C',
                    'status' => 1,
                    'password' => Hash::make(Str::random(32)),
                ]);
            }
        }
        // user_type is intentionally never written here for an existing
        // match - previously a resubmitted social-login could flip ANY
        // matched account (including one belonging to someone else, once
        // its social_id was known or guessed) to user_type=A.

        $userdata['id'] = $user->id;
        $userdata['email'] = $user->email;
        $userdata['social_id'] = $user->social_id;
        $userdata['social_status'] = $social_status;
        $userdata['token'] = $user->createToken('AfriDish')->accessToken;
        return response()->json(['status' => true,'message'=>'User login successfully.', 'data' => $userdata]);
    }

    
}
