<?php


namespace App\Http\Controllers\Admin;


use App\Http\Requests\AccountRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\AccountRequest as StoreRequest;

class OrganiserCrudController extends CrudController
{
    public function setup(){
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Organiser');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/organiser');
        $this->crud->setEntityNameStrings('organiser', 'organisers');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
//        $this->crud->setFromDb();
        $this->crud->setColumns([
            [
                'name'  => 'account_id',
                'label' => 'Account',
                'type'  => 'select',
                'entity'=> 'account',
                'attribute'=>'email'
            ],
            [
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text'
            ],
            [
                'name'  => 'about',
                'label' => 'About',
                'type'  => 'text'
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ]
        ]);
        $this->crud->addFields([
            [
                'name'  => 'account_id',
                'label' => 'Account',
                'type'  => 'select',
                'entity'=> 'account',
                'attribute'=>'email'
            ],
            [
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text'
            ],
            [
                'name'  => 'about',
                'label' => 'About',
                'type'  => 'textarea'
            ],
            [
                'name'  => 'phone',
                'label' => 'Phone',
                'type'  => 'text'
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ]
        ]);
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
//        dd($redirect_location);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
