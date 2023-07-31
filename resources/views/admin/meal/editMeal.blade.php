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

    @if (session()->has('success'))
    <h1>{{ session('success') }}</h1>
@endif

  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Edit Meal</h2></section>
 -->          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Edit Meal</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">

              <form role="form" action="{{ url('editMeal/'.$meal->mealmasterid) }}" method="post" id="editmealform" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                 <label>Meal<span style="color: red">*</span></label>

                  <input type="text" class="form-control" value="{{$meal->mealname }}" maxlength="255" name="mealname"  placeholder="Meal">
                  @if($errors->has('mealname'))
                    <span class="help-block">
                      <strong>{{ $errors->first('mealname') }}</strong>
                    </span>
                  @endif

  
                </div>
               
                <div class="form-group">
               
               <div class="col-sm-6">
                <button type="submit" class="btn bg-green btn-block">
                 Save</button></div>   <div class="col-sm-6"> <a href="{{ url('viewMeal') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
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
    $('#editmealform').validate({
    
    });
  });
</script>
@endpush