
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
            <div class="d-flex justify-content-end align-items-center col-10 col-md-8 col-lg-4" style="min-height: 87vh">
                  <form method="POST" class=" p-5 bg-dark rounded container-fluid text-white" action="{{ route('forgot') }}">
                        <div class="">
                            @if (session('error'))
                              <div class=" card-body border-0 lead text-danger justify-content-center py-2 px-3 fw-sm">
                                  {{ session('error') }}
                              </div>
                            @endif
                            @if (session('success'))
                              <div class=" card-body border-0 leadtext-success justify-content-center py-2 px-3 fw-sm">
                                  {{ session('success') }}
                              </div>
                            @endif

                            @if (!session('error'))
                            <div class="container-fluid py-2">
                              Enter your email here to get password reset link.
                            </div>
                            @endif
                            <div class="form-group text-end text-white fw-5">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control text-light-danger" name="email" id="email" placeholder="Enter your email" value="{{ old('email') }}" >
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer py-2 pt-5 position-relative">
                            <button  type="submit" class="btn btn-secondary btn-block btn-sm position-absolute bottom-0 end-0">Send</button>
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