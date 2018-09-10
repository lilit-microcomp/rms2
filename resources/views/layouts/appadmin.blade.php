<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @include('includes.head')
</head>
<body>
    <div>

        @include('includes.headeradmin')

        <div class="container">
          @yield('content')

          @yield('comments')
        </div>

        @include('includes.footer')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
