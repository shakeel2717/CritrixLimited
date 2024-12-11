<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Number;

class PlanActivatedNotification extends Notification implements ShouldQueue
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
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hello, {$this->transaction->user->name}!")
            ->subject($this->transaction->plan->name . ' Plan of ' . Number::currency($this->transaction->plan->price) . ' Activated Successfully!')
            ->line("We're excited that you have Activated {$this->transaction->plan->name} Plan of " . Number::currency($this->transaction->plan->price))
            ->line("If you need any assistance, feel free to reach out!")
            ->action('Visit ' . config('app.name'), url('/'))
            ->line('Thank you for joining us!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->transaction->user->id,
            'title' => 'New Plan Activated',
            'message' => $this->transaction->plan->name . ' Plan Activated Successfully!',
        ];
    }
}
