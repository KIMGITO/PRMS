use Carbon\Carbon;
@extends('sections.layout')
@section('display-logo')
    d-block d-lg-none
@endsection
@section('content')
<div class="body-wrapper" >
    <!--  Header Start -->
        @include('sections.header')
    <!--  Header End -->
    <div class="container-fluid">
      <div class="row">
                @if(session('success'))
                  <div class="text-success fw-bold">
                      {{ session('success') }}
                  </div>
                @endif
                @if(session('erorr'))
                  <div class="alert alert-danger fw-bold">
                      {{ session('error') }}
                  </div>
                @endif

                <style>
                  .search-card{
                    position: relative;
                    top: 14%;
                    position: fixed;
                    z-index: 10;
                  }
                </style>
          <div class="card bg-dark ms-4 col-9 search-card  ">
            <div class="row mt-1 container-fluid">
              <div class="col-md-6">
                <h5 class="card-title fw-bolder text-white fs-4 my-3 text-start">Quick Search A file:</h5>
              </div>
              <div class="col-md-6">
                @include('sections.search')
              </div>
            </div>     
          </div>
      </div>
    </div>
    <div class="m-3">
      <div class="row">
        <div class="col-md-11 container ">
          <div class="row">
            <div class=" px-1">
              <div class="card">
                <table class="table table-hover  table-light-success">
                  <thead class="fw-bolder ">
                      <div class="text-priamry fw-semibold" id="tableComment"></div>
                      <tr class="bg-dark text-white">
                          <th>Case Type</th>
                          <th>Case Number</th>
                          <th>Presiding Judge</th>
                          <th>Filing Date</th>
                          <th>Status</th>
                          <th></th>
                      </tr>
                  </thead>
                  
                  <tbody id="dataList">
                    @foreach ($files as $file)
                      <tr class="p-0">
                        @php
                            $id = Crypt::encrypt($file->id);
                        @endphp
                        <td class="text-capitalize">{{$file->casetype->case_type}}</td>
                        <td>{{$file->casetype->initials.' '.$file->case_number}}</td>
                        <td class="text-capitalize">{{$file->judge->name}}</td>
                        <td class="text-capitalize small text-info">{{\Carbon\Carbon::parse($file->filing_date)->format('d/m/Y')}}</td>
                        <td class="text-capitalize {{ $file->status == 'available'?' text-primary':'text-danger' }}">{{$file->status}}</td>
                        <td class="h-1"><a href="{{ route('get.file',['id'=>$id]) }}" class="link link-success h-4">more</td>
                      </tr>
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
            {{-- <div class="col-md-3 px-1">
              <div class="card bg-light-info rounded-circle">
                <div class="mt-3 h3 text-center">Trending</div>
                <div class="card-body justify-content-center align-items-center">
                  <p class="display-2 counter text-center" data-count="8">
                  </p>
                  <p class="text-center">Records</p>
                </div>
              </div>
            </div> --}}
          </div>
        </div>
        {{-- <div class="col-md-4 my-3">
          <div class="bg-light-success p-2 rounded" id="calendar"></div>
        </div> --}}
      </div>
      <div class="row px-4">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header h4 d-flex justify-content-between align-items-center">
              <p class="h2">Requests</p>
                <p class="counter bg-light-success rounded-1 p-2 " data-count="{{$message_count}}"></p>
              
            </div>
            <div class="card-body">
              @if ($message_count > 0)
                  <div class="card scrollbar scrollbar-success col-12" >
                    <ul class="col-11">
                      <li class="row py-1">
                        <div class="col-6 fs-3 text-dark fw-bolder text-center py-2">Time</div>
                        <div class="col-6 fs-3 text-dark fw-bolder  py-2">Name</div>
                      </li>
                      @foreach ($messages as $message)
                      <div class="btn rounded-0 border-0 col-12 btn-outline-light-success  text-secondary" onclick="openSMS(@json($message->id))">
                        <li class="row" id="info-{{$message->id}}">
                          <div class="col-2 small">{{$loop->iteration}} </div>
                          <div class="col-4 small">{{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</div>
                          <div class="col-4 fs-3 text-dark small mt-n1">{{ $message->client->name }}</div>
                          @if ($message->red == null)
                            <i id="check-{{$message->id}}" class="fa fa-check-circle col-1" aria-hidden="true"></i>
                          @else
                            <i class="fa fa-check-circle col-1 text-success" aria-hidden="true"></i>
                          @endif
                        </li>
                        <div style="display: none" class="col-10 text-start small bg-dark rounded p-1 ms-4 my-3 overflow-wrap" id="sms-{{$message->id}}">
                          <span class="text-success me-2 mb-2"> <u> Message: </u></span>
                          <span class="text-info"> {{$message->body}}</span><br>
                          
                          <div class="time mt-4 text-end small"> <span class="me-2">{{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}</span> {{ \Carbon\Carbon::parse($message->created_at)->format('H:i:s') }}</div>
                        </div>
                      </div>
                      @endforeach
                    </ul>
                  </div>
                @else
                    <div class="lead text-dark">
                      No new Message,  New unrend messages will display here
                    </div>
                @endif
            </div>
          </div>
        </div>
        <div class="col-md-2">
        
        
        </div>
      </div>
    </div>
  </div>
{{-- Footer Start --}}
@include('sections.footer')
{{-- Footer End --}}
  @endsection