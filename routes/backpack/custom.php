<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('category', 'CategoryCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('event', 'EventCrudController');
    Route::crud('slider', 'SliderCrudController');
    Route::crud('tag', 'TagCrudController');
    Route::crud('subscriber', 'SubscriberCrudController');
    Route::crud('event_request', 'EventRequestCrudController');
    Route::crud('venue', 'VenueCrudController');
    Route::crud('section', 'SectionCrudController');
    Route::crud('organiser', 'OrganiserCrudController');
    Route::crud('account', 'AccountCrudController');
    Route::crud('helpTopic','HelpTopicCrudController');
    Route::crud('helpTicket','HelpTicketCrudController');
    Route::get('helpTicket/{id}/replay', 'HelpTicketCrudController@replay')->name('ticket.replay');
    Route::post('helpTicket/{id}/replay', 'HelpTicketCrudController@replayPost')->name('ticket.replay.post');
    Route::crud('sector', 'SectorCrudController');
}); // this should be the absolute last line of this file