@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }

</style>
<style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 15px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #3a3938;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
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
/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
  top: 7.2px;
  left: 7.3px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}

</style>
@endpush
@section('content')
<!-- left column -->
<style type="text/css">

</style>
  <div class="content-wrapper">
   
              <section class="content-header"><h2>Add Measurement</h2></section>
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
    @if($message=="Succesfully added")
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
 <form role="form" action="{{ url('addMeasurement') }}" name="addmeasurment" method="POST" id="package_form">
  {{ csrf_field() }}
<div class="box box-primary" id="secondstep" >

           <div class="box-header with-border">
              <h3 class="box-title">Select Member</h3>
            </div>
                @if(request()->route('id'))
                @php 
                $i=request()->route('id');
                @endphp
                @else
                 @php 
                 $i='';
                @endphp
                @endif

<!-- /.box-header -->
<br>
 <div class="box-body">
    <div class="col-lg-4">
      <label class="container">Search By Username
  <input type="radio" name="rbnNumber" class="btnGetValue" value="1" checked="">
  <span class="checkmark"></span>
</label>
     <!-- <input type="radio" name="rbnNumber" class="btnGetValue" value="1" /> Search By Username -->
     </div>
     <div class="col-lg-4">
          <label class="container">Search By Mobileno
  <input type="radio" name="rbnNumber" class="btnGetValue" value="2">
  <span class="checkmark"></span>
</label>


     </div>
   </div>
      <!-- /**********************start serachbyusername **********************/ --> 
    <div class="box-body" id="serachbyusername" style="display: none; margin-top: -20px;">  
 
      <div class="col-lg-4">

        <!-- <label>Username<span style="color: red">*</span></label> -->

       <select  name="selectusername" id="username1" class="form-control span11 select2"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Member" required="">
        <option selected>Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}"{{$user->memberid  == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
        </select>
      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4">
 
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo1" class="form-control " disabled="" ><option selected>Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}"{{$user->memberid  == $i?'selected':''}}>{{ $user->mobileno }}</option>@endforeach
        </select>
    
<!-- /input-group -->
    </div>
    <br>

    <div class="col-lg-4" style="margin-top: -20px;">
      <div class="form-group">
       <button type="button" id="next1" class="btn bg-green">Next</button>
      </div>
    </div>
  </div>

  <!-- /**********************end serachbyusername **********************/ --> 
   <!-- /**********************start serachbymobileno **********************/ --> 
     <div class="box-body" id="serachbymobileno" style="display: none; margin-top: -20px;"> 
 
      <div class="col-lg-4">
  
      
        <!-- <label>Username<span style="color: red">*</span></label> -->

       <select name="selectusername" id="username2"  class="form-control " disabled="" ><option selected>Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}"{{$user->memberid  == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
        </select>
      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4" >
      
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo2" class="form-control select2"title="Select Mobileno" data-live-search="true"  data-actions-box="true" ><option selected>Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}"{{$user->memberid  == $i?'selected':''}}>{{ $user->mobileno }}</option>@endforeach
        </select>
      
<!-- /input-group -->
    </div>
    <br>

    <div class="col-lg-4" style="margin-top: -20px;">
      <div class="form-group">
       <button type="button" id="next2" class="btn bg-green">Next</button>
      </div>
    </div>
  </div>
  </div>

  <!-- /**********************end serachbymobileno **********************/ -->

  <div class="box box-primary" style="display: none" id="addmeasurment">
  <div class="box-header with-border"></div>
    <div class="box-body" > 
     <div class="col-lg-12">
      <div class="col-lg-3"></div>
      <div class="col-lg-5">
        <div class="form-group"> 
           <label>Date</label>
        <input type="date" onkeypress="return false" name="todaydate" class="form-control" value="<?php echo date('Y-m-d');?>">
        </div>
         <div class="form-group"> 
          <label>Weight</label>
        <input type="text" name="weight" class="form-control numberflot" placeholder="weight">
        </div>
         
         <div class="form-group"> 
             <label>Height</label>
        <input type="text" name="height" class="form-control numberflot" placeholder="height">
        </div>
         
         <div class="form-group"> 
           <label>Neck</label>
        <input type="text" name="neck" class="form-control numberflot" placeholder="neck">
        </div>
         <div class="form-group"> 
           <label>Left Upper Arm</label>
        <input type="text" name="leftupperarm" class="form-control numberflot" placeholder="left upper arm">
        </div>
         <div class="form-group"> 
            <label>Right Upper Arm</label>
        <input type="text" name="rightupperarm" class="form-control numberflot" placeholder="right upper arm">
        </div>
         <div class="form-group"> 
           <label>Chest</label>
        <input type="text" name="chest" class="form-control numberflot"placeholder="chest">
        </div>
        <div class="form-group"> 
           <label>Waist</label>
        <input type="text" name="waist" class="form-control numberflot"placeholder="waist">
        </div>
         <div class="form-group"> 
           <label>Hips</label>
        <input type="text" name="hips" class="form-control numberflot"placeholder="hips">
        </div>
         <div class="form-group"> 
           <label>Left Thigh</label>
        <input type="text" name="leftthigh" class="form-control numberflot"placeholder="left thigh">
        </div>
         <div class="form-group"> 
           <label>Right Thigh</label>
        <input type="text" name="rightthigh" class="form-control numberflot"placeholder="right thigh">
        </div>
         <div class="form-group"> 
           <label>Left Calf</label>
        <input type="text" name="leftcalf" class="form-control numberflot"placeholder="left calf">
        </div>
         <div class="form-group"> 
           <label>Right Calf</label>
        <input type="text" name="rightcalf" class="form-control numberflot"placeholder="right calf">
        </div>
        <center>
        <div class="form-group">
         <button type="submit" class="btn bg-green margin" id="save_memberform">Save </button>
           <button type="submit" class="btn bg-red">Cancel</button>
        </div>
        </center>
      </div>
      </div>
    </div>

