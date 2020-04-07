<?php


namespace App\Http\Controllers\Admin;


use App\Http\Requests\AccountRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\AccountRequest as StoreRequest;
/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AccountCrudController extends CrudController
{

    public function setup(){
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Account');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/account');
        $this->crud->setEntityNameStrings('account', 'accounts');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
//        $this->crud->setFromDb();
        $this->crud->setColumns([
            [
                'name'  => 'first_name',
                'label' => 'First Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'last_name',
                'label' => 'Last Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'is_active',
                'label' => 'Is Active',
                'type'  => 'boolean'
            ],
            [
                'name'  => 'is_banned',
                'label' => 'Is Banned',
                'type'  => 'boolean'
            ]
        ]);
        $this->crud->addFields([
            [
                'name'  => 'first_name',
                'label' => 'First Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'last_name',
                'label' => 'Last Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'is_active',
                'label' => 'Is Active',
                'type'  => 'boolean'
            ],
            [
                'name'  => 'is_banned',
                'label' => 'Is Banned',
                'type'  => 'boolean'
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
