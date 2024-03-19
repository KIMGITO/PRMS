
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

                <p class="text-center fs-5">Departments: <i class="fa fa-cogs" aria-hidden="true"></i></p>
                
                @if (session('success'))
                  <div class="text-success bg-light-success mt-1 py-1 rounded-2 text-center">
                    {{session('success')}}
                  </div>
                @endif
                @if (session('warning'))
                  <div class="text-warning bg-light-warning mt-1 py-1 rounded-2 text-center">
                    {{session('warning')}}
                  </div>
                @endif
                @if (session('error'))
                  <div class="text-danger bg-light-danger mt-1 py-1 rounded-2 text-center">
                    {{session('error')}}
                  </div>
                @endif
                
                <form method="POST" action="{{ route('store.new.department') }}">
                  @csrf
                  <div class="row">
                    <div class="card-title text-secondary">
                        Manage Departments:
                    </div>
                  </div>
                    
                  <div class="card p-2 shandow-lg bg-light">
                    <div class="container-fluid">
                      <div class="row align-items-center">
                        <div class="col-lg-9">
                            <label for="name" class="form-label">Add A Department:</label>
                            <input type="text" class="form-control bg-white" name ="name" id="name" placeholder="e.g Criminal Registry" aria-describedby="textHelp"value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex align-items-stretch mt-4 col-md-3 col-lg-2">
                              <button type="submit" class="btn btn-primary btn-sm"><span>Add</span></button>
                          </div>
                    </div>
                    <div class="row justify-content-end mt-2">
                      
                    </div>
                    </div>
                  </div>
                  
                </form>
                <div class="container-fluid">
                    <div  class="scrollbar scrollbar-info col-12">
                        <div class="row col-12">
                              <div class=" d-flex bg-light-danger align-items-stretch">
                                    <div class="card bg-light-danger shadow-none w-100">
                                      <div class="card-body p-4">
                                        <div class="mb-4">
                                          <h5 class="card-title fw-semibold text-danger text-center text-decoration-underline">Departments <span class="fs-1 offset-3 badge rounded-pill bg-danger">{{$data->count()}}</span></h5>
                                        </div>
                                        <ul class="timeline-widget mb-0 position-relative mb-n5">
                                          @php
                                            $count = 1;
                                            
                                          @endphp
                                          @foreach ($data as $department)
                                          @php
                                            $id = Crypt::encrypt($department->id);
                                          @endphp
                                            <li class="timeline-item d-flex position-relative overflow-hidden border-dark shadow-sm ">
                                              <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold ">
                                                <span class="h5 me-3">{{$count}}.</span>
                                                <span class="me-2 text-capitalize">{{$department->name}}</span>
                                                <span class="badge bg-secondary ms-2  btn border-0 rounded-3 fs-1 ">67 request</span>
                                                <span class="badge ms-4 rounded-1 fs-1 ">
                                                  <a href="{{ route('edit.department.form',['id'=>$id])}}" class=" btn btn-outline-dark btn-rounded-0 btn-sm border-0 text-decoration-underline ">Edit
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                  </a>
                                                </span>
                                                
                                              </div>
                                            </li>
                                            @php
                                              $count++;
                                            @endphp
                                          @endforeach
                                         
                                          
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                        </div>
                    </div>
                </div>
                
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