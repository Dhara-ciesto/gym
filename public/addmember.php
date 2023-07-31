<?php

 include 'global.php';

$url= $_SERVER['REQUEST_URI'];
$arr = explode("/", $url, 3);
$first = $arr[1];

// $GLOBALS['addmember']="green";
// echo $GLOBALS['addmember'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- left column -->
<!-- <script src="{{ asset('bower_components/jquery/src/ajax/jquery.min.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


<style type="text/css"> 

 .bg-orange{
     background-color: orange;
}
 .accordion-container .article-title {
     display: block;
     position: relative;
     margin: 0;
     padding: 0.625em 0.625em 0.625em 2em;
     border-top: 1px solid #ff851b;
     font-size: 1.20em;
     font-weight: bold;
     font-weight: normal;
     color: #444C3A;
     cursor: pointer;
}
 .checkmark {
     position: absolute;
     top: 0;
     left: 0;
     height: 25px;
     width: 25px;
     background-color: #eee;
}
/* On mouse-over, add a grey background color */
 .container:hover input ~ .checkmark {
     background-color: #ccc;
}
/* When the checkbox is checked, add a blue background */
 .container input:checked ~ .checkmark {
     background-color: #2196F3;
}
/* Create the checkmark/indicator (hidden when not checked) */
 .checkmark:after {
     content: "";
     position: absolute;
     display: none;
}
/* Show the checkmark when checked */
 .container input:checked ~ .checkmark:after {
     display: block;
}
 .container .checkmark:after {
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
 .accordion-container .article-title:hover, .accordion-container .article-title:notActive, .accordion-container .content-entry.open .article-title {
     background-color: #82C030;
     color: white;
}
 .accordion-container .article-title:hover i:before, .accordion-container .article-title:hover i:notActive, .accordion-container .content-entry.open i {
     color: white;
}
 .accordion-container .content-entry i {
     position: absolute;
     top: 3px;
     left: 12px;
     font-style: normal;
     font-size: 1.625em;
     sans-serif;
     color: #ff851b;
}
 .accordion-container .content-entry i:before {
     content: "+ ";
}
 .accordion-container .content-entry.open i:before {
     content: "- ";
}
 .accordion-content {
     display: none;
     padding-left: 2.3125em;
}
/* This stuff is just for the Codepen demo */
 #content {
     width: 100%;
}
 .accordion-container, #description {
     width: 90%;
     margin: 1.875em auto;
}
 @media all and (min-width: 860px) {
     #content {
         width: 70%;
         margin: 0 auto;
    }
}
 .badgebox {
     opacity: 0;
}
 .badgebox + .badge {
    /* Move the check mark away when unchecked */
     text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
     width: 27px;
}
 .badgebox:focus + .badge {
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */
    /* Adding a light border */
     box-shadow: inset 0px 0px 5px;
     Taking the difference out of the padding 
}
 .badgebox:checked + .badge {
    /* Move the check mark back when checked */
     text-indent: 0;
}
 .btn-success{
     background-color: #82C030;
     border-color: #82C030;
}
 .btn-success:hover{
     background-color: #83C530;
     border-color: #83C530;
}
 #radioBtn .notActive{
     color: #000000;
     background-color: #fff;
}
 .check {
     opacity:0.5;
     color:#996;
}
 .box{
     margin-bottom:5px;
}
 input[type="file"] {
     display: block;
}
 .imageThumb {
     max-height: 75px;
     border: 2px solid;
     padding: 1px;
     cursor: pointer;
}
 .pip {
     display: inline-block;
     margin: 10px 10px 0 0;
}
 .remove {
     display: block;
     background: #444;
     border: 1px solid black;
     color: white;
     text-align: center;
     cursor: pointer;
}
 .remove:hover {
     background: white;
     color: black;
}
    textarea {
    border: 1px solid #ddd;
    background: #fff url(../img/input-shaddow.gif) no-repeat left top;
    font: 11px Arial, Helvetica, sans-serif;
    color: #000;
    padding: 5px;
    width: 262px;
    float: left;
    margin: 0 10px 0 0;
    height: 50px;
    overflow: hidden;
}
 </style>
<script type="text/javascript">
   $(document).ready (function(){
           $("#danger-alert1").fadeTo(1000, 500).slideUp(500, function(){
            $("#danger-alert1").slideUp(500);
          });  
           $("#alert").fadeTo(1000, 500).slideUp(500, function(){
            $("#alert").slideUp(500);
          });   
         });
