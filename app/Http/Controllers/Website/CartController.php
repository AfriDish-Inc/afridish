<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Auth;

class CartController extends Controller
{
    public function index(Request $request){
        if (Auth::user()) {
          $cart = Cart::where('user_id',Auth::user()->id)->get();
            $cartdata = [];
            foreach ($cart as $key => $value) {
                $data = Product::where('id',$value->product_id)->first();
                $data['product_quantity'] = $value->product_quantity;
                $data['sub_total'] = $data->price * $value->product_quantity;
                $data['cart_id'] = $value->id; 
                array_push($cartdata,$data);
            }
            $total = [];
            foreach($cartdata as $key=>$cartvalue){
                 array_push($total,$cartvalue->sub_total); 
            }
           return view('Website.user.shoping-cart', compact('cartdata','total'));
          }else{
            return redirect('/login');
          } 
    }

    public function addToCart(Request $request){

      if (Auth::user()) {
            $validator = Validator::make($request->all(), [
                  'product_id' => 'required',
                  'product_quantity' => 'required',
                ]);
             if($validator->fails()){ 
               return redirect()->back()->with('errors', $validator->errors()->first()); 
             }
             
             $cartdata = Cart::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->first();
             $productdata = Product::where('id',$request->product_id)->first();
             if($cartdata && ($productdata->quantity > $cartdata->product_quantity)){
               $cartdata->product_quantity = $cartdata->product_quantity+$request->product_quantity;
               $cartdata->save();
             }else{
               if (($productdata->quantity) >= $request->product_quantity) {
                $cart = new Cart;
                $cart->user_id = Auth::user()->id;            
                $cart->product_id = $request->product_id;
                $cart->product_quantity = $request->product_quantity;
                $cart->save();
              }else{
                 return redirect()->back()->with('errors',"Only ".$productdata->quantity." product in stock");
              }
             }
             if($request->wishlist){
                Wishlist::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->delete();
             }
            return redirect()->back()->with('message',"Product added in cart successfully");;
          }else{
            return redirect('/login');
         } 
    }


    public function updateCart(Request $request){
      $cartdata = Cart::where('id',$request->cart_id)->first();
      $productdata = Product::where('id',$request->product_id)->first();
      if ($productdata->quantity >= $request->product_quantity) {
         if($cartdata && $request->product_quantity > 0){
           $cartdata->product_quantity = $request->product_quantity;
           $cartdata->save();
           return response()->json(['status' => true ,'message' => 'Cart updated successfully'], 200);
         }else{
           return response()->json(['status' => false ,'message' => 'Cart data not updated '], 200);
         }
     }else{
        return response()->json(['status' => false ,'message' => 'Only '.$productdata->quantity.' product in stock'], 200);
     }
    }


    public function removeCartProduct($id){
        Cart::where('id',$id)->where('user_id',Auth::user()->id)->delete();
        return redirect('/shoping-cart')->with('message','Product removed successfully');
    }  

    public function  moveToCart(Request $request){
       $cartdata = Cart::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->first();
       if($cartdata){
         $cartdata->product_quantity = $cartdata->product_quantity+$request->product_quantity;
         $cartdata->save();
       }else{
          $cart = new Cart;
          $cart->user_id = Auth::user()->id;            
          $cart->product_id = $request->product_id;
          $cart->product_quantity = $request->product_quantity;
          $cart->save();
       }
       $data =  Wishlist::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->delete();
       return redirect('/shoping-cart');
    }
}
