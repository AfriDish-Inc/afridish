<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers; 
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Traits\GlobalTrait;
use App\Models\PaymentRecord;
use App\Models\Subscription;
use App\Models\BankAccount;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    use GlobalTrait;
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
          $paymentdata = [
                    'tx_ref' => time(),
                    'amount' => $request->amount,
                    'currency' => 'NGN',
                    'payment_options' => 'card',
                    'redirect_url' => url('vendor/verify-subscribtion'),
                    'customer' => [
                        'email' => auth()->user()->email,
                        'name' => auth()->user()->name
                    ]
                ];

          //  try {
               $paymenturl = $this->curlPost(getenv('PAYMENT_URL'),$paymentdata);
               if($paymenturl){
                  return redirect($paymenturl->data->link);
               }else{
                 return redirect()->back()->with('error' , 'Payment gateways not working');
               }
            //    return redirect($paymenturl->data->link);
            // } catch (Exception $e) {
            //      return redirect()->back()->with('message', "error from pament gateway");   
            // }    
           
        }else{
            $validity = $this->remainingDate();
            $subscription = Subscription::where('user_id',auth()->user()->id)->first();
             $account = BankAccount::where('user_id',Auth::user()->id)->first();
            return view('admin.subscription.index',compact(['subscription','validity','account']));
        }
        
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

    public function addAccount(Request $request)
    {
        if ($request->isMethod('post')) {
           $validator = Validator::make($request->all(), [
            'account_bank' => 'required',
            'bank_code' => 'required',
            'account_number' => 'required',
            'beneficiary_name' => 'required',
            'currency' => 'required'
        ]);
         if($validator->fails()){ 
           return redirect()->back()->withInput()->with('error', $validator->errors()->first()); 
         }
          $bankAccount = BankAccount::updateOrCreate([
                'user_id' => auth()->user()->id,
            ], [
                'user_id' => auth()->user()->id,
                'account_bank' => $request->account_bank,
                'bank_code' => $request->bank_code,
                'account_number' => $request->account_number,
                'currency' => $request->currency,
                'beneficiary_name' => $request->beneficiary_name,
            ]);

            if($bankAccount){
               return redirect('/vendor/setting')->with('message','Great! Bank account added successfully');
            }else{
               return redirect()->with('error','Whoops! Bank account not added '); 
            }
        }else{
            $account = BankAccount::where('user_id',Auth::user()->id)->first();
            return view('admin.subscription.add-account',compact('account'));
        }
        
    }
}
