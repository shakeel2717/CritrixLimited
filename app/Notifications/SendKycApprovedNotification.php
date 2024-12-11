<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendKycApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $kyc)
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
            ->subject('Your KYC Application Has Been Approved!')
            ->line('We are pleased to inform you that your KYC (Know Your Customer) application has been successfully reviewed and approved.')
            ->line('This means that your account is now fully verified, and you can enjoy all the features and benefits of our platform without any restrictions.')
            ->action('Go to Dashboard', url('/'))
            ->line('Thank you for using ' . config('app.name'));
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

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->kyc->user_id,
            'title' => 'Account Verification Updated!',
            'message' => 'Your KYC Application Has Been Approved!',
        ];
    }
}
