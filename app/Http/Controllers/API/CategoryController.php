<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

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
}
