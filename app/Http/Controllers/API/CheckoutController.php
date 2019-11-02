<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 10/22/2019
 * Time: 15:03
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function postValidateTickets(Request $request, $event_id){
        /*
         * Order expires after X min
         */
        $order_expires_time = Carbon::now()->addMinutes(config('attendize.checkout_timeout_after'));
        $event = Event::findOrFail($event_id);

        $ticket_ids = $request->get('tickets');
    }
}