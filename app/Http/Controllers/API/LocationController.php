<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    *          description="page",
    *          in="query",
    *          name="page",
    *          required=false,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="1", summary="1"),
    *      ),
    *      @OA\Parameter(
    *          description="per_page",
    *          in="query",
    *          name="per_page",
    *          required=false,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="1", summary="10"),
    *      ),
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
    public function locationEvents($location_id, Request $request){
        $events = Event::with(['ticket_dates','venue:id,venue_name_tk,venue_name_ru,address'])->onLive()->withViews()->where('sub_category_id', $location_id)->paginate($request->per_page ?? 10);
        return EventResource::collection($events)->additional(['success' => true]);
    }
}
