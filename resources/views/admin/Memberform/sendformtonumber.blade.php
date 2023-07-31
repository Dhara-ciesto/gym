@extends('layouts.adminLayout.admin_design')
@section('content')
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
<!--      	 <h1 style="text-decoration: none;">Send Member Form</h1>
 -->     </section>
      <section class="content">

         
@if(session()->has('success'))
    <div class="alert alert-success">
        {{session('success') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
         </button>
    </div>

@endif
<!-- Info boxes -->
<div class="row">
  <div class="col-md-12">
     <div class="row">
        <div class="box box-info">
           <div class="box-header with-border">
              <h3 class="box-title">Send Member Form</h3>
              <div class="box-tools pull-right">
                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                 </button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
           </div>
           <!-- /.box-header -->
           <div class="box-body">
              <div class="col-lg-3"></div>
              <div class="col-lg-6">
                 <form action="{{ url('sendmemberform') }}" method="POST">
                    @csrf
                    <div class="form-group">
                       <label>First Name</label>
                       <input type="text" name="firstname" class="form-control" id="firstname" autocomplete="off" placeholder="First Name" required="">
                    </div>
                    <div class="form-group">
                       <label>Last Name</label>
                       <input type="text" name="lastname" class="form-control" id="lastname" autocomplete="off"  placeholder="Last Name" required="">
                    </div>
                    <div class="form-group">
                       <label>Mobile No</label>
                       <input type="text" name="mobileno" class="form-control" id="mobileno" autocomplete="off"  placeholder="Mobile No" maxlength="10" required="">
                    </div>
                    <center>
                       <div class="form-group">
                          <button type="submit" class="btn btn-success" id="send">Send</button>
                       </div>
                    </center>
                 </form>
              </div>
              <div class="col-lg-3"></div>
           </div>
        </div>
     </div>
  </div>
</div>
</section>
</div>
<script type="text/javascript">
	
// 	$("#send").on('click', function(){
// 		var code='dfd';
// 		var id=$('#mobileno').val();
//     var route='sendmemberform/'+id+'/'+code+'';
//     $.ajax({
//           type : 'POST', 
//           url :  route ,
//           data : {code:code,id:id,_token:'{{ csrf_token() }}'},
//           success : function(data){
           
//           }
//         });
// 		// alert(id);
// 		// location.href = '/sendmemberform/'+id+'/'+code+'';
//      // window.location = "sendmemberform/"+id+"/"+code"";    
// });
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
	$("#mode").select2({
    placeholder: "Select a Mode"
});
</script>
@endsection