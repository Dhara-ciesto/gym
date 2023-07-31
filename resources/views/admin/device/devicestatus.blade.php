@extends('layouts.adminLayout.admin_design')
@section('content')
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Device Status</h2></section>
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
      <!-- <a href="{{ url('addrole') }}" class="bowercomponentscustomedarkbluebtn btn add-new bg-navy" style="height: 35px;"><i class="fa fa-plus"></i> Add New</a> -->
<form action="{{url('devicestatus')}}" method="post">
  {{ csrf_field() }}
    <h3 class="box-title">Device Status</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
      <div class="row">
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
             <tr>
                <th>Device Name</th>
                <th>Port No</th>
                <th style="text-align: center;">Status</th>
              </tr>
              </thead>
              <tbody>
                @if($deviceinfo)
                @foreach($deviceinfo as $dinfo)
              <tr>
                <td>{{$dinfo->devicename}}</td>
                <td>{{$dinfo->portno}}</td>
                <td> 

                  @if($dinfo->device_status == 1)
                    <label class="btn bg-green">Connected</label>
                  @else
                    <label class="btn btn-danger">Disconnected</label>
                  @endif
              
                </td>                
              </td>
              </tr>
              @endforeach
              
              @endif
               
            </tbody></div>
            </table>
<!-- /.box-body -->
</div>
        </div>
</form>
    </div>
  </div>
</div>
</div>
</div></div>
</div>
@endsection