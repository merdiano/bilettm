@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('help')}}
    <section class="movie-items-group firts-child my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <div class="alert alert-info" role="alert">
                                    <p><strong>{{$ticket->owner}} : </strong>{{$ticket->text}}</p>
                                    <br>
                                    @if($ticket->attachment)
                                        <span><strong>Attachment:</strong> <a href="{{asset('user_content/'.$entry->attachment)}}">{{$entry->attachment}}</a></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @foreach($ticket->comments as $comment)
                            <div class="row">
                                <div class="@if($comment->user_id)col-lg-offset-4 col-md-offset-4 @endif col-lg-8 col-md-8">
                                    <div class="alert alert-success" role="alert">
                                        <p><strong>{{$comment->name}} : </strong>{{$comment->text}}</p><br>
                                        @if($comment->attachment)
                                            <span><strong>Attachment:</strong> <a href="{{asset('user_content/'.$comment->attachment)}}">{{$comment->attachment}}</a></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card-footer">
                        <form action="{{route('ticket.replay.post',['id' => $ticket->getKey()])}}" method="post">
                            @csrf
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
                            {!! Form::submit(trans("ClientSide.create_ticket"), ['class'=>"btn btn-success"]) !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('after_scripts')


@endsection
