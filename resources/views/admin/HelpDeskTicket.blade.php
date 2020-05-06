@extends("backpack::layout")
@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name !!}</span>
            <small>{!! $crud->getSubheading() ?? '#'.$entry->code !!}.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">{{ trans('backpack::crud.preview') }}</li>
        </ol>
    </section>
    @endsection

@section('content')
    @if ($crud->hasAccess('list'))
        <a href="{{ url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>

        <a href="javascript: window.print();" class="pull-right hidden-print"><i class="fa fa-print"></i></a>
    @endif

    <div class="row">
        <div class="{{ $crud->getShowContentClass() }}">

            <!-- Default box -->
            <div class="m-t-20">
                <div class="box no-padding no-border">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <strong>Name :</strong>
                            </td>
                            <td>
                                {{$entry->name}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>
                                    Email :
                                </strong>
                            </td>
                            <td>{{$entry->email}}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Phone :</strong>
                            </td>
                            <td>{{$entry->phone}}</td>
                        </tr>
                        <tr>
                            <td><strong>Subject : </strong></td>
                            <td colspan="5">{{$entry->subject}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="alert alert-info" role="alert">
                                <p><strong>{{$entry->owner}} : </strong>{{$entry->text}}</p>
                                <br>
                                @if($entry->attachment)
                                    <span><strong>Attachment:</strong> <a href="{{asset('user_content/'.$entry->attachment)}}">{{$entry->attachment}}</a></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @foreach($entry->comments as $comment)
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
                    <form action="{{route('ticket.replay.post',['id' => $entry->getKey()])}}" method="post">
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
@endsection
