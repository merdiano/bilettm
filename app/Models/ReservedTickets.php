<?php

namespace App\Models;

    /*
      Attendize.com   - Event Management & Ticketing
     */

/**
 * Description of ReservedTickets.
 *
 * @author Dave
 */
class ReservedTickets extends \Illuminate\Database\Eloquent\Model
{
    protected $dates = ['expects_payment_at'];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
