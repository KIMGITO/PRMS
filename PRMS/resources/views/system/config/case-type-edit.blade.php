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
                @php
                    $id = Crypt::encrypt($data['id']);
                @endphp
                <form method="POST" action="{{ route('update.caseType', ['id'=>$id]) }}">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="card-title text-secondary">
                        Manage Case Types:
                    </div>
                  </div>
                    
                  <div class="card p-2 shandow-lg bg-light">
                    <div class="row">
                        <div class="mb-3 col-lg-2">
                            <label for="initials" class="form-label">Initials:</label>
                            <input type="text" class="form-control bg-white" name ="initials" id="initials" placeholder="eg DIV" aria-describedby="textHelp" value="{{ $data['initials'] }}">
                            @error('initials')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-lg-7">
                            <label for="caseType" class="form-label">Add a case Type:</label>
                            <input type="text" class="form-control bg-white" name ="caseType" id="caseType" placeholder="eg Divorce" aria-describedby="textHelp" value="{{ $data['case_type'] }}">
                            @error('caseType')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-lg-3">
                            <label for="duration" class="form-label">Duration In Years:</label>
                            <input type="text" class="form-control bg-white" name ="duration" id="duration" placeholder="eg 3" aria-describedby="textHelp" value="{{ $data['duration'] }}">
                            @error('duration')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                  </div>
                  <div class="row justify-content-end">
                    <div class="d-flex align-items-center  col-md-3 col-lg-2">
                        <button type="submit" class="btn btn-primary btn-sm"><span>Update</span></button>
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
{{-- Footer Start --}}
@include('sections.footer')

@endsection