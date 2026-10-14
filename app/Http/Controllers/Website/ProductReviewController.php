<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use Validator;

class ProductReviewController extends Controller
{
    public function submitReview(Request $request){
        $validator = Validator::make($request->all(), [
              'rating' => 'required',
              'name' => 'required',
              'email' => 'required|email',
              'message' => 'required',
              'product_id' => 'required',
            ]);
        if($validator->fails()){ 
           return redirect()->back()->withInput($request->all())->with('errors', $validator->errors()->first()); 
        }
        $reviewdata = ProductReview::where('product_id',$request->product_id)->where('email',$request->email)->first();
        if ($reviewdata) {
            $reviewdata->rating = $request->rating;
            $reviewdata->name = $request->name;
            $reviewdata->email = $request->email;
            $reviewdata->message = $request->message;
            $reviewdata->save();
        }else{
            $productreview = new ProductReview;
            $productreview->rating = $request->rating;
            $productreview->name = $request->name;
            $productreview->email = $request->email;
            $productreview->message = $request->message;
            $productreview->product_id = $request->product_id;
            $productreview->user_id = auth()->user()->id;
            $productreview->save();
        }
        return redirect('product-details?id='.$request->product_id)->with('message','Thanks for give me product review');
    }
}
