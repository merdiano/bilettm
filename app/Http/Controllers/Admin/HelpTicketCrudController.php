<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\HelpTicketRequest as StoreRequest;
use App\Http\Requests\HelpTicketRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

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
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
}
