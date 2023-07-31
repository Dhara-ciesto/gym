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
 
  
</style>

  <div class="content-wrapper">
<!--     <section class="content-header"><h2>All Workout</h2></section>
 --><div class="container-fluid"> 
  @if ($message = Session::get('message'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
   <strong>{{ $message }}</strong>
</div>
@endif 

   <div class="table-wrapper">
    <div class="table-title">

   <div class="box-header">
       
    </div>
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
                <a href="{{ url('addExercise') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i>Add New</a>
               <h3 class="box-title">View Workout</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body" style="overflow: scroll;">
              <table id="exercisedata" class="table table-bordered table-striped">
                 <thead>
                <tr>
                  <th>Exercise</th>
                  <th>Video File</th>
                  <th>Action</th>
                         
                </tr>
                </thead>
                <tbody>
               @foreach($exercisedata as $exercise)
                <tr>
                    <td> {{ $exercise->exercisename }}</td>
                    <td> {{ $exercise->videoname}}</td>
                   
                  <td><a href="{{ url('editExercise/'.$exercise->exerciseid) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>              
                </tr>
                 @endforeach
                </tbody>
            
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

<!-- page script -->
</div>
</div>
</div>
</div>
@endsection
@push('script')
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<script>
  $(function () {
    $('#exercisedata').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script type="text/javascript">
  $('#exercisedata').DataTable({
       stateSave: false,
       paging:  true,
       "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
   });
</script>
@endpush


 