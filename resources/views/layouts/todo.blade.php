<html>
    <head>
        <title>TEST</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
        <link rel="stylesheet" href=@yield('css')>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    </head>
    <body>
        <x-header></x-header>
        <div class="session-loginMessage">{{ session('loginMessage') }}</div>
        <main>
            @yield('content')
        </main>
        <footer></footer>
    </body>
    @yield('script')
</html>