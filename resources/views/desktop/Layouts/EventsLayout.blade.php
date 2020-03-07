@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])

@section('after_styles')
    <link href="{{asset('vendor/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('category',$category)}}
    @include("Shared.Partials.FilterMenu")

    @yield('inner_content')

{{--    <section id="first-add-wrapper" style="margin: 100px 0;">--}}
{{--        <div class="container">--}}
{{--            <div class="row" style="padding: 0 20px;">--}}
{{--                <a href="" style="width: 100%">--}}
{{--                    <img src="{{asset('assets/images/advs/first.png')}}" style="width: 100%">--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

@endsection
@push('after_styles')
<style type="text/css">
    .red_button{
        color: #ffffff;
        background-color: #d33d33;
        height: fit-content;
        font-size: 20px;
        padding: 12px 60px;
        border-radius: 5px;
        margin-right: 5px;
        transition-property: background-color;
        transition-duration: .2s;
    }
</style>
@endpush
@section('after_scripts')

    <script src="{{asset('assets/javascript/hs.core.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/javascript/components/hs.datepicker.js')}}" type="text/javascript"></script>
    <script>
        {{--$('#datepicker').datepicker({--}}
        {{--    uiLibrary: 'bootstrap4',--}}
        {{--    icons: {--}}
        {{--        rightIcon: '{{__("ClientSide.date")}} <i class="fa fa-caret-down"></i>'--}}
        {{--    }--}}
        {{--}).on('changeDate', function(e) {--}}
        {{--    console.log(e.format());--}}
        {{--});--}}
            $.HSCore.components.HSDatepicker.init('#datepicker');

    </script>

@endsection
