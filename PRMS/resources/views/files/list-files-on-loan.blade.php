
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
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center  justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-12">
            <div class="card bg-dark mb-0">
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
                    <table class="table table-responsive  mb-0 align-middle bg-dark mb-3 border border-0 rounded-3">
                      <thead class="text- fs-3 ">
                        <tr class="border">
                          <th class="justify-content-between" colspan="3">
                            <p class="lead">
                              Transaction No:<span class="fw-s rounded-3 bg-secondary px-2 text-white ">{{$info}}</span>
                            </p>
                          </th>
                          <th colspan="">
                            <p class="lead">
                            COURT: <span class="fw-s rounded-4 bg-secondary px-2 text-dark ">{{$file->file->court->name}}</span>
                            </p>
                          </th>
                          <th colspan="2">
                            <p class="lead">
                            JUDGE: <span class="fw-s rounded-3 bg-secondary px-2 text-dark ">{{$file->file->judge->name}}</span>
                            </p>
                          </th>
                          <th colspan="1" class="text-end">
                            <p class="lead">
                              <button class="btn rounded-pill btn-sm btn-outline-danger" onclick="closeTable()">X</button>
                            </p>
                          </th>
                          <script>
                            function closeTable() {
                              document.querySelector('.table-responsive').style.display = 'none';
                            }
                          </script>
                        </tr>
                      </thead>

                      <tbody class="text-success">
                        <tr>
                          <td class="border-bottom-0 text-center" colspan="2" >
                            <h6 class="fw-semibold text-white mb-1">File Number</h6>
                            <span class="fw-normal">{{$file->file->casetype->initials." ".$file->file->case_number}}  </span>                          
                          </td>
                          <td class="border-bottom-0 text-center" colspan="1">
                              <h6 class="fw-semibold text-white mb-1">Issued By</h6>
                              <span class="fw-normal text-capitalize">{{$file->user->first_name." ".$file->user->last_name}}</span>                          
                          </td>
                          <td class="border-bottom-0 text-center" colspan="1">
                            <h6 class="fw-semibold text-white mb-1">To <span class="fw-normal text-success text-uppercase"> {{ $file->department->name }}</span> </h6>
                            <h6 class="fw-semibold text-white mb-1">Through <span class="fw-normal text-success text-capitalize">{{ $file->name }}</span> </h6>                         
                          </td>
                          @if ($file->status == 'pending')
                            <td class="border-bottom-0 text-center" colspan="1">
                              <h6 class="fw-semibold text-white mb-1">Issed On</h6>
                              <span class="fw-normal">{{ \Carbon\Carbon::parse($file->issedDate)->format('d/m/Y') }}</span>                          
                            </td>
                            <td class="border-bottom-0 text-center" colspan="1">
                              <h6 class="fw-semibold text-white mb-1">Expected In</h6>
                              <span class="fw-normal">{{ $file->period }}</span>                          
                            </td>
                            <td class="border-bottom-0 text-center">
                              <div class=" gap-2">
                                <h6 class="fw-semibold text-success mb-1">Status</h6>
                                <div class="badge bg-success  rounded-3 lead text-white">{{$file->status}}</div>
                              </div>
                            </td>
                          @else
                            <td class="border-bottom-0 text-center" colspan="1">
                              <h6 class="fw-semibold text-white mb-1">Expected Back Date</h6>
                              <span class="fw-normal">{{ \Carbon\Carbon::parse($file->dateExpected)->format('d/m/Y') }}</span>                          
                            </td>
                            <td class="border-bottom-0 text-center">
                              <div class=" gap-2">
                                <h6 class="fw-semibold text-danger mb-1">Status</h6>
                                <div class="badge bg-danger  rounded-3 lead text-white">{{$file->status}}</div>
                              </div>
                            </td>
                            <td class="border-bottom-0 text-center" colspan="1">
                              <h6 class="fw-semibold text-white mb-1"></h6>
                              <span class="fw-normal btn btn-outline-danger ">{{ $file->period }}</span>                          
                            </td>
                          @endif
                          
                        </tr>   
                        <tr class="text-success">
                          <td class="border-bottom-0 text-start" colspan="3">
                            <div class="card bg-dark p-1">
                              <h6 class="fw-semibold mb-1 text-white">Requestd For: </h6>
                              <span class="fw-normal">
                                  <ol class="small">
                                    @foreach ($purposes as $reason)
                                    <li class="list-group-item"><i class="fa fa-check text-white" aria-hidden="true"></i> {{$reason}}</li>
                                    @endforeach  
                                  </ol>
                              </span>  
                            </div>                          
                          </td>
                          <td class="border-bottom-o text-start" colspan="3">
                            <div class="card bg-dark p-1">
                              <h6 class="fw-semibold mb-1 text-white"> Transaction Description: </h6>
                              <p class="text-success small ">{{$file->file->case_description}}</p>
                            </div>
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
                <div class="table-responsive bg-light text-wrap">
                    <table class="table table-hover text-dark">
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
                          <tr class="p-0 {{ ($file->status == 'overdue') ? 'bg-light-danger' : 'bg-light-success'}}">
                            <td>{{$file->file->casetype->initials." ".$file->file->case_number}}</td>
                            <td>
                              <p class="text-capitalize"> {{$file->user->first_name." ".$file->user->last_name}}</p>
                            </td>
                            <td>
                              <p class="text-capitalize"> {{$file['name']}}</p>
                            </td>
                            <td class="text-capitalize">{{$file->issuedDate}}</td>
                            <td class="text-capitalize small text-primary">{{$file->dateExpected}}</td>
                            <td class="text-capitalize small {{($file->status == 'overdue') ? 'text-danger ': 'text-success'}}">{{($file->status == 'overdue') ? $file->status .`<br>`. $file->period : $file->status}}</td>
                            <td class="bg-light">
                              <div class="row">
                                @php
                                    $id = Crypt::encrypt($file['id']);
                                @endphp
                                <a  href="{{ route('store.return.file',['id'=>$id])}}" title="Confirm Return File" class="btn {{ ($file->status == 'overdue') ? 'btn-outline-danger' : 'btn-outline-success' }}  col-6  btn-rounded-0 btn-sm border-0 fw-bolder">
                                  <i class="fa fa-check p-0 m-0 " aria-hidden="true"></i>
                                  <i class="fa fa-check p-0 m-0 " aria-hidden="true"></i>
                                </a>
                              <form class="col-6" action="{{ route('return.file.info',['id'=>$id]) }}" id="form-{{ $file['id'] }}" method="GET">
                                <button type="submit"  title="More Info" class="btn {{ ($file->status == 'overdue') ? 'btn-outline-danger' : 'btn-outline-primary' }} btn btn-rounded-0 btn-sm border-0">
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
