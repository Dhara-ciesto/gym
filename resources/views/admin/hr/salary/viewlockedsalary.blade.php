@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Locked Salary</h2></section>
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
                                    <h3 class="box-title">Locked  Salary Detail</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row mb-5">
                                        <div class="col-md-12">
                                            <form method="post" class="form-inline" action="{{ route('empsalary') }}">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <select  class="form-control span11 selectpicker"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
                                                           @if(!empty($employee))
                                                           @foreach($employee as $emp)
                                                                <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <select  class="form-control" name="mobile" id="mobileno" placeholder="Mobileno" disabled="" style="width: 240px !important;">
                                                            <option value="">--Select Mobileno--</option>
                                                           @if(!empty($employee))
                                                           @foreach($employee as $emp)
                                                                <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <select  class="form-control span11 selectpicker"title="Select Month" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Month" required="" name="month" id="month" placeholder="Month">
                                                            <option value="">--Select Month--</option>
                                                            <option value='Janaury' @if($month == 'Janaury') selected="" @endif>Janaury</option>
                                                            <option value='February' @if($month == 'February') selected="" @endif>February</option>
                                                            <option value='March' @if($month == 'March') selected="" @endif>March</option>
                                                            <option value='April' @if($month == 'April') selected="" @endif>April</option>
                                                            <option value='May' @if($month == 'May') selected="" @endif>May</option>
                                                            <option value='June' @if($month == 'June') selected="" @endif>June</option>
                                                            <option value='July' @if($month == 'July') selected="" @endif>July</option>
                                                            <option value='August' @if($month == 'August') selected="" @endif>August</option>
                                                            <option value='September' @if($month == 'September') selected="" @endif>September</option>
                                                            <option value='October' @if($month == 'October') selected="" @endif>October</option>
                                                            <option value='November' @if($month == 'November') selected="" @endif>November</option>
                                                            <option value='December' @if($month == 'December') selected="" @endif>December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <select  class="form-control span11 selectpicker"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Year" required="" name="year" data-sear value="{{ $year }}">
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
                                                </div><br/>
                                                <div class="form-row" style="margin-top: 35px; margin-left: 15px;">
                                                    <button type="submit" class="btn btn-primary bg-orange">Submit</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-12">
                                            <table class="table table-responsive table-stripped">
                                                <thead>
                                                    <th>Employee Name</th>
                                                    <th>Month</th>
                                                    <th>Year</th>
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
                                                                <td>{{ $salary_data->status }}</td>
                                                                <td>
                                                                    <a href="{{ route('editsalary', $salary_data->salaryid) }}" title="Edit Salary"><i class="fa fa-edit"></i></a>
                                                                    <a href="" title="Delete Salary"><i class="fa fa-trash" style="color: red;"></i></a>
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



    });
</script>
@endpush