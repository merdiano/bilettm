@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('help')}}

<section class="movie-items-group firts-child my-5" style="margin-bottom: 100px !important;">
    <div class="container">
        <div class="row justify-content-between w-100 m-auto">
            <div>
                <h1>
                    @lang('ClientSide.support')
                </h1>
                <div style="height: 4px;width: 100px;background-color: #d43d34;"></div>
            </div>
            <div>
                <form action="{{route('help.show','')}}" method="GET" id="helpSearchForm" style="position: relative">
                    {!! Form::text('code', null, array('class'=>'form-control','placeholder' => trans('ClientSide.search_ticket'), 'style'=>'padding: 10px;width: 300px;border: 1px solid #d43d34;')) !!}
                    <a id="helpSearchSubmit" style="position: absolute; cursor: pointer; top: 9px; right: 15px;"><i class="fa fa-search" style="color: #d43d34; font-size: 22px;"></i></a>
                </form>
            </div>
        </div>
        <div class="row w-100 m-auto">
            <div class="col-12 p-0 black-text-wrapper"><p class="my-4">@lang('ClientSide.support_form_text')</p></div>
            <div class="col-12 p-0">
                <form action="{{route('help.create')}}" method="POST" enctype="multipart/form-data" class="row w-100 m-auto">
                    @csrf

                    <div class="form-group col-4 pl-0">
                        {!! Form::label('name', trans("ClientSide.name"), array('class'=>'control-label')) !!}
                        {!! Form::text('name', old('name'),array('class'=>'form-control', 'placeholder'=>'Пример: Аман' ))  !!}
                    </div>
                    <div class="form-group col-4 {{ ($errors->has('email')) ? 'has-error' : '' }}">
                        {!! Form::label('email', trans("ClientSide.email"), array('class'=>'control-label required')) !!}
                        {!! Form::text('email', old('email'),array('class'=>'form-control', 'placeholder'=>'Пример: aman@mail.ru' ))  !!}
                        @if($errors->has('email'))
                            <p class="help-block">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="form-group col-4 pr-0">
                        {!! Form::label('phone', trans("ClientSide.phone"), array('class'=>'control-label')) !!}
                        {!! Form::text('phone', old('phone'),array('class'=>'form-control', 'placeholder'=>'Пример: +993 65555555' ))  !!}
                    </div>

                    <div class="form-group col-8 pl-0 {{ ($errors->has('topic')) ? 'has-error' : '' }}">
                        {!! Form::label('topic', trans("ClientSide.support_topic"), array('class'=>'control-label')) !!}
                        {!! Form::select('topic',help_topics(), old('topic'), ['placeholder'=>trans('ClientSide.please_select'),'class' => 'form-control','id'=>'topic']) !!}
                        @if($errors->has('topic'))
                            <p class="help-block">{{ $errors->first('topic') }}</p>
                        @endif
                    </div>
                    <div class="form-group col-4 d-none">
                        {!! Form::label('subject', trans("ClientSide.support_subject"), array('class'=>'control-label')) !!}
                        {!! Form::text('subject', old('subject',trans('ClientSide.other')),array('class'=>'form-control' ))  !!}
                    </div>
                    <div class="form-group col-4 pr-0 {{ ($errors->has('attachment')) ? 'has-error' : '' }}">
                        {!! Form::label('attachment', trans("ClientSide.attachment"), array('class'=>'control-label')) !!}
                        {!! Form::file('attachment', array('class'=>'form-control')) !!}
                        @if($errors->has('attachment'))
                            <p class="help-block">{{ $errors->first('attachment') }}</p>
                        @endif
                    </div>
                    <div class="form-group col-12 p-0 custom-theme {{ ($errors->has('text')) ? 'has-error' : '' }}">
                        {!! Form::label('text', trans("ClientSide.message"), array('class'=>'control-label required')) !!}
                        {!! Form::textarea('text', old('text'),
                                    array(
                                    'class'=>'form-control  editable',
                                    'placeholder'=>'Опишите вашу проблему',
                                    'rows' => 5
                                    ))  !!}
                        @if($errors->has('text'))
                            <p class="help-block">{{ $errors->first('text') }}</p>
                        @endif
                    </div>
                    {!! Form::submit(trans("ClientSide.submit_ticket"), ['class'=>"btn btn-success", 'style'=>'background-color: #d43d34; border: #d43d34;padding: 10px 30px;']) !!}


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

                subject.val('');

            }else{

                subject.parent().addClass('d-none');

                subject.val(this.options[this.selectedIndex].text);
            }

            subject.trigger('change');

        });
    </script>


@endsection
