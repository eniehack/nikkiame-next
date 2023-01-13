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
        <a href="./{{$post->id}}/edit" class="waves-effect waves-light btn-large">
            <i class="material-icons right">edit</i>
            編集
        </a>
        @endif
    </article>
@endsection
