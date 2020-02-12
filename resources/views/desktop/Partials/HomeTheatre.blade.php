@if(!empty($theatre->events) && $theatre->events->count()>0)
<section id="teator" class="container teator">
    <div class="tab-header d-flex justify-content-between col-12">
        <h2 class="font-weight-bold">{{$theatre->title}}</h2>
        <div style="height: 5px; position: absolute; bottom: 10px; width: 100px; background-color: rgba(211,61,51,1)"></div>
        <div class="owl-nav disabled" style="float: right">
            <button type="button" role="presentation" class="owl-prev">
                <span aria-label="Previous">˂</span>
            </button>
            <button type="button" role="presentation" class="owl-next">
                <span aria-label="Next">˃</span>
            </button>
        </div>
        <a class="teatr-show-more m-0" href="{{$theatre->url}}">{{__('ClientSide.view')}}</a>
    </div>
    <div class="tab-ozi col-12 pt-4">
        <div class="kinoteator-tab1-wrapper">

            <div class="row w-100 m-auto">
                <div class="col-md-10 pl-0">
                    <div id="carousel-09-1" class="js-carousel text-center g-font-size-0 g-mb-20 g-mb-0--sm"
                         data-infinite="true" data-vertical="true"
                         data-arrows-classes="u-arrow-v1 g-absolute-centered--x g-width-35 g-height-35 g-font-size-18 g-color-gray g-bg-white"
                         data-arrow-left-classes="fa fa-angle-up g-top-0" data-arrow-right-classes="fa fa-angle-down g-bottom-0"
                         data-nav-for="#carousel-09-2">
                        @foreach($theatre->events as $event)
                            @include('desktop.Partials.TheaterItem',['event'=>$event])
                        @endforeach
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="carousel-09-2" class="js-carousel text-center u-carousel-v3 g-mx-minus-10 g-mx-minus-0--sm g-my-minus-5--sm"
                         data-infinite="true" data-center-mode="true" data-vertical="true" data-slides-show="4"
                         data-is-thumbs="true" data-nav-for="#carousel-09-1">
                        @foreach($theatre->events as $event)
                            <div class="js-slide g-px-10 g-px-0--sm g-py-5--sm">
                                <img class="img-fluid w-100" src="{{$event->image_url ?? '#'}}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
