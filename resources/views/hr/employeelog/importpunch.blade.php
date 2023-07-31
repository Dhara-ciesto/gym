@extends('layouts.adminLayout.admin_design')

@section('title', 'Import Employee Punch')
<style>
    strong{
        color: red;
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

@section('content')


        @php

            $year = !empty($year) ? $year : '';
            $month = !empty($month) ? $month : '';
            $employeeid = !empty($employeeid) ? $employeeid : '';
            $i = 0;
            $confirmdate = '';


        @endphp
        @if(Session::has('downloadexcel'))
         <meta http-equiv="refresh" content="5;url={{ Session::get('downloadexcel') }}">
        @endif
<div class="wrapper">
    <div class="content-wrapper">
        <!-- <section class="content-header">
            <div class="row">
            <div class="col-md-12">
              <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('employeelog') }}">Employee Log</a></li>
                <li class="active">Import Employee Log</li>
              </ol>
            </div>
            </div>
        </section> -->
        <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Import Punch </h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row mb-5">
                                        <div class="col-md-12">
                                            <div class="form-inline">
                                            <form action="{{ route('downloaddemosheet') }}" onsubmit="return downloadcsv()" method="post">
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
                                                   
                                                        <select  class="form-control span11 select2" name="mobile" id="mobileno" placeholder="Mobileno" disabled="" style="width: 240px !important;">
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
                                                    <button type="submit" id="download" class="btn btn-primary bg-green">Download</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            
                                   <form method="post" onsubmit="return chekfile()" id="uploadcsvform" enctype="multipart/form-data" action="{{ route('importemppunchcsv') }}" style="margin-top: 20px;">
                                    @csrf
                                    <div class="row mb-5">
                                    <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            
                                                <div class="form-group">
                                                    <label>Upload File<sapn style="color: red;">*</sapn></label>
                                                    <input type="file" name="file" id="file" class="form-control" accept=".csv">
                                                </div>
                                                @if($errors->has('file'))
                                                <span class="help-block">
                                                  <strong>{{ $errors->first('file') }}</strong>
                                              </span>
                                              @endif
                                        </div>
                                    </div>
                                    

                                    <div class="row mb-5">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <button id="uploadcsv" class="btn btn-success" style="margin-bottom: 10px;">Submit</button>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </form>
                            </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </section>
            
@endsection
@push('script')
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

    function chekfile(){


        var filename = $('#file').val();
        if(filename){
            $('#uploadcsv').attr('disabled', 'true');
            return true;
        }else{
            $('#uploadcsv').removeAttr('disabled');
            alert('Please upload csv file');
            return false;
        }
    }

    function downloadcsv(){

        var emp = $('#employeeid').val();
        var month = $('#month').val();
        var year = $('#year').val();

        if(!emp){
            alert('Please select Employee');
            return false;
        }else if(!month){
            alert('Please select Month');
            return false;
        }else if(!year){
            alert('Please select Year');
            return false;
        }else{
            $('#download').attr('disabled', 'true');
            return true;
        }

    }


</script>
@endpush