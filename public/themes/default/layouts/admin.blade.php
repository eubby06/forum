<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{ Provider::getSettings()->find(1)->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ theme_asset('css/frontend.css') }}" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
  </head>

  <body>

      @include('theme::'.Provider::getSettings()->getTheme().'.__partials.top_navigation')

    <div class="container-fluid">
      @include('theme::'.Provider::getSettings()->getTheme().'.__partials.errors')
      @yield('content')
      <hr />
      @yield('statistics')
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ theme_asset('vendor/js/jquery.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/js/bootstrap.min.js') }}"></script>

  </body>
</html>
