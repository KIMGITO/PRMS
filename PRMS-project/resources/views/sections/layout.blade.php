<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','PRMS')</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="{{ asset('vendor/css/styles.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/css/app.css') }}" />
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">




</head>

<body class="">
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
        {{ view('sections.side-bar') }}
    <!--  Sidebar End -->
    <!--  Main wrapper -->
        @yield('content')
  </div>
  {{-- Javascript inclusion --}}

  <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('vendor/js/apexcharts.min.js') }}"></script>
  <script src="{{ asset('vendor/js/simplebar.js') }}"></script>
  <script src="{{ asset('vendor/js/dashboard.js') }}"></script>
  <script src="{{ asset('vendor/js/app.min.js') }}"></script>
  <script src="{{ asset('app.js') }}"></script>

</body>
{{-- Clound Js --}}
{{ view('sections.clounds-background') }}

</html>