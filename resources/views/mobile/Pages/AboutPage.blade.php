@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')

@endsection
@section('content')
    <section class="my-3">
        <div class="container">
            <h2>{{$title}}</h2>
            {!! Markdown::parse($page) !!}
        </div>
    </section>
@endsection
