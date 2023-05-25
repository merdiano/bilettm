<?php

namespace App\Models;

use Attribute;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Event extends MyBaseModel
{
    use SoftDeletes;
    use CrudTrait;
    protected $dates = ['start_date', 'end_date', 'on_sale_date'];

    /**
     * The validation rules.
     *
     * @return array $rules
     */
    public function rules()
    {
        $format = config('attendize.default_datetime_format');
        return [
                'title_ru'               => 'required',
                'description_ru'         => 'required',
                'venue_id'            => 'required',
//                'location_venue_name' => 'required_without:venue_name_full',
//                'venue_name_full'     => 'required_without:location_venue_name',
                'start_date'          => 'required|date_format:"'.$format.'"',
                'end_date'            => 'required|date_format:"'.$format.'"',
                'organiser_name'      => 'required_without:organiser_id',
                'event_image'         => 'mimes:jpeg,jpg,png|max:3000',
            ];
    }

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    protected $messages = [
        'title.required'                       => 'You must at least give a title for your event.',
        'organiser_name.required_without'      => 'Please create an organiser or select an existing organiser.',
        'event_image.mimes'                    => 'Please ensure you are uploading an image (JPG, PNG, JPEG)',
        'event_image.max'                      => 'Please ensure the image is not larger then 3MB',
        'location_venue_name.required_without' => 'Please enter a venue for your event',
        'venue_name_full.required_without'     => 'Please enter a venue for your event',
    ];

    /**
     * The questions associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(\App\Models\Question::class, 'event_question');
    }

    /**
     * The questions associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions_with_trashed()
    {
        return $this->belongsToMany(\App\Models\Question::class, 'event_question')->withTrashed();
    }

    /**
     * The attendees associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendees()
    {
        return $this->hasMany(\App\Models\Attendee::class)
            ->where('attendees.is_cancelled',false)
            ->where('attendees.is_refunded',false);
    }

    /**
     * The images associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(\App\Models\EventImage::class);
    }

    /**
     * The messages associated with the event.
     *
     * @return mixed
     */
    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class)->orderBy('created_at', 'DESC');
    }

    /**
     * The tickets associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class);
    }

    public function starting_ticket(){
        return $this->tickets()
            ->select('id','ticket_date','event_id','price')
            ->where('ticket_date','>=',Carbon::now(\config('app.timezone')))
            ->orderBy('ticket_date')
            ->orderBy('price')
            ->limit(2); // limit 1 returns null ???
    }
    /**
     * The stats associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stats()
    {
        return $this->hasMany(\App\Models\EventStats::class);
    }

    // public function views():Attribute{
    //     return Attribute::make(
    //         get: $this->stats()->sum('views'),
    //     );
    // }
    /**
     * The affiliates associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliates()
    {
        return $this->hasMany(\App\Models\Affiliate::class);
    }

    /**
     * The orders associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
    

    public function ticket_dates(){
        return $this->tickets()
            ->select('ticket_date','event_id')
            ->where('is_hidden', false)
            ->where('ticket_date','>=',Carbon::now())
            ->orderBy('ticket_date', 'asc')
            ->groupBy('ticket_date')
            ->distinct();
    }

    /**
     * The access codes associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function access_codes()
    {
        return $this->hasMany(\App\Models\EventAccessCodes::class, 'event_id', 'id');
    }

    /**
     * The account associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class);
    }

    /**
     * The currency associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * The organizer associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organiser()
    {
        return $this->belongsTo(\App\Models\Organiser::class);
    }

    /**
     * Tags associated with the event
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags(){
        return $this->belongsToMany(\App\Models\Tag::class);
    }

    public function venue(){
        return $this->belongsTo(Venue::class);
    }
    /**
     * Category associated with the event
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mainCategory(){
        return $this->belongsTo(Category::class,'category_id');
    }

    /**
     * Sub category associated with the event
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(){
        return $this->belongsTo(Category::class,'sub_category_id');
    }

    public function getTitleAttribute(){

        return $this->{'title_'.Config::get('app.locale')};
    }

    public function getDescriptionAttribute(){

        return $this->{'description_'.Config::get('app.locale')} ?? 'No translation';
    }
    /**
     * Get the embed url.
     *
     * @return mixed
     */
    public function getEmbedUrlAttribute()
    {
        return str_replace(['http:', 'https:'], '', route('showEmbeddedEventPage', ['event' => $this->id]));
    }

    /**
     * Get the fixed fee.
     *
     * @return mixed
     */
    public function getFixedFeeAttribute()
    {
        return config('settings.booking_fee_fixed') + $this->organiser_fee_fixed;
    }

    /**
     * Get the percentage fee.
     *
     * @return mixed
     */
    public function getPercentageFeeAttribute()
    {
        return config('settings.booking_fee_percentage') + $this->organiser_fee_percentage;
    }

    /**
     * Parse start_date to a Carbon instance
     *
     * @param string $date DateTime
     */
    public function setStartDateAttribute($date)
    {
        $format = config('attendize.default_datetime_format');
        $this->attributes['start_date'] = Carbon::createFromFormat($format, $date);
    }

    /**
     * Format start date from user preferences
     * @return String Formatted date
     */
    public function startDateFormatted()
    {
        return $this->start_date->format(config('attendize.default_datetime_format'));
    }

    /**
     * Parse end_date to a Carbon instance
     *
     * @param string $date DateTime
     */
    public function setEndDateAttribute($date)
    {
        $format = config('attendize.default_datetime_format');
        $this->attributes['end_date'] = Carbon::createFromFormat($format, $date);
    }

    /**
     * Format end date from user preferences
     * @return String Formatted date
     */
    public function endDateFormatted()
    {
        return $this->end_date->format(config('attendize.default_datetime_format'));
    }

    /**
     * Indicates whether the event is currently happening.
     *
     * @return bool
     */
    public function getHappeningNowAttribute()
    {
        return Carbon::now()->between($this->start_date, $this->end_date);
    }

    /**
     * Get the currency symbol.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCurrencySymbolAttribute()
    {
        return $this->currency->symbol_left ?? '';
    }

    /**
     * Get the currency code.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCurrencyCodeAttribute()
    {
        return $this->currency->code;
    }

    /**
     * Return an array of attendees and answers they gave to questions at checkout
     *
     * @return array
     */
    public function getSurveyAnswersAttribute()
    {
        $rows[] = array_merge([
            'Order Ref',
            'Attendee Name',
            'Attendee Email',
            'Attendee Ticket'
        ], $this->questions->pluck('title')->toArray());

        $attendees = $this->attendees()->has('answers')->get();

        foreach ($attendees as $attendee) {
            $answers = [];

            foreach ($this->questions as $question) {
                if (in_array($question->id, $attendee->answers->pluck('question_id')->toArray())) {
                    $answers[] = $attendee->answers->where('question_id', $question->id)->first()->answer_text;
                } else {
                    $answers[] = null;
                }
            }

            $rows[] = array_merge([
                $attendee->order->order_reference,
                $attendee->full_name,
                $attendee->email,
                $attendee->ticket->title
            ], $answers);
        }

        return $rows;
    }

    /**
     * Get the embed html code.
     *
     * @return string
     */
    public function getEmbedHtmlCodeAttribute()
    {
        return "<!--Attendize.com Ticketing Embed Code-->
                <iframe style='overflow:hidden; min-height: 350px;' frameBorder='0' seamless='seamless' width='100%' height='100%' src='" . $this->embed_url . "' vspace='0' hspace='0' scrolling='auto' allowtransparency='true'></iframe>
                <!--/Attendize.com Ticketing Embed Code-->";
    }

    /**
     * Get a usable address for embedding Google Maps
     *
     */
    public function getMapAddressAttribute()
    {
        $string = $this->venue . ','
            . $this->location_street_number . ','
            . $this->location_address_line_1 . ','
            . $this->location_address_line_2 . ','
            . $this->location_state . ','
            . $this->location_post_code . ','
            . $this->location_country;

        return urlencode($string);
    }

    /**
     * Get the big image url.
     *
     * @return string
     */
    public function getBgImageUrlAttribute()
    {
        return URL::to('/') . '/' . $this->bg_image_path;
    }

    /**
     * Get the url of the event.
     *
     * @return string
     */
    public function getEventUrlAttribute()
    {
        return route("showEventPage", ["event_id"=>$this->id, "event_slug"=> Str::slug($this->title)]);
        //return URL::to('/') . '/e/' . $this->id . '/' . Str::slug($this->title);
    }

    /**
     * Get the sales and fees volume.
     *
     * @return \Illuminate\Support\Collection|mixed|static
     */
    public function getSalesAndFeesVoulmeAttribute()
    {
        return $this->sales_volume + $this->organiser_fees_volume;
    }

    public function getViewsCountAttribute(){
        return $this->stats()->sum('views');
    }

    public function getStartingTicketPriceAttribute(){
        $ticket = $this->tickets()
            ->where('is_hidden',0)
            ->orderBy('price','asc')
            ->first();
        if(!empty($ticket))
            return $ticket->total_price;
        return 0;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array $dates
     */
    public function getDates()
    {
        return ['created_at', 'updated_at', 'start_date', 'end_date'];
    }

    public function getIcsForEvent()
    {
        $siteUrl = URL::to('/');
        $eventUrl = $this->getEventUrlAttribute();

        $start_date = $this->start_date;
        $end_date = $this->end_date;
        $timestamp = new Carbon();

        $icsTemplate = <<<ICSTemplate
        BEGIN:VCALENDAR
        VERSION:2.0
        PRODID:{$siteUrl}
        BEGIN:VEVENT
        UID:{$eventUrl}
        DTSTAMP:{$timestamp->format('Ymd\THis\Z')}
        DTSTART:{$start_date->format('Ymd\THis\Z')}
        DTEND:{$end_date->format('Ymd\THis\Z')}
        SUMMARY:$this->title
        LOCATION:{$this->venue_name}
        DESCRIPTION:{$this->description}
        END:VEVENT
        END:VCALENDAR
        ICSTemplate;

        return $icsTemplate;
    }

    public function getSeansCount(){
        $seans = $this->tickets()->distinct()->orderBy('ticket_date')->count();
        return $seans != 0 ? $seans. ' seansa' : ''; //todo get from translate
    }
    /**
     * @param integer $accessCodeId
     * @return bool
     */
    public function hasAccessCode($accessCodeId)
    {
        return (is_null($this->access_codes()->where('id', $accessCodeId)->first()) === false);
    }

    public function scopeOnLive($query, $start_date = null, $end_date = null){
        //if date is null carbon creates now date instance
        //todo what if only end date is null??
        if(!empty($start_date) && !empty($end_date))
        {
            $query->where('start_date','<',$end_date)
                ->where('end_date','>',$start_date);
        }
        else
            $query->where('end_date','>',Carbon::now(config('app.timezone')));

        return $query->where('is_live',1)
            ->withCount(['images as image_url' => function($q){
                $q->select(DB::raw("image_path as imgurl"))
                    ->orderBy('created_at','desc')
                    ->take(1);
            }] );
    }

    public function sections(){
        //return $this->tickets()->with('section');
        return $this->tickets()->select(DB::raw('sections.*'))->join('sections','tickets.section_id','=','sections.id');
    }

    public function reservedTickets(){
        return $this->hasMany(ReservedTickets::class);
    }

    public function scopeWithViews($query)
    {
        return $query->withCount(['stats as views' => function ($query) {
            $query->select(DB::raw('sum(views)'));
        }]);
    }

    public function scopeWithReserved($query,$phone_id){
        return $query->with(['reservedTickets' => function($q) use ($phone_id){
            $q->select('id','session_id','ticket_id','event_id','expires')
                ->where('session_id',$phone_id )
                ->where('expires','>',Carbon::now())
                ->with('ticket:id,price');
        }]) ;
    }

}
