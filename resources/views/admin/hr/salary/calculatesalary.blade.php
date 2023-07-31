@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Salary</h2></section>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @php

            $year = !empty($year) ? $year : '';
            $month = !empty($month) ? $month : '';
            $employeeid = !empty($employeeid) ? $employeeid : '';
            $i = 0;
            $confirmdate = '';


        @endphp
        <div class="table-wrapper">
            <div class="table-title">
                <div class="box-header">
                </div>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Salary Detail #<b>{{ ucfirst($empdata->first_name) }} {{ ucfirst($empdata->last_name) }}</b></h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                            <form method="post" class="" action="{{ route('empsalary') }}">
                                                <input type="hidden" name="employeeid" value="{{ $employeeid }}">
                                                <input type="hidden" name="year" value="{{ $year }}">
                                                <input type="hidden" name="month" value="{{ $month }}">
                                                <input type="hidden" name="store" value="1">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Employee Name</label>
                                                            <input type="text" name="empname_display" class="form-control" value="{{ucfirst($empdata->first_name) }} {{ ucfirst($empdata->last_name)}}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Mobile No</label>
                                                            <input type="text" name="mobileno_display" class="form-control" value="{{ $empdata->mobileno }}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Month</label>
                                                            <input type="text" name="month_display" class="form-control" value="{{ $month }}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <label>Year</label>
                                                            <input type="text" name="year_display" class="form-control" value="{{ $year }}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                   {{--  <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Salary</label>
                                                            <input type="text" name="salary" class="form-control" value="{{ $empsalary }}" readonly="">
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Working Days</label>
                                                            <input type="text" name="workingdays_display" class="form-control" value="{{ $Workindays }}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Present Days</label>
                                                            <input type="text" name="attenddays_display" class="form-control" value="{{ $attenddays }}" readonly="">
                                                        </div>
                                                    </div>
                                                </div>  

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Holidays</label>
                                                            <input type="text" name="holidays_display" class="form-control" value="{{ $holidays }}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Taken Leave</label>
                                                            <input type="text" name="takenleave_display" class="form-control" value="{{ $takenleave }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                 <div class="row">
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Monthly Working Hour</label>
                                                            <input type="text" name="monthlyworking_hour_display" class="form-control" value="{{ $empworkinghour }}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> 
                                                        <div class="form-group">
                                                            <label>Total Working Hour</label>
                                                            <input type="text" name="totalworkinghour_display" class="form-control" value="{{ $total_hour }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Monthly Working Minute</label>
                                                            <input type="text" name="" class="form-control" value="{{ $empworkingminute }}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> 
                                                        <div class="form-group">
                                                            <label>Total Working Minute</label>
                                                            <input type="text" name="" class="form-control" value="{{ $totalminute }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Monthly Salary</label>
                                                            <input type="text" name="" class="form-control" value="{{ $empsalary }}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> 
                                                        <div class="form-group">
                                                            <label>Current Monthly Salary</label>
                                                            <input type="text" name="" class="form-control" value="{{ $current_salary }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row" style="margin-top: 35px; margin-left: 15px;">
                                                    <button type="submit" class="btn btn-primary bg-orange">Submit</button>
                                                </div>
                                            </form>
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

                <!-- page script -->
                <script>
                    $(function() {
                        //$('#example1').DataTable()
                        $('#example1').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': false,
                            'ordering': true,
                            'info': true,
                            'autoWidth': false
                        })
                    })
                </script>

            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
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
       });

       calsal();

    });
</script>
@endpush