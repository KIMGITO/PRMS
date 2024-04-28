<header class="app-header p-0" >
    <nav class="navbar col-12 navbar-expand-lg bg-secondary">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none @yield('display-btn')">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item d-block bg-dark rounded-circle @yield('display-logo') ">
          <a href="" class="nav-link" >
          <div class="brand-logo d-flex col-12 align-items-center justify-content-between">
              <img src="{{ asset('images/logos/icon.ico')}}" class="img img-fluid" alt="logo" width="100%">
          </div>
        </a>
          
        </li>
      </ul>
      
      <div class="navbar-collapse d-flex justify-content-center align-items-center px-0" id="navbarNav">
        
          <h1 class="fw-bolder d-inline py-2 shadow-lg text-center">
            Print Records Management System
        </h1>
        
      </div>
      {{-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">Toggle top offcanvas</button> --}}
      {{-- <div class="col-md-2 col-lg-2">
        <div class="btn btn-sm btn-info col-6 col-md-4 offset-lg-6 rounded-pill justify-content-between" id="sortBtn"> <i class="fa fa-arrow-down-short-wide tw-bold"></i></div>
        <div class="container-fluid mt-1 d-none" id="sortCard">
          <div class="row">
              <div class="position-relative">
                  <div class="card position-absolute p-1 bg-light top-0 start-0">
                    <p class="card-text">This card overlays everything within it.</p>
                  </div>
              </div>
          </div>
      </div> --}}

      {{-- toggle calendar --}}

    </nav>
  </header>