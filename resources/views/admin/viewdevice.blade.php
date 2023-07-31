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
   
     
<!--          <section class="content-header"><h2>View Device</h2></section>
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
      <a href="{{ url('adddevice') }}" class="bowercomponentscustomedarkbluebtn btn add-new bg-orange" style="height: 35px;"><i class="fa fa-plus"></i> Add New</a>

    <h3 class="box-title">View Device</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body"><div class="col-lg-12">
      <div class="row">
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
             <tr>
                <th>Device Name</th>
                <th>Ip Address</th>
                <th>Port No</th>
                <th>Reader</th>
                <!-- <th>Extra</th> -->
                <!-- <th>Actions</th> -->
              </tr>
              </thead>
              <tbody>@foreach($dinfo as $d)
              <tr>
                <td>{{$d->devicename}}</td>
                <td>{{$d->ipaddress}}</td>
                <td>{{$d->portno}}</td>
                <td>{{$d->reader}}</td>
               <!--  <td>information</td> -->
              <!-- <td><a href=""class="edit" title="Edit"><i class="fa fa-edit"></i></a> -->
                 
              </td>
              </tr>
              
              @endforeach
            </tbody></div>
            </table>
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
  $(function () {
    $('#example1').DataTable()
  });

</script>
@endpush