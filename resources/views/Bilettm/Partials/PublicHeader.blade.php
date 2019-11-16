<header id="js-header" class="u-header u-header--static u-shadow-v19">
<!-- Top Bar -->
<div class="top-of-header">
    <div class="container-fluid">
        <div class="row">
            <img src="{{asset('assets/images/advs/top_adv.png')}}" class="w-100">
        </div>
    </div>
</div>
<!-- End Top Bar -->

<div class="u-header__section u-header__section--light g-bg-white g-transition-0_3 g-py-10">
    <nav class="js-mega-menu navbar navbar-expand-lg px-0">
        <div class="container">
            <!-- Logo -->
            <div class="navbar-brand bilettm" style="width: 30%; margin-right: 0">
                <a href="/"><img src="{{asset('assets/images/logo/bilet-logo.svg')}}"></a>
                <a data-toggle="modal" data-target="#exampleModalCenter" class="add-event" style="cursor: pointer">+ добавить событие</a>
            </div>
            <!-- End Logo -->

            <!-- Navigation -->
            <div id="navBar" style="width: 40%;" class="collapse navbar-collapse align-items-center flex-sm-row g-pt-15 g-pt-0--lg row">
                <div class="col-12 search-panel w-100">
                    <form action="{{route('search')}}" method="GET" id="main-header-search-form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Мероприятия, исполнители, площадки">
                            <a id="top-header-submit"><img src="{{asset('assets/images/icons/search.svg')}}"></a>
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav ml-auto col-12 justify-content-between" id="bilet-menu-id">
                    @foreach(category_menu() as $category)
                        <li class="nav-item g-ml-10--lg">
                            <a class="nav-link text-uppercase g-pl-5 g-pr-0 g-py-20" href="{{$category->url}}">{{$category->title}}</a>
                        </li>
                        <li class="diam-sim nav-item g-ml-10--lg"><a class="nav-link text-uppercase g-pl-5 g-pr-0 g-py-20"><svg class="Polygon_3" fill="#ffffff" width="7px" viewBox="0 0 8 8">
                                    <path id="Polygon_3" d="M 3.292892932891846 0.7071067690849304 C 3.683417320251465 0.3165824711322784 4.316582202911377 0.3165824711322784 4.707106590270996 0.7071067690849304 L 7.292893409729004 3.292893171310425 C 7.683417320251465 3.683417320251465 7.683417320251465 4.316582679748535 7.292893409729004 4.707107067108154 L 4.707106590270996 7.292893409729004 C 4.316582202911377 7.683417320251465 3.683417081832886 7.683417320251465 3.292892932891846 7.292893409729004 L 0.7071067094802856 4.707106590270996 C 0.3165824413299561 4.316582202911377 0.3165824711322784 3.683417320251465 0.7071067690849304 3.292892932891846 Z">
                                    </path>
                                </svg></a></li>
                    @endforeach
                    {{--<li class="nav-item hs-has-sub-menu g-mx-10--lg g-mx-15--xl dropdown" id="center-menu-dropdown">--}}
                        {{--<a id="nav-link--home" class="nav-link g-px-5 g-py-20 dropdown-toggle" data-toggle="dropdown"><svg class="Polygon_3" fill="#ffffff" width="7px" viewBox="0 0 8 8">--}}
                                {{--<path id="Polygon_3" d="M 3.292892932891846 0.7071067690849304 C 3.683417320251465 0.3165824711322784 4.316582202911377 0.3165824711322784 4.707106590270996 0.7071067690849304 L 7.292893409729004 3.292893171310425 C 7.683417320251465 3.683417320251465 7.683417320251465 4.316582679748535 7.292893409729004 4.707107067108154 L 4.707106590270996 7.292893409729004 C 4.316582202911377 7.683417320251465 3.683417081832886 7.683417320251465 3.292892932891846 7.292893409729004 L 0.7071067094802856 4.707106590270996 C 0.3165824413299561 4.316582202911377 0.3165824711322784 3.683417320251465 0.7071067690849304 3.292892932891846 Z">--}}
                                {{--</path>--}}
                            {{--</svg>&nbsp;<svg class="Polygon_3" fill="#ffffff" width="7px" viewBox="0 0 8 8">--}}
                                {{--<path id="Polygon_3" d="M 3.292892932891846 0.7071067690849304 C 3.683417320251465 0.3165824711322784 4.316582202911377 0.3165824711322784 4.707106590270996 0.7071067690849304 L 7.292893409729004 3.292893171310425 C 7.683417320251465 3.683417320251465 7.683417320251465 4.316582679748535 7.292893409729004 4.707107067108154 L 4.707106590270996 7.292893409729004 C 4.316582202911377 7.683417320251465 3.683417081832886 7.683417320251465 3.292892932891846 7.292893409729004 L 0.7071067094802856 4.707106590270996 C 0.3165824413299561 4.316582202911377 0.3165824711322784 3.683417320251465 0.7071067690849304 3.292892932891846 Z">--}}
                                {{--</path>--}}
                            {{--</svg>&nbsp;<svg class="Polygon_3" fill="#ffffff" width="7px" viewBox="0 0 8 8">--}}
                                {{--<path id="Polygon_3" d="M 3.292892932891846 0.7071067690849304 C 3.683417320251465 0.3165824711322784 4.316582202911377 0.3165824711322784 4.707106590270996 0.7071067690849304 L 7.292893409729004 3.292893171310425 C 7.683417320251465 3.683417320251465 7.683417320251465 4.316582679748535 7.292893409729004 4.707107067108154 L 4.707106590270996 7.292893409729004 C 4.316582202911377 7.683417320251465 3.683417081832886 7.683417320251465 3.292892932891846 7.292893409729004 L 0.7071067094802856 4.707106590270996 C 0.3165824413299561 4.316582202911377 0.3165824711322784 3.683417320251465 0.7071067690849304 3.292892932891846 Z">--}}
                                {{--</path>--}}
                            {{--</svg></a>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<li><a href="">Menu Item 1</a></li>--}}
                            {{--<li><a href="">Menu Item 2</a></li>--}}
                            {{--<li><a href="">Menu Item 3</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                </ul>
            </div>
            <!-- End Navigation -->

            <div class="row" style="width: 30%; margin-left: 0" id="top-header-right">
                <div class="col-lg-12 col-md-12">
                    <ul id="top-menu-three-btn" style="float: right;">
                        {{--<li><a href=""><img src="{{asset('assets/images/icons/user.svg')}}">&nbsp;Вход</a></li>--}}
                        {{--<li><a href=""><img src="{{asset('assets/images/icons/plus.svg')}}">&nbsp;Регистрация</a></li>--}}
                        <li class="dropdown pull-right">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/images/icons/globe.svg')}}">&nbsp;Русский <i class="fa fa-caret-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="/setLocale/ru">Русский</a></li>
                                <li><a href="/setLocale/tk">Туркменский</a></li>
                                <li><a href="/setLocale/en">English</a></li>
                            </ul>
                        </li>
                        <div class="clearfix"></div>
                        <li style="display: block;" id="bottom-of-three-btn">
                            <a style="display: block; padding: 7px 0; min-width: 200px">{{\Backpack\Settings\app\Models\Setting::get('phone')??'+(993) 12 60-60-60'}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
</header>
<!-- End Header -->