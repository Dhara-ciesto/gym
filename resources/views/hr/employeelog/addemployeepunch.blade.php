@extends('layouts.adminLayout.admin_design')

@section('title', 'Add Employee Log')

@section('content')
<style>
    .table{
        width:auto;
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
<div class="wrapper">
    <div class="content-wrapper">
       <!--  <section class="content-header">
        <div class="row">
            <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('employeelog') }}">Employee Log</a></li>
                <li class="active">Add Employee punch</li>
            </ol>
        </div>
        </div>
        </section> -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Add Punch</h3>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <form action="{{ route('addemppunch') }}" method="post" id="workingdays">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label>Employee<span style="color: red;">*</span></label>
                                                    <select  class="form-control select2" name="employeeid" id="employeeid">
                                                        @if(!empty($employee))
                                                        <option value="">Select Employee</option>
                                                        @foreach($employee as $emp)
                                                        <option value="{{ $emp->employeeid }}">{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
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
                                                    <select  class="form-control" id="mobileno" disabled="">
                                                        @if(!empty($employee))
                                                        <option value="">Select Mobile No</option>
                                                        @foreach($employee as $emp)
                                                        <option value="{{ $emp->employeeid }}">{{ $emp->mobileno }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                    <div class="form-group">
                                                    <label>Punch Date<span style="color: red;">*</span></label>
                                                    <input type="date" name="punchdate" id="punchdate" class="form-control" max={{date('Y-m-d')}} />
                                                    @if($errors->has('punchdate'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('punchdate') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div id="allpunch" style="display:none;"></div>
                                                <div class="form-group">
                                                    <label>Check In<span style="color: red;">*</span></label>
                                                    <input type="time" name="checkin" class="form-control" max="24:00:00" />
                                                    @if($errors->has('checkin'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('checkin') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                    <div class="form-group">
                                                    <label>Check Out<span style="color: red;">*</span></label>
                                                    <input type="time" name="checkout" class="form-control" max="24:00:00" />
                                                    @if($errors->has('checkout'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('checkout') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <button type="submit" class="btn btn-primary bg-green">Save</button>
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
    $('#punchdate').on('change',function(){
        var punchdate=$('#punchdate').val();
        var empid = $('#employeeid').val();
        $.ajax({
        type : 'POST',
        data : {_token:'{{ csrf_token() }}',punchdate:punchdate,empid:empid},
        url : '{{ url('getpunchrecord') }}',
        success : function(data){
            if(data){
                $('#allpunch').empty();
                var allpunch = '<table class="table"><thead><th width="50%">'+data.dateid+'</th></thead>';
                    allpunch += '<tbody><tr><td><input type="time" class="form-control" name="timein1" value="'+data.timein1+'" disabled' ;

                    allpunch +='></td><td><input type="time" class="form-control"  name="timeout1" value="'+data.timeout1+'" disabled' ;
   
                    allpunch +='></td></tr>';

                    allpunch += '<tr><td><input type="time" class="form-control" name="timein2" value="'+data.timein2+'" disabled';
 
                    allpunch +='></td><td><input type="time" class="form-control"  name="timeout2" value="'+data.timeout2+'" disabled';
                   
                    allpunch +='></td></tr>';

                    allpunch += '<tr><td><input type="time" class="form-control" name="timein3" value="'+data.timein3+'" disabled';
                   
                    allpunch +='></td><td><input type="time" class="form-control" name="timeout3" value="'+data.timeout3+'" disabled';
                   
                    allpunch += '></td></tr>';
                    allpunch += '</tbody></table>';
            $('#allpunch').html(allpunch);
            $('#allpunch').show();
          
            }else{
         
            }
        }
    });
          
    });
</script>
@endpush
