<?php

namespace App\Notifications;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInquiry extends Notification implements ShouldQueue
{
    use Queueable;

    protected $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $productName = $this->inquiry->product->name ?? 'your menu';

        return (new MailMessage)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('You have a new order request on AfriDish, about '.$productName.'.')
            ->line('From: '.$this->inquiry->user->name.' ('.$this->inquiry->phone.')')
            ->line('Message: '.$this->inquiry->message)
            ->when($this->inquiry->requested_date, function ($mail) {
                return $mail->line('Requested for: '.$this->inquiry->requested_date->format('M j, Y'));
            })
            ->action('View in your dashboard', url('/vendor/inquiries'))
            ->line('Reach out to them directly to arrange the order.');
    }
}
