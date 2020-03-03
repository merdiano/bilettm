@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')

@endsection
@section('content')
    <section class="my-4">
        <div class="container text_black" style="font-size: 16px;">
            <h3>{{$title}}</h3>
            {!! Markdown::parse($page) !!}
        </div>
    </section>
@endsection
