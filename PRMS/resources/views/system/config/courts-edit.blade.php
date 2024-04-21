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
                                    $id = Crypt::encrypt($data['id']);
                                @endphp

                                <form method="POST" action="{{ route('destroy.court',['id'=> $id]) }}" id="form-delete-court">
                                    @csrf
                                    @method('DELETE')
                                </form>
                

                                <form method="POST" action="{{ route('update.court', ['id' => $id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="card-title text-secondary">
                                            Edit Court:
                                        </div>
                                    </div>

                                    <div class="card p-2 shandow-lg bg-light">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9 mb-3">
                                                <label for="name" class="form-label">Edit Court Name:</label>
                                                <input type="text" class="form-control bg-white" name="name" id="name"
                                                    value="{{ $data['name'] }}">
                                                @error('name')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-md-3 col-lg-2">
                                                    <a id="deleteButton" title="Delete"
                                                        onclick="confirmDelete('delete-court','court')"
                                                        class="btn btn-danger btn-sm col-12 py-1">
                                                        <span>Delete <i class="fa fa-trash"></i> </span>
                                                    </a>
                                                </div>
                                                <div class="col-md-3 col-lg-2">
                                                    <button type="submit" title="Update" class="btn btn-primary btn-sm col-12 py-1"><span>Update</span></button>
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