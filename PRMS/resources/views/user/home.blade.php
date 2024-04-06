@extends('sections.layout')
@section('display-logo')
    d-block d-lg-none
@endsection
@section('content')
<div class="body-wrapper" style="min-height: 93vh">
    <!--  Header Start -->
      @include('sections.header')
    <!--  Header End -->
    <div class="container-fluid">
      <!--  Row 1 -->
      <div class="row">
        <div class=" w-100">
          <div class="card-body">
            <div class="row justify-content-between align-items-center bg- rounded d-flex">
              <div class="col-md-6">
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
                <h5 class="card-title fw-bolder  fs-4 my-3 text-start">Quick Search A file:</h5>
              </div>
              <div class="col-md-6">
                @include('sections.search')
              </div>
            </div>
            
            <div class="offcanvas offcanvas-top col-md-9 col-lg-6 " tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="height: 100vh">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="bg-sccess h-100" >
                <div class=" offcanvas-body p-2 rounded" id="calendar"></div>
              </div>
            </div>

            <div class="row mt-2 d-block">
              <div class="bg-light d-flex justify-content-center align-items-center  ">
                  <div class="table-responsive scrollbar scrollbar-info mt-2">
                    <table class="table table-striped table-hover table-borderless table-primary ">
                      <thead class="table-info">  
                        <tr>
                          <th>Column 1</th>
                          <th>Column 2</th>
                          <th>Coldgdgdumn 3</th>
                          <th>Column 1</th>
                          <th>Column 2</th>
                          <th>Column dgdfg3</th>
                        </tr>
                      </thead>
                      <tbody class="table-group-divider">
                        <tr class="table-primary">
                          <td scope="row">Item</td>
                          <td>Item</td>
                          <td>Item</td>
                          <td>Itegfggdgdgm</td>
                          <td>Item</td>
                          <td>Itesffdgdm</td>
                        </tr>
                        <tr  class="table-primary">
                          <td scope="row">Item</td>
                          <td>csdsdtem</td>
                          <td>Item</td>
                          <td>Item</td>
                          <td>Item</td>
                          <td>Item</td>
                        </tr>
                        <tr class="table-primary">
                          <td scope="row">Item</td>
                          <td>Item</td>
                          <td>Item</td>
                          <td>Itegfggdgdgm</td>
                          <td>Item</td>
                          <td>Itesffdgdm</td>
                        </tr>
                        <tr  class="table-primary">
                          <td scope="row">Item</td>
                          <td>csdsdtem</td>
                          <td>Item</td>
                          <td>Item</td>
                          <td>Item</td>
                          <td>Item</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        
                      </tfoot>
                    </table>
                  </div>
                  
                </table>
              </div>
            </div>        
          </div>
        </div>
      </div>
    </div>
    <div class="m-3">
      <div class="row">
        <div class="col-md-11 container ">
          <div class="row">
            <div class="col-md-3 px-1">
              <div class="card bg-light-info">
                <div class="card-header h3 text-center">Trending</div>
                <div class="card-body justify-content-center align-items-center">
                  <p class="display-3 counter text-center" data-count="8">
                  </p>
                  <p class="text-center">Records</p>
                </div>
              </div>
            </div>
            <div class="col-md-5 px-1">
              <div class="card bg-light-success">
                <div class="card-header h2 text-center">Total</div>
                <div class="card-body justify-content-center align-items-center">
                  <p class="display-3 counter text-center" data-count="5000">
                  </p>
                  <p class="text-center">Records</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 px-1">
              <div class="card bg-light-danger">
                <div class="card-header h2 text-center">Mature</div>
                <div class="card-body justify-content-center align-items-center">
                  <p class="display-3 counter count-numbers text-center" data-count="230">
                  </p>
                  <p class="text-center">Records</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="col-md-4 my-3">
          <div class="bg-light-success p-2 rounded" id="calendar"></div>
        </div> --}}
      </div>
      <div class="row px-4">
        <div class="col-md-7">
          <div class="card">
            <div class="card-header h4 d-flex justify-content-between align-items-center">
              <p class="h2">Incoming Requests</p>
                <p class="counter bg-light-success rounded-1 p-2 " data-count="4"></p>
              
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-primary">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">From</th>
                      <th scope="col">Request</th>
                      <th class="bg-light-success" scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="">
                      <td scope="row">#01</td>
                      <td>John</td>
                      <td>Succ 23/2014</td>
                      <td class="text-center bg-light-success"> <button type="button" class="btn btn-success btn-sm"> Accept <i class="fas fa-question-circle fa-fw"></i> </button> </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div>
        <div class="col-md-5">
        <div class="card">
          <div class="card-header h2">Pending Activities</div>
          <div class="card-body">
            <div
              class="table-responsive"
            >
              <table
                class="table table-primary"
              >
                <thead>
                  <tr>
                    <th scope="col">Task</th>
                    <th scope="col">Description</th>
                    <th scope="col">Done?</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="">
                    <td scope="row">01</td>
                    <td>wash ufhe gerbger gje gregjkerg ren erkf erferfkf </td>
                    <td>
                      <div class="d-grid gap-2">
                        <button type="button" name="" id="" class="btn btn-primary btn-sm">
                          Done
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
        
        </div>
      </div>
    </div>
  </div>
{{-- Footer Start --}}
@include('sections.footer')
{{-- Footer End --}}
  @endsection