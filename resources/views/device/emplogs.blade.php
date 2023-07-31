@extends('layouts.adminLayout.admin_design')

@section('title', 'View Employee')

@push('css')

 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
 <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

<style type="text/css">
	.form-group col{
		padding: 15px;
	}
	label {
		display:block;
	}

   .select2{
   width: 100% !important;
   }
   .select2-container--default .select2-selection--single{
   border-radius: 2px !important;
   max-height: 100% !important;
   border-color: #d2d6de !important;
   height: 32px;
   max-width: 100%;
   min-width: 100% !important;
   }
</style>
@endpush

@section('content')

<div class="wrapper">
    <div class="content-wrapper">
		<!-- <section class="content-header">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li><a href="{{ route('emplog') }}">Log</a></li>
						<li class="active">View Employee Log</li>
					</ol>
				</div>
			</div>
		</section> -->
		<?php ?>
		  <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Employee Log</h3>
                          
                        </div>
						 <div class="box-body">
                            <div class="row">                               

                                <div class="col-md-12">
                                        @csrf
                                             <div class="col-md-2">

                                            <div class="form-group col">
                                        <label>Employee:</label>
                                        <select  class="form-control select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  placeholder="Select Employee" required="" name="employeeid" id="employeeid" data-search="true">
                                            @if(!empty($employee))
                                                                                    <option value="">Select Employee</option>

                                            @foreach($employee as $emp)
                                            <option value="{{ $emp->employeeid }}">{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
                                            @endforeach
                                            @else
                                            <option value="">No Employee available</option>
                                            @endif
                                        </select>

                                    </div>
                                </div>

                                             <div class="col-md-3">

                                        <div class="form-group col">
                                        <label>Mobile No:</label>
                                        <select  class="form-control" name="mobile" id="mobileno" placeholder="Mobileno" disabled="" style="width: 240px !important;">
                                            <option value="">Select Mobileno</option>
                                            @if(!empty($employee))
                                            @foreach($employee as $emp)
                                            <option value="{{ $emp->employeeid }}" >{{ $emp->mobileno }}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>
                          
                                                            <div class="col-md-3">

                                    <div class="form-group col">
                                        <label>From Date:</label>
                                        <input type="date" name="fromdate" id="fromdate" class="form-control" >

                                    </div>
                                </div>

                                       <div class="col-md-3">

                                    <div class="form-group col">
                                        <label>To Date:</label>
                                        <input type="date" name="todate" id="todate" class="form-control">

                                    </div>
                                </div>

                                      <div class="col-md-1">
                                        <div class="form-group col" >
                                        <button id="submit" class="btn btn-primary bg-green" style="margin-top: 25px;">Submit</button>
                                    </div>
                                    </div>
															</div>




                                </div>
                            </div>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-responsive table-hover" id="emp_table">
										<thead>
											<tr>
												<th>Name</th>
												<th>Mobile No</th>
												<th>Date</th>
												<th>Timein1</th>
												<th>Timeout1</th>
												<th>Timein2</th>
												<th>Timeout2</th>
												<th>Timein3</th>
												<th>Timeout3</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>		
						
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>			




<script type="text/javascript">
	$(document).ready(function(){

		$('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
           }
       });

		$('#submit').click(function(){
			$('#emp_table').DataTable({
				processing: true,
				serverSide: true,
				destroy: true,
				ajax: {
					url: "{{ route('emplogajax') }}",
					data : function(d){
						d.employeeid = $('#employeeid').val(),
						d.fromdate = $('#fromdate').val(),
						d.todate = $('#todate').val()
					}
				},
				columns: [
				{data: 'fullname', name: 'fullname'},
				{data: 'mobileno', name: 'mobileno'},
				{data: 'dateid', name: 'dateid'},
				{data: 'timein1', name: 'timein1'},
				{data: 'timeout1', name: 'timeout1'},
				{data: 'timein2', name: 'timein2'},
				{data: 'timeout2', name: 'timeout2'},
				{data: 'timein3', name: 'timein3'},
				{data: 'timeout3', name: 'timeout3'},
				]
			});
		});





	});
</script>


<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
  
  })
</script>

@endpush