<!doctype html>
<html lang="tr">
  <head>
      @include('admin.layouts.partials.head')
      @yield('css')
  </head>
  <body data-topbar="dark">
 <div id="layout-wrapper">
 	@include('admin.layouts.partials.header')
      @yield('content')

      @include('admin.layouts.partials.footer')
      @yield('js')
  </body>
</html>
