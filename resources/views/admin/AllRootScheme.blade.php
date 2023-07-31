@extends('layouts.adminLayout.admin_design')
@push('css')




@endpush
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
   
     
<!--          <section class="content-header"><h2>All Root Scheme</h2></section>
 -->          <!-- general form elements -->
           <section class="content">
 

 
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
      <?php $permission = unserialize(session()->get('permission')); ?>
    @if(isset($permission["'add_root_scheme'"]))
      <a href="{{ url('addrootscheme') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i>Add New</a>
      @endif

    <h3 class="box-title">View Root Scheme</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     <!-- <div class="col-lg-3"></div> -->
    <div class="row">
      <div class="col-md-12">
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
              <tr>
                <th>Scheme Name</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>@foreach($rootschemes as $scheme)
              <tr>
                <td> {{ $scheme->rootschemename }}</td>
                <td> {{ $scheme->description }}</td>
                
              <td>
                @if(isset($permission["'edit_root_scheme'"]))
                <a href="{{ url('editrootscheme/'.$scheme->rootschemeid) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>
                @endif
                 <!--  <a href="{{ url('deleterootscheme/'.$scheme->id) }}"class="delete" title="Delete"><i class="fa fa-trash"></i></a> -->
              </td>
              </tr>

              @endforeach
              </tbody>
            </table>
      </div>
    </div>
    <!-- <div class="col-lg-12 col-md-12">
      <div class="row"><div class="col-md-12">
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
              <tr>
                <th>Scheme Name</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>@foreach($rootschemes as $scheme)
              <tr>
                <td> {{ $scheme->rootschemename }}</td>
                <td> {{ $scheme->description }}</td>
                
              <td><a href="{{ url('editrootscheme/'.$scheme->rootschemeid) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>
                 <!--  <a href="{{ url('deleterootscheme/'.$scheme->id) }}"class="delete" title="Delete"><i class="fa fa-trash"></i></a> -->
              <!-- </td>
              </tr>

              @endforeach
              </tbody>
            </table></div> -->
<!-- /.box-body -->
</div>
</div>
</div>
</div>


</div>
</div>
</div>
</section>
</div></div>
@endsection
@push('script')

<script type="text/javascript">
  $(document).ready(function(){
    $('#example1').DataTable();
  });
</script>
@endpush