<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @include('includes.head')
</head>
<body>
    <div>

        @include('includes.header')

        <div class="container">
          @yield('content')
        </div>

        @include('includes.footer')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
