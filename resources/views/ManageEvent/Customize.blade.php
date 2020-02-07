{{-- @todo Rewrite the JS for choosing event bg images and colours. --}}
@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang("Event.customize_event")
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <i class="ico-cog mr5"></i>
    @lang("Event.customize_event")
@stop

@section('page_header')
    <style>
        .page-header {
            display: none;
        }
    </style>
@stop

@section('head')
    {{--{!! HTML::script('https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key='.config("services.google_places.key")) !!}--}}
    {{--{!! HTML::script('vendor/geocomplete/jquery.geocomplete.min.js') !!}--}}
    <script>
        $(function () {

            $("input[name='organiser_fee_percentage']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                verticalbuttons: true,
                forcestepdivisibility: 'none',
                postfix: '%',
                buttondown_class: "btn btn-link",
                buttonup_class: "btn btn-link",
                postfix_extraclass: "btn btn-link"
            });
            $("input[name='organiser_fee_fixed']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.01,
                decimals: 2,
                verticalbuttons: true,
                postfix: 'mnt',
                buttondown_class: "btn btn-link",
                buttonup_class: "btn btn-link",
                postfix_extraclass: "btn btn-link"
            });

            /* Affiliate generator */
            $('#affiliateGenerator').on('keyup', function () {
                var text = $(this).val().replace(/\W/g, ''),
                        referralUrl = '{{$event->event_url}}?ref=' + text;

                $('#referralUrl').toggle(text !== '');
                $('#referralUrl input').val(referralUrl);
            });

            {{--/* Background selector */--}}
            {{--$('.bgImage').on('click', function (e) {--}}
                {{--$('.bgImage').removeClass('selected');--}}
                {{--$(this).addClass('selected');--}}
                {{--$('input[name=bg_image_path_custom]').val($(this).data('src'));--}}

                {{--var replaced = replaceUrlParam('{{route('showEventPagePreview', ['event_id'=>$event->id])}}', 'bg_img_preview', $('input[name=bg_image_path_custom]').val());--}}
                {{--document.getElementById('previewIframe').src = replaced;--}}
                {{--e.preventDefault();--}}
            {{--});--}}

            {{--/* Background color */--}}
            {{--$('input[name=bg_color]').on('change', function (e) {--}}
                {{--var replaced = replaceUrlParam('{{route('showEventPagePreview', ['event_id'=>$event->id])}}', 'bg_color_preview', $('input[name=bg_color]').val().substring(1));--}}
                {{--document.getElementById('previewIframe').src = replaced;--}}
                {{--e.preventDefault();--}}
            {{--});--}}

            {{--$('#bgOptions .panel').on('shown.bs.collapse', function (e) {--}}
                {{--var type = $(e.currentTarget).data('type');--}}
                {{--console.log(type);--}}
                {{--$('input[name=bg_type]').val(type);--}}
            {{--});--}}

            {{--$('input[name=bg_image_path], input[name=bg_color]').on('change', function () {--}}
                {{--//showMessage('Uploading...');--}}
                {{--//$('.customizeForm').submit();--}}
            {{--});--}}

            /* Color picker */
            $('.colorpicker').minicolors();

            $('#ticket_design .colorpicker').on('change', function (e) {
                var borderColor = $('input[name="ticket_border_color"]').val();
                var bgColor = $('input[name="ticket_bg_color"]').val();
                var textColor = $('input[name="ticket_text_color"]').val();
                var subTextColor = $('input[name="ticket_sub_text_color"]').val();

                $('.ticket').css({
                    'border': '1px solid ' + borderColor,
                    'background-color': bgColor,
                    'color': subTextColor,
                    'border-left-color': borderColor
                });
                $('.ticket h4').css({
                    'color': textColor
                });
                $('.ticket .logo').css({
                    'border-left': '1px solid ' + borderColor,
                    'border-bottom': '1px solid ' + borderColor
                });
                $('.ticket .barcode').css({
                    'border-right': '1px solid ' + borderColor,
                    'border-bottom': '1px solid ' + borderColor,
                    'border-top': '1px solid ' + borderColor
                });

            });

            $('#enable_offline_payments').change(function () {
                $('.offline_payment_details').toggle(this.checked);
            }).change();
        });


    </script>

    <style type="text/css">
        .bootstrap-touchspin-postfix {
            background-color: #ffffff;
            color: #333;
            border-left: none;
        }

        .bgImage {
            cursor: pointer;
        }

        .bgImage.selected {
            outline: 4px solid #0099ff;
        }
    </style>
    <script>
        $(function () {

            var hash = document.location.hash;
            // var prefix = "tab_";
            if (hash) {
                $('.nav-tabs a[href=' + hash + ']').tab('show');
            }

            $(window).on('hashchange', function () {
                var newHash = location.hash;
                if (typeof newHash === undefined) {
                    $('.nav-tabs a[href=' + '#general' + ']').tab('show');
                } else {
                    $('.nav-tabs a[href=' + newHash + ']').tab('show');
                }

            });

            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            });

        });


    </script>

