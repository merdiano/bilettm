@include('ManageOrganiser.Partials.EventCreateAndEditJS')

{!! Form::model($event, array('url' => route('postEditEvent', ['event_id' => $event->id]), 'class' => 'ajax gf')) !!}

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('category',trans('Category.event_category'), array('class'=>'control-label required')) !!}
                    {!! Form::select('category_id',main_categories(), $event->category_id, ['class' => 'form-control','id'=>'categories']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('subCategory',trans('Category.event_sub_category'), array('class'=>'control-label')) !!}
                    {!! Form::subSelect('sub_category_id',sub_categories(), $event->sub_category_id, ['class' => 'form-control','id'=>'subCategories']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('is_live', trans("Event.event_visibility"), array('class'=>'control-label required')) !!}
                    {!!  Form::select('is_live', [
                    '1' => trans("Event.vis_public"),
                    '0' => trans("Event.vis_hide")],null,
                                                array(
                                                'class'=>'form-control'
                                                ))  !!}
                </div>
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('title_ru', trans("Event.event_title_ru"), array('class'=>'control-label required')) !!}
                {!! Form::text('title_ru', Input::old('title_ru'),
                                            array(
                                            'class'=>'form-control',
                                            'placeholder'=>trans("Event.event_title_placeholder", ["name"=>Auth::user()->first_name])
                                            ))  !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('title_tk', trans("Event.event_title_tk"), array('class'=>'control-label required')) !!}
                {!! Form::text('title_tk', Input::old('title_tk'),
                                            array(
                                            'class'=>'form-control',
                                            'placeholder'=>trans("Event.event_title_placeholder", ["name"=>Auth::user()->first_name])
                                            ))  !!}
            </div>

            <div class="form-group col-md-6">
            {!! Form::label('description_ru', trans("Event.event_description_ru"), array('class'=>'control-label')) !!}
            {!! Form::textarea('description_ru', Input::old('description_ru'),
                                        array(
                                        'class'=>'form-control editable',
                                        'rows' => 5
                                        ))  !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('description_tk', trans("Event.event_description_tk"), array('class'=>'control-label')) !!}
                {!! Form::textarea('description_tk', Input::old('description_tk'),
                                            array(
                                            'class'=>'form-control editable',
                                            'rows' => 5
                                            ))  !!}
            </div>
            <div class="form-group col-md-6 address-automatic">
            {!! Form::label('venue_name', trans("Event.venue_name"), array('class'=>'control-label required ')) !!}
            {!! Form::select('venue_id',venues_list(), Input::old('venue_id'), ['class' => 'form-control','id'=>'venue_name']) !!}
            {{--{!! Form::label('name', trans("Event.venue_name"), array('class'=>'control-label required ')) !!}--}}
            {{--{!!  Form::text('venue_name_full', Input::old('venue_name_full'),--}}
                                        {{--array(--}}
                                        {{--'class'=>'form-control geocomplete location_field',--}}
                                        {{--'placeholder'=>trans("Event.venue_name_placeholder")//'E.g: The Crab Shack'--}}
                                        {{--))  !!}--}}

            {{--<!--These are populated with the Google places info-->--}}
            {{--<div>--}}
               {{--{!! Form::hidden('formatted_address', $event->location_address, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('street_number', $event->location_street_number, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('country', $event->location_country, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('country_short', $event->location_country_short, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('place_id', $event->location_google_place_id, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('name', $event->venue_name, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('location', '', ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('postal_code', $event->location_post_code, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('route', $event->location_address_line_1, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('lat', $event->location_lat, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('lng', $event->location_long, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('administrative_area_level_1', $event->location_state, ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('sublocality', '', ['class' => 'location_field']) !!}--}}
               {{--{!! Form::hidden('locality', $event->location_address_line_1, ['class' => 'location_field']) !!}--}}
            {{--</div>--}}
            {{--<!-- /These are populated with the Google places info-->--}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('start_date', trans("Event.event_start_date"), array('class'=>'required control-label')) !!}
                    {!! Form::text('start_date', $event->getFormattedDate('start_date'),
                                                        [
                                                    'class'=>'form-control start hasDatepicker ',
                                                    'data-field'=>'datetime',
                                                    'data-startend'=>'start',
                                                    'data-startendelem'=>'.end',
                                                    'readonly'=>''

                                                ])  !!}
                </div>
            </div>

            <div class="col-sm-6 ">
                <div class="form-group">
                    {!!  Form::label('end_date', trans("Event.event_end_date"),
                                        [
                                    'class'=>'required control-label '
                                ])  !!}
                    {!!  Form::text('end_date', $event->getFormattedDate('end_date'),
                                                [
                                            'class'=>'form-control end hasDatepicker ',
                                            'data-field'=>'datetime',
                                            'data-startend'=>'end',
                                            'data-startendelem'=>'.start',
                                            'readonly'=>''
                                        ])  !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                   {!! Form::label('event_image', trans("Event.event_flyer"), array('class'=>'control-label ')) !!}
                   {!! Form::styledFile('event_image', 1) !!}
                </div>

                @if($event->images->count())

                    {!! Form::label('', trans("Event.current_event_flyer"), array('class'=>'control-label ')) !!}
                    <div class="form-group">
                        <div class="well well-sm well-small">
                           {!! Form::label('remove_current_image', trans("Event.delete?"), array('class'=>'control-label ')) !!}
                           {!! Form::checkbox('remove_current_image') !!}

                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="float-l">
                    @if($event->images->count())
                    <div class="thumbnail">
                       {!!HTML::image('/'.$event->images->first()['image_path'])!!}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <div class="panel-footer mt15 text-right">
           {!! Form::hidden('organiser_id', $event->organiser_id) !!}
           {!! Form::submit(trans("Event.save_changes"), ['class'=>"btn btn-success"]) !!}
        </div>
    </div>

</div>
{!! Form::close() !!}
