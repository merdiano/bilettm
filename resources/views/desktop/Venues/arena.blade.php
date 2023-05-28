<div class="row">
    <div class="col-12">
        <h2 class="pt-5 my-4" >{{__('ClientSide.step')}} 2. {{__('ClientSide.choose_sector')}}</h2>
        <div class="pills-struct mt-5">
            <ul role="tablist" class="nav nav-pills m-auto w-auto justify-content-center" id="choose_seats">
                @foreach($venue->sectors as $sector)
                    <li class="active" role="presentation" style="display: inline-block;">
                        <a aria-expanded="true" data-toggle="tab" class="btn btn-lg @if ($loop->first)active @endif show"
                           role="tab" id="home_tab_{{$sector->id}}" href="#home_{{$sector->id}}" aria-selected="true">
                            {{$sector->title}}

                        </a>
                    </li>
                @endforeach
            </ul>

            <h2 class="pt-5 my-4" >{{__('ClientSide.step')}} 3. {{__('ClientSide.choose_seat')}}</h2>
            <div class="mt-2 mb-4">
                <span class="pr-5"><i class="fa fa-circle" style="color: #ebeced; font-size: 13px"></i> {{__('ClientSide.available')}}</span>
                <span class="pr-5"><i class="fa fa-circle" style="color: #06b84d; font-size: 13px"></i> {{__('ClientSide.booked')}}</span>
                <span class="pr-5"><i class="fa fa-circle" style="color: #4e5ced; font-size: 13px"></i> {{__('ClientSide.reserved')}}</span>
                <span class="pr-5"><i class="fa fa-circle" style="color: #ff4159; font-size: 13px"></i> {{__('ClientSide.selection')}}</span>
            </div>

        </div>
    </div>
</div>