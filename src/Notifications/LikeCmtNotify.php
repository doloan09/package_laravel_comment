<?php

namespace Doloan09\Comments\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class LikeCmtNotify extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $user;
    public string $slug_article;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, string $slug_article)
    {
        $this->user = $user;
        $this->slug_article = $slug_article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'user_id' => $this->user->id,
            'user_name' =>$this->user->name,
            'slug' => $this->slug_article,
            'avatar' => $this->user->avatar
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        $list_notify = \App\Models\Notification::query()->where('notifiable_id', $notifiable->id)->where('read_at', null)->get();
        $sum = count($list_notify);

        return new BroadcastMessage([
            'id_user' => $this->user->id,
            'username' => $this->user->name,
            'message' => "$this->user (User $notifiable->id)",
            'slug' => $this->slug_article,
            'avatar' => $this->user->avatar,
            'time' => Carbon::now()->diffForHumans(),
            'sum' => $sum
        ]);
    }
}
