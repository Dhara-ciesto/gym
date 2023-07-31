@extends('layouts.adminLayout.admin_design')
@section('content')
    <?php $permission = unserialize(session()->get('permission')); ?>

 <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
<script src="../../bower_components/datatables.net/js/jquery.js"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net/js/dataTables.bootstrap.min.js"></script>
<script src="../../bower_components/datatables.net/js/dataTables.responsive.js"></script>
 <style>
   .select2{
   width: 100% !important;
   }
   .select2-container--default .select2-selection--single{
   border-radius: 2px !important;
   max-height: 100% !important;
   border-color: #d2d6de !important;
   height: 32px;
   max-width: 100%;
   min-width: 100% !important;
   }
 </style>
  <div class="content-wrapper">
    <section class="content-header"><h2>Manage Followup</h2></section>
      <!-- general form elements -->
        <section class="container-fluid">
          <br>
            <form class="form-inline" method="post" action="{{ url('followup') }}">
              <div class="box">
                <div class="box-header with-border">
                </div>
                  <div class="box-body">
                    {{ csrf_field() }}
                    <div class="row"> 
                      <div class="form-group col-md-3">
                        <div class="input-group date" id="startdate">
                          <label>Followup Date From</label>
                            <input type="date" onkeypress="return false" class="form-control " name="fdate" placeholder="From Date" @isset($query['fdate']) value="{{$query['fdate']}}"@endisset  />
                        </div>
                      </div>

                      <div class="form-group  col-md-3">
                        <div class="input-group date" id="startdate">
                          <label>Followup Date To</label>
                            <input type="date" onkeypress="return false" class="form-control" name="tdate" placeholder="To Date" @isset($query['tdate']) value="{{$query['tdate']}}"@endisset />
                        </div>
                      </div>

                      <div class="form-group col-md-3">
                        <div class="input-group date" id="startdate">
                          <label>Reminder Date From</label>
                            <input type="date" onkeypress="return false" class="form-control " name="fromremider" placeholder="From Date" @isset($query['fromremider']) value="{{$query['fromremider']}}"@endisset  />                  
                        </div>
                      </div>

                      <div class="form-group  col-md-3">
                        <div class="input-group date" id="startdate">
                          <label>Reminder Date To</label>
                            <input type="date" onkeypress="return false" class="form-control" name="toreminder" placeholder="To Date" @isset($query['toreminder']) value="{{$query['toreminder']}}"@endisset />
                        </div>
                      </div>
                    </div>
                    <div class="row"> 
                    <div class="form-group col-sm-3">
                    <br>
                    <div class="input-group">
                      <label>User Name</label>
                      <select  name="username" width="100%" class="form-control select2" title="Select Username" data-live-search="true" id="username">
                        <!-- <option value="" selected disabled>Select First Name</option> -->
                        <option value="">Select Username</option>
                        @foreach($users as $user)
                          <option value="{{ $user->inquiriesid }}"@if(isset($query['username'])) {{$query['username'] == $user->inquiriesid ? 'selected':''}} @endif>{{ $user->firstname }}  {{ $user->lastname }}</option>
                        @endforeach
                      </select>
                    </div>
                   </div>
                   <div class="form-group col-sm-2">
                    <br>
                    <div class="input-group">
                    <label>Status</label>
                    <select class="form-control select2"  width="100%"  name="status">
                          <option value="" selected="">Please select status</option>
                          <option value="0" @if(isset($query['status'])) {{$query['status'] == 0 ? 'selected':''}} @endif>Close Inquiry</option>
                          <option value="1"@if(isset($query['status'])) {{$query['status'] == 1 ? 'selected':''}}@endif>Active</option>
                          <option value="2" @if(isset($query['status'])){{$query['status'] == 2 ? 'selected':''}}@endif>Confirmed</option>
                          <option value="3"@if(isset($query['status'])) {{$query['status'] == 3 ? 'selected':''}}@endif>Converted Inquiry</option>
                        </select>
                    </div>
                   </div>
                   <div class="form-group col-md-3" style="margin-top:1%;">
                     <div class="input-group">
                      <label>Keyword</label>
                        <input type="text" name="keyword" class="form-control" value="{{ isset($query['keyword']) ? $query['keyword'] : '' }}"placeholder="Keyword">
                      </div>
                    </div>
                    <div class="form-group col-md-3" style="margin-top:2.4%;">
                      <button name="submit" type="submit" class="btn bg-green margin">Search</button>
                       <a href="{{ url('followup') }}" class="btn bg-red margin">Clear</a>
                    </div>
                  </div>
                </div>
              </div>
            </form>
      @if ($message = Session::get('message'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
      </div>
      @endif 
 <div class="table-wrapper">
    <div class="table-title">

      <div class="row">
        <div class="col-xs-12">
          

          <div class="box container-fluid">
            <div class="box-header">
  </div>

    <div class="box-body">
  
       <table id="allfollowup3" class="table table-bordered table-striped">
          <thead>
              <tr>
              <th style="display:none;">id</th>
               <th>Date</th>
                <th>
                Reminder</th>
               
                <th>Name</th>
                <th>Gender</th>
                <th>Inquiry Rating</th>
                <th>Cell No.</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>@foreach($followups as $followup)
              <tr>
              <td style="display:none;">{{$followup->followupcalldetailsid}}</td>
                 <td> {{date('d-m-Y', strtotime($followup->calldate)) }}</td>
                @if($followup->schedulenextcalldate != NULL && $followup->schedulenextcalldate != '1970-01-01')  
                <td>{{date('d-m-Y', strtotime($followup->schedulenextcalldate)) }}</td>
               
                @else
                <td>{{ '-' }}</td>
                
                @endif
           
                <td> {{ ucwords($followup->firstname) }} {{ ucwords($followup->lastname) }}</td>
                <td> {{ $followup->gender }}</td>
                <td> {{ $followup->rating }}</td>
                <td> {{ $followup->mobileno }}</td>
                 <td> {{ $followup->istatus == 3 ? 'Converted' : ($followup->istatus == 2 ? 'Confirmed' : ($followup->istatus == 0 ? 'Closed' : 'Active')) }}</td>

                 <td>   @if(isset($permission["'view_inquiry'"]))
                           <a href="{{url('viewfollowupprofile/'.$followup->inquiriesid)}}"class="Add" title="View Inquiry Profile" ><i class="fa fa-eye"></i></a>
                           @endif
                         
                           <a href="{{ url('viewfollowup/'.$followup->inquiriesid) }}"class="call"  title="Add Followup" onclick="call()"><i class="fa fa-phone"></i></a>
                     </td>     
                <!-- <td><a href="{{ url('editfollowupmodel/'.$followup->followupid) }}"class="edit" title="Edit"><i class="fa fa-eye"></i></a> -->
                 <!--  <a href="{{ url('deleteterm/'.$followup->id) }}"class="delete" title="Delete"><i class="fa fa-trash"></i></a> -->
              </td>
              </tr>
              @endforeach
              </tbody>
            
              </table>
                 <div class="datarender" style="text-align: center">
            {!! $followups->appends($query)->links() !!}  </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   
  </div>
</div>
    </section>
  </div>

<!-- page script -->
<script>
  $(function () {
    $('#allfollowup3').DataTable({
     "order": [[ 1, "Desc" ]],
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
<script type="text/javascript">
 $(document).ready( function () {
   
    $('.select2').select2();
//   $('#allfollowup').DataTable({
//    "order": [[ 0, "Desc" ]], //or asc 
//       stateSave: true,
//       "columnDefs": [
//                {"targets": "_all", "type": "date-eu"},
//                {"targets": "_all", "sortable": true}
//             ]
// });
});
</script>

@endsection