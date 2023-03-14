@extends('layouts.base')

@section('title')
{{$user->name}}のページ
@endsection

@section('head')
<style>
.username{
    font-size: 3rem
}
.article_title{
    font-size: 2rem;
}
</style>
@endsection

@section('main')
<article >
    <h1 class="username">{{$user->name}}</h1>
    <p>{{'@'.$user->user_id}} </p>
        @foreach ($user_all_posts as $user_each_post)
        <article >
            <h3 class="article_title"><a href="{{ route('posts.show', ['user'=>$user_each_post->user->user_id, 'post'=>$user_each_post->id]); }}" >{{$user_each_post -> title}}</a></h3>
            <time datetime="{{ $user_each_post -> created_at}}">{{ $user_each_post -> created_at}}</time>
        </article>
        @endforeach
</article>

@endsection
