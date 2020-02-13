<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Agent;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected function render($view, $data = null){

        $dir = Agent::isDesktop()?'desktop.':'mobile';
        return view($dir.$view, $data);
    }
}
