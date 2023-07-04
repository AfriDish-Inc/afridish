<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\VendorCategory;

class VendorController extends Controller 
{
    public function index(Request $request)
    {
        if ($request->is_feature) {
            $vendors = User::where('user_type','V')->where('is_feature',1)->paginate(10);
        }elseif($request->is_recommended){
            $vendors = User::where('user_type','V')->where('is_recommended',1)->paginate(10);
        }elseif($request->vendor_category_id){
            $vendors = User::where('user_type','V')->where('vendor_category_id',$request->vendor_category_id)->paginate(10);
        }else{
            $vendors = User::where('user_type','V')->paginate(10);
        }
        
        return view('Website.vendors.index',compact('vendors'));
    }

    public function details(Request $request)
    {
        $vendor = User::where('user_type','V')->where('id',$request->id)->first();
       // $products = Product::where('id',$request->id)->first();
        $relatedProducts = Product::where('provider_id',$request->id)->paginate(6);
        return view('Website.vendors.details',compact('vendor','relatedProducts'));
    }
}
