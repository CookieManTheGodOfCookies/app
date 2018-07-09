@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'USER')
        <div class="container">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <form method="post" action="{{ url('/send') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="panel-heading">
                            Feedback form
                        </div>
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('theme') ? ' has-error' : '' }}">
                                <label for="theme" class="control-label">Theme</label>
                                <input type="text" id="theme" name="theme" class="form-control">
                                @if($errors->has('theme'))
                                    <div class="help-block">
                                        {{ $errors->first('theme') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                                <label for="message" class="control-label">Message</label>
                                <textarea id="message" name="message" class="form-control"
                                          style="min-height: 150px;"></textarea>
                                @if($errors->has('message'))
                                    <div class="help-block">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="attachedFile" class="control-label">Attach a file</label>
                                <input type="file" name="file" id="attachedFile">
                            </div>
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    <span>{{session()->get('status')}}</span>
                                </div>
                            @endif
                            @if($errors->has('timeError'))
                                <div class="alert alert-danger">
                                    <span>{{$errors->first('timeError')}}</span>
                                </div>
                            @endif
                        </div>
                        <div class="panel-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Your applications
                    </div>
                    <div class="panel-body pre-scrollable">
                        @if(isset($applications))
                        @foreach($applications as $application)
                            <div class="panel {{ $application->checked_by_manager ? ' panel-success' : ' panel-default'}}">
                                <div class="panel-heading">
                                    {{$application->theme}}
                                    <span style="float:right">
                                        {{$application->created_at}}
                                    </span>
                                </div>
                                <div class="panel-body">
                                    {{$application->message}}
                                    @if($application->attached_filename !== 'NULL')
                                    <span style="float: right">
                                        <a href="/download/{{$application->attached_filename}}">Прикрепленный файл</a>
                                    </span>
                                    @endif
                                </div>
                                <div class="panel-footer">
                                    {{----}}
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="panel-footer">

                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="col-sm-offset-2 col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Client's applications
                    </div>
                    <div class="panel-body">
                    @if(isset($applications))
                        @foreach($applications as $application)
                            <div class="panel {{$application->checked_by_manager ? ' panel-success' : ' panel-default'}}">
                                <div class="panel-heading">
                                    <strong>Name: </strong>{{$application->user->name}}<br>
                                    <span style="float: right">{{$application->updated_at}}</span>
                                    <strong>E-mail: </strong>{{$application->user->email}}<br>
                                    <strong>Theme: </strong>{{$application->theme}}
                                </div>
                                <div class="panel-body">
                                    {{$application->message}}
                                </div>
                                <div class="panel-footer">
                                    <form method="get" action="{{url('/changeChecked')}}">
                                        <input type="hidden" value="{{$application->id}}" name="appID">
                                        @if($application->checked_by_manager)
                                            <button type="submit" class="btn btn-danger">Uncheck</button>
                                        @else
                                            <button type="submit" class="btn btn-primary">Check</button>
                                        @endif
                                        @if($application->attached_filename !== 'NULL')
                                        <span style="float: right;">
                                            <a href="/download/{{$application->attached_filename}}">Файл</a>
                                        </span>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    @endif
@endsection
