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
    private function isVendorUser()
    {
        return in_array(auth()->user()->user_type, ['V', 'CH', 'R']);
    }

    public function index(Request $request)
    {
        if ($this->isVendorUser()) {
            // A single order can span multiple vendors - find orders that
            // have at least one item belonging to this vendor, rather than
            // relying on orders.vendor_id (which can't represent more than
            // one vendor per order; see GlobalTrait::orderPlaced).
            $orders = Order::whereHas('items', function ($q) {
                $q->where('vendor_id', auth()->user()->id);
            })->orderBy('order_date', 'DESC')->paginate(10);
        }else{
            $orders = Order::orderBy('order_date', 'DESC')->paginate(10);
        }
        return view('admin.orders.index',compact('orders'));
    }

    public function updateOrder(Request $request)
    {
        if ($request->isMethod('post')) {
           $itemsQuery = OrderItem::where('order_id',$request->order_id);
           if ($this->isVendorUser()) {
               // Only this vendor's own line items in the order - a vendor
               // has no business changing another vendor's items, or the
               // order-wide status, in a shared multi-vendor order.
               $itemsQuery->where('vendor_id', auth()->user()->id);
           }
           $updated = $itemsQuery->update(['status' => $request->status]);

           if ($updated === 0) {
               abort(403);
           }

           // Only advance the order-wide status once every vendor's items
           // in this order have reached at least that status, so one
           // vendor's update can't claim the whole order is further along
           // than it actually is.
           $behind = OrderItem::where('order_id',$request->order_id)
               ->where('status','<',$request->status)
               ->exists();
           if (!$behind) {
               Order::where('id',$request->order_id)->update(['order_status' => $request->status]);
           }

           return redirect('vendor/orders')->with('message','Orders status updated successfully');
        }else{
            $order_details = Order::where('id',$request->id)->first();
            if ($this->isVendorUser() && !OrderItem::where('order_id',$request->id)->where('vendor_id',auth()->user()->id)->exists()) {
                abort(403);
            }
            return view('admin.orders.update',compact('order_details'));
        }

    }

    public function showOrder(Request $request)
    {
        $itemsQuery = OrderItem::where('order_id',$request->id);
        if ($this->isVendorUser()) {
            $itemsQuery->where('vendor_id', auth()->user()->id);
        }
        $order_details = $itemsQuery->paginate(10);
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
