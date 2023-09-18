@section('head')
<style>

</style>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - nikkiame</title>
    @yield('head')
    <style>
        footer{
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems, {});
        });
    </script>
</head>
<body>
    <header>@include('partial.header')</header>
    <main class="container">
        @yield('main')
    </main>
    <footer class="page-footer">
        <div class="container">
            <a class="grey-text text-lighten-3" href="https://github.com/eniehack/nikkiame-next">
                <img src="{{ asset('/assets/image/github-mark-white.png') }}" alt="GitHub" height="24" width="24">
            </a>
            <p>
                &copy;2023 Nikkiame Developers
            </p>
        </div>
        </footer>

</body>
</html>
