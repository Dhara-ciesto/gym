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


/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: 80vh;
    overflow-y: auto;
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


@endphp
<div class="wrapper">
    <div class="content-wrapper">
       <!-- <section class="content-header">
          <div class="row">
             <div class="col-md-12">
                <ol class="breadcrumb">

                   <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                   <li><a href="{{ route('viewemployeeaccount') }}">Salary</a></li>
                   <li class="active">Calculate Salary</li>
                </ol>
             </div>
          </div>
       </section> -->
       <section>

            <form method="post" class="form" action="{{ route('storeempsalary') }}">
                <input type="hidden" id="employeeid" name="employeeid" value="{{ $employeeid }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="month_display" value="{{ $month }}">
                <input type="hidden" name="Workindays" value="{{ $Workindays }}">
                <input type="hidden" name="holidays" value="{{ $holidays }}">
                <input type="hidden" name="totalworkinghour" value="{{ $totalworkinghour }}">
                <input type="hidden" name="empworkingminute" value="{{ $empworkingminute }}">
                <input type="hidden" name="monthlyworking_hour_display" value="{{ $empattandedhours }}">
                <input type="hidden" name="totalworkinghour_display" id="totalworkinghour"  value="{{ $totalhour_dispaly_model }}">
                <input type="hidden" name="workingminute" id="workingminute" value="{{ $totalminute_dispaly }}">
                <input type="hidden" name="empsalary" value="{{ $empsalary }}">
                <input type="hidden" name="givenleave" value="{{ $givenleave }}">
                <input type="hidden" name="store" value="1">
                <input type="hidden" name="cal_month" value="{{ $cal_month }}">
                @csrf
             <div class="row">
                <div class="col-lg-12 col-md-8">
                   <div class="row">
                      <div class="box">
                         <div class="box-header">
                            <h3 class="box-title">Salary #<b>{{ ucfirst($empdata->first_name) }} {{ ucfirst($empdata->last_name) }}</b></h3>
                            <h3 class="box-title  pull-right"><b>{{ $month.'-'.$year }}</b></h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Total Days</label>
                                     <input type="text" class="form-control" id="workingdays" value="{{ $Workindays+$holidays }}" name="workingdays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 ">
                                  <div class="form-group">
                                     <label>Working Days</label>
                                     <input type="text" class="form-control" id="actualdays"  name="actualdays_display"  value="{{ $Workindays }}" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Non Working Days</label>
                                     <input type="text" class="form-control" id="holiday" value="{{ $holidays }}" name="holidays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Present Days</label>
                                     <input type="text" class="form-control" id="attenddays" name="attenddays_display"  value="{{ $attenddays }}" oninput="caldays('pday', this.value)" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Absent Days</label>
                                     <input type="text" class="form-control" id="takenleave" name="takenleave_display" value="{{ $leavedays_cal }}" oninput="caldays('takenleave', this.value)" readonly      required="" autocomplete="off">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                    <button type="button" id="editallow" class="btn btn-default" style="margin-top:23px;" for="edit">Edit</button>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>


                               <!-- Dashboard duty hours start -->
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
                    <div style="display: block;">
                        <div @if($showhours == 1) style="display: block;" @else style="display: none;" @endif>
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
                                                    <input type="hidden" class="form-control" name="totalsessionprice" id="totalsessionprice" placeholder="price" value="{{ $allsessionprice }}"readonly >

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
                                                    <input type="text" class="form-control"  id="PT" placeholder="PT" value="{{ $totalfloorhour+$trainersession }}" readonly>
                                                </div>
                                                <div class="col-sm-4 col-lg-3">
                                                    <input type="text" class="form-control" id="totaltrainersalary" placeholder="Floor" value="{{ round(($totalfloorhour*$perhoursalary)+$totalsessionprice,2)}}" readonly>
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
                                    $totalnondutyhours =0;
                                    if($nondutyhours > 0){
                                        $totalnondutyhours = $nondutyhours;
                                    }



                                    @endphp

                                        <div class="row">
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Total Non Duty hours</label>
                                                    <div class="col-sm-4 col-lg-3">
                                                        <input type="text" class="form-control" id="totalnondutyhours" placeholder="Floor" value="{{ $totalnondutyhours }}"readonly >
                                                    </div>
                                                    <div class="col-sm-4 col-lg-3">

                                                        <input type="text" class="form-control" id="nondutyhoursamount" placeholder="Floor" value="{{ $nondutyhoursamount }}"readonly >
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
                                                    <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Extra hours</label>
                                                    <div class="col-sm-4 col-lg-3">
                                                        <input type="text" class="form-control" id="extrahour" name="extrahour" placeholder="Extra hours" value="" >
                                                    </div>
                                                    <div class="col-sm-4 col-lg-3">

                                                        <input type="text" class="form-control" id="extrahoursalary" placeholder="Extra hours Salary" name="extrahoursalary"value=""readonly >
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" @if($showleave == 1) style="display: block;" @else style="display: none;" @endif>
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
                                            <input type="text" class="form-control" id="absday" placeholder="Floor" value="{{ $leavedays_cal }}" readonly>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <br>
                                    <div class="col-md-2 col-lg-2 col-xs-6">
                                        <div class="form-group hide">
                                            <label>Extra</label>
                                            <input type="text" class="form-control" id="attenddays23" value="0" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xs-6 hide">
                                        <div class="form-group">
                                            <label>Casual leave</label>
                                            <input type="text" class="form-control" name="casualleave" id="casualleave" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xs-6" style="display:none;">
                                        <div class="form-group">
                                            <label>Medical Leave</label>
                                            <input type="text" class="form-control" name="medicalleave" id="medicalleave" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xs-6 ">
                                        <div class="form-group">
                                            <label>Leave</label>
                                            <input type="text" class="form-control" name="paidleave" id="paidleave" value="0">
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-lg-2 col-xs-6">
                                        <div class="form-group">
                                            <label>Total Leave</label>
                                            <input type="text" class="form-control" id="takenleave12" value="{{ $leavedays_cal  }}" readonly>
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
                          <?php $loanfine = !empty($emploanamountfine->amount) ? $emploanamountfine->amount : 0; ?>

                            <?php $loanamount = !empty($emploanamount->amount) ? $emploanamount->amount : 0; ?>
                            <?php $type = !empty($emploanamount->type) ? $emploanamount->type : NULL; ?>

                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Monthly Salary</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="monthlysalary" placeholder="PT" value="{{ $empsalary }}" readonly>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Sub Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" placeholder="PT" name="subtotal" id="subtotal"
                                        value="{{ $current_salary }}" readonly >
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
                                          <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Bonus / PT Incentive</label>

                                          <div class="col-sm-4 col-lg-3">

                                              <input type="number" onchange="checkfinalamount(this);" onkeyup="calfinalamount()" name="bonus" class="form-control"   id="bonus"  value="">


                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="">

                                      <div class="form-group">

                                          <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label>
                                          <input type="hidden" name="loanfine"  class="form-control" value="{{ $loanfine }}">
                                          <div class="col-sm-4 col-lg-3">
{{--                                              <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#ptlogs3" id="ptlogs3" value="PT Logs">Loan Details</button>--}}

{{--                                              <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#ptlogs4" id="ptlogs4" value="PT Logs">Fine Details</button> --}}
                                          </div>

                                          <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">TDS (%)</label>
                                          <div class="col-sm-4 col-lg-3">
                                              <!--    <input type="number" name="otheramount" class="form-control" min="0" id="otheramount" onfocusOut="calotheramount()" onfocusIn="storeotheramt()"> -->
                                              <input type="number" id="otheramount" onchange="checkfinalamount(this);" onkeyup="calfinalamount()" name="otheramount" autocomplete="off"  class="form-control number" placeholder="TDS (%)"   class="span11" >
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <br>
                            <div class="row">
                                   <div class="form-group" id="Loandiv">
{{--                                  <div class="form-group">--}}
{{--                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Loan Amount</label>--}}
{{--                                     <input type="hidden" name="loan"  class="form-control" value="{{ $loanamount }}">--}}
{{--                                     <div class="col-sm-4 col-lg-3">--}}
{{--                                        <input type="text" class="form-control" id="loan" placeholder="PT" name="loan" value="{{ $loanamount }}" readonly="">--}}
{{--                                     </div>--}}
{{--                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Loan Return</label>--}}
{{--                                     --}}{{-- <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label> --}}
{{--                                     <div class="col-sm-4 col-lg-3">--}}
{{--                                        <input type="number" name="emi" onfocusOut="calsal('loanamount')" class="form-control" max="{{ $loanamount }}"  id="emi">--}}
{{--                                     </div>--}}
{{--                                  </div>--}}
                               </div>
                            </div>
                              <div class="row">
                                  <div class="form-group" id="Finediv">
                                  </div>
                              </div>
                              <script>
                                  $(document).ready(function (){
                                      setTimeout(function (){getloan('Loan');},0)
                                      setTimeout(function (){getloan('Fine');},1000)
                                  });
                                  function getloan(type){
                                      $('#'+type+'div').empty();
                                      // $('#amountdiv').empty();
                                      var employeeid = $('#employeeid').val();
                                      // if(type=='EMI') {
                                      html = '';
                                      $.ajax({
                                          url: "{{ url('ajaxgetpendingloan') }}",
                                          method: "POST",
                                          data: {type:type,employeeid: employeeid, "_token": "{{ csrf_token() }}"},
                                          success: function (data) {
                                              if(data.length > 0) {
                                                  html += '<label class="col-sm-12" > '+type+' Detail </label>' +
                                                      '<div class="col-sm-10"><table class="table table-bordered table-striped">';
                                                  html += '<thead>';
                                                  html += '<tr>';
                                                  html += '<th> Remarks </th>';
                                                  html += '<th> Total Amount </th>';
                                                  html += '<th> Paid Amount </th>';
                                                  html += '<th> Due Amount </th>';
                                                  html += '<th> Action </th>';
                                                  html += '</tr>';
                                                  html += '</thead>';
                                                  html += '<tbody>';
                                                  $.each(data, function (i, item) {
                                                      html += '<tr>';
                                                      html += '<td>' + item.remark + '</td>';
                                                      html += '<td>' + item.total_amount + '</td>';
                                                      html += '<td>' + item.paid_amount + '</td>';
                                                      html += '<td>' + item.due_amount + '</td>';
                                                      html += '<td><input type="hidden" name="'+type+'_loanid[]" value="' + item.hr_loan_id + '" /> <input min="0" max="' + item.due_amount + '" type="number" placeholder="Amount" name="'+type+'_amount[]" onchange="checkfinalamount(this,\''+type+'\','+i+')" onkeyup="totalloan_amount(\''+type+'\','+i+')" id="'+type+'_amount'+i+'" class="form-control" /> </td>';
                                                      html += '</tr>';
                                                  });
                                                  html += '<tbody>';
                                                  html += '</tbody>' +
                                                      '<tfoot>' +
                                                      '<tr>' +
                                                      '<th style="text-align: right" colspan="5">'+type+' Return Amount : <label id="total'+type+'_amount">0</label></th>' +
                                                      '</tr>' +
                                                      '</tfoot>';
                                                  html += '</table></div>';
                                                  $('#'+type+'div').append(html);
                                              }
                                          },
                                          dataType: "json"
                                      });
                                      {{--}else{--}}
                                      {{--    $('#amountdiv').append('<label>Amount<span style="color: red;">*</span></label> <input type="text" name="amount" value="{{ $amount }}" class="form-control" maxlength="8" required="">');--}}
                                      {{--}--}}
                                  }
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

                                      var tdsamount = ((Number(subtotal) + Number(bonus) - Number(totalFine_amount)) * tds)/100;
                                      var finalamount = (Number(subtotal) + Number(bonus)) - (Number(tdsamount) + Number(totalFine_amount) + Number(totalLoan_amount) + Number(deductedamount))
                                      if(Number(finalamount) >= 0) {
                                          $('#current_salary').val(finalamount.toFixed(0));
                                      }
                                      return finalamount;
                                  }
                              </script>
{{--                              <div class="row">--}}
{{--                               <div class="">--}}
{{--                                  <div class="form-group">--}}
{{--                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Fine Amount</label>--}}
{{--                                     <input type="hidden" name="loanfine"  class="form-control" value="{{ $loanfine }}">--}}
{{--                                     <div class="col-sm-4 col-lg-3">--}}
{{--                                        <input type="number" class="form-control" id="loanfine" placeholder="Fine" name="loanfine" value="{{ $loanfine }}" readonly="" >--}}
{{--                                     </div>--}}
{{--                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Fine Return</label>--}}
{{--                                     --}}{{-- <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label> --}}
{{--                                     <div class="col-sm-4 col-lg-3">--}}
{{--                                        <input type="number" name="emi2" onfocusOut="calsal('loanfine')" class="form-control" max="{{ $loanfine }}"  id="emi2">--}}
{{--                                     </div>--}}
{{--                                  </div>--}}
{{--                               </div>--}}
{{--                            </div>--}}

                            <div class="row">
                               <div class="">
                                  <div class="form-group">

                                      <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Other Amount </label>
                                   <input type="hidden" name="type"  class="form-control" value="{{ $type }}">

                                     <div class="col-sm-4 col-lg-3">

                            <input type="number" id="deductedamount" onchange="calfinalamount();checkfinalamount(this);" name="deductedamount"  class="form-control" placeholder="Other Amount"   >
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Final Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" name="current_salary" style="border:1px solid;" class="form-control number" min="0" id="current_salary" autocomplete="off" value="{{ $current_salary }}" required="" readonly max="10">
                                     </div>
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
                                            <textarea name="remark" required="" class="form-control"  placeholder="Remarks"></textarea>
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <center>
                                <div class="form-row" style="margin-top: 35px; margin-left: 15px;">
                                    <button type="submit" class="btn btn-primary bg-green" id="submit">Save Salary</button>
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
                        <th>Check In </th>
                        <th>Check Out </th>
                        <th>Check In </th>
                        <th>Check Out </th>
                        <th>Check In </th>
                        <th>Check Out </th>
                        <th>Total Hour</th>
                        <th></th>
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

                                <td>{{ $hours}}</td>

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
{{--                        <th>Action</th>--}}
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
{{--                                 <td>--}}
{{--                                       <a  class="edit" href="{{ route('editemployeeleave', $employee->employeeleaveid) }}" title="edit"><i class="fa fa-edit"></i></a>--}}
{{--                                       <a  class="delete"  onclick="return myFunction();" href="{{ route('deleteemployeeleave', $employee->employeeleaveid) }}" title="delete"><i class="fa fa-trash"></i></a>--}}
{{--                                 </td>--}}
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
                        <th>Remarks</th>
                    </thead>
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
                                                 <th>Remarks</th>

                    </thead>
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
   let globalemi=$('#emi').val();

   let globalemi2=$('#emi2').val();
   let globalotheramout=$('#otheramount').val();

   $(document).ready(function(){

       var leavetakencount = {{ $leavedays_cal }};


       if(leavetakencount > 0){
           $('#submit').attr('disabled', 'true');
       }
       calsal();

    });
  //   function deductioncalculate(){
  //
  //    var otheramount=$('#otheramount').val();
  //    var emi=$('#emi').val();
  //    let commsalary = $('#subtotal').val();
  //        if(otheramount > 0){
  //                 if(Number(otheramount) > Number(commsalary))
  //           {
  //              alert('Please enter valid deduction amount');
  //              $('#otheramount').val('');
  //           }
  //
  //           else if (Number(otheramount) > 100)
  //           {
  //              $('#otheramount').val('');
  //              alert('Discount should not be greater than 100');
  //           }
  //           let baseamount_disount_cal = Number((commsalary*otheramount)) / 100;
  //              baseamount_disount_cal = commsalary - Number(baseamount_disount_cal);
  //              baseamount_disount_cal=baseamount_disount_cal.toFixed(2);
  //           $('#current_salary').val(Number(baseamount_disount_cal));
  //
  //
  //        }
  //        else{
  //           otheramount = 0;
  //        }
  //
  //        if(emi > 0){
  //
  //          let subtotal = $('#current_salary').val();
  //          subtotal = subtotal - Number(emi);
  //          subtotal = subtotal.toFixed(2);
  //          globalemi = emi;
  //                     globalemi2 = emi2;
  //
  //          $('#current_salary').val(Number(subtotal));
  //        }else{
  //           emi = 0;
  //        }
  // }
   $("#editallow").on('click',function(){
      if($('#attenddays').prop('readonly')){
         $("#attenddays").prop('readonly',false);
         $("#takenleave").prop('readonly',false);
       }
       else{
         $("#attenddays").prop('readonly',true);
         $("#takenleave").prop('readonly',true);
       }
   });
   $('#casualleave').on('input', function(){
       //calculatesalary();
       calsal();
      //  deductioncalculate();
   });

   $('#medicalleave').on('input', function(){
       //calculatesalary();
       calsal();
      //  deductioncalculate();
   });
   // var bonusvalue = '';
   // $('#bonus').on('change', function(){
   //    var emi = $('#emi').val();
   //    var emi2 = $('#emi').val();
   //     //calculatesalary();
   //    //  calbonus();
   //     calsal();
   //     if($('#current_salary').val() < 0){
   //         alert('loan amount is greater than final amount');
   //         $('#bonus').val(bonusvalue);
   //         calsal();
   //         return false;
   //     }
   //     bonusvalue = $('#bonus').val();
   //    //  deductioncalculate();
   //    //  additioncalculate();
   //
   // });

   $('#paidleave').on('input', function(){
       //calculatesalary();
       calsal();

      //  deductioncalculate();
      //  additioncalculate();
   });

   $('#extrahour').on('input', function(){
       //calculatesalary();
       calsal();
      //  deductioncalculate();
      //  additioncalculate();
   });
   $('#takenleave').change(function(){
       $('#casualleave').val(0);
       $('#medicalleave').val(0);
       $('#paidleave').val(0);
   });


   function caldays(type,val)
   {

      let actualdays = $('#actualdays').val();
      let current_salary_disp = {{ $current_salary }};
      let attenddays_disp = {{ $attenddays }};
      let takenleave_disp = {{ $leavedays_cal }};
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
      let loanfine = $('#loanfine').val();

      let totalleave= 0;

      let leftdays = Number(actualdays) - Number(val);

      let totaldays = Number(leftdays) + Number(val);
      $('#casualleave').val('');
      $('#medicalleave').val('');
      $('#paidleave').val('');
      $('#emi').val('');
            $('#emi2').val('');

      $('#otheramount').val('');


   if(leftdays < 0){
       alert('Pease Enter valid days');
       $('#attenddays').val(attenddays_disp);
       $('#takenleave').val(takenleave_disp);
       $('#current_salary').val(current_salary_disp);
       $('#subtotal').val(current_salary_disp);

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
         //   deductioncalculate();
       }
       else
       {
           $('#takenleave').val(leftdays);
           $('#absday').val(leftdays);
           $('#takenleave12').val(leftdays);
           calsal();
         //   deductioncalculate();
       }
   }
   }

       function calsal(){

            let salary = $('#salary').val();
            let workingdays = $('#workingdays').val();
            let current_salary = $('#current_salary').val();
            let current_salary_disp = {{ $current_salary }};
            let attenddays_disp = {{ $attenddays }};
            let takenleave_disp = {{ $takenleave }};
            let empworkinghour = {{ $empworkinghour }};
            let monthlysalary = $('#monthlysalary').val();
            let attenddays = $('#attenddays').val();
            let totalworkinghour = $('#totalworkinghour').val();
            let takenleave = $('#takenleave').val();
            let casualleave = $('#casualleave').val();
            let medicalleave = $('#medicalleave').val();
            let paidleave = $('#paidleave').val();
            let actualdays = $('#actualdays').val();
            let leavedays_cal  = Number(actualdays) - Number(attenddays);
            let perdaysalary = monthlysalary/workingdays;
            let perhoursalary = perdaysalary/empworkinghour;
             let nondutyhoursamount = $('#nondutyhoursamount').val();
            var holidays = Number($('#holiday').val());
            let emi = $('#emi').val();
                    let emi2 = $('#emi2').val();

            let otheramount = $('#otheramount').val();
            let loanamount = $('#loan').val();
                    let loanfine = $('#loanfine').val();
                    let deductedamount = $('#deductedamount').val();
            let totalsession= $('#totalsession').val();
            let deductsessionsalary= perhoursalary*Number($('#totalsession').val());

            let totalsessionprice = $('#totalsessionprice_display').val();
            let extrahour = $('#extrahour').val();
            let bonus = $('#bonus').val();
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
 //   function additioncalculate(){
 //      let bonus = $('#bonus').val();
 //
 //
 //      if(emi2 > 0 ){
 //         emi2=emi2;
 //      }else{
 //         emi2=0;
 //      }
 //      var  commsalary= Number($('#current_salary').val());
 //
 //      if(Number(bonus) > Number(commsalary))
 //      {
 //
 //         $('#bonus').val('2');
 //
 //      }else{
 //            commsalary = commsalary + Number(bonus);
 //           $('#current_salary').val(commsalary.toFixed(2));
 //      }
 //   }
 //   function deducteda(){
 //     let emi = $('#emi').val();
 //          let emi2 = $('#emi2').val();
 //
 // var  subtotal= $('#subtotal').val();
 //
 //
 //
 //
 //      let deductedamount = $('#deductedamount').val();
 //
 //      var  commsalary= $('#current_salary').val();
 //
 //    commsalary = subtotal - Number(emi);
 //    commsalary = commsalary - Number(emi2);
 //
 //            commsalary = commsalary -  Number(deductedamount);
 //               commsalary=commsalary.toFixed(2);
 //                        $('#otheramount').val('0');
 //
 //               $('#current_salary').val(Number(commsalary));
 //
 //
 //   }
 //   function calemi(){
 //      let emi = $('#emi').val();
 //            let emi2 = $('#emi2').val();
 //
 //      if(emi > 0 ){
 //         emi=emi;
 //      }else{
 //         emi=0;
 //      }
 //      let loanamount = $('#loan').val();
 //      var  commsalary= $('#subtotal').val();
 //           let deductedamount = $('#deductedamount').val();
 //
 //      if(Number(emi) > Number(loanamount) || Number(emi) > Number(commsalary))
 //      {
 //
 //         $('#emi').val('');
 //
 //      }else{
 //         if(globalemi != emi){
 //            commsalary = commsalary - Number(emi);
 //                        commsalary = commsalary - Number(emi2);
 //
 //                        commsalary = commsalary -  Number(deductedamount);
 //
 //               commsalary=commsalary.toFixed(2);
 //                        $('#otheramount').val('0');
 //
 //               $('#current_salary').val(Number(commsalary));
 //               globalemi=emi;
 //
 //
 //
 //         }
 //
 //
 //      }
 //      additioncalculate();
 //   }
 //   function calemi2(){
 //      let emi2 = $('#emi2').val();
 //            let emi = $('#emi').val();
 //
 //      if(emi2 > 0 ){
 //         emi2=emi2;
 //      }else{
 //         emi2=0;
 //      }
 //      let loanfine = $('#loanfine').val();
 //      var  commsalary= $('#subtotal').val();
 //           let deductedamount = $('#deductedamount').val();
 //
 //      if(Number(emi2) > Number(loanfine) || Number(emi2) > Number(commsalary))
 //      {
 //
 //         $('#emi2').val('');
 //
 //      }else{
 //         if(globalemi2 != emi2){
 //            commsalary = commsalary - Number(emi2);
 //                        commsalary = commsalary - Number(emi);
 //
 //                        commsalary = commsalary -  Number(deductedamount);
 //
 //               commsalary=commsalary.toFixed(2);
 //                        $('#otheramount').val('0');
 //
 //               $('#current_salary').val(Number(commsalary));
 //               globalemi2=emi2;
 //
 //
 //
 //         }
 //
 //
 //      }
 //      calsal();
 //      // additioncalculate();
 //      // deductioncalculate();
 //
 //   }
 //   function calotheramount()
 //   {
 //      let emi2 = $('#emi2').val();
 //
 //      let emi = $('#emi').val();
 //      var  subtotal= $('#subtotal').val();
 //      let deductedamount = $('#deductedamount').val();
 //
 //      let otheramount = $('#otheramount').val();
 //      var  commsalary= $('#subtotal').val();
 //      let loanamount = $('#loan').val();
 //      if(Number(otheramount) > Number(commsalary))
 //      {
 //         alert('Please enter valid deduction amount');
 //         $('#otheramount').val('');
 //      }
 //
 //      else if (Number(otheramount) > 100)
 //      {
 //         $('#otheramount').val('');
 //         alert('Discount should not be greater than 100');
 //      }
 //      else if(Number(emi) > Number(loanamount) || Number(emi) > Number(commsalary))
 //      {
 //         $('#emi').val('');
 //
 //      }
 //      else if(Number(emi2) > Number(loanfine) || Number(emi2) > Number(commsalary))
 //      {
 //         $('#emi2').val('');
 //      }
 //      else
 //      {
 //         subtotal = subtotal - Number(emi);
 //         subtotal = subtotal - Number(emi2);
 //         // subtotal=subtotal.toFixed(2);
 //         subtotal = subtotal -  Number(deductedamount);
 //         let baseamount_disount_cal = Number((subtotal*otheramount)) / 100;
 //         baseamount_disount_cal = subtotal - Number(baseamount_disount_cal);
 //         baseamount_disount_cal=baseamount_disount_cal.toFixed(2);
 //         $('#current_salary').val(Number(baseamount_disount_cal));
 //
 //         additioncalculate();
 //         deductioncalculate();
 //
 //      }
 //
 //   }

   function storeotheramt(){

      var commsalary= $('#current_salary').val();
   }

</script>
@endpush
