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
              <h3 class="box-title">Edit Workout</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('editWorkout/'.$workout->workoutid) }}"  method="post">
                 {{ csrf_field() }}
                <!-- text input -->
               <div class="form-group">
                  <label>Workout<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="workoutname" required placeholder="Workout" value="{{$workout->workoutname}}">
                  @if($errors->has('workoutname'))
                    <span class="help-block">
                      <strong>{{ $errors->first('workoutname') }}</strong>
                    </span>
                  @endif

  
                </div>
           
                  <div class="form-group">
                <div class="col-sm-offset-3">
              
         <button type="submit" class="btn bg-orange margin">
         Update</button>
         <a href="{{ url('viewWorkout') }}"class="btn bg-red margin">Cancel</a>
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