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
              <h3 class="box-title">Edit Payment Type</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('editpaymenttype/'.$PaymentType->paymenttypeid) }}"  method="post" id="payment_form">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Role Name<span style="color: red">*</span></label>
                  <input type="text" class="form-control" value="{{$PaymentType->paymenttype}}" name="PaymentType" id="PaymentType" placeholder="PaymentType"  required="">
                   @if($errors->has('PaymentType'))
                    <span class="help-block">
                      <strong>{{ $errors->first('PaymentType') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Description<span style="color: red">*</span></label>
                 <textarea class="form-control" rows="3" id="description"   name="description"placeholder="PaymentType" required>{{$PaymentType->description}}</textarea>
                </div>

                  <div class="form-group">
                <div class="col-sm-offset-3">
              
         <button type="submit" class="btn bg-green margin">
         Update</button>
         <a href="{{ url('paymenttypes') }}"class="btn bg-red margin">Cancel</a>
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
  $(document).ready(function(){
    $('#payment_form').validate({
      rules: {
        PaymentType : {
          required : true,
          maxlength : 255
        },
        description : {
          maxlength : 255
        }
      }
    });
  });
</script>
@endpush