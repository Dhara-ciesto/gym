@extends('layouts.adminLayout.admin_design')

@section('content')
 <div class="content-wrapper">
   
     
         <section class="content-header"></section>
          <!-- general form elements -->
           <section class="content">
         
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Edit Tag</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
          <form role="form" action="{{url('editExerciseLevel/'.$exerciselevel->exerciselevelid) }}"  method="post">
                 {{ csrf_field() }}
                <!-- text input -->
               <div class="form-group">
                  <label>Exercise Tag</label>
                  <input type="text" class="form-control" name="exerciselevel" required placeholder="Exercise" value="{{$exerciselevel->exerciselevel}}">
                  @if($errors->has('exerciselevel'))
                  <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('exerciselevel') }}</strong>
                  </span>
                  @endif
  
                </div>
                
               
           

                  <div class="form-group">
                <div class="col-sm-offset-3">
              
         <button type="submit" class="btn bg-green margin">
         Update</button>
         <a href="{{ url('viewExerciseLevel') }}"class="btn bg-red margin">Cancel</a>
        </div>
                

              </form></div>
            </div>
            <!-- /.box-body -->
          </div>
      
  </section>
</div>
</div>
</div>
@endsection