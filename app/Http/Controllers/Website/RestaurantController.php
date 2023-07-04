<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        if ($request->is_feature) {
            $restaurants = User::where('user_type','R')->where('is_feature',1)->paginate(10);
        }elseif($request->is_recommended){
            $restaurants = User::where('user_type','R')->where('is_recommended',1)->paginate(10);
        }elseif($request->vendor_category_id){
            $restaurants = User::where('user_type','R')->where('vendor_category_id',$request->vendor_category_id)->paginate(10);
        }else{
            $restaurants = User::where('user_type','R')->paginate(10);
        }
        
        return view('Website.restaurants.index',compact('restaurants'));
    }

    public function details(Request $request)
    {
        $restaurant = User::where('user_type','R')->where('id',$request->id)->first();
       // $products = Product::where('id',$request->id)->first();
        $relatedProducts = Product::where('provider_id',$request->id)->paginate(6);
        return view('Website.restaurants.details',compact('restaurant','relatedProducts'));
    }
}
