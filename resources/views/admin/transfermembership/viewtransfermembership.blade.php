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
<style type="text/css">
	.content-wrapper{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
td{
	max-width: 20%;
}
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
<!--      	 <h1 style="text-decoration: none;">Transfered Membership Report</h1>
 -->     </section>
      <section class="content">
         @if ($errors->any())
            <div class="alert alert-danger">
             <button type="button" class="close" data-dismiss="alert">×</button> 
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif 
             @if(session('success'))
  
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
   <strong>{{session('success')}}</strong>
</div>
@endif 
      <!-- Info boxes -->
     	 <div class="row">
     	 	<div class="col-md-12">
     	 		<div class="row">
     	 <!-- 			<div class="box box-info">
     	 				 <div class="box-header with-border">
			              <h3 class="box-title">Filters</h3>

			              <div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                </button>
			                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			              </div>
			            </div>-->
			            <!-- /.box-header -->
			           <!--   <div class="box-body">
			            	<form action="{{url('paymentreport')}}" method="post">
			            		{{csrf_field()}}
							<div class="table-responsive">
							  <table class="table no-margin">
							  <thead>
							  <tr>
							    <th>From :</th>
							    <th>To :</th>
							    <th>Mode</th>
							    <th>Username</th>
							 	<th>Amount</th>
							    
							  </tr>
							</thead>
							<tbody>
					
							<tr>
							<td><input type="date" name="fdate" class="form-control" value=""></td>
							<td><input type="date" name="tdate" class="form-control" value=""></td>
							<td><select name="mode" class="form-control select2" id="mode" data-placeholder="Select a Mode" >
								<option value="" selected="" disabled="">Select a Mode</option>
							</select></td>
							<td><select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
								<option value="" selected="" disabled="">Select a Username</option>
								</select></td>
									<td><input type="text" name="amount" class="form-control"value=""></td>
							
							
							</tr>
							<tr>
								
								<td><input type="text" name="keyword" placeholder="Search Keyword" class="form-control" value=""></td>
								<td style="text-align: left" colspan="4"><button type="submit" name="search" class="btn bg-orange"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('paymentreport') }}" class="btn bg-red">Clear</a></td>
								
							</tr>
							

							</tbody>
							</table>

							</div>
						</form>
			            </div>	
     	 			</div> -->
     	 			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Transfered Membership</h3>

              <div class="box-tools pull-right">
 <div class="" style="float: right;"><a href="{{ url('addtransfermembership') }}" class="btn btn-primary bg-orange" title="Transfer Membership"><i class="fa fa-plus"></i> Transfer Membership</a></div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin" id="viewtransferdata">
                  <thead>
                  <tr>
                  	<th>Date</th>
                    <th> From Name</th>
                    <th> To Name</th>
                    <th>Schemename</th>
                    <th>joinDate </th>
                    <th>Enddate</th>
                    <th>TransferBy</th>
                   
                  </tr>
                  </thead>
                  <tbody>
     					      @if(count($trans)>0)
                    @foreach($trans as $tran)
                    <tr> 
                      <td>{{date('d-m-Y', strtotime($tran->transfer_on)) }}</td>
                      <td> {{ ucwords($tran->fromfirstname) }} {{ ucwords($tran->fromlastname)}}</td>
                      <td> {{ ucwords($tran->tofirstname) }} {{ ucwords($tran->tolastname)}}</td>
                      <td>{{$tran->schemename}}</td>
                      <td>{{date('d-m-Y', strtotime($tran->transfer->joindate))}}</td>
                  
                      <td>{{date('d-m-Y', strtotime($tran->transfer->expiredate))}}</td>
                      <td>{{$tran->first_name}} {{$tran->last_name}}</td>
                    
                    </tr>
                  	
                    @endforeach
                    @endif
                  </tbody>
                </table>
                    <div class="datarender" style="text-align: center">
            </div>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        <!--     <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
          </div>
     	 		</div>
     	 	</div>

      	 </div>
 	  </section>
</div>
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
<script type="text/javascript">


$(function () {
    $('#viewtransferdata').DataTable()
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
@endsection