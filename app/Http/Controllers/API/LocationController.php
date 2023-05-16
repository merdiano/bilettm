<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Category;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v2/category/{category_id}/locations",
    *      tags={"Locations"},
    *      summary="Get locations",
    *      description="Get list of locations",
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
        $categories = Category::where('parent_id', $category_id)->select('title_tk','title_ru','id','parent_id')->sub()->get();
        return LocationResource::collection($categories)->additional(['success' => true]);
    }
}
