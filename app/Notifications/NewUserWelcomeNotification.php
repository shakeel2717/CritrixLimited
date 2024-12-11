<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserWelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $user)
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hello, {$this->user->name}!")
            ->subject('Welcome to ' . config('app.name'))
            ->line("We're excited to have you join us, {$this->user->name}.")
            ->line("Explore our features and make the most of your experience.")
            ->line("If you need any assistance, feel free to reach out!")
            ->action('Visit ' . config('app.name'), url('/'))
            ->line('Thank you for joining us!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'title' => 'Welcome to ' . config('app.name'),
            'message' => "We're excited to have you join us, {$this->user->name}. Explore our features and make the most of your experience. If you need any assistance, feel free to reach out!",
        ];
    }
}
