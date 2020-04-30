<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 9/11/2019
 * Time: 15:07
 */
// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(trans('ClientSide.home'), route('home'));
});

Breadcrumbs::for('category', function ($trail, $category){
    $trail->parent('home');
    $trail->push($category->title?? trans('ClientSide.results'), $category->url ?? '#');
});

Breadcrumbs::for('sub_category', function ($trail, $category){
    $trail->parent('category',$category->parent);
    $trail->push($category->title?? trans('ClientSide.results'), $category->url ?? '#');
});

Breadcrumbs::for('event',function($trail, $event){
    if($event->subCategory)
        $trail->parent('sub_category', $event->subCategory);
    else
        $trail->parent('category', $event->mainCategory);
    $trail->push($event->title?? trans('ClientSide.results'),$event->event_url ?? '#');
});

Breadcrumbs::for('seats',function ($trail,$event){
    $trail->parent('event',$event);
    $trail->push(trans('ClientSide.checkout'));//'Pokupka'
});

Breadcrumbs::for('search',function($trail){
    $trail->parent('home');
    $trail->push(trans('ClientSide.results'));//'Результат поиска'
});

Breadcrumbs::for('help',function($trail){
    $trail->parent('home');
    $trail->push(trans('ClientSide.help'));
});

Breadcrumbs::for('add_event',function($trail){
    $trail->parent('home');
    $trail->push('+ ДОБАВИТЬ СОБЫТИЕ');
});

Breadcrumbs::for('about',function($trail,$title){
    $trail->parent('home');
    $trail->push($title??'#title_transation');
});