</script>
<div class="content-wrapper">
   <section class="content-header text-center">
        <img src="/images/fitness5.png" height="100px" width="100px">
        <h2>Membership Form</h2>
   </section>
    <!-- general form elements -->
   <div class="content">
      <section id="content">
         <form action="/storemember.php" method="post" enctype="multipart/form-data" id="member_form" onsubmit="return ValidateForm();">
            <div id="accordion" class="accordion-container">
               <input type="hidden" name="code" value="<?php echo $first; ?>">
               <article class="content-entry open">
                  <h4 class="article-title"><i></i>Registration Details</h4>
                  <div class="accordion-content" style="display:block;">
                     <br/>
                     <div class="well well-lg">
                        <div class="form-group">
                           <label>First Name<span style="color: red">*</span>
                           </label>
                           <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" class="span11"  maxlength="60" value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname'];}?>" />
                        </div>
                        <div class="form-group">
                            <label>LastName<span style="color: red">*</span>
                            </label>
                            <input type="text" name="lastname" id="lastname" class="form-control inline-block" placeholder="LastName" class="span11" maxlength="60" value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname'];}?>"  />
                        </div>
                        <div class="form-group">
                            <label class="hide">User Name</label>
                            <input type="text" name="username" id="username" class="form-control hide" placeholder="User Name" class="span11"  maxlength="60" value="<?php if(isset($_POST['username'])){ echo $_POST['username'];}?>" readonly /><span id="error_username"></span>
                        </div>
                        <div class="form-group">
                              <label>Gender<span style="color: red">*</span>
                              </label>
                              <label>
                                  <input type="radio" name="gender" value="Female">Female</label>
                              <label>
                                  <input type="radio" name="gender" value="Male">Male</label>
                        </div>
                        <div class="form-group">
                           <label>Email<span style="color: red">*</span>
                           </label>
                           <input type="text" maxlength="60" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];}?>" id="email" name="email" class="form-control" placeholder="Email Id" class="span11"/>
                        </div>
                        <div class="form-group">
                           <label>Cell Phone Number<span style="color: red">*</span>
                           </label>
                           <input type="text" name="CellPhoneNumber" value="<?php if(isset($_POST['CellPhoneNumber'])){ echo $_POST['CellPhoneNumber'];}?>" id="MobileNo" class="form-control number" placeholder="Cell Phone Number"  maxlength="15" class="span11" /><span id="error_usermobile"></span>
                        </div>
                        <div class="form-group">
                            <label>Birthdate</label>
                            <input placeholder="Birthdate" value="<?php if(isset($_POST['birthday'])){ echo $_POST['birthday'];}?>" type="date" class="form-control" max="<?php echo date('Y-m-d');?>" name="birthday" class="span11" id="birthday" >
                     </div>
                     <div class="form-group">
                         <label>Anniversary</label>
                         <input placeholder="Anniversary" value="<?php if(isset($_POST['anniversary'])){ echo $_POST['anniversary'];}?>" type="date" onkeypress="return false" class="form-control" max="<?php echo date('Y-m-d');?>" name="anniversary" class="span11">
                        </div>
                       
                        <div class="form-group">
                           <label>Preferred Timing</label>
                           <br> <span><label>From</label></span>
                        <select type="time" class="form-control" name="working_hour_from_1" id="fromtime" >
                            <option selected="" disabled="" value="">--Select Timing--</option>
                            <option value="06:00" <?php if(isset($_POST['working_hour_from_1']) =='06:00' ) { echo  'selected'; } ?> >06:00 AM</option>
                            <option value="07:00"<?php if(isset($_POST['working_hour_from_1']) =='07:00' ) { echo  'selected'; } ?>>07:00 AM</option>
                            <option value="08:00"<?php if(isset($_POST['working_hour_from_1']) =='08:00' ) { echo  'selected'; } ?> >08:00 AM</option>
                            <option value="09:00" <?php if(isset($_POST['working_hour_from_1']) =='09:00' ) { echo  'selected'; } ?> >09:00 AM</option>
                            <option value="10:00" <?php if(isset($_POST['working_hour_from_1']) =='10:00' ) { echo  'selected'; } ?> >10:00 AM</option>
                            <option value="11:00" @<?php if(isset($_POST['working_hour_from_1']) =='11:00' ) { echo  'selected'; } ?> >11:00 AM</option>
                            <option value="12:00" <?php if(isset($_POST['working_hour_from_1']) =='12:00' ) { echo  'selected'; } ?> >12:00 PM</option>
                            <option value="13:00"<?php if(isset($_POST['working_hour_from_1']) =='13:00' ) { echo  'selected'; } ?> >01:00 PM</option>
                            <option value="14:00"<?php if(isset($_POST['working_hour_from_1']) =='14:00' ) { echo  'selected'; } ?> >02:00 PM</option>
                            <option value="15:00" <?php if(isset($_POST['working_hour_from_1']) =='15:00' ) { echo  'selected'; } ?> >03:00 PM</option>
                            <option value="16:00" <?php if(isset($_POST['working_hour_from_1']) =='16:00' ) { echo  'selected'; } ?> >04:00 PM</option>
                            <option value="17:00"<?php if(isset($_POST['working_hour_from_1']) =='17:00' ) { echo  'selected'; } ?> >05:00 PM</option>
                            <option value="18:00"<?php if(isset($_POST['working_hour_from_1']) =='18:00' ) { echo  'selected'; } ?> >06:00 PM</option>
                            <option value="19:00" <?php if(isset($_POST['working_hour_from_1']) =='19:00' ) { echo  'selected'; } ?> >07:00 PM</option>
                            <option value="20:00" <?php if(isset($_POST['working_hour_from_1']) =='20:00' ) { echo  'selected'; } ?> >08:00 PM</option>
                            <option value="21:00" <?php if(isset($_POST['working_hour_from_1']) =='21:00' ) { echo  'selected'; } ?> >09:00 PM</option>
                            <option value="22:00"<?php if(isset($_POST['working_hour_from_1']) =='22:00' ) { echo  'selected'; } ?> >10:00 PM</option>
                        </select>
                        <label>To</label>
                        <select type="time" class="form-control" id="totime" name="working_hour_to_1">
                            <option selected="" disabled="" value="">--Select Timing--</option>
                            <option value="07:00" <?php if(isset($_POST['working_hour_from_1']) =='07:00' ) { echo  'selected'; } ?> >07:00 AM</option>
                            <option value="08:00" <?php if(isset($_POST['working_hour_from_1']) =='08:00' ) { echo  'selected'; } ?> >08:00 AM</option>
                            <option value="09:00"<?php if(isset($_POST['working_hour_from_1']) =='09:00' ) { echo  'selected'; } ?> >09:00 AM</option>
                            <option value="10:00" <?php if(isset($_POST['working_hour_from_1']) =='10:00' ) { echo  'selected'; } ?> >10:00 AM</option>
                            <option value="11:00"<?php if(isset($_POST['working_hour_from_1']) =='11:00' ) { echo  'selected'; } ?> >11:00 AM</option>
                            <option value="12:00"<?php if(isset($_POST['working_hour_from_1']) =='12:00' ) { echo  'selected'; } ?> >12:00 PM</option>
                            <option value="13:00" <?php if(isset($_POST['working_hour_from_1']) =='13:00' ) { echo  'selected'; } ?> >01:00 PM</option>
                            <option value="14:00" <?php if(isset($_POST['working_hour_from_1']) =='14:00' ) { echo  'selected'; } ?> >02:00 PM</option>
                            <option value="15:00" <?php if(isset($_POST['working_hour_from_1']) =='15:00' ) { echo  'selected'; } ?> >03:00 PM</option>
                            <option value="16:00" <?php if(isset($_POST['working_hour_from_1']) =='16:00' ) { echo  'selected'; } ?> >04:00 PM</option>
                            <option value="17:00" <?php if(isset($_POST['working_hour_from_1']) =='17:00' ) { echo  'selected'; } ?> >05:00 PM</option>
                            <option value="18:00" <?php if(isset($_POST['working_hour_from_1']) =='18:00' ) { echo  'selected'; } ?> >06:00 PM</option>
                            <option value="19:00"<?php if(isset($_POST['working_hour_from_1']) =='19:00' ) { echo  'selected'; } ?> >07:00 PM</option>
                            <option value="20:00" <?php if(isset($_POST['working_hour_from_1']) =='20:00' ) { echo  'selected'; } ?> >08:00 PM</option>
                            <option value="21:00" <?php if(isset($_POST['working_hour_from_1']) =='21:00' ) { echo  'selected'; } ?> >09:00 PM</option>
                            <option value="22:00"<?php if(isset($_POST['working_hour_from_1']) =='22:00' ) { echo  'selected'; } ?> >10:00 PM</option>
                            <option value="23:00" <?php if(isset($_POST['working_hour_from_1']) =='23:00' ) { echo  'selected'; } ?> >11:00 PM</option>
                        </select>
                     </div>
                  </div>
              </article>
                    <article class="content-entry">
                        <h4 class="article-title"><i></i>Contact Details</h4>
                        <div class="accordion-content">
                            <br/>
                            <div class="well well-lg">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="Address" maxlength="255" class="form-control" ><?php if(isset($_POST['address'])){echo$_POST['address'];}?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="City" maxlength="60" class="form-control" placeholder="City" class="span11" value="<?php if(isset($_POST['City'])){ echo $_POST['City'];}?>" />
                                </div>
                                <div class="form-group">
                                    <label>Home Phone Number</label>
                                    <input type="text" name="HomePhoneNumber" class="form-control number" id="HomePhoneNumber" placeholder="Home Phone Number"  maxlength="15" value="<?php if(isset($_POST['HomePhoneNumber'])){ echo $_POST['HomePhoneNumber'];}?>" class="span11" /> <span class="errmsg"></span>
                                </div>
                                <div class="form-group">
                                    <label>Office Phone Number</label>
                                    <input type="text" name="OfficePhoneNumber" class="form-control number" id="OfficePhoneNumber" placeholder="Office Phone Number" maxlength="15" class="span11" value="<?php if(isset($_POST['OfficePhoneNumber'])){ echo $_POST['OfficePhoneNumber'];}?>" /> <span class="errmsg"></span>
                                </div>
                                <!--/.accordion-content-->
                    </article>

                    <div id="alldata">
                        <article class="content-entry">
                            <h4 class="article-title"><i></i>Emergancy Contact Details </h4>
                            <div class="accordion-content">
                                <br/>
                                <div class="well well-lg">
                                    <div class="form-group">
                                        <label>Emergancy Contact Name</label>
                                        <input type="text" name="emergancyname" value="<?php if(isset($_POST['emergancyname'])){ echo $_POST['emergancyname'];}?>" maxlength="60" class="form-control" placeholder="EmergancyName" class="span11" id="emergancyname" OfficePhoneNumber />
                                    </div>
                                    <div class="form-group">
                                        <label>Emergancy Contact Relation</label>
                                        <input type="text" name="emergancyrelation" value="<?php if(isset($_POST['emergancyrelation'])){ echo $_POST['emergancyrelation'];}?>" maxlength="60" class="form-control" placeholder="EmergancyRelation" class="span11" id="emergancyrelation" />
                                    </div>
                                    <div class="form-group">
                                        <label>Emergancy Contact Address</label>
                                        <textarea rows="2" cols="20" name="emergancyaddress" maxlength="60" wrap="soft" class="form-control"  class="span11"><?php if(isset($_POST['emergancyaddress'])){ echo $_POST['emergancyaddress'];}?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Emergancy Contact Number</label>
                                        <input type="text" name="EmergancyPhoneNumber" class="form-control" placeholder="EmergancyPhoneNumber" value="<?php if(isset($_POST['EmergancyPhoneNumber'])){ echo $_POST['EmergancyPhoneNumber'];}?>" id="EmergancyPhoneNumber"  class="span11" />&nbsp;<span class="errmsg"></span>
                                    </div>
                                </div>
                                <!--/.accordion-content-->
                        </article>
                        <article class="content-entry">
                            <h4 class="article-title"><i></i>Medical Details</h4>
                            <div class="accordion-content">
                                <div class="well well-lg">
                                    <div class="form-group">
                                        <label>Blood group</label>
                                        <input type="text" maxlength="3" value="<?php if(isset($_POST['bloodgroup'])){ echo $_POST['bloodgroup'];}?>" name="bloodgroup" class="form-control" class="span10" />
                                    </div>
                                    <div class="form-group">
                                        <label>Other Medical Details</label>
                                        <br>
                                        <label>A</label>
                                        <input type="text" maxlength="60" value="<?php if(isset($_POST['SpecificGoalsa'])){ echo $_POST['SpecificGoalsa'];}?>" name="SpecificGoalsa" class="form-control" class="span10" />
                                    </div>
                                    <div class="form-group">
                                        <label>B</label>
                                        <input type="text" maxlength="60" value="<?php if(isset($_POST['SpecificGoalsb'])){ echo $_POST['SpecificGoalsb'];}?>" name="SpecificGoalsb" class="form-control" class="span10" />
                                    </div>
                                    <div class="form-group">
                                        <label>C</label>
                                        <input type="text" maxlength="60" value="<?php if(isset($_POST['SpecificGoalsc'])){ echo $_POST['SpecificGoalsc'];}?>" name="SpecificGoalsc" class="form-control" class="span10" />
                                    </div>
                                </div>
                            </div>
                        </article>
     <article class="content-entry">
       <h4 class="article-title"><i></i>Other Information</h4>
       <div class="accordion-content">
        <br/>
        <div class="well well-lg">
            <div class="form-group">
                <label>Hear About..</label>
                <select class="form-control" name="HearAbout">
                    <option disabled="" selected>--Select Any--</option>
                    <option value="Fitness Five Member" @if($_POST( 'HearAbout')=='Fitness Five Member' ) selected @endif>Fitness Five Member</option>
                    <option value="We Called Them" @if($_POST( 'HearAbout')=='We Called Them' ) selected @endif>We Called Them</option>
                    <option value="Friends/Family" @if($_POST( 'HearAbout')=='Friends/Family' ) selected @endif>Friends/Family</option>
                    <option value="Via Internet" @if($_POST( 'HearAbout')=='Via Internet' ) selected @endif>Via Internet</option>
                    <option value="Word Of Mouth" @if($_POST( 'HearAbout')=='Word Of Mouth' ) selected @endif>Word Of Mouth</option>
                    <option value="Radio Advertise" @if($_POST( 'HearAbout')=='Radio Advertise' ) selected @endif>Radio Advertise</option>
                    <option value="Magazine Advertise" @if($_POST( 'HearAbout')=='Magazine Advertise' ) selected @endif>Magazine Advertise</option>
                    <option value="Other" @if($_POST( 'HearAbout')=='Other' ) selected @endif>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Profession</label>
                <input type="text" maxlength="60" value="<?php if(isset($_POST['profession'])){ echo $_POST['profession'];}?>" class="form-control" name="profession" placeholder="Profession" class="span11" />
            </div>
      
            <div class="form-group">
                <label>Are you coming from any company?</label>
                (if Yes than select)
                <select name="bycompany" type="text" class="form-control">
                    <option disabled="" selected>--Select Any--</option>
                    @foreach($company as $comp)

                    <option value="{{$comp->companyid}}">{{$comp->companyname}}</option>
                    @endforeach
                </select>
            </div>
   
            <div class="form-group">
                <label>How often a week whould you like to exercise ?</label>
                <input type="text" name="OftenWeekExercise" class="form-control number" placeholder="Often Week Exercise" class="span11" />
            </div>
            <div class="form-group">
                <label>Where do you rank in health in your life ?</label>
                <br>
                <label>
                    <input type="radio" name="rank" value="h1">HighPriority</label>
                <label>
                    <input type="radio" name="rank" value="m1">MediumPriority</label>
                <label>
                    <input type="radio" name="rank" value="l1">LowPriority</label>
            </div>
            <div class="form-group">
                <label>How commited are you towards reaching your goals ?</label>
                <br>
                <label>
                    <input type="radio" name="goal" value="v1">Very</label>
                <label>
                    <input type="radio" name="goal" value="s1">Semi</label>
                <label>
                    <input type="radio" name="goal" value="b1">Barely</label>
            </div>
        </div>
    </div>
      
    <!--/.accordion-content-->
