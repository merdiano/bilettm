<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use App\Models\Event;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
    * @OA\Info(
    *     version="2.0.0",
    *     title="Bilettm API"
    * )
    */
    /**
    * @OA\Get(
    *      path="/api/v2/home",
    *      tags={"Home"},
    *      summary="Home API",
    *      description="Get home elements: sliders, live events",
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function __invoke(Request $request)
    {
        // dd(Event::with('ticket_dates')
        // ->onLive()->withViews()
        // ->paginate(20));
       $slider = Slider::where('active',true)
           ->select('id','title_ru','title_tk','image','order')
           ->orderBy('order')
           ->get();

       return HomeResource::make(
            $slider,
            Event::with('ticket_dates')
                ->onLive()->withViews()
                ->paginate(20)
            )->additional(['success' => true]);
    }
}
