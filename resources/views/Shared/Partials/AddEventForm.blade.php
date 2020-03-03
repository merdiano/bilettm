<div class="title-and-btn">
    <form action="{{route('add_event')}}" class="row w-100 m-auto ajax" method="post">
        @csrf
    <div class="tab-header d-flex justify-content-between row px-0 m-auto" style="width: calc(100% - 10px)">
        <div class="col-6">
            <h4 class="font-weight-bold">{{__("ClientSide.addEvent")}}</h4>
            <div style="height: 5px; position: absolute; bottom: 15px; width: 100px; background-color: rgba(211,61,51,1)"></div>
        </div>

        <div class="col-6">
            <input type="submit" class="modal-send red_button" style="float: right" value="{{__("ClientSide.send")}}">
            <span style="float: right; font-size: 12px" class="text-right font-weight-bold">*{{__("ClientSide.required")}}</span>
        </div>
    </div>
    <div class="row">

            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="name">{{__("ClientSide.name")}}*</label>
                <input type="text" placeholder="Orazgeldi" name="name" class="form-control" required>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="phone">{{__("ClientSide.phone")}}*</label>
                <input type="text" placeholder="+99362222222"  name="phone" class="form-control" required>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="place">{{__('ClientSide.venue')}}*</label>
                <input type="text" placeholder="{{__('ClientSide.place')}}" name="place" class="form-control" required>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="email">Email*</label>
                <input type="email" name="email" placeholder="Sizin elektron poctanyz" class="form-control" required>
            </div>
            <div class="form-group col-12" style="padding: 0 5px">
                <label for="details">{{__('ClientSide.message')}}*</label>
                <textarea name="details" id="" cols="30" rows="5" placeholder="{{__('ClientSide.message')}}" class="form-control" required></textarea>
            </div>

        <p style="padding: 0 5px; color: #000000; margin: auto; font-size: 13px; font-weight: bold">* {{__("ClientSide.text")}}.</p>
    </div>
    </form>
</div>
