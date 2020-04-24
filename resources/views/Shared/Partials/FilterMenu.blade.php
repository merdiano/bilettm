@push('after_styles')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <style>
        label{margin-left: 20px;}
        #datepicker{width:180px; margin: 0 20px 20px 20px;}
        #datepicker > span:hover{cursor: pointer;}
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

            <li class="nav-item" style="position: relative; margin-left: -20px;">
                <form action="{{$category->url}}" method="post" class="calendar-form">
                    @csrf
                    {{--<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tab">Дата <i class="fa fa-caret-down"></i></a>--}}
                    <input id="datepickerr" placeholder="{{__('ClientSide.select')}}" name="date"/>
                </form>
            </li>
            <li>
                <label>Select Date: </label>
                <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                    <input class="form-control" type="text" readonly />
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </li>
        </ul>
    </div>
</nav>

@push('after_scripts')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script>
        $(function () {
            $("#datepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());
        });

    </script>
@endpush