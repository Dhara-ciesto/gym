@extends('layouts.adminLayout.admin_design')
@section('content')
 <div class="content-wrapper">
   
     
         <section class="content-header"></section>
          <!-- general form elements -->
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
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Edit Scheme</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('editscheme/'.$scheme->schemeid) }}" id="scheme_form"  method="post">
                 {{ csrf_field() }}


 
                <!-- text input -->
                  <div class="form-group">
             <label>Select Root Scheme<span style="color: red">*</span></label>

             
               <select name="RootSchemeId" required="" class="form-control"class="span11" required><option  disabled=""selected>--Please choose an option--</option>
               @foreach($rootscheme as $rscheme)   
              <option value="{{ $rscheme->rootschemeid }}" {{ ( $rscheme->rootschemeid == $scheme->rootschemeid  ) ? 'selected' : '' }}>{{ $rscheme->rootschemename }}</option>
              @endforeach
          </select>
              </div>
                <div class="form-group">
                  <label>Scheme Name<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="SchemeName" id="SchemeName" value="{{$scheme->schemename}}" placeholder="Enter Scheme Name"required>
                </div>
                <div class="form-group">
                  <label>Number of Days<span style="color: red">*</span></label>
              
                 <input type="number" class="form-control"  min='0' readonly="" value="{{$scheme->numberofdays}}" name="NumberOfDays" placeholder="Enter numer of days" required>
                </div>
                <div class="form-group">
                  <label>Base Price<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="BasePrice"value="{{$scheme->baseprice}}" placeholder="Enter Base Price" id="BasePrice" >
                   <input type="hidden" name="oldbaseprice" value="{{$scheme->baseprice}}">
                </div>
                <div class="form-group">
                  <label>Tax</label>
                  <input type="text" class="form-control"  name="Tax"value="{{$scheme->tax}}" placeholder="Enter Tax" readonly id="Tax">
                    <input type="hidden" name="oldtax" value="{{$scheme->tax}}">

                </div>
                <div class="form-group">
                  <label>Actual Price<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="ActualPrice"value="{{$scheme->actualprice}}" placeholder="Enter Actual Price" id="ActualPrice">
                   <input type="hidden" name="oldactualprice" value="{{$scheme->actualprice}}">
                </div>
                  <div class="form-group">
                  <label>Validity<span style="color: red">*</span></label>
                  <input type="date" onkeypress="return false" class="form-control" name="validity"value="{{$scheme->validity}}" min="{{$scheme->validity}}" >
                </div>
                 <div class="form-group">
              <label>From<span style="color: red">*</span></label>
               <input type="time"class="form-control" name="WorkingHourFrom" readonly=""
                min="9:00 am" max="12:00 pm" value="<?php $date = date("H:i", strtotime($scheme->workinghourfrom)); echo "$date"; ?>"/></div>
               
               <div class="form-group">To<span style="color: red">*</span>
               <input type="time" class="form-control" name="WorkingHourTo"readonly="" 
                min="9:00 am" max="12:00 pm"value="<?php $date = date("H:i", strtotime($scheme->workinghourto)); echo "$date"; ?>"  /></div>
               
            
                 <div class="form-group">
                  <label>Status</label>
                  <select  class="form-control"name="status" required>
                      <option selected disabled="">--Please choose an option--</option>
                      <option value="1" {{$scheme->status == '1' ? 'selected':''}}>Active</option>
                      <option value="0" {{$scheme->status == '0' ? 'selected':''}}>Deactive</option>
                  </select>
               
                </div>
                <div class="form-group">
                  <label>Gender</label>
        
                     <input type="checkbox" name="Female"  value="1" {{$scheme->female=='1' ? 'checked' : ''}} >
                      Female
                   
                      <input type="checkbox" name="Male"  value="1"  {{$scheme->male=='1' ? 'checked' : ''}}  >
                      Male
                    
                  </div>

                <div class="form-group">
                <div class="col-sm-offset-3">
              
         <button type="submit" class="btn bg-green margin">
         Update</button>
         <a href="{{ url('schemes') }}"class="btn bg-red margin">Cancel</a>
        </div>
                <!-- Select multiple-->
        
              </form></div>
            </div>
            <!-- /.box-body -->
          </div>
      
  </section>
</div>
</div>
</div>
@endsection

@push('script')
<script type="text/javascript">
  function myfun(){
 

    // alert('sad');
    // return false;
     var from= $('#from').val();
  var to=$('#to').val();
  var validity=$('#validity').val();
  if(validity.length == 0){
    alert('Please enter validity date');
  
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
  $(document).ready(function(){
    $('#user_validation_form').validate({
      SchemeName : {
        required : true,
        maxlength : 255
      }
    });
  });
</script>
@endpush