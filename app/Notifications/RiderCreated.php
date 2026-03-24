<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RiderCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $loginUrl = url('/login');

        return (new MailMessage)
            ->subject('Your Rider Account')
            ->greeting('Hello ' . $notifiable->name)
            ->line('An account has been created for you at Anique Logistics.')
            ->line('Email: ' . $notifiable->email)
            ->line('Password: ' . $this->password)
            ->action('Login', $loginUrl)
            ->line('Please change your password after logging in.');
    }
}
