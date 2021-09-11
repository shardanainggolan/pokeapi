<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('layouts.header')

    <body class="py-5">
        
        @yield('content')

    </body>

    @include('layouts.footer')
</html>
