@extends('layouts.base')

@php
use App\Enums\PostScope;
@endphp

@section('title')
{{$user->name}}のページ
@endsection

@section('head')
<style>
.article_title{
    font-size: 2rem;
    display: inline;
}
.article {
    margin-bottom: 25px;
}
#username {
    font-size: 3rem;
    margin-bottom: 5px;
    padding-bottom: 3px;
}
#userid {
    margin-top: 0px;
    margin-bottom: 40px;
    padding-top: 3px;
    color: #757575;
}
</style>
@endsection

@section('main')
<article class="article-list">
    <h1 id="username">{{$user->name}}</h1>
    <p id="userid">{{'@'.$user->user_id}} </p>
        @foreach ($user_all_posts as $user_each_post)
        <article class="article">
            <div>
                <h3 class="article_title">
                    <a href="{{ route('posts.show', ['user'=>$user_each_post->user->user_id, 'post'=>$user_each_post->id]); }}" >
                        {{$user_each_post -> title}}
                    </a>
                </h3>
                    @switch($user_each_post->scope)
                        @case(PostScope::Private)
                            <i class="material-icons">lock</i>
                            @break
                        @case(PostScope::Draft)
                            <i class="material-icons">insert_drive_file</i>
                            @break
                    @endswitch
            </div>
            <time datetime="{{ $user_each_post -> created_at}}">
                {{ $user_each_post -> created_at}}
            </time>
        </article>
        @endforeach
</article>

@endsection
