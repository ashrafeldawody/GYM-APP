<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use app\Models\User;

//this notification is not currently being used
class WelcomeMailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $member;
    public $options;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $member, $options = null)
    {
        $this->member = $member;
        $this->options = $options;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->view('email.welcome_message')->with([
                    'options' => $this->options
                ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
