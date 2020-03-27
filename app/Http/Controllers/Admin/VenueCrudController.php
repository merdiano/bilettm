<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VenueRequest as StoreRequest;
use App\Http\Requests\VenueRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class VenueCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class VenueCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Venue');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/venue');
        $this->crud->setEntityNameStrings('venue', 'venues');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->addColumns([
//            ['name'=>'venue_name','type'=>'text','label'=>'Venue Name En'],
            ['name'=>'venue_name_ru','type'=>'text','label'=>'Venue Name Ru'],
            ['name'=>'venue_name_tk','type'=>'text','label'=>'Venue Name Tk'],
            ['name'=>'active','type'=>'boolean','label'=>'Active']
        ]);

        $this->crud->addFields([
//            ['name'=>'venue_name','type'=>'text','label'=>'Venue Name En'],
            ['name'=>'venue_name_ru','type'=>'text','label'=>'Venue Name','tab' => 'Russian'],
            ['name'=>'venue_name_tk','type'=>'text','label'=>'Venue Name','tab' => 'Turkmen'],
            ['name'=>'description_ru','type'=>'simplemde','label'=>'Description', 'tab' => 'Russian'],
            ['name'=>'description_tk','type'=>'simplemde','label'=>'Description', 'tab' => 'Turkmen'],
            [   // Address
                'name' => 'address',
                'label' => 'Address',
                'type' => 'address_google',
                // optional
                'store_as_json' => true,
                'tab' => 'General'
            ],
            ['name'=>'images','type'=>'upload_multiple','label'=>'Suratlar',
                'upload' => true, 'disk' => config('filesystems.default'), 'tab' => 'Suratlar'],
            [ // image
                'label' => "Seats Image",
                'name' => "seats_image",
                'type' => 'image',
                'upload' => true,
                'tab' => 'Suratlar',
//                'crop' => true, // set to true to allow cropping, false to disable
//                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                // 'disk' => 's3_bucket', // in case you need to show images from a different disk
                 'prefix' => 'user_content/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ],
            ['name'=>'active','type'=>'checkbox','label'=>'Active','tab' => 'General']
        ]);

        // add asterisk for fields that are required in VenueRequest
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
