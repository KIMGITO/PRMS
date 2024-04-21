
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

                <p class="text-center fs-5">Configurations <i class="fa fa-cogs" aria-hidden="true"></i></p>
                @include('system.config.config-header')
                  
                <form method="POST" action="{{ route('store.new.judge') }}">
                  @csrf
                  <div class="row">
                    <div class="card-title text-secondary">
                        Manage Judges:
                    </div>
                  </div>
                    
                  <div class="card p-2 shandow-lg bg-light">
                    <div class="container-fluid">
                      <div class="row align-items-center">
                        <div class="col-lg-9">
                            <label for="name" class="form-label">Add A judge:</label>
                            <input type="text" class="form-control bg-white" name ="name" id="name" placeholder="e.g Lady Justice Kaniaru" aria-describedby="textHelp"value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                          <label class="form-label">Gender:</label>
                          <div class="bg-white rounded-2 px-1">
                            <div class="form-check">
                              <input class="form-check-input" checked value="male" type="radio" name="gender" id="male" />
                              <label class="form-check-label"  for="male"> Male </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" value="female" type="radio" name="gender" id="female" />
                              <label class="form-check-label" for="female"> Female </label>
                            </div>
                          </div>
                          @error('gender')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="row justify-content-end mt-2">
                      <div class="d-flex align-items-center  col-md-3 col-lg-2">
                          <button type="submit" class="btn btn-primary btn-sm"><span>Add</span></button>
                      </div>
                    </div>
                    </div>
                  </div>
                  
                </form>
                <div class="container-fluid">
                    <div class="row">
                      <div class="table-responsive scrollbar scrollbar-info">
                        <table  class="table table-striped table-hover table-borderless table-primary align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                  $count =1;
                              @endphp
                                @foreach ($judges as $judge)
                                <tr class="h-25">
                                    <td scope="row">{{ $count }}</td>
                                    <td>{{$judge['name']}}</td>
                                    <td>{{$judge['gender']}}</td>
                                    <td class="bg-light-secondary">
                                          @php
                                              $id = Crypt::encrypt($judge['id']);
                                          @endphp 
                                        <div class="row">
                                          <a href="{{ route('update.judge.form',['id'=>$id]) }}" class="btn btn-outline-success col-3 btn btn-rounded-0 btn-sm border-0">
                                            <i class="fa fa-user-edit" aria-hidden="true"></i>
                                          </a>
                                        <form class="col-6" action="{{ route('destroy.judge',['id'=>$id]) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-outline-danger btn btn-rounded-0 btn-sm border-0">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                          </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                        
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