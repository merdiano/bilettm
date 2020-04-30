@extends("desktop.Layouts.EventsLayout")
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('category',$category)}}
    @include("Shared.Partials.FilterMenu")

    @foreach($category->children as $cat)

        @php
        $cat_events = $events->where('sub_category_id',$cat->id);
        @endphp
        <section class="movie-items-group firts-child">
            <div class="container">
                <div class="row kinoteator tab-part">
                    <div class="tab-header d-flex justify-content-between col-12">
                        <h2  class="font-weight-bold">{{$cat->title}}</h2>
                        <div style="height: 5px; position: absolute; bottom: 0px; width: 100px; background-color: rgba(211,61,51,1)"></div>
                        @if($cat_events->count() == $cat->events_limit)
                        <a class="red_button" href="{{$cat->url}}">{{__("ClientSide.rep")}}</a>
                        @endif
                    </div>
                    <div class="tab-ozi col-12" style="margin-top: 10px">

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="container">
                                <div class="row">
                                    @foreach($cat_events as $event)
                                        @include("desktop.EventsList.{$cat->view_type}",['event'=>$event])
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

@section('after_scripts')
    <script src="{{asset('vendor/gijgo/gijgo.min.js')}}" type="text/javascript"></script>
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            icons: {
                rightIcon: '{{__("ClientSide.date")}} <i class="fa fa-caret-down"></i>'
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.gj-picker-bootstrap table tbody tr td', function () {
                alert(5342);
            });
        });
    </script>

@endsection