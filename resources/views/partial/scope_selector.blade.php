@php
    use App\Enums\PostScope;
@endphp

@section('head')
    <script>
        function switchDisplayPassPhrase(){
            let private_btn = document.getElementById("scope_private");
            let pass_phrase = document.getElementById("pass_phrase");
            let pass_phrase_label = document.getElementById("pass_phrase_label");
            if(private_btn.checked){
                pass_phrase.setAttribute("type", "text");
                pass_phrase_label.setAttribute("style", "display:block;");
                pass_phrase.setAttribute("required", "");
            } else{
                pass_phrase.setAttribute("type", "hidden");
                pass_phrase_label.setAttribute("style", "display:none;");
                pass_phrase.removeAttribute("required");
            }
        };
        window.onload = switchDisplayPassPhrase;
    </script>
@endsection

<div>
    <label for="scope_public">
        <input type="radio" name="scope" value="{{ PostScope::Public->value }}" id="scope_public" onclick="switchDisplayPassPhrase();" checked>
        <span>公開する</span>
    </label>
</div>
<div>
    <label for="scope_private">
        <input type="radio" name="scope" value="{{ PostScope::Private->value }}" id="scope_private" onclick="switchDisplayPassPhrase();"  {{ old("scope") === PostScope::Private ? "checked" : "" }} >
        <span>パスワード付きで公開する</span>
    </label>
</div>
<div>
    <label for="scope_draft">
        <input type="radio" name="scope" value="{{ PostScope::Draft->value }}" id="scope_draft" onclick="switchDisplayPassPhrase();" {{ old("scope") === PostScope::Draft ? "checked" : "" }} >
        <span>下書きとして保存する</span>
    </label>
</div>
<div class="input-field">
    <label for="pass_phrase" id="pass_phrase_label">パスワードを入力</label>
    <input type="hidden" name="pass_phrase" id="pass_phrase" >
</div>