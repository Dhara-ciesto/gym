<?php 
   include('..///config/database.php');
   //include('..///config/session.php');
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
<!--  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
   <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->`
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css"> -->
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
   /* When the checkbox is checked, add a green background */
   .customcheck input:checked ~ .checkmark {
   background-color: #00c0ef;
   border-radius: 5px;
   }
   /* Create the checkmark/indicator (hidden when not checked) */
   .checkmark:after {
   content: "";
   position: absolute;
   display: none;
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
   }
</style>
<div class="content-wrapper">
  <section class="content-header">
<!--      <h2>Claim Session</h2>
 -->  </section>
  <!-- general form elements -->
  <section class="content">
     @if(Session::has('msg'))
     <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ Session::get('msg') }}</strong>
     </div>
     @endif
     @if($msg!='')
     @if($msg=="Incorrect OTP" || $msg=="Something Went Wrong" || $msg=="No Any Session Available")
     <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{$msg}}</strong>
     </div>
     @endif
     @if($msg=="Session is successfully Claimed" || $msg=="Claim is Skiped" || $msg=="Session is successfully Marked As Conducted")
     <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{$msg}}</strong>
     </div>
     @endif
     @endif
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
           <h3 class="box-title">Claim Member</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
           <div class="col-lg-3"></div>
           <div class="col-lg-6">
         
              <form role="form" id="myform" action="{{ URL::route('claimptsession') }}" method="post" >
                 {{ csrf_field() }}
                 <!-- text input -->
                 <div class="form-group">
                    <label>Trainer<span style="color: red;">*</span></label>
                    <?php if(Session::get('role')=="admin"){ ?>
                    <select name="trainerid" class="form-control select2" id="trainerid" title="Select Trainer" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Trainer Selected" data-header="Select Trainer" required>
                                             <option value="">Select Trainer</option>

                       @foreach ($employees as $employee)
                       <option value="{{$employee->employeeid}}">{{$employee->username}}</option>
                       @endforeach
                    </select>
                    <?php }else{ ?>
                    <input type="text" name="trainername" class="form-control" value="{{$trainername}}" disabled>
                    <input type="hidden" name="trainerid" value="{{$trainerid}}">
                    <?php } ?>
                 </div>
                 <div class="form-group">
                    <label>Member<span style="color: red;">*</span></label>
                    <select name="memberid" class="form-control select2 " id="memberid" title="Select Memeber" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Memeber Selected" data-header="Select Memeber" required>
                       <option value="">Select Member</option>
                       @foreach ($members as $member)
                       <option value="{{$member->memberid}}"  @if(old('memberid') == $member->memberid) selected @endif>{{$member->firstname .' '. $member->lastname}}</option>
                       @endforeach
                    </select>
                 </div>
                 <div class="form-group">
                    <input type="text" class="form-control" value="{{ old('mobileno') }}" placeholder="Mobile No." name="mobileno" id="mobileno" readonly>
                    <!-- </select> -->
                 </div>
                     <div class="form-group">
                         <label>Package Type<span style="color: red;">*</span>
                         </label> &nbsp;
                         <label><input type="radio" value="yes" name="packageexpire" onclick="$('#memberid').trigger('change')" id="packageexpireyes" checked> Active</label>&nbsp;&nbsp;
                         <label><input type="radio" value="no" name="packageexpire" onclick="$('#memberid').trigger('change')" id="packageexpireno" > Expire </label>
                     </div>
                 <div class="form-group">
                    <label>Package<span style="color: red;">*</span></label>
                    <select name="packageid" class="form-control select2" id="packageid" required="">
                       <option value="">Select Member Package</option>
                    </select>
                 </div>
                 <div class="form-group">
                    <label>Actual Time<span style="color: red;">*</span></label>
                    <!-- <input type="time" class="form-control" placeholder="Trainer Time" name="pttime" id="pttime"> -->
                    <select type="time" class="form-control select2" title="Select Time" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Time Selected" data-header="Select Time" required name="actualtime" id="actualtime" required>
                    <option value="06:00" @if(old('actualtime') == '06:00') selected @endif>06:00 AM</option>
                    <option value="07:00" @if(old('actualtime') == '07:00') selected @endif>07:00 AM</option>
                    <option value="08:00" @if(old('actualtime') == '08:00') selected @endif>08:00 AM</option>
                    <option value="09:00" @if(old('actualtime') == '09:00') selected @endif>09:00 AM</option>
                    <option value="10:00" @if(old('actualtime') == '10:00') selected @endif>10:00 AM</option>
                    <option value="11:00" @if(old('actualtime') == '11:00') selected @endif>11:00 AM</option>
                    <option value="12:00" @if(old('actualtime') == '12:00') selected @endif>12:00 PM</option>
                    <option value="13:00" @if(old('actualtime') == '13:00') selected @endif>01:00 PM</option>
                    <option value="14:00" @if(old('actualtime') == '14:00') selected @endif>02:00 PM</option>
                    <option value="15:00" @if(old('actualtime') == '15:00') selected @endif>03:00 PM</option>
                    <option value="16:00" @if(old('actualtime') == '16:00') selected @endif>04:00 PM</option>
                    <option value="17:00" @if(old('actualtime') == '17:00') selected @endif>05:00 PM</option>
                    <option value="18:00" @if(old('actualtime') == '18:00') selected @endif>06:00 PM</option>
                    <option value="19:00" @if(old('actualtime') == '19:00') selected @endif>07:00 PM</option>
                    <option value="20:00" @if(old('actualtime') == '20:00') selected @endif>08:00 PM</option>
                    <option value="21:00" @if(old('actualtime') == '21:00') selected @endif>09:00 PM</option>
                    <option value="22:00" @if(old('actualtime') == '22:00') selected @endif>10:00 PM</option>
                    <option value="23:00" @if(old('actualtime') == '23:00') selected @endif>11:00 PM</option>
                    </select>  
                 </div>
                 <!--  <div class="form-group">
                    <label>Schedule Date</label>
                    <input type="date" onkeypress="return false" class="form-control" name="scheduledate" id="scheduledate">
                    </div>
                    -->
                     <div class="form-group">
                    <label>Actual Date<span style="color: red;">*</span>
                    </label>
                    <input type="date" onkeypress="return false" class="form-control" value="{{ old('actualdate') }}" name="actualdate" id="actualdate" required>
                 </div>
                 <div class="form-group">
                    <div class="col-sm-offset-3">
                       <div class="col-sm-8">
                          <button name="claim" type="submit" id="claim"  class="btn bg-green margin">Claim</button> 
                          <a href="{{ URL::route('claimptsession') }}"class="btn btn-danger">Cancel</a>
                       </div>
                    </div>
                 </div>
                 <!-- Select multiple-->
                 <div class="modal fade" id="ptpmodal" tabindex="-1" role="dialog" aria-labelledby="titleymodalLabel" aria-hidden="true">
                    '
                    <div class="modal-dialog modal-md">
                       <div class="modal-content">
                          <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                             <h4 class="modal-title" id="Label">FITPIN For Session <b id="ld"></b> <b id="lt" ></b></h4>
                          </div>
                          <div class="modal-body" style="display:none; text-align:center" id="bagtypemodalprogress">
                             <img src="./img/progress.gif" alt="Loading..." />
                          </div>
                          <div class="modal-body" id="trainermodalcontent">
                             <div class="row">
                                <div class="col-sm-8">
                                   <div class="col-sm-offset-3">
                                      <label>Enter PIN</label>
                                      <input type="text" name="ptp" id="ptp" maxlength="4" class="form-control" value="" >
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="modal-footer">
                           @if(Session::get('role')=='admin'|| Session::get('role')=='Admin'|| Session::get('role')=='ADMIN')
                             <button name="skip" type="button" id="skip" class="btn btn-warning">Skip</button>
                           @endif
                             <button name="mark_conduct" type="button" id="mark_conduct" class="btn btn-primary">Mark As Conducted</button>
                             {{-- <button type="button" id="close" data-dismiss="modal" class="btn btn-default" >Close</button> --}}
                             <button name="assigntrainer" id="assigntrainer" type="submit" class="btn btn-success">Claim</button>
                          </div>
                       </div>
                    </div>
                 </div>
              </form>
           </div>
           <div class="col-lg-3"></div>
        </div>
     </div>
     <!-- /.box-body -->
</div>
</section>
</div>
</div>
</div>

<script type="text/javascript">
  $('#trainerid').change(function(){
    $('#memberid').find('option:not(:first)').remove();
  $.ajax({
                   url:"{{ URL::route('getclaimmember') }}",
                   method:"GET",
                   data:{"_token": "{{ csrf_token() }}","trainerid":$('#trainerid').val()},
                  success:function(data) {
  
                    $.each(data,function(i,item){
                      // alert(item.firstname);
                     $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.firstname+' '+item.lastname));
                    });
                  },
                  dataType:'json',
  
              });
  });
</script>
<script type="text/javascript">
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
</script>
<script type="text/javascript">
  $('#memberid').change(function(){
    
      $('#pthour').val('');
       $('#packageid').find('option:not(:first)').remove();
       var member = $('#memberid').val();
       var trainerid = $('#trainerid').val();
    // alert(member);
        var expirestatus = $('input[name="packageexpire"]:checked').val();

        if(expirestatus=='yes'){
            var status=1;
        }else{
            var status=0;
        }
  
              $.ajax({
                   url:"{{ URL::route('assignptmemberpackage') }}",
                   method:"GET",
                   data:{"_token": "{{ csrf_token() }}","memberid":member,'trainerid':trainerid,'type':'package','schemeid':'','status':status},
                   async:false,
                  success:function(data) {
                    // alert(data);
                      $.each(data, function(i, item){
                        let current_datetime = new Date(item.joindate)
                        let joindate = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
                        let enddatetime = new Date(item.expiredate)
                        let end_date = enddatetime.getDate() + "-" + (enddatetime.getMonth() + 1) + "-" + enddatetime.getFullYear();
                        $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(item.schemename+' Start '+joindate+' End  '+end_date));
  
                      });
                  },
                  dataType:'json',
  
              });
          
              // $('select[name="mobile_no"]').fadeIn();
  });
</script>
<script type="text/javascript">
  $('#actualdate').change(function(){
      var packageexpire = $('input[name="packageexpire"]:checked').val()
  $.ajax({
              url:"{{ URL::route('checkfromdate') }}",
              method:"GET",
              data:{"_token": "{{ csrf_token() }}","packageexpire":packageexpire,"fromdate":$('#actualdate').val(),'memberpackagesid':$('#packageid').val()},
  
              success:function(data) {
                // alert(data);
                if(data=="invalid")
                {
                  swal(" Please Select Valid Date","Error!","error");
                  // $('#close').trigger('click');
                  $('#actualdate').val('');
                  checkfromdate();
                }
                if(data=="samedate"){
                     swal({
                           title: "Are you sure?",
                              text: "On This Date Session Is Already Claimed.",
                              icon: "warning",
                              buttons: true,
                              dangerMode: true,
                        });
                }
              },
              // dataType:'json',
  
            });
  });
</script>
<script type="text/javascript">
  $('#memberid').change(function(){
    $('#date1').val('');
    $('#date').val('');
  });
</script>
<script type="text/javascript">
  $('#claim').click(function(){
     $('#ld').empty();
     $('#lt').empty();
     $.ajax({
        url:"{{ URL::route('claimptsession') }}",
        method:"GET",
         data:{"_token": "{{ csrf_token() }}","memberid":$('#memberid').val(),'tid':$('#trainerid').val()},
        success:function(data) {
  
            var todayTime = new Date(data.date);
            var month = todayTime .getMonth() + 1;
            var day = todayTime .getDate();
            var year = todayTime .getFullYear();
            var date = day + "-" + month + "-" + year;
            $('#ld').append(date);
            $('#lt').append(data.hoursfrom);
        },
        dataType:'json',
  
        });
  });
</script>
<script type="text/javascript">
   $('#skip').click(function(){
     // id="10";
     swal({
       title: "Are you sure?",
           text: "Once skiped, you will have to enter pin in Member Session.",
           icon: "warning",
           buttons: true,
           dangerMode: true,
     }).then(
     function(isConfirm){
       if(isConfirm)
       {
         // alert(isConfirm);
         // alert(id);
         swal("Skiped!", "Your Member PTP has been Skiped.", "success");
         $('#skip').attr('type','submit');
         $('#skip').trigger('click');
       }
     });
   
   });
</script>
<script type="text/javascript">
  $('#mark_conduct').click(function(){
    // id="10";
    swal({
      title: "Are you sure?",
          text: "Once Marked, You can not change it.",
          icon: "warning",
          buttons: true,
          closeOnConfirm: true,

        
    }).then(
    function(isConfirm){
      if(isConfirm)
      {
      
      swal("Conducted!", "Member Session is Mark as Conducted.", "success");
         
        $('#mark_conduct').attr('type','submit');
        $('#mark_conduct').trigger('click');
      } 
    })
  });
</script>

<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
  
  })
</script>
<script type="text/javascript">
   $('#packageid').on('change',function(){
     // alert('dfg');
   checkfromdate();
   });
   
   function checkfromdate(){
     $.ajax({
    url:"{{ URL::route('ajaxgetjoindate') }}",
     method:"GET",
      data:{"_token": "{{ csrf_token() }}",'memberpackagesid':$('#packageid').val()},
   
     success:function(data) {
   // alert(data);
   $.each(data,function(i,item){
     // $('#fromdate').val(item.joindate);
     $('#date').val(item.joindate);
     // $('#date1').val(item.expiredate);
     // $('#enddate').val(item.expiredate);
   });
   },
   dataType:'json',
   
   });
   }
</script>
<script type="text/javascript">
   $(document).ready( function (){
   $('#example1').DataTable({
     "lengthMenu": [[7, 10, 15, -1], [7, 10, 15, "All"]]
   });
   /*$(document).on('click', '#close',function(){
     $('#ptpmodal').modal('hide');
   });*/
   });
</script>
@endsection
@push('script')
<script type="text/javascript">
   $(document).ready(function(){
     $('#claim').click(function(){
       let trainerid = $('#trainerid').val();
       let memberid = $('#memberid').val();
       let packageid = $('#packageid').val();
       let actualtime = $('#actualtime').val();
       let actualdate = $('#actualdate').val();
   
       if(trainerid != '' && memberid != '' && packageid != '' && actualtime != '' && actualdate != ''){
         $('#claim').attr('type','button');
         $('#claim').attr('data-target','#ptpmodal');
         $('#claim').attr('data-toggle','modal');
         
       } else {
         $('#claim').attr('type','submit');
         $('#claim').attr('data-target','');
         $('#claim').attr('data-toggle','');
         $('#trainerid').attr('title', 'This field is required.');
         $('#memberid').attr('title', 'This field is required.');
         $('#packageid').attr('title', 'This field is required.');
         $('#actualtime').attr('title', 'This field is required.');
         $('#actualdate').attr('title', 'This field is required.');
         $('#myform').validate({
           rules : {
             trainerid : 'required',
             memberid : 'required',
             packageid : 'required',
             actualtime : 'required',
             actualdate : 'required'
           },
           message : {
             trainerid : 'This field is required.',
             memberid : 'This field is required.',
             packageid : 'This field is required.',
             actualtime : 'This field is required.',
             actualdate : 'This field is required.'
           }
         });
       }
     //$(document).find('#trainerid-error').text('This field is required.');
   
     });
   });
   $(document).on('keypress', '#ptp', function(e){
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
       return false;
     }
    });
</script>
@endpush