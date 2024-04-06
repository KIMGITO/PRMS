
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
                
                <form method="POST" action="{{ route('store.new.purpose') }}">
                  @csrf
                  <div class="row">
                    <div class="card-title text-secondary">
                        Manage File Request Purpose:
                    </div>
                  </div>
                    
                  <div class="card p-2 shandow-lg bg-light">
                    <div class="container-fluid">
                      <div class="row align-items-center">
                        <div class="col-md-6 col-lg-8">
                            <label for="purpose" class="form-label">Add A Request Purpose:</label>
                            <input type="text" class="form-control bg-white text-capitalize" name ="purpose" id="purpose" placeholder="e.g Reading" aria-describedby="textHelp"value="{{ old('purpose') }}">
                            @error('purpose')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 col-lg-4">
                          <label class="form-label">Under Supervision?:</label>
                          <div class="bg-white rounded-2 px-1 row p-2">
                            <div class="form-check col-6">
                              <input class="form-check-input bg-danger"  value="1" type="radio" name="supervision" id="yes" />
                              <label class="form-check-label"  for="yes"> Yes </label>
                            </div>
                            <div class="form-check col-6">
                              <input class="form-check-input bg-danger" checked value="0" type="radio" name="supervision" id="no" />
                              <label class="form-check-label" for="no"> No </label>
                            </div>
                          </div>
                          @error('supervision')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                              <label for="description" class="form-label">Purpose:</label>
                              <textarea class="form-control" name="description" id="description" rows="2" placeholder="A small description."></textarea>
                              @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                              @enderror
                        </div>
                        
                        
                    </div>
                    <div class="row justify-content-end mt-2">
                      <div class="d-flex align-items-center  col-12">
                          <button type="submit" class="btn btn-primary col-12 btn-sm"><span>Add</span></button>
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
                                    <th scope="col">Purpose</th>
                                    <th scope="col">Supervision</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                  $count =1;
                              @endphp
                                @foreach ($data as $purpose)
                                <tr class="h-25">
                                    <td scope="row">{{ $count }}</td>
                                    <td class="text-capitalize"> {{$purpose['purpose']}}</td>
                                    <td>{{ $purpose['supervised']== '1' ?'Yes':'No' }}</td>
                                    <td class="small text-primary">{{ $purpose['description'] }}</td>
                                    <td class="bg-light-secondary">
                                        <div class="row">
                                          <a href="" class="btn btn-outline-success col-3 btn btn-rounded-0 btn-sm border-0">
                                            <i class="fa fa-user-edit" aria-hidden="true"></i>
                                          </a>
                                        <form class="col-6" action="" method="POST">
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