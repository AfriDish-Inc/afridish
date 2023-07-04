<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\FcmToken;

class sendPushNotificationToUser implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $data;
  protected $notification;

  public function __construct($data, $notification)
  {
      $this->data = $data;
      $this->notification = $notification;
  }

  public function handle()
  {
    foreach($this->data['users'] as $user_id)
    {
       $this->notification->user()->attach($user_id);

      // $fcm_token = User::select('firebase_token')->where('user_id', $user_id)->get()->toArray();

        $userDeviceToken = 'dbrkRbJZEkMQkI-XRbSSQJ:APA91bHqoaJyD6WM489lrkjnwrKIqotMpSPLXJdv67WNuJ3hDQxu0qn7KQRE3hQjnhBlRzZNs1uaHz7mAyfDOQ55WNjOYC2OaGEIm6LdZWqwqsTinL10s-KOBWQvZbVj1soke0WlgEkP';
        $NotificationArray= array();                                                     
        $NotificationArray["body"] = $this->data['body'];
        $NotificationArray["title"] = $this->data['title'];
        $NotificationArray["sound"] = "default";
        $NotificationArray["type"] = 1;

        $fields = array(
            'to' => $userDeviceToken,
            'data' => $NotificationArray
        );

        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';
        /*api_key available in: Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
      // $api_key    = env('FCM_API_KEY');
        $api_key    = 'AAAAuVlW47o:APA91bFtknHnAJp1eOyYPSaZOkrkkamzzm4NIgmj-21R0ivbNa-EwWaeE-O-RtXSIFtj_u47Zdqq3K8KlhbNajUqF9UKTiyC9TP4lEJEFDkthqvV20PWMGJ_eKEMB6dW6vH0pfv1wxyJ';
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

        if ($result === FALSE){
          $response['success']        = false;
          $response['status_code']    = '401';
        //return false;
        return $response;
      }else{
          $response['success']        = true;
          $response['status_code']    = '201';
          $response['message']        = "Successfully send.";
        //return true;
        return $response;
      }
        curl_close($ch);
    }
  }

  public function handle2()
  {
      $userDeviceToken = 'dbrkRbJZEkMQkI-XRbSSQJ:APA91bHqoaJyD6WM489lrkjnwrKIqotMpSPLXJdv67WNuJ3hDQxu0qn7KQRE3hQjnhBlRzZNs1uaHz7mAyfDOQ55WNjOYC2OaGEIm6LdZWqwqsTinL10s-KOBWQvZbVj1soke0WlgEkP';
      $NotificationArray= array();                                                     
      $NotificationArray["body"] = $this->data['body'];
      $NotificationArray["title"] = $this->data['title'];
      $NotificationArray["sound"] = "default";
      $NotificationArray["type"] = 1;

      $fields = array(
          'to' => $userDeviceToken,
          'data' => $NotificationArray
      );

      //API URL of FCM
      $url = 'https://fcm.googleapis.com/fcm/send';
      /*api_key available in: Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
    // $api_key    = env('FCM_API_KEY');
      $api_key    = 'AAAAuVlW47o:APA91bFtknHnAJp1eOyYPSaZOkrkkamzzm4NIgmj-21R0ivbNa-EwWaeE-O-RtXSIFtj_u47Zdqq3K8KlhbNajUqF9UKTiyC9TP4lEJEFDkthqvV20PWMGJ_eKEMB6dW6vH0pfv1wxyJ';
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
          return false;
        // die('FCM Send Error: ' . curl_error($ch));
      }
      curl_close($ch);

    //echo "<pre>"; print_r($result);      
      if ($result === FALSE){
          $response['success']        = false;
          $response['status_code']    = '401';
        //return false;
        return $response;
      }else{
          $response['success']        = true;
          $response['status_code']    = '201';
          $response['message']        = "Successfully send.";
        //return true;
        return $response;
      }
  }

  public function getUserFcmToken($user_id)
  {
    $userTokens = FcmToken::select('fcm_token')->where('user_id', $user_id)
                          ->get()->toArray();
                          
    foreach($userTokens as $userToken)
    {
      // $userDeviceToken = 'dFFiPh8T-gKHWjh0SlJQh-:APA91bHCtkDpXogwh0v0tcmTwav-NW2fCsNMl8xNgQOHFPRlT8jYTIPnEVoseL_qD5SZBJsg6Y0Y8kXC-qjSeKrivB7IFZoNnFSScx7WIyNzlTAw3i61p1iyqJPdCYA2Os12GKqvLbWY';
      $userDeviceToken = $userToken;
      $NotificationArray= array();                                                     
      $NotificationArray["body"] = $this->data['body'];
      $NotificationArray["title"] = $this->data['title'];
      $NotificationArray["sound"] = "default";
      $NotificationArray["type"] = 1;

      $fields = array(
          'to' => $userDeviceToken,
          'data' => $NotificationArray
      );

      //API URL of FCM
      $url = 'https://fcm.googleapis.com/fcm/send';
      /*api_key available in: Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
      // $api_key    = env('FCM_API_KEY');
      $api_key    = 'AAAAuVlW47o:APA91bFtknHnAJp1eOyYPSaZOkrkkamzzm4NIgmj-21R0ivbNa-EwWaeE-O-RtXSIFtj_u47Zdqq3K8KlhbNajUqF9UKTiyC9TP4lEJEFDkthqvV20PWMGJ_eKEMB6dW6vH0pfv1wxyJ';
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
          return false;
        // die('FCM Send Error: ' . curl_error($ch));
      }
      curl_close($ch);

      //echo "<pre>"; print_r($result);      
      if ($result === FALSE){
          $response['success']        = false;
          $response['status_code']    = '401';
        //return false;
        return $response;
      }else{
          $response['success']        = true;
          $response['status_code']    = '201';
          $response['message']        = "Successfully send.";
        //return true;
        return $response;
      }
    }
  }
}
