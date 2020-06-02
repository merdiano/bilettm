<?php

namespace App\Notifications;

use App\Models\BackpackUser;
use App\Models\HelpTicketComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class TicketCommented extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $comment;

    public $tries = 2;

    public function __construct(HelpTicketComment $comment)
    {
        $this->comment = $comment;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        try{
            if($notifiable instanceof BackpackUser){
                return (new MailMessage)
                    ->line('New comment on ticket №'.$this->comment->ticket->code)
                    ->line($this->comment->text)
                    ->line($this->comment->created_at)
                    ->action('Reply here', route('ticket.replay',['id'=>$this->comment->help_ticket_id]));

            }
            else
                return (new MailMessage)
                    ->view('Emails.Help.CommentNotification',['comment' => $this->comment]);
        }
        catch (\Exception $ex){
            Log::error($ex);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->comment->toArray();
    }
}
