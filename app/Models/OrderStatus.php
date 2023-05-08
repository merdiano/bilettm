<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

    /*
      Attendize.com   - Event Management & Ticketing
     */

/**
 * Description of OrderStatus.
 *
 * @author Dave
 */
class OrderStatus extends \Illuminate\Database\Eloquent\Model
{
    use CrudTrait;
    public $timestamps = false;
}
