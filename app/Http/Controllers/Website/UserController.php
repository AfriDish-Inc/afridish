<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BillingAddress;
use Redirect;
use Auth;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers; 
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\OrderItem; 
use App\Models\Order;

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
           return redirect('billing-address')->with('errors', $validator->errors()->first()); 
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

    public function saveAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address1' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'mobile_number' => 'required|numeric|digits:10'
        ]);
         if($validator->fails()){ 
           return redirect('billing-address')->with('errors', $validator->errors()->first()); 
         }
         if($this->checkemail($request->email)){
             $billingAddress = new BillingAddress;
             $billingAddress->user_id = Auth::user()->id;
             $billingAddress->first_name = $request->first_name;
             $billingAddress->last_name = $request->last_name;
             $billingAddress->email = $request->email;
             $billingAddress->address1 = $request->address1;
             $billingAddress->address2 = $request->address2;
             $billingAddress->state = $request->state;
             $billingAddress->city = $request->city;
             $billingAddress->zip_code = $request->zip_code;
             $billingAddress->mobile_number = $request->mobile_number;
             $billingAddress->save();
             return redirect('checkout')->with('message','Great! Billing Address saved Successfully !');
        }else{
            return redirect('checkout')->with('error', 'Please enter valid email !');
        }
    }



    public function billingAddress(Request $request){
           return view('Website.user.billing-address');
    }

    public function checkout(Request $request){
   
        if (Auth::user()) {
          $cart = Cart::where('user_id',Auth::user()->id)->get();
          $addressdata = BillingAddress::where('user_id',Auth::user()->id)->latest()->first();
          if (!$addressdata) {
                return redirect('/billing-address')->with('errors',"Please fill address details");
            }
            $cartdata = [];
            foreach ($cart as $key => $value) {
                $data = Product::where('id',$value->product_id)->first();
                $data['product_quantity'] = $value->product_quantity;
                $data['sub_total'] = $data->price * $value->product_quantity;
                $data['cart_id'] = $value->id;
                array_push($cartdata,$data);
            }
            
            $productQuantity =  $totalProduct = $total = [];
            foreach($cartdata as $key=>$cartvalue){
                 array_push($total,$cartvalue->sub_total); 
                 array_push($totalProduct,$cartvalue->id);
                 array_push($productQuantity,$cartvalue->product_quantity); 
            }
            
            $cartdata['addressdata'] = $addressdata;
           return view('Website.user.checkout', compact('cartdata','productQuantity','totalProduct','total'));
          }else{
            return redirect('/login');
          } 
    }

    public function orderHistory(Request $request){
        if (Auth::user()) {

           //$orderItems = OrderItem::where('order_id',$request->order_id)->get();
           $orders = Order::where('user_id',auth()->user()->id)->get();
           foreach ($orders as $key => $value) {
               $itemdata = OrderItem::where('order_id',$value->id)->first();
               $productdata = Product::where('id',$itemdata->product_id)->first();
               $product_image = explode('|',$productdata->image);
               $value->product_name = $productdata->name;
               $value->product_image = $product_image[0];
               $value->price = $itemdata->price;
               $value->product_quantity = $itemdata->order_quantity;
           }
           return view('Website.user.order-history', compact('orders'));
          }else{
            return redirect('/login');
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
            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect('/');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'user_type'=> 'C',
                    'password' => encrypt('123456dummy')
                ]);
                Auth::login($newUser);
                return redirect('/');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
