<div class="card text-center">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs justify-content-around">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName()=='config.caseType'?'active bg-light-info':'' }} " href="{{ route('config.caseType') }}">Caste Types Mgt</a>
            </li>
            <li class="nav-item sidebar-item ">
                <a class="nav-link {{ Route::currentRouteName()=='config.court'?'active bg-light-info':'' }} " href="{{ route('config.court') }}">Court Mgt</a>
            </li> 
            <li class="nav-item">
                <a  class="nav-link {{ Route::currentRouteName()=='config.judge'?'active bg-light-info':'' }} " href="{{ route('config.judge') }}">Judges Mgt</a>
            </li>
            <li class="nav-item">
                <a  class="nav-link {{ Route::currentRouteName()=='config.purpose'?'active bg-light-info':'' }} " href="{{ route('config.purpose') }}">Request Purpose</a>
            </li>
            
        </ul>
    </div>
    @if (session('success'))
        <div class="text-success bg-light-success mt-1 py-1">
            {{session('success')}}
        </div>
    @endif
    @if (session('error'))
        <div class="text-danger bg-light-danger mt-1 py-1">
            {{session('error')}}
        </div>
    @endif
    @if (session('info'))
        <div class="text-primary bg-light-primary mt-1 py-1">
            {{session('info')}}
        </div>
    @endif
</div>