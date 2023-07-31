@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
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
   <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
<!--   <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
 -->  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

<!-- <script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
 -->
<style type="text/css">

</style>

  <div class="content-wrapper">
<!-- <section class="content-header"><h2>All Scheme</h2></section>
 - --><div class="container-fluid">
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
          <div class="box box-info">
                 <div class="box-header with-border">
                    <h3 class="box-title">Filters</h3>
                    <div class="box-tools pull-right">
                       <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                       </button>
                       <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                 </div>
                 <!-- /.box-header -->
                 <div class="box-body">
                       <div class="box-body">


                        <form method="post" class="form-inline" id="gstform" action="{{ url('schemes') }}">
                                           {{csrf_field()}}
         <div class="table-responsive">
                <table class="table no-margin">
                <thead>
              <tr>
                  <th>Select Root Scheme</th>
                  <th>Select Status</th>

                  <th></th>
                  <th></th>


                </tr>
              </thead>
              <tbody>

              <tr>

              <td>
               <select name="rootschemename"  class="form-control select2 span8" data-placeholder="Select a Root Scheme" >
                                         <option value="" selected="" disabled="">Select a Root Scheme</option>
                                         @foreach($rootschemes as $user)
                                         <option value="{{$user->rootschemeid}}"  @if(isset($query['rootschemename'])) {{$query['rootschemename'] == $user->rootschemeid ? 'selected':''}} @endif>
                                         {{ $user->rootschemename }}
                                         </option>
                                         @endforeach
                                      </select>
              </td>

              <td>
                                        <select name="status" class="form-control select2 span8" data-placeholder="Select Status" >
                                         <option value="" selected="" disabled="">Select Status</option>
                                        <option value="1" {{ $query['status'] == '1' ? 'selected' : ''}}>Active</option>
                                             <option value="0" {{ $query['status'] == '0' ? 'selected' : ''}}>Deactive</option>
                                      </select>

                </td>


                    <td>
<button type="submit" id="submitbutton" name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button>
    <a  href="{{ url('schemes') }}" class="btn bg-red">Clear</a>
</td>

                <td></td>

              </tr>


              </tbody>
              </table>

              </div>


                                </form>

                                      {{csrf_field()}}

                 </div>
              </div>

          <div class="box">
            <div class="box-header">
              <?php $permission = unserialize(session()->get('permission')); ?>
                @if(isset($permission["'add_scheme'"]))

                <a href="{{ url('addscheme') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i>Add New</a>
                @endif
               <h3 class="box-title">View Schemes</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1"  class="table no-margin">
                <thead>
                <tr>
                <th>RootScheme</th>
                <th>Scheme</th>
                <th>Number Of Days</th>
                <th>Base Price</th>

                <!-- <th>Tax</th> -->
                <th>Actual Price</th>
                 <th>Validity</th>
<!--                 <th>Status</th>
 -->                <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                 @foreach($schemes as $scheme)
                <tr>
                <td> {{ $scheme->RootScheme->rootschemename }}</td>
                <td> {{ $scheme->schemename }}</td>
                <td> {{ $scheme->numberofdays }}</td>
                <td> {{ $scheme->baseprice }}</td>
                <!-- <td> {{ $scheme->Tax }}</td> -->
                <td> {{ $scheme->actualprice }}</td>
                @if($scheme->validity)
                <td><span class='hide'>{{$scheme->validity}}</span>{{date('d-m-Y', strtotime($scheme->validity))}}</td>
                @else
                <td></td>
                @endif
              <!--   <td>
                  {{ $scheme->status == '1' ? 'active' : 'Deactive' }} </td>
                  <td> -->
                    @if(isset($permission["'edit_scheme'"]))
                 <td>   <a href="{{ url('editscheme/'.$scheme->schemeid) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a></td>
                    @endif
                </tr>
                 @endforeach
                </tbody>

              </table>
                <div class="datarender" style="text-align: center">
          {!! $schemes->render() !!}  </div>
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
@push('script')
<!-- <script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script> -->
<script type="text/javascript">
  $('#submitbutton').click(function(e){
  e.preventDefault();
  $('#excel').val(0);
  $('#gstform').submit();

});

</script>
<script type="text/javascript">


  $(document).ready(function(){

    $('.select2').select2()


    $('#example1').DataTable();
  });
</script>
@endpush
@endsection
