
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
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-10 col-lg-8 col-xxl-6">
            <div class="card mb-0">
              <div class="card-body">
                  @php
                        $id = Crypt::encrypt($data['id']);
                  @endphp
                <p class="text-center fs-5">Departments: <i class="fa fa-cogs" aria-hidden="true"></i></p>
                @if (session('success'))
                  <div class="text-success bg-light-success mt-1 py-1 rounded-2 text-center">
                    {{session('success')}}
                  </div>
                @endif
                @if (session('error'))
                  <div class="text-danger bg-light-danger mt-1 py-1 rounded-2 text-center">
                    {{session('error')}}
                  </div>
                @endif
                <form class="d-none" id="form-delete-department" action="{{ route('destroy.department',['id'=>$id]) }}">
                  @csrf
                </form>

                <form method="POST" action="{{ route('edit.department',['id'=>$id]) }}">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="card-title text-secondary">
                      Manage Departments:
                    </div>
                  </div>
                    
                  <div class="card p-2 shandow-lg bg-light">
                    <div class="container-fluid">
                      <div class="row align-items-center justify-content-center">
                        <div class="">
                            <label for="name" class="form-label">Edit Department:</label>
                            <input type="text" class="form-control bg-white" name ="name" id="name" placeholder="e.g Criminal Registry" aria-describedby="textHelp"value="{{ old('name',$data['name']) }}">
                            @error('name')
                              <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                      <div class="container-fluid">
                        <div class="row justify-content-between mt-3">
                              <div id="deleteButton" title="Delete" onclick="confirmDelete('delete-department','department')" 
                              class="btn btn-danger btn-sm col-md-3 col-lg-2 py-1"><span> Delete <i class="fa fa-trash" aria-hidden="true"></i></span></div>
                              <button type="submit" class="btn btn-success btn-sm col-md-3 col-lg-2 py-1"><span> Edit <i class="fa fa-pencil" aria-hidden="true"></i></span></button>
                        </div>
                      </div>
                    <div class="row justify-content-end mt-2">
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
</div>
@include('sections.footer')

@endsection