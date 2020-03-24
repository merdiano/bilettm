@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('after_styles')

@endsection
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('about',$title)}}
    <section class="my-3">
        <div class="container">
            <div class="row text_black" >
                <div class="col-3">


                    <ul class="list-group w-100 " style="float: left;height: 100%; background-color: #ffffff; z-index: 10;position: relative;color: #000000;font-size: 17px;">
                        <li class="list-group-item border-0 pl-0">
                            <h3>@lang('ClientSide.venues')</h3><div style="background-color: rgba(211,61,51,1);height: 5px;width: 80px;margin-bottom: 15px;"></div> </li>
                        @foreach($venues as $venue)
                            <li class="list-group-item border-0 pl-0">
                                <a class="text-dark capitalizer" href="{{route('about',['page'=>'introduction'])}}">{{$venue->venue_name}}</a></li>
                        @endforeach
                    </ul>
                    <div style="width: 5px;float: left;height: calc(100% - 20px); margin-top: 10px; margin-left: -6px; box-shadow: 2px 0 10px rgba(0,0,0,.1)"></div>
                </div>
                <div class="col-9 pl-4" style="font-size: 17px">
                    <h2>{{$venue->venue_name}}</h2>
                    {!! Markdown::parse($venue->description) !!}
                </div>
            </div>
        </div>
    </section>
@endsection
