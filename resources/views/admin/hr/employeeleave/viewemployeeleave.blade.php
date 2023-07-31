@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Employee Leave</h2></section>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
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

        @php

            $employeeid = !empty($employeeid) ? $employeeid : '';

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
                                    <h3 class="box-title">Employee Leave Detail</h3>
                                    <div class="" style="float: right;"><a href="{{ route('employeeleave') }}" class="btn btn-primary bg-orange" title="Add Working days">Add Employee Leave</a></div>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form method="post" action="{{ route('searchemployeeleave') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Employee<span style="color: red;">*</span></label>
                                                    <select  class="form-control span11 selectpicker"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
                                                     @if(!empty($employee))
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
                                            <label>Mobile No<span style="color: red;">*</span></label>
                                            <select  class="form-control" disabled="" id="mobileno">
                                             @if(!empty($employee))
                                             <option value="">--Select Employee--</option>
                                             @foreach($employee as $emp)
                                             <option value="{{ $emp->employeeid }}"  @if($employeeid == $emp->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                             @endforeach
                                             @endif
                                         </select>
                                         <span id="leave_error" style="color: red;display: none;">Please add employee leave</span>
                                     </div>
                                                <div class="form-group col">
                                                    <button type="submit" class="btn btn-primary bg-orange">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Reason</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($employeeleave))
                                                @foreach($employeeleave as $key => $employee)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($employee->date)) }}</td>
                                                        <td>{{ $employee->reason }}</td>
                                                        <td>
                                                            <a href="{{ route('editemployeeleave', $employee->employeeleaveid) }}" title="edit"><i class="fa fa-edit"></i></a>
                                                            <a href="{{ route('deleteemployeeleave', $employee->employeeleaveid) }}" title="edit"><i class="fa fa-trash"></i></a>
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
                        $('#example1').DataTable()
                        $('#example2').DataTable({
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
        $('#unfreeze_btn').click(function(){
            $('#processing').show();
            $('#unfreeze_btn').hide();

            let freezeid = $('#unfreezeid').val();

            $.ajax({

                type: 'POST',
                url : '{{ route('unfreezemembership') }}',
                data : {freezeid:freezeid, _token:"{{csrf_token()}}" },
                success : function(data){
                    
                    if(data == 0){
                        alert("membership is unfreezed");
                        window.location.href = '';
                    }else{

                        alert('There is some problem occure in device');  
                        window.location.href = '';

                       /* $('#processing').hide();
                        $('#notset').show();*/
                    }
                }




            });
        });

        $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
            }
        });

    });
</script>
@endpush