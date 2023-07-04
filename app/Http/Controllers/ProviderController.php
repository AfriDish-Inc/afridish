<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\VendorCategory;
use App\Models\VendorDailyHour;
use Redirect;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers; 
use Illuminate\Support\Facades\Validator;
use App\Mail\VerifyMail;
use Illuminate\Support\Str;
use Mail;

class ProviderController extends Controller
{
    public function index()
    {
        $provider = User::latest()->where('user_type' , 'V')->paginate(10);
        return view('admin.provider.index')->with(['providers'=>$provider]);
    }

    public function create()
    {
        $vendorCategories = VendorCategory::get();
        return view('admin.provider.create',compact('vendorCategories'));
    }

    public function store(Request $request){
        $messages = [
           'profile_picture.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
           // 'user_address' => 'required',
            'vendor_category_id' => 'required',
            'mobile_number' => 'required|numeric||unique:users,mobile_number|digits:10',
            'profile_picture' => 'required|mimes:jpeg,png,jpg|max:2048'
        ],$messages);
         if($validator->fails()){ 
           return redirect()->back()->withInput()->with('error', $validator->errors()->first()); 
         }

         if($this->checkemail($request->email)){
            $password = Str::upper(Str::random(16));
            $file = $request->file('profile_picture');
            $filename = $file->getClientOriginalName();
            $filename = time().'_'.$filename;
            $path = 'upload/images';
            $file->move($path, $filename);
            $provider = new User;
            $provider->name = $request->name;
            $provider->email = $request->email;
            $provider->user_type = 'V';
            $provider->profile_picture = $filename;
            $provider->mobile_number = $request->mobile_number;
            $provider->user_address = $request->user_address;
            $provider->vendor_category_id = $request->vendor_category_id;
            $provider->password = bcrypt($password);
            $provider->save();
            $message = 'Great! Provider Created Successfully.';

            $dailyHour = VendorDailyHour::updateOrCreate([
                'user_id' => $provider->id
            ], [
                'user_id' => $provider->id,
                'sun' => $request->sun_start_date.'|'.$request->sun_end_date,
                'mon' => $request->mon_start_date.'|'.$request->mon_end_date,
                'tue' => $request->tue_start_date.'|'.$request->tue_end_date,
                'wed' => $request->wed_start_date.'|'.$request->wed_end_date,
                'thu' => $request->thu_start_date.'|'.$request->thu_end_date,
                'fri' => $request->fri_start_date.'|'.$request->fri_end_date,
                'sat' => $request->sat_start_date.'|'.$request->sat_end_date,
                'status' => 1
            ]);

            $data= [
                'email' => $request->email,
                'password' => $password,
            ];

            Mail::to($request->email)->send(new VerifyMail($data));
             return Redirect::to('admin/provider')->with('success',$message);
         }else{
            return redirect()->back()->withInput()->with('error', 'Please enter valid email !');
         }
    }

    public function show(User $category)
    {
        //
    }

    public function edit(User $provider)
    {   
       // $providerdata =  User::where('id',$provider->id);
        $vendorCategories = VendorCategory::get();
        $dailyhours = VendorDailyHour::where('user_id',$provider->id)->first();
        return view('admin.provider.edit',compact('provider','dailyhours','vendorCategories'));
    }

    public function update(Request $request,$id)
    {
        $messages = [
           'profile_picture.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            //'email' => 'required|unique:users,email',
            //'user_address' => 'required',
            'vendor_category_id' => 'required',
            'mobile_number' => 'required|numeric|digits:10',
            'profile_picture' => 'required|mimes:jpeg,png,jpg|max:2048'
        ],$messages);

         if($validator->fails()){ 
           return redirect()->back()->withInput()->with('error', $validator->errors()->first()); 
         }
         
        
        if($this->checkemail($request->email)){
          $provider = User::where('id',$id)->first();
          if($request->name){
            $provider->name = $request->name;
          } 
          if($request->mobile_number){
            $provider->mobile_number = $request->mobile_number;
          } 
          if($request->user_address){
            $provider->user_address = $request->user_address;
          } 

          if($request->vendor_category_id){
            $provider->vendor_category_id = $request->vendor_category_id;
          }
          if($request->file('profile_picture')){
            $file = $request->file('profile_picture');
            $filename = $file->getClientOriginalName();
            $filename = time().'_'.$filename;
            $path = 'upload/images';
            $file->move($path, $filename);
            $provider->profile_picture = $filename;
          } 

          if($request->password){
            $provider->password = bcrypt("Welcome");
          } 
          $provider->save();

            $dailyHour = VendorDailyHour::updateOrCreate([
                'user_id' => $id
            ], [
                'user_id' => $id,
                'sun' => $request->sun_start_date.'|'.$request->sun_end_date,
                'mon' => $request->mon_start_date.'|'.$request->mon_end_date,
                'tue' => $request->tue_start_date.'|'.$request->tue_end_date,
                'wed' => $request->wed_start_date.'|'.$request->wed_end_date,
                'thu' => $request->thu_start_date.'|'.$request->thu_end_date,
                'fri' => $request->fri_start_date.'|'.$request->fri_end_date,
                'sat' => $request->sat_start_date.'|'.$request->sat_end_date,
                'status' => 1
            ]);
          return Redirect::to('admin/provider')->with('success','Great! Provider Updated Successfully.');
        }else{
            return redirect()->back()->withInput()->with('error', 'Please enter valid email !');
        }
    }

    public function destroy(Request $request){
        Product::where('provider_id',$request->id)->delete();  
        VendorDailyHour::where('user_id',$request->id)->delete();  
        User::where('id',$request->id)->delete();
        return Redirect::to('admin/provider')->with('success','Provider deleted successfully');
    }

    public function checkemail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
}
