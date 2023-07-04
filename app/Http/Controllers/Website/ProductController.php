<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers; 
use Illuminate\Support\Facades\Validator;
use Redirect;
use App\Traits\GlobalTrait;
use Auth;
  
class ProductController extends Controller
{ 
    use GlobalTrait;
    public function index(Request $request) 
    { 
        $brands = Brand::get();
        if($request->category_id){
            $products = Product::where('category_id',$request->category_id)->latest()->get();
        }elseif ($request->is_feature) {
            $products = Product::where('is_feature',1)->latest()->get();
        }elseif ($request->vendor_category_id) {
            $products = Product::where('vendor_type',$request->vendor_category_id)->latest()->get();
        }elseif ($request->vendor_id) {
            $products = Product::where('provider_id',$request->vendor_id)->latest()->get();
        }else{
            $products = Product::latest()->get();
        }
       
        foreach ($products as $key => $value) {
            $productReview = ProductReview::where('product_id',$value->id)->latest()->get();
            if(count($productReview) > 0){
            $reviewCount = count($productReview);
            $ratingsum = ProductReview::where('product_id',$value->id)->sum('rating');
            $value->rating_count = $ratingsum/$reviewCount;
         }else{
            $value->rating_count = "0"; 
         }
            
        }

        $categories = Category::paginate(10);
        return view('Website.product.index',compact(['brands','categories','products']));
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if($validator->fails()){ 
            return redirect()->back()->withInput()->with('error', $validator->errors()->first()); 
        }
        $products = Product::where('id',$request->id)->first();
        $relatedProducts = Product::where('category_id',$products->category_id)->paginate(6);
        $productReview = ProductReview::where('product_id',$request->id)->latest()->get();
        if(count($productReview) > 0){
         $reviewCount = count($productReview);
         $ratingsum = ProductReview::where('product_id',$request->id)->sum('rating');
         $rating_count = $ratingsum/$reviewCount;
        }else{
            $rating_count = "0";
            $reviewCount = "0";
         }
        //echo $sum; die;

        return view('Website.product.details',compact('products','relatedProducts','productReview','reviewCount','rating_count'));
    }

    public function productBrand(Request $request){
        $brands = Brand::paginate(10);
        return view('Website.product.brand',compact(['brands']));
    }

    public function addWishlist(Request $request){ 
            
            $wishlistdata = Wishlist::where(['product_id' => $request->id , 'user_id'=>auth()->user()->id])->first();
            if($wishlistdata){
              $wishlistdata->delete();  
              $msg = "Product removed in wishlist";
            }else{
            $user = Wishlist::firstOrNew(['product_id' => $request->id , 'user_id'=>auth()->user()->id]);
            $user->product_id = $request->id;
            $user->user_id = auth()->user()->id;
            $user->save();  
            $msg = "Great! Product added in wishlist.";
            }
            
            return Redirect::back()->with('success',$msg);  
    }

    public function wishlist(){
        $data = Wishlist::where('user_id',auth()->user()->id)->get();
        foreach ($data as $key => $value) {
            $productdata = Product::where('id',$value->product_id)->first();
            $value->product_name = $productdata->name;
            $value->image = $productdata->image;
            $value->price = $productdata->price;
        }
        return view('Website.product.wishlist',compact('data'));
    } 

    public function removeWishlist(Request $request)
    {
         $data = Wishlist::where('user_id',auth()->user()->id)->where('id',$request->id)->delete();
         return Redirect::back()->with('success','Product removed in wishlist.');
    }

    public function addToCart(Request $request)
    {
        $cart = Cart::firstOrNew(['product_id' => $request->id , 'user_id'=>auth()->user()->id]);   
        $cart->product_id = $request->id;
        $cart->product_quantity = $request->product_quantity;
        $cart->user_id = auth()->user()->id;
        $cart->save(); 
    }

