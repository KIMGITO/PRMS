
@extends('sections.layout')
@section('display-logo')
    d-block d-lg-none
@endsection
@section('content')
<div class="body-wrapper" style="min-height: 93vh">
    <!--  Header Start -->
    @include('sections.header')
    <!--  Header End -->
    
    {{-- Body --}}

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="">
    
    <div
      class="position-relative overflow-hiddenradial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-10 col-lg-7 col-xxl-5">
            <div class="card mb-0">
              <div class="card-body mt-5">

                <p class="text-center fs-5">Edit User</p>
                <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block pb-4 w-100">
                  <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="100" alt="">
                </a>
                @php
                    $id = Crypt::encrypt($user['id']);
                @endphp
                <form method="POST" action="{{ route('edit.user',['id'=>$id])}}">
                    @csrf
                    @method('PUT')
                  <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" name ="firstName"id="firstName" aria-describedby="textHelp"value="{{ old('firstName',$user['first_name']) }}">
                        @error('firstName')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3 col-lg-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name ="lastName"id="lastName" aria-describedby="textHelp"value="{{ old('lastName',$user['last_name']) }}">
                        @error('lastName')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="nationalId" class="form-label">ID Number</label>
                        <input type="number" class="form-control" name ="nationalId"id="nationalId" aria-describedby="textHelp"value="{{ old('nationalId',$user['national_id']) }}">
                        @error('nationalId')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3 col-lg-6">
                        <label for="workId" class="form-label">Job Number</label>
                        <input type="text" class="form-control" name ="workId"id="workId" aria-describedby="textHelp"value="{{ old('workId',$user['work_id']) }}">
                        @error('workId')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input class="form-control" name ="email" id="email" aria-describedby="textHelp"value="{{ old('email',$user['email']) }}">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3 col-lg-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="phone" class="form-control" name ="phone" id="phone" aria-describedby="textHelp"value="{{ old('phone',$user['phone']) }}">
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="row">
                    {{-- <div class="mb-3 col-lg-8">
                        <label for="password" class="form-label"> Password</label>
                        <input type="text" readonly class="form-control" name ="password"id="password" aria-describedby="textHelp">
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div> --}}
                      <div class="mb-3 col-lg-6">
                        <label for="role" class="form-label">Role</label>
                        <input value="{{ old('role',$user['role']) }}" type="text" class="form-control text-uppercase" name ="role"id="role" aria-describedby="textHelp">
                        @error('role')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="d-none">
                        <input type="text" name="id" value="{{ $user['id'] }}">
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

  </div>
{{-- Footer Start --}}
@include('sections.footer')

@endsection