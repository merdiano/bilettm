<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function getCategories($parent_id = false){
        $categories = Category::select('title_tk','title_ru','id','parent_id');

        if($parent_id)
            $categories->children($parent_id);
        else
            $categories->main();
        return response()->json(['categories' => $categories->get()]);
//        return $categories->get();
    }

    public function getEvents($cat_id = null, Request $request){
        $date = $request->get('date');
        //$cat_id = $request->get('cat_id');

        $e_query = Event::onLive();
        if(!empty($cat_id)){
            $category = Category::findOrFail($cat_id);

            if($category->parent_id > 0){
                $e_query->where('sub_category_id',$category->id);
            }
            else{
                $e_query->where('category_id',$category->id);
            }
        }
        if(!empty($date)){
            $e_query->whereDate('start_date','>=',Carbon::parse($date));
        }

        return $e_query->select('id','title','start_date')
            ->onLive()
            ->paginate(8);
    }

    public function getEvent($id){
        $event = Event::with('images')->findOrFail($id);
        return $event;
    }
}
