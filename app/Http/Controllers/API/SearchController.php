<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v2/search",
    *      tags={"Search"},
    *      summary="Search events",
    *      description="Search events",
    *      @OA\Parameter(
    *          description="The keyword for search is: key",
    *          in="query",
    *          name="key",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="string", value="herem", summary="a string value"),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function __invoke(Request $request)
    {
        $key = $request->get('key');
        $events = Event::select('id','title_ru','title_tk')
                ->onLive()
                ->where('title_ru','like',"%{$key}%")
                ->orWhere('title_tk','like',"%{$key}%")
                ->paginate(10);
        return EventResource::collection($events)->additional(['success' => true]);
    }
}
