@if(!empty($category->events) && $category->events->count()>0)
<div class="section-section py-5 {{$category->view_type}}">
<div class="container" style="padding: 0 12px !important; margin-bottom: 15px;">
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <h5 class="">{{$category->title}}
                <div class="title-bottom-line"></div>
            </h5>
            <a href="{{$category->url}}" class="show-all">{{__('ClientSide.view')}}</a>
        </div>
    </div>
</div>
<div class="owl-carousel owl-theme" >
    @foreach($category->events as $event)
        <div class="item">
        @include('mobile.Partials.EventListItem',['event'=>$event])
        </div>
    @endforeach
</div>
</div>
@endif

