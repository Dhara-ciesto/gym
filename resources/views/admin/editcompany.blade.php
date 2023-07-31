@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
@endpush
@section('content')
 <div class="content-wrapper">
   
     
         <section class="content-header"></section>
          <!-- general form elements -->
           <section class="content">
         
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Edit Company</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('editcompany/'.$company->companyid) }}" id="compant_form"  method="post">
                 {{ csrf_field() }}
                <!-- text input -->
               <div class="form-group">
                  <label>Company Name<span style="color: red;">*</span></label>
                  <input type="text" class="form-control" name="companyName" id="companyName" required placeholder="Company Name" @if(old('companyName') != null) value="{{old('companyName')}}"  @else value="{{$company->companyname}}" @endif>
                  @if($errors->has('companyName'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companyName') }}</strong>
                    </span>
                  @endif
  
                </div>
                <div class="form-group">
                  <label>Gst No.<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="GstNo" id="GstNo" minlength="15" maxlength="15" required placeholder="Gst No" value="{{$company->gstno}}">
                     @if($errors->has('GstNo'))
                    <span class="help-block">
                      <strong>{{ $errors->first('GstNo') }}</strong>
                    </span>
                  @endif
               
                </div>
                 <div class="form-group">
                  <label>Contact Person<span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="contactPerson" id="contactPerson" required placeholder="ContactPerson" value="{{$company->contactpersonname}}">
                @if($errors->has('contactPerson'))
                    <span class="help-block">
                      <strong>{{ $errors->first('contactPerson') }}</strong>
                    </span>
                  @endif
                </div>
                  <div class="form-group">
             <label>Contact No.<span style="color: red;">*</span></label>
             
                <input type="text" name="contactNo" id="contactNo"  minlength="10" maxlength="10"
 class="form-control number" placeholder="ContactNo" required=""  class="span11"value="{{$company->contactpersonmobileno}}" /><span class="errmsg"></span>
               </div>
             <!--     <div class="form-group">  
                  <label>Contact No.</label>
                <input type="text" class="form-control" name="contactNo" required placeholder="ContactNo">
                </div> -->
                 <div class="form-group">
                  <label>Address</label>
                 <textarea class="form-control" rows="3"  name="add" id="add" placeholder="Address">{{$company->companyaddress}}</textarea>
                  @if($errors->has('add'))
                    <span class="help-block">
                      <strong>{{ $errors->first('add') }}</strong>
                    </span>
                  @endif
                </div>

                  <div class="form-group">
                <div class="col-sm-offset-3">
              
         <button type="submit" class="btn bg-green margin">
         Update</button>
         <a href="{{ url('company') }}"class="btn bg-red margin">Cancel</a>
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
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#compant_form').validate({
      rules: {
        companyName : {
          required : true,
          maxlength : 255
        },
        GstNo : {
          required : true,
          maxlength : 15,
        },
        contactPerson : {
          required : true,
          maxlength : 255,
        },
        contactNo : {
          required : true,
          maxlength : 10,
        },
        add : {
          maxlength : 255
        }
      }
    });
  });
</script>