@extends('layouts.app')
@section('pagetitle', trans('app.edit_post'))
@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1>{{ trans('app.edit_post') }}</h1>
                {!! Breadcrumbs::render('post.edit', \App\Models\BoardCat::whereId($post->cat_id)->first(), $post) !!}
            </div>
        </div>
        @if(Auth::check())
            @if(Auth::user()->id == $post->user_id or Auth::user()->can('mod-threads'))
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('board.post.update', [$post->thread_id, $post->id]) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                    @if (count($errors) > 0))
                                    <div class="rmarchivtbl errorbox">
                                        <h2>{{ trans('app.edit_post_failed') }}</h2>
                                        <div class="content">
                                            @foreach ($errors->all() as $error)
                                                <strong>{{ $error }}</strong>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                        <input type="hidden" name="thread_id" id="thread_id" value="{{ $post->thread_id }}">
                                        <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}">

                                        @include('_partials.markdown_editor', ['edit_text' => $post->content_md])
                                    <div class="foot">
                                        <input type="submit" value="{{ trans('app.submit') }}">
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ trans('app.your_permissions_are_to_low') }}
                        </div>
                        <div class="panel-body">
                            {{ trans('app.your_permissions_are_to_low_to_post') }}
                        </div>
                    </div>
                </div>
            @endif

        @else
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('app.your_permissions_are_to_low') }}
                    </div>
                    <div class="panel-body">
                        {{ trans('app.your_permissions_are_to_low_to_post') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection