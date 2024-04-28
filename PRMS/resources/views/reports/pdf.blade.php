

<style>
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    position: relative;
    top: 2%;
}
th, td {
    border: 1px solid #000;
    padding: 8px;
}
th {
    background-color: #f2f2f2;
}
.pdf-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 20px;
}
.header-desc {
    position: relative;
    right: 1%;
    left: 80%;
    top: 2%;
    text-align: end;
    font-size: 12px;
    color: #333;
    
}
.pdf-header p {
    font-size: 12px;
    color: #333;
    align-self: flex-end;
}
.li {
    position: relative;
    top: 1.5%;
    padding: 0% 1% 0% 2%;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    background-color: #f2f2f2;
}
.li img {
    position: absolute;
    top: -1.2%;
    right: 2%;
    width: 100px;
    height: auto;
    display: inline;
    border-radius: 8px;
}
.li h1 {
    left: 25%;
    right: 25%;
    display: inline;
    align-items: stretch;
    font-weight: 900;
    font-size: 30px;
    color: #0e6aa7d2;
}
.title{
  text-align: center;
  font-size: 20px;
  font-weight: 800;
  text-decoration: underline;
}
.report-message p{
  font-size: 15px;
}
</style>
<div class="pdf-header">
  <div class="li">
    <h1> Disposal Report </h1>
    <img  src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logos/logo.png'))) }}">
    
  </div>
  <div>
    <div class="header-desc ">
      <p>Developed by PRMS system <br> On: {{ $time }}</p><br>
      
    </div>
  
</div>
<div class="title"><h3>{{$title}}</h3></div>
<div class="report-message"><p>{{$message}}</p></div>

<div class="table-responsive">
      <table class="table table-hover text-dark  table-light-success">
          <thead class="fw-bolder fs-8">
              <caption class="text-center fs-7 fw-5">
              </caption>
              <div class="text-priamry fw-semibold" id="tableComment"></div>
              <tr class="bg-info">
                  <th>Case Type</th>
                  <th>Case Number</th>
                  <th>Plaintiffs</th>
                  <th>Defendants</th>
                  <th>Presiding Judge</th>
                  <th>Recived on</th>
              </tr>
          </thead>
          <tbody id="dataList">
            @foreach($files as $file)
            <tr class="p-0">
              <td class="text-capitalize">{{$file->casetype->case_type}}</td>
              <td>{{$file->casetype->initials.' '.$file->case_number}}</td>
              <td>
                @if (strpos($file['plaintiffs'],',') !== false)
                    @php
                        $plaintiffs = explode(',',$file['plaintiffs']);
                    @endphp
                    <ol>
                      @foreach ($plaintiffs as $plaintiff)
                        <li class="text-capitalize small">{{$plaintiff}}</li>
                    @endforeach
                    </ol>
                @else
                <p class="text-capitalize"> {{$file['plaintiffs']}}</p>
                @endif
              </td>
              <td>
                @if (strpos($file['defendants'],',') !== false)
                    @php
                        $defendants = explode(',',$file['defendants']);
                    @endphp
                    <ol>
                      @foreach ($defendants as $defendant)
                        <li class="text-capitalize small">{{$defendant}}</li>
                    @endforeach
                    </ol>
                @else
                <p class="text-capitalize"> {{$file['defendants']}}</p>
                @endif
              </td>
              <td class="text-capitalize">{{$file->judge->name}}</td>
              <td class="text-capitalize small text-info">{{$file->created_at}}</td>
              
            </tr>
            @endforeach
        </tbody>
          
         
      </table>
  </div>

{{-- @endsection --}}