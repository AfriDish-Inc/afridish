<?php

namespace App\Http\Controllers\Website;

use Stripe;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\StripeClient;

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

}
