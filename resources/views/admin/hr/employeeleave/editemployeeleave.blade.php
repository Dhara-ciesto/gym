@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Edit Employee Leave</h2></section>
    <div class="container-fluid">
        @if ($message = Session::get('message'))
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
                                    <h3 class="box-title">Edit Employee Leave</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <form action="{{ route('editemployeeleave', $empleave->employeeleaveid) }}" method="post" id="workingdays">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label>Employee<span style="color: red;">*</span></label>
                                                        <select  class="form-control span11 selectpicker"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear disabled="">
                                                           @if(!empty($employee))
                                                           @foreach($employee as $emp)
                                                           <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $empleave->employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
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
                                                           <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $empleave->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                        <span id="leave_error" style="color: red;display: none;">Please add employee leave</span>
                                                    </div>

                                                 <div class="form-group">
                                                     <label>Date<span style="color: red;">*</span></label>
                                                     <input type="date" name="leavedate" id="leavedate" class="form-control" required="" value="{{ $empleave->date }}" max="{{ $empleave->expirydate }}">
                                                     @if($errors->has('leavedate')) 
                                                     <span class="help-block">
                                                      <strong>{{ $errors->first('leavedate') }}</strong>
                                                     </span>
                                                     @endif
                                                 </div>

                                                 <div class="form-group">
                                                     <label>Reason</label>
                                                     <textarea name="reason" class="form-control">{{ $empleave->reason }}</textarea>
                                                     @if($errors->has('reason'))
                                                     <span class="help-block">
                                                      <strong>{{ $errors->first('reason') }}</strong>
                                                     </span>
                                                     @endif
                                                 </div>

                                                    <button type="submit" class="btn btn-primary bg-orange" id="submit">Submit</button>
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
@endpush