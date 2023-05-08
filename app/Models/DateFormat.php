<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

    /*
      Attendize.com   - Event Management & Ticketing
     */

/**
 * Description of DateFormat.
 *
 * @author Dave
 */
class DateFormat extends \Illuminate\Database\Eloquent\Model
{
    use CrudTrait;
    /**
     * Indicates whether the model should be timestamped.
     *
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * Indicates whether the model should use soft deletes.
     *
     * @var bool $softDelete
     */
    protected $softDelete = false;
}
