@extends('layouts.adminLayout.admin_design')

@section('title', 'View Employee Leave')

@section('content')
<?php $permission = unserialize(session()->get('permission')); ?>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<style type="text/css">

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
        @php

            $employeeid = !empty($employeeid) ? $employeeid : '';

        @endphp
<div class="wrapper">
    <div class="content-wrapper">
       <!--  <section class="content-header">
           <div class="row">
                <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{ route('viewemployeeleave') }}">Employee Leave</a></li>
                    <li class="active">Edit Employee Leave</li>
                </ol>
                </div>
            </div>
        </section> -->
        <section class="content">
            @if ($message = Session::get('message'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
               <strong>{{ $message }}</strong>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
               <strong>{{ $message }}</strong>
            </div>
            @endif
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">View Employee Leave</h3>

                            <div class="" style="float: right;">

                                @if(isset($permission["'add_employee_leave'"]))
                                <a href="{{ route('addleave') }}" class="btn btn-primary bg-orange" title="Add Working days">Add Leave</a></div>
                            @endif
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row" style="margin-left: 0px !important; ">

                                    <form method="post" class="form-inline" action="{{ route('viewleaveentry') }}">
                                    @csrf
                                    <div class="form-group">
                                        {{-- <label>Employee<span style="color: red;">*</span></label> --}}
                                        <select  class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" placeholder="Please Select Employee" name="employeeid" id="employeeid" data-sear>
                                        @if(!empty($employee))
                                        <option value="">Please Select Employee</option>
                                        @foreach($employee as $emp)
                                        <option value="{{ $emp->employeeid }}" @if($employeeid == $emp->employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        @if($errors->has('employeeid'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('employeeid') }}</strong>
                                    </span>
                                    @endif
                                    </div>

                                    <div class="form-group">
                                    {{--  <label>Mobile No<span style="color: red;">*</span></label> --}}
                                    <select  class="form-control" disabled="" id="mobileno">
                                        @if(!empty($employee))
                                        <option value="">Select Mobile No</option>
                                        @foreach($employee as $emp)
                                        <option value="{{ $emp->employeeid }}"  @if($employeeid == $emp->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span id="leave_error" style="color: red;display: none;">Please add employee leave</span>
                                    </div>

                                    <div class="form-group">
                                        {{-- <label>Employee<span style="color: red;">*</span></label> --}}
                                        <select  class="form-control span11 select2"title="Select Status"  data-placeholder="Please Select Status" name="status" id="employeeid" >
                                        <option value="">Please Select Status</option>
                                        <option value="Pending" @if($request->status == "Pending") selected="" @endif>Pending</option>
                                        <option value="Approve" @if($request->status == "Approve") selected="" @endif>Approved</option>
                                        <option value="Reject" @if($request->status == "Reject") selected="" @endif>Rejected</option>
                                        </select>
                                        @if($errors->has('employeeid'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('employeeid') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary bg-green">Search</button>
                                    </div>
                                    <div class="form-group">
                                        <a href="{{ url('viewleaveentry')}}" class="btn btn-primary bg-red">Clear</a>
                                    </div>
                                </form>

                            </div>
                            <br/>
                            <form method="post" class="form-inline" action="{{ route('changeleavestatus') }}">
                            @csrf
                            <div class="box-body table-responsive no-padding">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th># <input type="checkbox" onchange="if($(this).prop('checked')==true){$('.leaveid').prop('checked',true)}else{$('.leaveid').prop('checked',false)}" ></th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Leave Date</th>
                                            <th>Leave Type</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($employeeleave))
                                            @foreach($employeeleave as $key => $employee)
                                                <tr>
                                                        <td><label>{{ $key+1 }} @if( $employee->status == 'Pending')<input type="checkbox" name="leaveid[]" id="leaveid{{$key}}" class="leaveid" value="{{$employee->leaveentryid}}" > @endif</label></td>
                                                    @php

                                                        $fname = !empty($employee->empname->first_name) ? $employee->empname->first_name : '';
                                                        $lname = !empty($employee->empname->last_name) ? $employee->empname->last_name : '';

                                                    @endphp
                                                     <td>{{ date('d-m-Y', strtotime($employee->created_at)) }}</td>
                                                    <td>{{ $fname }} {{ $lname }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($employee->date)) }}</td>
                                                    <td>{{ $employee->leavetype  ==  "Cl" ? 'Casual Leave': ($employee->leavetype  ==  "Ml" ? 'Medical Leave': 'Paid Leave' )   }}</td>
                                                    <td>{{ $employee->status }}</td>
                                                    <td>{{ $employee->reason }}</td>
                                                    <td>
                                                        @if( $employee->status == 'Pending')
                                                        <a style="color:green"; href="{{ route('approveleave', $employee->leaveentryid) }}" title="Approve"><i class="fa fa-check"></i></a>
                                                        <a style="color:red"; href="{{ route('rejectleave', $employee->leaveentryid) }}" title="Reject"><i class="fa fa-times"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="approveall" class="btn btn-primary bg-green"><i class="fa fa-check"></i></button>
                                <button type="submit" name="rejectall" class="btn btn-primary bg-red"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="form-group">
                            </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function (){
        $('#example1').DataTable({
            "lengthMenu": [[7, 10, 15, -1], [7, 10, 15, "All"]]
        });
    });
</script>
@endsection
@push('script')
<script type="text/javascript">

    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })

      //iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
      })
      //Red color scheme for iCheck
      $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
      })
      //Flat red color scheme for iCheck
      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
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
  </script>
<script type="text/javascript">

  function myFunction() {
      if(!confirm("Are You Sure to Delete Details ?"))
      event.preventDefault();
  }

    $(document).ready(function(){

        $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
            }
        });

    });
</script>
@endpush
