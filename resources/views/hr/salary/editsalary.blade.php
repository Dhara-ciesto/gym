@extends('layouts.adminLayout.admin_design')
<style>
   .highlight{
   border:1px solid black !important;
   }
   .row{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
    .content-wrapper {
    /* min-height: 100%;*/
    }

</style>
@section('title', 'Calculate Salary')
@section('content')
@php
$year = !empty($year) ? $year : '';
$month = !empty($month) ? $month : '';
$employeeid = !empty($employeeid) ? $employeeid : '';
$i = 0;
$confirmdate = '';
@endphp
@php
    function getSundays($y, $m)
    {
        return new DatePeriod(
            new DateTime("first sunday of $y-$m"),
            DateInterval::createFromDateString('next sunday'),
            new DateTime("first friday of next month")
        );
    }




        // if(count($schemedetail) > 0){
        //     $persessionprice= round($schemedetail->baseprice/$schemedetail->pthours,2);
        //     $sessionprice=round($persessionprice*($trainerdetail['trainerpercentage']/100),2);
        //     $totalsessionprice=$sessionprice*$schemedetail['totalsession'];
        // }

    // if(count($schemedetail) > 0){
    //     $persessionprice= round($schemedetail->baseprice/$schemedetail->pthours,2);
    //     $sessionprice=round($persessionprice*($trainerdetail['trainerpercentage']/100),2);
    //     $totalsessionprice=$sessionprice*$schemedetail['totalsession'];
    // }


@endphp
<div class="wrapper">
    <div class="content-wrapper">
       <section class="content-header">
         <!--  <div class="row">
             <div class="col-md-12">
                <ol class="breadcrumb">
                   <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                   <li><a href="{{ route('viewemployeeaccount') }}">Salary</a></li>
                   <li class="active">Calculate Salary</li>
                </ol>
             </div>
          </div> -->
       </section>
       <section>
        @php
        // $roleid = 6;
        if($roleid == 5){
            $showleave = 1;
            $showhours = 0;
        }elseif($roleid == 6){

            $showleave = 0;
            $showhours = 0;
        }else{

            $showleave = 1;
            $showhours = 1;
        }
        @endphp

               <form method="post" class="form" action="{{ route('editsalary', $salary->salaryid) }}">
                  <input type="hidden" id="employeeid" name="employeeid" value="{{ $salary->employeeid }}">
                  <input type="hidden" name="year" value="{{ $salary->year }}">
                  <input type="hidden" name="Workindays" value="{{ $salary->Workindays }}">
                  <input type="hidden" name="holidays" value="{{ $salary->holidays }}">
                  <input type="hidden" name="totalworkinghour" value="{{ $salary->totalworkinghour }}">
                  <input type="hidden" name="empworkingminute" value="{{ $salary->empworkingminute }}">
                  <input type="hidden" name="workingminute" value="{{ $salary->totalminute }}">
                  <input type="hidden" name="totalworkinghour_display" value="{{ $salary->totalhour }}">



                  <input type="hidden" name="empsalary" value="{{ $salary->empsalary }}">
                  <input type="hidden" name="givenleave" value="{{ $salary->givenleave }}">
                  <input type="hidden" name="store" value="1">
               <input type="hidden" name="month_display" value="{{ $salary->month}}">
               <input type="hidden" name="" class="form-control number" value="{{ $salary->empworkingminute }}" readonly="">
               <input type="hidden" name="monthlyworking_hour_display" class="form-control" value="{{ $salary->empworkinghour }}" readonly="">


                @csrf
             <div class="row">
                <div class="col-lg-12 col-md-8">
                   <div class="row">
                      <div class="box">
                         <div class="box-header">
                            <h3 class="box-title">Salary #<b>{{ucfirst($salary->employee->first_name) }} {{ ucfirst($salary->employee->last_name)}}</b></h3>
                            <h3 class="box-title  pull-right"><b>{{  $salary->month.'-'.$salary->year }}</b></h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Total Days</label>
                                     <input type="text" class="form-control" id="workingdays" value="{{ $salary->actualdays + $salary->holidays}}" name="workingdays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 ">
                                  <div class="form-group">
                                     <label>Working Days</label>
                                     <input type="text" class="form-control" id="actualdays"  name="actualdays_display"  value="{{ $salary->actualdays }}" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Non Working Days</label>
                                     <input type="text" class="form-control" id="holiday" value="{{ $salary->holidays }}" name="holidays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Present Days</label>
                                     <input type="text" class="form-control" id="attenddays" name="attenddays_display"  value="{{ $salary->attenddays }}" oninput="caldays('pday', this.value)">
                                     @if($errors->has('attenddays_display'))
                                       <span class="help-block">
                                          <strong>{{ $errors->first('attenddays_display') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Absent Days</label>
                                     <input type="text" class="form-control" id="takenleave" name="takenleave_display" value="{{$salary->takenleave }}" oninput="caldays('takenleave', this.value)"
                                        required="" autocomplete="off">
                                        @if($errors->has('takenleave_display'))
                                        <span class="help-block">
                                           <strong>{{ $errors->first('takenleave_display') }}</strong>
                                     </span>
                                     @endif
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  {{-- <div class="form-group">
                                     <label>Monthly </label>
                                     <input type="text" class="form-control">
                                  </div> --}}
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="row">
                      <div class="box">
                         <div class="box-header with-border">
                            <h3 class="box-title">Duty Hours<b></b></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label class="col-sm-1  col-lg-2 control-label">Detail</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <label class="control-label"> Hours</label>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <label class="control-label"> Rs</label>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <label class="control-label"> Logs</label>
                                     </div>
                                  </div>
                               </div>
                            </div>
                            @php

                                if($empattandedhours>0){
                                        $totalfloorhour=$empattandedhours-$trainersession;
                                        }else{
                                            $totalfloorhour=0;
                                        }


                                        $perdaysalary=round($empsalary/($Workindays+$holidays), 2);

                                        $perhoursalary=round($perdaysalary/$empworkinghour , 2);

                            @endphp

                                <div class="row">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Total Floor Hours</label>
                                            <div class="col-sm-4 col-lg-3">
                                                <input type="text" class="form-control" id="totalfloorhour" placeholder="Floor" value="{{ $totalfloorhour }}"readonly >
                                            </div>
                                            <div class="col-sm-4 col-lg-3">
                                                <input type="text" class="form-control" id="floorslary" placeholder="Floor" value="{{ $totalfloorhour*$perhoursalary }}"readonly >
                                            </div>
                                            <div class="col-sm-4 col-lg-3">
                                                <button type="button" class="btn btn-default" id="floorlogs" value="Floor Logs" data-toggle="modal" data-target="#exampleModalLong">Floor Logs</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             @php
                                 $totalsessionprice=0;

                             @endphp

                             @if($trainerdetail)
                                 @if(count($trainerdetail['trainershemes']) > 0 )
                                     @php $totalsessionprice =0; @endphp
                                     @foreach($trainerdetail['trainershemes'] as $schemedetail)
                                         @php
                                             if($schemedetail->dutyhours  == 1){
                                                 $totalsessionprice += $schemedetail->amount;
                                             }
                                         @endphp
                                     @endforeach
                                 @endif
                             @endif

                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Total PT Hours</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" name="totalsession" id="totalsession" placeholder="PT" value="{{ $trainersession }}" readonly>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                         <input type="text" class="form-control" name="totalsessionprice_display" id="totalsessionprice_display" placeholder="price" value="{{ $totalsessionprice }}"readonly >
{{--                                         <input type="hidden" class="form-control" name="totalsessionprice" id="totalsessionprice" placeholder="price" value="{{ $allsessionprice }}"readonly >--}}
                                     </div>
                                      <div class="col-sm-4 col-lg-3">
                                        <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#ptlogs" id="ptlogs" value="PT Logs">PT Logs</button>
                                     </div>
                                  </div>
                               </div>
                            </div>

                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="PT" placeholder="PT" value="{{ $totalfloorhour+$trainersession }}" readonly>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="totaltrainersalary" placeholder="Floor" value="{{ round(($totalfloorhour*$perhoursalary)+$totalsessionprice,2) }}" readonly>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>

                   <div class="row">
                     <div class="box">
                        <div class="box-header with-border">
                           <h3 class="box-title">Non Duty Hours<b></b></h3>
                           <div class="box-tools pull-right">
                               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                           </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                           <div class="row">
                              <div class="">
                                 <div class="form-group">
                                    <label class="col-sm-1  col-lg-2 control-label">Detail</label>
                                    <div class="col-sm-4 col-lg-3">
                                       <label class="control-label"> Hours</label>
                                    </div>
                                    <div class="col-sm-4 col-lg-3">
                                       <label class="control-label"> Rs</label>
                                    </div>

                                 </div>
                              </div>
                           </div>

                           @php
                               $totalnondutyhours = 0;
                                        if($nondutyhours > 0){
                                            $totalnondutyhours = $nondutyhours;
                                        }
                           @endphp

                               <div class="row">
                                   <div class="">
                                       <div class="form-group">
                                           <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Total Non Duty hours</label>
                                           <div class="col-sm-4 col-lg-3">
                                               <input type="text" class="form-control" id="" placeholder="Non Duty" value="{{ ($totalnondutyhours)?$totalnondutyhours:0}}"readonly >
                                           </div>
                                           <div class="col-sm-4 col-lg-3">

                                           <input type="text" class="form-control" id="nondutyhoursamount" placeholder="Non Duty" value="{{ $nondutyhoursamount }}"readonly >
                                           </div>
                                          <div class="col-sm-4 col-lg-3">
                                                <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#nondutyptlogs" id="nondutyptlog" value="PT Logs">Non Duty Logs</button>
                                             </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="row">
                                   <div class="">
                                       <div class="form-group">
                                           <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Extra Hours</label>
                                           <div class="col-sm-4 col-lg-3">
                                               <input type="text" class="form-control" id="extrahour" name="extrahour" placeholder="Extra Hours" value="{{ $salary->extrahour }}" >
                                           </div>
                                           <div class="col-sm-4 col-lg-3">

                                           <input type="text" class="form-control" id="extrahoursalary" name="extrahoursalary" placeholder="Extra Hours Salary" value="{{ $salary->extrahoursalary }}"readonly >
                                           </div>

                                       </div>
                                   </div>
                               </div>
                        </div>
                     </div>
                  </div>

                   <div class="row">
                      <div class="box">
                         <div class="box-header with-border">
                            <h3 class="box-title">Leave Calculation<b></b></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                         </div>

                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Absent Days</label>
                                  <div class="col-sm-4 col-lg-3">
                                     <input type="text" class="form-control" id="absday" placeholder="Floor" value="{{ $salary->takenleave }}" readonly>
                                  </div>
                               </div>
                            </div>

                            <div class="row">
                               <br>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                 <div class="form-group hide">
                                    <label>Extra</label>
                                    <input type="text" class="form-control" id="attenddays23" value="0">
                                 </div>
                              </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 hide">
                                  <div class="form-group">
                                     <label>Casual leave</label>
                                     <input type="text" class="form-control" autocomplete="off" name="casualleave" id="casualleave" value="{{ $salary->casualleave}}">
                                     @if($errors->has('casualleave'))
                                       <span class="help-block">
                                          <strong>{{ $errors->first('casualleave') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                               </div>

                               <div class="col-md-2 col-lg-2 col-xs-6" style="display:none;">
                                  <div class="form-group">
                                     <label>Medical Leave</label>
                                     <input type="text" class="form-control" autocomplete="off"  name="medicalleave" id="medicalleave" value="{{ $salary->medicalleave}}">
                                     @if($errors->has('medicalleave'))
                                        <span class="help-block">
                                           <strong>{{ $errors->first('medicalleave') }}</strong>
                                     </span>
                                     @endif
                                    </div>
                               </div>

                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Leave</label>
                                     <input type="text" class="form-control" autocomplete="off" name="paidleave" id="paidleave" value="{{ $salary->paidleave}}">
                                     @if($errors->has('paidleave'))
                                        <span class="help-block">
                                           <strong>{{ $errors->first('paidleave') }}</strong>
                                     </span>
                                     @endif
                                    </div>
                               </div>

                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Total Leave</label>
                                     <input type="text" class="form-control" autocomplete="off" id="takenleave12" value="{{ $salary->takenleave  }}" readonly>
                                  </div>
                               </div>
                                <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Date Wise Leave</label>
                                          <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#ptlogs2" id="ptlogs2" value="PT Logs">Leave</button>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="row">
                      <div class="box">
                         <div class="box-header with-border">
                            <h3 class="box-title">Salary Calculation<b></b></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <?php $loanamount = !empty($emploanamount->amount) ? $emploanamount->amount : 0; ?>
                            <?php $loanfine = !empty($emploanamountfine->amount) ? $emploanamountfine->amount : 0; ?>
{{--                            @php $loanamount = $loanamount+$salary->salaryemi; @endphp--}}
{{--                            @php $loanfine = $loanfine+$salary->salaryemi2; @endphp--}}
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Monthly Salary</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="monthlysalary" placeholder="PT" value="{{  $salary->empsalary  }}" readonly>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Sub Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" placeholder="PT"  id="subtotal"
                                        value="{{ $current_salary }}" readonly>
                                     </div>
                                  </div>
                               </div>
                            </div>
                                <div class="row">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label>
                                            <div class="col-sm-4 col-lg-3">
                                                {{-- <input type="number" class="form-control" id="loanfine" placeholder="Fine" name="loanfine" value="{{ $loanfine }}" readonly="" > --}}
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Bonus</label>

                                            <div class="col-sm-4 col-lg-3">

                                                <input type="number" onchange="checkfinalamount(this);" onkeyup="calfinalamount()" name="bonus" class="form-control"   id="bonus"  value="{{ $salary->bonus > 0 ? $salary->bonus : 0 }}">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="">
{{--                                        <div class="form-group">--}}

{{--                                            <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Details</label>--}}
{{--                                            <input type="hidden" name="loanfine"  class="form-control" value="{{ $loanfine }}">--}}
{{--                                            <div class="col-sm-4 col-lg-3">--}}
{{--                                                <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#ptlogs3" id="ptlogs3" value="PT Logs">Loan Details</button>--}}

{{--                                                <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#ptlogs4" id="ptlogs4" value="PT Logs">Fine Details</button> </div>--}}
{{--                                        </div>--}}
                                        <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">TDS (%)</label>
                                        {{-- <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label> --}}
                                        <div class="col-sm-4 col-lg-3">
                                            <input type="number" id="otheramount" onchange="checkfinalamount(this);" onkeyup="calfinalamount()" name="otheramount" autocomplete="off"  class="form-control number" placeholder="TDS (%)"   class="span11"  value="{{ $salary->salaryothercharges > 0 ? $salary->salaryothercharges : 0 }}">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group" id="Loandiv">
                                        @if(!empty($loandetail))
                                        <label class="col-sm-12" > Loan Detail </label>
                                        <div class="col-sm-10"><table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th> Remarks </th>
                                                    <th> Total Amount </th>
                                                    <th> Paid Amount </th>
                                                    <th> Due Amount </th>
                                                    <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                               @foreach($loandetail as $key=> $value)
                                                <tr>
                                                    <td>{{$value->remark}}</td>
                                                    <td>{{$value->total_amount}}</td>
                                                    <td>{{$value->paid_amount}}</td>
                                                    <td>{{$value->due_amount}}</td>
                                                    <td><input type="hidden" name="Loan_loanid[]" value="{{$value->hr_loandetail_id}}" />
                                                       <input min="0" max="{{$value->due_amount}}" type="number" placeholder="Amount" value="{{$value->amount}}" name="Loan_amount[]" onchange="checkfinalamount(this,'Loan',{{$key}})" onkeyup="totalloan_amount('Loan',{{$key}})" id="Loan_amount{{$key}}" class="form-control" /> </td>
                                                    </tr>
                                                @endforeach
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th style="text-align: right" colspan="5">Loan Return Amount : <label id="totalLoan_amount">0</label></th>
                                                </tr>
                                                </tfoot>
                                                </table></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group" id="Finediv">
                                        @if(!empty($finedetail))
                                            <label class="col-sm-12" > Fine Detail </label>
                                            <div class="col-sm-10">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th> Remarks </th>
                                                        <th> Total Amount </th>
                                                        <th> Paid Amount </th>
                                                        <th> Due Amount </th>
                                                        <th> Action </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($finedetail as $key=> $value)
                                                        <tr>
                                                            <td>{{$value->remark}}</td>
                                                            <td>{{$value->total_amount}}</td>
                                                            <td>{{$value->paid_amount}}</td>
                                                            <td>{{$value->due_amount}}</td>
                                                            <td><input type="hidden" name="Fine_loanid[]" value="{{$value->hr_loandetail_id}}" />
                                                                <input min="0" max="{{$value->due_amount}}" type="number" placeholder="Amount" name="Fine_amount[]" value="{{$value->amount}}" onchange="checkfinalamount(this,'Fine',{{$key}})" onkeyup="totalloan_amount('Fine',{{$key}})" id="Fine_amount{{$key}}" class="form-control" /> </td>
                                                        </tr>
                                                    @endforeach
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th style="text-align: right" colspan="5">Loan Return Amount : <label id="totalFine_amount">0</label></th>
                                                    </tr>
                                                    </tfoot>
                                                </table></div>
                                        @endif
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function (){
                                        setTimeout(function (){totalloan_amount('Loan',0);},0)
                                        setTimeout(function (){totalloan_amount('Fine',0);},1000)
                                        setTimeout(function (){calfinalamount();},1000)
                                    });
                                    function totalloan_amount(type,i){
                                        var sum = 0;
                                        $('input[name="'+type+'_amount[]"]').each(function(){
                                            sum += +$(this).val();
                                        });
                                        // alert(sum);
                                        var current_salary = Number($('#current_salary').val());
                                        if(sum <= current_salary){
                                            $('#total'+type+'_amount').text(sum);
                                        }else{
                                            sum=0;
                                            $('input[name="'+type+'_amount[]"]').each(function(){
                                                sum += +$(this).val();
                                            });
                                            $('#total'+type+'_amount').text(sum);
                                        }
                                        // var finalamount = calfinalamount();
                                        // if(finalamount < 0){
                                        //     alert('Final Amount '+finalamount +' Not Valid');
                                        //     $('#total'+type+'_amount').text(0);
                                        //     $('#'+type+'_amount'+i).val('');
                                        // }
                                    }
                                    function checkfinalamount(e,type=null,i=0){
                                        var finalamount = calfinalamount();
                                        if(finalamount < 0){
                                            alert('Final Amount '+finalamount.toFixed(0) +' Not Valid');
                                            if(type!=null) {
                                                $('#total' + type + '_amount').text(0);
                                                $('#' + type + '_amount' + i).val('');
                                            }else{
                                                $(e).val(0);
                                            }
                                        }
                                    }
                                    function calfinalamount(){
                                        var subtotal = $('#subtotal').val();
                                        var bonus = $('#bonus').val();
                                        var tds = $('#otheramount').val();
                                        var totalLoan_amount = $('#totalLoan_amount').text();
                                        var totalFine_amount = $('#totalFine_amount').text();
                                        var deductedamount = $('#deductedamount').val();

                                        var tdsamount = ((Number(subtotal) + Number(bonus) + Number(totalLoan_amount)) * tds)/100;
                                        var finalamount = (Number(subtotal) + Number(bonus)) - (Number(tdsamount) + Number(totalFine_amount) + Number(totalLoan_amount) + Number(deductedamount))
                                        if(Number(finalamount) >= 0) {
                                            $('#current_salary').val(finalamount.toFixed(0));
                                        }
                                        return finalamount;
                                    }
                                </script>
{{--                            <div class="row">--}}
{{--                               <div class="">--}}
{{--                                  <div class="form-group">--}}
{{--                                      <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Loan Amount</label>--}}
{{--                                     <input type="hidden" name="loan"  class="form-control" value="{{ $loanamount }}">--}}
{{--                                     <div class="col-sm-4 col-lg-3">--}}
{{--                                        <input type="text" class="form-control" id="loan" placeholder="PT" name="loan" value="{{ $loanamount }}" readonly="">--}}
{{--                                     </div>--}}
{{--                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Loan Return</label>--}}
{{--                                     <div class="col-sm-4 col-lg-3">--}}
{{--                                        <input type="number" name="emi" onfocusOut="calsal()" class="form-control" max="{{ $loanamount }}"  id="emi" value="{{ $salary->salaryemi > 0 ? $salary->salaryemi : 0 }}" >--}}
{{--                                     </div>--}}
{{--                                  </div>--}}
{{--                               </div>--}}
{{--                            </div>--}}
{{--                             <div class="row">--}}
{{--                               <div class="">--}}
{{--                                  <div class="form-group">--}}
{{--                                      <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Fine Amount</label>--}}
{{--                                     <input type="hidden" name="loanfine"  class="form-control" value="{{ $loanfine }}">--}}
{{--                                     <div class="col-sm-4 col-lg-3">--}}
{{--                                         <input type="number" class="form-control" id="loanfine" placeholder="Fine" name="loanfine" value="{{ $loanfine }}" readonly="" >--}}
{{--                                     </div>--}}
{{--                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Fine Return</label>--}}

{{--                                     <div class="col-sm-4 col-lg-3">--}}

{{--                                       <input type="number" name="emi2" onfocusOut="calsal()" class="form-control" max="{{ $loanfine }}"  id="emi2"  value="{{ $salary->salaryemi2 > 0 ? $salary->salaryemi2 : 0 }}">--}}


{{--                                     </div>--}}
{{--                                  </div>--}}
{{--                               </div>--}}
{{--                            </div>--}}
                            </div>
                            <div class="row">
                               <div class="">
                                  <div class="form-group">

                                      <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Other Amount </label>

                                     <div class="col-sm-4 col-lg-3">

                                       <input type="number" id="deductedamount" onchange="calfinalamount();checkfinalamount(this);" name="deductedamount"  class="form-control" placeholder="Other Amount"   value="{{ $salary->salarydeductedamount > 0 ? $salary->salarydeductedamount : 0 }}"  >

                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Final Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" name="current_salary" style="border:1px solid;" class="form-control number" min="0" id="current_salary" autocomplete="off" value="{{ $salary->currentsalary }}" required="" readonly max="10">
                                     </div>
                                     @if($errors->has('current_salary'))
                                     <span class="help-block">
                                        <strong>{{ $errors->first('current_salary') }}</strong>
                                  </span>
                                  @endif
                                  </div>
                               </div>
                            </div>
                             <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label>
                                     <div class="col-sm-4 col-lg-3">

                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Remarks</label>
                                     <div class="col-sm-4 col-lg-3">
                                                            <textarea name="remark" required="" class="form-control"  placeholder="Remarks">{{$salary->remark}}</textarea>
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <center>
                                <div class="form-row" style="margin-top: 35px; margin-left: 15px;">
                                    <button type="submit" class="btn btn-primary bg-green" id="submit">Update Salary</button>
                                    <a href="{{ route('viewsalary') }}" class="btn btn-danger">cancel</a>
                                </div>
                            </center>
                         </div>
                      </div>

                   </div>
                </div>
             </div>
            </form>
       </section>
    </div>
 </div>

@endsection


  <!-- Modal -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Employee Logs</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive" style="height: auto;overflow-y: auto">
                <table class="table">
                    <thead>
                        <th>Date</th>
                        <th>Timein1</th>
                        <th>Timeout1</th>
                        <th>Timein2</th>
                        <th>Timeout2</th>
                        <th>Timein3</th>
                        <th>Timeout3</th>
                    </thead>
                    <tbody>
                    @php

                        foreach (getSundays(date('Y',strtotime($year)), date('m',strtotime($month))) as $key => $wednesday) {
                          if($key<5){
                             $sunday[]= $wednesday->format("d-m-Y");
                          }

                          }

                    @endphp
                        @foreach($employeelog as $emplog)
                            @php
                                $hours=0;
                                $diff=0;
                                 for ($i=1;$i<=3;$i++){
                                    $time1 = strtotime($emplog['timein'.$i]);
                                    $time2 = strtotime($emplog['timeout'.$i]);
                                    $diff = $diff +  round(abs($time2 - $time1) / 60,2);

                                    }
                                    $hours = (floor($diff / 60).':'.round(($diff -   floor($diff / 60) * 60),2));
                            @endphp
                            <tr @if(date('D',strtotime($emplog->dateid))!='Sun')
                                 @if($emplog->timein1 <= 0)
                                 style="color:red;"
                                 @endif
                                 @if ($hours < $empworkinghour-1)
                                 style="color:blue;"
                                    @endif
                                    @endif >
                                <td>{{date('d-m-Y',strtotime($emplog->dateid))}}</td>
                                <td>{{$emplog->timein1}}</td>
                                <td>{{$emplog->timeout1}}</td>
                                <td>{{$emplog->timein2}}</td>
                                <td>{{$emplog->timeout2}}</td>
                                <td>{{$emplog->timein3}}</td>
                                <td>{{$emplog->timeout3}}</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="ptlogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Employee PT Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-inverse">

                        <th>Member</th>
                        <th>PIN</th>
                        <th>Scheme</th>
                        <th>Total Session</th>
                        <th>Per Session Amount</th>
                        <th>Total Amount</th>

                        </thead>
                        <tbody>
                        @if(!empty($ptlogsdisplay))
                            @if(count($ptlogsdisplay) > 0)
                                @foreach($ptlogsdisplay as $key => $ptlog)
                                    <tr>
                                        <td>{{$ptlog->firstname}} {{$ptlog->lastname}}</td>
                                        <td>{{$ptlog->pin}}</td>
                                        <td>{{$ptlog->schemename}}</td>
                                        <td>{{$ptlog->count}}</td>
                                        <td>{{$ptlog->persessionamt}}</td>
                                        <td>{{$ptlog->ptlogscountamt}}</td>
                                    </tr>

                                @endforeach
                            @endif
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="nondutyptlogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Non Duty PT Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-inverse">
                        <th>Member</th>
                        <th>PIN</th>
                        <th>Scheme</th>
                        <th>Total Session</th>
                        <th>Per Session Amount</th>
                        <th>Total Amount</th>

                        </thead>
                        <tbody>
                        @if(!empty($nondutylogdisplay))
                            @if(count($nondutylogdisplay) > 0)
                                @foreach($nondutylogdisplay as $key => $ptlog)
                                    <tr>
                                        <td>{{$ptlog->firstname}} {{$ptlog->lastname}}</td>
                                        <td>{{$ptlog->pin}}</td>
                                        <td>{{$ptlog->schemename}}</td>
                                        <td>{{$ptlog->count}}</td>
                                        <td>{{$ptlog->persessionamt}}</td>
                                        <td>{{$ptlog->nondutycountamt}}</td>
                                    </tr>

                                @endforeach
                            @endif
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


   <div class="modal fade" id="ptlogs2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Date Wise Leave</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-inverse">
                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Status</th>
{{--                                        <th>Action</th>--}}
                    </thead>
                    <tbody>
                        @if(!empty($empleave))
                               @foreach($empleave as $key => $employee)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                @php

                                                    $fname = !empty($employee->empname->first_name) ? $employee->empname->first_name : '';
                                                    $lname = !empty($employee->empname->last_name) ? $employee->empname->last_name : '';

                                                @endphp
                                                <td>{{ $fname }} {{ $lname }}</td>
                                                <td>{{ date('d-m-Y', strtotime($employee->date)) }}</td>
                                                <td>{{ $employee->reason }}</td>
                                                <td>{{ $employee->status }}</td>
{{--                                                <td>--}}
{{--                                                    <a  class="edit" href="{{ route('editemployeeleave', $employee->employeeleaveid) }}" title="edit"><i class="fa fa-edit"></i></a>--}}
{{--                                                    <a  class="delete"  onclick="return myFunction();" href="{{ route('deleteemployeeleave', $employee->employeeleaveid) }}" title="delete"><i class="fa fa-trash"></i></a>--}}
{{--                                                </td>--}}
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="ptlogs3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Loan Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-inverse">
                                        <th>Employee</th>
                                                <th>Type</th>
                                                <th>Amount</th>
  <th>Date</th>
                                                 <th>Remarks</th>                    </thead>
                    <tbody>
                        @if(!empty($account))
                                                @foreach($account as $accountdata)
                                                    <tr>

                                                        <td><?php echo (!empty($accountdata->employeename->first_name) ? ucfirst($accountdata->employeename->first_name) : '') ?> <?php echo (!empty($accountdata->employeename->last_name)) ? ucfirst($accountdata->employeename->last_name) : '' ?></td>
                                                         <td>{{ ucfirst($accountdata->type) }}</td>
                                                        <td>{{ $accountdata->enteramount }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($accountdata->empaccountdate)) }}</td>
                                                  <td>{{ $accountdata->remark }}</td>
                                                       <!--  <td>
                                                           <a  class="edit"  href="{{ route('editleave' , $accountdata->empaccountid) }}" title="edit"><i class="fa fa-edit"></i></a>
                                                        </td> -->
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ptlogs4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Fine Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-inverse">
                                        <th>Employee</th>
                                                <th>Type</th>
                                                <th>Amount</th>
<th>Date</th>
                                                 <th>Remarks</th>                    </thead>
                    <tbody>
                        @if(!empty($accountfine))
                                                @foreach($accountfine as $accountdata)
                                                    <tr>

                                                        <td><?php echo (!empty($accountdata->employeename->first_name) ? ucfirst($accountdata->employeename->first_name) : '') ?> <?php echo (!empty($accountdata->employeename->last_name)) ? ucfirst($accountdata->employeename->last_name) : '' ?></td>
                                                        <td>{{ ucfirst($accountdata->type) }}</td>
                                                        <td>{{ $accountdata->enteramount }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($accountdata->empaccountdate)) }}</td>
                                                  <td>{{ $accountdata->remark }}</td>
                                                       <!--  <td>
                                                           <a  class="edit"  href="{{ route('editleave' , $accountdata->empaccountid) }}" title="edit"><i class="fa fa-edit"></i></a>
                                                        </td> -->
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@push('script')

<script type="text/javascript">
$(document).ready(function(){
   // calsal();
});
   let globalemi=$('#emi').val();
      let globalemi2=$('#emi2').val();

   let globalotheramout=$('#otheramount').val();
   // $(document).ready(function(){

   //     var leavetakencount = {{ $salary->takenleave }};


   //     if(leavetakencount > 0){
   //         $('#submit').attr('disabled', 'true');
   //     }

   //     $('#employeeid').change(function(){

   //         let empid = $(this).val();
   //         if(empid){
   //            $('#mobileno option[value='+empid+']').prop('selected', true);
   //        }
   //    });

   // });


   $('#casualleave').on('input', function(){
       //calculatesalary();
       calsal();
   });

   $('#medicalleave').on('input', function(){
       //calculatesalary();
       calsal();
   });
   $('#bonus').on('input', function(){
       //calculatesalary();
      //  calbonus();
      //  calsal();
      //  additioncalculate();

   });

   $('#paidleave').on('input', function(){
       //calculatesalary();
       calsal();


   });

   $('#extrahour').on('input', function(){
       //calculatesalary();
       calsal();
   });

   $('#takenleave').change(function(){
       $('#casualleave').val(0);
       $('#medicalleave').val(0);
       $('#paidleave').val(0);
   });
      function deducteda(){

         let deductedamount = $('#deductedamount').val();
         var  commsalary= $('#current_salary').val();


         commsalary = commsalary -  Number(deductedamount);
         commsalary=commsalary.toFixed(2);
         $('#current_salary').val(Number(commsalary));

   }
   function caldays(type,val)
   {

   let actualdays = $('#actualdays').val();
   let attenddays_disp = {{ $salary->attenddays }};
   let takenleave_disp = {{ $salary->takenleave }};
   let salary = $('#salary').val();
   let workingdays = $('#workingdays').val();
   let current_salary = $('#current_salary').val();
   let perdaysalary = monthlysalary/workingdays;
   let casualleave = $('#casualleave').val();
   let medicalleave = $('#medicalleave').val();
   let paidleave = $('#paidleave').val();
   let emi = $('#emi').val();
   let otheramount = $('#otheramount').val();
   let loanamount = $('#loan').val();
   let totalleave= 0;
   let commsalary=$('#current_salary').val();
   let nondutyhoursamount = $('#nondutyhoursamount').val();
   let extrahour = $('#extrahour').val();
      // $('#extrahoursalary').val(0);
   let leftdays = Number(actualdays) - Number(val);
   let totaldays = Number(leftdays) + Number(val);
   if(!otheramount){
        otheramount = 0;
    }

    if(!emi){
        emi = 0;
    }




   if(leftdays < 0){
       alert('Pease Enter valid days');
       $('#attenddays').val(attenddays_disp);
       $('#takenleave').val(takenleave_disp);
       $('#current_salary').val(current_salary);
        $('#subtotal').val(current_salary);

       $('#casualleave').val('');
       $('#medicalleave').val('');
       $('#paidleave').val('');

   }else{

       if(type=='takenleave')
      {
         $('#attenddays').val(leftdays);
         $('#absday').val(val);
         $('#takenleave12').val(val);
         calsal();
         deductioncalculate();
      }
       else
       {

           $('#takenleave').val(leftdays);
           $('#absday').val(leftdays);
           $('#takenleave12').val(leftdays);
           calsal();
           deductioncalculate();
       }

   }
   }

function calsal(){

    let salary = $('#salary').val();
    let workingdays = $('#workingdays').val();
    let empworkinghour = {{ $empworkinghour }};
    let monthlysalary = $('#monthlysalary').val();
    let attenddays = $('#attenddays').val();

    let takenleave = $('#takenleave').val();
    let casualleave = $('#casualleave').val();
    let medicalleave = $('#medicalleave').val();
    let paidleave = $('#paidleave').val();
    let actualdays = $('#actualdays').val();
    let perdaysalary = monthlysalary/workingdays;
    let perhoursalary = perdaysalary/empworkinghour;
    let nondutyhoursamount = $('#nondutyhoursamount').val();
    let emi = $('#emi').val();

    let otheramount = $('#otheramount').val();
    let totalsession= $('#totalsession').val();
    let deductsessionsalary= perhoursalary*Number($('#totalsession').val());

    let totalsessionprice = $('#totalsessionprice_display').val();
    let extrahour = $('#extrahour').val();
    $('#extrahoursalary').val(0);
    if(!otheramount){
        otheramount = 0;
    }
    if(!emi){
        emi = 0;
    }

    let totalleave = Number(casualleave) + Number(medicalleave) + Number(paidleave);
    let commsalary = (Number(workingdays)) * Number(perdaysalary);
    commsalary =  commsalary - (Number(takenleave)) * Number(perdaysalary);

    calleave();

    if(Number(workingdays) == 0){

        $('#current_salary').val(0);
        $('#subtotal').val(0);
        $('#emi').val(0);
        $('#emi2').val(0);

        $('#otheramount').val(0);
        $('#extrahoursalary').val(0);

    }else{

        let attendhour = Number(workingdays) * Number(empworkinghour);
        $('#totalworkinghour').val(attendhour);

        let attendminute = Number(workingdays) * Number(empworkinghour) * 60;
        $('#workingminute').val(attendminute);

        if(Number(casualleave) > 0 ){

            let totalsalary = Number(casualleave) * Number(perdaysalary);
            commsalary = Number(commsalary) + Number(totalsalary);

        }
        if(Number(medicalleave) > 0){

            let totalsalary = Number(medicalleave) * Number(perdaysalary);
            commsalary = Number(commsalary) + Number(totalsalary);

        }

        commsalary=commsalary.toFixed(2);
        $('#subtotal').val(Number(commsalary));
        if(totalsession > 0 )
        {
            commsalary = commsalary - Number(deductsessionsalary);
            commsalary = commsalary + Number(totalsessionprice);
            commsalary=commsalary.toFixed(2);
            $('#subtotal').val(Number(commsalary));

        }
        if(nondutyhoursamount){
            commsalary = Number(commsalary) + Number(nondutyhoursamount);
            commsalary=commsalary.toFixed(2);
            $('#subtotal').val(Number(commsalary));
        }
        if(extrahour){
            let extraslary = perhoursalary*Number(extrahour);
            $('#extrahoursalary').val(Number(extraslary.toFixed(2)));
            commsalary = Number(commsalary) + Number(extraslary);
            commsalary=commsalary.toFixed(2);
            $('#subtotal').val(Number(commsalary));
        }
        var finalamount = calfinalamount();
        if(finalamount < 0){
            alert('Final Amount '+finalamount +' Not Valid');
            $('#submit').attr('disabled', 'true');
            return false;
        }

        if(Number(totalleave) == Number(takenleave)){

            $('#submit').removeAttr('disabled');
        }else{
            console.log('totalleave'+totalleave);
            console.log('takenleave'+takenleave);
            $('#submit').attr('disabled', 'true');
        }
    }

}
   function calleave()
   {
        let takenleave = $('#takenleave').val();
        let casualleave = $('#casualleave').val();
        let medicalleave = $('#medicalleave').val();
        let paidleave = $('#paidleave').val();
        let totalleave = Number(casualleave) + Number(medicalleave) + Number(paidleave);

        if(takenleave < totalleave)
        {
            alert('Please enter valid leave');
            $('#casualleave').val('');
            $('#medicalleave').val('');
            $('#paidleave').val('');
        }
        else{

        }
   }
   // function calemi(){
   //    let emi = $('#emi').val();
   //    let emi2 = $('#emi2').val();
   //
   //    if(emi > 0 ){
   //       emi=emi;
   //    }else{
   //       emi=0;
   //    }
   //    let loanamount = $('#loan').val();
   //    var commsalary= $('#subtotal').val();
   //    let deductedamount = $('#deductedamount').val();
   //
   //    if(Number(emi) > Number(loanamount) || Number(emi) > Number(commsalary))
   //    {
   //
   //       $('#emi').val('');
   //
   //    }
   //    else if(Number(emi2) > Number(loanfine) || Number(emi2) > Number(commsalary))
   //    {
   //       $('#emi2').val('');
   //    }
   //    else{
   //       if(globalemi != emi){
   //          commsalary = commsalary - Number(emi);
   //                      commsalary = commsalary - Number(emi2);
   //
   //                      commsalary = commsalary -  Number(deductedamount);
   //
   //             commsalary=commsalary.toFixed(2);
   //                      $('#otheramount').val('0');
   //
   //             $('#current_salary').val(Number(commsalary));
   //             globalemi=emi;
   //
   //
   //
   //       }
   //
   //
   //    }
   //    additioncalculate();
   // }
   // function calemi2(){
   //    let emi2 = $('#emi2').val();
   //          let emi = $('#emi').val();
   //
   //    if(emi2 > 0 ){
   //       emi2=emi2;
   //    }else{
   //       emi2=0;
   //    }
   //    let loanfine = $('#loanfine').val();
   //    let loanamount = $('#loan').val();
   //
   //    var  commsalary= $('#subtotal').val();
   //         let deductedamount = $('#deductedamount').val();
   //    if(Number(emi) > Number(loanamount) || Number(emi) > Number(commsalary))
   //    {
   //       $('#emi').val(0);
   //
   //    }
   //    else if(Number(emi2) > Number(loanfine) || Number(emi2) > Number(commsalary))
   //    {
   //
   //       $('#emi2').val('');
   //
   //    }else{
   //       if(globalemi2 != emi2){
   //          commsalary = commsalary - Number(emi2);
   //                      commsalary = commsalary - Number(emi);
   //
   //                      commsalary = commsalary -  Number(deductedamount);
   //
   //             commsalary=commsalary.toFixed(2);
   //                      $('#otheramount').val('0');
   //
   //             $('#current_salary').val(Number(commsalary));
   //             globalemi2=emi2;
   //
   //
   //
   //       }
   //
   //
   //    }
   //    calsal();
   //
   // }
   // function additioncalculate(){
   //    let bonus = $('#bonus').val();
   //
   //
   //    if(emi2 > 0 ){
   //       emi2=emi2;
   //    }else{
   //       emi2=0;
   //    }
   //    var  commsalary= Number($('#current_salary').val());
   //    if(Number(bonus) > Number(commsalary))
   //    {
   //
   //       $('#bonus').val('2');
   //
   //    }else{
   //          commsalary = commsalary + Number(bonus);
   //         $('#current_salary').val(commsalary.toFixed(2));
   //    }
   // }
   // function calotheramount()
   // {
   //    let emi2 = $('#emi2').val();
   //
   //    let emi = $('#emi').val();
   //    var  subtotal= $('#subtotal').val();
   //    let deductedamount = $('#deductedamount').val();
   //
   //    let otheramount = $('#otheramount').val();
   //    var  commsalary= $('#subtotal').val();
   //    let loanamount = $('#loan').val();
   //    let loanfine =  $('#loanfine').val();
   //    if(Number(otheramount) > Number(commsalary))
   //    {
   //       alert('Please enter valid deduction amount');
   //       $('#otheramount').val('');
   //    }
   //
   //    else if (Number(otheramount) > 100)
   //    {
   //       $('#otheramount').val('');
   //       alert('Discount should not be greater than 100');
   //    }
   //    else if(Number(emi) > Number(loanamount) || Number(emi) > Number(commsalary))
   //    {
   //       $('#emi').val('');
   //
   //    }
   //    else if(Number(emi2) > Number(loanfine) || Number(emi2) > Number(commsalary))
   //    {
   //       $('#emi2').val('');
   //    }else if(deductedamount > Number(commsalary)){
   //       $('#deductedamount').val('');
   //    }
   //    else
   //    {
   //       subtotal = subtotal - Number(emi);
   //       subtotal = subtotal - Number(emi2);
   //       // subtotal=subtotal.toFixed(2);
   //       subtotal = subtotal -  Number(deductedamount);
   //       let baseamount_disount_cal = Number((subtotal*otheramount)) / 100;
   //       baseamount_disount_cal = subtotal - Number(baseamount_disount_cal);
   //       baseamount_disount_cal=baseamount_disount_cal.toFixed(2);
   //       $('#current_salary').val(Number(baseamount_disount_cal));
   //
   //    }
   //      additioncalculate();
   // }
   //
   // function deductioncalculate(){
   //
   //    var otheramount=$('#otheramount').val();
   //    var emi=$('#emi').val();
   //    var bonus = $('#bonus').val();
   //    if(otheramount > 0){
   //          let subtotal = $('#subtotal').val();
   //          subtotal = subtotal - Number(otheramount);
   //          subtotal = subtotal.toFixed(2);
   //          globalotheramout = otheramount;
   //
   //          $('#current_salary').val(Number(subtotal));
   //       }
   //       else{
   //          otheramount = 0;
   //       }
   //
   //       if(emi > 0){
   //          let subtotal = $('#subtotal').val();
   //          subtotal = subtotal - Number(emi);
   //          subtotal = subtotal.toFixed(2);
   //          globalemi = emi;
   //          $('#current_salary').val(Number(subtotal));
   //       }else{
   //          emi = 0;
   //       }
   //       calotheramount();
   //       // additioncalculate();
   // }
</script>
@endpush
