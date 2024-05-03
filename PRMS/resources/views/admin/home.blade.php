@extends('sections.layout')
@section('display-logo')
    d-block d-lg-none
@endsection
@section('content')
<div class="body-wrapper">
  <style>
    .time{
      position: relative;
      bottom: 0;
      right: 0;
    }
    .scrollbar{
      height: 350px;
    }
    
  </style>
    <!--  Header Start -->
      @include('sections.header')
    <!--  Header End -->
    <div class="container-fluid ">
      <!--  Row 1 -->
      <div class="row bg-white py-1">
        <div class="col-lg-8 d-flex align-items-strech justify-content-center shandow-lg">
          <div class=" w-100">
            @if(session('success'))
                  <div class="text-success fw-bold">
                      {{ session('success') }}
                  </div>
              @endif
              @if(session('error'))
                  <div class="alert alert-danger fw-bold">
                      {{ session('error') }}
                  </div>
              @endif
              @if (session('info'))
                  <div class="text-primary fw-bold">
                    {{ session('info') }}
                  </div>
              @endif
            <div class="card bg-light rounded  ">
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold text-center  text-success"> Daily Transactions Rate -1 week </h5>
                </div>
              </div>

              <script>
                var popColors = @json($pop_colors)
              </script>
              <script>
                var popInitials = @json($pop_initials)
              </script>
              <script>
                var popNames = @json($pop_names)
              </script>
              <script>
                var popCount = @json($pop_count)
              </script>
              <script>
                var popMap = @json($pop_map)
              </script>
              <script>
                var transactions = @json($transactions)
              </script>
              <script>
                var totals = @json($pop_totals)
              </script>

              {{-- <div id="records-population" class="p-2 rounded"></div> --}}
              <div id="records-population" class="p-2 rounded"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12">
              <div class=" overflow-hidden">
                <div class="card p-1 bg-light">
                  <h5 class="card-title text-center fw-semibold">Storage Distribution</h5>
                  <div class="row text-success text-center rounded-2  align-items-center"> 
                    <div id="records" class="mt-5"></div> 
                    <i class="lead">Distribution of files </i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row my-1 rounded ">
        <div class="col-lg-5 card  p-1 d-flex align-items-stretch">
          <div class="w-100 ">
            <div class="card-body p-1">
              <div class="mb-4">
                @if ($message_count > 0 && $messages[0]->red == null)
                  <span id="counter-budge" class="badge bg-danger rounded-circle lead position-absolute top-0 start-100  translate-middle">
                    {{$message_count}}
                  </span>
                @endif
                <h5 class="card-title fw-semibold">Messages </h5>
              </div>
             
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
            @if ($message_count > 0)
              <div class="btn btn-danger btn-sm col-4 text-end" onclick="deleteMessages()">Delete messages <i class="fa fa-trash fa-shake"></i> </div>
            @endif
          </div>
        </div>
        <div class="col-lg-7 card p-1 d-flex align-items-stretch">
          <div class=" w-100">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Recent Transactions
                
              </h5>
              <div class="table-responsive col-12">
                <table class="table text-nowrap mb-0 align-middle col-12">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">No</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">User</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Description</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Status</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Time</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($logged_activities as $activity) 
                    <tr>
                      <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6></td>
                      <td class="border-bottom-0 small">
                          <h6 class="fw-semibold mb-1">{{$activity->first_name}}</h6>
                          <span class="fw-normal">{{ $activity->last_name }}</span>                          
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal small overflow-wrap"> {{$activity->description}} </p>
                      </td>
                      <td class="border-bottom-0">
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge small bg-{{($activity->status == true) ? 'success' : 'danger'}} rounded-3 fw-semibold">
                            {{($activity->status == true) ? 'success' : 'failed' }}
                          </span>
                        </div>
                      </td>
                      <td class="border-bottom-0">
                        <p class=" mb-0 small "> {{\Carbon\Carbon::parse($activity->created_at)->format('H:i:s')}}<br> {{\Carbon\Carbon::parse($activity->created_at)->format('d/m')}} </p>
                      </td>
                    </tr> 
                    @endforeach      
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- Footer Start --}}
      @include('sections.footer')
      {{-- Footer End --}}
    </div>
  </div>

  @endsection