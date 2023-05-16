<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\SearchController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => '/v2',
], function(){
    Route::get('/home', HomeController::class);
    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::get('/category/{category_id}/locations', [LocationController::class, 'locations']);
    Route::get('/search', SearchController::class);
    Route::get('/event/{id}/details', [EventController::class, 'eventDetailById']);
    Route::get('/event/{id}/seats', [EventController::class, 'eventSeatsById']);
});




