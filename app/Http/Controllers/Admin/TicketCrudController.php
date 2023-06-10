<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SectionRequest;
use Backpack\CRUD\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SectionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TicketCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Ticket');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/ticket');
        $this->crud->setEntityNameStrings('ticket', 'tickets');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            ['name' => 'event_id', 'type'=>'select','entity'=>'event','attribute'=>'title_ru','label'=>'Event'],
            ['name'=>'title','type'=>'text','label'=>'Title'],
            ['name'=>'price','type'=>'text','label'=>'Price'],
            ['name' => 'section_id', 'type'=>'select','entity'=>'section','attribute'=>'section_no_ru','label'=>'Section'],
            ['name'=>'ticket_date','type'=>'datetime','label'=>'Data bileta'],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SectionRequest::class);

        $this->crud->addFields([
            ['name' => 'event_id', 'type'=>'select','entity'=>'event','attribute'=>'title_ru','label'=>'Event'],
            ['name'=>'title','type'=>'text','label'=>'Title'],
            ['name'=>'price','type'=>'number','label'=>'Price', 'attributes' => ['step' => '0.01']],
            ['name' => 'section_id', 'type'=>'select','entity'=>'section','attribute'=>'section_no_ru','label'=>'Section'],
            ['name'=>'description','type'=>'text','label'=>'Description'],
            ['name'=>'ticket_date','type'=>'datetime','label'=>'Data bileta'],
            ['name'=>'start_sale_date','type'=>'datetime','label'=>'Nachalo prodazh'],
            ['name'=>'end_sale_date','type'=>'datetime','label'=>'Deadline prodazh'],
            ['name'=>'quantity_available','type'=>'number','label'=>'Kolichestvo'],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
