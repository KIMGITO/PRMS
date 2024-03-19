
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
              <div class="card-body mt-5">

                <p class="text-center fs-5">Loan File</p>
                <a href="/{{ auth()->user()->role }}" class="text-nowrap logo-img text-center d-block pb-4 w-100">
                  <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="180" alt="">
                </a>
                @php
                  $id = Crypt::encrypt($file['id']);
                @endphp
                <form method="POST" action="{{ route('store.loan.file',['id'=>$id]) }}">
                        @csrf
                      <div class="row">
                          @if (session('success'))
                              <div class="text-success  mt-1 py-1">
                                  {{session('success')}}
                              </div>
                          @endif
                          @if (session('error'))
                              <div class="text-danger  mt-1 py-1">
                                  {{session('error')}}
                              </div>
                          @endif
                      </div>
                    
                  <div class="row ">
                    <div class="mb-3 col-lg-6">
                        <label for="caseNumber" class="form-label">Case Number <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control text-uppercase" readonly name ="caseNumber"id="caseNumber" aria-describedby="textHelp" value="{{ $file->casetype->initials." ".$file['case_number'] }}">
                        @error( 'caseNumber' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="department" class="form-label">Rquesting Department <span class="text-danger">*</span> </label>
                        <select class="form-select form-select-lg rounded-1 p-1 bg-light" name="department" id="department">
                          <option class="text-danger bg-primary" selected value="0" disabled >Select a department...</option>
                          @foreach ($departments as $department)
                            <option {{ old('department') == $department['id'] ? 'selected' :''}} value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                          @endforeach
                        </select>
                        @error( 'department' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  
                  <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="name" class="form-label">Through?: Name </label>
                        <input type="text" class="form-control" name ="name"id="name" aria-describedby="textHelp"value="{{ old('name') }}">
                        @error( 'name' )
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    <div class="mb-3 col-lg-6">
                        <label for="dateBack" class="form-label">When Expected Back:<span class="text-danger">*</span> </label>
                        <input type="datetime-local" class="form-control" name ="dateBack"id="dateBack" aria-describedby="textHelp"value="{{ old('dateBack') }}">
                        @error( 'dateBack' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                      
                  </div>
                  <div class="container-fluid">
                    <div class="row">
                      <label for="" class="form-label">Purpose Of Request (chek all that apply):<span class="text-danger">*</span> </label>
                      @foreach ($purpose as $reason)
                      <div class="form-check mb-3 col-md-4">
                        <input class="form-check-input bg-dark" @if (in_array($reason->id,old('purpose',[]))) checked @endif name="purpose[]" type="checkbox"  value="{{$reason->id}}" id='{{$reason['purpose']}}' />
                        <label class="form-check-label text-capitalize"  for='{{$reason['purpose']}}'> {{$reason->purpose}}</label>
                      </div>
                      @endforeach
                        @error( 'purpose' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="mb-3">
                      <label for="description" class="form-label">Description:</label>
                      <textarea class="form-control" name="description" id="description" placeholder="(optional) a small description" rows="2"></textarea>
                    </div>
                    @error( 'description' )
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    
                  </div>
                  <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2 "><span>Continue</span></button>
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