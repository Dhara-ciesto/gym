@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Working Days</h2></section>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @php

            $year = !empty($year) ? $year : '';

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
                                    <h3 class="box-title">Working Days Detail</h3>
                                    <div class="" style="float: right;"><a href="{{ route('workingdays') }}" class="btn btn-primary bg-orange" title="Add Working days">Add Working Days</a></div>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form method="post" action="{{ route('searchyear') }}">
                                                @csrf
                                                <div class="form-group col">
                                                    <label>Select Year</label>
                                                    <select  class="form-control span11 selectpicker"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Year" required="" name="year" data-sear value="{{ $year }}">
                                                        @for($i = 2019; $i<=2030; $i++)
                                                        <option value="{{ $i }}" @if($i == $year) selected="" @endif>{{ $i }}</option>
                                                        @endfor
                                                    </select>
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
                                                <th>Month</th>
                                                <th>Year</th>
                                                <th>Holidays</th>
                                                <th>Working Days</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($working_days))
                                                @foreach($working_days as $days)
                                                    <tr>
                                                        <td>{{ $days->year }}</td>
                                                        <td>{{ $days->month }}</td>
                                                        <td>{{ $days->holidays }}</td>
                                                        <td>{{ $days->workingdays }}</td>
                                                        <td>
                                                            <a href="{{ route('editworkingdays', $days->workingcalid) }}" title="edit"><i class="fa fa-edit"></i></a>
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
    });
</script>
@endpush