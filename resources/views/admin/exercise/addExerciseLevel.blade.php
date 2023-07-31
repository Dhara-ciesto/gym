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
   
     
<!--          <section class="content-header"><h2>Add Tag</h2></section>
 -->          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Tag</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">

              <form role="form" action="{{ url('addExerciseLevel') }}" method="post" id="level_form" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                 <label>Exercise Tag<span style="color: red">*</span></label>

                  <input type="text" class="form-control" value="{{ old('exerciselevel') }}" maxlength="255" name="exerciselevel" required placeholder="Exercise Level">
                  @if($errors->has('exerciselevel'))
                    <span class="help-block">
                      <strong>{{ $errors->first('exerciselevel') }}</strong>
                    </span>
                  @endif

  
                </div>
               
              

                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Save</button></div>   <div class="col-sm-6"> <a href="{{ url('viewExerciseLevel') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
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
    $('#level_form').validate({
      /*rules: {
        username : {
          required : true,
          maxlength : 255
        },
        email : {
          required : true,
          maxlength : 255
        }
      }*/
    });
  });
</script>
@endpush