</article>
<article class="content-entry">
    <h4 class="article-title"><i></i>Profile Photo</h4>
    <div class="accordion-content">
        <div class="well well-lg">
            <div class="form-group">
                <label>Photo</label>
                <input type="file" name="profileimage" class="form-control" id="profileimage" accept="image/jpg, image/jpeg, image/png" class="span11" />
                <img id="img" height="100px">
                <!-- <input type="hidden" name="base64image" class="image-tag"> -->
                <!-- <div id="my_camera"></div>

                <input type=button class="btn bg-orange margin" value="Start Camera" onClick="configure()">
                <input type=button class="btn bg-orange margin" value="Capture" onClick="take_snapshot()">

                <div id="results"></div>

                <input type=button value="Save image" id="profileimagesave" class="btn bg-orange margin" onClick="saveSnap()" style="display: none;"> -->
            </div>
        </div>
    </div>
    <!-- /.accordion-content -->
</article>
<article class="content-entry">
    <h4 class="article-title"><i></i>ID Proof</h4>
    <div class="accordion-content">
        <br/>
        <div class="well well-lg">
            <div class="field" align="left">
                <h3>ID Proofs </h3>
                <h5>(can attach more than one):</h5>
                <input type="file" id="files" name="attachments[]" multiple />
                <ul id="fn"></ul> <i id="file"></i>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-3"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-offset-4">
        <button type="submit" id="save_memberform" class="btn btn-success margin">Save</button> <a href="{{ url('members') }}" class="btn btn-danger margin">Cancel</a>
    </div>
    </div>
    </form>
   <script type="text/javascript">
