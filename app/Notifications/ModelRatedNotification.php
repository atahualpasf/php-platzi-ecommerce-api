<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModelRatedNotification extends Notification
{
    use Queueable;

    private string $qualifiableName;
    private string $productName;
    private float $score;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        string $qualifiableName,
        string $productName,
        float $score
    )
    {
        $this->qualifiableName = $qualifiableName;
        $this->productName = $productName;
        $this->score = $score;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("{$this->qualifiableName} ha calificado tu producto {$this->productName} con {$this->score}
            estrellas");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
