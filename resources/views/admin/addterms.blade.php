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
   
     
<!--          <section class="content-header"><h2>Add Terms</h2> </section>
 -->          <!-- general form elements -->
           <section class="content ">
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
              <h3 class="box-title">Add Terms</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('addterms') }}" method="post" id="term_form" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Terms<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="Terms" id="Terms" value="{{ old('Terms') }}" required placeholder="Enter Terms" maxlength="18"
                  @if($errors->has('Terms'))
                    <span class="help-block">
                      <strong>{{ $errors->first('Terms') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Credit into Minute<span style="color: red">*</span></label>
                  <input type="text"  class="form-control number" maxlength="10" value="{{ old('Minutes') }}"  name="Minutes" placeholder="Enter Credit into Minute" required>
                  @if($errors->has('Minutes'))
                    <span class="help-block">
                      <strong>{{ $errors->first('Minutes') }}</strong>
                    </span>
                  @endif
                <!--  <textarea class="form-control" rows="3"  name="Minuts" required placeholder="Enter Minuts"></textarea> -->
                </div>
                <div class="form-group">
                <label>Appointment is required ?</label>
                 <select name="Appointment" class="form-control">
                   <option value="0"selceted>No</option>
                   <option value="1">Yes</option>
                  
                 </select>
               </div>

                         <div class="form-group">   <div class="col-sm-offset-3">
   <div class="col-sm-8">
      <button name="submit" type="submit" class="btn bg-green margin">Save</button>   <a href="{{ url('terms') }}"class="btn btn-danger">Cancel</a></div></div>
  
  </div>
                <!-- Select multiple-->
        

              </form></div><div class="col-lg-3"></div></div>
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
    $('#term_form').validate({
      rules: {
        Terms : {
          required : true,
          maxlength : 255
        },
        email : {
          required : true,
          maxlength : 255
        }
      }
    });
  });
</script>
@endpush