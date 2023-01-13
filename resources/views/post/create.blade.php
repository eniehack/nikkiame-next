@extends('layouts.base')

@section('title')
新規投稿
@endsection

@section('main')
<h1>New Post</h1>
    @if ($errors->any())
        <div class="row">
            <div class="card-panel  red lighten-1 m5">
                <div class="card-content white-text">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif



<form action="/posts" method="post" class="row">
        @csrf
        <div class="col s12">
            <div class="input-field">
                <label for="title">タイトル</label>
                <input type="text" name="title">
                <span class="helper-text" data-error="wrong" data-success="right">空白で投稿すると「2022-11-09」のようなタイトルになります。</span>
            </div>
        </div>
        <div class="col s12">
            <div class="input-field">
                <label for="content">本文</label>
                <textarea name="content" class="materialize-textarea" cols="30" rows="10" required></textarea>
                <span class="helper-text" data-error="wrong" data-success="right">
                    <a href="https://commonmark.org/help/">
                        Markdown記法
                    </a>
                    が使えます。
                </span>
            </div>
        </div>
        <button type="submit" class="waves-effect waves-light btn-large">
            <i class="material-icons right">send</i>
            投稿
        </button>
</form>
@endsection