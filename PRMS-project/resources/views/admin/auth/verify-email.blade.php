
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
              <form method="POST" class=" p-2 rounded container-fluid text-primary" action="{{ route('verify.otp',['id'=>'id']) }}">
                  <div  class="card-title bg-success p-1 rounded-top text-dark">
                      <p class="fs-3 fw-bolder ">
                          Verify Email
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
                      <div class="row">
                        <card class="title sm-lg-0">
                        <i class="fas fa-envelope-circle-check fa-7x float-md-start pb-3 pb-lg-2 pe-md-1 pe-lg-3 text-success"></i>
                        <p class="pt-2">Hello <span class="text-capitalize">{{$userName}}</span>, An email with 6 digts OTP was sent to <span class="text-success">{{$email}}</span>. 
                        Type the code here to verify the email.</p>
                        
                      </card>
                      
                      </div>
                      
                        <div class="digit-container">
                          <input type="text" class="digit-input fa-jump " maxlength="1">
                          <input type="text" class="digit-input" maxlength="1">
                          <input type="text" class="digit-input" maxlength="1">
                          <input type="text" class="digit-input" maxlength="1">
                          <input type="text" class="digit-input" maxlength="1">
                          <input type="text" class="digit-input" maxlength="1">
                          <input type="text" name="otp"  class="d-none" id="collectedInputs">
                        </div>
                  </div>
                  <div class="mt-1" >
                    @if (session('resend'))
                      <a href="{{ route('resend.otp')}}" class=" btn btn-outline-primary py-0 fw-bold hter fs-3 text-end offset-6">Click Here to resnd OTP</a>
                    @endif
                  </div>
                  <div class="card-footer bg-success  mt-5 mt-lg-1 py-2 position-relative">
                  </div>
              </form>
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