@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">

</style>
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

<!-- left column -->
<style type="text/css">

</style>
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>View Measurement</h2></section>
          <!-- general form elements -->
           <section class="content">
          @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
             @if ($message = Session::get('message'))
    @if($message=="Succesfully Added")
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
    @if($message=="Succesfully Edited")
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
    @endif

<script type="text/javascript">
  $(document).ready (function(){
                $("#danger-alert").fadeTo(5000, 500).slideUp(500, function(){
               $("#danger-alert").slideUp(1000);
                });   
 });
</script>
@if(isset($_POST['selectusername']))
@php    $mid=$_POST['selectusername'];  @endphp   
@else   
@php    $mid=0;  @endphp    
@endif
@if(isset($_POST['from']))
@php    $from=$_POST['from'];  @endphp   
@else   
@php    $from='';  @endphp    
@endif
@if(isset($_POST['to']))
@php    $to=$_POST['to'];  @endphp   
@else   
@php    $to='';  @endphp    
@endif
 <form role="form" action="{{ url('viewMeasurement') }}" name="viewMeasurement" method="POST" id="package_form">
  {{ csrf_field() }}
<div class="box box-primary" id="secondstep" >

           <div class="box-header with-border">
              <h3 class="box-title">Select Member</h3>
            </div>

<!-- /.box-header -->
    <div class="box-body">  <h4><u></u></h4> 
      <div class="col-lg-2">
  
      <div class="form-group">
        <label>Username<span style="color: red">*</span></label>

       <select name="selectusername" id="username"  class="form-control select2"title="Select Username" data-placeholder="Select Username">

        <option selected value="" disabled="">Please Select</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}" {{ $user->memberid == $mid ? 'selected' : ''}}>{{ $user->username }}</option>@endforeach
        </select>
      </div>
 
      </div>

    <div class="col-lg-2">
      <div class="form-group">
        <label>Mobile No:</label>
        <select name="selectmobileno" id="mobileNo" class="form-control" disabled="" ><option selected >Please Select</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}"  {{ $user->memberid == $mid ? 'selected' : ''}} >{{ $user->mobileno }}</option>@endforeach
        </select>
      </div>
    </div>

   
       <div class="col-lg-3">
      <div class="input-group">
        <label>From Date</label>
        <input type="date" onkeypress="return false" name="from" class="form-control" value="{{ $from }}">
      </div>
<!-- /input-group -->
    </div>


      <div class="col-lg-3">
      <div class="input-group">
        <label>To Date</label>
        <input type="date" onkeypress="return false" name="to" class="form-control"  value="{{ $to }}">
      </div>
<!-- /input-group -->
    </div>


    <div class="col-lg-1" style="margin-top: 23px;">
      <div class="form-group">
       <button type="submit" id="next" class="btn bg-green">Search</button>
      </div>
    </div>
       <div class="col-lg-1" style="margin-top: 23px;">
      <div class="form-group">

        <a href="{{ url('viewMeasurement') }}" class="btn bg-red">Clear</a>
       <!-- <button type="submit" id="next" class="btn bg-orange">Clear</button> -->
      </div>
    </div>
    </div>
  </div>
</form>
  <div class="box box-primary" style="display: block;" id="viewMeasurement">
  <div class="box-header with-border"> <div class="" style="float: right;"><a href="{{ url('addMeasurement') }}" class="btn btn-primary bg-orange" title="Add Measurement"><i class="fa fa-plus"></i> Add Measurement</a></div></div>
    <div class="box-body" > 
     <div class="col-lg-12" style="overflow: auto;">
     <table id="measurement" class="table table-bordered table-striped" width="100%" >
                <thead>
                <tr>
                <th>Member</th>
                <th>Date</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Neck</th>
                <th>Left Upper Arm</th>
                <th>Right Upper Arm</th>
                <th>Chest</th>
                <th>Waist</th>
                <th>Hips</th>
                <th>Left Thigh</th>
                <th>Right Thigh</th>
                <th>Left Calf</th>
                <th>Right Calf</th>
                 <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($measurement as $mm)
          
                <tr>
                <td>{{ ucwords( $mm->firstname) }} {{ ucwords($mm->lastname) }}</td>
          <td> {{ date('d-m-Y', strtotime($mm->todaydate)) }}</td>
                <td> {{ $mm->weight }}</td>
                <td> {{ $mm->height }}</td>
                <td> {{ $mm->neck }}</td>
                <td> {{ $mm->leftupperarm }}</td>
                <td> {{ $mm->rightupperarm }}</td>
                <td> {{ $mm->chest }}</td>
                <td> {{ $mm->waist }}</td>
                <td> {{ $mm->hips }}</td>
                <td> {{ $mm->leftthigh }}</td>
                <td> {{ $mm->rightthigh }}</td>
                <td> {{ $mm->leftcalf }}</td>
                <td> {{ $mm->rightcalf }}</td>
                  <td>
                    <?php $permission = unserialize(session()->get('permission')); ?>
                    @if(isset($permission["'edit_measurement'"]))
                    <a href="{{ url('editMeasurement/'.$mm->measurementid) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>
                    @endif
                  </td>           
                </tr>
                 @endforeach
                </tbody>
            
              </table>
      </div>
    </div>

           
             
  

</div>

</section>
</div>

<script type="text/javascript">
 
    
      $('#measurement').DataTable({
         stateSave: false,
                paging:  true,
                "ordering" : true,
            "scrollCollapse" : true,
            "order": [[ 0, "desc" ]],
            // sorting:false,
            
            "columnDefs" : [{"targets":1, "type":"date-eu"}],
            "bInfo": true
   });
      
$(document).on('ready',function(){

  $('#username').trigger('change');
})

</script>
<script type="text/javascript">
  $('.numberflot').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});
</script>
<script type="text/javascript">
function clear_form_elements() {

  $('#addmeasurment').find(':input').each(function() {

    switch(this.type) {
        case 'password':
        case 'text':
        case 'textarea':
        case 'file':
        
        case 'select-multiple':
        case 'number':
        case 'tel':
        case 'email':

            jQuery(this).val('');
            break;
        case 'checkbox':
        case 'radio':
       
            this.selected =false;
            this.checked = false;
        $(this).closest('tr').find('[type=text]').attr("disabled", "disabled");
        // $('#scheme').find('option:not(:first)').remove();
        
            break;
    }
  });
  // $('#RecieptNo').val(s);
}
</script>
<script type="text/javascript">
  $('#next').on('click',function(){

         $('#viewMeasurement').css('display','block');
  
  });
</script>
<script type="text/javascript">
   $('#username').on('change',function(){
    // clear_form_elements();
    // alert('sdfs');



    var username = $('#username').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
       $('select[name=selectmobileno]').val(data.memberid);
      // $('#mobileNo').val();
      },
       dataType:"json"
     });
   });
</script>
<script type="text/javascript">
   $('#mobileNo').on('change',function(){
    var user = $('#mobileNo').val();
    var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:user, _token:_token},
      success:function(result)
      {
      var data=result;

      // $('#username').attr("value",data.username).val(data.username);
     $("#username").val(data.userid);
      },
       dataType:"json"
     });
   });
// </script>


@endsection
@push('script')
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
@endpush