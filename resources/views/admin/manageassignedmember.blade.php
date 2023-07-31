<?php
 include('..///config/database.php');
 include('..///config/session.php');
?>

@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<!-- <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
 <style type="text/css">
   .table-bordered {
    border: 1px solid #f4f4f4;
}
 </style>
 <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
  <style type="text/css">
    .customcheck {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.customcheck input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #babbba;
    border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.customcheck:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.customcheck input:checked ~ .checkmark {
    background-color: #00c0ef;
    border-radius: 5px;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
} .select2{
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

/* Show the checkmark when checked */
.customcheck input:checked ~ .checkmark:after {
    /*display: block;*/
    content: "";
    color: #20b904;
}

/* Style the checkmark/indicator */
.customcheck .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  </style>

  @php

  if(isset($_POST['trainerid'])){
     $tid=$_POST['trainerid'];
     $employee=\App\Employee::where('employeeid',$tid)->where('status',1)->get()->first();
     if(!(empty($employee)))
     {
     if(!empty($employee->username))
     {
      $employeename=$employee->username;
     }
   }
  }
  else{
    $tid=0;
  }
  if(isset($_POST['memberid'])){

    $mid=$_POST['memberid'];
    $membername=\App\Member::where(['memberid' => $mid])->get(['firstname','lastname'])->first();
    $membername=$membername->firstname.' '.$membername->lastname;

  }
  else{
    $mid=0;
  }
  if(isset($_POST['packageid'])){
    $pid=$_POST['packageid'];
    $package=\App\MemberPackages::where('memberpackagesid',$pid)->get()->first();
    $schemeid=$package->schemeid;
    $scheme= \App\Scheme::where('schemeid',$schemeid)->where('status',1)->get()->first();
    $schemename=$scheme->schemename;
  }
  else{
    $pid=0;
  }
@endphp
@if(request()->route('tid'))
@php
  $tid=request()->route('tid');
@endphp
@endif
@if(request()->route('mid'))
@php
  $mid=request()->route('mid');
@endphp
@endif
@if(request()->route('pid'))
@php
 $pid=request()->route('pid');
@endphp

@endif
  <div class="content-wrapper">


<!--          <section class="content-header"><h2>Manage Member</h2></section>
 -->          <!-- general form elements -->
           <section class="content">

              @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
            <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Manage Member</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="{{ URL::route('manageassignedmember') }}" method="post"  >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="col-md-3">
                <div class="form-group">
                  <label>Trainer</label>
                  @if(Session::get('role')=="trainer")

                    @php
                    $trainerid=Session::get('employeeid');
                    $trainername=Session::get('username');
                    @endphp
                    <input type="text" class="form-control" name="trainername" id="trainername" readonly="" value="{{$trainername}}">
                     <input type="hidden" name="trainerid" id="trainerid"  value="{{$trainerid}}">
                  @else
                      <select name="trainerid" class="form-control select2" id="trainerid" title="Select Trainer" data-header="Select Trainer" required data-placeholder="Select Trainer">

                    <option></option>
                    @foreach ($employees as $employee)
                      <option value="{{$employee->employeeid}}" {{ $tid == $employee->employeeid ? 'selected':''}}>@if($employee->username){{$employee->username}}@endif</option>
                    @endforeach
                  </select>
                  @endif
                </div>
              </div>

                <div class="col-md-3">
                <div class="form-group">
                  <label>Member</label>
                   <select name="memberid" class="form-control select2" id="memberid" required>
                      <option value="">Select Member</option>
                    </select>
                </div>
              </div>
              <!-- <div class="col-md-3">
                  <div class="form-group">
                  <label>Mobile No.</label>
                  <input type="text" class="form-control" placeholder="Mobile No." name="mobileno" id="mobileno" readonly>
                </div>
              </div> -->
<!--                 <script type="text/javascript">
                  $('#memberid').change(function(){
                       var member = $('#memberid').val();
                    // alert(member);


                              $.ajax({
                                   url:"{{ URL::route('assignptmembermobileno') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member},
                                  success:function(data) {
                                    // alert(data);

                                      // $('#mobile_no').fadeIn().html(data);

                                     // $('#mobile_no').html('<option value="'+data+'">'+data+'</option>');
                                     // alert($('#mobileno').val());
                                     $('#mobileno').val(data);
                                  },

                              });

                              // $('select[name="mobile_no"]').fadeIn();
                 });
                  $(document).ready(function(){
                    var member = $('#memberid').val();
                    // alert(member);
                              $.ajax({
                                   url:"{{ URL::route('assignptmembermobileno') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member},
                                  success:function(data) {
                                    // alert(data);

                                      // $('#mobile_no').fadeIn().html(data);

                                     // $('#mobile_no').html('<option value="'+data+'">'+data+'</option>');
                                     // alert($('#mobileno').val());
                                     $('#mobileno').val(data);
                                  },

                              });
                  });
                </script> -->
                <div class="col-md-6">
                <div class="form-group">
                  <label>Package</label>
                 <select name="packageid" class="form-control select2" id="packageid" title="Select Package"  required>
               <option value="">Select Package</option>

                  </select>
                </div>
              </div>
              <!--   <script type="text/javascript">
                  $('#memberid').change(function(){
                      $('#pthour').val('');
                       $('#packageid').find('option:not(:first)').remove();
                       var member = $('#memberid').val();
                    // alert(member);


                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member,'type':'package','schemeid':''},
                                   async:false,
                                  success:function(data) {
                                    // alert(data);
                                      $.each(data, function(i, item){

                                        $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(item.schemename));

                                      });
                                  },
                                  dataType:'json',

                              });

                              // $('select[name="mobile_no"]').fadeIn();
                 });
                  $(document).ready(function(){
                    $('#pthour').val('');
                       $('#packageid').find('option:not(:first)').remove();
                       var member = $('#memberid').val();
                    // alert($('#memberid').val());


                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member,'type':'package','schemeid':''},
                                   async:false,
                                  success:function(data) {
                                    // alert(data);
                                      $.each(data, function(i, item){

                                        html="<option";
                                          if(item.memberpackagesid=="<?php if(isset($packageid)){echo $packageid;} ?>")
                                          {
                                            html+=" selected";
                                          }
                                        html+="></option>";

                                        $("#packageid").append($(html).attr("value", item.memberpackagesid).text(item.schemename));

                                      });
                                  },
                                  dataType:'json',

                              });
                  });
                </script> -->
                 <div class="col-md-3">
                <div class="form-group">
                  <label>Training Hours</label>
                  <input type="text" class="form-control" placeholder="Trainer Hours" name="pthour" id="pthour" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>From Date</label>
                <input type="date" name="fromdate" class="form-control" id="fromdate" value="{{ $fromdate ? $fromdate : ''}}" >
                </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>To Date</label>
                <input type="date" name="todate" class="form-control" id="todate"  value="{{$todate}}">

              </div>
          </div>
                <!-- <div class="form-group">
                  <label>From Date</label>
                  <input type="date" onkeypress="return false" class="form-control" name="date" value="<?php echo date('Y-m-d');?>" id="date">
                </div> -->
                 <script type="text/javascript">
                  $('#packageid').change(function(){

                       var member = $('#memberid').val();
                    // alert(member);

                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":'','type':'pthour','schemeid':$('#packageid').val()},
                                  success:function(data) {
                                    // swal(data,"Successfully",'success');
                                    $('#pthour').val(data);

                                  },

                              });

                              // $('select[name="mobile_no"]').fadeIn();
                 });
                $(document).ready(function(){
                  var member = $('#memberid').val();
                    // alert($('#packageid').val());
                             setTimeout(function (){
                                 $.ajax({
                                     url:"{{ URL::route('assignptmemberpackage') }}",
                                     method:"GET",
                                     data:{"_token": "{{ csrf_token() }}","memberid":'','type':'pthour','schemeid':$('#packageid').val()},
                                     success:function(data) {
                                         // swal(data,"Successfully",'success');
                                         $('#pthour').val(data);

                                     },

                                 });
                             },2000);
                });
                </script>
               <div class="form-group">
                    <button name="view" type="submit" id="view" class="btn bg-green margin" style="margin-top: 25px">View</button>   <a href="{{ URL::route('manageassignedmember') }}"class="btn btn-danger margin" style="margin-top: 25px">Cancel</a>

                </div>
                <!-- Select multiple-->


              </form></div>
          <div style="overflow: auto;">
             <table id="example1" class="table table-bordered table-striped dataTable dt-responsive"  width="100%">
               <thead>
                <tr>
                  <th colspan="2"><center>Schedule</center></th>
                  <!-- <th></th> -->
                  <th colspan="2"><center>Actual</center></th>
                  <th colspan="2"></th>
                </tr>
                <tr>
                  <th style="display: none;"></th>
                  <th>Schedule Date</th>
                  <th>Schedule Time</th>
                 <!--  <th>Day</th> -->
                  <th>Actual Date</th>
                  <th>Actual Time</th>
                  <th>Trainee</th>
                  <th>Status</th>
               </tr>
               </thead>
               <tbody>
               @php
               $totalclaim = 0;
               $totalskip = 0;
               $totalpending = 0;
               @endphp
                @foreach($grid as $i => $data)
                @if($data->hoursfrom!='')
                    <tr>
                      <td style="display: none;"></td>
                      @if($data->status=='Conducted' || $data->status=='Marked' || $data->status=='Paid' || $data->status=='PaidPending')
                      <?php
                            $totalclaim++;
                        $claimptsession = DB::table('claimptsession')->where(['trainerid'=>$data->trainerid,'memberid'=>$data->memberid,'scheduledate'=>$data->date])->get();
                      ?>
                       <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                      <td id="2td{{$i}}"> {{$data->hoursfrom}} </td>

                    <!-- <td>{{$data->day}}</td> -->
                      <td>{{(isset($claimptsession[0]))?date('d-m-Y',strtotime($claimptsession[0]->actualdate)):''}}</td>
                    <td>{{(isset($claimptsession[0]))?$claimptsession[0]->actualtime:''}}</td>
                      <td id="3td{{$i}}"> {{$data->username}}</td>
                      <td>
                        <input type="hidden" name="mid{{$i}}" id="mid{{$i}}" value="{{$data->ptmemberid}}">
                        <form role="form" id="myform" action="{{ URL::route('claimptsession') }}" method="post"  >
                         {{ csrf_field() }}
                         <input type="hidden" name="ptmemberid" value="{{$data->ptmemberid}}">
                          <label style="color: green">Claimed</label>
                        </form>
                      </td>
                      @endif
                      @if($data->status=='Pending')
                        <?php
                            $totalskip++;
                        $claimptsession=DB::table('claimptsession')->where(['trainerid'=>$data->trainerid,'memberid'=>$data->memberid,'scheduledate'=>$data->date])->get();
                      ?>
                      <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                      <td id="2td{{$i}}"> {{$data->hoursfrom}} </td>
                      <!-- <td>{{$data->day}}</td> -->
                      <td>{{date('d-m-Y',strtotime($claimptsession[0]->actualdate))}}</td>
                      <td>{{$claimptsession[0]->actualtime}}</td>
                      <td id="3td{{$i}}"> {{$data->username}}</td>
                      <td>
                        <input type="hidden" name="mid{{$i}}" id="mid{{$i}}" value="{{$data->ptmemberid}}">
                        <form role="form" id="myform" action="{{ URL::route('claimptsession') }}" method="post"  >
                         {{ csrf_field() }}
                         <input type="hidden" name="ptmemberid{{$i}}" id="ptmemberid{{$i}}" value="{{$data->ptmemberid}}">
                        <a data-toggle="modal" data-target="#pinmodal" id="pin{{$i}}" data-placement="top" onclick="getrow({{$i}})" title="PIN"> <label style="color: red"> Enter PIN</label></a>
                        </form>
                      </td>
                      @endif
                      @if($data->status=='Active')
                          @php $totalpending++; @endphp
                      <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                      <td id="2td{{$i}}">
                        {{$data->hoursfrom}}
                        <!-- <select name="time{{$i}}" class="form-control" id="time{{$i}}" disabled="">

                          <option value="06:00" @if($data->hoursfrom=='06:00'){{'selected'}}@endif>06:00</option>
                          <option value="07:00" @if($data->hoursfrom=='07:00'){{'selected'}}@endif>07:00</option>
                          <option value="08:00" @if($data->hoursfrom=='08:00'){{'selected'}}@endif>08:00</option>
                          <option value="09:00" @if($data->hoursfrom=='09:00'){{'selected'}}@endif>09:00</option>
                          <option value="10:00" @if($data->hoursfrom=='10:00'){{'selected'}}@endif>10:00</option>
                          <option value="11:00" @if($data->hoursfrom=='11:00'){{'selected'}}@endif>11:00</option>
                          <option value="12:00" @if($data->hoursfrom=='12:00'){{'selected'}}@endif>12:00</option>
                          <option value="13:00" @if($data->hoursfrom=='13:00'){{'selected'}}@endif>13:00</option>
                          <option value="14:00" @if($data->hoursfrom=='14:00'){{'selected'}}@endif>14:00</option>
                          <option value="15:00" @if($data->hoursfrom=='15:00'){{'selected'}}@endif>15:00</option>
                          <option value="16:00" @if($data->hoursfrom=='16:00'){{'selected'}}@endif>16:00</option>
                          <option value="17:00" @if($data->hoursfrom=='17:00'){{'selected'}}@endif>17:00</option>
                          <option value="18:00" @if($data->hoursfrom=='18:00'){{'selected'}}@endif>18:00</option>
                          <option value="19:00" @if($data->hoursfrom=='19:00'){{'selected'}}@endif>19:00</option>
                          <option value="20:00" @if($data->hoursfrom=='20:00'){{'selected'}}@endif>20:00</option>
                          <option value="21:00" @if($data->hoursfrom=='21:00'){{'selected'}}@endif>21:00</option>
                          <option value="22:00" @if($data->hoursfrom=='22:00'){{'selected'}}@endif>22:00</option>
                          <option value="23:00" @if($data->hoursfrom=='23:00'){{'selected'}}@endif>23:00</option>
                        </select> --></td>
                      <!-- <td>{{$data->day}}</td> -->
                      <td></td>
                      <td></td>
                      <td id="3td{{$i}}">
                        {{$data->username}}
                      </td>
                      <td>
                        <input type="hidden" name="mid{{$i}}" id="mid{{$i}}" value="{{$data->ptmemberid}}">
                        <form role="form" id="myform" action="{{ URL::route('claimptsession') }}" method="post"  >
                         {{ csrf_field() }}
                         <input type="hidden" name="ptmemberid" value="{{$data->ptmemberid}}">
                        <!--  <a data-toggle="tooltip" onclick="listenForDoubleClickedit({{$i}}) " id="edit{{$i}}" data-placement="top" title="Edit" class="btn-bx edit"><i class=" glyphicon glyphicon-edit"></i></a> -->
                         <a data-toggle="tooltip" onclick="listenForDoubleClickok({{$i}}) " id="ok{{$i}}" data-placement="top" title="Submit" class="btn-bx" style="display: none;"><i class=" glyphicon glyphicon-ok"></i></a>
                         <!--  <a data-toggle="tooltip" id="a{{$i}}" value="{{$i}}" onclick="hidea(this)" style="color:green" data-placement="top" title="Claim" onclick="document.getElementById('myform').submit()" class=""><i class=" glyphicon glyphicon-list"></i></a> -->
                        </form>
                      </td>

                      @endif

                    </tr>
                    @endif
                @endforeach

               </tbody>
                 <tfoot>
                 <tr>
                     <td>Pending Session</td>
                     <td><b>{{$totalpending}}</b></td>
                     <td>Claim Session</td>
                     <td><b>{{$totalclaim}}</b></td>
                     <td>Skip Session</td>
                     <td><b>{{$totalskip}}</b></td>
                 </tr>
                 </tfoot>
             </table>
           </div>

            </div>
            <!-- /.box-body -->
          </div>

  </section>
  <script type="text/javascript">
    function getrow(i) {
      // alert(element);
     var ptmemberid= $('#ptmemberid'+i).val();
     $('#ptid').val(ptmemberid);
      // $('#2td16').contentEditable = true;
    }
  </script>
  <div class="modal fade" id="pinmodal" tabindex="-1" role="dialog" aria-labelledby="titleymodalLabel" aria-hidden="true">'
      <div class="modal-dialog modal-md">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="Label">PTP For Session <l id="ld"></l> <l id="lt" ></l></h4>

            </div>

            <div class="modal-body" style="display:none; text-align:center" id="bagtypemodalprogress">

                <img src="./img/progress.gif" alt="Loading..." />

            </div>

            <div id="modalalert" class="alert alert-danger alert-dismissable" style="display:none">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    Incorrect PIN.

                </div>

            <div class="modal-body" id="trainermodalcontent">
              <div class="row">
              <div class="col-sm-8">
              <div class="col-sm-offset-3">
                <label>Enter PIN</label>
                <input type="hidden" name="ptid" id="ptid" class="form-control" value="">
                <input type="text" name="ptp" id="ptp" class="form-control" value="">
              </div>
            </div>
            </div>

            </div>


            <div class="modal-footer">

                <button type="button" id="close" class="btn btn-danger" data-dismiss="modal">Close</button>

                <button name="checkptp" id="checkptp" type="button" class="btn btn-success">Save</button>

            </div>
