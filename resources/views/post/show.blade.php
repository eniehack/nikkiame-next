@extends('layouts.base')

@section('title')
{{ $title }}
@endsection

@section('main')
<article>
        <h1>{{ $title }}</h1>
        <aside>
            <p><i class="small material-icons">person</i> <span>{{ $author->name }}</span></p>
            <p><i class="small material-icons">date_range</i> <time>{{ $created_at }}</time></p>
            <p><i class="small material-icons">sync</i> <time>{{ $updated_at }}</time></p>
        </aside>
        <div>
            {!! $converter->convertToHtml($content) !!}
        </div>
    </article>
@endsection
