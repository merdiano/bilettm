@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('help')}}

    <section class="movie-items-group firts-child" style="margin-bottom: 100px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <form action="{{route('help.create')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            {!! Form::label('title_ru', trans("Event.event_title_ru"), array('class'=>'control-label required')) !!}
                            {!! Form::text('title_ru', Input::old('title_ru'),array('class'=>'form-control' ))  !!}
                        </div>
                        <div class="form-group custom-theme">
                            {!! Form::label('description_ru', trans("Event.event_description_ru"), array('class'=>'control-label required')) !!}
                            {!! Form::textarea('description_ru', Input::old('description_ru'),
                                        array(
                                        'class'=>'form-control  editable',
                                        'rows' => 5
                                        ))  !!}
                        </div>
                        <div class="form-group address-automatic">
                        {!! Form::label('venue_name', trans("Event.venue_name"), array('class'=>'control-label required ')) !!}
                        {!! Form::select('venue_id',$categories->pluck('id','title'), Input::old('venue_id'), ['class' => 'form-control','id'=>'venue_name']) !!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