var image='';
 // Configure a few settings and attach camera
 function configure(){
  Webcam.set({
   width: 320,
   height: 240,
   image_format: 'jpeg',
   jpeg_quality: 90
  });
  Webcam.attach( '#my_camera' );
 }
 // A button for taking snaps


 // preload shutter audio clip
 // var shutter = new Audio();
 // shutter.autoplay = false;
 // shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';

 function take_snapshot() {


  // take snapshot and get image data
  Webcam.snap( function(data_uri) {
  // display results in page
  document.getElementById('results').innerHTML = 
   '<img id="imageprev" src="'+data_uri+'" height="100px" width="100px"/>';

   image=data_uri;
    $("#profileimagesave").css('display','block');

  } );

  Webcam.reset();
 }

function saveSnap(data_uri){

   var base64image = document.getElementById("imageprev").src;
  // alert(base64image);
  $(".image-tag").val(base64image);
  // alert(image);


}
</script>
<script type="text/javascript">
  $('#save_memberform').on('click',function(){
  
      var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      var email = $('#email').val();
     var checked_gender = document.querySelector('input[name = "gender"]:checked');
     var len = $('#MobileNo').val();
     if($('#firstname').val().length < 0  || ($('#firstname').val().length == 0)){
      alert('Please Enter Firstname !'); 
      $('#save_memberform').attr('disabled',false);
      return false;
     }
     if($('#lastname').val().length < 0 || ($('#lastname').val().length == 0)){
      alert('Please Enter Lastname !'); 
      $('#save_memberform').attr('disabled',false);
      return false;
     }
  
     if(checked_gender != null){  //Test if something was checked
     } else {
       $('#save_memberform').attr('disabled',false);
      alert('Please select gender'); 
         return false;
      }
     
      if (reg.test(email) == false) 
      {
        alert('Invalid Email Address');
         $('#save_memberform').attr('disabled',false);
        return false;
      }
     
      if(len.length < 10){

        alert ( "Please Enter valid Phone number" );
         $('#save_memberform').attr('disabled',false);
        return false; 
      }
      

      // alert($('#emergancyname').val().length);
     if( $('#emergancyname').val().length < 0  || $('#emergancyname').val().length == 0) {
       alert( "Please Provide Emergancy Name!" );
            //$('#save_memberform').attr('disabled',false);
       return false;

    }
     if( $('#emergancyrelation').val().length < 0 || $('#emergancyrelation').val().length == 0) {
       alert( "Please Provide Emergancy Relation!" );
        $('#save_memberform').attr('disabled',false);
       return false;
    }
      if( $('#EmergancyPhoneNumber').val().length < 0  || $('#EmergancyPhoneNumber').val().length == 0) {
       alert( "Please Provide Emergancy PhoneNumber!" );
        $('#save_memberform').attr('disabled',false);
       return false;
    }
    if( $('#address').val().length < 0  || $('#address').val().length == 0) {
       alert( "Please Provide Address !" );
        $('#save_memberform').attr('disabled',false);
       return false;
    }
    if( $('#birthday').val().length < 0  || $('#birthday').val().length == 0) {
       alert( "Please Provide Birthdate !" );
        $('#save_memberform').attr('disabled',false);
       return false;
    }
    var fromt = $('#fromtime').val();
   if(!fromt){
       $('#save_memberform').attr('disabled',false);
      alert ( "Please Enter From Time" );
      return false; 
   }
   var tot =$('#totime').val();
   if(!tot){
      alert ( "Please Enter To Time" );
       $('#save_memberform').attr('disabled',false);
      return false; 
   }
    $('#save_memberform').trigger('click');
    $('#save_memberform').attr('disabled',true);
                                                                            
   });
   </script>
 
