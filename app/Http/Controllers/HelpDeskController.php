<?php


namespace App\Http\Controllers;


use App\Http\Requests\HelpTicketCommentRequest;
use App\Http\Requests\HelpTicketRequest;
use App\Models\BackpackUser;
use App\Models\HelpTicket;
use App\Models\HelpTicketComment;
use App\Models\User;
use App\Notifications\TicketCommented;
use App\Notifications\TicketReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class HelpDeskController extends Controller
{

    public function show($code){

        $ticket = HelpTicket::with('comments')
            ->where('code',$code)
            ->first();
        if(!$ticket)
            abort(404);

        return $this->render('Pages.HelpDeskTicket',['ticket' => $ticket]);
    }

    /**
     *  Show the form for creating the help desk ticket
     */
    public function create(){

        return $this->render('Pages.HelpDeskCreateForm');
    }

    public function store(HelpTicketRequest $request){

        try{
            $ticket = new HelpTicket([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'text' => $request->get('text'),
                'phone' => $request->get('phone'),
                'subject' => $request->get('subject'),
                'attachment' => $request->file('attachment')
            ]);

            if($request->get('topic'))
                $ticket->ticket_category_id = $request->get('topic');

            $ticket->save();

            /**
             * Notify customer that ticket is received;
             */
            $ticket->notify(new TicketReceived($ticket));

            $this->notifyAdministrators(new TicketReceived($ticket))   ;

            return redirect()->route('help.show',['code' => $ticket->code]);
        }
        catch (\Exception $exception){
            Log::error($exception);
            session()->flash(['error' => $exception->getMessage()]);
            return redirect()->back();
        }

    }

    /**
     * Notify administrators that ticket is arrived;
     */
    private function notifyAdministrators(\Illuminate\Notifications\Notification $notification){

        $administrators = BackpackUser::where('is_admin',1)->get(['id','email']);

        Notification::send($administrators, $notification);
    }

    public function comment(HelpTicketCommentRequest $request,$code){

        $ticket = HelpTicket::select('id','name','email')
            ->where('code',$code)
            ->first();

        if(!$ticket)
            abort(404);

        $comment =  HelpTicketComment::create([
            'text' => $request->text,
            'help_ticket_id' => $ticket->id,
            'attachment' => $request->file('attachment'),
            'name' => $ticket->owner,
        ]);

        $ticket->update(['status' => 'pending']) ;

        $this->notifyAdministrators(new TicketCommented($comment));

        return redirect()->route('help.show',['code' => $code]);

    }
}
