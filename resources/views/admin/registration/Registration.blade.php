@extends('layouts.adminLayout.admin_design')
@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


@endpush
@section('content')
<style type="text/css">
  .table{
     border-spacing:0;
  }
  .animate{
        max-height: 600px;

  }
  #login{
    /*margin-top: -50px !important;*/

        padding: 18px 6% 40px 6% !important;
  }
</style>

<link rel="stylesheet" type="text/css" href="css/registerform.css">


              <div class="content-wrapper">


                       <section class="content-header"><h2></h2></section>
                        <!-- general form elements -->
                         <div class="content">
                        @if ($errors->any())
                          <div class="alert alert-danger">
                               <button type="button" class="close" data-dismiss="alert">×</button>
                          <ul>
                          @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                          @endforeach
                          </ul>
                          </div>
                          @endif
                    @if ($message = Session::get('message'))
                  @if($message=="Succesfully added")
                    <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                  @endif
                  @if($message=="User Is Already Exits")
                    <div class="alert alert-danger alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                  @endif
              @endif



              <div class="row">

                 <section>
        <div id="container_demo">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div class="row">

                    <div id="login" class="animate form col-md-12">
                        <form action="{{route('rpostverify')}}" autocomplete="on" method="post" id="q1">
                        {{ csrf_field() }}
                            <div class="row">
                               <h3  class="text-center">Registration Details</h3>
                            </div>

                     <div class="bootstrap-iso">

                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="form-group">
                            <!-- <label class="control-label" for="date">Date</label> -->
                            <input type="hidden" class="form-control" id="date" name="date" placeholder="DD/MM/YYYY" type="text"/>
                            @if($registration_uid)
                            <input type="hidden" name="paymentid" value="{{$registration_uid->id + 1}}">
                            @endif
                          </div>


                        </div>
                      </div>
                  <div class="row">

                       <div class="col-md-12 col-sm-9 col-xs-12" id="mob">
                        <div class="form-group">
                           <label class="control-label col-sm-2" style="margin-left: 0px !important; margin-right: 0px;    padding-left: 0px;" for="mobileno">Mobile Number<span style="color : red;">*</span></label>
      <div class="col-sm-10">
         <input class="form-control number" id="mobileno"  onkeyup="valid()" name="mobileno" placeholder="Mobile Number" type="text" maxlength="10"  />
       </div>

     </div>

   </div>

                        <!--     <label class="control-label" for="mobileno">Mobile No<span style="color : red;">*</span></label>
                            <input class="form-control number" id="mobileno"  onchange="valid()" name="mobileno" placeholder="Mobile No" type="text" maxlength="10"  />
                          </div> -->

                        </div>
                        <div  class="box" id="tablereghistory"  style="max-height:100px;display: none;margin-top: 20px; overflow: auto; margin: -2px;" >
                            <div class="box-body">
                              <table id="reghistory" class="table" cellspacing="5" style="border-width: 0px;" width="100%">
                          <thead>
                           <th>Name</th>
                           <th>Type OF Registration</th>
                           <th>Date</th>
                          </thead>
                          <tbody>
                            <tr  class="txt" style="display: none"></tr>
                          </tbody>
                          </table>
                          </div>
                       </div>
                      </div>
                      <br>
                      <div class="row">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label class="control-label" for="Name">First Name<span style="color : red;">*</span></label>
                            <input class="form-control" type="text" onchange="valid()" id="fname"  name="fname" placeholder="Enter First Name" required="">
                          </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="date">Last Name<span style="color : red;">*</span></label>
                            <input class="form-control" id="lname" name="lname" onchange="valid()" placeholder="Enter Last Name" type="text"  />
                          </div>

                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="form-group">
                            <label class="control-label" for="date">Birthdate</label>
                            <!-- <input class="form-control" id="date" name="bdate" onchange="valid()" placeholder="DD/MM/YY" type="text" /> -->
                            <input  type="date" id="scheduledate" autocomplete="off" class="form-control" name="bdate"onkeypress="return false" max="<?php echo date('Y-m-d');?>" placeholder="<?php echo date("d-m-Y"); ?>" value="" >
                          </div>

                        </div>




                         <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input class="form-control" id="email" onchange="valid()" name="email" placeholder="Enter Email" type="email"/>
                          </div>
                        </div>
                      </div>
                        <div class="row">
                         <div class="col-md-12 col-sm-9 col-xs-12">
                         <div class="form-group">
                             <label class="control-label col-sm-3"  style="margin-left: 0px !important; margin-right: 0px !important;  padding-left: 0px;" for="gender">Gender</label>
                                        <div class="col-sm-9">

                            <input type="radio" name="gender" value="Female" onchange="valid()" class="gender" checked>
                             <label>Female</label>

                             <input type="radio" name="gender" value="Male" onchange="valid()" class="gender">
                              <label>Male</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!--                <div class="col-md-12 col-sm-9 col-xs-12" id="mob">
                        <div class="form-group">
                           <label class="control-label col-sm-2" style="margin-left: 0px !important; margin-right: 0px;    padding-left: 0px;" for="mobileno">MobileNo<span style="color : red;">*</span></label>
      <div class="col-sm-10">
         <input class="form-control number" id="mobileno"  onchange="valid()" name="mobileno" placeholder="Mobile No" type="text" maxlength="10"  />
       </div>

     </div>

   </div> -->
                       <div class="row">
                         <div class="col-md-12 col-sm-9 col-xs-12">
                         <div class="form-group">
                       <label class="control-label col-sm-3"  style="margin-left: 0px !important; margin-right: 0px !important;  padding-left: 0px;" for="regtype">Registration Type</label>
                                <div class="col-sm-9">
                            <select class="form-control" id="regtype" onchange="valid()" name="regtypeid">
                            <option value="">Select Type</option>
                            @foreach($regtypes as $regtype)
                                  <option value="{{$regtype->regpaymentid}}" >{{$regtype->regpaymentname}}</option>
                            @endforeach
                            </select>
                          </div>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" name="regtypeprice" id="priceregtype">

                       <!--   <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="Designation">Designation</label>
                            <input class="form-control" maxlength="150" id="Designation" onchange="valid()" name="designation" placeholder="Designation" type="text"/>
                          </div>
                        </div>  -->
                     <br>

                    <div class="row">
                        <div class="text-center">
                          <center>

                              <a type="submit" href="#toregister" style="display: none" class="button bg-green" id="next">Next</a>
                              </center>
                        </div>
                    </div>

                    </div>


                <div id="register" class="animate form">


                           <div class="row">
                               <h3  class="text-center">For Office Use Only</h3>
                            </div>

                            <div class="bootstrap-iso">



                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <label class="control-label " for="package">Root Scheme<span style="color : red;">*</span></label>
                              <select class="form-control" name="rootscheme" id="rootscheme">
                                <option value="">-Select Root Scheme-</option>
                                @foreach($rootscheme as $root)
                                <option value="{{$root->rootschemeid}}">{{$root->rootschemename}}</option>
                                @endforeach
                              </select>

                            </div>
                        </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <label class="control-label " for="package">Scheme<span style="color : red;">*</span></label>
                              <select class="form-control" name="package" id="package">
                                <option value="">-Select Scheme-</option>
                              </select>

                            </div>
                          </div>


                      </div>

                      <div class="row">


                         <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label class="control-label" for="Trainer">Trainer</label>
                            <select class="form-control" name="therapist" id="therapist">
                              <option value="">-Select Trainer-</option>
                              @foreach($therapist as $thera)
                              <option value="{{$thera->username}}">{{$thera->username}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <label class="control-label" for="Timing">Timing</label>
                              <input class="form-control" type="time" id="time" name="timing" >

                          </div>
                          </div>
                      </div>

                  <!--     <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="payment">Payment</label>
                            <select class="form-control" name="payment">


                          </div>
                        </div>
                      </div> -->

                        <div class="row">
                        <div class="col-md-6 col-sm-4 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="startingdate">Starting Date</label>
                            <input class="form-control" type="date" autocomplete="off" id="start_date1" onkeypress="return false"  name="startingdate"
                            value="{{date('Y-m-d')}}">

                          </div>
                        </div>
                        <input type="hidden" name="end_date" id="enddate">
                         <div class="col-md-6 col-sm-4 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="duedate">No of days<span style="color : red;">*</span></label>
                            <input class="form-control" type="number" autocomplete="off"  id="noofdays"  name="validday" placeholder="Days" max="20" min="0" required="">

                          </div>
                        </div>
                     <!--    <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="duedate">Due Date</label>
                            <input class="form-control" type="text" autocomplete="off"  id="due_date" onkeypress="return false" name="duedate" placeholder="DD/MM/YYYY">

                          </div>
                        </div> -->
                       <!--  <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="form-group">
                            <label class="control-label" for="endingdate">Ending Date</label>
                            <input class="form-control" type="text" autocomplete="off" id="end_date" onkeypress="return false" name="endingdate" placeholder="DD/MM/YYYY">

                          </div>
                        </div> -->
                      </div>


                    </div>

                     <div class="row">
                     <center>
                            <a href="#tologin" class="btn bg-orange margin">Previous</a>
                            <!-- <input type="submit" name="submit" value="Register" id="registration" class="buttonsubmit"> -->


                              <button type="submit" class="btn bg-green" id="registration"  name="submit">Register</button>


                       </center>
                              <!-- <a  name="submit" value="Register" id="registration" class=" button">Register</a> -->


                    </div>


                </div>

            </div>
        </div>

              </div>

     </section>


<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">OTP Verification</h4>
            </div>
            <div class="modal-body">
              <div class="beforegenerate">

                <p>Please Generate OTP for the Future Process !</p>

                                <span id="error_message" class="text-danger"></span>
                                <span class="text-danger" id="invalid_email"></span>
                               <span id="success_message" class="text-success"></span>

                 <a href="#" name="GenerateOtp" id="GenerateOtp" class="btn bg-orange">Genarate OTP</a>

                   </div>

                    <div class="aftergenerate">

                       <p>We sent OTP Code Via SMS / Email.</p>

                       <div class="form-group">
                        <input type="number" name="otp" id="numberotp" class="form-control" placeholder="Please Enter OTP Code">
                    </div>

                    <!-- <a href="#" class="btn bg-aqua" name="ResendOtp" id="ResendOtp">Resend OTP</a> -->

                    <button type="submit" class="btn bg-orange" ondocument="verify()" id="verifyotp">Verify OTP</button>

                     <a href="#" name="skipotp" id="skipotp" class="btn bg-orange">Skip OTP</a>

                    </div>






            </div>
        </div>
    </div>
</div>
</form>


                </div>

              </div>
            </div>
</div>

@endsection
@push('script')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  var j1 = jQuery.noConflict(true);
  j1(document).ready(function(){
    j1('.date').datepicker({
      maxDate : 0,
      dateFormat : 'dd-mm-yy'
    });
    j1('#start_date').datepicker({
      dateFormat : 'dd-mm-yy'
    });
    j1('#due_date').datepicker({
      dateFormat : 'dd-mm-yy'
    });
    j1('#end_date').datepicker({
      dateFormat : 'dd-mm-yy'
    });
  });
  </script>
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script>
      var j2 = jQuery.noConflict(true);
    j2(document).ready(function(){


      j2('#GenerateOtp').click(function(){

        var mobileno = j2('#mobileno').val();
        var fname = j2('#fname').val();
        var lname = j2('#lname').val();
        var email = j2('#email').val();


        if(IsEmail(email)==false){
          j2('#invalid_email').show();
          return false;
        }
          function IsEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+j2/;

          /*if(!regex.test(email)) {
            j2('#invalid_email').fadeIn().html("Please Fill All Details");
            setTimeout(function(){
                                 j2('#invalid_email').fadeOut("Slow");
                            }, 2000);
          }

           else
           { */

                j2('#error_message').html('');

                j2.ajax({

                     type:"POST",
                    data: {"_token": "{{ csrf_token() }}","mobileno": mobileno,"email":email,"fname":fname,"lname":lname},
                    url:'{{ URL::route("otpverify") }}',
                     success:function(data){

                          j2('#success_message').fadeIn().html(data);
                          setTimeout(function(){
                               j2('#success_message').fadeOut("Slow");
                          }, 2000);
                     }
                });
           //}

        }
      });

      j2('#ResendOtp').click(function(){

        var mobileno = j2('#mobileno').val();

        j2('#error_message').html('');
                j2.ajax({

                     type:"POST",
                    data: {"_token": "{{ csrf_token() }}","mobileno": mobileno},
                    url:'{{ URL::route("regresendotp") }}',
                     success:function(data){

                          j2('#success_message').fadeIn().html(data);
                          setTimeout(function(){
                               j2('#success_message').fadeOut("Slow");
                          }, 2000);
                     }
                });

  });


  $('#noofdays').on('keyup',function(){
   var days= $('#noofdays').val();
    // alert(days);
   todatecalculate(days);
  });
   j2('#start_date1').on('change',function(){
    $('#noofdays').trigger('keyup');

   });
  function  todatecalculate(days){
        var start_date=$('#start_date1').val();

 // alert(start_date);
    var days=days;
   if(start_date){

            var x = document.getElementById("start_date1").value;
                 var date = new Date(x);

                 date.setDate(date.getDate(x) + parseInt(days));
                   // alert(date);
                   var month = date.getUTCMonth() + 1; //months from 1-12
                  var day = date.getUTCDate();
                  var year = date.getUTCFullYear();
                  if(day.toString().length <= 1) {
                      day = '0' + day;
                  }
                   if(month.toString().length <= 1) {
                      month = '0' + month;
                  }
                  newdate = year + "-" + month + "-" + day ;
                  // alert(newdate);
                      // alert(newdate);
                   $('#enddate').val('');
                  $('#enddate').val(newdate);
  }
   }

//       j2('#start_date1').on('change',function(){
//           var start_date=j2('#start_date1').val();
//           alert(start_date);
//            var validday=j2('#noofdays').val();
// alert(validday);
// if(validday){


//               var x = start_date;
//                  var date = new Date(x);

//                  date.setDate(date.getDate(x) + parseInt(days));
//                    // alert(date);
//                    var month = date.getUTCMonth() + 1; //months from 1-12
//                   var day = date.getUTCDate();
//                   var year = date.getUTCFullYear();
//                   if(day.toString().length <= 1) {
//                       day = '0' + day;
//                   }
//                    if(month.toString().length <= 1) {
//                       month = '0' + month;
//                   }
//                   newdate = year + "-" + month + "-" + day ;
//                   // alert(newdate);
//                    $('#enddate').val('');
//                   $('#enddate').val(newdate);
//            // var end_date =
// }
//       });
  j2('#skipotp').click(function(){

        var mobileno = j2('#mobileno').val();
        var numberotp = j2('#numberotp').val();
        var fname = j2('#fname').val();
        var lname = j2('#lname').val();
        var email = j2('#email').val();
        var Designation = j2('#Designation').val();
        var rootscheme = j2('#rootscheme').val();
        var package = j2('#package').val();
        var therapist = j2('#therapist').val();
        var payment = j2('#payment').val();
        var time = j2('#time').val();
        var start_date = j2('#start_date').val();
        var due_date = j2('#due_date').val();
        var end_date = j2('#end_date').val();
        var regtype = j2('#regtype').val();


        j2('#error_message').html('');
                j2.ajax({

                     type:"POST",
                    data: {       "_token": "{{ csrf_token() }}",
                                  "mobileno": mobileno,
                                  "numberotp":numberotp,
                                  "fname":fname,
                                  "lname":lname,
                                  "email": email,
                                  "Designation":Designation,
                                  "rootscheme":rootscheme,
                                  "package":package,
                                  "therapist": therapist,
                                  "payment":payment,
                                  "time":time,
                                  "start_date":start_date,
                                  "due_date":due_date,
                                  "end_date":end_date,
                                  "regtype":regtype,
                      },
                    url:'{{ URL::route("skipregotp") }}',
                     success:function(data){

                        window.location = "{{ URL::route('registrationdetails') }}";
                     }
                });

  });

 });


