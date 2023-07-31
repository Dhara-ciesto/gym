@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

<link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>

<style type="text/css">
.content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
}.select2{
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
<!--         <h1 style="text-decoration: none;">Session Report</h1>
 -->     </section>
      <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Session Report</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
            </div>
            <div class="box-body">                                            
                        <form method="post" class="form-inline" id="gstform" action="{{ url('sessionreportadmin') }}">
                                           {{csrf_field()}}
         <div class="table-responsive">
                <table class="table no-margin">
                <thead>
              <tr>
                  <th>Username :</th>
                
                  <th></th>
                  <th></th>

                  
                </tr>
              </thead>
              <tbody>
          
              <tr>

              <td>     
   <select  name="username" class="form-control select2 " width="100%" data-placeholder="Select a Username"  id="username" >
      <option value="" selected disabled>Select User Name</option>
    
      @foreach($users as $user)


        <option value="{{ $user->userid }}" @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>{{$user->firstname}}  {{$user->lastname}}</option>

      @endforeach
    </select>
              </td>
          
           <td>     
   <select  name="mobileno" class="form-control select2 " width="100%" data-placeholder="Select a Mobileno"  id="mobileno" >
      <option value="" selected disabled>Select Mobileno</option>
    
      @foreach($users as $user)


        <option value="{{ $user->userid }}" @if(isset($query['mobileno'])) {{$query['mobileno'] == $user->userid ? 'selected':''}} @endif>{{$user->mobileno}} </option>

      @endforeach
    </select>
              </td>
          


                    <td>
<button type="submit" id="submitbutton" name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button>         
    <a  href="{{ url('sessionreportadmin') }}" class="btn bg-red">Clear</a>
</td>
                
                <td></td>
              
              </tr>
           

              </tbody>
              </table>

              </div>


                                </form>
            <div class="table-responsive">
                <table id="membersession"  class="table table-bordered table-striped" width="100%" >
            <thead>
                <tr>
         
                <th>Member Name</th>
                                <th>Mobile No</th>

                <th>Scheme Name</th>
                <th>Active/Pending Session</th>
                <th>Deducted Session</th>
                </tr>
            </thead>
            <tbody>
            @if(count($trainersession2)>0)
            <tr>

                @foreach($trainersession2 as $trainersession1)
                <td>{{$trainersession1->firstname}}  {{$trainersession1->lastname}}</td>
                                <td>{{$trainersession1->mobileno}}</td>  

                <td>{{$trainersession1->schemenameprint}}</td>
                <td>{{$trainersession1->activecount}}</td>  
                <td>{{$trainersession1->deductedcount}}</td>
            </tr>
            @endforeach
            @endif
            </tbody>
            </table>
            <div class="datarender" style="text-align: center">
            </div>
        
            </div>
            </div>
        </div>
        </div>
  </div>
      </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
$('#membersession').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : true,
    'ordering'    : true,
    'info'        : false,
    'autoWidth'   : false
  });
</script>
<script type="text/javascript">
    $('#submitbutton').click(function(e){
  e.preventDefault();
  $('#gstform').submit();

});
</script>

<script type="text/javascript">
    
     $(function(){
    $('.select2').select2()

     });
</script>
@endpush