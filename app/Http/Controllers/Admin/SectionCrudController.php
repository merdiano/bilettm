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
class SectionCrudController extends CrudController
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
        $this->crud->setModel('App\Models\Section');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/section');
        $this->crud->setEntityNameStrings('section', 'sections');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
//            ['name'=>'section_no','type'=>'text','label'=>'Section No En'],
            ['name'=>'section_no_ru','type'=>'text','label'=>'Section No Ru'],
            ['name'=>'section_no_tk','type'=>'text','label'=>'Section No Tk'],
            ['name'=>'description','type'=>'text','label'=>'Notes'],
//            ['name'=>'description_ru','type'=>'text','label'=>'Description Ru'],
//            ['name'=>'description_tk','type'=>'text','label'=>'Description Tk'],
            ['name' => 'venue_id', 'type'=>'select','entity'=>'venue','attribute'=>'venue_name_ru','label'=>'Venue'],
            ['name' => 'sector_id', 'type'=>'select','entity'=>'sector','attribute'=>'title_ru','label'=>'Sector'],
        ]);
        CRUD::column('order');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SectionRequest::class);

        $this->crud->addFields([
//            ['name'=>'section_no','type'=>'text','label'=>'Section No'],
            ['name'=>'section_no_ru','type'=>'text','label'=>'Section No Ru'],
            ['name'=>'section_no_tk','type'=>'text','label'=>'Section No Tk'],
            ['name'=>'description','type'=>'textarea','label'=>'Notes'],
//            ['name'=>'description_ru','type'=>'text','label'=>'Description Ru'],
//            ['name'=>'description_tk','type'=>'text','label'=>'Description Tk'],
            ['name' => 'venue_id', 'type'=>'select','entity'=>'venue','attribute'=>'venue_name_ru','label'=>'Venue'],
            ['name' => 'sector_id', 'type'=>'select','entity'=>'sector','attribute'=>'title_ru','label'=>'Sector'],
//            [ // image
//                'label' => "Section Image",
//                'name' => "section_image",
//                'type' => 'image',
//                'upload' => true,
////                'crop' => true, // set to true to allow cropping, false to disable
////                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
//                // 'disk' => 's3_bucket', // in case you need to show images from a different disk
//                'prefix' => 'user_content/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
//            ],
            ['name'=>'seats','type'=>'table','label'=>'Seats',
                'columns' => [
                    'row' => 'Row',
                    'start_no' => 'Starts at',
                    'end_no' => 'Ends at'
                ]
            ]

        ]);
        CRUD::field('order');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
