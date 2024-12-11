<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendKycRejectNotification extends Notification
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
            ->subject('KYC Application Status Update – Action Required!')
            ->line('Thank you for submitting your KYC (Know Your Customer) application. After a thorough review, we regret to inform you that your application has not been approved at this time.')
            ->line('Review and resubmit the required documents. Ensure all documents are clear, legible, and up-to-date.')
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
            'message' => 'Your KYC Application Has Been Rejected!',
        ];
    }
}
