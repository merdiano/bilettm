@extends('Bilettm.Layouts.BilettmLayout')

@section('content')

    <section class="page-breadcrumbs">
        <div class="container">
            <div class="row">
                <ul style="padding-left: 30px">
                    <li>
                        <a href="">{{__('ClientSide.home')}}</a>
                    </li>
                    <li>
                        <i class="fa fa-caret-right"></i>
                    </li>
                    <li class="page-name">
                        <a href="">{{__("ClientSide.for_cinema")}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Films Opisanie Buttons section -->
    <section id='cat_and_buttons'>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-4">

                    <select id='vybor_select' >
                        <option class="cat_op" >{{__('ClientSide.week')}}</option>
                        <option class="cat_op">{{__('ClientSide.composers')}}</option>
                        <option class="cat_op">{{__('ClientSide.events')}}</option>
                        <option class="cat_op">{{__('ClientSide.concerts')}}</option>
                    </select>
                </div>
                <div class="col-md-8 col-lg-8 col-8">
                    <div id='cat_buts'>
                        <button class="active_cat_but cat_but">{{__('ClientSide.alternatives')}}</button>
                        <button class="cat_but">{{__('ClientSide.bards')}}</button>
                        <button class="cat_but">{{__('ClientSide.jazz')}}</button>
                        <button class="cat_but">{{__('ClientSide.others')}}</button>
                        <button class="cat_but">{{__('ClientSide.movies')}}</button>
                        <button class="cat_but">{{__('ClientSide.classic')}}</button>
                        <button class="cat_but">{{__('ClientSide.music')}}</button>
                        <button class="cat_but">{{__('ClientSide.musical')}}</button>
                        <button class="cat_but">{{__('ClientSide.ballet')}}</button>
                        <button class="cat_but">{{__('ClientSide.operetta')}}</button>
                        <button class="cat_but">Поп и Эстрада</button>
                        <button class="cat_but">РЕЙВ</button>
                        <button class="cat_but">Рок</button>
                        <button class="cat_but">Романсы</button>
                        <button class="cat_but">Музыкальный спектакль</button>
                        <button class="cat_but">Мюзикл</button>
                        <button class="cat_but">Опера и Балет</button>
                        <button class="cat_but">Оперетта</button>
                        <button class="cat_but">Поп и Эстрада</button>
                        <button class="cat_but">РЕЙВ</button>
                        <button class="cat_but">Рок</button>
                        <button class="cat_but">Романсы</button>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Films opisanie  Buttons end -->
    <!-- Film Opisanie nachalo -->
    <section id='opisanie_section'>
        <div class="container film">
            <div class="row">
                <div class="col-md-3 col-3 col-lg-3">
                    <img class="film_img" src="{{ asset('assets/images/public/EventPage/backgrounds/1.jpg') }}"/>
                </div>
                <div class="col-md-6 col-lg-6 col-6">
                    <div class="film_op">
                        <div class="date">
                            <div class="day">
                                <h4>13 сентября</h4>
                                <h6>19:00, пятница</h6>
                            </div>
                        </div>
                        <h2 class="film_name"><a href="#">"Человек-паук Вдали от дома"</a></h2>
                        <span>В кино с 4 июля</span>
                        <p class="op_text">
                            Питер Паркер вместе с друзьями отправляется на летние каникулы в Европу. Однако отдохнуть приятелям вряд ли удастся — Питеру придется согласиться помочь Нику Фьюри раскрыть тайну существ, вызывающих стихийные бедствия и разрушения по всему континенту.
                        </p>
                        <div class="buy_and_salary">
                            <a class="buy_button" href="#">Купить</a> <span>250 tmt</span>
                        </div>
                    </div>
                </div>
                <!-- Calendar -->
                <div class="col-md-3 col-lg-3 col-3">
                    <div id='calendar_block'>
                        <div align=center>
                            <div style="width:100%; border:1px solid #c0c0c0; padding:6px;">
                                <table id="calendar"  border="0" cellspacing="0" cellpadding="1">
                                    <thead><tr><td><b>‹</b><td colspan="5"><td><b>›</b><tr><td>Пн</td><td>Вт</td><td>Ср</td><td>Чт</td><td>Пт</td><td>Сб</td><td>Вс</td></thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Calendar end -->
            </div>
        </div>

        <div class="container film">
            <div class="row">
                <div class="col-md-3 col-3 col-lg-3">
                    <img class="film_img" src="{{ asset('assets/images/public/EventPage/backgrounds/1.jpg') }}"/>
                </div>
                <div class="col-md-6 col-lg-6 col-6">
                    <div class="film_op">
                        <div class="date">
                            <div class="day">
                                <h4>13 сентября</h4>
                                <h6>19:00, пятница</h6>
                            </div>
                        </div>
                        <h2 class="film_name"><a href="#">"Человек-паук Вдали от дома"</a></h2>
                        <span>В кино с 4 июля</span>
                        <p class="op_text">
                            Питер Паркер вместе с друзьями отправляется на летние каникулы в Европу. Однако отдохнуть приятелям вряд ли удастся — Питеру придется согласиться помочь Нику Фьюри раскрыть тайну существ, вызывающих стихийные бедствия и разрушения по всему континенту.
                        </p>
                        <div class="buy_and_salary">
                            <a class="buy_button" href="#">Купить</a> <span>250 tmt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container film">
            <div class="row">
                <div class="col-md-3 col-3 col-lg-3">
                    <img class="film_img" src="{{ asset('assets/images/public/EventPage/backgrounds/1.jpg') }}"/>
                </div>
                <div class="col-md-6 col-lg-6 col-6">
                    <div class="film_op">
                        <div class="date">
                            <div class="day">
                                <h4>13 сентября</h4>
                                <h6>19:00, пятница</h6>
                            </div>
                        </div>
                        <h2 class="film_name"><a href="#">"Человек-паук Вдали от дома"</a></h2>
                        <span>В кино с 4 июля</span>
                        <p class="op_text">
                            Питер Паркер вместе с друзьями отправляется на летние каникулы в Европу. Однако отдохнуть приятелям вряд ли удастся — Питеру придется согласиться помочь Нику Фьюри раскрыть тайну существ, вызывающих стихийные бедствия и разрушения по всему континенту.
                        </p>
                        <div class="buy_and_salary">
                            <a class="buy_button" href="#">Купить</a> <span>250 tmt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container film">
            <div class="row">
                <div class="col-md-3 col-3 col-lg-3">
                    <img class="film_img" src="{{ asset('assets/images/public/EventPage/backgrounds/1.jpg') }}"/>
                </div>
                <div class="col-md-6 col-lg-6 col-6">
                    <div class="film_op">
                        <div class="date">
                            <div class="day">
                                <h4>13 сентября</h4>
                                <h6>19:00, пятница</h6>
                            </div>
                        </div>
                        <h2 class="film_name"><a href="#">"Человек-паук Вдали от дома"</a></h2>
                        <span>В кино с 4 июля</span>
                        <p class="op_text">
                            Питер Паркер вместе с друзьями отправляется на летние каникулы в Европу. Однако отдохнуть приятелям вряд ли удастся — Питеру придется согласиться помочь Нику Фьюри раскрыть тайну существ, вызывающих стихийные бедствия и разрушения по всему континенту.
                        </p>
                        <div class="buy_and_salary">
                            <a class="buy_button" href="#">Купить</a> <span>250 tmt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container film">
            <div class="row">
                <div class="col-md-3 col-3 col-lg-3">
                    <img class="film_img" src="{{ asset('assets/images/public/EventPage/backgrounds/1.jpg') }}"/>
                </div>
                <div class="col-md-6 col-lg-6 col-6">
                    <div class="film_op">
                        <div class="date">
                            <div class="day">
                                <h4>13 сентября</h4>
                                <h6>19:00, пятница</h6>
                            </div>
                        </div>
                        <h2 class="film_name"><a href="#">"Человек-паук Вдали от дома"</a></h2>
                        <span>В кино с 4 июля</span>
                        <p class="op_text">
                            Питер Паркер вместе с друзьями отправляется на летние каникулы в Европу. Однако отдохнуть приятелям вряд ли удастся — Питеру придется согласиться помочь Нику Фьюри раскрыть тайну существ, вызывающих стихийные бедствия и разрушения по всему континенту.
                        </p>
                        <div class="buy_and_salary">
                            <a class="buy_button" href="#">Купить</a> <span>250 tmt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container film">
            <div class="row">
                <div class="col-md-9 col-lg-9 col-sm-9 col-9">
                    <div class="pagination_blk">
                        <span>Видно на странице - 5/48</span>
                        <div class="arrows_block">
                            <a  class='arrows' id='left_arrow' href="#"><img src="assets/assets/img/icons/left.png"></a><a class='arrows' id='right_arrow' href="#"><img src="assets/assets/img/icons/right.png"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection