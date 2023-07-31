@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Add Working Days</h2></section>
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
            $year = !empty($year) ? $year : old('year');
            $month = !empty($month) ? $month : old('month');
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
                                    <h3 class="box-title">Add Working Days</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <form action="{{ route('workingdays') }}" method="post" id="workingdays">
                                                    {{ csrf_field() }}
                                                    <div class="form-group ">
                                                        <label>Year<span style="color: red;">*</span></label>
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
                                                    <div class="form-group ">
                                                        <label>Month<span style="color: red;">*</span></label>
                                                        <select class="form-control span11 selectpicker"title="Select Month" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Month" required="" name="month" data-sear value="{{ $month }}">
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
                                                        @if($errors->has('month'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('month') }}</strong>
                                                      </span>
                                                      @endif
                                                    </div>
                                                    <div class="form-group ">
                                                        <label>Working Days<span style="color: red;">*</span></label>
                                                        <input type="text" name="workingdays" value="{{ old('workingdays') }}" class="form-control number" maxlength="2" required="">
                                                        @if($errors->has('workingdays'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('workingdays') }}</strong>
                                                      </span>
                                                      @endif
                                                    </div>
                                                    <button type="submit" class="btn btn-primary bg-orange">Submit</button>
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