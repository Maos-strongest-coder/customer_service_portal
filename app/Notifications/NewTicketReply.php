<?php

namespace App\Notifications;

use App\Models\TicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketReply extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public TicketReply $reply)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $ticket = $this->reply->ticket;
        $user = $this->reply->user;

        return (new MailMessage)
            ->subject('New Reply on Ticket #' . $ticket->id)
            ->greeting('Hello ' . $notifiable->full_name . ',')
            ->line($user->full_name . ' replied to ticket: "' . $ticket->title . '".')
            ->action('Show ticket', url('/tickets/' . $ticket->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
