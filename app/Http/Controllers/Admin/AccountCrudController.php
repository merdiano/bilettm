<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AccountRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AccountCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AccountCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Account::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/account');
        CRUD::setEntityNameStrings('account', 'accounts');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('first_name');
        CRUD::column('last_name');
        CRUD::column('email');
        CRUD::column('timezone_id');
        CRUD::column('date_format_id');
        CRUD::column('datetime_format_id');
        CRUD::column('currency_id');
        CRUD::column('name');
        CRUD::column('last_ip');
        CRUD::column('last_login_date');
        CRUD::column('address1');
        CRUD::column('address2');
        CRUD::column('city');
        CRUD::column('state');
        CRUD::column('postal_code');
        CRUD::column('country_id');
        CRUD::column('email_footer');
        CRUD::column('is_active');
        CRUD::column('is_banned');
        CRUD::column('is_beta');
        CRUD::column('stripe_access_token');
        CRUD::column('stripe_refresh_token');
        CRUD::column('stripe_secret_key');
        CRUD::column('stripe_publishable_key');
        CRUD::column('stripe_data_raw');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AccountRequest::class);

        CRUD::field('first_name');
        CRUD::field('last_name');
        CRUD::field('email');
        CRUD::field('timezone_id');
        CRUD::field('date_format_id');
        CRUD::field('datetime_format_id');
        CRUD::field('currency_id');
        CRUD::field('name');
        CRUD::field('last_ip');
        CRUD::field('last_login_date');
        CRUD::field('address1');
        CRUD::field('address2');
        CRUD::field('city');
        CRUD::field('state');
        CRUD::field('postal_code');
        CRUD::field('country_id');
        CRUD::field('email_footer');
        CRUD::field('is_active');
        CRUD::field('is_banned');
        CRUD::field('is_beta');
        CRUD::field('stripe_access_token');
        CRUD::field('stripe_refresh_token');
        CRUD::field('stripe_secret_key');
        CRUD::field('stripe_publishable_key');
        CRUD::field('stripe_data_raw');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
