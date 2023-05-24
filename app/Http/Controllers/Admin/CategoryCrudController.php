<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Category');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/category');
        $this->crud->setEntityNameStrings('category', 'categories');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements 
        $this->crud->set('reorder.label', 'title_tk');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 2);
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            ['name'=>'id','type'=>'text','label'=>'Id'],
            ['name'=>'title','type'=>'text','label'=>'Title en'],
            ['name'=>'title_tk','type'=>'text','label'=>'Title tm'],
            ['name'=>'title_ru','type'=>'text','label'=>'Title ru'],
            ['name'=>'view_type','type'=>'text','label'=>'View Type'],
            ['name'=>'events_limit','type'=>'text','label'=>'Event limit'],
            ['name'=>'parent_id','type'=>'text','label'=>'Parent'],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);

        $this->crud->addFields([
            ['name'=>'title','type'=>'text','label'=>'Title em'],
            ['name'=>'title_tk','type'=>'text','label'=>'Title tm'],
            ['name'=>'title_ru','type'=>'text','label'=>'Title ru'],
            ['name'=>'view_type','type' =>'enum', 'label'=>'View Type'],
            ['name'=>'events_limit','type'=>'number','label'=>'Event limit'],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
