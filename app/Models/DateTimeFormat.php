<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

    /*
      Attendize.com   - Event Management & Ticketing
     */

/**
 * Description of DateTimeFormat.
 *
 * @author Dave
 */
class DateTimeFormat extends \Illuminate\Database\Eloquent\Model
{
    use CrudTrait;
    /**
     * Indicates whether the model should be timestamped.
     *
     * @var bool $timestamps
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string $table
     */
    protected $table = 'datetime_formats';
    /**
     * Indicates whether the model should use soft deletes.
     *
     * @var bool $softDelete
     */
    protected $softDelete = false;
}
