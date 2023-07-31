@extends('layouts.adminLayout.admin_designApp')
@section('content')
<style type="text/css">
	.content-wrapper{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
td{
	max-width: 10%;
   word-break: break-all  !important;

}
table td{
  width: 10% !important;
  max-width: 10% !important;
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
    <section class="content-header">
     	 <h1 style="text-decoration: none;">All Trainers</h1>
     </section>
     <!-- content start -->
      <section class="content">
     	 <div class="row">
     	 	<div class="col-md-12">
     	 		<div class="row">
            <!-- box start -->
     	 			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            {{-- get mobilenumber from url and store it to session [letter on -> fetch this number in view tainer profile] --}}
            @php
            session(['mobileno' => request()->route("id")]);
            @endphp
            

            <!-- for all trainer -->
            <div class="box-body">
              <div class="table-responsive" style="word-wrap: break-word;">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>View</th>
                  	<th>Employee</th>
                    <th>Level Of Trainer</th>
                    <th>City</th>
                    <th>Experience</th>
                    <th>Achievments</th>
                    {{-- <th>Photo</th>
                    <th>Results</th> --}}
                  </tr>
                  </thead>
                  @if(Session('role')== 'trainer')
                    <tbody>
                      @foreach($data as $data1)
                       @if($data1->employeeid == Session('employeeid'))
                       <tr>
                        <td><a href="{{url('viewtrainerprofileApp/'.$data1->trainerprofileid)}}"><i class="fa fa-eye"></i></td>
                          <td>{{ucwords($data1->first_name)}} {{ucwords($data1->last_name)}}</td>
                          <td>{{$data1->leveloftrainer}}</td>
                          <td>{{$data1->city}}</td>
                          <td>{{$data1->exp }} </td>
                          <td>{{$data1->achievments }}</td>
                          {{-- <td>{{$data1->photo }}</td>
                          <td  style="width: 10px !important ;">{{$data1->results}}</td>  --}}
                       </tr>
                       @endif
       		           @endforeach
                    </tbody>
                  @else
                    <tbody>
                      @foreach($data as $data1)  
                       <tr>
                        <td><a href="{{url('viewtrainerprofileApp/'.$data1->trainerprofileid)}}"><i class="fa fa-eye"></i></td>
                          <td>{{ucwords($data1->first_name)}} {{ucwords($data1->last_name)}}</td>
                          <td>{{$data1->leveloftrainer}}</td>
                          <td>{{$data1->city}}</td>
                          <td>{{$data1->exp }} </td>
                          <td>{{$data1->achievments }}</td>
                          {{-- <td>{{$data1->photo }}</td>
                          <td  style="width: 10px !important ;">{{$data1->results}}</td>  --}}
                       </tr>
                     @endforeach
                    </tbody>
                  @endif
                </table>
                  <div class="datarender" style="text-align: center">
                         {{ $data->links() }}    
                  </div>
                </div>
            </div>
          </div>
          <!-- box End -->
        </div>
      </div>
    </div>
  </section>
  <!-- content end -->
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
	$("#mode").select2({
    placeholder: "Select a Mode"
});
</script>
@endsection