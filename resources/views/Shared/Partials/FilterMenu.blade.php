<nav class="w-100">
    <div class="container">
        <ul class="nav u-nav-v1-1 g-mb-20 category-filter" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-lightgray g-mb-20">

            <li class="nav-item">
                <a class="nav-link active" href="{{$category->customUrl(['start'=>now(),'end'=>today()->endOfDay()])}}">{{__("ClientSide.today")}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{$category->customUrl(['start'=>now()->endOfDay(),'end'=>Carbon::tomorrow()->endOfDay()])}}">{{__('ClientSide.tomorrow')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{$category->customUrl(['start'=>now(),'end'=>today()->endOfWeek()])}}">{{__('ClientSide.week')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{$category->customUrl(['start'=>now(),'end'=>today()->endOfMonth()])}}">{{__('ClientSide.month')}}</a>
            </li>

            <li class="nav-item dropdown" style="position: relative; margin-left: -20px;">
                <form action="{{$category->url}}" method="post" class="calendar-form">
                    @csrf
                    {{--<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tab">Дата <i class="fa fa-caret-down"></i></a>--}}
                    <input id="datepicker" placeholder="{{__('ClientSide.select')}}" name="date"/>
                </form>
            </li>
            <li><a href="">Test</a></li>
        </ul>
    </div>
</nav>
