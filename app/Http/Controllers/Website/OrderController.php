<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers; 
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Traits\GlobalTrait;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;
use App\Models\PaymentRecord;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use Stripe;
use Carbon\Carbon;
class OrderController extends Controller
{
     private $stripe;
      public function __construct(){
          Stripe\Stripe::setApiKey(config('services.stripe.secret'));
          $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret')); 
         
          
     }
    use GlobalTrait;

    public function productCheckout(Request $request)
    {

        if(!$request->address_id){
            return redirect('billing-address')->with('errors', "Please fill address details");
        }
        
       
        $validator = Validator::make($request->all(), [
              'grand_total' => 'required',
              'payment_method' => 'required',
              'address_id' => 'required',
              'product_id' => 'required',
              'product_quantity' => 'required', 
            ]);
        if($validator->fails()){ 
           return redirect()->back()->with('errors', $validator->errors()->first()); 
        }
           $user = User::select('stripe_id', 'email')->where('id', Auth::id())->first();
          try{
                   $userDetails =  \Stripe\Customer::retrieve(
                         $user->stripe_id,
                      []
                    );
                    } catch(\Exception $ex){
                     $result = array(
                       "statusCode" => 401,
                       "message" => $ex->getMessage()
                     );
                     return response()->json($result );
                   }
        
                $this->orderPlaced($request->all());
                if($request->payment_method == "stripe") {
        
                 try{
                 
                     $data = \Stripe\Charge::create([
                       'amount' => $request->grand_total * 100,
                       'currency' => 'USD',
                       'description' => 'This payment for subscription',
                       'customer' => ($user)?$user->stripe_id:'',
                       'source' => $userDetails->default_source,
                       //'transfer_group'=>$order_details->invoice,
                      // 'capture' => false,
                       
                     ]);
                 }
                      catch (\Exception $ex)
                       {
                           $result = array(
                             "statusCode" => 401,
                             "message" => $ex->getMessage()
                           );
                           return response()->json($result);
                       }
                       if($data->status == "succeeded"){
          // $verifypayment = $this->curlGet($request->transaction_id);

          //$orderData=Session::get('orderData');
           $paymentRecord = PaymentRecord::firstOrCreate([
                'transacton_id' => $data->id
            ], [
                'transacton_id' => $data->id,
                'last_four_digit' => $data->source->last4,
                'flw_ref' => 0,
                'tx_ref' => $data->balance_transaction,
                'amount' => $data->amount,
                'app_fee' => 0,
                'customer_id' => auth()->user()->id,
                'status' => $data->status,
                'currency' => $data->currency,
                'card_type' => $data->source->brand,
                'payment_responce' => json_encode($data),
            ]);

           $subscription = Subscription::firstOrCreate([
                'user_id' => auth()->user()->id,
            ], [
                'stripe_id' => $data->id,
                'user_id' => auth()->user()->id,
                'card_last_four' => $data->source->last4,
                'start_at' => now(),
                'expire_at' => Carbon::today()->addDays(30)
            ]);

            if($subscription){
               return redirect('/order-history')->with('message','Great! Plan subscribed successfully');
            }else{
               return redirect()->back()->with('error','Whoops! Plan not subscribed'); 
            }
           
       }
   }
   else{
    return redirect('/order-history')->with('message','Great! Order placed successfully');
   }

  /*      if ($request->payment_method == "fw") {
            $paymentdata = [
                    'tx_ref' => time(),
                    'amount' => $request->grand_total,
                    'currency' => 'NGN',
                    'payment_options' => 'card',
                    'redirect_url' => url('/verify'),
                    'customer' => [
                        'email' => auth()->user()->email,
                        'name' => auth()->user()->name
                    ]
                ];
                   
           $paymenturl = $this->curlPost(getenv('PAYMENT_URL'),$paymentdata);

           if($paymenturl){
              Session::put('orderData', $request->all());
              return redirect($paymenturl->data->link);
           }else{
             return redirect()->back()->with('error' , 'Payment gateways not working');
           }
           
        }else{
            if($request->grand_total > 0){
                $data = $this->orderPlaced($request->all());
            }else{
                $data = false;
            }  
        }
                                            
        if($data){
            return view('Website.user.order-place', compact('data'));
           //return redirect('order-place')->with('message','Great! Order placed successfully');
        }else{
           return redirect('checkout')->with('error','Whoops! Order not placed '); 
        }*/
    }

    public function orderHistory(Request $request){
        if (Auth::user()) {

           //$orderItems = OrderItem::where('order_id',$request->order_id)->get();
           $orders = Order::where('user_id',auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
           foreach ($orders as $key => $value) {

               $itemdata = OrderItem::where('order_id',$value->id)->first();

               $productdata = Product::where('id',$itemdata->product_id)->first();
               if($productdata)
               {

                $product_image = explode('|',$productdata->image);
               $value->product_name = $productdata->name;
               $value->product_image = $product_image[0];
               $value->price = $itemdata->price;
               $value->product_quantity = $itemdata->order_quantity;
            }
           }
           
           return view('Website.user.order-history', compact('orders'));
          }else{
            return redirect('/login');
          } 
    }

    public function orderDetails(Request $request)
    {
       // if (Auth::user()) {

           //$orderItems = OrderItem::where('order_id',$request->order_id)->get();
          // $orders = Order::where('user_id',auth()->user()->id)->get();
          // foreach ($orders as $key => $value) {
               $itemdata = OrderItem::where('order_id',$request->id)->get();

               foreach ($itemdata as $key => $itemvalue) {
                  $productdata = Product::where('id',$itemvalue->product_id)->first();
                   $product_image = explode('|',$productdata->image);
                   $itemvalue->product_name = $productdata->name;
                   $itemvalue->product_image = $product_image[0];
                   $itemvalue->price = $itemvalue->price;
                   $itemvalue->product_quantity = $itemvalue->order_quantity;
               }

        
          // }
           return view('Website.user.order-details', compact('itemdata'));
          /*}else{
            return redirect('/login');
          }*/ 
    }

    public function verifyPayment(Request $request)
    {
        
       if($request->status == "successful"){
           $verifypayment = $this->curlGet($request->transaction_id);

          $orderData=Session::get('orderData');
           $paymentRecord = PaymentRecord::firstOrCreate([
                'transacton_id' => $request->transaction_id
            ], [
                'transacton_id' => $request->transaction_id,
                'last_four_digit' => $verifypayment->data->card->last_4digits,
                'flw_ref' => $verifypayment->data->flw_ref,
                'tx_ref' => $verifypayment->data->tx_ref,
                'amount' => $verifypayment->data->amount,
                'app_fee' => $verifypayment->data->app_fee,
                'customer_id' => $verifypayment->data->customer->id,
                'status' => $verifypayment->data->status,
                'currency' => $verifypayment->data->currency,
                'card_type' => $verifypayment->data->card->type,
                'payment_responce' => json_encode($verifypayment),
            ]);
           $data = $this->orderPlaced($orderData);
           DB::table('orders')->where('id',$data)->update(['paypal_charge_id' => $request->transaction_id]);
           Session::flush();
            if($data){
               return view('Website.user.order-place', compact('data'));
           //return redirect('order-place')->with('message','Great! Order placed successfully'); paypal_charge_id
            }else{
               return redirect('checkout')->with('error','Whoops! Order not placed '); 
            }
           
       }
    }

    public function orderRating(Request $request)
    {
        
    }

}
