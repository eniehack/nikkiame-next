<nav>
    <div class="nav-wrapper">
        <div style="margin-left: 20px;">
            <a href="/" class="brand-logo">Nikkiame</a>
        </div>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="/signin">Signin</a></li>
            <li><a href="/signup">Signup</a></li>
            <li><a href="{{route('posts.create')}}">新規投稿</a></li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
  <li><a href="/signin">Signin</a></li>
  <li><a href="/signup">Signup</a></li>
  <li><a href="{{route('posts.create')}}">新規投稿</a></li>
</ul>