
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

                <p class="text-center fs-5">Add New File</p>
                <a href="/{{ auth()->user()->role }}" class="text-nowrap logo-img text-center d-block pb-4 w-100">
                  <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="180" alt="">
                </a>
                
                <form method="POST" action="{{ route('store.new.file') }}">
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
                    <p class="text-danger fw-light">All fields with <span class="fw-bold h4 text-danger">*</span> are required</p>

                    <div class="mb-3 col-lg-5">
                        <label for="caseNumber" class="form-label">Case Number <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" name ="caseNumber"id="caseNumber" aria-describedby="textHelp"value="{{ old('caseNumber') }}">
                        @error( 'caseNumber' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="row ">
                    <div class="mb-3">
                        <label for="caseType" class="form-label">Case Type <span class="text-danger">*</span> </label>
                        <select class="form-select form-select-lg" name="caseType" id="caseType">
                          <option class="text-danger bg-primary" value="0" >Select a case type...</option>
                          @foreach ($types as $type)
                            <option {{ old('caseType') == $type['id'] ? 'selected' :''}} value="{{ $type['id'] }}">{{ $type['case_type'] }}</option>
                          @endforeach
                        </select>
                        @error( 'caseType' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="filingDate" class="form-label">Filing Date <span class="text-danger">*</span> </label>
                        <input type="date" class="form-control" name ="filingDate"id="filingDate" aria-describedby="textHelp"value="{{ old('filingDate') }}">
                        @error( 'filingDate' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3 col-lg-6">
                        <label for="rullingDate" class="form-label">Rulling Date</label>
                        <input type="date" class="form-control" name ="rullingDate"id="rullingDate" aria-describedby="textHelp"value="{{ old('rullingDate') }}">
                        @error( 'rullingDate' )
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="card shandow-lg p-2 ">
                    <div class="card-title text-bolder text-success text-center bg-light-danger">
                        Parties Involved
                    </div>
                    <div class="container-fluid">
                       <div class="row">
                        <div class="mb-3 py-2 col-lg-6 scrollbar scrollbar-info" >
                            <div class="card-title h5 text-success">
                                <p>Plaintiffs <span class="text-danger">*</span> </p>
                            </div>
                            <div id="plaintiffsField">
                              <div class="mb-1" id="p1">
                                  <label for="plaintiff" class="form-label text-capitalize">Name 1</label>
                                  <input type="plaintiff" class="form-control bg-light-success plaintiff"  id="plaintiff-1" aria-describedby="textHelp">
                                  <p class="text-sm text-danger" id="p1"></p>
                              </div>
                              
                            </div>
                            {{-- error reporting --}}
                            @error( 'plaintiffs' )
                              <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <div class="d-none">
                              <input type="text" readonly id="plaintiffsCombined" name="plaintiffs">
                            </div>
                            {{-- add more / remove a field --}}
                            <div class="row justify-content-end">
                                <div class="btn  rounded text-danger btn-sm col-3 col-md-2 col-lg-2">
                                    <i class="fa fa-minus-circle fa-2x" id="minusPlaintiffs" aria-hidden="true"></i>
                                </div>
                                <div class="btn rounded text-success btn-sm col-3 col-md-2 col-lg-2">
                                    <i class="fa fa-plus-circle fa-2x" id="addPlaintiffs"  aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 py-2 col-lg-6 border-0 border-2 border-start border-danger scrollbar scrollbar-info">
                            <div class="card-title h5 text-danger">
                                <p>Defendants <span class="text-danger">*</span> </p>
                            </div>
                            <div id="defendantsField">
                              <div class="mb-1" id="d1">
                                  <label for="defendant" class="form-label text-capitalize">Name 1</label>
                                  <input type="defendant" class="form-control bg-light-success defendant"  id="defendant-1" aria-describedby="textHelp">
                              </div>
                            </div>
                           
                            {{-- error reporting  --}}
                            @error( 'defendants' )
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <div class="d-none">
                              <input type="text" readonly id="defendantsCombined" name="defendants">
                            </div>
                            {{-- Add more / remove fields --}}
                            <div class="row justify-content-end">
                                <div class="btn  rounded text-danger btn-sm col-3 col-md-2 col-lg-2">
                                    <i class="fa fa-minus-circle fa-2x" id="minusDefendants" aria-hidden="true"></i>
                                </div>
                                <div class="btn rounded text-success btn-sm col-3 col-md-2 col-lg-2">
                                    <i class="fa fa-plus-circle fa-2x" id="addDefendants" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                       </div>
                        
                      </div>
                  </div>
                  
                  <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="judge" class="form-label">Presiding Judge <span class="text-danger">*</span> </label>
                        <select class="form-select form-select-lg" name="judge" id="judge">
                            <option class="text-danger bg-primary" value="0">Select a judge...</option>
                            @foreach ( $judges as $judge )
                              <option {{ old('judge') == $judge['id'] ? 'selected' :''}} value="{{ $judge['id'] }}">{{ $judge['name'] }}</option>
                            @endforeach
                           
                        </select>
                        @error( 'judge' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3 col-lg-6">
                        <label for="court" class="form-label">Court <span class="text-danger">*</span> </label>
                        <select class="form-select form-select-lg" name="court" id="court">
                            <option  class="text-danger bg-primary" value="0">Select a court...</option>
                            @foreach ( $courts as $court )
                              <option {{ old('court') == $court['id'] ? 'selected' :''}} value="{{ $court['id'] }}">{{ $court['name'] }}</option>
                            @endforeach
                        </select>
                        @error( 'court' )
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="mb-3">
                    <label for="caseDescription" class="form-label">Case Description<i class="fa fa-audio-description" aria-hidden="true"></i></label>
                    <textarea class="form-control" name="caseDescription" id="caseDescription" placeholder="A simple description of the case..." rows="2">{{ old('caseDescription') }}</textarea>
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