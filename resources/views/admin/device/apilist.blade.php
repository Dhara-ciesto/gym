@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Device Operations</h2></section>
 -->          <!-- general form elements -->
        

<div class="container-fluid">
  <hr> 
  @if ($message = Session::get('message'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>
@endif 
<div class="table-wrapper">
  <div class="table-title">

       <div class="box">
    <div class="box-header">
    <h3 class="box-title">Device Operations</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body"><div class="col-lg-12">
      <div class="row">
        <div class="col-md-12" style="margin-bottom: 20px;">
           {{--  <form action="{{ route('searchapi') }}" class="form-inline" method="post">
              @csrf
              <div class="form-row">
                <div class="col-md-3">
                  <label>From Date:</label>
                  <input type="date" name="fromdate" class="form-control">
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-3">
                  <label>To Date:</label>
                  <input type="date" name="todate" class="form-control">
                </div>
              </div>

              <div class="form-row">
                <button class="btn btn-primary" style="margin-top: 24px;">Submit</button>
              </div>
              
            </form> --}}
        </div><br/>
        <div class="row">
          <div class="col-md-12">
        <table id="example1" class="table table-bordered table-responsive table-striped" role="grid" aria-describedby="example1_info">
          <thead>
             <tr>
                <th>#</th>
                <th>Username</th>
                <th>Operation</th>
                <th>Response</th>
                <th>Date</th>
                <th>status</th>
              </tr>
              </thead>
              <tbody>
              @foreach($apilist as $key => $api) 
              <tr>
                <td>{{ ++$key }}</td>
                @if(!empty($api->user->username))
                  <td>{{$api->user->username}}</td>
                @endif
                @if(!empty($api->anytimeaccess->username))
                  <td>{{$api->anytimeaccess->username}}</td>
                @endif
                <td>{{$api->apitype}}</td>
                @if($api->status == 1)
                @if($api->response_code == 0)
                  <td style="color: green;">Success</td>
                @else
                  <td style="color: red;">Fail</td>
                @endif
                @else
                  <td></td>
                @endif
                <td>{{ date('d-m-Y', strtotime($api->created_at)) }}</td>
                @if($api->status == 1)
                  <td style="color: green;">Complete</td>
                @else
                  <td style="color: red;">Pending</td>
                @endif        
              </tr>
              @endforeach
              
             
            </tbody></div>
            </table>
          </div>
        </div>
            <div class="row"> 
              <div class="col-md-12">
                <center>{{ $apilist->links() }}</center>
              </div> 
            </div>
<!-- /.box-body -->
</div>
        </div>

    </div>
  </div>
</div>
</div>
</div></div>
</div>
@endsection
@push('script')

<script>
  

</script>
@endpush