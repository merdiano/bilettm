<?php

namespace App\Notifications;

use App\Models\HelpTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class TicketReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    /**
     * The maximum number of exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    protected $ticket;

    public function __construct(HelpTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable instanceof HelpTicket ? ['mail'] : ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Log::info($notifiable);
        try{
            if($notifiable instanceof HelpTicket){
                return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->line($this->ticket->text)
                    ->line($this->ticket->created_at)
                    ->action('Notification Action', route('help.show',['code' => $this->ticket->code]))
                    ->line('Thank you for using our application!');
            }
            else
                return (new MailMessage)
                    ->line('You have new ticket')
                    ->line($this->ticket->text)
                    ->line($this->ticket->created_at)
                    ->action('Notification Action', route('ticket.replay',['id'=>$this->ticket->id]))
                    ->line('Thank you for using our application!');


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
        return $this->ticket->toArray();
    }
}
