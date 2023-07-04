<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\BillingAddress;

class OrderController extends Controller
{
    public function index(Request $request)
    {   
        if (auth()->user()->user_type == 'V' || auth()->user()->user_type == "CH" || auth()->user()->user_type == "R") {
            $orders = Order::where('vendor_id',auth()->user()->id)->orderBy('order_date', 'DESC')->paginate(10);
        }else{
            $orders = Order::orderBy('order_date', 'DESC')->paginate(10);
        }
        return view('admin.orders.index',compact('orders'));
    }

    public function updateOrder(Request $request)
    {
        if ($request->isMethod('post')) {
           $order_item = OrderItem::where('order_id',$request->order_id)->update(['status' => $request->status]); 
           $orderdata = Order::where('id',$request->order_id)->first();
           $orderdata->order_status = $request->status;
           $orderdata->save();

           return redirect('vendor/orders')->with('message','Orders status updated successfully');
        }else{
            $order_details = Order::where('id',$request->id)->first();
            return view('admin.orders.update',compact('order_details'));
        }
        
    }

    public function showOrder(Request $request)
    {
        $order_details = OrderItem::where('order_id',$request->id)->paginate(10);
        foreach ($order_details as $key => $value) {
            $productdata = Product::where('id',$value->product_id)->first();
            $orderdata = Order::where('id',$value->order_id)->first();
            $addressdata = BillingAddress::where('user_id',$orderdata->user_id)->first();
            $value->product_name = $productdata->name;
            $value->address = $addressdata;
        }
        return view('admin.orders.show',compact('order_details'));
    }



    public function soldProduct(Request $request)
    {
         $data = OrderItem::where('vendor_id',auth()->user()->id)->where('status',2)->paginate(10);
         return view('admin.sold-product.index',compact('data'));
    }
}
