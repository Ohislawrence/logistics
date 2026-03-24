<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderAssigned extends Notification
{
    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Delivery Assigned: ' . $this->order->tracking_id)
            ->line('A delivery has been assigned to you.')
            ->line('Tracking ID: ' . $this->order->tracking_id)
            ->action('View Order', url(route('rider.orders.show', $this->order)))
            ->line('Thank you for delivering with us.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'tracking_id' => $this->order->tracking_id,
            'message' => 'Order assigned to you',
        ];
    }
}
