<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;


//Route v2 api routes ====================================================================================
Route::group([
    'prefix'     => '/v2',
], function(){
    Route::get('/home', HomeController::class);
    Route::get('/search', SearchController::class);
    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::get('/category/{category_id}/events', [CategoryController::class, 'categoryEvents']);
    Route::get('/category/{category_id}/locations', [CategoryController::class, 'locations']);
    Route::get('/location/{location_id}/events', [LocationController::class, 'locationEvents']);
    Route::get('/event/{id}/details', [EventController::class, 'eventDetailById']);
    Route::get('/event/{id}/seats', [EventController::class, 'eventSeatsById']);
    Route::post('/event/{id}/reserve', [App\Http\Controllers\CheckoutController::class, 'postReserveTickets']);
    Route::post('/event/{id}/register_order', [App\Http\Controllers\CheckoutController::class, 'postRegisterOrder']);
    Route::get('/event/{id}/checkout', [App\Http\Controllers\CheckoutController::class, 'postCompleteOrder']);
    Route::get('/my_tickets', [CheckinController::class, 'getTickets']);
});


//Route v1 api routes ====================================================================================
Route::group([
    'prefix'     => '/v1',
], function(){
    Route::get('home', [App\Http\Controllers\EventController::class, 'index']);
    Route::get('main', [App\Http\Controllers\EventController::class, 'getMain']);
    Route::get('search', [App\Http\Controllers\EventController::class, 'search']);
    Route::get('categories[/{parent_id}]', [App\Http\Controllers\CategoryController::class, 'get_categories']);
    Route::get('category/{category_id}/events', [App\Http\Controllers\CategoryController::class, 'showCategoryEvents']);
    Route::get('sub_category/{category_id}/events', [App\Http\Controllers\CategoryController::class, 'showSubCategoryEvents']);
    Route::get('event/{id}/details', [App\Http\Controllers\EventController::class, 'getEvent']);
    Route::get('event/{id}/seats', [App\Http\Controllers\EventController::class, 'getEventSeats']);
});

Route::post('auth/login', [AuthController::class, 'authenticate']);
Route::post('auth/reset', [AuthController::class, 'reset_password']);

Route::group(
    [
        'middleware'    => 'jwt.auth',
        'prefix'        => 'vendor'
    ],
    function(){
        Route::get('events', [App\Http\Controllers\EventController::class, 'getVendorEvents']);
        Route::get('event/{id}/details', [App\Http\Controllers\EventController::class, 'getVendorEvent']);
        Route::get('event/{id}/attendees', [CheckinController::class, 'getAttendees']);
        Route::get('event/{id}/ticket_attendees', [CheckinController::class, 'getTicketsAttendees']);
        Route::post('event/{id}/checkin', [CheckinController::class, 'checkInAttendees']);
        Route::post('event/{id}/book', [CheckoutController::class, 'offline_book']);
        Route::post('event/{id}/book_cancel', [CheckoutController::class, 'offline_cancel']);
    }
);


