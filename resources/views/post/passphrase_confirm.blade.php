@extends('layouts.base')

@section('title')
パスワードを入力してください
@endsection

@section('main')
<p>
この投稿は、パスワードを入力しなければなりません。
</p>
<form action="{{ route('post.passphrase.post', ['post' => $post_id]) }}" method="post" class="row">
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
