
@extends('simple-layout')
@section('content')
<main class="row" id="main">
    @include('sections.header')
      <div class="container-fluid d-flex justify-content-center alighn-items-center">
        <div class="d-flex justify-content-end align-items-center col-10 col-md-8 col-lg-4" style="min-height: 87vh">
          <form method="POST" class=" p-2 rounded container-fluid text-primary bg-dark" action="{{ route('index.auth') }}">
              <div  class="card-title  p-1 rounded-top text-success">
                  <p class="lead ">
                      Log in
                  </p>
              </div>
              <div class="card-body ">
               
                  @if (session('error'))
                    <div class=" card-body border-0 lead text-danger justify-content-center py-2 px-3 fw-sm">
                        {{ session('error') }}
                    </div>
                  @endif
                  @if (session('success'))
                    <div class=" card-body border-0 lead  text-success justify-content-center py-2 px-3 fw-sm">
                        {{ session('success') }}
                    </div>
                  @endif
                  <div class="form-group col-lg-10 offset-1 text-end lead text-success fw-5">
                      <label for="email">Email:</label>
                      <input type="text" class="form-control " name="email" id="email" placeholder="Enter your email" value="{{ old('email')}}">
                      @error('email')
                          <div class="text-danger small">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="form-group col-lg-10 offset-1 text-end lead text-success fw-5">
                      <label for="password">Password:</label>
                      <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Enter your password" >
                      @error('password')
                          <div class="text-danger small">{{ $message }}</div>
                      @enderror
                  </div>
                  <p class="my-2 text-white laed fs-3"> Forgot password <a href=" {{ route('forgot.password.form') }}" class="link-danger fw-bolder"> Click Here</a></p>
              </div>
              <div class="card-footer  py-2 position-relative">
                  <button  type="submit" class="btn btn-secondary btn-block btn-sm position-absolute bottom-0 end-0">Login</button>
              </div>
          </form>
      </div>
      </div>
      @include('sections.footer')
</main>
@endsection
