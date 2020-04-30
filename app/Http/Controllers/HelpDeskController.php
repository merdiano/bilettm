<?php


namespace App\Http\Controllers;


use App\Models\HelpTicketCategory;

class HelpDeskController extends Controller
{

    public function show(){

    }

    /**
     *  Show the form for creating the help desk ticket
     */
    public function create(){

        $categories = HelpTicketCategory::where('active',1)
            ->select(['id','title_'.config('app.locale').' as title'])
            ->orderBy('position','asc')
            ->pluck('title','id');
//        dump($categories);

        return $this->render('Pages.HelpDeskCreateForm',$categories);
    }

    public function store(){

    }

    public function comment(){

    }
}
