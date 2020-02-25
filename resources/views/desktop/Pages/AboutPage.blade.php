@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('after_styles')

@endsection
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('about',$title)}}
    <section class="my-3">
        <div class="container">
            <div class="row">
                <div class="col-2">


                    <ul class="list-inline">
                        <li class="list-inline-item text-capitalize"><h3>@lang('ClientSide.about_us')</h3></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'introduction_'.Config::get('app.locale')])}}">{{__('ClientSide.introduction')}}</a></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'partners_'.Config::get('app.locale')])}}">{{__("ClientSide.partners")}}</a></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'contacts_'.Config::get('app.locale')])}}">{{__("ClientSide.contacts")}}</a></li>


                        <li class="list-inline-item text-capitalize"><h3>@lang('ClientSide.about_payment')</h3></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'how_to_buy_'.Config::get('app.locale')])}}">{{__("ClientSide.how_to_buy")}}</a></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'questions_'.Config::get('app.locale')])}}">{{__("ClientSide.questions")}}</a></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'concert_halls_'.Config::get('app.locale')])}}">{{__("ClientSide.concert_halls")}}</a></li>
                        <li class="list-inline-item text-capitalize"><a href="#">{{__("ClientSide.refund")}}</a></li>


                        <li class="list-inline-item text-capitalize"><h3>@lang('ClientSide.cooperation')</h3></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'organizers_'.Config::get('app.locale')])}}">{{__("ClientSide.organizers")}}</a></li>
                        <li class="list-inline-item text-capitalize"><a href="{{route('about',['page'=>'oferta_'])}}">{{__("ClientSide.oferta")}}</a></li>
                        <li class="list-inline-item text-capitalize"><a data-toggle="modal" data-target="#exampleModalCenter">{{__("ClientSide.addEvent")}}</a></li>
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
