
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','PRMS')</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="{{ asset('vendor/css/styles.min.css') }}" />
<style>
</style>
</head>
@section('display-btn')
            d-none
        @endsection
    
    <body id="body" class="container-fluid">
   
  {{-- main body --}}
  <main class="row" id="main">
        @include('sections.header')
          <div class="container-fluid d-flex justify-content-center alighn-items-center">
            <div class="d-flex justify-content-end align-items-center col-10 col-md-8 col-lg-6" style="min-height: 87vh">
                  <div class="p-5 bg-dark rounded container-fluid ">
                        <div class="card-body">
                            <div class=" py-2 text-success lead h-5">
                              A link to reset your password was sent to your email account. Check to reset your password
                              
                            </div>
                            <a class="card-link text-end text-white h4 lead-2 btn offset-10" href="{{ route('index') }}"> Log In</a>
                        </div>
                      
                  </div>
          </div>
          </div>
          @include('sections.footer')
  </main>
 </body>
 <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
 <script src="{{ asset('vendor/css/icons/fontawsome/js/all.min.js') }}"></script>
  <script src="{{ asset('app.js')}}"></script>
</body>

</html>