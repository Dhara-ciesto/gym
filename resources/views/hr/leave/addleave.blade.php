@extends('layouts.adminLayout.admin_design')

@section('title', 'Add Leave')

@push('css')
<style type="text/css">
    .help-block{
        color: red;
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
@endpush
@section('content')

        @php
            $leaveyear = !empty($leaveyear) ? $leaveyear : old('leaveyear');
            $leave = !empty($leave) ? $leave : old('noofleave');
        @endphp
<div class="wrapper">
    <div class="content-wrapper">
         <!-- <section class="content-header">
           <div class="row">
            <div class="col-md-12">
              <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('viewleave') }}">Leave</a></li>
                <li class="active">Add Leave</li>
              </ol>
            </div>
            </div>
        </section> -->
     
        <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Add Leave</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <form action="{{ route('leave') }}" method="post" id="workingdays">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label>Employee<span style="color: red;">*</span></label>
                                                        <select  class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
                                                        @if(!empty($employee))
                                                            <option value="">Select Employee</option>
                                                        @foreach($employee as $emp)
                                                            <option value="{{ $emp->employeeid }}" @if(old('employeeid') ==  $emp->employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
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
                                                        <select  class="form-control" name="mobileno" id="mobileno" disabled="" >
                                                        @if(!empty($employee))
                                                            <option value="">Select Mobileno</option>
                                                        @foreach($employee as $emp)
                                                            <option value="{{ $emp->employeeid }}"  @if(old('employeeid') ==  $emp->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                        @endforeach
                                                        @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No Of Leave<span style="color: red;">*</span></label>
                                                        <input type="text" name="noofleave" value="{{ $leave }}" class="form-control number" maxlength="2" required="">
                                                        @if($errors->has('noofleave'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('noofleave') }}</strong>
                                                      </span>
                                                      @endif
                                                    </div>
                                                    <div class="form-group ">
                                                        <label>Expiry Date<span style="color: red;">*</span></label>
                                                        <input type="date" name="expirydate" value="{{ old('expirydate') }}" class="form-control" onkeypress="return false" required="" min="{{ date('Y-m-d') }}">
                                                        @if($errors->has('expirydate'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('expirydate') }}</strong>
                                                      </span>
                                                      @endif
                                                    </div>
                                                    <button type="submit" class="btn btn-primary bg-green">Save</button>
                                                    <a href="{{ route('viewleave') }}" class="btn btn-danger">Cancel</a>
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
