@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])

@section('after_styles')
    <link href="{{asset('vendor/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('category',$category)}}
    @include("desktop.Partials.FilterMenu")

    @yield('inner_content')

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

    <script src="{{asset('vendor/gijgo/gijgo.min.js')}}" type="text/javascript"></script>
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            icons: {
                rightIcon: '{{__("ClientSide.date")}} <i class="fa fa-caret-down"></i>'
            }
        });
    </script>

@endsection
