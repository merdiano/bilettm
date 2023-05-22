<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SubscriberRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubscriberCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubscriberCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Subscriber');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subscriber');
        $this->crud->setEntityNameStrings('subscriber', 'subscribers');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
    }

    protected function setupListOperation()
    {
        $this->crud->setColumns([
            [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Email'
            ] ,
             [
                 'name' => 'active',
                 'type' => 'boolean',
                 'label' => 'Active'
             ]
         ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubscriberRequest::class);

        $this->crud->addFields([
            [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Email'
            ] ,
            [
                'name' => 'active',
                'type' => 'checkbox',
                'label' => 'Active'
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
