<?php

namespace App\Models;

    /*
      Attendize.com   - Event Management & Ticketing
     */

/**
 * Description of OrderItems.
 *
 * @author Dave
 */
class OrderItem extends MyBaseModel
{
//    use \Backpack\CRUD\CrudTrait;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool $timestamps
     */
    public $timestamps = false;
    protected $fillable = ['title','order_id','quantity','unit_price','unit_booking_fee'];
}
