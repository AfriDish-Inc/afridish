<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\PaymentRecord;
use App\Models\Subscription;
use Carbon\Carbon;

class StripePaymentController extends Controller
{
    public function stripe()
    {
        return view('admin.subscription.checkout');
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $data = Stripe\Charge::create ([
                "amount" =>$request->amount * 100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "This payment for subscription",
        ]);
        // echo "<pre>";
        // print_r($data); die;
        //Session::flash('success', 'Payment Successfull!');

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
               return redirect('/vendor/setting')->with('message','Great! Plan subscribe successfully');
            }else{
               return redirect()->back()->with('error','Whoops! Plan not subscribe'); 
            }
           
       }
           
       // return redirect('vendor/setting')->with('success',"Payment Successfull!");
    }

     public function verifySubscription(Request $request)
    {
        /*echo "<pre>";
        print_r($request->all()); die;*/
        if($request->status == "successful"){
           $verifypayment = $this->curlGet($request->transaction_id);

          //$orderData=Session::get('orderData');
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

           $subscription = Subscription::firstOrCreate([
                'user_id' => auth()->user()->id,
            ], [
                'stripe_id' => $request->transaction_id,
                'user_id' => auth()->user()->id,
                'card_last_four' => $verifypayment->data->card->last_4digits,
                'start_at' => now(),
                'expire_at' => Carbon::today()->addDays(30)
            ]);

            if($subscription){
               return redirect('/vendor/setting')->with('message','Great! Plan subscribe successfully');
            }else{
               return redirect()->back()->with('error','Whoops! Plan not subscribe'); 
            }
           
       }
    }
}
