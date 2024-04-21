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
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-10 col-lg-8 col-xxl-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <p class="text-center fs-5">Configurations <i class="fa fa-cogs" aria-hidden="true"></i></p>
                                @include('system.config.config-header')
                                @php
                                    $id = Crypt::encrypt($judge['id']);
                                @endphp
                                <form method="POST" action="{{ route('update.judge', ['id' => $id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="card-title text-secondary">
                                            Edit Judge:
                                        </div>
                                    </div>

                                    <div class="card p-2 shandow-lg bg-light">
                                        <div class="container-fluid">
                                            <div class="row align-items-center">
                                                <div class="col-lg-9">
                                                    <label for="name" class="form-label">Edit Judge Name:</label>
                                                    <input type="text" class="form-control bg-white" name="name" id="name"
                                                        value="{{ $judge['name'] }}">
                                                    @error('name')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label">Gender:</label>
                                                    <div class="bg-white rounded-2 px-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="male" type="radio" name="gender"
                                                                id="male" {{ $judge['gender'] == 'male' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="male"> Male </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="female" type="radio" name="gender"
                                                                id="female" {{ $judge['gender'] == 'female' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="female"> Female </label>
                                                        </div>
                                                    </div>
                                                    @error('gender')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row justify-content-end mt-2">
                                                <div class="d-flex align-items-center col-md-3 col-lg-2">
                                                    <button type="submit" class="btn btn-primary btn-sm"><span>Update</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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