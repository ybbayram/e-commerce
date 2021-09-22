<!doctype html>
<html lang="tr">
<head>
   @include('tanitim.layouts.partials.head')
        @yield('css')

</head>
<body class="theme-color-27">
        @include('tanitim.layouts.partials.navbar')
        @yield('content')

        @include('tanitim.layouts.partials.footer')
        @yield('js')

</body>
</html>
