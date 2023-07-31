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
   
     
<!--          <section class="content-header">Edit Reason</section>
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
              <h3 class="box-title">Edit Reason</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('editReason/'.$reason->reasonid) }}"  method="post" id="reason_form">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Reason</label>
                  <input type="text" class="form-control" @if(old('reason') != null) value="{{ old('reason') }}"  @else value="{{$reason->reason}}" @endif name="reason" placeholder="Enter reason"  required="">
                  @if($errors->has('reason'))
                    <span class="help-block">
                      <strong>{{ $errors->first('reason') }}</strong>
                    </span>
                  @endif
                </div>
             

                  <div class="form-group">
                <div class="col-sm-offset-3">
              
         <button type="submit" class="btn bg-green margin">
         Update</button>
         <a href="{{ url('reasons') }}"class="btn bg-red margin">Cancel</a>
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
    $('#reason_form').validate({
      rules: {
        Reason : {
          required : true,
          maxlength : 255
        }
      }
    });
  });
</script>
@endpush