
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
                
                <form method="POST" action="{{ route('store.new.caseType') }}">
                  @csrf
                  <div class="row">
                    <div class="card-title text-secondary">
                        Manage Case Types:
                    </div>
                  </div>
                    
                  <div class="card p-2 shandow-lg bg-light">
                    <div class="row">
                        <div class="mb-3 col-lg-2">
                            <label for="initials" class="form-label">Initials:</label>
                            <input type="text" class="form-control bg-white" name ="initials" id="initials" placeholder="eg DIV" aria-describedby="textHelp"value="{{ old('initials') }}">
                            @error('initials')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-lg-7">
                            <label for="caseType" class="form-label">Add a case Type:</label>
                            <input type="text" class="form-control bg-white" name ="caseType" id="caseType" placeholder="eg Divorce" aria-describedby="textHelp"value="{{ old('caseType') }}">
                            @error('caseType')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-lg-3">
                            <label for="duration" class="form-label">Duration In Years:</label>
                            <input type="text" class="form-control bg-white" name ="duration" id="duration" placeholder="eg 3" aria-describedby="textHelp"value="{{ old('duration') }}">
                            @error('duration')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                  </div>
                  <div class="row justify-content-end">
                    <div class="d-flex align-items-center  col-md-3 col-lg-2">
                        <button type="submit" class="btn btn-primary btn-sm"><span>Add</span></button>
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
                                        <th scope="col">Initials</th>
                                        <th scope="col">Case Type</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $count =1;
                                  @endphp
                                    @foreach ($types as $type)
                                    <tr class="h-25">
                                        <td scope="row">{{ $count }}</td>
                                        <td>{{$type['initials']}}</td>
                                        <td>{{$type['case_type']}}</td>
                                        <td class="bg-light-secondary">
                                          @php
                                              $id = Crypt::encrypt($type['id']);
                                          @endphp
                                            <div class="row">
                                              <a href="{{ route('update.caseType.form',['id'=>$id]) }}" class="btn btn-outline-success col-3 btn btn-rounded-0 btn-sm border-0">
                                                <i class="fa fa-file-pen fs-4 " aria-hidden="true"></i>
                                              </a>
                                              @php
                                                  $id = Crypt::encrypt($type['id']);
                                              @endphp
                                            <form class="col-6" action="{{ route('destroy.caseType',['id'=>$id]) }}" method="POST">
                                              @method('DELETE')
                                              <button type="submit" class="btn btn-outline-danger btn btn-rounded-0 btn-sm border-0">
                                                <i class="fa fa-file-circle-minus fs-4 " aria-hidden="true"></i>
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