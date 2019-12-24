<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SliderRequest as StoreRequest;
use App\Http\Requests\SliderRequest as UpdateRequest;

/**
 * Class SliderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SliderCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Slider');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/slider');
        $this->crud->setEntityNameStrings('slider', 'sliders');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->addColumns([
            ['name' => 'title','type' => 'text', 'label' => 'Title En'],
            ['name' => 'title_ru','type' => 'text', 'label' => 'Title Ru'],
            ['name' => 'title_tk','type' => 'text', 'label' => 'Title Tk'],
            ['name' => 'text','type' => 'text', 'label' => 'Text En'],
            ['name' => 'text_ru','type' => 'text', 'label' => 'Text Ru'],
            ['name' => 'text_tk','type' => 'text', 'label' => 'Text Tk'],
            ['name' => 'link','type' => 'text', 'label' => 'Link'],
            ['name' => 'active','type' => 'boolean', 'label' => 'Active'],
            ['name' => 'image','type' => 'text', 'label' => 'Image'],
        ]);
        $this->crud->addFields([
            ['name' => 'title','type' => 'text', 'label' => 'Title'],
            ['name' => 'text','type' => 'text', 'label' => 'Text'],
            ['name' => 'link','type' => 'text', 'label' => 'Link'],
            ['name' => 'active','type' => 'checkbox', 'label' => 'Active'],
            [ // image
                'label' => "Image",
                'name' => "image",
                'type' => 'image',
                'upload' => true,
                //'crop' => true, // set to true to allow cropping, false to disable
                //'aspect_ratio' => 2, // ommit or set to 0 to allow any aspect ratio
                //'disk' => 'local', // in case you need to show images from a different disk
//                'prefix' => 'user_content/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ],

        ]);

        // add asterisk for fields that are required in SliderRequest
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