</section>
<!--/#content-->
<script type="text/javascript">
   $(function(){
                 $('#profileimage').change(function(){

                   var input = this;
                   var url = $(this).val();
                   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                   if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                   {
                     var reader = new FileReader();
   
                     reader.onload = function (e) {
                      $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                  }
                  else
                  {
                     console.log('dsfs');
                   $('#img').attr('src', '/public/images/no_preview.png');
                 }
               });
   
               });
               $(function() {
                 var Accordion = function(el, multiple) {
                   this.el = el || {};
                   this.multiple = multiple || false;
   
                   var links = this.el.find('.article-title');
                   links.on('click', {
                     el: this.el,
                     multiple: this.multiple
                   }, this.dropdown)
                 }
   
                 Accordion.prototype.dropdown = function(e) {
                   var $el = e.data.el;
                   $this = $(this),
                   $next = $this.next();
   
                   $next.slideToggle();
                   $this.parent().toggleClass('open');
   
                   if (!e.data.multiple) {
                     $el.find('.accordion-content').not($next).slideUp().parent().removeClass('open');
                   };
                 }
                 var accordion = new Accordion($('.accordion-container'), false);
               });
   
               $('#radioBtn a').on('click', function(){
                 var sel = $(this).data('title');
                 var tog = $(this).data('toggle');
                 $('#'+tog).prop('value', sel);
   
                 $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('notActive').addClass('notnotActive');
                 $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notnotActive').addClass('notActive');
               });
</script>
<script type="text/javascript">
   $("#div1,#div2,#div3,#div4,#div5,#div7,#div13").hide();
   
               jQuery('.showSingle').click(function(){
                 // jQuery('.targetDiv').hide();
                 jQuery('#div'+$(this).attr('target')).hide(500);
                 
               });
               jQuery('.showno').click(function(){
   
                 jQuery('#div'+$(this).attr('target')).show(500);
               });
   
   
               $('.img-check').click(function(e) {
                 $('.img-check').not(this).removeClass('check')
                 .siblings('input').prop('checked',false);
                 $(this).addClass('check')
                 .siblings('input').prop('checked',true);
               });
</script>



<script type="text/javascript">
   $('#membersave').on('click',function(){
             $('#otp').css("display", "block");
           });
</script>
<script type="text/javascript">
   $('#submit').on('click',function() {
             var FinalAmount = $('#FinalAmount').val();
             var total = $('#total').val();
             if(FinalAmount == total)
              return true;
            else
             $("#modal-default").css("display", "block");
   
           return false;
         });
</script>
<script type="text/javascript">
   $('#MobileNo').on('keyup',function(){
      var error_usermobile = '';
      var usermobile = $('#MobileNo').val();
      var _token = $('input[name="_token"]').val();
   
     //  $.ajax({
     //   url:"/MemberController/checkmobile",
     //   method:"GET",
     //   data:{usermobile:usermobile, _token:_token},
     //   success:function(result)
     //   {
     //    if(result == 'unique')
     //    {
     //     $('#error_usermobile').html('<label class="text-success"></label>');
     //     $('#MobileNo').removeClass('has-error');
         
     //   }
     //   else
     //   {
     //       // alert("hi1");
     //       $('#error_usermobile').html('<label class="text-danger">Mobile number is Already exist</label>');
     //       $('#MobileNo').addClass('has-error');
   
     //     }
     //   }
     // })
    });
</script>
<script type="text/javascript">
   $('#firstbtn').on('click',function(){
     var username = $('#username').val();
       // alert(username);
       var mobileno = $('#MobileNo').val();
       var _token = $('input[name="_token"]').val();
       // alert("hi");
       $.ajax({
         url:"{{ route('createuser') }}",
         method:"POST",
         data:{username:username, mobileno:mobileno, _token:_token},
         success:function(result) 
         {
           // alert(result);
           $('#selectusername').append('<option selected="selected" value="'+result+'">'+$('#username').val()+'</option>');
           $('#selectmoblieno').append('<option selected="selected" value="'+$('#MobileNo').val()+'">'+$('#MobileNo').val()+'</option>');
           // alert("hi1");
           $('#firststep').hide();
           $('#secondstep').show();
         },
         // dataType:"json"
       })
     });
</script>
<script type="text/javascript">
   $(document).ready(function() {
       if (window.File && window.FileList && window.FileReader) {
         $("#files").on("change", function(e) {
          var fileName = $(this).parent().children("strong").text();
          var files = e.target.files,
          filesLength = files.length;
          
   
          for (var i = 0; i < filesLength; i++) {
           var f = files[i];
           var filename1 = f.name;
           var fileReader = new FileReader();
           fileReader.onload = (function(e) {
             var file = e.target;
          // alert(file);
   
          $("<span class=\"pip\">" +
           "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + f.name + "\"/>" +
           "<br/><span class=\"remove\">Remove image</span>" +
           "</span>").insertAfter("#files");
   
          $(".remove").click(function(){
           $(this).parent(".pip").remove();
   
             // alert(e.target.result);
             // $('#files').val(e.target.result);
   
           });
   
             // Old code here
             /*$("<img></img>", {
               class: "imageThumb",
               src: e.target.result,
               title: file.name + " | Click to remove"
             }).insertAfter("#files").click(function(){$(this).remove();});*/
             
           });
           // $('#fn').append('<br><li>'+filename1+'</li>');
           fileReader.readAsDataURL(f);
         }
       });
       } else {
         alert("Your browser doesn't support to File API")
       }
     });
</script>
<script type="text/javascript">
   $('input[type="checkbox"]').on('change',function(){
      // event.preventDefault();
     // var searchIDs = $('input[type="checkbox"]').map(function(){     return $(this).val();    }).get(); // <----
        // $next = $('input[type="checkbox"]').next('td').find('[type=text]');
        //  $next.attr('required','required');
        var x= true;
        $('input[type="checkbox"]').map(function(){
         if($(this).prop("checked") == true){
           var y=  $(this).closest('tr').find('[type=text]').val();
           $(this).closest('tr').find('[type=text]').prop("disabled", false).attr('required','');
           if (y == "")
           {
             alert("kindly enter values of selected PaymentType !");
             x= false;
           }
         }
         else if($(this).prop("checked") == false){
   
         }
       });
             //alert(x);
             if (x == false)
              return false;
            else
             return true;
         });
</script>
<script type="text/javascript">
   $('#rootscheme').on('change',function(){
           $('#scheme').find('option:not(:first)').remove();
     // $('#scheme').find('option').remove();
     var name=document.getElementById("rootscheme").value;
     var _token = $('input[name="_token"]').val();
     if(name)
     {
      $.ajax({
       url:"{{ route('scheme') }}",
       method:"POST",
       data:{name:name, _token:_token},
       success:function(result)
       {
         var data=result;
         $.each(data, function(i,item){
                     // $('#scheme').append('<option value="'+item.id+'">'+item.SchemeName+'</option>');
                     $('#scheme').append($("<option></option>").attr("value",item.id).text(item.SchemeName));
   
                   })
       },
       dataType:"json"
     })
    }
   });
         $("#fromtime").on("change", function(){
          var from=$("#fromtime").prop('selectedIndex');
            // alert(from);
            $('#totime option').eq(from).prop('selected', true);
          });
         $("#totime").on("change", function(){
          var to=$("#totime").prop('selectedIndex');
            // alert(from);
            $('#fromtime option').eq(to).prop('selected', true);
          });
         $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           //display error message
           $(this).find('.errmsg').html("Digits Only are allowed gbghbdfhbdbdfgbdfgfv").show().fadeOut("slow");
           return false;
         }
       });
         $('#scheme').on('change',function(){
          $('#MembershipAmount').val('');
   
     // $('#scheme').find('option').remove();
     var name = document.getElementById("scheme").value;
     var _token = $('input[name="_token"]').val();
     if(name)
     {
      $.ajax({
       url:"{{ route('schemeActualPrice') }}",
       method:"POST",
       data:{name:name, _token:_token},
       success:function(result)
       {
         var data=result;
         $.each(data, function(i,item){
   
   
          $('#MembershipAmount').attr("value",item.id).val(item.ActualPrice);
          $('#BasePrice').attr("value",item.id).val(item.BasePrice);
          $('#FinalAmount').attr("value",item.id).val(item.ActualPrice);
        })
   
       },
       dataType:"json"
     })
    }
   });
