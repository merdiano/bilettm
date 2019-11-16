<nav>
    <div class="container">
        <ul class="nav u-nav-v1-1 g-mb-20 category-filter" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-lightgray g-mb-20">

            <li class="nav-item">
                <a class="nav-link active" href="{{$category->customUrl(['sort'=>'popular','start'=>$start,'end'=>$end])}}">{{__("ClientSide.popular")}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{$category->customUrl(['sort'=>'new','start'=>$start,'end'=>$end])}}">{{__('ClientSide.new')}}</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tab">{{__('ClientSide.filter')}} <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item nav-link"
                       href="{{$category->customUrl(['sort'=>$sort,'start'=>Carbon::now(),'end'=>Carbon::today()->endOfDay()])}}" >{{__('ClientSide.today')}}</a>
                    <a class="dropdown-item nav-link"
                       href="{{$category->customUrl(['sort'=>$sort,'start'=>Carbon::tomorrow(),'end'=>Carbon::tomorrow()->endOfDay()])}}" >{{__('ClientSide.tomorrow')}}</a>
                    <a class="dropdown-item nav-link"
                       href="{{$category->customUrl(['sort'=>$sort,'start'=>Carbon::now(),'end'=>Carbon::today()->endOfWeek()])}}" >{{__('ClientSide.week')}}</a>
                    <a class="dropdown-item nav-link"
                       href="{{$category->customUrl(['sort'=>$sort,'start'=>Carbon::now(),'end'=>Carbon::today()->endOfMonth()])}}" >{{__('ClientSide.month')}}</a>
                </div>
            </li>
            <li class="nav-item dropdown" style="position: relative; margin-left: -20px;">
                <form action="{{$category->url}}" method="post" class="calendar-form">
                    @csrf
                    {{--<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tab">Дата <i class="fa fa-caret-down"></i></a>--}}
                    <input id="datepicker" placeholder="{{__('ClientSide.select')}}" name="date"/>
                </form>
            </li>
        </ul>
    </div>
</nav>