
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
              <div class="card-body">
               
                <p class="text-center fs-5">Search Results List</p>
                {{-- search field --}}
                <div class="row justify-content-between align-items-center mb-3">
                    <div class="text-nowrap logo-img text-center d-block col-md-5 col-lg-4">
                        <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="150" alt="">
                    </div>
                    <div class="col-md-5 col-lg-4">
                      <form class="form-inline" method="get" action="{{ route('search.file') }}">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light-success offset border-0 table-hover rounded-start-5" id="searchIcon">
                              <button type="submit" id="searchBtn" class="btn rounded-pill text-dark "><i class="fas fa-search "></i></button>
                            </span>
                            <input type="text" {{-- id="searchInput" --}}  name="query" placeholder="search user " class="form-control bg-light-success border-0 px-4 p-0 rounded-start-0 rounded-end-5 text-dark fs-4" placeholder="Search" aria-label="Search" aria-describedby="searchIcon" >
                            
                        </div>
                      </form>
                    </div>
                    <div class="col-md-2 col-lg-2">
                      @if ($search)
                      <a href="{{ route('list.files') }}" class="btn btn-sm btn-info col-6 col-md-6 offset-lg-5 rounded-pill justify-content-between" id="sortBtn"> 
                        <i class="fa fa-arrow-left tw-bold" id="sort"></i> Back
                      </a>
                      @endif
                 
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
                                {{-- {{ $files->links('pagination::bootstrap-5',['class'=>'pagination'])}} --}}
                              
                              {{-- Total Files: {{ $files->count() }} --}}
                            
                              
                            </caption>
                            <div class="text-priamry fw-semibold" id="tableComment"></div>
                            <tr class="bg-info">
                                <th>Case Type</th>
                                <th>Case Number</th>
                                <th>Plaintiffs</th>
                                <th>Defendants</th>
                                <th>Presiding Judge</th>
                                <th>Filing Date</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="dataList">
                          @php
                              $count = 1;
                          @endphp
                          @foreach ($files as $file)
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
                            <td class="text-capitalize small text-info">{{$file->filing_date}}</td>
                            <td class="text-capitalize {{ $file->status == 'available'?' text-primary':'text-danger' }}">{{$file->status}}</td>
                            <td colspan="2" class="bg-light">
                              <div class="row">
                                @php
                                    $id = Crypt::encrypt($file['id']);
                                @endphp
                                <a href="{{ route('loan.file',['id'=>$id])}}" title="Loan File" class="btn {{ $file['status']=='available'?'btn-outline-success':'btn-outline-secondary shandow-md disabled' }}  col-4 btn btn-rounded-0 py-2 border-0">
                                  @if ($file['status']=='available')
                                  <i class="fas fa-handshake fs-4 " aria-hidden="true"></i>
                                  @else
                                  <i class="fas fa-handshake-slash fs-4 " aria-hidden="true"></i>
                                  @endif
                                </a>
                                <a href="{{ route('file.info',['id'=>$id])}}"  class="btn col-4 text-center btn-outline" title="More info">
                                  <i class="fa fa-info-circle me-5" aria-hidden="true"></i>
                                </a>
                                <form title="Delete" class="col-4 ms-0" action="{{ route('destroy.user',['id'=>$file['id']]) }}" id="form-{{ $file['id'] }}" method="POST">
                                  @method('DELETE')
                                  <div onclick="confirmDelete({{$file['id']}},'File')" class="btn btn-outline-danger btn-rounded px-2 border-0">
                                    <i class="fa fa-file-circle-xmark fs-4 " aria-hidden="true"></i>
                                  </div>
                                </form>
                              </div>
                          </td>
                          </tr>
                          @php
                              $count++;
                          @endphp
                          @endforeach
                          @if ($message !="")
                          <tr>
                            <td colspan="7"><div class="fw-bold text-danger text-center">{{$message}}</div></td>
                          </tr>
                          @endif
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
