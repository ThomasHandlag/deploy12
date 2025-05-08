<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use App\Mail\VerifyMail;
use App\Models\VerifyCode;
use Illuminate\Notifications\Messages\MailMessage;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Mail;

class VerifyCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        
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
        dd($notifiable);
        $otpCode = Random::generate(6, '0-9');

        // Store the new OTP
        VerifyCode::create([
            'user_id' => $notifiable->id,
            'code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(1), // OTP expires in 10 minutes
        ]);
       
        // return (new VerifyMail($otpCode))
        //     ->to($notifiable->email);

        Mail::to($request->user()->email)->send(new VerifyMail($otpCode));

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->action('Verify Email', url('/verify-email-otp'))
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
