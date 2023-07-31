@extends('layouts.adminLayout.admin_design')
@section('content')
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
      <div class="row">
         @if ($message = Session::get('message'))

        @if($message=="Succesfully Registerd")
                    <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
            @else
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
       @endif

        @endif
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
            <?php $permission = unserialize(session()->get('permission')); ?>
               @if(isset($permission["'add_registration'"]))
                <a href="{{ url('registration#tologin') }}" class="pull-right  bowercomponentscustomedarkbluebtn  add-new bg-orange" style="width: 165px;"><i class="fa fa-plus"></i>&nbsp;<b>New Registration</b></a>
                @endif
                <h3 class="box-title">View Registration</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="timeline">
                    @foreach ($registrations as $reg)
                        
                    
                    <!-- timeline time label -->
                    <li class="time-label">
                        <span class="bg-red">
                          {{date("d-m-Y"),strtotime($reg->created_at)}} 
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                
                    <!-- timeline item -->
                    <li>
                        <!-- timeline icon -->
                        <i class="fa fa-pencil bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{date("H:i a",strtotime($reg->rdate))}}</span>
                
                            <h3 class="timeline-header"><a href="" >@if($reg->starting_date) {{date("d-m-Y",strtotime($reg->starting_date))}} @endif</a> ...</h3>
                
                            <div class="timeline-body">
                              <div class="col-sm-12 col-md-12 "> 
                                <ul class="ml-2 mt-2">
                              <li style="font-size: 120%;"> Name :  {{ $reg->firstname.' '.$reg->lastname }} </li>
                              <li style="font-size: 120%;"> Mobile No :  {{ $reg->phone_no}} </li>
                              <li style="font-size: 120%;"> Start Date : {{date("d-m-Y"),strtotime($reg->starting_date)}} </li>
                              <li style="font-size: 120%;"> No of Days :  {{ $reg->credit_validity_day}} </li>
                              <li style="font-size: 120%;"> Start Date : {{date("H:i: a"),strtotime($reg->timing)}} </li>
                              <li style="font-size: 120%;"> Trainer :  {{ $reg->therapist_id}} </li>   
                              <li style="font-size: 120%;"> Package :  {{ $reg->schemename}} </li>
                              <li style="font-size: 120%;"> Status :   @if($reg->rstatus == 1)  Active  @elseif($reg->is_member == 1) Convert to Member @else Deactive  @endif </li>
                                </ul>
                              </div>
                            </div>
                
                            <div class="timeline-footer">
                                &nbsp;
                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    @endforeach
                
                </ul>
            </div>
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

 
<!-- ./wrapper -->
<!-- SlimScroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<!-- AdminLTE for demo purposes -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });

  $('#example1').DataTable({
       stateSave: false,
        paging:  true,
         "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
   });

</script>

@endsection