</div>
</form>
</section>
</div>
<script type="text/javascript">

                                      
</script>
<script type="text/javascript">
 $( document ).ready(function() {
     var selValue = $('input[name=rbnNumber]:checked').val(); 
  if(selValue == 1){
          $('#serachbyusername').css('display','block');
          $('#serachbymobileno').css('display','none');
        }
        else if(selValue == 2 ){
          $('#serachbyusername').css('display','none');
          $('#serachbymobileno').css('display','block');
        }
    // $('#username').trigger('change');
     $('.btnGetValue').click(function() {
        var selValue = $('input[name=rbnNumber]:checked').val(); 
        // console.log(selValue);
        if(selValue == 1){
          $('#serachbyusername').css('display','block');
          $('#serachbymobileno').css('display','none');
        }
        else if(selValue == 2 ){
          $('#serachbyusername').css('display','none');
          $('#serachbymobileno').css('display','block');
        }
        // $('p').html('<br/>Selected Radio Button Value is : <b>' + selValue + '</b>');
    });
  });
  $('.btnGetValue').on('change',function(){
    clear_form_elements();
   $('#addmeasurment').css('display','none');
  });
</script>
  <script>
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
        case 'select-one':
        case 'select-multiple':
        case 'number':
        case 'tel':
        case 'email':

            jQuery(this).val('');
            break;
        case 'checkbox':
        case 'radio':
        case 'select':
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
  $('#next2').on('click',function(){

  var username = $("#username2").value;
     var MobileNo =$("#mobileNo2").value;
 
var _token = $('input[name="_token"]').val();
       $.ajax({
      url:"{{ route('measurementgetuser') }}",
      method:"POST",
      data:{username:username, MobileNo:MobileNo, _token:_token},
      success:function(result)
      {
      
       if(result)
       {
     // alert(result);
        var data=result;
   
         $('#addmeasurment').css('display','block');
       
       }
       else
       {
       
         $('#addmeasurment').css('display','none');
       }
      },
       // dataType:"json"
     })

  });
</script>
<script type="text/javascript">
  $('#next1').on('click',function(){

  var username = document.getElementById("username1").value;
     var MobileNo = document.getElementById("mobileNo1").value;
 
var _token = $('input[name="_token"]').val();
       $.ajax({
      url:"{{ route('measurementgetuser') }}",
      method:"POST",
      data:{username:username, MobileNo:MobileNo, _token:_token},
      success:function(result)
      {
      
       if(result)
       {
     // alert(result);
        var data=result;
   
         $('#addmeasurment').css('display','block');
       
       }
       else
       {
       
         $('#addmeasurment').css('display','none');
       }
      },
       // dataType:"json"
     })

  });
</script>
<script type="text/javascript">
   $('#username1').on('change',function(){
     clear_form_elements();
    // alert('sdfs');
    // alert($("#username2").val());
   $('#addmeasurment').css('display','none');



    var username = $('#username1').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
       // alert(data.memberid);
        // console.log(data);
  
       $('#mobileNo1').val(data.memberid);
       $("#username2").val(data.memberid);
       $('#mobileNo2').val(data.memberid);

       
    // $('#mobileNo').select2().trigger('change');

     
      },
        dataType:"json"
     });
   });
</script>
<script type="text/javascript">
  $('#mobileNo2').on('change',function(){

   $('#addmeasurment').css('display','none');
    var username = $('#mobileNo2').val();
    var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;

      // $('#username').attr("value",data.username).val(data.username);
     $("#username2").val(data.memberid);
     $("#username1").val(data.memberid);
      $('#mobileNo1').val(data.memberid);
      },
       dataType:"json"
     });
   });



$('#save_memberform').click(function(){
     if ($('#package_form').valid()){
         $('#package_form').submit();
         $('#save_memberform').attr('disabled',true);

     }
  });
 </script>
@endsection
@push('script')

@endpush