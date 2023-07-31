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
    
     
<!--          <section class="content-header"><h2>Add Password</h2></section>
 -->          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Password</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">


              <form role="form" action="{{ url('addpassword') }}" method="post" id="dietitemform" >
                 {{ csrf_field() }}
                <!-- text input -->
             
               
              


                    <div class="form-group">
                     <label>Password for Excel file</label>
                     <input type="Password"  name="excelpassword" value="{{ old('excelpassword') }}" class="form-control  "  placeholder="Password for Excel"  class="span11" />
                     @if($errors->has('excelpassword'))
                     <span class="help-block">
                     <strong>{{ $errors->first('excelpassword') }}</strong>
                     </span>
                     @endif
                  </div>


<!-- 

                    <div class="form-group">
                     <label>Password for PDF file</label>
                     <input type="text"  name="pdfpassword" value="{{ old('pdfpassword') }}" class="form-control  "  placeholder="Password for PDF"  class="span11" />
                     @if($errors->has('pdfpassword'))
                     <span class="help-block">
                     <strong>{{ $errors->first('pdfpassword') }}</strong>
                     </span>
                     @endif
                  </div> -->





                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Save</button></div>   <div class="col-sm-6"> <a href="{{ url('viewpassword') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
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
    $('#dietitemform').validate({
    
    });
  });
</script>
@endpush