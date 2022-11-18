@extends('layouts.base')

@section('title')
Sign up
@endsection

@section('main')
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

    <form action="/signup" method="post" class="row">
        @csrf
        <div class="col s12">
            <div class="input-field">
                <label for="name">名前</label>
                <input type="text" name="name" data-length="20" required>
                <span class="helper-text" data-error="wrong" data-success="right">
                    本名である必要はありません。
                    20文字以下である必要があります。
                </span>
            </div>
        </div>
        <div class="col s12">
            <div class="input-field">
                <label for="uid">ユーザID</label>
                <input type="text" name="uid" data-length="15" required>
                <span class="helper-text" data-error="wrong" data-success="right">
                    アルファベット小文字、数字、ドット(.)、アンダーバー（_）で構成され、
                    15文字以内である必要があります。
                </span>
            </div>
        </div>
        <div class="col s12">
            <div class="input-field">
                <label for="pass">パスワード</label>
                <input type="password" name="pass" required>
                <span class="helper-text" data-error="wrong" data-success="right">
                    8文字以上である必要があります。
                </span>
            </div>
        </div>

        <button class="btn waves-effect waves-light" type="submit" name="action">
            登録
            <i class="material-icons right">send</i>
        </button>
    </form>
@endsection
