<?php


namespace App\Http\Controllers;


use App\Http\Requests\HelpTicketCommentRequest;
use App\Http\Requests\HelpTicketRequest;
use App\Models\HelpTicket;
use App\Models\HelpTicketComment;
use App\Models\HelpTopic;
use Illuminate\Support\Facades\Log;

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
//
//        try{

            $ticekt = HelpTicket::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'text' => $request->get('text'),
                'phone' => $request->get('phone'),
                'subject' => $request->get('subject'),
                'ticket_category_id' => $request->get('topic'),
                'attachment' => $request->get('attachment')
            ]);
//        }
//        catch (\Exception $exception){
//            Log::error($exception);
//        }
        //todo fire event notify admin by mail, attachment

        return redirect()->route('help.show',['code' => $ticekt->code]);
    }

    public function comment(HelpTicketCommentRequest $request,$code){

        $ticket = HelpTicket::select('id')
            ->where('code',$code)
            ->first();

        if(!$ticket)
            abort(404);

        $comment =  HelpTicketComment::create([
            'text' => $request->text,
            'help_ticket_id' => $ticket->id
        ]);

        $ticket->update(['status' => 'pending']) ;

        if($request->has('attachment')){

        }

        //todo notify, attachment

        return redirect()->route('help.show',['code' => $code]);

    }
}
