
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
          <div class="col-md-12 col-lg-10 col-xxl-8">
            <div class="card mb-0">
              <div class="card-body">
                <div class="row">
                  <a href="{{ route('redirect.back',['url'=>$info->url]) }}" class="btn col-1 fw-bolder bg-danger-subtle">Back</a>
                  <p class="text-center col-11 fs-5"> <i class="fa fa-info-circle" aria-hidden="true"></i> File Info</p>
                </div>
                <div class="row">
                        <div class="col-6">
                              <a href="/{{ auth()->user()->role }}" class="text-nowrap logo-img text-center d-block w-50 ">
                                    <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="80" alt="">
                              </a>
                        </div>
                        <div class="container-fluid col-6">
                              <div class="row bg-light-secondary rounded">
                                    <div class="col-6 text-primary">
                                         <i class="fas fa-handshake fa-spin fs-4"></i> {{$info->transaction_count}} Successfful Transactions
                                    </div>
                                    <div class="col-6 {{$info->status =='available'?'text-success':'text-danger'}} text-capitalize">
                                        <i class="fa fa-question-circle fa-spin text-primary fs-5" aria-hidden="true"></i> <span class="text-primary">Status</span> {{$info->status}}
                                    </div>
                              </div>
                        </div>
                </div>
                
                <div class="card-group">
                  <div class="text-center col-4">
                        <div class="card-body">
                              <h4 class="card-title text-capitalize">{{$info->casetype->case_type}} </h4>
                              <p class="card-text"> <span class="lead">NO: {{$info->casetype->initials."  ".$info->case_number}}</span></p>
                              <h4 class="card-title">Recived On:</h4>
                              <p class="card-text">{{$info->created_at}}</p>
                        </div>
                  </div>
                  <div class="text-center col-4">
                        <div class="card-body">
                              <h4 class="card-title text-capitalize">Filing Date:</h4>
                              <p class="card-text">{{$info->filing_date}}</p>
                              <h4 class="card-title text-capitalize">Ruling Date:</h4>
                              <p class="card-text">{{$info->ruling_date != ""?$info->ruling_date:"Not Ruled"}}</p>
                        </div>
                  </div>
                  <div class="text-center col-4">
                        <div class="card-body">
                              <h4 class="card-title text-capitalize">Judge:</h4>
                              <p class="card-text">{{$info->judge->name}}</p>
                              <h4 class="card-title text-capitalize">Court:</h4>
                              <p class="card-text">{{$info->court->name}}</p>
                        </div>
                  </div>
                  <div class="text-start  p-0 col-3 bg-light-success rounded">
                        <div class="card-body">
                              <h4 class="card-title text-capitalize">Plaintiffs:</h4>
                              @if (strpos($info->plaintiffs,',') !== false)
                              @php
                                  $plaintiffs = explode(',',$info->plaintiffs);
                              @endphp
                              <ol>
                                @foreach ($plaintiffs as $plaintiff)
                                  <li class="text-capitalize small">{{$plaintiff}}</li>
                              @endforeach
                              </ol>
                          @else
                              <ol class="small">
                                <li><p class="text-capitalize"> {{$info->plaintiffs}}</p></li>
                              </ol>
                          @endif
                        </div>
                  </div>
                  <div class="text-start  p-0 col-3 bg-light-danger rounded">
                        <div class="card-body">
                              <h4 class="card-title text-capitalize">Defendants:</h4>
                              @if (strpos($info->defendants,',') !== false)
                              @php
                                  $defendants = explode(',',$info->defendants);
                              @endphp
                              <ol>
                                @foreach ($defendants as $defendant)
                                  <li class="text-capitalize small">{{$defendant}}</li>
                              @endforeach
                              </ol>
                          @else
                              <ol class="small">
                                <li><p class="text-capitalize"> {{$info->defendants}}</p></li>
                              </ol>
                          @endif
                        </div>
                  </div>
                  <div class="text-start bg-light-primary rounded col-6">
                        <div class="card-body">
                              <h4 class="card-title text-capitalize">Description:</h4>
                              <p class="card-text">{{$info->judge->name}}</p>
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