@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
		.content-wrapper{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
	td{
		border:2px;
		border-color: gray;
	}
	.page-item{
		background-color: #f39c12!important;
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
			              <h3 class="box-title">View Access Cards</h3>

			              <div class="box-tools pull-right">
			                <?php $permission = unserialize(session()->get('permission')); ?>
			                @if(isset($permission["'add_anytimeaccess'"]))
			                	 <a href="{{ url('addanytimeaccesscard') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i>Add New</a>
			               	@endif
			              </div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
					     <div class="table-responsive">
		                <table class="table no-margin">
		                  <thead>
		                  <tr>
		                  	<th>Access card</th>
		                    <th>Validity</th>
		                    <th>Status</th>
		                    <th>Action</th>
		                    
		                  </tr>
		                  </thead>
		                  <tbody>
		     					
		                  	@if(count($belts)>0)

		                  	@foreach($belts as $belt)
		                  	<tr @if($belt->beltstatus != 'free' || $belt->validity < date('Y-m-d')) style="color:red" @endif>
		                  		
		                  	
		                  		<td>{{$belt->beltno}}</td>
		                  		<!-- <td>{{$belt->rfidno}}</td> -->
		                  	<td>{{date('d-m-Y', strtotime($belt->validity)) }}</td>
		                  		<td>{{ucfirst($belt->beltstatus)}}</td>
		                  		 
		                  		 @if(isset($permission["'edit_anytimeaccess'"]))
		                  		<td style="background-color: white;"> <a href="{{ url('editanytimeaccesscard/'.$belt->anytimeaccessbeltid) }}" class="edit" title="Edit"><i class="fa fa-edit"></i></a></td>
		                  		@endif

		                  		<!-- @if($belt->enrollstatus == 1)
		                  		<td><a href="#" style="color: red;" title="Belt Already Enroll in Device"><i class="fa fa-universal-access"></i></a></td>
		                  		@else
		                  		<td><a href="#" class="info" title="Belt Not Enroll Into Device"><i class="fa fa-universal-access"></i></a></td>
		                  		@endif -->
		                  	
		                  		
		                  	</tr>
		                  		@endforeach
		                  		@else
		                  		<tr><td colspan="8" style="text-align: center">{{ 'No Data Found'}}</td></tr>
		                  		@endif
		                  	
		                  </tbody>
		                </table>
		                    <div class="datarender" style="text-align: center">
		            {!! $belts->render() !!}  </div>
		              </div>
			            </div>
			        </div>
     	 			
     	 	</div>
     	 </div>
    </section>
</div>

@endsection