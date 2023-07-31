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
  <div class="content-wrapper">
    
     
         <section class="content-header"><h2>Edit Registration Type</h2></section>
          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Edit Registration Type</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-3"></div><div class="col-lg-5">


              <form role="form" action="{{ url('editregpaymenttype/'.$regpayment->regpaymentid) }}" method="post" id="dietnoteform" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                 <label>Name<span style="color: red">*</span></label>

                  <input type="text"  class="form-control" value="{{$regpayment->regpaymentname}}" maxlength="255" name="regpaymentname"  placeholder="Name">
                  @if($errors->has('regpaymentname'))
                    <span class="help-block">
                      <strong>{{ $errors->first('regpaymentname') }}</strong>
                    </span>
                  @endif

  
                </div>
                <div class="form-group">
                      <label>Company Name<span style="color: red">*</span></label>

                  <input type="text"  class="form-control"  value="{{$regpayment->companyname}}"  maxlength="255" name="companyname"  placeholder="Company Name">
                   @if($errors->has('companyname'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companyname') }}</strong>
                    </span>
                  @endif
                  
                </div>
                   <div class="form-group">
                      <label>Contact Person<span style="color: red">*</span></label>

                  <input type="text"  class="form-control"  value="{{$regpayment->copersonname}}"  maxlength="255" name="copersonname"  placeholder="Contact Person Name">
                   @if($errors->has('copersonname'))
                    <span class="help-block">
                      <strong>{{ $errors->first('copersonname') }}</strong>
                    </span>
                  @endif

                  
                </div>
                     <div class="form-group">
                      <label>Contact No<span style="color: red">*</span></label>

                  <input type="text"  class="form-control"  value="{{$regpayment->contactno}}"  maxlength="255" name="contactno"  placeholder="Contact No">
                   @if($errors->has('contactno'))
                    <span class="help-block">
                      <strong>{{ $errors->first('contactno') }}</strong>
                    </span>
                  @endif

                  
                </div>

                    <div class="form-group">
                      <label>GST No<span style="color: red">*</span></label>

                  <input type="text"  class="form-control"value="{{$regpayment->gstno}}"  maxlength="15" name="gstno"  placeholder="GST No" minlength="15">
                   @if($errors->has('gstno'))
                    <span class="help-block">
                      <strong>{{ $errors->first('gstno') }}</strong>
                    </span>
                  @endif

                  
                </div>
                    <div class="form-group">
                      <label>Amount<span style="color: red">*</span></label>

                  <input type="text"  class="form-control number"  maxlength="255" name="amount"  placeholder="Amount" value="{{$regpayment->amount}}"  >
                   @if($errors->has('amount'))
                    <span class="help-block">
                      <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                  @endif

                  
                </div>
                 <br>            
              

                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Update</button></div>   <div class="col-sm-6"> <a href="{{ url('regpaymenttype') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
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
    $('#dietnoteform').validate({
    
    });
  });
</script>
@endpush