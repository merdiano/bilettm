<footer class="mob-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center g-color-white font-weight-bold">{{__('ClientSide.want')}}</h2>
                <p class="text-center g-color-white">{{__("ClientSide.email_for")}}</p>
            </div>
        </div>
        <form action="{{route('subscription')}}" method="POST" class="row ajax">
            @csrf
            <div class="form-group col-8 pr-1">
                <input type="text" class="form-control" placeholder="{{__("ClientSide.email")}}">
            </div>
            <div class="form-group col-4 pl-1">
                <input type="submit" class="form-control" value="{{__("ClientSide.subscribe")}}">
            </div>
        </form>
        <div class="row pt-4">
            <div class="col-6">
                <ul>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'introduction'])}}">{{__('ClientSide.introduction')}}</a></li>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'questions'])}}">{{__("ClientSide.questions")}}</a></li>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'oferta'])}}">{{__("ClientSide.oferta")}}</a></li>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'partners'])}}">{{__("ClientSide.partners")}}</a></li>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'contacts'])}}">{{__("ClientSide.contacts")}}</a></li>
                </ul>
            </div>
            <div clas="col-6">
                <ul>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'refund'])}}">{{__("ClientSide.refund")}}</a></li>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'organizers'])}}">{{__("ClientSide.organizers")}}</a></li>
                    <li><a class='text-uppercase' href="{{route('about',['page'=>'concert_halls'])}}">{{__("ClientSide.concert_halls")}}</a></li>
                    <li><a style="color: #ffffff; cursor: pointer" data-toggle="modal" data-target="#exampleModalCenter">{{__("ClientSide.addEvent")}}</a></li>
                </ul>
            </div>
        </div>
        <div class="row text-center">
            <p class="all-rights">© {{Carbon::now()->year}} {{__("ClientSide.ticket_service")}} Billettm.com. {{__("ClientSide.copyright")}}.</p>
        </div>
    </div>
</footer>

@push('after_scripts')
    <script>
        $('.header-search-a').click(function () {
            $('.navbar-toggler').click();
            $('.search-input-box').focus();

        })
    </script>
@endpush
