@extends("desktop.Layouts.EventsLayout")
@section('inner_content')
    @foreach($sub_cats as $cat)

        <section class="movie-items-group firts-child">
            <div class="container">
                <div class="row kinoteator tab-part">
                    <div class="tab-header d-flex justify-content-between col-12">
                        <h2  class="font-weight-bold">{{$cat->title}}</h2>
                        <div style="height: 5px; position: absolute; bottom: 10px; width: 100px; background-color: rgba(211,61,51,1)"></div>
                        <a class="red_button" href="{{$cat->url}}">{{__("ClientSide.rep")}}</a>
                    </div>
                    <div class="tab-ozi col-12" style="margin-top: 10px">

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="container">
                                <div class="row">
                                    @foreach($cat->cat_events as $event)
                                        @include("desktop{$category->view_type}",['event'=>$event])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- End Tab panes -->
                    </div>
                </div>
            </div>
        </section>

    @endforeach

@endsection
