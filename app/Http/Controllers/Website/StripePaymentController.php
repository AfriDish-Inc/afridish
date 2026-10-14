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
        try {
            $data = Stripe\Charge::create ([
                    "amount" =>$request->amount * 100,
                    "currency" => "USD",
                    "source" => $request->stripeToken,
                    "description" => "This payment for subscription",
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        if($data->status == "succeeded"){
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

           // updateOrCreate, not firstOrCreate - a renewal payment must
           // actually extend expire_at on the existing row, not be
           // silently absorbed into it while the old expiry stands.
           $subscription = Subscription::updateOrCreate([
                'user_id' => auth()->user()->id,
            ], [
                'stripe_id' => $data->id,
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

       return redirect()->back()->with('error', 'Payment was not successful.');
    }
}
