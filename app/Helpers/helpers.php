<?php

use App\Models\HelpTopic;

if (!function_exists('money')) {
    /**
     * Format a given amount to the given currency
     *
     * @param $amount
     * @param \App\Models\Currency $currency
     * @return string
     */
    function money($amount, \App\Models\Currency $currency = null)
    {
        if(!$currency){
            return number_format($amount,2,'.',',').trans('ClientSide.currency_code');
        }
        return $currency->symbol_left . number_format($amount, $currency->decimal_place, $currency->decimal_point,
            $currency->thousand_point) . $currency->symbol_right;
    }
}
if(!function_exists('main_categories')){

    /**
     * return main categories
     * @return mixed
     */
    function main_categories(){
        return \App\Models\Category::main()->pluck('title_ru','id');
    }
}

if(!function_exists('venues_list')){
    function venues_list(){
        return \App\Models\Venue::select('venue_name_'.config('app.locale'),'id')
            ->where('active',1)
            ->pluck('venue_name_'.config('app.locale'),'id');
    }
}
if(!function_exists('sections_list')){
    function sections_list($venue_id){
        return \App\Models\Section::select('id','section_no_ru')
            ->where('venue_id',$venue_id)
            ->pluck('section_no_ru','id');
    }
}

if(!function_exists('category_menu')){
    /**
     *  make menu from categories
     */
    function category_menu(){

        return \App\Models\Category::main()->select('id','title_tk','title_ru')->get();
//        $categories = main_categories();
//        if(count($categories)>6){
//            //todo implement top category menu
//        }
    }
}

if(! function_exists('sub_categories')){
    /**
     * return sub categoreies
     */

    function sub_categories(){
        return \App\Models\Category::sub()
            ->select(trans('Category.category_title'),'id','parent_id')
            ->get();
    }
}
if(!function_exists('organisers')){

    function organisers(){
        if(Illuminate\Support\Facades\Auth::user()->is_admin)
            return \App\Models\Organiser::all();
        else
            return \Illuminate\Support\Facades\Auth::user()->account->organisers;
    }
}
if(!function_exists('zanitlananlar')){
    function zanitlananlar($ticket){
        $reserved = $ticket->reserved->pluck('seat_no')
            ->transform(function ($item,$key){
               return [$item => 'reserved'];
            });

        $booked = $ticket->booked->pluck('seat_no')
            ->transform(function ($item,$key){
                return [$item =>'booked'];
            });
        return $booked->merge($reserved)->toJson();
    }
}
if(!function_exists('help_topics')){
    function help_topics(){
        return HelpTopic::where('active',1)
            ->select(['id','title_'.config('app.locale').' as title'])
            ->orderBy('position','asc')
            ->pluck('title','id');
    }
}
