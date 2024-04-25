@extends('sections.layout')
@section('display-logo')
    d-block d-lg-none
@endsection
@section('content')
<div class="body-wrapper" style="min-height: 93vh; overflow-y: auto;">
    <!--  Header Start -->
    @include('sections.header')
    <!--  Header End -->

    {{-- Body --}}
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-12 mt-5 col-lg-10 col-xxl-5">
                        <div class="card mb-0">
                            <div class="card-body">
                                @if (session('success'))
                  <div class="text-success bg-light-success mt-1 py-1 rounded-2 text-center">
                    {{session('success')}}
                  </div>
                            @endif
                            @if (session('warning'))
                            <div class="text-warning bg-light-warning mt-1 py-1 rounded-2 text-center">
                                {{session('warning')}}
                            </div>
                            @endif
                            @if (session('error'))
                            <div class="text-danger bg-light-danger mt-1 py-1 rounded-2 text-center">
                                {{session('error')}}
                            </div>
                            @endif
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p class="text-center fs-5">Logged Activities <i class="fa fa-list" aria-hidden="true"></i></p>
                                    <div class="col-md-6 log-lg- d-flex justify-content-between align-items-center">
                                        <label class="form-check-label" for="selectAll">Select All <input type="checkbox" id="selectAll"></label>
                                        <button class="btn btn-danger" id="deleteSelected">Delete <i class="fa fa-trash"></i> </button>
                                    </div>  
                                </div>
                                <form class="form-horizontal" id="deleteSelectedForm" action="{{ route('delete.selected.activities') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="selectedActivities" id="selectedActivities">
                                </form>
                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>User</th>
                                                <th>Action</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activities as $activity)
                                            <tr>
                                                <td>{{ $activity->date }}</td>
                                                <td>{{ $activity->time }}</td>
                                                <td>{{ $activity->user_name }}</td>
                                                <td>{{ $activity->action }}</td>
                                                <td><input type="checkbox" class="activityCheckbox" value="{{ $activity->id }}"></td>
                                            </tr>
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
    {{-- Footer Start --}}
    @include('sections.footer')
</div>

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        var checkboxes = document.getElementsByClassName('activityCheckbox');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });

    document.getElementById('deleteSelected').addEventListener('click', function() {
        var selectedIds = [];
        var checkboxes = document.getElementsByClassName('activityCheckbox');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedIds.push(checkboxes[i].value);
            }
        }
        // Send selectedIds to the server for deletion
        console.log(selectedIds);
        $('#selectedActivities').val(selectedIds);
        $('#deleteSelectedForm').submit();
    });
</script>
@endsection