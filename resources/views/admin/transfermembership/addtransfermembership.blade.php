@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
  .content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
  }
  .td{
  max-width: 20% !important;
}
table tr {
 border:none !important;
 border-color: white;

}

 .badgebox
   {
   opacity: 0;
   }
   .badgebox + .badge
   {
   /* Move the check mark away when unchecked */
   text-indent: -999999px;
   /* Makes the badge's width stay the same checked and unchecked */
   width: 27px;
   }
   .badgebox:focus + .badge
   {
   /* Set something to make the badge looks focused */
   /* This really depends on the application, in my case it was: */
   /* Adding a light border */
   box-shadow: inset 0px 0px 5px;
   Taking the difference out of the padding 
   }
   .badgebox:checked + .badge
   {
   /* Move the check mark back when checked */
   text-indent: 0;
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

.input.largerCheckbox { 
           transform : scale(10); 
        } 
      .bg-green{
        background-color: green;
      }
</style>
<style type="text/css">


/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 15px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #3a3938;
}
/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
  top: 7.2px;
  left: 7.3px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header">

      <h1 style="text-decoration: none;"></h1>
  </section>
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transfer Membership</h3>

                    </div>
                    <!-- /.box-header -->

                    @if(request()->route('id')) @php $i=request()->route('id'); @endphp @else @php $i=''; @endphp @endif
                    <form action="{{url('addtransfermembership')}}" method="post" id="transferform">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="col-lg-12">
                                <div class="col-lg-1">
                                    <label>From::</label>
                                </div>
                                <div class="col-lg-5">

                                    <label class="container">Search By Username
                                        <input type="radio" name="rbnNumberfrom" class="btnGetValuefrom" value="1" checked="">
                                        <span class="checkmark"></span>
                                    </label>

                                </div>
                                <div class="col-lg-6">
                                    <label class="container">Search By Mobileno
                                        <input type="radio" name="rbnNumberfrom" class="btnGetValuefrom" value="2">
                                        <span class="checkmark"></span>
                                    </label>

                                </div>
                                <br>
                                <!-- /**********************start serachbyusername **********************/ -->
                                <div class="bs" id="serachbyusernamefrom" style="display: none; margin-top: -20px;">
                                    <br>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-5">

                                        <!-- <label>Username<span style="color: red">*</span></label> -->

                                        <select name="useridfrom" id="usernamefrom1" class="form-control span11 select2" title="Select Member" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-header="Select Member" required="">
                                            <option selected>Please choose an option</option>@foreach($users as $user)
                                            <option value="{{ $user->userid }}" {{$user->userid == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
                                        </select>

                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-5">

                                        <!-- <label>Mobile No:</label> -->
                                        <select name="selectmobilenofrom" id="mobileNofrom1" class="form-control" disabled="">
                                            <option selected>Please choose an option</option>@foreach($users as $user)
                                            <option value="{{ $user->userid }}" {{$user->userid == $i?'selected':''}}>{{ $user->mobileno }}</option>@endforeach
                                        </select>

                                        <!-- /input-group -->
                                    </div>

                                </div>

                                <!-- /**********************end serachbyusername **********************/ -->
                                <!-- /**********************start serachbymobileno **********************/ -->
                                <div class="bs" id="serachbymobilenofrom" style="display: none; margin-top: -20px;">
                                    <br>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-5">

                                        <!-- <label>Username<span style="color: red">*</span></label> -->

                                        <select name="useridfrom" id="usernamefrom2" class="form-control " disabled="">
                                            <option selected>Please choose an option</option>@foreach($users as $user)
                                            <option value="{{ $user->userid }}">{{ $user->username }}</option>@endforeach
                                        </select>

                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-5">

                                        <!-- <label>Mobile No:</label> -->
                                        <select name="selectmobilenofrom" id="mobileNofrom2" class="form-control select2" title="Select Mobileno" data-live-search="true" data-actions-box="true">
                                            <option selected>Please choose an option</option>@foreach($users as $user)
                                            <option value="{{ $user->userid }}">{{ $user->mobileno }}</option>@endforeach
                                        </select>

                                        <!-- /input-group -->
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <br>
                                <br>
                                <!-- /********************start***to*************************/ -->
                                <div class="bs" style="display: block;">
                                    <div class="col-lg-1">
                                        <label>To::</label>
                                    </div>
                                    <div class="col-lg-5">

                                        <label class="container">Search By Username
                                            <input type="radio" name="rbnNumberto" class="btnGetValueto" value="1" checked="">
                                            <span class="checkmark"></span>
                                        </label>

                                    </div>
                                    <div class="col-lg-6">
                                        <label class="container">Search By Mobileno
                                            <input type="radio" name="rbnNumberto" class="btnGetValueto" value="2">
                                            <span class="checkmark"></span>
                                        </label>

                                    </div>
                                </div>
                                <!-- /**********************start serachbyusername **********************/ -->
                                <div class="bs" id="serachbyusernameto" style="display: none; margin-top: -20px;">
                                    <br>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-5">
                                        <!-- <label>Username<span style="color: red">*</span></label> -->
                                        <select name="useridto" id="usernameto1" class="form-control span11 select2" title="Select Member" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-header="Select Member" required="">
                                            <option selected>Please choose an option</option>@foreach($tousers as $user)
                                            <option value="{{ $user->userid }}" {{$user->userid == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
                                        </select>
                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-5">
                                        <!-- <label>Mobile No:</label> -->
                                        <select name="selectmobilenofrom" id="mobileNoto1" class="form-control " disabled="">
                                            <option selected>Please choose an option</option>@foreach($tousers as $user)
                                            <option value="{{ $user->userid }}" {{$user->userid == $i?'selected':''}}>{{ $user->mobileno }}</option>@endforeach
                                        </select>
                                        <!-- /input-group -->
                                    </div>
                                </div>
                                <!-- /**********************end serachbyusername **********************/ -->
                                <!-- /**********************start serachbymobileno **********************/ -->
                                <div class="bs" id="serachbymobilenoto" style="display: none; margin-top: -20px;">
                                    <br>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-5">
                                        <!-- <label>Username<span style="color: red">*</span></label> -->
                                        <select name="useridto" id="usernameto2" class="form-control" disabled="">
                                            <option selected>Please choose an option</option>@foreach($tousers as $user)
                                            <option value="{{ $user->userid }}">{{ $user->username }}</option>@endforeach
                                        </select>
                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-5">
                                        <!-- <label>Mobile No:</label> -->
                                        <select name="selectmobilenoto" id="mobileNoto2" class="form-control select2" title="Select Mobileno" data-live-search="true" data-actions-box="true">
                                            <option selected>Please choose an option</option>@foreach($tousers as $user)
                                            <option value="{{ $user->userid }}">{{ $user->mobileno }}</option>@endforeach
                                        </select>

                                        <!-- /input-group -->
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <input type="hidden" name="transferfrom" id="transferfrom">
                                <input type="hidden" name="transferto" id="transferto">
                                <div class="col-lg-12" style="align-self: center">
                                    <br>
                                    <center>
                                        <div class="form-group">
                                            <button type="button" id="next1" class="btn bg-green">Next</button>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="box box-info" id="Package" style="display: none">
                            <div class="box-header with-border">
                                <h3 class="box-title">Details</h3>

                                <div class="box-tools pull-right">

                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" id="acpack">
                                <div class="col-lg-12">

                                    <div class="table table-responsive">
                                        <table id="activepackages" class="table no-margin table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Package</th>
                                                    <th>Amount</th>
                                                    <th>Discount</th>
                                                    <th>JoinDate</th>
                                                    <th>EndDate</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                <tr class="activepacks">
                                                    <td colspan="6"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="activepacks[]" id="activepacks">

                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <center>
                                        <div class="form-group">

                                            @if(Session::get('role')=="admin")
                                            <input type="submit" name="submit" class="btn bg-green margin"id="submit" value="Transfer">     
                                            
                                            @else
                                            <input type="button" value="Transfer" class="btn bg-green margin" data-toggle="modal" data-target="#myModal" id="submit" />
                                       
                                            @endif
                                            <!-- <input type="submit" name="submit" value="Transfer" class="btn bg-green margin"> -->
                                            <a href="" value="" class="btn bg-red">Cancel</a>

                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Please select following</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Select Admin<span style="color: red;">*</span></label>
                                                <select name="adminid" class="form-control" id="adminid">
                                                    <option value="">Select</option>
                                                    @if(!empty($admin)) @foreach($admin as $admin_data)
                                                    <option value="{{ $admin_data->employeeid}}">{{ ucfirst($admin_data->first_name) }} {{ ucfirst($admin_data->last_name) }} ({{ $admin_data->mobileno }})</option>
                                                    @endforeach @endif
                                                </select>
                                                <span id="admin_error" style="color: red;display: none;">Please Select admin</span>
                                            </div>
                                        </div>
                                        <button type="button" id="sendotp" class="btn bg-orange">sendOtp</button>
                                        <br>
                                        <center>
                                            <div id="otp" style="display: none; text-align: left;">
                                                <br>
                                                <div class="box">
                                                    <div class="box-body">
                                                        <label>Enter OTP</label>
                                                        <input type="text" style="height:30px; width:200px; align-self: center;align-content: center;" class="form-control" name="otp" id="txtotp" placeholder="Enter OTP"><span id="error_otp"></span>
                                                        <br>
                                                        <input type="button" style="align-self: center;" name="verify" class="btn bg-orange" value="verify" id="verify">
                                                    </div>
                                                </div>
                                            </div>
                                        </center>
                                        <input type="hidden" name="nextstep" id="nextstep">
                                        <input type="submit" name="submit" id="submitfinal" style="display: none">
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
</div>
<script>
   $("#verify").click(function(){
     var txtotp =$("#txtotp").val();
     var _token = $('input[name="_token"]').val();
     $.ajax({
       url:"{{ url('transferotpverify') }}",
       method:"POST",
       data:{txtotp:txtotp, _token:_token},
       success:function(result)
       {
         var data=result;
         /*alert(result);*/
         if(result == 'Verified'){
           $("#submitfinal").trigger('click');
         }
         else{
          $('#error_otp').html('<label class="bg-red">Wrong OTP ! Please try again</label>');
        }


      },

    });
   });
   
   $("#sendotp").click(function(e){
    e.preventDefault();
 
     var adminid=$('#adminid').val();
    
// alert(adminid);

     var _token = $('input[name="_token"]').val();

    $.ajax({
       url:"{{ url('transferotpsend') }}",
       method:"POST",
       data:{adminid:adminid, _token:_token},
       success:function(result)
       {
         var data=result;

         $("#otp").css('display','block');

       }
    });
   
   });
   </script>
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 dd/mm/yyyy
    $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'dd/mm/yyyy h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

<script type="text/javascript">
 $( document ).ready(function() {

     var selValue = $('input[name=rbnNumberfrom]:checked').val(); 
  if(selValue == 1){
          $('#serachbyusernamefrom').css('display','block');
          $('#serachbymobilenofrom').css('display','none');
        }
        else if(selValue == 2 ){
          $('#serachbyusernamefrom').css('display','none');
          $('#serachbymobilenofrom').css('display','block');
        }
    // $('#username').trigger('change');
     $('.btnGetValuefrom').click(function() {
        var selValue = $('input[name=rbnNumberfrom]:checked').val(); 
        // console.log(selValue);
        if(selValue == 1){
          $('#serachbyusernamefrom').css('display','block');
          $('#serachbymobilenofrom').css('display','none');
        

        }
        else if(selValue == 2 ){
          $('#serachbyusernamefrom').css('display','none');
          $('#serachbymobilenofrom').css('display','block');
         
        }
        // $('p').html('<br/>Selected Radio Button Value is : <b>' + selValue + '</b>');
    });
  });
  $('.btnGetValuefrom').on('change',function(){
   
   $('#Package').css('display','none');
  });

 var selValue = $('input[name=rbnNumberto]:checked').val(); 
  if(selValue == 1){
          $('#serachbyusernameto').css('display','block');
          $('#serachbymobilenoto').css('display','none');
        }
        else if(selValue == 2 ){
          $('#serachbyusernameto').css('display','none');
          $('#serachbymobilenoto').css('display','block');
        }
    // $('#username').trigger('change');
     $('.btnGetValueto').click(function() {
        var selValue = $('input[name=rbnNumberto]:checked').val(); 
        // console.log(selValue);
        if(selValue == 1){
          $('#serachbyusernameto').css('display','block');
          $('#serachbymobilenoto').css('display','none');
        

        }
        else if(selValue == 2 ){
          $('#serachbyusernameto').css('display','none');
          $('#serachbymobilenoto').css('display','block');
         
        }
        // $('p').html('<br/>Selected Radio Button Value is : <b>' + selValue + '</b>');
    });

  $('.btnGetValueto').on('change',function(){
   
   $('#Package').css('display','none');
   // $('#activepacks').find('option').remove();
  });
</script>
<script type="text/javascript">
   var jsarray = new Array();
  function getactivepackages(){
     // $('#activepacks').find('option').remove();
       $('#Package').css('display','none');
     var username = document.getElementById("usernamefrom1").value;
     var MobileNo = document.getElementById("mobileNofrom1").value;
     var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ url('getactivepackages') }}",
          method:"POST",
          data:{username:username, MobileNo:MobileNo, _token:_token},
          success:function(result2)
          {
            $('#Package').css('display','block');
            // console.log(result2.length);
          if(result2.length > 0 )
            {
           var  data=result2;
        // console.log(data);
          
      
     
        $("#activepackages tbody tr:not(:first)").empty();
                $.each(data, function(i,item){
               

                  var txt = '<tr class="changebackcolor"><td style="width:10% !important;"><label><input type="checkbox" name="check[]"value="'+item.schemeid+'"  checked class="largerCheckbox badgebox" onclick="checkboxclick(this)"><span class="badge bg-orange">&check;</span></label></td><td style="width:15%"><input class="form-control" type="text" value="'+item.schemename+'"></td><td style="width:15% !important;"><input type="text"class="form-control" value="'+item.amount+'"></td><td style="width:15% !important;"><input class="form-control" type="text" value="'+item.discount+'"></td><td style="width:15% !important;"><input class="form-control" type="text" value="'+formatDate(item.joindate)+'"></td><td style="width:15% !important;"><input class="form-control" type="text" value="'+formatDate(item.expiredate)+'"></td></tr>';
                    // jsarray[i] = item.schemeid;
  
                    
                      jsarray.push(item.schemeid);
                      // console.log(jsarray);
                      // alert(jsarray.type());
                      // alert(jsarray);
               jsarray= $.makeArray( jsarray );
                
                 // activepacks.push(item.schemeid);
                 // $('#activepacks').val(activepacks);
                  // console.log( $('#activepacks').val());
                  $('.activepacks:last').after(txt);
           
            });
                 $('#activepacks').val(JSON.stringify(jsarray));
                // $('#activepacks').val(JSON.stringify(jsarray));
                // console.log($('#activepacks').val());
              }
          else{
            // alert('sdfsdd');
            $('#Package').css('display','none');
            alert('No any package Available');
               // $('#acpack').after('<center>No any Package Available</center>');
            }
           },
               dataType:"json"
          });
  }
