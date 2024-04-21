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
                                @php
                                    $id = Crypt::encrypt($data['id']);
                                @endphp

                                <p class="text-center fs-5">Configurations <i class="fa fa-cogs" aria-hidden="true"></i></p>
                                @include('system.config.config-header')

                                <form class="d-none" id="form-delete-purpose" method="POST" action="{{ route('destroy.purpose',['id'=>$id]) }}">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <form method="POST" action="{{ route('update.purpose', ['id' => $id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="card-title text-secondary">
                                            Edit File Request Purpose:
                                        </div>
                                    </div>

                                    <div class="card p-2 shandow-lg bg-light">
                                        <div class="container-fluid">
                                            <div class="row align-items-center">
                                                <div class="col-md-6 col-lg-8">
                                                    <label for="purpose" class="form-label">Edit Request Purpose:</label>
                                                    <input type="text" class="form-control bg-white text-capitalize" name="purpose"
                                                        id="purpose" value="{{ $data['purpose'] }}">
                                                    @error('purpose')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label">Under Supervision?:</label>
                                                    <div class="bg-white rounded-2 px-1 row p-2">
                                                        <div class="form-check col-6">
                                                            <input class="form-check-input bg-danger" value="1" type="radio"
                                                                name="supervision" id="yes" {{ $data['supervised'] == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="yes"> Yes </label>
                                                        </div>
                                                        <div class="form-check col-6">
                                                            <input class="form-check-input bg-danger" value="0" type="radio"
                                                                name="supervision" id="no" {{ $data['supervised'] == '0' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="no"> No </label>
                                                        </div>
                                                    </div>
                                                    @error('supervision')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Purpose Description:</label>
                                                    <textarea class="form-control" name="description" id="description"
                                                        rows="2">{{ $data['description'] }}</textarea>
                                                    @error('description')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row justify-content-between mt-2">
                                                <div class="col-md-6 col-lg-4">
                                                    <div id="deleteButton" title="Delete" onclick="confirmDelete('delete-purpose','purpose')" 
                                                    class="btn btn-danger btn-sm py-1 px-2"><span> Delete <i class="fa fa-trash" aria-hidden="true"></i></span></div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <button type="submit" class="btn btn-success btn-sm col-12 py-1"><span>Update</span>
                                                    </button>
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