</script>

<script type="text/javascript">

  j2(document).ready(function(){
    j2('#mobileno').focus(function(){
       j2(this).removeAttr('style');
    });
    j2('#fname').focus(function(){
       j2(this).removeAttr('style');
    });
    j2('#lname').focus(function(){
       j2(this).removeAttr('style');
    });
    j2('#package').focus(function(){
       j2(this).removeAttr('style');
    });


    $("#myModal").modal('hide');

    if (j2('#registration').click(function(){

        var mobileno = j2('#mobileno').val();
        var fname = j2('#fname').val();
        var lname = j2('#lname').val();
        var package = j2('#package').val();


        if(mobileno.length == 0){
          alert('Please Enter contact number');
          j2('#mobileno').css('border', '1px solid red');
            return false;
        }

        if(fname.length == 0){
          alert('Please Enter first name');
          j2('#fname').css('border', '1px solid red');
            return false;

        }

        if(lname.length == 0){
          alert('Please Enter last name');
          j2('#lname').css('border', '1px solid red');

            return false;

        }

        if(package.length == 0){
          alert('Please select scheme');
          j2('#package').css('border', '1px solid red');
           return false;

        }

      if(mobileno.length != 0 && fname.length != 0 && lname.length != 0 && package.length != 0 ){

        return true;
         // j2('#priceregtype').val()
        //$("#myModal").modal('show');
      }
    }));


       j2('.aftergenerate').hide();


     if (j2('#GenerateOtp').click(function(){

           //j2('.close').hide();

           j2('.aftergenerate').show();
           j2('.beforegenerate').hide();

        }));

  });

