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
   
     
<!--          <section class="content-header"><h2>All Active Role</h2></section>
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
      <a href="{{ url('addrole') }}" class="bowercomponentscustomedarkbluebtn btn add-new bg-orange" style="height: 35px;"><i class="fa fa-plus"></i> Add New</a>

    <h3 class="box-title">View Roles</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body"><div class="col-lg-12">
      <div class="row">
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
             <tr>
                <th>Name</th>
                <th>Description</th>
                <!-- <th>Extra</th> -->
                <th>Actions</th>
                <th>Deactive  Role</th>
              </tr>
              </thead>
              <tbody>@foreach($roles as $role)
              <tr>
                <td> {{ucwords( $role->employeerole )}}</td>
                <td> {{ $role->description }}</td>
               <!--  <td>information</td> -->
              <td><a href="{{ url('editrole/'.$role->roleid) }}" class="edit" title="Edit"><i class="fa fa-edit"></i></a>

              <!--    <td>   <a href="" class="" id="deactiveuserq" data-toggle="modal" data-target="#deactiveuser" onclick="deactiveuser('{{$role->roleid}}')"  title="Deactive Role"><span class="label label-warning" >Deactive</a></span> </td> -->
                 <td> <a href="{{url('deactiverole/'.$role->roleid)}}" onclick="return myFunction();" class="btn bg-light-navy" > <span class="label label-danger" >Deactive</a></span> </td>
                  <!-- <a href="{{ url('deleterole/'.$role->id) }}"class="delete" title="Delete"><i class="fa fa-trash"></i></a> -->
              </td>
              </tr>
              
              @endforeach
            </tbody></div>
            </table>
<!-- /.box-body -->

    <div class="modal fade" id="deactiveuser">
              <div class="modal-dialog">
                 <div class="modal-content">
                    <div class="modal-header">
                       <button type="button" class="close close1"  data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title"><b>Deactive Role</b></h4>
                    </div>
                    <div class="modal-body">
                       <h4>Are You Sure To Deactive Role!</h4>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-danger close1"  data-dismiss="modal">No</button>
                       <a  id="deactiveusersave" data-dismiss="modal" class="btn bg-green">Yes</a>
                    </div>
                 </div>
                 <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->                        
           </div>
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
<script type="text/javascript">

  function myFunction() {
      if(!confirm("Are You Sure to Deactive Role ?"))
      event.preventDefault();
  }
</script>
<script>
  $(function () {
    $('#example1').DataTable()
  });

</script>
@endpush