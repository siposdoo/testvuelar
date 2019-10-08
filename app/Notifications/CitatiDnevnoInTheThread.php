<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CitatiDnevnoInTheThread extends Notification
{
    use Queueable;
    
    protected $subscriber;
    protected $citat;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $citat,$subscriber)
    {
        $this->subscriber = $subscriber;
        $this->citat = $citat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->citat->count() > 0){
            return ['mail', 'database'];
        }
        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        
        return (new MailMessage)->markdown('mails.citats-dayly',[
            'citat' => $this->citat,
            'subscriber' => $this->subscriber
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
