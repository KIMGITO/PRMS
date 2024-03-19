
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
        {{-- {{View::make('sections/header')}}
        @yield('content')
        {{View::make('sections/footer')}}
        {{View::make('sections/clounds-background')}} --}}
   
  {{-- main body --}}
  <main class="row" id="main">
        @include('sections.header')
          <div class="container-fluid d-flex justify-content-center alighn-items-center">
            <div class="d-flex justify-content-end align-items-center col-10 col-md-8 col-lg-4" style="min-height: 87vh">
              <form method="POST" class=" p-2 rounded container-fluid text-primary" action="{{ route('index.auth') }}">
                  <div  class="card-title bg-secondary p-1 rounded-top text-dark">
                      <p class="fs-3 fw-bolder ">
                          Log in
                      </p>
                  </div>
                  <div class="card-body ">
                   
                      @if (session('error'))
                        <div class=" card-body border-0 bg-light-danger text-danger justify-content-center py-2 px-3 fw-sm">
                            {{ session('error') }}
                        </div>
                      @endif
                      @if (session('success'))
                        <div class=" card-body border-0 bg-light-success text-success justify-content-center py-2 px-3 fw-sm">
                            {{ session('success') }}
                        </div>
                      @endif
                      <div class="form-group text-end text-dark fw-5">
                          <label for="email">Email:</label>
                          <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email" value="{{ old('email')}}">
                          @error('email')
                              <div class="text-danger small">{{ $message }}</div>
                          @enderror
                      </div>
                      <div class="form-group text-end text-dark fw-5">
                          <label for="password">Password:</label>
                          <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Enter your password" >
                          @error('password')
                              <div class="text-danger small">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <div class="card-footer bg-secondary  mt-4 py-2 position-relative">
                      <button  type="submit" class="btn btn-secondary btn-block btn-sm position-absolute bottom-0 end-0">Login</button>
                  </div>
              </form>
          </div>
          </div>
          @include('sections.footer')
  </main>
 </body>
  
</body>

</html>