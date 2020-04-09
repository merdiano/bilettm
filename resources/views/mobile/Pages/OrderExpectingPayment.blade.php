@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])

@section('content')

    <section id="intro" class="container">
        <div class="row justify-content-center">
            <div class=" my-5 pt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 240 240">
                    <g id="_x31_3-Info_Box" transform="translate(0 0)">
                        <path id="Path_448" data-name="Path 448" d="M110.235.388C52.643,4.939,5.79,51.177.518,108.707a119.8,119.8,0,0,0,13.142,66.9,28.666,28.666,0,0,1,1.448,23.185L0,240l43.655-14.553a28.5,28.5,0,0,1,21.948,1.51,119.809,119.809,0,0,0,66.8,12.418c57.074-5.748,102.679-52.411,107.205-109.594A120.03,120.03,0,0,0,110.235.388Z" transform="translate(0 0)" fill="#d33d33"/>
                        <ellipse id="Ellipse_164" data-name="Ellipse 164" cx="99.257" cy="99.258" rx="99.257" ry="99.258" transform="translate(20.486 21)" fill="#fff"/>
                        <ellipse id="Ellipse_165" data-name="Ellipse 165" cx="12" cy="12.5" rx="12" ry="12.5" transform="translate(107.742 49.118)" fill="#e83132"/>
                        <path id="Path_449" data-name="Path 449" d="M38.387,117.969h0A12.386,12.386,0,0,1,26,105.581V35.387A12.386,12.386,0,0,1,38.387,23h0A12.386,12.386,0,0,1,50.774,35.387v70.194A12.386,12.386,0,0,1,38.387,117.969Z" transform="translate(81.613 72.306)" fill="#e83132"/>
                    </g>
                </svg>
            </div>
            <div class="col-md-12 text-center mb-5 pb-5">

                <h1 property="name" style="font-weight: bold">@lang('ClientSide.checkout_fail_title')</h1>
                <p class="pb-5 mb-5">
                    @lang('ClientSide.checkout_fail_text')
                </p>
                <a class="btn btn-danger" href="#">@lang('ClientSide.checkout_fail_button')</a>
            </div>
        </div>
    </section>


@stop