</script>
<script type="text/javascript">
  function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
   
    return [day, month, year].join('/');
}
</script>
<!-- <script type="text/javascript">
    function formatDate(date) {

    var todayTime = new Date();
    var month = format(todayTime .getMonth() + 1);
    var day = format(todayTime .getDate());
    var year = format(todayTime .getFullYear());
    return month + "/" + day + "/" + year;

</script> -->
<script type="text/javascript">
  $('#next1').on('click',function(){
    var username = document.getElementById("usernamefrom1").value;
    var MobileNo = document.getElementById("mobileNofrom1").value;
    var _token = $('input[name="_token"]').val();
      $.ajax({
        url:"{{ route('getuseridforpayment') }}",
        method:"POST",
        data:{username:username, MobileNo:MobileNo, _token:_token},
        success:function(result)
        {
          if(result!= null)
          {
            var data=result;
            $('#Package').css('display','block');
            getactivepackages();
          }
          else
          {
            $('#Package').css('display','none');
          }
      },
        dataType:"json"
     })
  });
</script>

<script type="text/javascript">
   $('#usernamefrom1').on('change',function(){

   
   $('#Package').css('display','none');
   
   
    var username = $('#usernamefrom1').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
      // console.log(data);
      $('#mobileNofrom1').val(data.userid);
       $("#usernamefrom2").val(data.userid);
       $('#mobileNofrom2').val(data.userid);
        $("#transferfrom").val(data.userid);
       // $('#activepacks').find('option').remove();

      // $('#mobileNo').val();
      },
       dataType:"json"
     });
   });
