
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
          <div class="col-lg-12">
            <div class="card mb-0">
              <div class="card-body mt-4">
                <p class="text-center fs-5">Mature Files List</p>
                {{-- search field --}}
                <div class="row justify-content-between align-items-center mb-3">
                    <div class="text-nowrap logo-img text-center d-block col-md-5 col-lg-4">
                        <img  class="rounded-circle" width="150" alt="">
                    </div>
                    <div class="col-md-5 col-lg-4">
                      <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light-success offset border-0 table-hover rounded-start-5" id="searchIcon">
                              <button type="button" id="searchBtn" class="btn rounded-pill text-dark "><i class="fas fa-search "></i></button>
                            </span>
                            <input type="text" id="searchInput" name="query" placeholder="search user " class="form-control bg-light-success border-0 px-4 p-0 rounded-start-0 rounded-end-5 text-dark fs-4" placeholder="Search" aria-label="Search" aria-describedby="searchIcon" >
                        </div>
                      </form>
                    </div>
                    <div class="col-md-2 col-lg-2">
                      <a href="{{ route('mature.download.pdf') }}" class="btn btn-sm btn-outline-success"> <i class='fa fa-eye text-info'></i>  <i class='fa fa-download mx-1'></i>  <i class='fa fa-print text-dark'></i> </a>

                    </div>
                 
                </div>
                
                <div class="table-responsive">
                  @if(session('success'))
                      <div class="alert alert-success fw-bold">
                          {{ session('success') }}
                      </div>
                  @endif
                  @if(session('error'))
                      <div class="alert alert-danger p-1 fw-bold">
                          {{ session('error') }}
                      </div>
                  @endif
                    <table class="table table-hover text-dark  table-light-success">
                        <thead class="fw-bolder fs-8">
                            <caption class="text-center fs-7 fw-5">
                              
                            </caption>
                            <div class="text-priamry fw-semibold" id="tableComment"></div>
                            <tr class="bg-info">
                                <th>Case Type</th>
                                <th>Case Number</th>
                                <th>Plaintiffs</th>
                                <th>Defendants</th>
                                <th>Presiding Judge</th>
                                <th>Recived on</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                          @foreach($files as $file)
                          {{-- <tr>
                              <td>{{ $file->casetype->case_type }}</td>
                              <td>{{ $file->casetype->initials.' '.$file->case_number }}</td>
                              <td></td>
                              <td>{{ $file->defendants }}</td>
                              <td>{{ $file->judge->name }}</td>
                              <td>{{ $file->filing_date }}</td>
                          </tr> --}}
                          <tr class="p-0">
                            <td class="text-capitalize">{{$file->casetype->case_type}}</td>
                            <td>{{$file->casetype->initials.' '.$file->case_number}}</td>
                            <td>
                              @if (strpos($file['plaintiffs'],',') !== false)
                                  @php
                                      $plaintiffs = explode(',',$file['plaintiffs']);
                                  @endphp
                                  <ol>
                                    @foreach ($plaintiffs as $plaintiff)
                                      <li class="text-capitalize small">{{$plaintiff}}</li>
                                  @endforeach
                                  </ol>
                              @else
                              <p class="text-capitalize"> {{$file['plaintiffs']}}</p>
                              @endif
                            </td>
                            <td>
                              @if (strpos($file['defendants'],',') !== false)
                                  @php
                                      $defendants = explode(',',$file['defendants']);
                                  @endphp
                                  <ol>
                                    @foreach ($defendants as $defendant)
                                      <li class="text-capitalize small">{{$defendant}}</li>
                                  @endforeach
                                  </ol>
                              @else
                              <p class="text-capitalize"> {{$file['defendants']}}</p>
                              @endif
                            </td>
                            <td class="text-capitalize">{{$file->judge->name}}</td>
                            <td class="text-capitalize small text-info">{{$file->created_at}}</td>
                            
                          </tr>
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
{{-- Footer Start --}}
@include('sections.footer')

@endsection
