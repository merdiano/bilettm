<?php


namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index($slug, $subs = null)
    {
        $page_slug = Str::endsWith($slug,'_tk') || Str::endsWith($slug,'_ru')? $slug : $slug.'_'.config('app.locale');

        $page = Page::findBySlug($page_slug);

        if (!$page)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $data['title'] = $page->title;
        $data['page'] = $page->content;

        return $this->render('Pages.AboutPage', $data);
    }

}
