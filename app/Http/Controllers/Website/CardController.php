<?php

namespace App\Http\Controllers\Website;

use Stripe;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Http\Exceptions\HttpResponseException;
use Stripe\StripeClient;
use App\Models\User;
use App\Models\PaymentDetails;


class CardController extends Controller
{
    public function __construct()
    {
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

    }
  
   public function stripeToken($inputArr)
    {
        //Create Stripe Token
        $token = $this->stripe->tokens->create([
          "card" => [
            "number" => $inputArr['card_number'],
            "exp_month" => $inputArr['exp_month'],
            "exp_year" => $inputArr['exp_year'],
            "cvc" => $inputArr['cvc'],
            "name" => $inputArr['name']
          ],
        ]);

        return $token['id'];
    }



    /**
     * Created By Arjinder Singh
     * Created At 10-04-2023
     * @var $request object of request class
     * @var $user object of user class
     * @return object with add user card
     * This function use to api add user card
     */

    public function addUserCard(Request $request)
    {
         $requestArr = $request->all();
         
          

       if (Auth::user()) {
       $userObj=Auth::user();
           $validator = Validator::make($request->all(), [
              'card_number' => 'required',
              'exp_month' => 'required',
              'exp_year' => 'required',
              'cvc'=>'required',
              'name'=>'required'
            ]);
             if($validator->fails()){ 
               return redirect()->back()->withInput($request->all())->with('errors', $validator->errors()->first()); 
            }
               

        $input = $request->all();
        try{
             $card_token = $this->stripeToken($input);
        }
       catch (\Exception $ex)
        {
          return response()->json(['status' => false, 'inavlid' => $ex->getMessage()], 200);
         }

        try
        {
            if (!$userObj->stripe_id)
            {
                $customer = \Stripe\Customer::create([
                  'email' => $userObj->email,
                  'description' => '+ ' . $userObj->mobile_number 
                ]);
                $userObj->stripe_id = $customer['id'];
            }
            else
            {
                \Stripe\Customer::update(
                  $userObj->stripe_id,
                ['email' => $userObj->email]
                );
            }

            // tok_visa is the token which will generate in client side
            $stripeCard = \Stripe\Customer::createSource(
              $userObj->stripe_id,
            ['source' => $card_token]
            );
        }
        catch (\Exception $ex)
        {

           return response()->json(['status' => false, 'inavlid' => $ex->getMessage()], 200);
            
        }

        if (isset($stripeCard['id']) && $stripeCard['id'] != '')
        {
            /*$userCardArr = [
              'user_id' => $userObj->id,
              'card_token' => $stripeCard['id']
            ];*/

            //$userCardObj = UserCard::create($userCardArr);
            $userCardObj = $userObj->save();

            if ($userCardObj)
            {
                return response()->json(['status' => true, 'message' => 'Your card has been added successfully'], 200);
                
              
            }
            else
            {
                return response()->json(['status' => false, 'errors' => 'Unable to add card. Please try again later.'], 200);
               
            }
        }
        else
        {
            return response()->json(['status' => false, 'errors' => 'Unable to add card. Please try again later.'], 200);
        }
      }
      else{
        return response()->json(['status' => 2, 'message' => 'Login required'], 200);
      }
    }

     /**
     * Created By Arjinder Singh
     * Created At 09-11-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object with delete user card
     * This function use to api delete user card
     */

       public function deleteUserCard(Request $request)
    {
       

       $requestArr = $request->all();
         $userObj = $request->user();
        if (!$userObj) {
            return returnNotAuthorizedResponse('User is not authorized');
        }
        $rules=[
          'card_id' => 'required',
        ];

        $validator = Validator::make($requestArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        if (!$userObj->stripe_id)
        {
            $result = array(
              "statusCode" => 200, // $this-> successStatus
              "message" => 'No card found of the user.'
            );
            return response()->json($result);
        }

        try
        {
            $hasDeleted = \Stripe\Customer::deleteSource(
              $userObj->stripe_id,
              $request->input('card_id')
            );
        }
        catch (\Exception $ex)
        {
            $result = array(
              "statusCode" => 401,
              "message" => $ex->getMessage()
            );
            return response()->json($result);
        }

        // $userCard = UserCard::where('user_id', $user->id)->where('id', $request->input('card_id'))->first();
        if ($hasDeleted)
        {
            $result = array(
              "statusCode" => 200,
              "message" => "Your card has been deleted successfully!"
            );
        }
        else
        {
            $result = array(
              "statusCode" => 500,
              "message" => "Unable to delete card."
            );
        }
        return response()->json($result);
    }

   

     /**
     * Created By Arjinder Singh
     * Created At 21-11-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object with create payment when job completed 
     * This function use to api create payment when job completed 
     */

      public function createPayment(Request $request)
      {
         
         $requestArr = $request->all();
          $rules=[
            'job_id'=>'required',
            'card_id'=>'required'
            
          ];
          $validator = Validator::make($requestArr, $rules);
           if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
         $userObj = $request->user();
        if (!$userObj) {
            return returnNotAuthorizedResponse('User is not authorized');
        }

      
      $job=Jobs::where('id',$requestArr['job_id'])->first();

        if(!$job)
        {
              return returnNotFoundResponse('Job not found with this job id');
        }
       $users=   user::where('id',$job->created_by)->first();
       
try{
      $charge = \Stripe\Charge::create([
        'amount' => $job->total*100,
        'currency' => 'USD',
        'description' => 'Payment to Instaprotect for job id '.$job->invoice.'',
        'customer' => ($users)?$users->stripe_id:'',
        'source' => $requestArr['card_id'],
        'transfer_group'=>$job->invoice,
        'capture' => false,
        
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


          //$charge['paid']=false;
      if($charge['paid']!=true){
          $result = [
              "statusCode" => 409, 
              "message" => 'Transaction failed, '.$charge['failure_message'].', failed code'.$charge['failure_code'].'',
          ];
         return response()->json($result);
      }

        $bodyguardPaymentArr = [
            'job_id' => $job->id,
            'charge_id' => $charge['id'],
            'txn_id' => $charge['balance_transaction'],
            'amount' => round($charge['amount']/100),
            'card_id' => $charge['payment_method'],
           'bodyguard_id'=>$job->bodyguard_id
        ];

        PaymentDetails::create($bodyguardPaymentArr);
        $this->stripe->charges->capture(
         $charge['id'],
         []
        );
        
        return returnSuccessResponse('Payment sent successfully', $bodyguardPaymentArr);   
   }



}
