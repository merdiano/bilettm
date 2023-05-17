<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\EventResource;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\LocationResource;
use App\Models\Event;

class CategoryController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v2/categories",
    *      tags={"Category"},
    *      summary="Get categories",
    *      description="Get list of categories",
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function categories(){
        $categories = Category::select('title_tk','title_ru','id','parent_id')->main()->get();
        return CategoryResource::collection($categories)->additional(['success' => true]);
    }

    /**
    * @OA\Get(
    *      path="/api/v2/category/{category_id}/events",
    *      tags={"Category"},
    *      summary="Category events and locations",
    *      description="Get events and categories of given id",
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
    *          description="category_id",
    *          in="path",
    *          name="category_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="1", summary="1"),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function categoryEvents($category_id, Request $request){
        $data = Event::where('category_id', $category_id)->with('ticket_dates')->paginate($request->per_page ?? 10);

        return EventResource::collection($data)->additional(['success' => true]);
    }

    private function sorts_filters($request){
        $data['start'] = $request->get('start') ?? Carbon::today();
        $data['end'] = $request->get('end')?? Carbon::today()->endOfCentury();
        $sort = $request->get('sort');

        if($sort == 'new')
            $orderBy = ['field'=>'created_at','order'=>'desc'];
        if ($sort =='popular')
            $orderBy = ['field'=>'views','order'=>'desc'];
        else
        {
            $orderBy =['field'=>'start_date','order'=>'asc'];
            $sort = 'start_date';
        }
        $data['sort'] = $sort;
        //todo check date formats;
        return [$orderBy, $data];
    }

    /**
    * @OA\Get(
    *      path="/api/v2/category/{category_id}/locations",
    *      tags={"Category"},
    *      summary="Get locations of category",
    *      description="Get list of locations of category",
    *      @OA\Parameter(
    *          description="Category id to search for locations",
    *          in="path",
    *          name="category_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="1", summary="1"),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function locations($category_id){
        $locations = Category::select('title_tk','title_ru','id','parent_id')->where('parent_id', $category_id)->get();
        return CategoryResource::collection($locations)->additional(['success' => true]);
    }
}
