<?php

namespace Owaslo\OtpAuthentication\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Owaslo\Textit\TextitMessage;

class VerifyPhone extends Notification
{
    use Queueable;

    /**
     * The password token.
     *
     * @var string
     */
    private $otp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        $this->token = $otp;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['textit'];
    }

    /**
     * Build the text representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toTextit($notifiable)
    {
        return (new TextitMessage($notifiable->getPhoneForVerification(), 'OTP: '.$this->token.', Please use the above OTP to sign in.'));
    }
}
