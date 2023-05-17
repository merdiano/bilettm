<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Category;
use App\Models\Event;

class LocationController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v2/location/{location_id}/events",
    *      tags={"Location"},
    *      summary="Get events of location",
    *      description="Get events of location",
    *      @OA\Parameter(
    *          description="Location id",
    *          in="path",
    *          name="location_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="2", summary="2"),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *      ),
    *  )
    */
    public function locationEvents($location_id){
        $events = Event::with(['ticket_dates','venue:id,venue_name_tk,venue_name_ru,address'])->where('sub_category_id', $location_id)->paginate(10);
        return EventResource::collection($events)->additional(['success' => true]);
    }
}
