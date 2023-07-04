<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.orderPlaced')->from('admin@yopmail.com', 'puffie')
        ->subject('Order placed successfully.')
        ->replyTo( 'test@test.com', 'puffie Customer')->with([
            'userName' => $this->mailData['userName'],
            'orderId' => $this->mailData['orderId'],
            'orderType' => $this->mailData['orderType'],
            'orderDate' => $this->mailData['orderDate'],
            'orderTime' => $this->mailData['orderTime'],
            'taxPercent' => $this->mailData['taxPercent'],
            'taxAmount' => $this->mailData['taxAmount'],
            'shippingCost' => $this->mailData['shippingCost'],
            'orderAmount' => $this->mailData['orderAmount'],
            'storeName' => $this->mailData['storeName'],
            'storeAddress' => $this->mailData['storeAddress'],
            'orderPersonName' => $this->mailData['orderPersonName'],
            'orderDeliveryAddress' => $this->mailData['orderDeliveryAddress'],
            'productsData' => $this->mailData['productsData'],
          ]);
    }
}
