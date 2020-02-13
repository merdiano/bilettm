@extends('Shared.Layouts.BilettmLayout')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('search')}}
    <section class="movie-items-group firts-child" style="margin-bottom: 100px">
        <div class="container">
            <div class="row kinoteator tab-part">
                <div class="tab-header d-flex justify-content-between col-12">
                    <h2 class="">{{$query}}</h2>
                    <div style="height: 5px; margin-left: 5px; position: absolute; bottom: 0px; width: 100px; background-color: rgba(211,61,51,1)"></div>
                </div>
                <div class="tab-ozi col-12">
                    <!-- Nav tabs -->
                    <ul class="nav u-nav-v1-1 g-mb-20" role="tablist" data-target="nav-1-1-default-hor-left" data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-lightgray g-mb-20">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" role="tab">{{__("ClientSide.results")}}: {{$events->count()}}/{{$events->total()}}</a>
                        </li>
                    </ul>
                    <!-- End Nav tabs -->

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="kinoteator-tab1-wrapper">
                            <div class="container">
                                <div class="row">
                                    @foreach($events as $event)
                                        @include('desktop.Partials.EventItem')
                                    @endforeach
                                        {{$events->links('vendor.pagination.simple-bootstrap-4')}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Tab panes -->
                </div>
            </div>
        </div>
    </section>
@endsection
