<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use App\Models\Competitor;
use App\Models\VendorCategory;
use App\Models\CompareProduct;
use Redirect;
use Auth;
use Laravel\Passport\Token;

class StatusController extends Controller
{
    public function updateStatus(Request $request)
    {
        if($request->model == 'products')
        {
                Product::where('id' , $request->product_id)->update(['is_active' => $request->status]);
                return response()->json(['status' => true , 'message' => 'Product status updated successfully.'], 200);
        }

        if($request->model == 'categories')
        {
            Category::where('id' , $request->product_id)->update(['is_active' => $request->status]);
            return response()->json(['status' => true , 'message' => 'Category status updated successfully.'], 200);
        }

        if($request->model == 'tags')
        {
            Tag::where('id' , $request->product_id)->update(['is_active' => $request->status]);
            return response()->json(['status' => true , 'message' => 'Category status updated successfully.'], 200);
        }
    }

    public function updateFeatures(Request $request) 
    {
        if($request->model == 'products')
        {

            Product::where('id' , $request->product_id)->update(['is_feature' => $request->status]);
            return response()->json(['status' => true ,'message' => 'Product Is feature updated successfully.'], 200);
        }

        if($request->model == 'categories')
        {
            Category::where('id' , $request->product_id)->update(['is_feature' => $request->status]);
            return response()->json(['status' => true , 'message' => 'Category Is feature updated successfully.'], 200);
        }

        if($request->model == 'vendor_categories')
        {
            VendorCategory::where('id' , $request->product_id)->update(['is_feature' => $request->status]);
            return response()->json(['status' => true , 'message' => 'Category Is feature updated successfully.'], 200);
        }

        if($request->model == 'users')
        {
            User::where('id' , $request->id)->update(['is_feature' => $request->status]);
            return response()->json(['status' => true , 'message' => 'Vendor Is feature updated successfully.'], 200);
        }
    }


    public function updateRecommended(Request $request) 
    {
        if($request->model == 'users')
        {
            User::where('id' , $request->id)->update(['is_recommended' => $request->status]);
            return response()->json(['status' => true , 'message' => 'Vendor Is recommended  updated successfully.'], 200);
        }
    }

//vendor_categories is_feature
}