    public function productData(Request $request){
        $min_price = 0;
        if($request->brand_id && $request->category_id  && $request->price){
            if($request->sortBy == 'htl'){
              $data = Product::whereIn('category_id',$request->category_id)->whereIn('brand_id',$request->brand_id)->whereBetween('price', [$min_price, $request->price])->latest()->get(); 
            }else{
              $data = Product::whereIn('category_id',$request->category_id)->whereIn('brand_id',$request->brand_id)->get();   
            }

        }elseif ($request->brand_id && $request->category_id  && $request->price) {
            if($request->sortBy == 'htl'){
               $data = Product::whereIn('brand_id',$request->brand_id)->whereIn('category_id',$request->category_id)->whereBetween('price', [$min_price, $request->price])->latest()->get();
            }else{
               $data = Product::whereIn('brand_id',$request->brand_id)->whereIn('category_id',$request->category_id)->whereBetween('price', [$min_price, $request->price])->get();
            }
        }elseif ($request->category_id  && $request->price) {
            if($request->sortBy == 'htl'){
                $data = Product::whereIn('category_id',$request->category_id)->whereBetween('price', [$min_price, $request->price])->latest()->get();
            }else{
                $data = Product::whereIn('category_id',$request->category_id)->whereBetween('price', [$min_price, $request->price])->get();
            }
        }elseif ($request->brand_id && $request->category_id) {
            if($request->sortBy == 'htl'){
               $data = Product::whereIn('brand_id',$request->brand_id)->whereIn('category_id',$request->category_id)->latest()->get();
            }else{
               $data = Product::whereIn('brand_id',$request->brand_id)->whereIn('category_id',$request->category_id)->get();
            }
        }elseif ($request->brand_id && $request->price) {
            if($request->sortBy == 'htl'){
              $data = Product::whereIn('brand_id',$request->brand_id)->whereBetween('price', [$min_price, $request->price])->latest()->get();
            }else{
              $data = Product::whereIn('brand_id',$request->brand_id)->whereBetween('price', [$min_price, $request->price])->get();
            }
        }elseif ($request->sortBy && $request->price) {
            if($request->sortBy == 'htl'){
              $data = Product::whereBetween('price', [$min_price, $request->price])->latest()->get();
            }else{
              $data = Product::whereBetween('price', [$min_price, $request->price])->get();
            }
        }elseif ($request->brand_id ) {
            if($request->sortBy == 'htl'){
              $data = Product::whereIn('brand_id',$request->brand_id)->latest()->get();
            }else{
              $data = Product::whereIn('brand_id',$request->brand_id)->get();
            }
        }elseif ($request->category_id) {
            if($request->sortBy == 'htl'){
              $data = Product::whereIn('category_id',$request->category_id)->latest()->get();
            }else{
              $data = Product::whereIn('category_id',$request->category_id)->get();
            }
        }elseif ($request->sortBy) {
            if($request->sortBy == 'htl'){
              $data = Product::latest()->get();
            }else{
              $data = Product::get();
            }
        }elseif ($request->price) {
            if($request->sortBy == 'htl'){
              $data = Product::whereBetween('price', [$min_price, $request->price])->latest()->get();
            }else{
              $data = Product::whereBetween('price', [$min_price, $request->price])->get();
            }
        }else{
            $data = Product::latest()->get();
        }

        /*echo "<pre>"; 
        print_r($data);
        die;*/
        if(Auth::user()){
            foreach ($data as $key => $featurevalue) {
                $wishlist = Wishlist::where('product_id',$featurevalue->id)->where('user_id',Auth::user()->id)->first();
                if($wishlist){
                    $featurevalue->is_fav = 1;
                }else{
                    $featurevalue->is_fav = ""; 
                }

                $productReview = ProductReview::where('product_id',$featurevalue->id)->latest()->get();
                if(count($productReview) > 0){
                    //$reviewCount = count($productReview);
                    $ratingsum = ProductReview::where('product_id',$featurevalue->id)->avg('rating');
                    $featurevalue->rating_count = round($ratingsum);
                 }else{
                    $featurevalue->rating_count = "0";
                 }
            }
        } 
        return response()->json($data);
    }

