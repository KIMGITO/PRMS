
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
               
                <p class="text-center fs-5">Files On Loan</p>
                {{-- search field --}}
                <div class="row justify-content-between align-items-center mb-3">
                    <div class="text-nowrap logo-img text-center d-block col-md-3 col-lg-2">
                        <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="100" alt="">
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
                 
                </div>
                @foreach ($transactions as $file)
                  @if ($file->id === $info)
                  <div class="table-responsive">
                    <table class="table table-responsive text-nowrap mb-0 align-middle bg-light-info mb-3 border border-0 rounded-3">
                      <thead class="text-dark fs-3 bg-body-secondary">
                        <tr class="border ">
                          <th colspan="5" class="justify-content-between">
                            <h6 class="fw-bolder mb-0 text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> More About Transaction Number <span class="fw-s rounded-3 bg-secondary px-2 text-white ">#{{$info}}</span> </h6>
                          </th>
                          <th colspan="2">
                            COURT: <span class="badge bg-warning  text-dark fw-semibold">{{$file->file->court->name}}</span>
                          </th>
                          <th colspan="2">
                            JUDGE: <span class="badge bg-success  text-dark fw-semibold">{{$file->file->judge->name}}</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="border-bottom-0 text-center" colspan="2">
                            <h6 class="fw-semibold mb-1">File Number</h6>
                            <span class="fw-normal">{{$file->file->casetype->case_type." ".$file->file_number}}  </span>                          
                          </td>
                          <td class="border-bottom-0 text-center" colspan="2">
                              <h6 class="fw-semibold mb-1">Issued By</h6>
                              <span class="fw-normal text-capitalize">{{$file->user->first_name." ".$file->user->last_name}}</span>                          
                          </td>
                          <td class="border-bottom-0 text-center" colspan="1">
                            <h6 class="fw-semibold mb-1">Transaction Date</h6>
                            <span class="fw-normal">{{$file->issuedDate}}</span>                          
                          </td>
                          <td class="border-bottom-0 text-center" colspan="1">
                           
                            <h6 class="fw-semibold mb-1">To <span class="fw-normal text-uppercase"> {{ $file->department->name }}</span> </h6>
                            <h6 class="fw-semibold mb-1">Through <span class="fw-normal text-capitalize">{{ $file->name }}</span> </h6>                         
                          </td>
                          <td class="border-bottom-0 text-center bg-light-secondary rounded-2" colspan="1">
                            <h6 class="fw-semibold mb-1">Applicants</h6>
                           
                            @if (strpos($file->file->plaintiffs,',') !== false)
                                  @php
                                      $plaintiffs = explode(',',$file->file->plaintiffs);
                                  @endphp
                                  <ol>
                                    @foreach ($plaintiffs as $plaintiff)
                                      <li class="text-capitalize small">{{$plaintiff}}</li>
                                  @endforeach
                                  </ol>
                              @else
                                  <ol class="small">
                                    <li><p class="text-capitalize"> {{$file->file->plaintiffs}}</p></li>
                                  </ol>
                              @endif
                            
                            
                          </td>
                          <td class="border-bottom-0 text-center bg-light-danger rounded-2" colspan="1">
                            <h6 class="fw-semibold mb-1">Defendants</h6>
                              @if (strpos($file->file->defendants,',') !== false)
                                  @php
                                      $defendants = explode(',',$file->file->defendants);
                                  @endphp
                                  <ol>
                                    @foreach ($defendants as $defendant)
                                      <li class="text-capitalize small">{{$defendant}}</li>
                                  @endforeach
                                  </ol>
                              @else
                                  <ol class="small">
                                    <li><p class="text-capitalize"> {{$file->file->defendants}}</p></li>
                                  </ol>
                              @endif                        
                          </td>
                          <td class="border-bottom-0 text-center">
                            <div class=" gap-2">
                              <h6 class="fw-semibold mb-1">Return</h6>
                              <div class="badge bg-primary rounded-3 fw-semibold">Low</div>
                            </div>
                          </td>
                        </tr>   
                        <tr class="bg-light-danger">
                          <td class="border-bottom-0 text-start" colspan="4">
                            <h6 class="fw-semibold mb-1">Requestd For: </h6>
                            <span class="fw-normal">
                                <ol class=" list-group-horizontal">
                                  @foreach ($purposes as $reason)
                                  <li class="list-group-item">{{$reason}}</li>
                                  @endforeach  
                                </ol>
                            </span>                          
                          </td>
                          <td class="border-bottom-o text-start" colspan="4">
                            <h6 class="fw-semibold mb-1"> Transaction Description: </h6>
                            <p class="text-dark">{{$file->file->case_description}}</p>
                          </td>
                        <td>

                        </td>  
                        </tr>                   
                      </tbody>
                    </table>
                  </div>
                  @break
                  @endif
                @endforeach
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
                <div class="table-responsive">
                    <table class="table table-hover text-dark  table-light-success">
                        <thead class="fw-bolder fs-8">
                            <caption class="text-center fs-7 fw-5">
                              {{ $transactions->count() }} Files On Loan
                            </caption>
                            <div class="text-priamry fw-semibold" id="tableComment"></div>
                            <tr class="bg-info">
                                <th>File Number</th>
                                <th>Issued BY</th>
                                <th>Borrower</th>
                                <th>Loaning Date</th>
                                <th>Expected Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="dataList">
                          @php
                              $count = 1;
                          @endphp
                          @foreach ($transactions as $file)
                          <tr class="p-0">
                            <td>{{$file->file->casetype->case_type." ".$file->file->case_number}}</td>
                            <td>
                              <p class="text-capitalize"> {{$file->user->first_name." ".$file->user->last_name}}</p>
                            </td>
                            <td>
                              <p class="text-capitalize"> {{$file['name']}}</p>
                            </td>
                            <td class="text-capitalize">{{$file->issuedDate}}</td>
                            <td class="text-capitalize small text-info">{{$file->dateExpected}}</td>
                            <td class="text-capitalize small text-info">Overdue+2days</td>
                            <td class="bg-light">
                              <div class="row">
                                @php
                                    $id = Crypt::encrypt($file['id']);
                                @endphp
                                <a  href="{{ route('store.return.file',['id'=>$id])}}" title="Confirm Return File" class="btn btn-outline-success col-6 btn btn-rounded-0 btn-sm border-0 fw-bolder">
                                  <i class="fa fa-check p-0 m-0" aria-hidden="true"></i>
                                  <i class="fa fa-check p-0 m-0" aria-hidden="true"></i>
                                </a>
                              <form class="col-6" action="{{ route('return.file.info',['id'=>$id]) }}" id="form-{{ $file['id'] }}" method="GET">
                                <button type="submit" title="More Info" class="btn btn-outline-primary btn btn-rounded-0 btn-sm border-0">
                                  <i class="fa fa-info-circle fs-4" aria-hidden="true"></i> 
                                </button>
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
