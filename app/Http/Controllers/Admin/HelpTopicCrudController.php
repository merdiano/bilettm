<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\HelpTopicRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class HelpTicletCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class HelpTopicCrudController extends CrudController
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
        $this->crud->setModel('App\Models\HelpTopic');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/helpTopic');
        $this->crud->setEntityNameStrings('help topic', 'help topics');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
    }

    protected function setupListOperation()
    {
        $this->crud->setColumns([
            ['name' => 'position','label'=>'Order Position','type'=>'number'],
            ['name' => 'title_tk','label'=>'Title Turkmen','type'=>'text'],
            ['name' => 'title_ru','label'=>'Title Russian','type'=>'text'],
            ['name' => 'active', 'label' => 'Active', 'type' => 'check']
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(HelpTopicRequest::class);

        $this->crud->addFields([
            ['name' => 'title_tk','label'=>'Title Turkmen','type'=>'text'],
            ['name' => 'title_ru','label'=>'Title Russian','type'=>'text'],
            ['name' => 'position','label'=>'Order Position','type'=>'number'],
            ['name' => 'active', 'label' => 'Active', 'type' => 'checkbox']
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