@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- tab -->
            <ul class="nav nav-tabs">
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'general'])}}"
                    class="{{($tab == 'general' || !$tab) ? 'active' : ''}}"><a href="#general" data-toggle="tab">@lang("basic.general")</a>
                </li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'design'])}}"
                    class="{{$tab == 'design' ? 'active' : ''}}"><a href="#design" data-toggle="tab">@lang("basic.event_page_design")</a></li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'order_page'])}}"
                    class="{{$tab == 'order_page' ? 'active' : ''}}"><a href="#order_page" data-toggle="tab">@lang("basic.order_form")</a></li>

{{--                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'social'])}}"--}}
{{--                    class="{{$tab == 'social' ? 'active' : ''}}"><a href="#social" data-toggle="tab">@lang("basic.social")</a></li>--}}
{{--                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'affiliates'])}}"--}}
{{--                    class="{{$tab == 'affiliates' ? 'active' : ''}}"><a href="#affiliates"--}}
{{--                                                                        data-toggle="tab">@lang("basic.affiliates")</a></li>--}}
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'fees'])}}"
                    class="{{$tab == 'fees' ? 'active' : ''}}"><a href="#fees" data-toggle="tab">@lang("basic.service_fees")</a></li>
{{--                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'ticket_design'])}}"--}}
{{--                    class="{{$tab == 'ticket_design' ? 'active' : ''}}"><a href="#ticket_design" data-toggle="tab">@lang("basic.ticket_design")</a></li>--}}

            </ul>
            <!--/ tab -->
            <!-- tab content -->
            <div class="tab-content panel">
                <div class="tab-pane {{($tab == 'general' || !$tab) ? 'active' : ''}}" id="general">
                    @include('ManageEvent.Partials.EditEventForm', ['event'=>$event, 'organisers'=>organisers()])
                </div>
                <div class="tab-pane scale_iframe {{$tab == 'design' ? 'active' : ''}}" id="design">

                    <div class="row">

                        <div class="col-sm-12">
                            <h4>@lang("Design.event_page_preview")</h4>

                            <div class="iframe_wrap" style="overflow:hidden; height: 600px; border: 1px solid #ccc;">
                                <iframe id="previewIframe"
                                        src="{{route('showEventPagePreview', ['event_id'=>$event->id])}}"
                                        frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%"
                                        width="100%">
                                </iframe>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane {{$tab == 'fees' ? 'active' : ''}}" id="fees">
                    {!! Form::model($event, array('url' => route('postEditEventFees', ['event_id' => $event->id]), 'class' => 'ajax')) !!}
                    <h4>@lang("Fees.organiser_fees")</h4>

                    <div class="well">
                        {!! @trans("Fees.organiser_fees_text") !!}
                    </div>

                    <div class="form-group col-md-6 col-sm-12">
                        {!! Form::label('organiser_fee_percentage', trans("Fees.service_fee_percentage"), array('class'=>'control-label required')) !!}
                        {!!  Form::text('organiser_fee_percentage', $event->organiser_fee_percentage, [
                            'class' => 'form-control',
                            'placeholder' => trans("Fees.service_fee_percentage_placeholder")
                        ])  !!}
                        <div class="help-block">
                            {!! @trans("Fees.service_fee_percentage_help") !!}
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        {!! Form::label('organiser_fee_fixed', trans("Fees.service_fee_fixed_price"), array('class'=>'control-label required')) !!}
                        {!!  Form::text('organiser_fee_fixed', null, [
                            'class' => 'form-control',
                            'placeholder' => trans("Fees.service_fee_fixed_price_placeholder")
                        ])  !!}
                        <div class="help-block">
                            {!! @trans("Fees.service_fee_fixed_price_help", ["cur"=>$event->currency_symbol]) !!}
                        </div>
                    </div>
                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit(trans("basic.save_changes"), ['class'=>"btn btn-success"]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

                <div class="tab-pane {{$tab == 'order_page' ? 'active' : ''}}" id="order_page">
                    {!! Form::model($event, array('url' => route('postEditEventOrderPage', ['event_id' => $event->id]), 'class' => 'ajax ')) !!}
                    <h4>@lang("Order.order_page_settings")</h4>

                    <div class="form-group">
                        {!! Form::label('pre_order_display_message', trans("Order.before_order"), array('class'=>'control-label ')) !!}

                        {!!  Form::textarea('pre_order_display_message', $event->pre_order_display_message, [
                            'class' => 'form-control',
                            'rows' => 4
                        ])  !!}
                        <div class="help-block">
                            @lang("Order.before_order_help")
                        </div>

                    </div>
                    <div class="form-group">
                        {!! Form::label('post_order_display_message', trans("Order.after_order"), array('class'=>'control-label ')) !!}

                        {!!  Form::textarea('post_order_display_message', $event->post_order_display_message, [
                            'class' => 'form-control',
                            'rows' => 4
                        ])  !!}
                        <div class="help-block">
                            @lang("Order.after_order_help")
                        </div>
                    </div>

                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit(trans("basic.save_changes"), ['class'=>"btn btn-success"]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
            <!--/ tab content -->
        </div>
    </div>
@stop
