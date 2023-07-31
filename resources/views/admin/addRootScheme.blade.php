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
   
     
<!--          <section class="content-header"><h2>Add Root Scheme</h2> </section>
 -->          <!-- general form elements -->
           <section class="content ">
           
            <!--               @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif -->

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Root Scheme</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('addrootscheme') }}" method="post" id="root_scheme_form">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Scheme Name<span style="color: red">*</span></label>
                  <input type="text" class="form-control" value="{{ old('scheme_name') }}" name="scheme_name" id="scheme_name" required placeholder="Enter Scheme Name">
                  @if($errors->has('scheme_name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('scheme_name') }}</strong>
                    </span>
                  @endif

                </div>
                <div class="form-group">
                  <label>Description<span style="color: red">*</span></label>
                 <textarea class="form-control" rows="3"  name="description" id="description" required placeholder="Enter Descrription">{{ old('description') }}</textarea>
                 @if($errors->has('description'))
                  <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                  </span>
                @endif

                </div>

                         <div class="form-group">   <div class="col-sm-offset-3">
   <div class="col-sm-8">
      <button name="submit" type="submit" class="btn bg-green margin">Save</button>   <a href="{{ url('rootschemes') }}"class="btn btn-danger">Cancel</a></div></div>
  
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
    $('#root_scheme_form').validate({
      rules: {
        scheme_name : {
          required : true,
          maxlength : 255
        },
        description : {
          required : true,
          maxlength : 255
        }
      }
    });
  });
</script>
@endpush
