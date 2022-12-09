@extends('layouts.base')

@section('title')
Sign in
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
    <form action="/signin" method="post" class="row">
        @csrf
        <div class="col s12">
            <div class="input-field">
                <label for="uid">ユーザID</label>
                <input type="text" name="uid" required>
            </div>
        </div>
        <div class="col s12">
            <div class="input-field">
                <label for="pass">パスワード</label>
                <input type="password" name="pass" required>
            </div>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">
            ログイン
            <i class="material-icons right">send</i>
        </button>
    </form>
@endsection
