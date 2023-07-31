@extends('layouts.adminLayout.admin_design') @section('title', 'View Amount') @section('content')
<style type="text/css">
.select2 {
	width: 100% !important;
}

.select2-container--default .select2-selection--single {
	border-radius: 2px !important;
	max-height: 100% !important;
	border-color: #d2d6de !important;
	height: 32px;
	max-width: 100%;
	min-width: 100% !important;
}
</style> @php $employeeid = !empty($empid) ? $empid : ''; @endphp
<div class="content-wrapper">

	<div class="container-fluid">
		<hr> @if ($message = Session::get('message'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong> </div> @endif
		<div class="table-wrapper">
			<div class="table-title">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">View Loan</h3>
						<div class="" style="float: right;"><a href="{{ route('employeeaccount') }}" class="btn btn-primary bg-orange" title="Add Working days">Add Loan</a></div>
           
           
          </div>
					<!-- /.box-header -->
					<div class="box-body">
           
						<div class="row" style="margin-left: 0px !important;">
							<form method="post" class="form-inline" action="{{ route('searchemployeeaccount') }}"> @csrf
								<div class="form-group">
									<select class="form-control span11 select2" title="Select Employee" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear> @if(!empty($employee))
										<option value="">Select Employee</option> @foreach($employee as $emp)
										<option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option> @endforeach @endif </select>
								</div>
								<div class="form-group">
									<select class="form-control" name="mobile" id="mobileno" placeholder="Mobileno" disabled="" style="width: 240px !important;">
										<option value="">Select Mobileno</option> @if(!empty($employee)) @foreach($employee as $emp)
										<option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ $emp->mobileno }}</option> @endforeach @endif </select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary bg-green">Submit</button>
								</div>
							</form>
						</div>
						<br/>
            <div >
				@if($pendingamt)
              <h5><b> Pending amount : {{$pendingamt}}</b></h5>
			  @endif
              </div>
              <br>
						<div class="row" style="margin-left: 0px !important;margin-right: 0px !important;">
							<div class="col-md-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Total Amount</th>
                      <th>Paid Amount</th>
                      <th>Due Amount</th>
                      <th>Date</th>
                      <th>Remarks</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    
                    @if(!empty($loan))
                    @foreach($loan as $value)
                    <tr>
                      <td>{{ ucfirst($value->type) }}</td>
                      <td>{{ $value->total_amount }}</td>
                      <td>{{ $value->paid_amount }}</td>
                      <td>{{ $value->due_amount }}</td>
                      <td>{{ date('d-m-Y', strtotime($value->loan_date)) }}</td>
                      <td>{{ $value->remark }}</td>
						<td><a href="#" data-toggle="modal" onclick="getloandetail('{{$value->hr_loan_id}}')" data-target="#viewloandetail"><i class="fa fa-eye"></i></a></td>
                    </tr>
                    @endforeach
					@else
                    <tr>
                      <td colspan="7">No Data Found</td>
                    </tr> 
                    @endif 
                  </tbody>
                </table>
              </div>
             
						</div>
						<!-- /.box-body -->
          
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
	</div>
</div>
<script>
	function getloandetail(loanid){
		$('#loandetaildiv').empty();
		$.ajax({
			url: "{{ url('ajaxgetpendingloandetail') }}",
			method: "POST",
			data: {loanid: loanid, "_token": "{{ csrf_token() }}"},
			success: function (data) {
				html = '';
				if(data.length > 0) {
					$.each(data, function (i, item) {
						if(item.type=='Debit'){
						bgcolor = '#ec6666'; //red
						}else{
						bgcolor = 'lightgreen';
						}
						html += '<tr>';
						html += '<td style="background-color: '+bgcolor+'">' + item.type + '</td>';
						if(item.salary_id !='' && item.salary_id!=null){
						html += '<td style="background-color: '+bgcolor+'">Salary</td>';
						}else{
						html += '<td style="background-color: '+bgcolor+'">Manually</td>';
						}
						html += '<td style="background-color: '+bgcolor+'">' + item.amount + '</td>';
						html += '<td style="background-color: '+bgcolor+'">' + item.created_at + '</td>';
						html += '</tr>';
					});
				}
				$('#loandetaildiv').append(html);
			},
			dataType: "json"
		});
	}
</script>
<div id="viewloandetail" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Loan Detail</h4>
			</div>
			<div class="modal-body" style="overflow-y: auto">
				<table class="table table-striped table-bordered">
					<thead>
					<tr>
						<td>Type</td>
						<td>From</td>
						<td>Amount</td>
						<td>Date</td>
					</tr>
					</thead>
					<tbody id="loandetaildiv">

					</tbody>
					<tfoot>

					</tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
</section> @endsection @push('script')
<script type="text/javascript">
$(document).ready(function() {
	$('#employeeid').change(function() {
		let empid = $(this).val();
		if(empid) {
			$('#mobileno option[value=' + empid + ']').prop('selected', true);
		}
	});
});
</script>
<script type="text/javascript">
$(function() {
	//Initialize Select2 Elements
	$('.select2').select2()
		//Datemask dd/mm/yyyy
	$('#datemask').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		})
		//Datemask2 mm/dd/yyyy
	$('#datemask2').inputmask('mm/dd/yyyy', {
			'placeholder': 'mm/dd/yyyy'
		})
		//Money Euro
	$('[data-mask]').inputmask()
		//Date range picker
	$('#reservation').daterangepicker()
		//Date range picker with time picker
	$('#reservationtime').daterangepicker({
			timePicker: true,
			timePickerIncrement: 30,
			format: 'MM/DD/YYYY h:mm A'
		})
		//Date range as a button
	$('#daterange-btn').daterangepicker({
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().subtract(29, 'days'),
			endDate: moment()
		}, function(start, end) {
			$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
		})
		//Date picker
	$('#datepicker').datepicker({
			autoclose: true
		})
		//iCheck for checkbox and radio inputs
	$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		})
		//Red color scheme for iCheck
	$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
			checkboxClass: 'icheckbox_minimal-red',
			radioClass: 'iradio_minimal-red'
		})
		//Flat red color scheme for iCheck
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		})
		//Colorpicker
	$('.my-colorpicker1').colorpicker()
		//color picker with addon
	$('.my-colorpicker2').colorpicker()
		//Timepicker
	$('.timepicker').timepicker({
		showInputs: false
	})
})
</script> @endpush