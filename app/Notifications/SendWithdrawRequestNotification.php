<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Number;

class SendWithdrawRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $transaction)
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('New Withdraw Request')
            ->subject('New Withdraw Request')
            ->line('Your withdraw request of ' . Number::currency($this->transaction->amount) . ' has been sent successfully. We will process it as soon as possible.')
            ->action('Go to Dashboard', url('/'))
            ->line('Thank you for using ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'user_id' => $this->transaction->user->id,
            'title' => 'New Withdraw Request',
            'message' => 'Your withdraw request of ' . Number::currency($this->transaction->amount) . ' has been sent successfully.',
        ];
    }
}
