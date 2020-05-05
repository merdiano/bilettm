@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('help')}}

<section class="movie-items-group firts-child my-5">
    <div class="container">
        <div class="row justify-content-center">
            <p class="my-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque libero mollitia nemo, nobis odit quasi quidem quisquam sunt. Cupiditate dolores nisi nostrum officiis provident quasi recusandae unde voluptate. Eos, suscipit!</p>
            <div class="col-6">
                <form action="{{route('help.create')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        {!! Form::label('name', trans("ClientSide.name"), array('class'=>'control-label')) !!}
                        {!! Form::text('name', old('name'),array('class'=>'form-control' ))  !!}
                    </div>
                    <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                        {!! Form::label('email', trans("ClientSide.email"), array('class'=>'control-label required')) !!}
                        {!! Form::text('email', old('email'),array('class'=>'form-control' ))  !!}
                        @if($errors->has('email'))
                            <p class="help-block">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', trans("ClientSide.phone"), array('class'=>'control-label')) !!}
                        {!! Form::text('phone', old('phone'),array('class'=>'form-control' ))  !!}
                    </div>

                    <div class="form-group {{ ($errors->has('topic')) ? 'has-error' : '' }}">
                        {!! Form::label('topic', trans("ClientSide.topic"), array('class'=>'control-label')) !!}
                        {!! Form::select('topic',help_topics(), old('topic'), ['placeholder'=>trans('ClientSide.please_select'),'class' => 'form-control','id'=>'topic']) !!}
                        @if($errors->has('topic'))
                            <p class="help-block">{{ $errors->first('topic') }}</p>
                        @endif
                    </div>
                    <div class="form-group d-none">
                        {!! Form::label('subject', trans("ClientSide.subject"), array('class'=>'control-label')) !!}
                        {!! Form::text('subject', old('subject',trans('ClientSide.other')),array('class'=>'form-control' ))  !!}
                    </div>
                    <div class="form-group custom-theme {{ ($errors->has('text')) ? 'has-error' : '' }}">
                        {!! Form::label('text', trans("ClientSide.text"), array('class'=>'control-label required')) !!}
                        {!! Form::textarea('text', old('text'),
                                    array(
                                    'class'=>'form-control  editable',
                                    'rows' => 5
                                    ))  !!}
                        @if($errors->has('text'))
                            <p class="help-block">{{ $errors->first('text') }}</p>
                        @endif
                    </div>
                    <div class="form-group {{ ($errors->has('attachment')) ? 'has-error' : '' }}">
                        {!! Form::label('attachment', trans("ClientSide.attachment"), array('class'=>'control-label')) !!}
                        {!! Form::file('attachment') !!}
                    </div>
                    {!! Form::submit(trans("ClientSide.create_ticket"), ['class'=>"btn btn-success"]) !!}
                    @if($errors->has('attachment'))
                        <p class="help-block">{{ $errors->first('attachment') }}</p>
                    @endif

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('after_scripts')
    <script>
        $('select[name=topic]').on('change', function() {
            // alert(this.options[this.selectedIndex].text);
            let  subject = $('input[name=subject]');
            if(this.options[this.selectedIndex].value == 0)
            {

                subject.parent().removeClass('d-none');

                subject.val('bosh');

            }else{

                subject.parent().addClass('d-none');

                subject.val(this.options[this.selectedIndex].text);
            }

            subject.trigger('change');

        });
    </script>


@endsection