</script>


<script type="text/javascript">
    function valid()
    {

      // alert(j2('#regtype').val()!='');
  var radioValue = $("input[name='gender']:checked").val();
    var regtype=j2('#regtype').val();

    if(j2('#fname').val()!=""  && j2('#lname').val()!="" &&  j2('#mobileno').val().length == 10)

    {
      if(radioValue && regtype)

      {
        var rty='';

           j2.ajax({
        url:"{{ route('getpriceofregtype') }}",
        method:"POST",
        data:{regtype:regtype, _token:"{{ csrf_token()}}"},
        success:function(result)
        {
          // alert(result);
          if(result){
            rty=result;

          }
          j2('#priceregtype').val(JSON.parse(rty));

        }

       });


        j2('#next').css('display','block');
      }
      else{
        j2('#next').css('display','none');
      }

    }
    else
    {
       j2('#next').css('display','none');
    }

    }
     j2('#next').css('display','none');

    j2('#rootscheme').on('change',function(){
      let root = j2(this).val();

      j2.ajax({
        url:"{{ route('schemeforregistration') }}",
        method:"POST",
        data:{root:root, _token:"{{ csrf_token()}}"},
        success:function(result)
        {
          //alert(result);
          j2('#package').html(result);

        }

       });

    });

   j2(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});


