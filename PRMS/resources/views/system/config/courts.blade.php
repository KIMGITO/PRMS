
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
                
                <form method="POST" action="{{ route('store.new.court') }}">
                  @csrf
                  <div class="row">
                    <div class="card-title text-secondary">
                        Manage Courts:
                    </div>
                  </div>
                    
                  <div class="card p-2 shandow-lg bg-light">
                    <div class="row align-items-center">
                        <div class="col-lg-9 mb-3">
                            <label for="name" class="form-label">Add Court:</label>
                            <input type="text" class="form-control bg-white" name="name" id="name" placeholder="eg Environment And Land Court" aria-describedby="textHelp" value="{{ old('name') }}">
                            
                        </div>
                        <div class="col-lg-3 mt-2">
                            <button type="submit" class="btn btn-primary btn-sm"><span>Add</span></button>
                        </div>
                    </div>
                    @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
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
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                  $count =1;
                              @endphp
                                @foreach ($courts as $court)
                                <tr class="h-25">
                                    <td scope="row">{{ $count }}</td>
                                    <td>{{$court['name']}}</td>
                                    <td class="bg-light-secondary">
                                      @php
                                          $id = Crypt::encrypt($court['id']);
                                      @endphp
                                        <div class="row">
                                          <a href="{{ route('update.court.form',['id'=>$id]) }}" class="btn btn-outline-success col-3 btn btn-rounded-0 btn-sm border-0">
                                            <i class="fa fa-file-signature fs-4 " aria-hidden="true"></i>
                                          </a>
                                          @php
                                              $id = Crypt::encrypt($court['id']);
                                          @endphp

                                        <form class="col-6" action="{{ route('destroy.court',['id'=>$id]) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-outline-danger btn btn-rounded-0 btn-sm border-0">
                                            <i class="fa fa-file-circle-xmark fs-4 " aria-hidden="true"></i>
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