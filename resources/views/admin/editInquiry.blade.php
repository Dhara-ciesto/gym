@extends('layouts.adminLayout.admin_design_without_footer')
@section('content')
<style type="text/css">
  body {
    font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;}
    .sidebar {
    padding-bottom: 150%; 
}
</style>
 <meta charset="utf-8">
    <title>Add Inquiry</title>
      
      <script src="{{ asset('bower_components/bootstrap/js/cdnjs-extra/jquery.min.js') }}"></script>
<!--     <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
<script src="{{ asset('bower_components/bootstrap/js/cdnjs-extra/bootstrap.min.js') }}"></script>
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script> -->
<script src="{{ asset('bower_components/bootstrap/js/cdnjs-extra/jquery.easing.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
 
  </head>
  <body>
    <div class="row">
    <div class="col-md-6 col-md-offset-3">
      @if(count($errors)>0)
      <ul>
        @foreach($errors->all() as $error)
        <li class="alert alert-danger">{{$error}}</li>
        @endforeach
      </ul>
      @endif
       <script type="text/javascript">
        $(window).load(function(){
        setTimeout(function(){ $('.alert-danger').fadeOut() }, 5000);
      });
      </script>
        <form id="msform" action="{{url('editinquiry/'.$inquiry->inquiriesid)}}" method="Post">
          {{ csrf_field() }}
            <!-- progressbar -->
            <ul id="progressbar"style="margin-left: 180px;">
                <li class="active"><b>Personal Details</b></li>
                <li><b>Tell us something more about you</b></li>
                <li><b>Package And Inquiry Details</b></li>
               
                
            </ul>
            <!-- fieldsets -->
            <fieldset>
                <h2 class="fs-title">Personal Details</h2>
                <h3 class="fs-subtitle">Tell us something more about you</h3>
                <input type="text" name="firstname" placeholder="First Name" required id="firstname" value="{{$inquiry->firstname}}" />
                <input type="text" name="lastname" placeholder="Last Name" required id="lastname"value="{{$inquiry->lastname}}" />
              
                <ul class="donate-now">
                  <li>
                      <!-- <input type="text"> -->
                      <span id="title"><b>Select Gender</b></span>
                  </li>
                  <li>
                      <input type="radio" id="a25" name="gender" value="male" {{$inquiry->gender == 'male'?'checked':'' }} />
                      <label for="a25">Male</label>
                  </li>
                  <li>
                      <input type="radio" id="a50" name="gender" value="female" {{$inquiry->gender == 'female'?'checked':''}} />
                      <label for="a50">Female</label>
                  </li>

                  </ul>
                  <!-- <input type="radio" name="gender" value="male" checked>Male
                  <input type="radio" name="gender" value="female">Female -->
                  <input type="email" name="email" placeholder="Enter your Email" id="email" value="{{$inquiry->email}}">
                <input type="text" name="mobileno" placeholder="Phone No" maxlength="10" class="number" required="" value="{{$inquiry->mobileno}}" />
                <input type="button" name="next" class="next action-button" value="Next"/>
            </fieldset>
            <fieldset>
                <h2 class="fs-title">Tell us something more about you</h2>
                <h3 class="fs-subtitle">Tell us something more about you</h3>

                <label>Profession</label>
                <input type="text" name="profession" placeholder="Profession" value="{{$inquiry->profession}}" />

                <label>Already Member in other GYM ?</label>
                <select name="alreaygymmember" onchange="memberinothergym();" id="mg">      
                  <option value="Yes" {{$inquiry->alreadymember == 'Yes'?'selected':''}} id="yes">Yes</option>
                    <option value="No" {{$inquiry->alreadymember == 'No'?'selected':''}} id="no">No</option>
                </select>
               

                @if($inquiry->note)
                <label>Details About Other GYM </label>
                <textarea type="text" name="note" placeholder="Please Give Details About GYM !" id="am">{{$inquiry->note}}</textarea>
                @endif

                <label>How Did You Here about us ?</label>
                <select name="howknowaboutus" id = "country" required="">
                  <option value="null">-- How Did You Here about us ? --</option>
                  <option value="Fitness Five Member" {{$inquiry->hearabout == 'Fitness Five Member'?'selected':''}}>Fitness Five Member</option>
                  <option value="We Called Them" {{$inquiry->hearabout == 'We Called Them'?'selected':''}}>We Called Them</option>
                  <option value="Friends/Family" {{$inquiry->hearabout == 'Friends/Family'?'selected':''}}>Friends / Family</option>
                  <option value="Internet Search Engine" {{$inquiry->hearabout == 'Internet Search Engine'?'selected':''}}>Internet Search Engine</option>
                  <option value="Word of Mouth" {{$inquiry->hearabout == 'Word of Mouth'?'selected':''}}>Word of Mouth</option>
                  <option value="Radio Advertise" {{$inquiry->hearabout == 'Radio Advertise'?'selected':''}}>Radio Advertise</option>
                  <option value="Magazine Advertise" {{$inquiry->hearabout == 'Magazine Advertise'?'selected':''}}>Magazine Advertise</option>
                  <option value="other" {{$inquiry->hearabout == 'other' ? 'selected':''}}>other</option>
                </select>
      
                <label>Reference By :</label>
                 <select name="reference">
                  <option value="null">-- Reference By --</option>
                  <option value="advertise"{{$inquiry->referenceby == 'advertise'?'selected':''}}>advertise</option>
                  <option value="club_member"{{$inquiry->referenceby == 'club_member'?'selected':''}}>club Member</option>
                  <option value="other"{{$inquiry->referenceby == 'other'?'selected':''}}>other</option>
                </select><br/><br/>

                <textarea type="text" name="remarks" placeholder="Remark">{{$inquiry->remarks}}</textarea>

                
             <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
              <input type="button" name="next" class="next action-button" value="Next"id="next2"/>
            </fieldset>

            <fieldset>
                <h2 class="fs-title">Package And Inquiry Details</h2>
                <h3 class="fs-subtitle">Tell About Interested Package !</h3>
                <label>Package</label>
                <select name="package" id="package" onchange="s()" disabled="" style="cursor: not-allowed;"> 
                  <option value="{{$inquiry->packagename}}">{{$inquiry->packagename}}</option>           
                </select>
               <!--  <script type="text/javascript">
                  function s(){
                    alert($('#package').val());
                  }
                </script> -->
              <!--   <input type="text" name="menberinothergym" placeholder="Already Member in ohther GYM ?"/> -->
                <label>Point of Contact</label>
                <select name="poc" disabled="" style="cursor: not-allowed;">
                  <!-- <option value="null">-- Select Point of Contact --</option> -->
                  <option value="Vicky Shah">Vicky Shah</option>           
                </select>

                <label>Inquiry Type</label>
                 <select name="inquirytype" disabled="" style="cursor: not-allowed;">
                  <!-- <option value="null">-- Reference By --</option> -->
                  <option value="walkin">{{$inquiry->inquirytype}}</option>
                  <option value="walkin">Walk In</option>
                  <option value="oncall">On Call</option>
                  <option value="app">Application</option>
                  <option value="website">Website</option>
                </select>

                 <label>Inquiry Rate</label>
                 <select name="inquiryrate" disabled="" style="cursor: not-allowed;">
                  <!-- <option value="null">-- Reference By --</option> -->
                  <option value="walkin">{{$inquiry->rating}}</option>
                  <option value="superhot">Super Hot</option>
                  <option value="hot">Hot</option>
                  <option value="warm">Warm</option>
                  <option value="cold">Cold</option>
                  <option value="notinterested">Not Interested</option>
                </select><br/><br/>

                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                 <input   type="submit" value="Submit" class="action-button"  />
            </fieldset>

           <!--  <fieldset>
              <div class="col-lg-12">
                
            
                <h2 class="fs-title">Create your Inquiry</h2>
                <h3 class="fs-subtitle">Fill in your credentials</h3>
                <ul class="donate-now-change">
                  <li>
                      <input type="radio" id="Followup" name="readytomember" value="Followup" checked="" />
                      <label for="Followup">Add Followup</label>
                  </li>
                  <li>
                      <input type="radio" id="member" name="readytomember" value="Member" />
                      <label for="member">Add Member</label>
                  </li>

                  </ul>
                
                 <div id="Followupdetails" class="addfollowers">

                    <div><b>Followup Date</b><input type="date" onkeypress="return false" name="FollowUpDays" disabled="" value="{{$followup->followupdays}}"></div>
                     <label>Followup Time</label>
                            <select name="ftime" disabled="">
                              <option>{{$followup->followuptime}}</option>
                              <option>Morning</option>
                              <option>Afternoon</option>
                              <option>Evening</option>
                            </select><br/>
                      <label>Specific Time</label><input type="text" disabled="" value="{{$followup->followupspecifictime}}" name="stime" placeholder="Specific Time">
                 </div>
                
                 <input type="password" name="pass" placeholder="Password"/>
                <input type="password" name="cpass" placeholder="Confirm Password"/> 
                
               </div>
               <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
               
            </fieldset> --> 

  </form>
              </div>

      
    </div>
</div>

<script>
$(document).ready(function(){
    $("#Followup").click(function(){
    $("#Followupdetails").show();
  });
  $("#member").click(function(){
    $("#Followupdetails").hide();
  });

});
</script>

<script type="text/javascript" src="{{ asset('js/inquiry_multistep.js') }} "></script>
<script type="text/javascript">
  $("#email").focusout(function() {
   var email_x = document.getElementById("email").value;
        filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,20})+$/;
        if (filter.test(email.value)) {
            document.getElementById("email").style.border = "1px solid green";
            return true;
        } else {
            document.getElementById("email").style.border = "1px solid red";
            return false;
        }
});
</script>
<script type="text/javascript">
 $("#firstname").on("change", function(){
  var j = $(this).val();
  if(j){
   return true
  }
  else{
   
    return false;
  }
 });
 $("#lastname").on("change", function(){
  var j = $(this).val();
  if(j){
   return true
  }
  else{

    return false;
  }
 });

</script>
<script type="text/javascript">
   $("form").submit(function() { 
                    // alert("data"); 
                }); 
</script>
@endsection