    public function wishlistAdd(Request $request){
      if (Auth::user()) {
        $validator = Validator::make($request->all(), [
              'product_id' => 'required',
            ]);
         if($validator->fails()){ 
           return redirect()->back()->with('errors', $validator->errors()->first()); 
         }
       $wishlist = Wishlist::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->first();
       if($wishlist){
         $wishlist->delete();
         $count = Wishlist::where('user_id',Auth::user()->id)->count();
         return response()->json(['status' => 0 ,'message' => 'Wishlist removed successfully','favcount'=>$count], 200);
       }else{
         $wishlistcreate = new Wishlist;
         $wishlistcreate->user_id = Auth::user()->id;
         $wishlistcreate->product_id = $request->product_id;
         $wishlistcreate->save();
         $count = Wishlist::where('user_id',Auth::user()->id)->count();
         return response()->json(['status' => 1 ,'message' => 'Wishlist Added successfully','favcount'=>$count], 200);
       }
      }else{
        return response()->json(['status' => 2 ,'message' => 'Login required'], 200);
      }
    }

    public function addcart(Request $request){

      if (Auth::user()) {
            $validator = Validator::make($request->all(), [
                  'product_id' => 'required',
                  'product_quantity' => 'required',
                ]);
             if($validator->fails()){ 
                return response()->json(['status' => 0 ,'errors' => $validator->errors()->first()], 200); 
             }
             
             $cartdata = Cart::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->first();

             $productdata = Product::where('id',$request->product_id)->first();
             if($cartdata && ($productdata->quantity > $cartdata->product_quantity)){
               $cartdata->product_quantity = $cartdata->product_quantity+$request->product_quantity;
               $cartdata->vendor_id = $productdata->provider_id;
               $cartdata->save();
             }else{

                // $olderdata = Cart::where('vendor_id',$productdata->provider_id)->where('user_id',Auth::user()->id)->get();
                // die($olderdata);
                // if(count($olderdata) > 0){
                   if ((($productdata->quantity) >= $request->product_quantity )) {
                    
                    $cart = new Cart;
                    $cart->user_id = Auth::user()->id;            
                    $cart->product_id = $request->product_id;
                    $cart->vendor_id = $productdata->provider_id;
                    $cart->product_quantity = $request->product_quantity;
                    $cart->save();
                  }else{
                     $count = Cart::where('user_id',Auth::user()->id)->count(); 
                     return response()->json(['status' => 0 ,'message' => "Only ".$productdata->quantity." product in stock",'favcount'=>$count], 200);
                     //return redirect()->back()->with('errors',"Only ".$productdata->quantity." product in stock");
                  }
              // }else{

              // }
             }
             if($request->wishlist){
                Wishlist::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->delete();
             }

             $count = Cart::where('user_id',Auth::user()->id)->count();
             return response()->json(['status' => 1 ,'message' => 'Product added in cart successfully','favcount'=>$count], 200);
            //return redirect()->back()->with('message',"Product added in cart successfully");;
          }else{
            return response()->json(['status' => 2 ,'message' => 'Login required'], 200);
         } 
    }


    public function removeCart(Request $request){
        $validator = Validator::make($request->all(), [
              'cart_id' => 'required',
            ]);
         if($validator->fails()){ 
            return response()->json(['status' => 0 ,'errors' => $validator->errors()->first()], 200); 
         }
        Cart::where('id',$request->cart_id)->where('user_id',Auth::user()->id)->delete();
        $count = Cart::where('user_id',Auth::user()->id)->count();
        return response()->json(['status' => 1 ,'message' => 'Product removed successfully','favcount'=>$count], 200);
    } 

}
