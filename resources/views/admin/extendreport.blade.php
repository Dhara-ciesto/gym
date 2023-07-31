@extends('layouts.adminLayout.admin_design') @section('content')
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
    <div class="content-wrapper">
        <section class="content-header">
            <!--         <h2>Freezed Membership</h2></section>
             -->    <div class="container-fluid">
                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <div class="table-wrapper">
                    <div class="table-title">

                        <div class="box-header">

                        </div>
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Filters</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">


                                            <form action="{{url('extendreport')}}" method="post">
                                                {{csrf_field()}}
                                                <div class="table-responsive">
                                                    <table class="table no-margin">
                                                        <thead>
                                                        <tr>
                                                            <th>Username</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        <tr>
                                                            <div class="col-xs-4">
                                                                <td><select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
                                                                        <option value="" selected="" disabled="">Select a Username</option>
                                                                        @foreach($users as $user)
                                                                            <option value="{{$user->userid}}"  @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif >
                                                                                {{ $user->username }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select></td>
                                                            </div>

                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left" colspan="4"><button type="submit" name="search" class="btn bg-green"><i class="fa fa-filter"></i>Filters</button><a href="{{ url('extendreport') }}" class="btn bg-red">Clear</a></td>
                                                        </tr>


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </form>
                                            {{ csrf_field() }}

                                        </div>
                                    </div>


                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">Manualy Extend Membership</h3>
{{--                                            <div class="" style="float: right;"><a href="{{ url('freezemembership') }}" class="btn btn-primary bg-orange" title="Freeze Membership"><i class="fa fa-plus"></i> Freeze Membership</a></div>--}}
                                        </div>

                                        <!-- /.box-header -->
                                        <div class="box-body" style="overflow: scroll;">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Member Name</th>
                                                    <th>Old Join Date</th>
                                                    <th>New Join Date</th>
                                                    <th>Old End Date</th>
                                                    <th>New End Date</th>
                                                    <th>Reason</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($extendhistory))
                                                    @foreach($extendhistory as $value)
                                                        <tr>
                                                            <td>{{$value->firstname.' '.$value->lastname}}</td>
                                                            <td>{{date('d-m-Y',strtotime($value->oldjoindate))}}</td>
                                                            <td>{{date('d-m-Y',strtotime($value->newjoindate))}}</td>
                                                            <td>{{date('d-m-Y',strtotime($value->oldenddate))}}</td>
                                                            <td>{{date('d-m-Y',strtotime($value->newenddate))}}</td>
                                                            <td>{{$value->reason}}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4"><center>No Data Found</center></td>
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

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Datemask dd/mm/yyyy

        })
    </script>
@endpush