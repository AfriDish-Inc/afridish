<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Quantity;
use App\Models\Subscription;
use App\Models\ProductReview;
use App\Models\Cart;
use Redirect;
use Carbon;
use App\Traits\GlobalTrait;
class ProductController extends Controller
{
    use GlobalTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){   
        if (auth()->user()->user_type == "V" || auth()->user()->user_type == "CH" || auth()->user()->user_type == "R") {
             $data['products'] = Product::with('category')->where('provider_id',auth()->user()->id)->latest()->paginate(10);
         }else{
             $data['products'] = Product::with('category')->latest()->paginate(10);
         }
		return view('admin.product.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
		$data['category'] = Category::where('is_active' , 1)->get();
        $data['brand'] = Brand::get();
        if(auth()->user()->user_type == "V"){
            $data['provider'] = User::where('id' , auth()->user()->id)->get();
        }else{
            $data['provider'] = User::where('user_type' , 'V')->get();
        }
        $data['quantity_unit'] = Quantity::select('name')->get();
		return view('admin.product.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
		$request->validate([
            'name' => 'required|unique:products',
            'detail' => 'required',
			'category_id' => 'required|numeric',
            'brand_id' => 'required',
            'provider_id' => 'required|numeric',
			'quantity' => 'required|numeric',
            'price' => 'required|numeric|between:0,99999.99',
            'image' => 'required',
            'description' => 'required',
            'video'=>'required'
        ]);
        try {
                $products = new Product;
                $images=array();
                if($files=$request->file('image')){
                    foreach($files as $file){
                        $name=$file->getClientOriginalName();
                        $file->move('upload/images',$name);
                        $images[]=$name;
                    }
                }
                $video_path='';
                 if($file=$request->file('video')){
                    
                        $name=$file->getClientOriginalName();
                        $file->move('upload/images',$name);
                        $video_path=$name;
                    
                }
              
                $vendordetails = User::where('id',$request->provider_id)->first();
                $products->name = $request->name;
                $products->detail = $request->detail;
                $products->user_id = auth()->user()->id;
                $products->category_id = $request->category_id;
                $products->provider_id = $request->provider_id;
                $products->price = $request->price;
                $products->brand_id = $request->brand_id;
                $products->quantity = $request->quantity;
                $products->description = $request->description;
                $products->address = $request->address;
                $products->latitude = $request->lat;
                $products->longitude = $request->lon;
                $products->vendor_type = $vendordetails->vendor_category_id;
                $products->sku = $this->random_strings(10);
                $products->image = implode("|",$images);
                $products->video=$video_path;
              if (auth()->user()->user_type == "V") {
                $expDate = Carbon\Carbon::now()->subDays(7);
                $data = User::whereDate('created_at', '>',$expDate)->where('id',auth()->user()->id)->first(); 
                if($this->remainingDate() > 0 || $data){
                   $productCount = Product::where('user_id',auth()->user()->id)->count();
                    if ($productCount < 7) {
                        $products->save();
                        $msg = "Great! Product saved Successfully.";
                    }else{
                        $msg = "You can add only 7 products free";
                    } 
                   
                }else{
                    $msg = "Your free plan expired ! Please subscribe";
                }
               
                return Redirect::to('vendor/product')->with('success',$msg);
            }else{
                $products->save();
                return Redirect::to('admin/product')->with('success','Great! Product saved Successfully.');
            }
        } catch (Exception $e) {
            if (auth()->user()->user_type == "V") {
                 return Redirect::to('vendor/product')->with('success',$e);
             }else{
                 return Redirect::to('admin/product')->with('success',$e);
             }   
        }
    }

    public function show(Product $product)
    {
		$request->validate([
            'name' => 'required',
            'store_id' => 'required',
			'category_id' => 'required'
        ]);
    }

    public function edit(Product $product){
		$where = array('id' => $product->id);
        $data['product'] =Product::where($where)->first();
        $data['quantity_unit'] = Quantity::select('name')->get();
		$data['category'] = Category::where('is_active' , 1)->get();
        $data['brand'] = Brand::get();
        if(auth()->user()->user_type == "V"){
            $data['provider'] = User::where('id' , auth()->user()->id)->get();
        }else{
            $data['provider'] = User::where('user_type' , 'V')->get();
        }
        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
			'category_id' => 'required|numeric',
			'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'provider_id' => 'required|numeric',
            'description' => 'required',
        ]);

        $product_detail = Product::where('id', '=', $id)->first();
        //$product->update($request->all());
        $vendordetails = User::where('id',$request->provider_id)->first();
        
        //$product = Product::where('id', '=', $id)->update(['latitude'=>$request->lat,'longitude'=>$request->lon,'vendor_type'=>$vendordetails->vendor_category_id]);
		$file = $request->file('image');
		if(isset($file))
		{
            $images=array();
            if($files=$request->file('image')){
                foreach($files as $file){
                    $name=$file->getClientOriginalName();
                    $file->move('upload/images',$name);
                    $images[]=$name;
                }
            }
            $video_path='';
                 if($file=$request->file('video')){
                    
                        $name=$file->getClientOriginalName();
                        $file->move('upload/images',$name);
                        $video_path=$name;
                    
            }
                $product_detail->name = $request->name;
                $product_detail->detail = $request->detail;
                $product_detail->user_id = auth()->user()->id;
                $product_detail->category_id = $request->category_id;
               
                $product_detail->price = $request->price;
                $product_detail->brand_id = $request->brand_id;
                $product_detail->quantity = $request->quantity;
                $product_detail->description = $request->description;
                $product_detail->address = $request->address;
                $product_detail->latitude = $request->lat;
                $product_detail->longitude = $request->lon;
                isset($images) ? $product_detail->image = $images : $product_detail->image;
                $product_detail->image = implode("|",$images);
                isset($video_path) ? $product_detail->video = $video_path : $product_detail->video;
                $product_detail->save();
                
			/*$product = Product::where('id', '=', $id)->update(
						   array(
								 "image" => implode("|",$images)
								 )
						   );*/
		}
        if (auth()->user()->user_type == "V") {
             return Redirect::to('vendor/product')->with('success','Product updated successfully');
         }else{
             return Redirect::to('admin/product')->with('success','Product updated successfully');
         } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product){
        Wishlist::where('product_id',$product->id)->delete();
        Cart::where('product_id',$product->id)->delete();
        ProductReview::where('product_id',$product->id)->delete();
        $product->delete();
        if (auth()->user()->user_type == "V") {
            return Redirect::to('vendor/product')->with('success','Product deleted successfully');
        }else{
            return Redirect::to('admin/product')->with('success','Product deleted successfully');
        }
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
         return response()->json(['status' => true ,'message' => 'Wishlist Updated successfully'], 200);
       }else{
         $wishlistcreate = new Wishlist;
         $wishlistcreate->user_id = Auth::user()->id;
         $wishlistcreate->product_id = $request->product_id;
         $wishlistcreate->save();
         $count = Wishlist::where('user_id',Auth::user()->id)->count();
         return response()->json(['status' => true ,'message' => 'Wishlist Added successfully','favcount'=>$count], 200);
       }
      }else{
        return response()->json(['status' => false ,'message' => 'Login required'], 401);
      }
    }

    public function random_strings($length_of_string){
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}