</script>
<script type="text/javascript">
 j2('#mobileno').on('change',function(){

       if(j2('#mobileno').val().length == 10){
          var mobileno=j2('#mobileno').val();
              j2.ajax({
                url:"{{ url('loadreghistory') }}",
                method:"POST",
                data:{mobileno:mobileno, _token:"{{ csrf_token()}}"},
                success:function(result)
                {
                  console.log(result);
                  data=result;
                     if (data.length != 0) {
                                      $('#tablereghistory').css('display','block');
                                    $("#reghistory tbody tr:not(:first)").empty();

                                      $.each(data, function(i, item){
                                        // alert(item.created_at);
                                     var  apnd='<tr class="txt"><td>'+item.firstname+'</td><td>';
                                     if(item.regpaymentname !=null){
                                      apnd+=item.regpaymentname;
                                     }
                                    apnd+='</td><td>';
                                     if(item.regcreatedate != null){
                                         var date=item.regcreatedate;
                                       date=  new Date(date);
                                     var day = date.getDate();
                                    var month = date.getMonth(); //Be careful! January is 0 not 1
                                    var year = date.getFullYear();
                                    var dateString = day + "-" +(month + 1) + "-" + year;
                                     apnd+= dateString;
                                     }

                                    apnd+= '</td></tr>';
                                       $('.txt:last').after(apnd);

                                      });
                                    }
                                    else{
                                        $('#tablereghistory').css('display','none');
                                    }
                  // j2('#mobileno').after(result);
                  // j2('#package').html(result);

                },
                  dataType:"json"
              });
        }


  });
</script>
@endpush
