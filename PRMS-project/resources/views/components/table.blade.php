<table class="table table-hover text-dark  table-light-success">
                        <thead class="fw-bolder fs-8">
                            <caption class="text-center fs-7 fw-5">
                                {{-- <i>User list <b> {{ $users->links("pagination::bootstrap-5") }} </b></i> --}}
                            </caption>
                            <div class="text-priamry fw-semibold" id="tableComment"></div>
                            <tr>
                              @foreach ($heads as $head)
                                <th>{{ $head }}</th>
                              @endforeach
                            </tr>
                        </thead>
                        <tbody id="{{ $tId }}">
                          @foreach ($data as $row)
                          <tr>
                            @foreach ($row as $cell)
                              <td>{{$cell}}</td>
                            @endforeach
                          </tr>
                          @endforeach
                        </tbody>
                    </table>