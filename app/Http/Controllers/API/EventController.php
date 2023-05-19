<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v2/event/{id}/details",
    *      tags={"Events"},
    *      summary="Get event details",
    *      description="Get event details by it's ID",
    *      @OA\Parameter(
    *          description="Pass event's id here",
    *          in="path",
    *          name="id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="421", summary="421"),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function eventDetailById($id){
        //todo handle if not found
        $event = Event::with(['ticket_dates','venue:id,venue_name_tk,venue_name_ru,address'])->withViews()->onLive()->find($id);
        return EventResource::make($event);
    }

    /**
    * @OA\Get(
    *      path="/api/v2/event/{id}/seats",
    *      tags={"Events"},
    *      summary="Get event seats",
    *      description="Get event seats by it's ID",
    *      @OA\Parameter(
    *          description="Pass event's id here",
    *          in="path",
    *          name="id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="421", summary="421"),
    *      ),
    *      @OA\Parameter(
    *          description="Parameter ticket_date",
    *          in="query",
    *          name="ticket_date",
    *          required=true,
    *          @OA\Schema(type="string"),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function eventSeatsById(Request $request, $id){
        $this->validate($request, [ 'ticket_date' => 'required|date' ]);
        $event = Event::with('venue:id,venue_name,seats_image,address,venue_name_ru,venue_name_tk')->withViews()->findOrFail($id,['id','venue_id']);

        $tickets = Ticket::WithSection($id, $request->get('ticket_date'))
            ->where('end_sale_date','>',Carbon::now())
            ->where('start_sale_date','<',Carbon::now())
            ->where('is_hidden', false)
            ->where('is_paused', false)
            ->orderBy('sort_order','asc')
            ->get();

        if($tickets->count()==0)
            return response()->json([
               'status' => 'error',
               'message' => 'There is no tickets available'
            ]);

        return response()->json([
            'status' => 'success',
            'venue' => $event->venue,
            'tickets' => $tickets
        ]);

        //return EventResource::make($event);
    }
}
