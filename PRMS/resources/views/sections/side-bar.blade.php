<aside class="left-sidebar rounded-3">
    <!-- Sidebar scroll-->
    <div class="rounded-3">
      <div class="brand-logo d-flex align-items-center justify-content-between bg-dark">
        <a href='@if(Auth::check()) {{auth()->user()->role}}@endif  ' class="text-nowrap logo-img">
          <img src="{{ asset('images/logos/logo.png')}}" class="rounded-circle shadow-lg" width="180" alt="logo" />
          
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8 text-success"></i>
        </div>
      </div>
      {{-- <ul class="navbar-nav flex-row ms-auto align-items-center d-inline justify-content-end">
          
        </ul> --}}
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar bg-light " data-simplebar="">
        <ul id="sidebarnav" class="pb-5 ">

          <li class="sidebar-item pt-2">
            <a class="sidebar-link d-flex gap-3 px-2 bg-primary" href="#profile-management" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="records-management" >
              <div class="align-center gap-4 px-2">
                <img src="{{ asset('images/logos/logo.png') }}" alt="" width="50" height="50" class="rounded-circle">
                <span class="fw-bolder offset-5 fs-6 text-light text-capitalize"> @if(Auth::check()) {{auth()->user()->first_name}}@endif </span>
              </div>
            </a>
          </li>
          <div class="container-fluid collapse p-0" id="profile-management">
            <div class="col-12 rounded-0 p-1 bg-primary">
              <a href="{{ route('user.profile') }}" class="btn btn-primary-outline d-flex align-items-center gap-3 dropdown-item py-1">
                <i class="fa fa-edit text-white fs-5" aria-hidden="true"></i>
                <p class="mb-0 fs-4 fw-bolder text-dark"> Edit</p>
              </a>
              <a href="" class="btn btn-primary-outline d-flex align-items-center gap-3 dropdown-item py-1">
                <i class="fa fa-calculator text-white fs-5" aria-hidden="true"></i>
                <p class="mb-0 fs-4 fw-bolder text-dark"> Activities</p>
              </a>
              <a href="{{ route('logout') }}" class="btn btn-sm btn-danger col-5 rounded-0 offset-7"> <span class="fw-bolder me-3">Log Out</span></a>
            </div>
          </div>

          <div class="bg-info-light shadow-lg rounded-top-3">
            <li class="sidebar-item pt-2">
              <a class="sidebar-link d-flex gap-3 px-2 " href="/{{ auth()->user()->role }}" >
                <div class="align-center gap-4 d-flex px-2"><i class="fa fa-gauge fs-5 gap-5 mt-1 text-dark"></i>
                  <p class="fs-4 fw-bold"> 
                    @if (auth()->user()->role == 'admin')
                         Admin
                    @endif
                   Dashboard</p>
                  </div>
              </a>
            </li>
           
            @if (Auth::check() && auth()->user()->role =='admin')
            <li class="sidebar-item pt-2 ">
              <a class="sidebar-link d-flex gap-3 px-2 bg-info " href="/user" >
                <div class="align-center gap-4 d-flex px-2"><i class="fa fa-gauge fs-5 gap-5 mt-1 text-dark"></i><p class="fs-4 fw-bold text-warning">User Dashboard</p></div>
              </a>
            </li>

              <li class="sidebar-item py-2">
                <a class="sidebar-link d-flex gap-3 px-2" href="#user-management" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="user-management" >
                  <div class="align-center gap-4 d-flex px-2 text-dark"><i class="fa fa-users fs-5 gap-3 mt-1"></i><p class="fs-4 fw-bold"> Users</p></div>
                </a>
              </li>
              <div class="container collapse" id="user-management">
                <div class="message-body ms-3 p ps-2 bg-dark">
                  <a href="{{ route('user.list')}}" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-success">
                    <i class="fa fa-users-cog"></i>
                    <p class="mb-0 fs-4"> Manage Users</p>
                  </a>
                  <a href="{{ route('create.user.form') }}" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-info">
                    <i class="fa fa-user-plus"></i>
                    <p class="mb-0 fs-4">Add User</p>
                  </a>
                </div>
              </div>
            
                
            @endif
            

            <li class="sidebar-item  pt-2">
                <a class="sidebar-link d-flex gap-3 px-2" href="#records-management" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="records-management" >
                  <div class="align-center gap-4 d-flex px-2"><i class="fa fa-folder-tree text-dark fs-4 gap-5 mt-1"></i>
                    <p class="fs-4 fw-bold"> Manage Files</p>
                  </div>
                </a>
            </li>
            <div class="container collapse" id="records-management">
              <div class="message-body ms-3 p-2 bg-dark">
                <a href="{{ route('list.files') }}" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-success">
                  <i class="fa fa-file-invoice"></i>
                  <p class="mb-0 fs-4"> All Files</p>
                </a>
                <a href="{{ route('create.file.form') }}" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-info">
                  <i class="fa fa-file-circle-plus"></i>
                  <p class="mb-0 fs-4">Add File</p>
                </a>
                <a href="" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-warning">
                  <i class="fa fa-file-export"></i>
                  <p class="mb-0 fs-4">Loan File</p>
                </a>
                <a href="{{ route('return.file') }}" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-danger">
                  <i class="fa fa-file-circle-check"></i>
                  <p class="mb-0 fs-4">Return File</p>
                </a>
              </div>
            </div>
            <li class="sidebar-item pt-2">
              <a class="sidebar-link d-flex gap-3 px-2" href="#tasks" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="tasks" >
                <div class="align-center gap-4 d-flex px-2"><i class="fa fa-timeline text-dark fs-4 gap-5 mt-1"></i>
                  <p class="fs-4"> Manage Tasks</p>
                </div>
              </a>
            </li>
            <div class="container collapse" id="tasks">
              <div class="message-body ms-3 p-2 bg-dark">
                <a href="javascript:void(0)" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-success">
                  <i class="fa fa-list-check"></i>
                  <p class="mb-0 fs-4"> My Tasks</p>
                </a>
                <a href="javascript:void(0)" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-warning">
                  <i class="fa fa-up-right-from-square"></i>
                  <p class="mb-0 fs-4">Asign Task</p>
                </a>
                
              </div>
            </div>

            <li class="sidebar-item pt-2">
              <a class="sidebar-link d-flex gap-3 px-2" href="#reports" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="reports" >
                <div class="align-center gap-4 d-flex px-2"><i class="fa fa-file-signature text-dark fs-4 gap-5 mt-1"></i>
                  <p class="fs-4"> Report & Analysis</p>
                </div>
              </a>
            </li>
            <div class="container collapse" id="reports">
              <div class="message-body ms-3 p-2 bg-dark">
                <a href="{{ route('disposal.files') }}" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-success">
                  <i class="fs-4 p-1 mt-1 fa fa-file-invoice"></i>
                  <p class="mb-0 fs-4"> Mature Files</p>
                </a>
                <a href="javascript:void(0)" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-info">
                  <i class="fs-4 p-1 mt-1 fa fa-file-circle-plus"></i>
                  <p class="mb-0 fs-4">Add File</p>
                </a>
                <a href="javascript:void(0)" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-warning">
                  <i class="fs-4 p-1 mt-1 fa fa-file-export"></i>
                  <p class="mb-0 fs-4">Loan File</p>
                </a>
                <a href="javascript:void(0)" class="btn bt-success-outline d-flex align-items-center gap-3 dropdown-item py-1 text-danger">
                  <i class="fs-4 p-1 mt-1 fa fa-file-circle-check"></i>
                  <p class="mb-0 fs-4">Return File</p>
                </a>
              </div>
            </div>
        @if (auth()->user()->role =='admin')
        <div class="sidebar-item ">
          <a class="sidebar-link d-flex gap-3 px-2" href="#system" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="system" >
            <div class="align-center gap-4 d-flex px-2"><i class="fa fa-screwdriver-wrench text-dark fs-6 gap-5 mt-1"></i>
              <p class="fs-5"> System</p>
            </div>
          </a>
        </div>
        <div class="container collapse mb-5" id="system">
          <div class="message-body bg-ligt-success p-2">
            <a href="{{ route('config.caseType') }}" class=" bg-indigo mb-1 p-1 d-flex align-items-end gap-3 dropdown-item rounded-1 text-info">
              <i class="fs-5 p-2 mt-1 fa fa-wrench"></i>
              <p class="mb-0 fs-4"> Configurations</p>
            </a>
            <a href="{{ route('new.department') }}" class=" bg-indigo mb-1 p-1 d-flex align-items-end gap-3 dropdown-item rounded-1 text-info">
              <i class="fs-5 p-2 mt-1 fa fa-sitemap"></i>
              <p class="mb-0 fs-4"> Departments</p>
            </a>
            <a href="{{ route('logged.activities') }}" class=" bg-indigo mb-1 p-1 d-flex align-items-end gap-3 dropdown-item rounded-1 text-info">
              <i class="fs-5 p-2 mt-1 fa fa-fingerprint"></i>
              <p class="mb-0 fs-4">Logged Activies</p>
            </a>
            <a href="javascript:void(0)" class=" bg-indigo mb-1 p-1 d-flex align-items-end gap-3 dropdown-item rounded-1 text-danger">
              <i class="fs-5 p-2 mt-1 fa fa-file-invoice"></i>
              <p class="mb-0 fs-4">Files Settings</p>
            </a>
          </div>
        </div>
        @endif
        
      </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>