@extends('layouts.base')

@section('title')
新規投稿
@endsection

@section('head_js')
<script>
    function switchDisplayPassPhrase(){
        let private_btn = document.getElementById("scope_private");
        let pass_phrase = document.getElementById("pass_phrase");
        if(private_btn.checked){
            pass_phrase.setAttribute("type", "text");
            pass_phrase.setAttribute("required", "");
        } else{
            pass_phrase.setAttribute("type", "hidden");
            pass_phrase.removeAttribute("required");
        }
    };
</script>
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



<form action="{{route('posts.store')}}" method="post" class="row">
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
            <div>
                <label for="scope_public">
                    <input type="radio" name="scope" value="0" id="scope_public" onclick="switchDisplayPassPhrase();" checked>
                    <span>公開する</span>
                </label>
            </div>
            <div>
                <label for="scope_private">
                    <input type="radio" name="scope" value="1" id="scope_private" onclick="switchDisplayPassPhrase();" >
                    <span>パスワードを付ける</span>
                </label>
            </div>
            <div class="input-field">
                <label for="pass_phrase" >パスワードを入力</label>
                <input type="hidden" name="pass_phrase" id="pass_phrase" >
            </div>
        <button type="submit" class="waves-effect waves-light btn-large">
            <i class="material-icons right">send</i>
            投稿
        </button>
</form>
@endsection
