<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin_reply)
    {
        $this->admin_reply = $admin_reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.contactUs')
        ->from('admin@yopmail.com', 'AfriDish')
        ->subject('Reply from AfriDish')
        ->replyTo('admin@yopmail.com', 'AfriDish');
    }
}
