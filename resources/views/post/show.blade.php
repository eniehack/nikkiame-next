@extends('layouts.base')

@php
use App\Enums\PostScope;
@endphp

@section('title')
{{ $post->title }}
@endsection

@section('head')
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name="description" content="{{ mb_substr($post->content, 0, 100) }}">
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ mb_substr($post->content, 0, 100) }}" />
    <meta property="og:site_name" content="Nikkiame" />
    <meta property="og:image" content="{{ asset('/assets/image/sweets_cinnamon_stick.png') }}" />

<style>
    #title {
        margin-top: 50px;
    }
    #title h1 {
        display: inline;
    }
</style>
@endsection

@section('main')
<article>
    <div id="title">
        <h1>{{ $post->title }}</h1>
        @if ($post->scope === PostScope::Private->value)
            <i class="material-icons">lock</i>
        @endif
    </div>
        
        <aside>
            <p><i class="small material-icons">person</i> <a href="{{ route('user.profile', ['user' => $post->user->user_id ]) }}">{{ $post->user->name }}</a></p>
            <p><i class="small material-icons">date_range</i> <time>{{ $post->created_at }}</time></p>
            <p><i class="small material-icons">sync</i> <time>{{ $post->updated_at }}</time></p>
        </aside>
        <div>
            {!! $converter->convertToHtml($post->content) !!}
        </div>
        @if($editButtonFlag)
        <div class="row">
        <div class="col">
        <a href="{{route('posts.edit',['user' => $post->user->user_id, 'post' => $post->id])}}" class="waves-effect waves-light btn">
            <i class="material-icons right">edit</i>
            編集
        </a>
        </div>
        <div class="col">
        <form action="{{ route('posts.destroy', ['user' => $post->user->user_id, 'post' => $post->id]) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="waves-effect waves-light btn red" onclick='return window.confirm("削除しますか？");'>
            <i class="material-icons right">delete</i>
            削除
        </button>
        </form>
        </div>
        </div>

        @endif
    </article>
@endsection
