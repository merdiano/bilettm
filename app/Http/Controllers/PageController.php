<?php


namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
class PageController extends Controller
{
    public function index($slug, $subs = null)
    {
        $page = Page::findBySlug($slug);

        if (!$page)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $data['title'] = $page->title;
        $data['page'] = $page->content;

        return view('desktop.Pages.AboutPage', $data);
    }

}
