@extends('sections.layout')
@section('display-logo')
    d-block d-lg-none
@endsection
@section('content')
<div class="body-wrapper" style="min-height: 93vh">
    @include('sections.header')
    
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-12 col-lg-10 col-xxl-8">
                        <div class="card mb-0">
                            <div class="card-body bg-dark text-light">
                                <div class="row">
                                    <a href="{{ route('redirect.back',['url'=>$info->url]) }}" class="btn btn-sm mb-3 col-1 fw-bolder bg-danger-subtle">Back</a>
                                    <p class="text-center col-11 fs-5 text-success"> <i class="fa fa-info-circle text-white" aria-hidden="true"></i> <span class="text-white">File Info</span> <span class="ms-5 mx-2 fs-2"><span class="text-info fs-4">Judge</span>: {{$info->judge->name}}</span> <span class="text-info fs-4">Court</span>: <span class="fs-2">{{$info->court->name}}</span></span> </p> 
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/{{ auth()->user()->role }}" class="text-nowrap logo-img text-center d-block w-50 ">
                                            <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="80" alt="">
                                        </a>
                                    </div>
                                    <div class="container-fluid col-9">
                                        <div class="row  rounded">
                                            <div title="Numbe of Successfful Transactions" class="col-4 text-info">
                                                <i class="fas fa-handshake fs-4"></i> {{$info->transaction_count}} 
                                            </div>
                                            <div title="Status" class="col-4 fa-bounce {{$info->status =='available'?'text-success':'text-danger'}} text-capitalize">
                                                <i class="fa fa-question-circle  {{$info->status =='available'?'text-success':'text-danger'}} fs-5" aria-hidden="true"></i> <span class="text-primary"></span> {{$info->status}}
                                            </div>
                                            <div class="col-4 text-primary" title="Dispoal Date ">
                                            <span class="bg-danger px-1 rounded-3">{{$info->disposal_date}}</span> <i class="fas fa-trash fa-shake fs-4 text-danger"></i>  
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-group">
                                    <div class="text-center col-4">
                                        <div class="card-body">
                                            <h4 class="card-title text-info text-capitalize">{{$info->casetype->case_type}} </h4>
                                            <p class="card-text"> <span class="lead">File No: {{$info->casetype->initials."  ".$info->case_number}}</span></p>
                                            <h4 class="card-title text-info">Received On:</h4>
                                            <p class="card-text">{{$info->created_at}}</p>
                                        </div>
                                    </div>
                                    <div class="text-center col-4">
                                        <div class="card-body">
                                            <h4 class="card-title text-info text-capitalize">Filing Date:</h4>
                                            <p class="card-text">{{$info->filing_date}}</p>
                                            <h4 class="card-title text-info text-capitalize">Ruling Date:</h4>
                                            <p class="card-text laed text-success">{{$info->ruling_date != "" ? $info->ruling_date : "Not Ruled"}}</p>
                                        </div>
                                    </div>
                                    <div class="text-center col-4">
                                        <div class="card-body">
                                            <h4 class="card-title text-info text-capitalize">Judge:</h4>
                                            <p class="card-text">{{$info->judge->name}}</p>
                                            <h4 class="card-title text-info text-capitalize">Court:</h4>
                                            <p class="card-text">{{$info->court->name}}</p>
                                        </div>
                                    </div>
                                    <div class="text-start p-0 col-4 rounded">
                                        <div class="bg-dark">
                                            <h4 class="card-title text-capitalize text-success">Plaintiffs:</h4>
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
                                    <div class="text-start  p-0 col-4 rounded">
                                        <div class="bg-dark">
                                            <h4 class="card-title text-danger text-capitalize">Defendants:</h4>
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
                                    <div class="text-start  rounded col-4">
                                        <div class=" card bg-dark p-2">
                                            <h4 class="card-title  text-primary text-capitalize">Description:</h4>
                                            <p class="card-text">{{$info->case_description}}</p>
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

    @include('sections.footer')

@endsection