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
                {{--<form action="{{$category->url}}" method="post" class="calendar-form ">--}}
                    {{--@csrf--}}
                    {{--<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tab">Дата <i class="fa fa-caret-down"></i></a>--}}
                    {{--<input id="datepicker" placeholder="{{__('ClientSide.select')}}" name="date"/>--}}
                {{--</form>--}}
                <div class="container-calendar">
                    <div class="button-container-calendar">
                        <button id="previous">&#8249;</button>
                        <button id="next">&#8250;</button>
                        <h3 id="monthHeader"></h3>
                        <p id="yearHeader"></p>
                    </div>

                    <table class="table-calendar" id="calendar">
                        <thead id="thead-month"></thead>
                        <tbody id="calendar-body"></tbody>
                    </table>

                    <div class="footer-container-calendar">
                        <label for="month">Jump To: </label>
                        <select id="month">
                            <option value=0>Jan</option>
                            <option value=1>Feb</option>
                            <option value=2>Mar</option>
                            <option value=3>Apr</option>
                            <option value=4>May</option>
                            <option value=5>Jun</option>
                            <option value=6>Jul</option>
                            <option value=7>Aug</option>
                            <option value=8>Sep</option>
                            <option value=9>Oct</option>
                            <option value=10>Nov</option>
                            <option value=11>Dec</option>
                        </select>
                        <select id="year"></select>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
