@push('after_styles')
    <style>
        .calendar-form button{
            z-index: 100;
        }
    </style>
@endpush

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

            <li class="nav-item dropdown" style="position: relative; margin-left: -10px;">
                <form action="{{$category->url}}" method="get" class="calendar-form ">
                    @csrf
                    {{--<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tab">Дата <i class="fa fa-caret-down"></i></a>--}}
                    {{--<input id="datepicker" placeholder="{{__('ClientSide.select')}}" name="date" style="width: 95px; opacity: 1; z-index: 1; border-radius: 3px; margin-top: -2px; padding: 3px 10px;"/>--}}
                    <input id="datepicker" placeholder="00/00/00" name="date" style="width: 95px; opacity: 1; z-index: 1; border-radius: 3px; margin-top: -2px; padding: 3px 10px;"/>
                    <input type="hidden"  name="start" value="">
                    <input type="hidden"  name="end" value="">

                    <a id="calendar-search-btn" style="position: absolute; top: 0; left: 40px; margin: 7px;">
                        <i class="fa fa-search" style="padding: 7px; background-color: #d33d33; color: #ffffff; border-radius: 5px; margin: -10px; margin-left: 95px;"></i>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</nav>

@push('after_scripts')
    <script>
        $(document).ready(function () {
            $("#calendar-search-btn").bind('click', function () {
                $("#calendar-search-btn").attr('href', 'https://www.bilettm.com/gotten/date/'+$("#datepicker").val());
                $("#calendar-search-btn").click();
            });
        });
    </script>
    @endpush
