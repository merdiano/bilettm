<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SectionRequest as StoreRequest;
use App\Http\Requests\SectionRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class SectionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SectionCrudController extends CrudController
{
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

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();
        $this->crud->addColumns([
            ['name'=>'section_no','type'=>'text','label'=>'Section No'],
            ['name'=>'description','type'=>'text','label'=>'Description'],
        ]);

        $this->crud->addFields([
            ['name'=>'section_no','type'=>'text','label'=>'Section No'],
            ['name'=>'description','type'=>'text','label'=>'Description'],
            ['name' => 'venue_id', 'type'=>'select','entity'=>'venue','attribute'=>'venue_name'],
            [ // image
                'label' => "Section Image",
                'name' => "section_image",
                'type' => 'image',
                'upload' => true,
//                'crop' => true, // set to true to allow cropping, false to disable
//                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                // 'disk' => 's3_bucket', // in case you need to show images from a different disk
                'prefix' => 'user_content/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ],
            ['name'=>'seats','type'=>'table','label'=>'Seats',
                'columns' => [
                    'row' => 'Row',
                    'start_no' => 'Starts at',
                    'end_no' => 'Ends at'
                ]
            ]

        ]);

        // add asterisk for fields that are required in SectionRequest
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
