<?php


namespace App\Http\Controllers;


use App\Models\HelpTopic;

class HelpDeskController extends Controller
{

    public function show(){

    }

    /**
     *  Show the form for creating the help desk ticket
     */
    public function create(){

        return $this->render('Pages.HelpDeskCreateForm');
    }

    public function store(){

    }

    public function comment(){

    }
}
