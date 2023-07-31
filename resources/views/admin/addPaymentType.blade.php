@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
@endpush()
@section('content')
<!-- left column -->
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Add Payment Type</h2></section>
 -->          <!-- general form elements -->
           <section class="content">
          <!--  @if ($errors->any())
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
              <h3 class="box-title">Add Payment Type</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">
              <form role="form" action="{{ url('addpaymenttype') }}" method="post" id="payment_form">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Payment Type<span style="color: red">*</span></label>
                  <input type="text" class="form-control" value="{{ old('PaymentType') }}" name="PaymentType" id="PaymentType" required placeholder="Enter Payment Type">
                  @if($errors->has('PaymentType'))
                    <span class="help-block">
                      <strong>{{ $errors->first('PaymentType') }}</strong>
                    </span>
                  @endif
  
                </div>
                <div class="form-group">
                  <label>Description</label>
                 <textarea class="form-control" rows="3"  name="description" id="description" placeholder="Enter Descrription">{{ old('description') }}</textarea>
                </div>

                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Save</button></div>   <div class="col-sm-6"> <a href="{{ url('paymenttypes') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
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