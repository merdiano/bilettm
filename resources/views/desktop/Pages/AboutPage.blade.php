@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('after_styles')

@endsection
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('about',$title)}}
    <section class="mx-4">
        <div class="container">
            <div class="row">
                <div class="col-2">


                    <ul class="list-group">
                        <li class="list-group-item"><h3>@lang('ClientSide.about_us')</h3></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'introduction'])}}">{{__('ClientSide.introduction')}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'partners'])}}">{{__("ClientSide.partners")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'contacts'])}}">{{__("ClientSide.contacts")}}</a></li>


                        <li class="list-group-item"><h3>@lang('ClientSide.about_payment')</h3></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'how_to_buy'])}}">{{__("ClientSide.how_to_buy")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'questions'])}}">{{__("ClientSide.questions")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'concert_halls'])}}">{{__("ClientSide.concert_halls")}}</a></li>
                        <li class="list-group-item"><a href="#">{{__("ClientSide.refund")}}</a></li>


                        <li class="list-group-item"><h3>@lang('ClientSide.cooperation')</h3></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'organizers'])}}">{{__("ClientSide.organizers")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'oferta'])}}">{{__("ClientSide.oferta")}}</a></li>
                        <li class="list-group-item"><a data-toggle="modal" data-target="#exampleModalCenter">{{__("ClientSide.addEvent")}}</a></li>
                    </ul>
                </div>
                <div class="col-10">
                    <h2>{{$title}}</h2>
                    {!! Markdown::parse($page) !!}
                </div>
            </div>
        </div>
    </section>
@endsection
