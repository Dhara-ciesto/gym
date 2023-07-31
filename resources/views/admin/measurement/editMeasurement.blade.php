@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
@endpush
@section('content')
<!-- left column -->
<style type="text/css">

</style>
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Edit Measurement</h2></section>
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

 <form role="form" action="{{ url('editMeasurement/'.$editmeasurement->measurementid) }}" name="addmeasurment" method="POST" id="package_form">
  {{ csrf_field() }}
<div class="box box-primary" id="secondstep" >

           <div class="box-header with-border">
<!--               <h3 class="box-title">Select Member</h3>
 -->            </div>

<!-- /.box-header -->
    <div class="box-body">  <h4><u></u></h4> 
      <div class="col-lg-4">
  
      <div class="input-group">
        <label>Username<span style="color: red">*</span></label>

       <select name="selectusername" id="username" disabled="" class="form-control selectpicker"title="Select User" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Username" required><option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}"{{  $user->memberid==$editmeasurement->memberid ? 'selected':'' }}>{{ $user->username }}</option>@endforeach
        </select>
      </div>
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4">
      <div class="input-group">
        <label>Mobile No:</label>
        <select name="selectmobileno" id="mobileNo" disabled="" class="form-control" disabled="" ><option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}" {{ $user->memberid==$editmeasurement->memberid ? 'selected':'' }}>{{ $user->mobileno }}</option>@endforeach
        </select>
      </div>
<!-- /input-group -->
    </div>
    <br>
<!-- 
    <div class="col-lg-4" style="margin-top: 5px;">
      <div class="form-group">
       <button type="button" id="next" class="btn bg-green">Next</button>
      </div>
    </div> -->
  </div>
  </div>
  <div class="box box-primary" style="display: block" id="addmeasurment">
  <div class="box-header with-border"></div>
    <div class="box-body" > 
     <div class="col-lg-12">
      <div class="col-lg-3"></div>
      <div class="col-lg-5">
        <div class="form-group"> 
           <label>Date</label>
        <input type="date" onkeypress="return false" name="todaydate" class="form-control" value="<?php echo date('Y-m-d', strtotime($editmeasurement->todaydate))?>">
        </div>
         <div class="form-group"> 
          <label>Weight</label>
        <input type="text" name="weight" class="form-control numberflot" placeholder="weight" value="{{$editmeasurement->weight}}">
        </div>
         
         <div class="form-group"> 
             <label>Height</label>
        <input type="text" name="height" class="form-control numberflot" placeholder="height" value="{{$editmeasurement->height}}">
        </div>
         
         <div class="form-group"> 
           <label>Neck</label>
        <input type="text" name="neck" class="form-control numberflot" placeholder="neck" value="{{$editmeasurement->neck}}">
        </div>
         <div class="form-group"> 
           <label>Left Upper Arm</label>
        <input type="text" name="leftupperarm" class="form-control numberflot" placeholder="left upper arm" value="{{$editmeasurement->leftupperarm}}">
        </div>
         <div class="form-group"> 
            <label>Right Upper Arm</label>
        <input type="text" name="rightupperarm" class="form-control numberflot" placeholder="right upper arm" value="{{$editmeasurement->rightupperarm}}">
        </div>
         <div class="form-group"> 
           <label>Chest</label>
        <input type="text" name="chest" class="form-control numberflot"placeholder="chest" value="{{$editmeasurement->chest}}">
        </div>
        <div class="form-group"> 
           <label>Waist</label>
        <input type="text" name="waist" class="form-control numberflot"placeholder="waist" value="{{$editmeasurement->waist}}">
        </div>
         <div class="form-group"> 
           <label>Hips</label>
        <input type="text" name="hips" class="form-control numberflot"placeholder="hips" value="{{$editmeasurement->hips}}" >
        </div>
         <div class="form-group"> 
           <label>Left Thigh</label>
        <input type="text" name="leftthigh" class="form-control numberflot"placeholder="left thigh" value="{{$editmeasurement->leftthigh}}">
        </div>
         <div class="form-group"> 
           <label>Right Thigh</label>
        <input type="text" name="rightthigh" class="form-control numberflot"placeholder="right thigh" value="{{$editmeasurement->rightthigh}}">
        </div>
         <div class="form-group"> 
           <label>Left Calf</label>
        <input type="text" name="leftcalf" class="form-control numberflot"placeholder="left calf" value="{{$editmeasurement->leftcalf}}">
        </div>
         <div class="form-group"> 
           <label>Right Calf</label>
        <input type="text" name="rightcalf" class="form-control numberflot"placeholder="right calf" value="{{$editmeasurement->rightcalf}}">
        </div>
        <center>
        <div class="form-group">
         <button type="submit" class="btn bg-green margin">Save </button>
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
  $('#package_form').on('submit',function(){
      $('#username').prop( "disabled", false );
      $('#mobileNo').prop( "disabled", false );
      
  });
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
  $('#next').on('click',function(){

  var username = document.getElementById("username").value;
     var MobileNo = document.getElementById("mobileNo").value;
 
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
   $('#username').on('change',function(){
    clear_form_elements();
    // alert('sdfs');

   $('#addmeasurment').css('display','none');


    var username = $('#username').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
       $('select[name=selectmobileno]').val(data.userid);
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

</script>
@endpush