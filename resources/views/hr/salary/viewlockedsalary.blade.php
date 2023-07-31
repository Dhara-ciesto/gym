@extends('layouts.adminLayout.admin_design')
@section('title', 'Locked Salary')

@section('content')

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
                <li><a href="{{ route('viewlockedsalary') }}">Salary</a></li>
                <li class="active">View Locked Salary</li>
              </ol>
            </div>
            </div> -->
        </section>

        <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Locked  Salary Detail</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row mb-5">
                                        <div class="col-md-12">
                                            <form method="get" class="form-inline" action="{{ route('viewlockedsalary') }}">
                                                @csrf
                                                <div class="form-group">

                                                        <select  class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" name="employeeid" id="employeeid" data-sear>
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

                                                        <select  class="form-control span11 select2"title="Select Month" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Month" required="" name="month" placeholder="Month">
                                                            <option value="All" selected>All</option>
                                                            @foreach($months as $month)
                                                                <option value="{{$month}}" @if(isset($_GET['month']) && $month==$_GET['month']) selected @endif>{{$month}}</option>
                                                            @endforeach

                                                        </select>

                                                </div>
                                                  <div class="form-group">

                                                        <select  class="form-control span11 select2"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Year" required="" id="year" name="year[]" data-sear multiple>
                                                                <option value="">Select year</option>
                                                            @for($i = 2019; $i<=2030; $i++)
                                                                <option value="{{ $i }}"  @if(isset($_GET['year']) && in_array($i,$_GET['year'])) selected @endif>{{ $i }}</option>
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
                                                    <a href="{{ route('viewlockedsalary') }}" class="btn btn-default ">Clear</a>
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
                                                    <th>EMI</th>
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
                                                                <td>{{ $salary_data->salaryemi }}</td>
                                                                @if($salary_data->ispaid != 1)
                                                                <td>{{ $salary_data->status }}</td>
                                                                @else
                                                                <td>Paid</td>

                                                                @endif
                                                                <td>
                                                                    @if($salary_data->ispaid != 1)
                                                                    <a href="{{ route('unlocksalary', $salary_data->salaryid) }}" title="Edit Salary" class="btn btn-success">Unlock</a>
                                                                    <a class="btn btn-danger" id="pay" onclick="account('{{$salary_data->employee->accountno}}', '{{$salary_data->paymenttype}}', '{{$salary_data->remark2}}',
                                                                    '{{$salary_data->Chequenofield}}','{{ $emp_name }}', '{{ $salary_data->employee->employeeid }}', '{{ $salary_data->salaryid }}','{{$salary_data->currentsalary}}')" data-toggle="modal" data-target="#accountmodel">Pay</a>
                                                                    @else
                                                                    <a href="{{ url('printsalaryslip/'.$salary_data->salaryid) }}" class="" target="_blank"><i class="fa fa-print"></i></a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5">No data found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            @if(!empty($salary))
                                            <center>{{ $salary->render()  }}</center>
                                            @endif
                                        </div>
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
<div class="modal fade" id="accountmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Employee Name</label>
                    <input type="hidden" name="empid" id="empid">
                    <input type="hidden" name="salaryid" id="salaryid">
                    <input type="text" name="empname" id="empname" class="form-control" readonly="">
                </div>
                <div class="form-group">
                    <label>Account No</label>
                    <input type="text" name="accountno" id="accountno" class="form-control" readonly="">
                </div>
                                                        @if(!empty($salary_data->currentsalary))

                <div class="form-group">
                    <label>Final Amount</label>
                    <input type="text" name="currentsalary" id="currentsalary" value="{{ $salary_data->currentsalary }}" class="form-control" readonly="">
                </div>
                @endif
                  <div class="form-group">
                    <label>Mode of Payment
                    <span style="color: red">*</span>
                    </label>
                    <br>
                    <input type="radio" name="paymenttype"  value="Cash" class="paymenttype">
                    <label>Cash</label>
                     <input type="radio"    name="paymenttype"
                       value="Cheque"
                       class="paymenttype">


                    <label>Cheque </label>

                    <input type="radio"  name="paymenttype" value="Bank" class="paymenttype">
                    <label>Bank</label>
                    <input type="radio"  name="paymenttype" value="Credit Card" class="paymenttype">
                    <label>Credit Card </label>

                 </div>
                  <div  id="Chequeno" style="display: none"  class="form-group">
                   <input type="text" id="Chequenofield"  name="Chequenofield" hidden="true" class="form-control number "autocomplete="off" placeholder="Enter Cheque Number" class="span11" maxlength="20" />
                 </div>
                   <div class="form-group">
                 <label>Remarks</label>
                                            <textarea name="remark2" class="form-control"  placeholder="Remarks"></textarea>

                                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="pay_emp">Pay</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('script')
<script type="text/javascript">
        $('input[name="paymenttype"]').on('click', function() {
      // alert($(this).val());
        if ($(this).val() == 'Cheque') {
            $('#Chequeno').show();
             $('#Chequenofield').attr('required',true);
            // $('#bankname').show();
        }
        else {
            $('#Chequeno').hide();
            $('#Chequenofield').attr('required',false);
            $('#bankname').hide();
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
           }
       });

        $('#pay_emp').click(function(){
            let accountno = $('#accountno').val();
                        let Chequeno = $('#Chequenofield').val();

            var paymenttype = $(".paymenttype:checked").val();
            let empname = $('#empname').val();
             var remark2 =$('textarea').val()


            let empid = $('#empid').val();
            let salaryid = $('#salaryid').val();

            $.ajax({

                type : 'POST',
                url : '{{ route('confirmsalary') }}',
                data : {accountno:accountno,Chequeno:Chequeno,paymenttype:paymenttype,remark2:remark2, empname:empname, empid:empid, salaryid:salaryid, _token : '{{ csrf_token() }}'},
                success : function(data){
                    if(data == 201){
                        //  alert(paymenttype);
                        alert('Salary is paid');
                        window.location.href = '';
                    }else{
                        alert('Salary is not paid, Something went wrong!');
                    }
                }
            });

        });

    });

    function account(account,paymenttype,remark2,Chequenofield,empname, empid, salaryid,salary){
        $('#accountmodel #accountno').val(account);
          $('#accountmodel #paymenttype').val(paymenttype);
                    $('#accountmodel #remark2').val(remark2);
                    $('#accountmodel #Chequenofield').val(Chequenofield);
                    $('#currentsalary').val(salary);

        $('#accountmodel #empname').val(empname);
        $('#accountmodel #empid').val(empid);
        $('#accountmodel #salaryid').val(salaryid);
    }
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
$(select).html(html);


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
@endpush
