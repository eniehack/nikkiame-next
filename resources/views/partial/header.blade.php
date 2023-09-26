<nav>
    <div class="nav-wrapper">
        <div style="margin-left: 20px;">
            <a href="/" class="brand-logo">Nikkiame</a>
        </div>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            @if ( session()->has('name') )
                <li><a href="{{ route('user.profile', ['user' => session('uid')]) }}">my page</a></li>
                <li><a href="{{ route('posts.create') }}">新規投稿</a></li>
            @else
                <li><a href="{{ route('signin.get') }}">Signin</a></li>
            @endif
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    @if ( session()->has('name') )
        <li><a href="{{ route('user.profile', ['user' => session('uid')]) }}">my page</a></li>
        <li><a href="{{ route('posts.create') }}">新規投稿</a></li>
    @else
        <li><a href="{{ route('signin.get') }}">Signin</a></li>
    @endif
</ul>