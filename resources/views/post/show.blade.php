@extends('layouts.base')

@section('title')
{{ $post->title }}
@endsection

@section('main')
<article>
        <h1>{{ $post->title }}</h1>
        <aside>
            <p><i class="small material-icons">person</i> <span>{{ $post->user->name }}</span></p>
            <p><i class="small material-icons">date_range</i> <time>{{ $post->created_at }}</time></p>
            <p><i class="small material-icons">sync</i> <time>{{ $post->updated_at }}</time></p>
        </aside>
        <div>
            {!! $converter->convertToHtml($post->content) !!}
        </div>
        @if($editButtonFlag)
        <div class="row">
        <div class="col">
        <a href="{{route('posts.edit',['post' => $post->id])}}" class="waves-effect waves-light btn">
            <i class="material-icons right">edit</i>
            編集
        </a>
        </div>
        <div class="col">
        <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
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
