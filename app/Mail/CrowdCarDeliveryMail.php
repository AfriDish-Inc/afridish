<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CrowdCarDeliveryMail extends Mailable
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
        return $this->view('mail.deliveryCrowdCar')->from('admin@yopamil.com', 'puffie')
        ->subject($this->mailData['mailSubject'])
        ->replyTo( $this->mailData['toEmail'], 'puffie Customer')->with([
            'mailContent' => $this->mailData['mailContent'],
          ]);
    }
}
