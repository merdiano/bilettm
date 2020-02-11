@extends("Bilettm.Layouts.EventsLayout")
@section('inner_content')
    <section class="movie-items-group">
        <div class="container">
            <div class="row kinoteator tab-part">
                <div class="tab-header d-flex justify-content-between col-12">
                    <h2>{{$category->title}}</h2>
                    <div style="height: 5px; position: absolute; bottom: 0px; width: 100px; background-color: rgba(211,61,51,1)"></div>
                </div>
                <div class="tab-ozi col-12">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container">
                            <div class="row">
                                @foreach($events as $event)
                                    @include("Bilettm.EventsList.{$category->view_type}")
                                @endforeach
                            </div>
                            {{$events->onEachSide(5)->links()}}
                        </div>
                    </div>
                    <!-- End Tab panes -->
                </div>
            </div>
        </div>
    </section>
@endsection
