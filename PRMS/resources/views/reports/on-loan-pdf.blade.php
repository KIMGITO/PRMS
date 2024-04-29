
<head>
    <title>On Loan Files</title>
  </head>
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
  <div class="report-message">
    <p>{{$message}}</p>
  </div>
  
  <div class="table-responsive">
        <table class="table table-hover text-dark  table-light-success">
            <thead class="fw-bolder fs-8">
                <caption class="text-center fs-7 fw-5">
                </caption>
                <div class="text-priamry fw-semibold" id="tableComment"></div>
                <tr class="bg-info">
                    <th>No</th>
                    <th>File Number</th>
                    <th>Issed By</th>
                    <th>Issued To</th>
                    <th>Borrower</th>
                    <th>Loaning Date</th>
                    <th>Expected Date</th>
                </tr>
            </thead>
            <tbody id="dataList">
              @foreach($files as $file)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$file->file->casetype->initials." ".$file->file->case_number}}</td>
                <td>{{$file->user->first_name}}</td>
                <td>{{$file->department->name}}</td>
                <td style="">{{$file->name}}</td>
                <td>{{ date('d/m/Y', strtotime($file->issuedDate)) }}</td>
                <td>{{ date('d/m/Y', strtotime($file->dateExpected)) }}</td>
            </tr>
              @endforeach
          </tbody>
            
           
        </table>
    </div>
  
  {{-- @endsection --}}