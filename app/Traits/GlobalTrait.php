<?php 
namespace App\Traits;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Storage; 
use Carbon;
 
trait GlobalTrait
{
    public function getData($id,$col,$table){
        $data = DB::table($table)->where($col, $id)->first();
        return $data->name;
    }

    public function getAllData($id,$col,$table){
        $data = DB::table($table)->where($col, $id)->first();
        return $data;
    }


    public function getById($id,$col,$table){ 
        $data = DB::table($table)->where($col, $id)->get();
        return $data;
    }

    public function getAll($table){
        $data = DB::table($table)->get();
        return $data;
    }

    public function isWishlist($data)
    {
        $data = DB::table('wishlists')->where($data)->get();
        return $data;
    }

    public function remainingDate($value=''){
          $subsdata = DB::table('subscriptions')->where('user_id',auth()->user()->id)->first();
          if($subsdata){
            //$subsdata = $subsdata;
            return Carbon\Carbon::parse(now())->diffInDays($subsdata->expire_at, false);
            //return Carbon\Carbon::parse($subsdata->expire_at)->diffInDays(now(), false);
          }else{
            return false;
          }
          
    }


    public function uploadS3FIle($file_path,$data){
        $path = Storage::disk('s3')->put($file_path, $data, 'public');
        $path = Storage::disk('s3')->url($path);
        return $path;
    }


    public function orderPlaced($data)
    {
        //return $data;
        $insertdata['user_id'] = auth()->user()->id;
        $insertdata['product_id'] = "";
        $insertdata['order_date'] = now();
        $insertdata['order_type'] = $data['payment_method'];
        $insertdata['amount'] = $data['grand_total'];
        $insertdata['quantity'] = $data['product_quantity'];
        $insertdata['tax_amount'] = $data['tax'];
        $insertdata['tax_percent'] = $data['tax_percent'];
        $insertdata['shipping_cost'] = $data['shipping_cost'];
        $insertdata['address_id'] = $data['address_id']; 
        $insert_id =  DB::table('orders')->insertGetId($insertdata);
        $product_ids = explode('|',$data['product_id']);
        foreach ($product_ids as $key => $value) {
            $cartdata = DB::table('carts')->where('user_id',auth()->user()->id)->where('product_id',$value)->first();
            if($cartdata){
                $productdata = DB::table('products')->where('id',$value)->first();
                DB::table('orders')->where('id',$insert_id)->update(['vendor_id' => $productdata->provider_id]);
                $order_item['order_id'] = $insert_id;
                $order_item['product_id'] = $value;
                $order_item['order_quantity'] = $cartdata->product_quantity;
                $order_item['price'] = $productdata->price;
                $order_item['vendor_id'] = $productdata->provider_id;
                DB::table('order_items')->insert($order_item);
                DB::table('products')->where('id',$value)->update(['quantity' => $productdata->quantity-$cartdata->product_quantity, 'product_sold'=>$cartdata->product_quantity]);
                DB::table('carts')->where('id',$cartdata->id)->delete();
            }
        }
        return $insert_id;
    }




