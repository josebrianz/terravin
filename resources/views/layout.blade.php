<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
