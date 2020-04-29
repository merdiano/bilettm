<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\HelpTicketCategoryRequest as StoreRequest;
use App\Http\Requests\HelpTicketCategoryRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class HelpTicletCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class HelpTicketCategoryCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\HelpTicketCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/helpTicketCategory');
        $this->crud->setEntityNameStrings('help ticket category', 'help ticket categories');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();
        $this->crud->setColumns([
            ['name' => 'title_tk','label'=>'Title Turkmen','type'=>'text'],
            ['name' => 'title_ru','label'=>'Title Russioan','type'=>'text'],
            ['name' => 'active', 'label' => 'Active', 'type' => 'check']
        ]);

        $this->crud->addFields([
            ['name' => 'title_tk','label'=>'Title Turkmen','type'=>'text'],
            ['name' => 'title_ru','label'=>'Title Russioan','type'=>'text'],
            ['name' => 'active', 'label' => 'Active', 'type' => 'checkbox']
        ]);
        // add asterisk for fields that are required in HelpTicletCategoryRequest
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
