
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','PRMS')</title>
  <link rel="stylesheet" href="{{ asset('vendor/css/styles.min.css') }}" />
<style>
 
</style>
</head>
@section('display-btn')
            d-none
@endsection

<body id="body" class="container-fluid">
    @yield('content')
</body>
</html>