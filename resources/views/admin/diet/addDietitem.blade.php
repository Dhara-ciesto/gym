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
    
     
<!--          <section class="content-header"><h2>Add Diet Item</h2></section>
 -->          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Item</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">


              <form role="form" action="{{ url('addDietitem') }}" method="post" id="dietitemform" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                 <label>DietItem<span style="color: red">*</span></label>

                  <input type="text" class="form-control" value="{{ old('dietitem') }}" maxlength="255" name="dietitem"  placeholder="Diet Item">
                  @if($errors->has('dietitem'))
                    <span class="help-block">
                      <strong>{{ $errors->first('dietitem') }}</strong>
                    </span>
                  @endif

  
                </div>
               
              

                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Save</button></div>   <div class="col-sm-6"> <a href="{{ url('viewDietitem') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
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