</div>

    </div>


</div>
<script type="text/javascript">
      $('.select2').select2()

  $('#checkptp').click(function(){
    $.ajax({
          url:"{{ URL::route('claimptsession') }}",
          method:"GET",
           data:{"_token": "{{ csrf_token() }}","ptid":$('#ptid').val(),"memberid":$('#memberid').val(),"ptp":$('#ptp').val()},
          success:function(data) {
            // alert(data);
            if(data!="error")
            {
              $('#view').trigger('click');
            }
            else
            {
              $('#modalalert').show();
              $('#ptp').val('');

            }
          },
          dataType:'json',

          });
  });
</script>

<!-- <script type="text/javascript">
  $('#trainerid').on('change',function(){


  var trainerid=$('#trainerid').val();
  $.ajax({
          url:"{{ url('gettrainermember') }}",
          method:"GET",
           data:{"_token": "{{ csrf_token() }}","trainerid":trainerid},
          success:function(data) {

            if(data)
            {
              $('#memberid').find('option:not(:first)').remove();
             $.each(data, function(i, item){
                $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.firstname+' '+item.lastname));
              });
            }
            else
            {


            }
          },
          dataType:'json',

          });
   });
</script>
   -->
<script type="text/javascript">
  var tid=<?php echo $tid;?>;
      var mid=<?php echo $mid;?>;
      var pid=<?php echo $pid;?>;

 $( document ).ready(function() {
     var tid=<?php echo $tid;?>;
      var mid=<?php echo $mid;?>;
      var pid=<?php echo $pid;?>;

      if(trainerid == 0 && memberid == 0 && packageid ==0){
        $('#sessionreport').css('display','none');
      }
      if(trainerid !== 0){

      }
      if(memberid !== 0){

      }
    $('#trainerid').trigger('change');
 // $('#memberid').trigger('change');


});

 $('#view').on('click',function(){

 })
