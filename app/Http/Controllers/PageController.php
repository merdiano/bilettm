<?php


namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
use Illuminate\Support\Facades\Config;
class PageController extends Controller
{
    public function index($slug, $subs = null)
    {
        $page = Page::findBySlug($slug.'_'.Config::get('app.locale'));

        if (!$page)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $data['title'] = $page->title;
        $data['page'] = $page->content;

        return $this->render('Pages.AboutPage', $data);
    }

}
