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
    <div class="box-body">
      <div class="col-lg-3"></div>
        <div class="col-lg-6">
          <form role="form" action="{{ url('editExercise/'.$exercise->exerciseid) }}"  method="post" id="exercise_form">
            {{ csrf_field() }}
                <!-- text input -->
            <div class="form-group">
              <label>Exercise</label>
              <input type="text" class="form-control" @if(old('exercisename') != null) value="{{ old('exercisename') }}" @else value="{{$exercise->exercisename}}" @endif name="exercisename" required placeholder="Exercise" >
              @if($errors->has('exercisename'))
              <span class="help-block">
              <strong>{{ $errors->first('exercisename') }}</strong>
              </span>
              @endif
          </div>
          <div class="form-group">
            <label>Video Link</label>
            <input type="text" class="form-control" @if(old('videoname') != null) value="{{ old('videoname') }}" @else value="{{$exercise->videoname}}" @endif name="videoname" required placeholder="Video Name" >
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3">
              <button type="submit" class="btn bg-green margin">Update</button>
                <a href="{{ url('viewExercise') }}"class="btn bg-red margin">Cancel</a>
            </div>
          </div>
            <!-- Select multiple-->
          </form>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#exercise_form').validate({
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