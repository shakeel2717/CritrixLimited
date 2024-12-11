<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Number;

class SendTransferFundNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $transaction, public $to, public $from)
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
            ->line('Funds Received ' . Number::currency($this->transaction->amount) . ' from ' . $this->from->username)
            ->subject('You have received a transfer of ' . Number::currency($this->transaction->amount))
            ->line('You just received a transfer of ' . Number::currency($this->transaction->amount) . ' from ' . $this->from->username)
            ->action('Go to Dashboard', url('/'))
            ->line('Thank you for using ' . config('app.name'));
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'user_id' => $this->transaction->user->id,
            'title' => Number::currency($this->transaction->amount) . ' Funds Received',
            'message' => 'You just received a transfer of ' . Number::currency($this->transaction->amount) . ' from ' . $this->from->username,
        ];
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
