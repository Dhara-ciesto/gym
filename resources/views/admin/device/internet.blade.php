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
   
     
<!--          <section class="content-header"><h2>Device On/Off Status</h2></section>
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
    <h3 class="box-title">Device On/Off Status</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body"><div class="col-lg-12">
      <div class="row">
        <table id="example1" class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
          <thead>
             <tr>
                <th>Date</th>
                <th>Time</th>
                <th>status</th>
              </tr>
              </thead>
              <tbody>
              @if(!empty($internetstatus))
                @foreach($internetstatus as $key => $internet) 
                <tr>
                  <td>{{ date('d-m-Y', strtotime($internet->internetdate)) }}</td>
                  <td>{{ date('H:i:s', strtotime($internet->internetdate)) }}</td>
                  @if($internet->internetstatus == 0)
                    <td><span style="color: red;">Down</span></td>
                  @else
                    <td><span style="color: green;">Up</span></td>
                  @endif
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="3">No Data Found</td>
                </tr>
              @endif
              
             
            </tbody></div>
            </table>
            <div class="row"> 
              <div class="col-md-12">
                <center>{{ $internetstatus->links() }}</center>
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