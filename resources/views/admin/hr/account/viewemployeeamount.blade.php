@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Employee Account</h2></section>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @php


        $employeeid = !empty($empid) ? $empid : '';
      

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
                                    <h3 class="box-title">Account Detail</h3>
                                    <div class="" style="float: right;"><a href="{{ route('employeeaccount') }}" class="btn btn-primary bg-orange" title="Add Working days">Add Amount</a></div>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                    <form method="post" class="form-inline" action="{{ route('searchemployeeaccount') }}">
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
                                        <div class="form-row" style="margin-top: 35px; margin-left: 15px;">
                                            <button type="submit" class="btn btn-primary bg-orange">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                    <div class="row">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($account))
                                                @foreach($account as $accountdata)
                                                    <tr>
                                                        
                                                        <td><?php echo (!empty($accountdata->employeename->first_name) ? ucfirst($accountdata->employeename->first_name) : '') ?> <?php echo (!empty($accountdata->employeename->last_name)) ? ucfirst($accountdata->employeename->last_name) : '' ?></td>
                                                        <td>{{ ucfirst($accountdata->type) }}</td>
                                                        <td>{{ $accountdata->amount }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($accountdata->empaccountdate)) }}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('editleave' , $accountdata->empaccountid) }}" title="edit"><i class="fa fa-edit"></i></a> --}}
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
                </div>
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