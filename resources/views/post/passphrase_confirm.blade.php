@extends('layouts.base')

@section('head')
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name="description" content="この投稿は、パスワードを入力しなければなりません。">
    <meta property="og:type" content="article" />
    <meta property="og:title" content="パスワード付き投稿" />
    <meta property="og:description" content="この投稿は、パスワードを入力しなければなりません。" />
    <meta property="og:site_name" content="Nikkiame" />
    <meta property="og:image" content="{{ asset('/assets/image/sweets_cinnamon_stick.png') }}" />
@endsection

@section('title')
パスワードを入力してください
@endsection

@section('main')
<p>
この投稿は、パスワードを入力しなければなりません。
</p>
<form action="{{ route('post.passphrase.post', ['user' => $user_id, 'post' => $post_id]) }}" method="post" class="row">
        @csrf
        <input type="hidden" name="post_id" value="{{$post_id}}">
        <div class="col s12">
            <div class="input-field">
                <label for="pass">パスワード</label>
                <input type="password" name="passphrase" required>
            </div>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">
            挑戦
            <i class="material-icons right">send</i>
        </button>
    </form>
@endsection
