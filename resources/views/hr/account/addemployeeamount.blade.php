@extends('layouts.adminLayout.admin_design')

@section('title', 'Add Amount')

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
            $amount = !empty($amount) ? $amount : old('amount');
            $type = !empty($type) ? $type : old('type');
            $employeeid = !empty($employeeid) ? $employeeid : old('employeeid');
        @endphp
    <div class="wrapper">
        <div class="content-wrapper">
           <section class="content-header">
           <!--      <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li><a href="{{ route('viewemployeeaccount') }}">View Amount</a></li>
                            <li class="active">Add Amount</li>
                        </ol>
                    </div>
                </div>
            </section> -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Add Loan</h3>
                            </div>

                                <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <form action="{{ route('employeeaccount') }}" method="post" id="workingdays">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label>Date<span style="color: red;">*</span></label>
                                                    <input type="date" name="loan_date" class="form-control" id="loan_date" value="{{date('Y-m-d')}}" required="">
                                                    @if($errors->has('loan_date'))
                                                        <span class="help-block">
                                                        <strong>{{ $errors->first('loan_date') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Empolyee<span style="color: red;">*</span></label>
                                                    <select  class="form-control span11 select2"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
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
                                                    <label>Type<span style="color: red;">*</span></label>
                                                    <select  class="form-control" onchange="getloan()" name="type" id="type" placeholder="Select type">
                                                        <option value="">Select Type</option>
                                                        <option value="Fine">Fine</option>
                                                        <option value="Loan" >Loan</option>
                                                        <option value="EMI" >EMI</option>
                                                    </select>
                                                    @if($errors->has('type'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('type') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group" id="loandiv">

                                                </div>
                                                 
                                                <div class="form-group" id="amountdiv">

                                                </div>
                                                 <div class="form-group">
                                                    <label>Remarks<span style="color: red;">*</span></label>
                                                     <textarea name="remark" id="remarks" class="form-control" required="" placeholder="Remarks"></textarea>
                                                     @if($errors->has('remark'))
                                                         <span class="help-block">
                                                        <strong>{{ $errors->first('remark') }}</strong>
                                                    </span>
                                                     @endif
                                                </div>
                                                <button type="submit" class="btn btn-primary bg-green">Save</button>
                                                <a href="{{ route('viewemployeeaccount') }}" class="btn btn-danger">Cancel</a>
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
    <script>
        function getloan(){
            $('#loandiv').empty();
            $('#amountdiv').empty();
            var type = $('#type').val();
            var employeeid = $('#employeeid').val();
            if(type=='EMI') {
                html = '';
                $.ajax({
                    url: "{{ url('ajaxgetpendingloan') }}",
                    method: "POST",
                    data: {employeeid: employeeid, "_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        html += '<table class="table table-bordered table-striped">';
                        html += '<thead>';
                        html += '<tr>';
                        html += '<th> Type </th>';
                        html += '<th> Total Amount </th>';
                        html += '<th> Paid Amount </th>';
                        html += '<th> Due Amount </th>';
                        html += '<th> Action </th>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody>';
                        $.each(data,function (i,item){
                            html += '<tr>';
                            html += '<td>'+item.type+'</td>';
                            html += '<td>'+item.total_amount+'</td>';
                            html += '<td>'+item.paid_amount+'</td>';
                            html += '<td>'+item.due_amount+'</td>';
                            html += '<td><input type="hidden" name="loanid[]" value="'+item.hr_loan_id+'" /> <input min="0" max="'+item.due_amount+'" type="text" name="amount[]" class="form-control" /> </td>';
                            html += '</tr>';
                        });
                        html += '<tbody>';
                        html += '</tbody>';
                        html += '</table>';
                        $('#loandiv').append(html);
                    },
                    dataType: "json"
                });
            }else{
                $('#amountdiv').append('<label>Amount<span style="color: red;">*</span></label> <input type="text" name="amount" value="{{ $amount }}" class="form-control" maxlength="8" required="">');
            }
        }
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
