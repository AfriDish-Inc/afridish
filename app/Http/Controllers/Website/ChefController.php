<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class ChefController extends Controller
{
    public function index(Request $request)
    {
        if ($request->is_feature) {
            $chefs = User::where('user_type','CH')->where('is_feature',1)->paginate(10);
        }elseif($request->is_recommended){
            $chefs = User::where('user_type','CH')->where('is_recommended',1)->paginate(10);
        }elseif($request->vendor_category_id){
            $chefs = User::where('user_type','CH')->where('vendor_category_id',$request->vendor_category_id)->paginate(10);
        }else{
            $chefs = User::where('user_type','CH')->paginate(10);
        }
        
        return view('Website.chef.index',compact('chefs'));
    }

    public function details(Request $request)
    {
        $chef = User::where('user_type','CH')->where('id',$request->id)->first();
       // $products = Product::where('id',$request->id)->first();
        $relatedProducts = Product::where('provider_id',$request->id)->paginate(6);
        return view('Website.chef.details',compact('chef','relatedProducts'));
    }
}
