<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HelpTicketCommentRequest;
use App\Models\HelpTicket;
use App\Models\HelpTicketComment;
use App\Notifications\TicketCommented;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\HelpTicketRequest as StoreRequest;
use App\Http\Requests\HelpTicketRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Notification;

/**
 * Class HelpTicletCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class HelpTicketCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\HelpTicket');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/helpTicket');
        $this->crud->setEntityNameStrings('help ticket', 'help tickets');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        $this->crud->setColumns([
            ['name'=>'code','type'=>'text','label'=>'Code'],
            ['name'=>'name','type'=>'text','label'=>'Name'],
            ['name'=>'phone','type'=>'text','label'=>'Phone'],
            ['name'=>'email','type'=>'email','label'=>'Email'],
            ['name'=>'subject','type'=>'text','label'=>'Subject'],
            ['name'=>'status','type'=>'text','label'=>'Status'],
        ]);
        // add asterisk for fields that are required in HelpTicletRequest
//        $this->crud->setRequiredFields(StoreRequest::class, 'create');
//        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->denyAccess('create');
        $this->crud->denyAccess('update');
        $this->crud->allowAccess('show');
        $this->crud->addButtonFromView('line', 'replay', 'replay', 'beginning');

    }
    public function show($id)
    {
        $content = parent::show($id);

//        $this->crud->addColumn([
//            'name' => 'table',
//            'label' => 'Table',
//            'type' => 'table',
//            'columns' => [
//                'code'  => 'Code',
//                'name'  => 'Name',
//                'phone' => 'Phone',
//            ]
//        ]);

        return $content;
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function replay($id){

        $entry = HelpTicket::with(['comments','topic'])->findOrFail($id);
        return view('admin.HelpDeskTicket')
            ->with('entry',$entry)
            ->with('crud',$this->crud);
    }

    public function replayPost(HelpTicketCommentRequest $request, $ticket_id){
        $ticket = HelpTicket::findOrFail($ticket_id,['id','email','name']);

        $comment = HelpTicketComment::create([
            'help_ticket_id' => $ticket_id,
            'text' => $request->text,
            'name' => auth()->user()->full_name,
            'user_id' => auth()->id()
        ]);

        Notification::route('mail', $ticket->email)
            ->notify(new TicketCommented($comment));

        return redirect()->route('ticket.replay',['id'=>$ticket_id]);
    }
}
