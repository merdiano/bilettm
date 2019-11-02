<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 9/11/2019
 * Time: 15:07
 */
// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('category', function ($trail, $category){
    $trail->parent('home');

    if(!empty($category) && $category->parent_id){
        $parent = $category->parent;
        $trail->push($parent->title,$parent->url);
    }
    $trail->push($category->title ?? 'Events', $category->url ?? '#');
});

Breadcrumbs::for('event',function($trail, $event){
    $trail->parent('category', $event->mainCategory);
    $trail->push($event->title,$event->event_url);
});

Breadcrumbs::for('seats',function ($trail,$event){
    $trail->parent('event',$event);
    $trail->push('Pokupka');
});

Breadcrumbs::for('search',function($trail){
    $trail->parent('home');
    $trail->push('Результат поиска');
});

Breadcrumbs::for('add_event',function($trail){
    $trail->parent('home');
    $trail->push('+ ДОБАВИТЬ СОБЫТИЕ');
});