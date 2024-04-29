
@extends('simple-layout')
@section('content')
<main class="row" id="main">
    @include('sections.header')
      <div class="container-fluid d-flex justify-content-center alighn-items-center">
        <div class="d-flex justify-content-end align-items-center col-10 col-md-8 col-lg-4" style="min-height: 87vh">
          <form method="POST" class=" p-2 rounded container-fluid text-primary bg-dark" action="{{ route('store.new.client') }}">
              <div  class="card-title  p-1 rounded-top text-info">
                  <p class="lead ">
                      Register Client
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
                    <div class="form-group col-lg-10 offset-1  lead text-info fw-5">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control " name="name" id="name" placeholder="Enter your name" value="{{ old('name')}}">
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                  <div class="form-group col-lg-10 offset-1  lead text-info fw-5">
                      <label for="email">Email:</label>
                      <input type="text" class="form-control " name="email" id="email" placeholder="Enter your email" value="{{ old('email')}}">
                      @error('email')
                          <div class="text-danger small">{{ $message }}</div>
                      @enderror
                  </div>

              </div>
              <div class="card-footer  mt-5 py-2 position-relative">
                  <button  type="submit" class="btn btn-secondary btn-block btn-sm position-absolute bottom-0 end-0">Register</button>
              </div>
          </form>
      </div>
      </div>
      @include('sections.footer')
</main>
@endsection