</script>
<script type="text/javascript">
   $('#mobileNofrom2').on('change',function(){
    var username = $('#mobileNofrom2').val();
    var _token = $('input[name="_token"]').val();
     $.ajax({
        url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
   
      // $('#username').attr("value",data.username).val(data.username);
      $("#usernamefrom2").val(data.userid);
     $("#usernamefrom1").val(data.userid);
     $("#mobileNofrom1").val(data.userid);
          $("#transferfrom").val(data.userid);

     // $('#activepacks').find('option').remove();
      },
       dataType:"json"
     });
   });
   // 
</script>
<script type="text/javascript">
   $('#usernameto1').on('change',function(){

   
   $('#Package').css('display','none');
   
   
    var username = $('#usernameto1').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
      // console.log(data);
      $('#mobileNoto1').val(data.userid);
       $("#usernameto2").val(data.userid);
       $('#mobileNoto2').val(data.userid);
       $('#transferto').val(data.userid);
       // $('#activepacks').find('option').remove();
      // $('#mobileNo').val();
      },
       dataType:"json"
     });
   });
</script>
<script type="text/javascript">
   $('#mobileNoto2').on('change',function(){
    $('#Package').css('display','none');
    var username = $('#mobileNoto2').val();
    var _token = $('input[name="_token"]').val();
     $.ajax({
        url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
   
      // $('#username').attr("value",data.username).val(data.username);
      $("#usernameto2").val(data.userid);
     $("#usernameto1").val(data.userid);
     $("#mobileNoto1").val(data.userid);
      $('#transferto').val(data.userid);

     // $('#activepacks').find('option').remove();
      },
       dataType:"json"
     });
   });
   // 
