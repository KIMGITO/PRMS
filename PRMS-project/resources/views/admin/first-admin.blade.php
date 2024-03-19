
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
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
          <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
              <div class="col-md-10 col-lg-6 col-xxl-5">
                <div class="card mb-0">
                  <div class="card-body">
    
                    <p class="text-center fs-5">System Administrator </p>
                    <div class="alert alert-info">
                        <p class="h-2 fw-bolder text-danger">NOTE!! NOTE!! NOTE!!</p>
                        <p>The system has detected that no existing users are present.
                             As a result, this page is being displayed to create an Admin account.
                                <span class="text-danger fw-bold">Please note that this form should 
                                    only be filled out by the intended administrator.
                                </span> 
                                It will only be displayed this one time. 
                                <span class="text-success">
                                    Please fill out the  form below to create the Admin account and proceed 
                                    to PAPER RECORDS MANAGEMENT SYSTEM.    
                                </span>
                            </p>

                    </div>
                    <form method="POST" action="{{ route('store.first.admin')}}">
                      @csrf
                      <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name ="firstName"id="firstName" aria-describedby="textHelp"value="{{ old('firstName') }}">
                            @error('firstName')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="mb-3 col-lg-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name ="lastName"id="lastName" aria-describedby="textHelp"value="{{ old('lastName') }}">
                            @error('lastName')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="nationalId" class="form-label">ID Number</label>
                            <input type="number" class="form-control" name ="nationalId"id="nationalId" aria-describedby="textHelp"value="{{ old('nationalId') }}">
                            @error('nationalId')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="mb-3 col-lg-6">
                            <label for="workId" class="form-label">Job Number</label>
                            <input type="text" class="form-control" name ="workId"id="workId" aria-describedby="textHelp"value="{{ old('workId') }}">
                            @error('workId')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name ="email" id="email" aria-describedby="textHelp"value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="mb-3 col-lg-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="phone" class="form-control" name ="phone" id="phone" aria-describedby="textHelp"value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="row">
                        <div class="mb-3 col-lg-8">
                            <label for="password" class="form-label">Default Password</label>
                            <input type="text" value="12345678" readonly class="form-control" name ="password"id="password" aria-describedby="textHelp">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="mb-3 col-lg-4">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" value="admin" readonly class="form-control" name ="role"id="role" aria-describedby="textHelp">
                            @error('role')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2 "><span>Continue</span></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
          @include('sections.footer')
  </main>

  
   {{-- Javascript inclusion --}}
  
   <script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('vendor/js/sidebarmenu.js') }}"></script>
   <script src="{{ asset('vendor/js/app.min.js') }}"></script>
   <script src="{{ asset('vendor/js/apexcharts.min.js') }}"></script>
   <script src="{{ asset('vendor/js/simplebar.js') }}"></script>
   <script src="{{ asset('vendor/js/dashboard.js') }}"></script>
 </body>
  
</body>

</html>