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
                            <h3>@lang('ClientSide.about_us')</h3><div style="background-color: rgba(211,61,51,1);height: 5px;width: 80px;margin-bottom: 15px;"></div> </li>
                        <li class="list-group-item border-0 pl-0">
                            <a class="text-dark capitalizer" href="{{route('about',['page'=>'introduction'])}}">{{__('ClientSide.introduction')}}</a></li>
                        <li class="list-group-item border-0 pl-0">
                            <a  class="text-dark capitalizer" href="{{route('about',['page'=>'oferta'])}}">{{__("ClientSide.oferta")}}</a></li>

                        <li class="list-group-item border-0 pl-0">
                            <a  class="text-dark capitalizer" href="{{route('about',['page'=>'contacts'])}}">{{__("ClientSide.contacts")}}</a></li>

                        <li class="list-group-item border-0 pl-0">
                            <h3>@lang('ClientSide.about_payment')</h3><div style="background-color: rgba(211,61,51,1);height: 5px;width: 80px;margin-bottom: 15px;"></div> </li>
                        <li class="list-group-item border-0 pl-0">
                            <a class="text-dark capitalizer" href="{{route('about',['page'=>'how_to_buy'])}}">{{__("ClientSide.how_to_buy")}}</a></li>
                        <li class="list-group-item border-0 pl-0">
                            <a class="text-dark capitalizer" href="{{route('about',['page'=>'questions'])}}">{{__("ClientSide.questions")}}</a></li>

                        <li class="list-group-item border-0 pl-0">
                            <a class="text-dark capitalizer" href="{{route('about',['page'=>'refund'])}}">{{__("ClientSide.refund")}}</a></li>

                        <li class="list-group-item border-0 pl-0">
                            <h3>@lang('ClientSide.cooperation')</h3><div style="background-color: rgba(211,61,51,1);height: 5px;width: 80px;margin-bottom: 15px;"></div> </li>
                        <li class="list-group-item border-0 pl-0">
                            <a  class="text-dark capitalizer" href="{{route('about',['page'=>'organizers'])}}">{{__("ClientSide.organizers")}}</a></li>
                        <li class="list-group-item border-0 pl-0">
                            <a class="text-dark capitalizer" href="{{route('about',['page'=>'partners'])}}">{{__("ClientSide.partners")}}</a></li>
                        <li class="list-group-item border-0 pl-0">
                            <a class="text-dark capitalizer" href="{{route('about',['page'=>'concert_halls'])}}">{{__("ClientSide.concert_halls")}}</a></li>
                        <li class="list-group-item border-0 pl-0">
                            <a  class="text-dark capitalizer" data-toggle="modal" data-target="#exampleModalCenter">{{__("ClientSide.addEvent")}}</a></li>
                    </ul>
                    <div style="width: 5px;float: left;height: calc(100% - 20px); margin-top: 10px; margin-left: -6px; box-shadow: 2px 0 10px rgba(0,0,0,.1)"></div>
                </div>
                <div class="col-9 pl-4" style="font-size: 17px">
                    <h2>{{$title}}</h2>
                    {!! Markdown::parse($page) !!}
                </div>
            </div>
        </div>
    </section>
@endsection
