<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\BillingAddress;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Redirect;

class AdminController extends Controller
{
    public function index()
    {
		return view('admin.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'last_name' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:5000'
        ]);

        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $path = 'upload/images';
        $file->move($path, $filename);

        User::where('id', Auth::user()->id)->update([
            'name' => $request->name,
            //'last_name' => $request->last_name,
            'address' => $request->address,
            'latitude' => $request->lat,
            'longitude' => $request->lon,
            'profile_picture' => $filename
        ]);

        if (Auth::user()->user_type == "V") {
             $msg = "Great! Vendor profile updated successfully.";
         }else{
            $msg = "Great! admin profile updated successfully.";
         } 
        return Redirect::back()->with('success',$msg);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|different:old_password|max:20|regex:/^[\w-]*$/',
            'confirm_password' => 'required|same:new_password'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($request->old_password, $user->password))
        {
            $user->fill([
             'password' => Hash::make($request->new_password)
             ])->save();
            if (Auth::user()->user_type == "V") {
                $msg = "Great! Vendor password updated successfully.";
             }else{
                $msg = "Great! admin password updated successfully.";
             } 
            return Redirect::back()->with('success',$msg);
        }
        else {
            return Redirect::back()->with('error','Old password is incorrect.');
        }
    }

    public function Orders(Request $request)
    {
         $orders = Order::where('vendor_id',auth()->user()->id)->paginate(10);   
         return view('admin.orders.index',compact('orders'));
    }

    

}