</script>
<script type="text/javascript">
   $('#firstname').on('keyup',function(){
       var  first = document.getElementById("firstname").value;
       var  second = document.getElementById("lastname").value;
       $( "#username" ).trigger( "keyup" );
       $('#username').val(first+""+second);
       var el = $('#username').val();
        var val = el.replace(/\s/g, "");
        $('#username').val(val);
       var error_username = '';
       var username = $('#username').val();
       var _token = $('input[name="_token"]').val();
   
     //   $.ajax({
     //     url:"/MemberController/check",
     //     method:"GET",
     //     data:{username:username, _token:_token},
     //     success:function(result)
     //     {
     //      if(result == 'unique')
     //      {
     //       // $('#error_username').html('<label class="text-success">User Name is Valid</label>');
     //       $('#username').removeClass('has-error');
     //       $('#firstbtn').attr('disabled', false);
     //     }
     //     else
     //     {
     //       // alert("hi1");
     //       $('#error_username').html('<label class="text-danger">User Name is Already Exist</label>');
     //       $('#username').addClass('has-error');
     //       $('#firstbtn').attr('disabled', 'disabled');
     //     }
     //   }
     // })
     });
     $('#lastname').on('keyup',function(){
   
       var  first = document.getElementById("firstname").value;
       var  second = document.getElementById("lastname").value;
       $( "#username" ).trigger( "keyup" );
   
       $('#username').val(first+""+second);
        var el = $('#username').val();
        var val = el.replace(/\s/g, "");
        $('#username').val(val);
       var error_username = '';
       var username = $('#username').val();
       var _token = $('input[name="_token"]').val();
   
     //   $.ajax({
     //     url:"/MemberController/check",
     //     method:"GET",
     //     data:{username:username, _token:_token},
     //     success:function(result)
     //     {
     //      if(result == 'unique')
     //      {
     //       // $('#error_username').html('<label class="text-success">User Name is Valid</label>');
     //       $('#username').removeClass('has-error');
     //       $('#firstbtn').attr('disabled', false);
     //     }
     //     else
     //     {
     //       // alert("hi1");
     //       $('#error_username').html('<label class="text-danger">User Name is Already Exist</label>');
     //       $('#username').addClass('has-error');
     //       $('#firstbtn').attr('disabled', 'disabled');
     //     }
     //   }
     // })
     });
</script>
<script type="text/javascript">
   $('#username').on('keyup',function(){
         // alert("hi");
         var error_username = '';
         var username = $('#username').val();
         var _token = $('input[name="_token"]').val();
   
     //     $.ajax({
     //       url:"/MemberController/check",
     //       method:"GET",
     //       data:{username:username, _token:_token},
     //       success:function(result)
     //       {
     //        if(result == 'unique')
     //        {
     //         // $('#error_username').html('<label class="text-success">User Name is Valid</label>');
     //         $('#username').removeClass('has-error');
     //         $('#firstbtn').attr('disabled', false);
     //       }
     //       else
     //       {
     //       // alert("hi1");
     //       $('#error_username').html('<label class="text-danger">User Name is Already Exist</label>');
     //       $('#username').addClass('has-error');
     //       $('#firstbtn').attr('disabled', 'disabled');
     //     }
     //   }
     // })
       });
</script>
</section>