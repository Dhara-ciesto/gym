@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<style type="text/css">
  strong{
    color: red;
  }
</style>
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Add Company</h2></section>
 -->          <!-- general form elements -->
           <section class="content">
           <!-- @if ($errors->any())
            <div class="alert alert-danger">
                 <button type="button" class="close" data-dismiss="alert">×</button> 
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif -->

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Company</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">
              <form role="form" action="{{ url('addCompany') }}" method="post" id="compant_form">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Company Name<span style="color: red;">*</span></label>
                  <input type="text" class="form-control" value="{{ old('companyName') }}" name="companyName" id="companyName" required placeholder="Company Name">
                  @if($errors->has('companyName'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companyName') }}</strong>
                    </span>
                  @endif
  
                </div>
                <div class="form-group">
                  <label>Gst No.<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="GstNo" id="GstNo" value="{{ old('GstNo') }}" minlength="15" maxlength="15" required placeholder="Gst No">
                    @if($errors->has('GstNo'))
                    <span class="help-block">
                      <strong>{{ $errors->first('GstNo') }}</strong>
                    </span>
                  @endif
               
                </div>
                 <div class="form-group">
                  <label>Contact Person<span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="contactPerson" id="contactPerson" value="{{ old('contactPerson') }}" required placeholder="ContactPerson">
                  @if($errors->has('contactPerson'))
                    <span class="help-block">
                      <strong>{{ $errors->first('contactPerson') }}</strong>
                    </span>
                  @endif
                </div>
                  <div class="form-group">
             <label>Contact No.<span style="color: red;">*</span></label>
             
                <input type="text" name="contactNo" id="contactNo"  minlength="10" maxlength="10"
 class="form-control number" placeholder="ContactNo" required="" value="{{ old('contactNo') }}"  class="span11" />
               @if($errors->has('contactNo'))
                    <span class="help-block">
                      <strong>{{ $errors->first('contactNo') }}</strong>
                    </span>
                  @endif
 <span class="errmsg"></span>

               </div>
             <!--     <div class="form-group">  
                  <label>Contact No.</label>
                <input type="text" class="form-control" name="contactNo" required placeholder="ContactNo">
                </div> -->
                 <div class="form-group">
                  <label>Address</label>
                 <textarea class="form-control" rows="3"  name="add" id="add" placeholder="Address">{{ old('add') }}</textarea>
                  @if($errors->has('add'))
                    <span class="help-block">
                      <strong>{{ $errors->first('add') }}</strong>
                    </span>
                  @endif
                </div>

                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Save</button></div>   <div class="col-sm-6"> <a href="{{ url('company') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
      </div>
                <!-- Select multiple-->
        

              </form></div><div class="col-lg-3"></div>
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
@endpush