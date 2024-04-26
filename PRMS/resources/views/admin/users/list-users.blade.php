
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
               
                <p class="text-center fs-5">User List</p>
                {{-- search field --}}
                <div class="row justify-content-between align-items-end mb-3">
                    <div class="text-nowrap logo-img text-center d-block col-md-6 col-lg-4">
                        <img src="{{ asset('images/logos/logo.png') }}" class="rounded-circle" width="150" alt="">
                    </div>
                    <div class="col-md-6 col-lg-4">
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
                
                <div class="table-responsive">
                  @if(session('success'))
                      <div class="alert alert-success fw-bold">
                          {{ session('success') }}
                      </div>
                  @endif
                  @if(session('error'))
                      <div class="alert alert-danger fw-bold">
                          {{ session('error') }}
                      </div>
                  @endif
                  @if(session('warning'))
                    <div class="alert alert-warning fw-bold">
                        {{ session('error') }}
                    </div>
                  @endif
                  @if (session('info'))
                      <div class="alert alert-primary fw-bold">
                        {{ session('info') }}
                      </div>
                  @endif

                    <table class="table table-hover text-dark  table-light-success">
                        <thead class="fw-bolder fs-8">
                            <caption class="text-center fs-7 fw-5">
                                <i>User list <b> {{ $users->links("pagination::bootstrap-5") }} </b></i>
                            </caption>
                            <div class="text-priamry fw-semibold" id="tableComment"></div>
                            <tr class="bg-info">
                                <th>Name</th>
                                <th>National Id</th>
                                <th>Job Id</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="dataList">
                          @php
                              $count = 1;
                          @endphp
                          @foreach ($users as $user)
                          @php
                              $id = Crypt::encrypt($user['id']);
                          @endphp
                          <tr>
                            <td>{{$user['first_name'].' '.$user['last_name']}}</td>
                            <td>{{$user['national_id']}}</td>
                            <td>{{$user['work_id']}}</td>
                            <td>{{$user['email']}}</td>
                            <td>{{$user['phone']}}</td>
                            <td>{{$user['role']}}</td>
                            <td class="bg-light">
                              <div class="row">
                                <a href="{{ $user->id == auth()->user()->id ? route('user.profile'):route('edit.user.form',['id'=>$id])}}" class="btn btn-outline-success col-4 btn btn-rounded-0 btn-sm border-0">
                                  <i class="fa fa-user-edit fs-4 " aria-hidden="true"></i>
                                </a>
                              <form class="col-6" action="{{ route('destroy.user',['id'=>$user['id']]) }}" id="form-{{$user['id']}}" method="POST">
                                @method('DELETE')
                                <div onclick="confirmDelete({{$user['id']}})"  class="btn btn-outline-danger btn btn-rounded-0 btn-sm border-0">
                                  <i class="fa fa-user-times fs-4 " aria-hidden="true"></i>
                                </div>
                              </form>
                              </div>
                          </td>
                          </tr>
                          @php
                              $count++;
                          @endphp
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

