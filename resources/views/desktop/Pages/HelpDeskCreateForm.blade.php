@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('help')}}

<section class="movie-items-group firts-child my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="{{route('help.create')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        {!! Form::label('name', trans("ClientSide.name"), array('class'=>'control-label')) !!}
                        {!! Form::text('name', old('name'),array('class'=>'form-control' ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', trans("ClientSide.email"), array('class'=>'control-label required')) !!}
                        {!! Form::text('email', old('email'),array('class'=>'form-control' ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', trans("ClientSide.phone"), array('class'=>'control-label')) !!}
                        {!! Form::text('phone', old('phone'),array('class'=>'form-control' ))  !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('topic', trans("ClientSide.topic"), array('class'=>'control-label')) !!}
                        {!! Form::select('topic',help_topics(), old('topic'), ['placeholder'=>trans('ClientSide.please_select'),'class' => 'form-control','id'=>'topic']) !!}
                    </div>
                    <div class="form-group hidden">
                        {!! Form::label('subject', trans("ClientSide.subject"), array('class'=>'control-label')) !!}
                        {!! Form::text('subject', old('subject',trans('ClientSide.other')),array('class'=>'form-control' ))  !!}
                    </div>
                    <div class="form-group custom-theme">
                        {!! Form::label('text', trans("ClientSide.text"), array('class'=>'control-label required')) !!}
                        {!! Form::textarea('text', old('text'),
                                    array(
                                    'class'=>'form-control  editable',
                                    'rows' => 5
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('attachment', trans("ClientSide.attachment"), array('class'=>'control-label')) !!}
                        {!! Form::file('attachment') !!}
                    </div>
                    {!! Form::submit(trans("ClientSide.create_ticket"), ['class'=>"btn btn-success"]) !!}
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('after_scripts')
    <script>
        $('select[name="topic"]').on('change', function() {
            $('input[name="subject"]').val(this.html());
        });
    </script>


@endsection
