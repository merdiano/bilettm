@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('content')
    <div class="container">
        <div class="row">
            <h2 class="pt-4" >{{__('ClientSide.by_ticket_for', ['event'=>$event->title_])}}</h2>
            <h6 class="g-brd-bottom text-left">{{$venue->venue_name}}</h6>
            <h3 class="my-4 w-100" >{{__('ClientSide.step')}} 1. {{__('ClientSide.checkout_schema')}} </h3>
            <button type="button" class="btn btn-outline-dark px-5 py-3 seats-map" data-toggle="modal" data-target="#exampleModal">
                @lang("Public_ViewEvent.seats_map")
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 800px">
                    <div class="modal-content" style="background-color: unset; border: none; ">
                        <div class="modal-header" style="border-bottom: none">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    style="border: 2px solid #ffffff; border-radius: 100px; padding: 0; opacity: 1">
                                            <span aria-hidden="true"
                                                  style="color: #ffffff; opacity: 1; text-shadow: none; font-weight: lighter; font-size: 35px; padding: 0px !important; width: 30px; height: 30px; display: block; line-height: 31px;">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img class="img-responsive" src="{{asset('user_content/'.$event->venue->seats_image)}}" style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
            @include('desktop.Venues.'.$venue->type)
        </div>

    </div>

@endsection
@section('after_scripts')
    <script>
        $(':checkbox').change(function() {
            var table = $(this).closest('tbody');
            var max_seats = table.data('max');
            var checkedCount = table.find('input:checkbox:checked').length;

            if(checkedCount>max_seats){
                $(this).prop("checked",false)
                showMessage("You have excidid maximum ticket count: "+max_seats)
                return;
            }

            if(this.checked) {
                var ticket = "<span aria-label='"+this.id+"'>"+this.value+"</span>"
               $('.your-selected-seats').append(ticket);

            }
            else{
                $('.your-selected-seats').find("[aria-label='"+this.id+"']").remove();
            }

        });

        $(document).ready(function () {
            $('table').each(function (index,table) {
                disable_rb(table);
            });
        });
        function disable_rb(table) {
            //alert(reserved[0]);
            var disable_list = $(table).data('content');
            // console.warn(JSON.parse(disable_list));
            var table_id = $(table).data('id');
            for(var i=0; i<disable_list.length; i++){

                var objkey = Object.keys(disable_list[i]);
                // console.warn(objkey);
                var obValue = Object.values(disable_list[i])
                 // console.log($('#seat'+table_id+'-'+objkey).val());
                $('#seat'+table_id+'-'+objkey).addClass('input-'+obValue);
                $('#seat'+table_id+'-'+objkey).attr("disabled", true);
            }
        }

    </script>
    @include("Shared.Partials.LangScript")
    {!!HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/frontend.js')!!}
@endsection
