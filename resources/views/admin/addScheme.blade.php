@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
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

 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
@endpush
@section('content')
<!-- left column -->
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Add Scheme</h2></section>
 -->          <!-- general form elements -->
           <section class="content">
      {{--  @if ($errors->any())
            <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <ul>
            @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif --}}
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Scheme</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('addscheme') }}" id="scheme_form" method="post" onsubmit="return myfun()">
                 {{ csrf_field() }}
                <!-- text input -->
               <div class="form-group">
             <label>Select Root Scheme<span style="color: red">*</span></label>
             
                <select name="RootSchemeId" required class="form-control select2"class="span11"><option disabled="" selected="">Please choose an option</option>@foreach($scheme as $scheme)
              <option value="{{ $scheme->rootschemeid }}" @if(old('RootSchemeId') == $scheme->rootschemeid) selected @endif>{{ $scheme->rootschemename }}</option>@endforeach
          </select>
              </div>
                <div class="form-group">
                  <label>Scheme Name<span style="color: red">*</span></label>
                  <input type="text" class="form-control" maxlength="191" name="SchemeName" value="{{ old('SchemeName') }}"  id="SchemeName" required placeholder="Enter Scheme Name"><span id="error_SchemeName"></span>
                  @if($errors->has('SchemeName'))
                  <span class="help-block">
                    <strong>{{ $errors->first('SchemeName') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Number of Days<span style="color: red">*</span></label>
              
                 <input type="text" class="form-control number" value="{{ old('NumberOfDays') }}"  min='0' name="NumberOfDays" required placeholder="Enter numer of days">
                 @if($errors->has('NumberOfDays'))
                  <span class="help-block">
                    <strong>{{ $errors->first('NumberOfDays') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Base Price<span style="color: red">*</span></label>
                  <input type="text" class="form-control number" value="{{ old('BasePrice') }}" name="BasePrice" id="BasePrice" maxlength="10" required placeholder="Base Price">
                  @if($errors->has('BasePrice'))
                  <span class="help-block">
                    <strong>{{ $errors->first('BasePrice') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Tax</label>

                  <input type="text" class="form-control" name="Tax" id="Tax"   value="{{($sgst)+($cgst)}}" readonly>
                </div>
                <div class="form-group">
                  <label>Actual Price<span style="color: red">*</span></label>
                  <input type="text" class="form-control number" value="{{ old('ActualPrice') }}" name="ActualPrice" id="ActualPrice" required placeholder="ActualPrice" maxlength="10">
                  @if($errors->has('ActualPrice'))
                  <span class="help-block">
                    <strong>{{ $errors->first('ActualPrice') }}</strong>
                  </span>
                  @endif
                </div>
                 <div class="form-group">
                  <label>Validity<span style="color: red">*</span></label>
                  <input type="date" class="form-control" onkeypress="return false" value="{{ old('validity') }}" name="validity" id="validity" min="{{ date('Y-m-d') }}"  required placeholder="ActualPrice" >
                  @if($errors->has('validity'))
                  <span class="help-block">
                    <strong>{{ $errors->first('validity') }}</strong>
                  </span>
                  @endif
                </div>
                 <div class="form-group">
           <label>From (24 hour)<span style="color: red">*</span></label>
               <input type="" name="WorkingHourFrom" value="{{ old('WorkingHourFrom') }}" class="form-control input-a" id="from" min="06:00" max="21:00"  required="required" autocomplete="off"> 
               @if($errors->has('WorkingHourFrom'))
                  <span class="help-block">
                    <strong>{{ $errors->first('WorkingHourFrom') }}</strong>
                  </span>
                  @endif
                 <!--  <input id="input-ar54" value="" class="form-control input-a number" placeholder="Time" name="tab6time1" autocomplete="off" onkeypress="return false"> -->
              <!--  <input type="time"class="form-control"  id="from" required name="WorkingHourFrom"
                min="5:00" max="12:00" value="06:00" /> --></div>
      
               <div class="form-group">To<span style="color: red">*</span>
                <input type=""  name="WorkingHourTo" value="{{ old('WorkingHourTo') }}" class="form-control input-a" id="to" min="06:00" max="24:00" step="600"required autocomplete="off"> 
                @if($errors->has('WorkingHourTo'))
                  <span class="help-block">
                    <strong>{{ $errors->first('WorkingHourTo') }}</strong>
                  </span>
                  @endif
              <!--  <input type="time" class="form-control" id="to" name="WorkingHourTo"
                min="9:00" max="12:00" value="12:00"/> --></div>
               
      <!--       
                 <div class="form-group">
                  <label>Status</label>
                  <select  class="form-control"name="status">
                      <option selected disabled="">Please choose an option</option>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                  </select>
               
                </div> -->
                <div class="form-group">
                  <label>Gender</label>
                     <input type="checkbox" name="Female"  value="1" checked="">
                      Female
                   
                      <input type="checkbox" name="Male"  value="1"  checked="">
                      Male
                    
                  </div>

                   <div class="form-group">
                      <div class="col-sm-offset-3">
              <div class="col-sm-8">
                     <button disabled class="btn bg-green" id="btnnew" style="display: none;">Submitting</button>
                <button name="submit" type="submit" class="btn bg-green margin" id="save">Save</button>   <a href="{{ url('schemes') }}"class="btn btn-danger">Cancel</a></div></div>
  
              </div>
                <!-- Select multiple-->
        

              </form></div><div class="col-lg-3"></div></div>
            </div>
            <!-- /.box-body -->
          </div>
      
  </section>
</div>
</div>
</div>
<script type="text/javascript">
   $('#BasePrice').on('keyup',function(){
    if($("#BasePrice").val() == 0){
       $('#ActualPrice').val('0');
    }else{
     var result = parseFloat((parseInt($("#BasePrice").val()) / 100) * parseInt($("#Tax").val()));
     var sum=parseFloat(0);
      sum=parseFloat((parseInt($("#BasePrice").val()))+result);
            $('#ActualPrice').val((sum).toFixed(2) || ''); //shows value in "#rate"
  }

   });
   $('#ActualPrice').on('keyup',function(){
     if($("#ActualPrice").val() == 0){
     
       $('#BasePrice').val('0');
    }
    else
    {

     var result = parseFloat((parseInt($("#Tax").val()))+100);
    
      var ActualPrice = parseFloat($("#ActualPrice").val()*100);
    
      var sum =parseFloat(ActualPrice/result);
     // var sum = parseFloat(0);
     //  sum = parseFloat((parseInt($("#ActualPrice").val()))-result);
     //        $('#BasePrice').val(sum || ''); //shows value in "#rate"
   $('#BasePrice').val((sum).toFixed(2) || ''); 
   }
   });
</script>
<script type="text/javascript">
    $('#SchemeName').on('keyup',function(){
      // alert("hi");
    var error_SchemeName = '';
    var SchemeName = $('#SchemeName').val();
    var _token = $('input[name="_token"]').val();

     $.ajax({
      url:"{{ route('SchemeController.check') }}",
      method:"POST",
      data:{SchemeName:SchemeName, _token:_token},
      success:function(result)
      {
       if(result == 'unique')
       {
        $('#error_SchemeName').html('<label class="text-success">Scheme is Valid</label>');
        $('#SchemeName').removeClass('has-error');
        $('#firstbtn').attr('disabled', false);
       }
       else
       {
        // alert("hi1");

        $('#error_SchemeName').html('<label class="text-danger">Scheme is Already Exist! Please Enter Different Price</label>');

        $('#SchemeName').addClass('has-error');
        $('#firstbtn').attr('disabled', 'disabled');
       }
      }
     })

 });
</script>
<script type="text/javascript">
  function myfun(){
 

    // alert('sad');
    // return false;
     var from= $('#from').val();
  var to=$('#to').val();
  var validity=$('#validity').val();
  if(validity.length == 0){
    alert('Please enter validity date');
    // $('#').();
  }
  
  if(from.length !=0 && to.length != 0){
    if(from==to){
      alert('Please enter valid time!')
      return false;
    }
    else if(to < from){
   alert('Please enter valid time!')
   return false;
    }
    else{
      return true;
    }
  }
  }
 
</script>

@endsection

@push('script')
<script type="text/javascript">
  $(document).ready(function(){
     var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
$('#button-a').click(function(e){
    // Have to stop propagation here
    e.stopPropagation();
    input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
});
$('#button-b').click(function(e){
    // Have to stop propagation here
    e.stopPropagation();
    input.clockpicker('show')
            .clockpicker('toggleView', 'hours');
});
   /* $('#save').click(function(){
     $('#btnnew').show();
     $('#save').hide();
   });*/
    $('#scheme_form').validate({
      rules: {
        SchemeName : {
          required : true,
          maxlength : 255
        },
        email : {
          required : true,
          maxlength : 255
        },
        validity : {
          required : true,
          dateFormat: true
        }
      }
    });
    $('.select2').select2()

    $('#SchemeName').change(function(){
      let schemes = $(this).val();
      if(!schemes){
        $('#error_SchemeName').html('');
      }
    });
  });
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.js"></script>

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
@endpush
