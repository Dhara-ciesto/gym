@extends('layouts.adminLayout.admin_design')

@section('title', 'Add Employee Leave')

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
                    <li><a href="{{ route('viewemployeeleave') }}">Employee Leave</a></li>
                    <li class="active">Add Employee Leave</li>
                </ol>
                </div>
            </div>
        </section> -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add Employee Leave</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                            <form action="{{ route('employeeleave') }}" method="post" id="workingdays">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Employee<span style="color: red;">*</span></label>
                                                <select  class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
                                                    @if(!empty($employee))
                                                    <option value="">Please select Employee</option>
                                                    @foreach($employee as $emp)
                                                    <option value="{{ $emp->employeeid }}" @if(old('employeeid') == $emp->employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
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
                                                <label>Mobile No<span style="color: red;">*</span></label>
                                                <select  class="form-control" disabled="" id="mobileno">
                                                    @if(!empty($employee))
                                                    <option value="">Select Mobile No</option>
                                                    @foreach($employee as $emp)
                                                    <option value="{{ $emp->employeeid }}"@if(old('employeeid') == $emp->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <span id="leave_error" style="color: red;display: none;">Please add employee leave</span>
                                            </div>

                                                <div class="form-group">
                                                    <label>Type<span style="color: red;">*</span></label>
                                                    <select class="form-control" id="leavetype" onchange="calremainleave(this.value)" placeholder="Select Leave Type" name="leavetype" required="">
                                                        <option value="">Select Leave Type</option>
                                                        <option value="Cl" @if(old('leavetype') == 'Cl') selected="" @endif>Casual Leave</option>
                                                        <option value="Ml" @if(old('leavetype') == 'Ml') selected="" @endif>Medical Leave</option>
                                                        <option value="Pl" @if(old('leavetype') == 'Pl') selected="" @endif>Paid Leave</option>
                                                        <option value="Hl" @if(old('leavetype') == 'Hl') selected="" @endif>Half Leave</option>
                                                    </select>
                                                    @if($errors->has('leavedate'))
                                                        <span class="help-block">
                                                <strong>{{ $errors->first('leavedate') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                            <div class="form-group">
                                                <label>From Date<span style="color: red;">*</span></label>
                                                <input type="date" name="fromdate" onchange="leavecalcalcution()" id="fromdate" class="form-control" required="" value="{{ old('fromdate') }}">
                                                @if($errors->has('fromdate'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('fromdate') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>To Date<span style="color: red;">*</span></label>
                                                    <input type="date" name="todate" onchange="leavecalcalcution()" id="todate" class="form-control" required="" value="{{ old('todate') }}">
                                                    @if($errors->has('todate'))
                                                        <span class="help-block">
                                                <strong>{{ $errors->first('todate') }}</strong>
                                                </span>
                                                    @endif
                                            </div>
                                                <div class="form-group">
                                                    <label >Total Number of Days</label>
                                                        <input type="text" name="totalleave" id="totalleave" class="form-control" readonly value="" required>
                                                </div>


                                            <div class="form-group">
                                                <label>Reason</label>
                                                <textarea name="reason" class="form-control">{{ old('reason') }}</textarea>
                                                @if($errors->has('reason'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('reason') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <button type="submit" class="btn btn-primary bg-green" id="submit">Save</button>
                                            <a href="{{ route('viewworkingdays') }}" class="btn btn-danger">Cancel</a>
                                        </form>
                                    </div>
                                    <div class="col-md-3"></div>
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
    function  calremainleave(leavemasterid){
        var half=0;

        if(leavemasterid == 'Hl'){
           half=1;
        }

        console.log(leavemasterid);
        if(half==1){
            $('#fromdate').prop('value','<?php echo date('d-M-Y') ?>')
            $('#fromdate').attr('onchange',"$('#todate').val(this.value)");
            $('#todate').prop('value','<?php echo date('d-M-Y') ?>')
            $('#todate').attr('onchange',"$('#fromdate').val(this.value)");
            $('#totalleave').prop('value','0.5');
        }else{
            $('#fromdate').prop('value','')
            $('#fromdate').attr('onchange',"leavecalcalcution()");
            $('#todate').prop('value','')
            $('#todate').attr('onchange',"leavecalcalcution()");
            $('#totalleave').prop('value','');
            leavecalcalcution();
        }
    }
    function formatDate(date) {
        var monthNames = [
            "1", "2", "3",
            "4", "5", "6", "7",
            "8", "9", "10",
            "11", "12"
        ];

        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        return monthNames[monthIndex] + '/' + day + '/' + year;
    }
    function daysdifference(firstDate, secondDate) {
        var From_date = new Date(firstDate);
        var To_date = new Date(secondDate);
        // To calculate the time difference of two dates
        var Difference_In_Time = To_date.getTime() - From_date.getTime();

// To calculate the no. of days between two dates
        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

        return Difference_In_Days;
    }
    function leavecalcalcution(){
        var leavetotdate = $('#todate').val();
        var leavefromdate = $('#fromdate').val();

        if (leavetotdate != '' && leavefromdate != '') {
            var totalleave = daysdifference(formatDate(new Date(leavefromdate)), formatDate(new Date(leavetotdate))) + 1;

            if (totalleave >= 0) {
                $('#totalleave').val(totalleave);
            } else {
                $('#todate').val('');
                $('#fromdate').val('');
                $('#totalleave').val('');
            }
        } else {
            var totalleave = '';
        }
    }
    function unfreeze(id){
        $('#unfreeze #unfreezeid').val(id);
        //$('#unfreeze #unfreezeid').text(id);
    }

    $(document).ready(function(){

         $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
            }

            $.ajax({
                type : 'POST',
                url : '{{ route('empexpirydate') }}',
                data : {empid:empid, _token : '{{ csrf_token() }}'},
                success : function(data){


                    if(data != 'leavenotfound' ){


                        $('#leavedate').attr('max', data);
                        $('#leave_error').css('display', 'none');
                        $('#submit').removeAttr('disabled');

                    }else{

                        $('#submit').attr('disabled', 'true');
                        $('#leave_error').css('display', 'block');

                    }

                }
            });
       });

    });
</script>
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
@endpush
