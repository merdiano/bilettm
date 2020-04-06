<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">
            <img src="{{asset('assets/images/logo/bilet-logo.svg')}}" style="height: 46px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars"></span>
        </button>

        <a class="header-search-a"><i class="fa fa-search text-white"></i></a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="width: 100%; padding: 10px 30px;box-shadow: 0px 0px 10px rgba(0,0,0,.3)">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item @if(Route::currentRouteName()=='home') active @endif">
                    <a class="nav-link" href="/">@lang('ClientSide.home') <span class="sr-only">(current)</span></a>
                </li>
                @foreach(category_menu() as $category)
                <li class="nav-item">
                    <a class="nav-link @if(url()->current()==$category->url) active @endif" href="{{$category->url}}">{{$category->title}}</a>
                </li>
                @endforeach
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">@lang('ClientSide.concert_halls')
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        @foreach(venues_list() as $id => $venue)
                            <li>
                                <a href="{{route('venues',['id'=>$id])}}">{{$venue}}</a></li>
                        @endforeach
                    </ul>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0" action="{{route('search')}}" method="GET">
                <input class="form-control mr-sm-2 search-input-box" type="search" name="q" placeholder="{{__('ClientSide.placeholder')}}" aria-label="Search">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" style="width: 100%;">{{__('ClientSide.search')}}</button>
            </form>
        </div>
    </nav>
</header>
