@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')

@endsection
@section('content')
    <section class="mt-4  mb-5">
        <div class="container text_black" style="font-size: 16px;">
            <h4 class="mb-4">{{$title}}</h4>
            {!! Markdown::parse($page) !!}
        </div>
    </section>
@endsection
