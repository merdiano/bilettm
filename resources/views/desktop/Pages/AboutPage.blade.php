@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('after_styles')

@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-2">

                    <h2>@lang('ClientSide.about_us')</h2>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__('ClientSide.introduction')}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__("ClientSide.partners")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__("ClientSide.contacts")}}</a></li>
                    </ul>
                    <h2>@lang('ClientSide.about_payment')</h2>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__("ClientSide.how_to_buy")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__("ClientSide.questions")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__("ClientSide.concert_halls")}}</a></li>
                        <li class="list-group-item"><a href="#">{{__("ClientSide.refund")}}</a></li>
                    </ul>
                    <h2>@lang('ClientSide.cooperation')</h2>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__("ClientSide.organizers")}}</a></li>
                        <li class="list-group-item"><a href="{{route('about',['page'=>'znakomstwa-s-bilettm'])}}">{{__("ClientSide.oferta")}}</a></li>
                        <li class="list-group-item"><a style="color: #ffffff; cursor: pointer" data-toggle="modal" data-target="#exampleModalCenter">{{__("ClientSide.addEvent")}}</a></li>
                    </ul>
                </div>
                <div class="col-10">
                    <h1>{{$title}}</h1>
                    {!! Markdown::parse($page) !!}
                </div>
            </div>
        </div>
    </section>
@endsection
