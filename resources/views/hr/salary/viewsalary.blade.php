@extends('layouts.adminLayout.admin_design')

@section('title', 'View Salary')
@section('content')
<style>
     .content-wrapper {
    /* min-height: 100%;*/
    }
</style>
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

            $year = !empty($year) ? $year : '';
            $month = !empty($month) ? $month : '';
            $employeeid = !empty($employeeid) ? $employeeid : '';
            $i = 0;
            $confirmdate = '';


        @endphp
        <div class="wrapper">
            <div class="content-wrapper">
               <!--  <section class="content-header">
                    <div class="row">
                        <div class="col-md-12">
                            <ol class="breadcrumb">
                                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                <li><a href="{{ route('viewsalary') }}">Salary</a></li>
                                <li class="active">View Salary</li>
                            </ol>
                        </div>
                    </div>
                </section> -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">View Salary</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row mb-5">
                                        <div class="col-md-12">
                                            <form method="post" class="form-inline" action="{{ route('searchsalary') }}">
                                                @csrf
                                                <div class="form-group">
                                                 
                                                        <select  class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
                                                           @if(!empty($employee))
                                                           <option value="">Please Select Employee</option>
                                                           @foreach($employee as $emp)
                                                                <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                   
                                                </div>
                                                <div class="form-group">
                                                   
                                                        <select  class="form-control" name="mobile" id="mobileno" placeholder="Mobileno" disabled="" style="width: 240px !important;">
                                                            <option value="">Select Mobileno</option>
                                                           @if(!empty($employee))
                                                           @foreach($employee as $emp)
                                                                <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                
                                                </div>
                                                  <div class="form-group">
                                                    
                                                        <select  class="form-control span11 select2"title="Select Month" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Month" required="" name="month" id="month" placeholder="Month">
                                                           
                                                        </select>
                                                   
                                                </div>
                                               <div class="form-group">
                                                    
                                                        <select  class="form-control span11 select2"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Year" required="" id="year" name="year" data-sear value="{{ $year }}">
                                                                <option value="">Select year</option>
                                                            @for($i = 2019; $i<=2030; $i++)
                                                                <option value="{{ $i }}" @if($i == $year) selected="" @endif>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                        @if($errors->has('year'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('year') }}</strong>
                                                      </span>
                                                      @endif
                                                 
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary bg-green">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <br/>
                                        <br/>
                                        <br/>

                                         <div class="col-md-12">
                                            <div class="box-body table-responsive no-padding">
                                            <table class="table table-responsive table-stripped">
                                                <thead>
                                                    <th>Employee Name</th>
                                                    <th>Month</th>
                                                    <th>Year</th>
                                                    <th>Actual Salary</th>
                                                    <th>Salary</th>
                                                    <th>Paid Leave</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($salary))
                                                        @foreach($salary as $salary_data)
                                                            <tr>
                                                                @php
                                                                    $fname = !empty($salary_data->employee->first_name) ? $salary_data->employee->first_name  : '';
                                                                    $lname = !empty($salary_data->employee->last_name) ? $salary_data->employee->last_name  : '';
                                                                    $emp_name = ucfirst($fname).' '.ucfirst($lname);
                                                                @endphp
                                                                <td>{{ $emp_name }}</td>
                                                                <td>{{ $salary_data->month }}</td>
                                                                <td>{{ $salary_data->year }}</td>
                                                                <td>{{ $salary_data->empsalary }}</td>
                                                                <td>{{ $salary_data->currentsalary }}</td>
                                                                <td>{{ $salary_data->paidleave }}</td>
                                                                <td>{{ $salary_data->status }}</td>
                                                                <td>
                                                                    <a class="edit"   href="{{ route('editsalary', $salary_data->salaryid) }}" title="Edit Salary"><i class="fa fa-edit"></i></a>
                                                                    <a  class="delete" href="{{ route('locksalary', $salary_data->salaryid) }}" title="Lock Salary"><i class="fa fa-lock"></i></a>
                                                                    {{-- <a href="{{ route('printsalaryslip', $salary_data->salaryid) }}" title="printsalaryslip Salary" target="_blank"><i class="fa fa-print"></i></a>                                                                </td>  --}}
                                                            </tr>
                                                        @endforeach
                                                        <div class="datarender" style="text-align: center">  {!! $salary->render() !!} </div>
                                                    @else
                                                        <tr>
                                                            <td colspan="5">No data found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
@endsection
@push('script')
<script type="text/javascript">
    $(document).ready(function(){

        $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
           }
       });



    });
</script>

<script type="text/javascript">

    $(function () {

var date = new Date();
date.setMonth(date.getMonth() );
var months = 12;
var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
var select = document.getElementById('month');
var html = '';
for (var i = 0; i < months; i++) {
  var m = date.getMonth();
  html += '<option value="' + monthNames[m] + '">' + monthNames[m] + '</option>'
  date.setMonth(date.getMonth() + 1);
}
select.innerHTML = html;


var d = new Date(),
        
    y = d.getFullYear();

$('#year option[value="'+y+'"]').prop('selected', true);
      


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