</script>
<script type="text/javascript">
   function checkboxclick(th){

    // alert($(th).val());


 // alert($(this).find('input[type="checkbox"]').is(":checked"));

       if($(this).find('input[type="checkbox"]').is(":checked") == true){
                 // alert("Checkbox is checked.");
            }
            else if($(this).find('input[type="checkbox"]').is(":checked") == false){
            $('#activepackages input:checkbox').each(function () {
              var sThisVal = (this.checked ? $(this).val() : "");
              if(sThisVal){
               // alert(sThisVal);
              }

              // alert(jsarray);

            });
          
            // alert(jsarray);
              // alert($(this).find('input[name="check"]').val());//Refers to TD element
          
            }

}
function removeitem(val){
// alert(val);
  $('#activepacks').val(JSON.stringify(jsarray));
}
</script>


<script type="text/javascript">
  $('#submit').on('click',function(e){
    // alert($('#transferto').val());
        if(!$('#transferfrom').val() || !$('#transferto').val()){
           e.preventDefault();
           alert('Please Select User');
            return false;
        }else if($('#transferto').val() == $('#transferfrom').val()){
           e.preventDefault();
           alert("You can't transfer package to same User");
         return false;
    
        }
        else{
          return true;
        
        }

  });
  $('#transferform').on('submit',function(){

    if($('#transferto').val() == $('#transferfrom').val()){
       alert("You can't transfer package to same User");
         return false;
    }
    else{
      return true;
    }
   
  
  })
</script>
@endsection