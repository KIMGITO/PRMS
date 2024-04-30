
@extends('simple-layout')
@section('content')
<main class="row" id="main">
    @include('sections.header')
      <div class="container-fluid d-flex bg-dark justify-content-center alighn-items-center">
        <div class="d-flex justify-content-end align-items-center col-10 col-md-8 col-lg-4" style="min-height: 87vh">
          <form method="POST" class=" p-2 rounded-5 card shandow-lg container-fluid text-primary bg-dark" action="{{ route('send.message') }}">
              <div  class="card-title  p-1 rounded-top text-info">
                  <p class="lead text-center">
                      Send message <span class="small text-danger"> <br> Directed to registry</span>
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
                  <div class="form-group col-lg-10 lead  my-3 offset-1 text-info fw-5">
                    <label for="username">Username or Email:</label>
                    <input type="text" class="form-control text-dark bg-light" name="username" id="username" placeholder="Enter your username" value="{{ old('name')}}">
                    @error('username')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                  <div class="form-group col-lg-10 offset-1  lead text-info fw-5">
                    <div class="form-group">
                      <label for="message">message</label>
                      <textarea class="form-control text-dark bg-light" name="message" id="message" rows="3"></textarea>
                    </div>
                    @error('message')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                

              </div>
              <div class="card-footer  mt-5 py-2 position-relative">
                  <button  type="submit" class="btn btn-outline-light btn-block btn-sm position-absolute bottom-0 end-0"> <i class="fa fa-paper-plane fs-5" aria-hidden="true"></i> </button>
              </div>
          </form>
      </div>
      </div>
      @include('sections.footer')
</main>
@endsection
