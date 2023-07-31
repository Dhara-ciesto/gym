
@extends('layouts.adminLayout.admin_design')
@section('title', 'View Working Days')

@section('content')
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

        @php

            $year = !empty($year) ? $year : '';

        @endphp
<div class="wrapper">
    <div class="content-wrapper">
        <!--  <section class="content-header">
           <div class="row">
            <div class="col-md-12">
              <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('viewworkingdays') }}">Working Days</a></li>
                <li class="active">View Working Days</li>
              </ol>
            </div>
            </div>
        </section> -->
       <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">View Working Days</h3>
                           <div class="" style="float: right;"><a href="{{ route('workingdays') }}" class="btn btn-primary bg-orange" title="Add Working days">Add Working Days</a></div>
                        </div>
                   

                        <!-- /.box-header -->
                     <div class="box-body">
                            <div class="row">                               

                                <div class="col-md-8">


                                    <form method="post" action="{{ route('searchyear') }}">
                                        @csrf

                                  <div class="col-md-4">

                                        <div class="form-group col">
                                            <label>Select Year</label>
                                             <select  class="form-control span11 select2"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Year" required="" id="year" name="year" data-sear value="{{ $year }}">
                                                                <option value="">Select year</option>
                                                            @for($i = 2019; $i<=2030; $i++)
                                                                <option value="{{ $i }}" @if($i == $year) selected="" @endif>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                        </div>
                                    </div>
                                         <div class="col-md-4">

                                        <div class="form-group col">
                                            <br>
                                                                                   <button type="submit" class="btn btn-primary bg-green">Submit</button>

                                    </div>
                                </div>
                        
                                                 </form>
                                                    </div>
                       </div>
                            <div class="box-body table-responsive no-padding">
                            <table id="example1" class="table table-bordered table-striped table-hover">
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
                                                    <a class="edit" href="{{ route('editworkingdays', $days->workingcalid) }}" title="edit"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <div class="datarender" style="text-align: center">  {!! $working_days->render() !!} </div>

                                    @else
                                        <tr>
                                            <td colspan="5">No Data Found</td>

                                        </tr>
                                    @endif
                                </tbody>

                            </table>
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

<script type="text/javascript">var d = new Date(),
        
    y = d.getFullYear();

$('#year option[value="'+y+'"]').prop('selected', true);</script>
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()


    //Datemask dd/mm/yyyy
  
  })
</script>
@endpush