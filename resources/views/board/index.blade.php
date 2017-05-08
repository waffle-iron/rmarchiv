@extends('layouts.app')
@section('pagetitle', 'forum übersicht')
@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1>{{ trans('board.index.title') }}</h1>
                {!! Breadcrumbs::render('forums') !!}
            </div>
        </div>
        @foreach($cats as $cat)
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><a href="{{ url('board/cat', $cat->id) }}">{{ $cat->title }}</a></h4>
                </div>
                <ul class="list-group">
                    @foreach($cat->threads->sortByDesc('last_created_at')->take(15) as $thread)
                        <li class="list-group-item media" style="margin-top: 0px;">
                            <a class="pull-right" href="{{ route('board.thread.show', $thread->id) }}"><span class="badge">{{ $thread->posts->count() }}</span></a>
                            <a class="pull-left" href="{{ url('users', $thread->user->id) }}"><img class="media-object img-rounded" width="42px" src="http://ava.rmarchiv.de/?size=42&gender=male&id={{ $thread->user->id }}" alt="{{ $thread->user->name }}"></a>
                            <div class="thread-info">
                                <div class="media-heading">
                                    @if($thread->closed == 1)
                                        <i class="fa fa-lock text-danger"></i>
                                    @endif
                                    @if(\App\Models\BoardPoll::whereThreadId($thread->id)->count() != 0)
                                            <i class="fa fa-signal fa-rotate-270"></i>
                                    @endif
                                    <a href="{{ route('board.thread.show', $thread->id) }}">{{ $thread->title }}</a>
                                </div>
                                <div class="media-body" style="font-size: 12px;">
                                    <a href="{{ route('board.cat.show', $cat->id) }}"><span @if(\App\Helpers\DatabaseHelper::isThreadUnread($thread->id) === true) style="font-weight: bold;" @endif>{{ $cat->title }}</span></a>
                                    <span> • </span>
                                    erstellt <time datetime='{{ $thread->created_at }}' title='{{ $thread->created_at }}'>{{ \Carbon\Carbon::parse($thread->created_at)->diffForHumans() }}</time>
                                    <span> • </span>
                                    letzte antwort <time datetime='{{ $thread->last_created_at }}' title='{{ $thread->last_created_at }}'>{{ \Carbon\Carbon::parse($thread->last_created_at)->diffForHumans() }}</time> von <a href='{{ url('users', $thread->last_user->id) }}' class='usera' title="{{ $thread->last_user->name }}">
                                        <img width="16px" class="img-rounded" src='http://ava.rmarchiv.de/?size=16&gender=male&id={{ $thread->last_user->id }}' alt="{{ $thread->last_user->name }}"/>
                                    </a> <a href='{{ url('users', $thread->last_user->id) }}' class='user'>{{ $thread->last_user->name }}</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
        <div class="row">
            @if(Auth::check())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('board.index.create_thread') }}
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['route' => ['board.thread.store'], 'id' => 'frmBBSPost']) !!}
                        <div class='content'>
                            <label for='topic'>{{ trans('board.index.topic_title') }}</label>
                            <input name='topic' id='topic'/>
                            <label for='category'>{{ trans('board.index.category') }}</label>
                            <select name='category' id='category'>
                                @foreach($cats as $cat)
                                    <option value='{{ $cat->id }}'>{{ $cat->title }}</option>
                                @endforeach
                            </select>
                            <label for='message'>{{ trans('board.index.message') }}</label>
                            @include('_partials.markdown_editor')
                            <div>{!! trans('board.index.markdown') !!}</div>
                        </div>
                        <div class='foot'>
                            <input type='submit' value='{{ trans('board.index.send') }}' id='submit'></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('board.index.show.no_login_title') }}
                    </div>
                    <div class="panel-body">
                        {{ trans('board.index.show.no_login_title') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection