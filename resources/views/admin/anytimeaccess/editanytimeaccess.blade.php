@extends('layouts.adminLayout.admin_design')
@section('content')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
@endpush
<style type="text/css">
		.content-wrapper{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     	
     </section>
      <section class="content">
      <!-- Info boxes -->
     	 <div class="row">
     	 	<div class="col-md-12">
     	 		<div class="row">
     	 			<div class="box box-info">
     	 				 <div class="box-header with-border">
			              <h3 class="box-title">Edit Access Cards</h3>

			              <div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                </button>
			                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			              </div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
			            	<form action="{{url('editanytimeaccesscard/'.$belt->	anytimeaccessbeltid)}}" method="post">
			            		{{csrf_field()}}
			            		<div class="col-lg-3"></div>
			            		<div class="col-lg-6">
									<div class="form-group">
						               	<label>Access Card</label>
						              	 <input type="text" name="beltno" readonly id="beltno" class="form-control number" placeholder="Enter Access Card No/Name" class="span11" required="" maxlength="15" value="{{ $belt->beltno }}" /><span id="error_username"></span>
						              	  @if($errors->has('beltno'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('beltno') }}</strong>
						                    </span>
						                  @endif
					            	</div>
					            	<div class="form-group">
						               	<label>Validity</label>
						              	 <input type="date" name="validity" id="validity" onkeypress="return false" min="<?php echo date('Y-m-d')?>" class="form-control" placeholder="RFID No" class="span11" required=""value="{{ $belt->validity }}" />
						              	  @if($errors->has('validity'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('validity') }}</strong>
						                    </span>
						                  @endif
					            	</div>
					            	<!-- <div class="form-group">
						               	<label>RFID No</label>
						              	 <input type="text" name="rfidno" id="rfidno" class="form-control" maxlength="15" placeholder="RFID No" class="span11" required=""value="{{ $belt->rfidno }}" />
						              	 @if($errors->has('rfidno'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('rfidno') }}</strong>
						                    </span>
						                  @endif
					            	</div> -->
					            	<div class="form-group">
						               <center>
						              	<button type="submit" class="btn bg-green margin">Update</button>
						              	<a href="{{url('viewanytimeaccesscard')}}" class="btn bg-red ">Cancel</a>
						              
						              	</center>
					            	</div>
					            </div>
					            <div class="col-lg-3"></div>
			            	</form>
			            </div>
			        </div>
     	 			
     	 	</div>
     	 </div>
    </section>
</div>

@endsection