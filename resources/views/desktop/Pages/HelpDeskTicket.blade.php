@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('help')}}
    <section class="movie-items-group firts-child my-5">
        <div class="container">
            <div class="row justify-content-between w-100 m-auto">
                <div>
                    <h1>
                        @lang('ClientSide.support') : {{$ticket->code}}
                    </h1>
                    <div style="height: 4px;width: 100px;background-color: #d43d34;"></div>
                </div>
                <div>
                    <form action="{{route('help.show',['code'=>''])}}" method="GET">
                        {!! Form::text('code', null, array('class'=>'form-control')) !!}}
                    </form>
                </div>
            </div>
            <div class="row w-100 m-auto" style="margin-top: 20px !important;">
                <div class="card w-100" style="border: none;">
                    <div class="card-body" style="height: 400px; overflow-y: scroll; border: 1px solid #eeeeee; border-radius: 5px;">
                        <div class="row justify-content-end">
                            <div class="col-lg-8 col-md-8">
                                <div>
                                    <p style="width: 120px; float: right;">
                                        <strong class="d-block">{{$ticket->owner}} </strong>
                                        <small class="d-block">{{$ticket->created_at->diffForHumans()}}</small>
                                    </p>
                                    <div style="width: calc(100% - 120px);">
                                        <p class="message-one-right" style="margin-bottom: -8px; position: relative; width: calc(100% - 50px); background-color: #e3e3e3; color: #000000; padding: 10px 30px; border-radius: 5px;">{{$ticket->text}}</p>
                                    </div>
                                    <br>
                                    @if($ticket->attachment)
                                        <span><strong>Attachment:</strong> <a href="{{asset('user_content/'.$entry->attachment)}}">{{$entry->attachment}}</a></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @foreach($ticket->comments as $comment)
                            <div class="row @if($comment->user_id)justify-content-start @else justify-content-end @endif ">
                                <div class="col-lg-8 col-md-8">
                                    <div>
                                        <p style="width: 120px; @if($comment->user_id) float: left; @else float: right; @endif">
                                            <strong class="d-block">{{$comment->name}} </strong>
                                            <small class="d-block">{{$comment->created_at->diffForHumans()}}</small>
                                        </p>

                                        <div style="width: calc(100% - 120px); @if($comment->user_id) float: left; @endif">
                                            <p class="@if($comment->user_id) message-one-left @else message-one-right @endif"
                                               style="@if($comment->user_id) background-color: #d43d34; color: #ffffff; @else margin-bottom: -8px; background-color: #e3e3e3; color: #000000; @endif position: relative; width: calc(100% - 50px); padding: 10px 30px; border-radius: 5px;">{{$comment->text}}</p>
                                        </div>
                                        <br>
                                        @if($comment->attachment)
                                            <span><strong>Attachment:</strong> <a href="{{asset('user_content/'.$comment->attachment)}}">{{$comment->attachment}}</a></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card-footer px-0" style="border: none; background-color: transparent">
                        <form action="{{route('help.comment',['code' => $ticket->code])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group custom-theme {{ ($errors->has('text')) ? 'has-error' : '' }}">
                                {!! Form::label('text', trans("ClientSide.message"), array('class'=>'control-label required')) !!}
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
                                @if($errors->has('attachment'))
                                    <p class="help-block">{{ $errors->first('attachment') }}</p>
                                @endif
                            </div>
                            {!! Form::submit(trans("ClientSide.reply"), ['class'=>"btn btn-success", 'style'=>'background-color: #d43d34; border: #d43d34']) !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('after_scripts')


@endsection