</script>
<script type="text/javascript">

  $('#trainerid').change(function(){
    var trainerid = $('#trainerid').val();
    $('#memberid').find('option:not(:first)').remove();
    $.ajax({
      url:"{{ url('getsessiontrainermember') }}",
      method:"GET",
      data:{"_token": "{{ csrf_token() }}","trainerid":trainerid},
      success:function(data) {
       var  result=data;
        if(result){
          $.each(result, function(i, item){
          $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.firstname+' '+item.lastname));
          });
          $("#memberid option[value="+mid+"]").attr("selected", "selected");
          if(mid){
            $("#memberid").trigger('change');
          }
        }
      },
      dataType:'json',
    });
  });
</script>
<script type="text/javascript">
  $('#memberid').change(function(){
    var member1 = $('#memberid').val();
    $.ajax({
      url:"{{ URL::route('getpackage') }}",
      method:"GET",
      data:{"_token": "{{ csrf_token() }}","memberid":member1},
      async:false,
      success:function(data) {
        if(data){
          $('#packageid').find('option:not(:first)').remove();
          $.each(data, function(i, item){
            $('#mobileno').val(item.mobileno);
           let current_datetime = new Date(item.joindate)
                        let joindate = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
                        let enddatetime = new Date(item.expiredate)
                        let end_date = enddatetime.getDate() + "-" + (enddatetime.getMonth() + 1) + "-" + enddatetime.getFullYear();
            $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(item.schemename+ ' Start ' +joindate+ ' End ' +end_date ));
          });
          $("#packageid option[value="+pid+"]").attr("selected", "selected");
        }
      },
      dataType:'json',
    });
  });
</script>

<script type="text/javascript">
  $(document).ready( function (){
  $('#example1').DataTable({
    "lengthMenu": [[7, 10, 15, -1], [7, 10, 15, "All"]]
  });
});
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
