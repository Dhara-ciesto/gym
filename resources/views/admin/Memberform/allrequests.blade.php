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
<!--      	 <h1 style="text-decoration: none;">View Member Form</h1>
 -->     </section>
      <section class="content">
      <!-- Info boxes -->
     	 <div class="row">
     	 	<div class="col-md-12">
     	 		<div class="row">
   
     	 			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Received Forms</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                  <tr>
                    <td>Date</td>
                  	<th>Member</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Response</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($memberdata as $data)
                    <tr>
                      <td>{{ date('d-m-Y',strtotime($data->createddate))}}</td>
                      <td>{{$data->firstname}} {{$data->lastname}}</td>
                      <td>{{$data->username}}</td>
                      <td>{{$data->mobileno}}</td>
                      
                      <td @if($data->answer==1) style="color:green;" @elseif($data->answer==3)style="color:red;"  @else style="color:blue;" @endif>@if($data->answer==1){{'Accepted'}} @elseif($data->answer==3){{'Rejected'}} @else {{'Pending'}} @endif</td>
                      <td><a  onclick="return myFunction();" href="{{url('addMember/'.$data->memberid)}}"><i class="fa fa-check"></i></a>
                      <a class="delete"  onclick="return myFunction1();" href="{{url('rejectrequest/'.$data->memberid)}}"><i class="fa fa-times"></i></a></td>
                    </tr>
                    @endforeach
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
<script>
function changestatus($id)
{
        var id=$id;
        // alert(beltno);
        var _token = $('input[name="_token"]').val();
        $.ajax({
                  url:"{{ url('changeMemberStatus') }}",
                  method:"POST",
                  data:{id:id, _token:_token},
                  success:function(result)
                  {
                    var data=result;
                    if(data){
                      // alert(data);
                     
                    }
                  },
                   dataType:"json"
                 })

}
</script>
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


  function myFunction() {
      if(!confirm("Are You Sure to Confirm Member Form ?"))
      event.preventDefault();
  }


  function myFunction1() {
      if(!confirm("Are You Sure to Cancle Member Form ?"))
      event.preventDefault();
  }


	$("#mode").select2({
    placeholder: "Select a Mode"
});
</script>

<script>
  $(function () {
    $('#example1').DataTable({
      lengthmenu:false,
      order: [[0, 'desc']],
    })
  });

</script>
@endsection