    public function sendPushNotification($device_ids,$data){
        try{
            $url = 'https://fcm.googleapis.com/fcm/send';
            //$api_key = 'AAAAhIb_fs8:APA91bHrj-wviaDTaC4LQW22jeLv0gzoJ9up1yJw-udW7XpyGx1KLFFV6gl0v_rISj7ds2iXntSmDrxhq_awBFiBNqhPukEiumceujRmjnIRQ1g9nFiVo1QNq0VGnEVJYxvECt8bWR5Y';
            $api_key = 'AAAAcTNzVWI:APA91bGERPJRVoSXk8Pfd7y2lq2Gcc3s_FlBCD1z8zgiw8yO7KtvfS2cVuW79zqWKXV3_zuNrJ2dEL0UM5uZKBR1p_zGJEhiKFeAFt8ej0iuAGJ0P28LG_CnTERNa38Pyoz2G50MiU8e';
            $count = 1;
            $fields  = array(
                'registration_ids' => $device_ids,
                'data' => array (
                 //  'title' => $message['title'],
                    'title' => $data['title'],
                    "message" =>$data['message'],
                    "notification_type" => "show notification",
                    "notification_message_type" => '1'
                ),
                'notification' => array(
                    'title' => $data['title'],
                    'body'  => $data['body'],
                    'sound' => 'default',
                    'badge' =>  1
                ),
                'priority' => 'high'
            );

            //header includes Content type and api key
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key='.$api_key
            );


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);

            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
          return $result;
        }catch(Exception $e){
         echo 'Message: ' .$e->getMessage();
        }
    }

    public function statusType($id){
        switch ($id) {
            case "1":
              $status = "Active";
              break;
            default:
              $status = "InActive";
          }
          return $status;
    } 
    
    public function pageType($id){
        switch ($id) {
            case "1":
              $status = "Term And Condition";
              break;
            case "2":
              $status = "Privacy Policy";
              break;
            default:
              $status = "Any";
          }
          return $status;
    } 

    public function removeToken($id)
    {
        $data = DB::table('oauth_access_tokens')->where('user_id',$id)->delete();
        return $data;
    }

    public function curlPost($url,$data){
        $jsondata = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$jsondata,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.getenv('SECRET_KEY'),
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function curlGet($txid){
        //$jsondata = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.getenv('SECRET_KEY'),
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function sendMailApi($data="") {
        $mail = new PHPMailer(true);
        try {
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             
            $mail->SMTPAuth = true;
            //$mail->Username = 'developersiapp@gmail.com';
            $mail->Username = 'test52352@gmail.com';
            //$mail->Password = 'R4knixj8FLTi13';
            $mail->Password = 'rguoiakhvnhxeuxh';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('developersiapp@gmail.com', 'sheba-music');
            $mail->addAddress($data['email']);
            $mail->addReplyTo('developersiapp@gmail.com', 'sheba-music');
            $mail->isHTML(true);
            $mail->Subject = $data['subject'];
            $mail->Body    = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="HandheldFriendly" content="true" />
                    <meta name="MobileOptimized" content="320" />
                    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no" />
                    <title>CyndicaLabs</title>
                    <link rel="icon" type="image/png" href="images/fav.png">
                <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet"> </head>
                <body style="background-color:#eff2f7;
                             font-family: Roboto, sans-serif;
                             padding:0;
                             margin:0;
                             font-weight: normal;
                             font-size: 15px;
                             color: #2e2e2e;
                             line-height: 1.6em;
                             vertical-align:middle;
                             padding:20px;">
                    <table style="width:100%;
                                  max-width:505px;
                                  margin:0px auto;
                                  background-color:#fff;
                                  border-collapse: collapse;
                                  box-sizing: border-box;
                                  display:block;
                                  padding:30px;
                                  border-radius:5px;
                                  text-align:left;">
                            <thead style="display:block">
                            <tr  style="display:block">
                                <th colspan="1"
                                    style="font-weight: normal;
                                           text-align:left;
                                           display:block">
                                    <img style="width:235px;
                                                margin:10px auto 30px;"
                                         src="lab_logo.png";
                                        />
                                </th>
                            </tr>
                            </thead>
                            <tbody  style="display:block">
                            <tr  style="display:block">
                                <td colspan="1"
                                    style="font-weight: normal;
                                           display:block">
                                           <p style="font-size: 15px;
                                               margin:0 0 20px;
                                               font-weight: normal;
                                               text-align:left;"><span >title :</span><span style="margin-left:15px;">'.$data['title'].'</span>
                                    </p>
                                    <h5 style="font-size: 15px;
                                margin:0 0 20px;
                                               text-align:left;
                                               ">OTP:<span style="margin-left:15px;">'.$data['otp'].'</span>
                                    </h5>

                                </td>
                            </tr>
                            </thead>
                    </table>
                </body>
                </html>';
            return $mail->send();
        } catch (Exception $e) {
             return back()->with('error','Message could not be sent.');
        }
    }

     public function sendMailWeb($data="") {
        $mail = new PHPMailer(true);
        try {
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             
            $mail->SMTPAuth = true;
            //$mail->Username = 'developersiapp@gmail.com';
            $mail->Username = 'test52352@gmail.com';
            //$mail->Password = 'R4knixj8FLTi13';
            $mail->Password = 'rguoiakhvnhxeuxh';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('developersiapp@gmail.com', 'sheba-music');
            $mail->addAddress($data['email']);
            $mail->addReplyTo('developersiapp@gmail.com', 'sheba-music');
            $mail->isHTML(true);
            $mail->Subject = $data['subject'];
                    $mail->Body    = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="HandheldFriendly" content="true" />
                    <meta name="MobileOptimized" content="320" />
                    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no" />
                    <title>CyndicaLabs</title>
                    <link rel="icon" type="image/png" href="images/fav.png">
                <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet"> </head>
                <body style="background-color:#eff2f7;
                             font-family: Roboto, sans-serif;
                             padding:0;
                             margin:0;
                             font-weight: normal;
                             font-size: 15px;
                             color: #2e2e2e;
                             line-height: 1.6em;
                             vertical-align:middle;
                             padding:20px;">
                    <table style="width:100%;
                                  max-width:505px;
                                  margin:0px auto;
                                  background-color:#fff;
                                  border-collapse: collapse;
                                  box-sizing: border-box;
                                  display:block;
                                  padding:30px;
                                  border-radius:5px;
                                  text-align:left;">
                            <thead style="display:block">
                            <tr  style="display:block">
                                <th colspan="1"
                                    style="font-weight: normal;
                                           text-align:left;
                                           display:block">
                                    <img style="width:235px;
                                                margin:10px auto 30px;"
                                         src="lab_logo.png";
                                        />
                                </th>
                            </tr>
                            </thead>
                            <tbody  style="display:block">
                            <tr  style="display:block">
                               <h3>Sheba Music</h3>
                                <td colspan="1"
                                    style="font-weight: normal;
                                           display:block">
                                           <p style="font-size: 15px;
                                               margin:0 0 20px;
                                               font-weight: normal;
                                               text-align:left;"><span >title :</span><span style="margin-left:15px;">'.$data['title'].'</span>
                                    </p>
                                    <h5 style="font-size: 15px;
                                margin:0 0 20px;
                                               text-align:left;
                                               "><a class="btn btn-warning" href = "'.$data['link'].'">click here</span>
                                    </h5>

                                </td>
                            </tr>
                            </thead>
                    </table>
                </body>
                </html>';
            return $mail->send();
        } catch (Exception $e) {
             return back()->with('error','Message could not be sent.');
        }
    }


}