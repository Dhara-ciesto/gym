@extends('layouts.adminLayout.admin_design_without_footer')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>


<style type="text/css"> .accordion-container .article-title {
  display: block;
  position: relative;
  margin: 0;
  padding: 0.625em 0.625em 0.625em 2em;
  border-top:1px solid #0b0b0b;
  font-size: 1.20em;
  font-weight: bold;
  font-weight: normal;
  color: #444C3A;
  cursor: pointer;
}
.box {
  border-top-color: #3a3938 !important;
}
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}
.active {
  border-bottom: 2px solid #ecf0f1;
  text-decoration: none;
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
.timeline-header{ color:white; }



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
.accordion-container .article-title:hover,
.accordion-container .article-title:notActive,
.accordion-container .content-entry.open .article-title {
  background-color: #0b0b0b;
  color: white;
}
.accordion-container .article-title:hover i:before,
.accordion-container .article-title:hover i:notActive,
.accordion-container .content-entry.open i {
  color: white;
}
.accordion-container .content-entry i {
  position: absolute;
  top: 3px;
  left: 12px;
  font-style: normal;
  font-size: 1.625em;
  sans-serif;
  color: #0b0b0b;
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
.accordion-container,
#description {
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
.wrapper {
  margin-right: auto;
  /* 1 */
  margin-left: auto;
  /* 1 */
  max-width: 960px;
  /* 2 */
  padding-right: 10px;
  /* 3 */
  padding-left: 10px;
  /* 3 */
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
.btn-success {
  background-color: #82C030;
  border-color: #82C030;
}
.btn-success:hover {
  background-color: #83C530;
  border-color: #83C530;
}
#radioBtn .notActive {
  color: #000000;
  background-color: #fff;
}
.check {
  opacity: 0.5;
  color: #996;
}
.box {
  border-top-color: #3a3938 !important;
  margin-bottom: 5px;
}
.active {
  border-top-color: #3a3938 !important;
}
.timeline-item {
  background: #474444 !important;
}
:root {
  --main-color: #ffffff;
  --circle-color: #000;
  --size-to: 100px;
}
#martix {
  position: absolute;
  left: 30px;
  top: 95px;
  position: fixed;
}
.circle {
  overflow: hidden;
  width: 41%;
  height: 38%;
  position: fixed;
  bottom: 102px;
  left: 0;
  display: flex;
  align-items: center;
  align-content: center;
  justify-content: center;
  z-index: 10000;
}
.circle__el {
  width: 0;
  height: 0;
  background: transparent;
  border: 5px solid var(--circle-color);
  border-radius: 50%;
  animation: go 1.5s ease-out infinite;
}
.circle__el_two {
  animation-delay: 0.5s;
}
.circle__el_three {
  animation-delay: 1s;
}
@keyframes go {
  100% {
    width: var(--size-to);
    height: var(--size-to);
    box-shadow: 0 0 15px var(--circle-color);
    opacity: 0;
  }
}
.cloud {
  width: 70%;
  z-index: 1;
}
#a {
  position: relative;
  top: 1px;
  left: 0px;
  animation: one 2s ease-in infinite;
}
@keyframes one {
  0% {
    left: -80px;
  }
  50% {
    left: 50px;
  }
  60% {
    left: 50px;
  }
  70% {
    left: 50px;
    opacity: 1;
  }
  100% {
    left: 210px;
    opacity: 0;
  }
}
input[type="date"]::-webkit-inner-spin-button,
input[type="date"]::-webkit-clear-button {
    display: none;
    -webkit-appearance: none;
}
/*form styles*/

#msform {
  text-align: center;
  position: relative;
  margin-top: 30px;
}
#msform fieldset {
  background: white;
  border: 0 none;
  border-radius: 0px;
  box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
  padding: 20px 30px;
  box-sizing: border-box;
  width: 80%;
  margin: 0 10%;
  /*stacking fieldsets above each other*/
  position: relative;
}
/*Hide all except first fieldset*/

#msform fieldset:not(:first-of-type) {
  display: none;
}
/*inputs*/

#msform input,
#msform textarea {
  padding: 15px;
  border: 1px solid #ccc;
  border-radius: 0px;
  margin-bottom: 10px;
  width: 100%;
  box-sizing: border-box;
  font-family: montserrat;
  color: #2C3E50;
  font-size: 13px;
}
#msform input:focus,
#msform textarea:focus {
  -moz-box-shadow: none !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
  border: 1px solid #F4E5CE;
  outline-width: 0;
  transition: All 0.5s ease-in;
  -webkit-transition: All 0.5s ease-in;
  -moz-transition: All 0.5s ease-in;
  -o-transition: All 0.5s ease-in;
}
/*buttons*/

#msform .action-button {
  width: 100px;
  background: #E4971C;
  font-weight: bold;
  color: white;
  border: 0 none;
  border-radius: 25px;
  cursor: pointer;
  padding: 10px 5px;
  margin: 10px 5px;
}
#msform .action-button:hover,
#msform .action-button:focus {
  box-shadow: 0 0 0 2px white, 0 0 0 3px #E4971C;
}
#msform .action-button-previous {
  width: 100px;
  background: #C5C5F1;
  font-weight: bold;
  color: white;
  border: 0 none;
  border-radius: 25px;
  cursor: pointer;
  padding: 10px 5px;
  margin: 10px 5px;
}
#msform .action-button-previous:hover,
#msform .action-button-previous:focus {
  box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
}
/*headings*/

.fs-title {
  font-size: 18px;
  text-transform: uppercase;
  color: #2C3E50;
  margin-bottom: 10px;
  letter-spacing: 2px;
  font-weight: bold;
}
.fs-subtitle {
  font-weight: normal;
  font-size: 13px;
  color: #666;
  margin-bottom: 20px;
}
/*progressbar*/

#progressbar {
  margin-bottom: 30px;
  overflow: hidden;
  /*CSS counters to number the steps*/
  counter-reset: step;
}
#progressbar li {
  list-style-type: none;
  color: #E79718;
  text-transform: uppercase;
  font-size: 9px;
  width: 25%;
  float: left;
  position: relative;
  letter-spacing: 1px;
}
#progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 24px;
  height: 24px;
  line-height: 26px;
  display: block;
  font-size: 12px;
  color: #333;
  background: white;
  border-radius: 25px;
  margin: 0 auto 10px auto;
}
/*progressbar connectors*/

#progressbar li:after {
  content: '';
  width: 100%;
  height: 2px;
  background: white;
  position: absolute;
  left: -50%;
  top: 9px;
  z-index: -1;
  /*put it behind the numbers*/
}
#progressbar li:first-child:after {
  /*connector not needed before the first step*/
  content: none;
}
/*marking active/completed steps green*/

/*The number of the step and the connector before it = green*/

#progressbar li.active:before,
#progressbar li.active:after {
  background: #E4971C;
  color: white;
}
/* Not relevant to this form */

.dme_link {
  margin-top: 30px;
  text-align: center;
}
.dme_link a {
  background: #FFF;
  font-weight: bold;
  color: #8bc73c;
  border: 0 none;
  border-radius: 25px;
  cursor: pointer;
  padding: 5px 25px;
  font-size: 12px;
}
.dme_link a:hover,
.dme_link a:focus {
  background: #C5C5F1;
  text-decoration: none;
}
.donate-now li {
  float: left;
  margin: 0 5px 0 0;
  width: 100px;
  height: 40px;
  position: relative;
  list-style-type: none;
}
#title {
  text-align: center;
}
.donate-now label,
.donate-now input {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.donate-now input[type="radio"] {
  opacity: 0.01;
  z-index: 100;
}
.donate-now input[type="radio"]:checked + label,
.Checked + label {
  background: #E4971C;
}
.donate-now label {
  padding: 5px;
  border: 1px solid #CCC;
  /* cursor:pointer;*/
  z-index: 90;
}
select {
  width: 100%;
  padding: 10px 15px;
  border: 1px blue;
  border-radius: 4px;
  background-color: #F2EBE0;
}
select option {
  padding: 5px;
  border: 1px blue;
}
.donate-now-change li {
  float: left;
  margin: 0 5px 0 0;
  width: 150px;
  height: 40px;
  position: relative;
  list-style-type: none;
}
.donate-now-change label,
.donate-now input {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.donate-now-change input[type="radio"] {
  opacity: 0.01;
  z-index: 100;
}
.donate-now-change input[type="radio"]:checked + label,
.Checked + label {
  background: #E4971C;
}
.donate-now-change label {
  padding: 5px;
  border: 1px solid #CCC;
  z-index: 90;
}


.addfollowers {
  float: left;
  padding: 2%;
}
.clearfix:before,
.clearfix:after {
  content: " ";
  /* 1 */
  display: table;
  /* 2 */
}
.clearfix:after {
  clear: both;
}
/*
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */

.clearfix {
  *zoom: 1;
}
/*//////////////////////////////////////////////////////////////////
[ FONT ]*/

@font-face {
  font-family: Poppins-Regular;
  src: url('../fonts/poppins/Poppins-Regular.ttf');
}
@font-face {
  font-family: Poppins-Medium;
  src: url('../fonts/poppins/Poppins-Medium.ttf');
}
@font-face {
  font-family: Poppins-Bold;
  src: url('../fonts/poppins/Poppins-Bold.ttf');
}
@font-face {
  font-family: Poppins-SemiBold;
  src: url('../fonts/poppins/Poppins-SemiBold.ttf');
}
/*//////////////////////////////////////////////////////////////////
[ RESTYLE TAG ]*/

* {
  margin: 0px;
  padding: 0px;
  box-sizing: border-box;
}

/*---------------------------------------------*/

a:focus {
  outline: none !important;
}
a:hover {
  text-decoration: none;
}
/*---------------------------------------------*/

h1,h2,h3,h4,h5,h6 {
  margin: 0px;
}
p {
  font-family: Poppins-Regular;
  font-size: 14px;
  line-height: 1.7;
  color: #666666;
  margin: 0px;
}
ul,
li {
  margin: 0px;
  list-style-type: none;
}
/*---------------------------------------------*/

input {
  outline: none;
  border: none;
}
input[type="number"] {
  -moz-appearance: textfield;
  appearance: none;
  -webkit-appearance: none;
}
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
textarea {
  outline: none;
  border: none;
  border-radius: inherit;
}
/*textarea:focus, input:focus {
  border-color: transparent !important;
}*/

input:focus::-webkit-input-placeholder {
  color: transparent;
}
input:focus:-moz-placeholder {
  color: transparent;
}
input:focus::-moz-placeholder {
  color: transparent;
}
input:focus:-ms-input-placeholder {
  color: transparent;
}
textarea:focus::-webkit-input-placeholder {
  color: transparent;
}
textarea:focus:-moz-placeholder {
  color: transparent;
}
textarea:focus::-moz-placeholder {
  color: transparent;
}
textarea:focus:-ms-input-placeholder {
  color: transparent;
}
input::-webkit-input-placeholder {
  color: #999999;
}
input:-moz-placeholder {
  color: #999999;
}
input::-moz-placeholder {
  color: #999999;
}
input:-ms-input-placeholder {
  color: #999999;
}
textarea::-webkit-input-placeholder {
  color: #999999;
}
textarea:-moz-placeholder {
  color: #999999;
}
textarea::-moz-placeholder {
  color: #999999;
}
textarea:-ms-input-placeholder {
  color: #999999;
}
/*---------------------------------------------*/

button {
  outline: none !important;
  border: none;
  background: transparent;
}
button:hover {
  cursor: pointer;
}
iframe {
  border: none !important;
}
/*//////////////////////////////////////////////////////////////////
[ Contact ]*/

.container-contact100 {
  width: 100%;
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
  background: transparent;
  position: relative;
  z-index: 1;
}
.contact100-map {
  position: absolute;
  z-index: -2;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
}
.wrap-contact100 {
  width: 670px;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
}
/*==================================================================
[ Title form ]*/

.contact100-form-title {
  width: 100%;
  position: relative;
  z-index: 1;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  align-items: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  padding: 64px 15px 64px 15px;
}
.contact100-form-title-1 {
  font-family: Poppins-Bold;
  font-size: 20px;
  color: #fff;
  line-height: 1.2;
  text-align: center;
  padding-bottom: 7px;
}
.contact100-form-title-2 {
  font-family: Poppins-Regular;
  font-size: 15px;
  color: #fff;
  line-height: 1.5;
  text-align: center;
}
.contact100-form-title::before {
  content: "";
  display: block;
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(54, 84, 99, 0.7);
}
/*==================================================================
[ Form ]*/

.contact100-form {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 43px 88px 57px 190px;
}
/*------------------------------------------------------------------
[ Input ]*/

.wrap-input100 {
  width: 100%;
  position: relative;
  border-bottom: 1px solid #b2b2b2;
  margin-bottom: 26px;
}
.label-input100 {
  font-family: Poppins-Regular;
  font-size: 15px;
  color: #808080;
  line-height: 1.2;
  text-align: right;
  position: absolute;
  top: 14px;
  left: -105px;
  width: 80px;
}
/*---------------------------------------------*/

/*---------------------------------------------*/

input.input100 {
  height: 45px;
}
textarea.input100 {
  min-height: 115px;
  padding-top: 14px;
  padding-bottom: 13px;
}
/*------------------------------------------------------------------
[ Alert validate ]*/

.validate-input {
  position: relative;
}
</style>
  <div class="content-wrapper">

    <section class="content-header">
      <h1 style="text-decoration: none">
        Member Profile &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;Form No &nbsp;&nbsp;<input type="number" name="refno" id="refno"  readonly="" placeholder="Form No." class="span11" required="" value="{{$member->memberid}}" />
      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>

      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
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
      @if($message)
      <div class="alert alert-success alert-block" id="ak">
        <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{{ $message }}</strong>
      </div>
      <script type="text/javascript">
          $(document).ready (function(){
           $('#pkgd').trigger('click');
            });
      </script>
    @endif
    @endif
<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="box">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" style="height: 200px; width:200px;" <?php if ($member->photo): ?> src="/files/{{$member->photo}}"
        <?php else: ?>src="/files/default.png"
        <?php endif ?>alt="User profile picture">
        <h3 class="profile-username text-center">{{$member->firstname}} {{$member->lastname}}</h3>
        <p class="text-muted text-center">{{$member->profession}}</p>
        <br/>
        <!-- <ul class="list-group list-group-unbordered"> -->@if($member->mstatus == 2)
        <center>
          <div class="btn btn-success" style="background: #1788f7;">Freezed</div>
        </center>
        @elseif($member->mstatus == 1)
        <center>
          <div class="btn btn-success" style="background: #1788f7;">Active</div>
        </center>


 @elseif($member->mstatus == 0)
        <center>
          <div class="btn btn-success" style="background: #1788f7;">Deactive</div>
        </center>


        <br/>@endif
        <div class="nav-tabs-custom">
          <ul class="">
            <li class="list-group-item">
              <button type="button" id="package"><b style="text-decoration: none">Packages</b>
              </button>
              <p class="pull-right">{{count($packages)}}</p>
            </li>
             <li class="list-group-item">
              <button type="button" id="package"><b style="text-decoration: none">Freeze Count</b>
              </button>
              <p class="pull-right">{{count($freezemembership_data)}}</p>
            </li>
            <li class="list-group-item"> <b>Notes</b>  <a class="pull-right" style="color: black">{{count($notes)}}</a>
            </li>
            <!-- <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li> -->
          </ul>
        </div>
        <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <!-- About Me Box -->
    <!-- /.box -->
    <br>
    <input class="input100" type="hidden" name="memberid" value="{{$member->mid}}">
    <!-- ********************for create note**************************-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Add Note</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Recipient:</label>
                <input type="text" class="form-control" id="recipient-name" readonly="" value="{{$member->username}}">
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Note:</label>
                <textarea class="form-control" id="notes"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-green" id="savenotes">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- ********************for edit note**************************-->
    <div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Note</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Recipient:</label>
                <input type="text" class="form-control" id="recipient-name" readonly="" value="{{$member->username}}">
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Note:</label>
                <textarea class="form-control" id="notesdetails"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-green" id="updatenote">Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- ********************for view note**************************-->
    <div class="modal fade" id="exampleModalview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"><b>View Note</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Recipient:</label>
                <input type="text" class="form-control" id="recipient-name" readonly="" value="{{$member->username}}">
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Note:</label>
                <textarea class="form-control" id="notedetail"></textarea>
              </div>
              <div id="imagePreview">@foreach($notes as $note) @if($note->images) @php $noteimages = json_decode($note->images); @endphp @foreach($noteimages as $imgs)
                <a href="/files/{{$imgs}}" target="_blank">
                  <img src="/files/{{$imgs}}" alt="Image Alternative text" title="{{$imgs}}" height="100px" />
                </a>@endforeach @endif @endforeach</div>
            </form>
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn bg-orange" id="uploadimage">Upload</button> -->
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- ********************for image upload**************************-->
    <div class="modal fade" id="exampleModalimage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"><b>Image Note</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" enctype="multipart/form-data" action="{{ route('imageupload') }}">{{csrf_field()}}
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Recipient:</label>
                <input type="text" class="form-control" id="recipient-name" name="user" value="{{$member->username}}">
                <input type="hidden" name="note" value="" id="noteid">
              </div>
              <div class="form-group">
                <label for="images" class="col-form-label">Image Upload:</label>
                <input type="file" name="image_upload[]" accept="image/x-png,image/gif,image/jpeg" enctype="multipart/form-data" id="image-upload" multiple />
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-green" name="imageupload" id="imageupload">Upload</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- ********************for**************************-->
    <div id="notesall">
      <div class="box box-body">
        <center> <a href="{{ url('assignPackageOrRenewalPackage/'.$member->userid) }}" class="btn bg-orange" id="assignpackage">Assign Package</a>
        </center>
      </div>
      <div class="box box-primary">
        <div class="box-body content-fit-box">
          <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">+ Add Notes</button>
        </div>
      </div>
      <?php $i=0; ?>@if($notes)
      <div class="box box-primary">@foreach($notes as $key =>$note)
        <div class="box-body content-fit-box">{{ substr($note->notes, 0, 18) }}{{'...'}} &emsp;
          <br/>
          <br>
          <button type="button" class="btn bg-orange editnote" id="editnote" data-toggle="modal" data-target="#exampleModaledit" value="{{$note->notesid}}" onclick="datadisplay('<?php echo $note->notesid; ?>')"><i class="fa fa-edit"></i>
          </button>
          <button type="button" class="btn bg-red" id="viewnote" data-toggle="modal" data-target="#exampleModalview" value="{{$note->notes}}" onclick="datadisplay('<?php echo $note->notesid; ?>')"><i class="fa fa-eye"></i>
          </button>
          <input type="hidden" name="imgnote{{$i}}" id="imgnote{{$i}}" value="{{$note->notesid}}">
          <button type="button" class="btn bg-navy" id="imagenote{{$i}}" onclick="imagenote('{{$note->notesid}}')" data-toggle="modal" data-target="#exampleModalimage"><i class="fa fa-image"></i>
          </button>
          <button type="button" class="btn bg-navy" data-toggle="modal" value="{{$note->notesid}}" id="notedelete{{<?php echo $i; ?>}}" onclick="notedelete('<?php echo $note->notesid; ?>')"><i class="fa fa-trash"></i>
          </button>
        </div>
        <?php $i++ ?>@endforeach</div>@endif</div>
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#timeline" data-toggle="tab">Timeline</a>
        </li>
        <li><a href="#activity" data-toggle="tab">Personal Details</a>
        </li>
        <li>
          <a>
            <button id="pkgd" data-target="#packagedetails" data-toggle="tab">Package Details</button>
          </a>
        </li>
        <li><a href="#paymenthistory" data-toggle="tab">Payment History</a>
        </li>
        <li><a href="#settings" data-toggle="tab">Settings</a>
        </li>
        <li><a href="#workout" data-toggle="tab">Workout</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="activity">
          <!-- Post -->
          <!-- <form action="{{ url('verify') }}" method="post" enctype="multipart/form-data" enctype="multipart/formdata">  {{ csrf_field() }} -->
          <div id="accordion" class="accordion-container">
            <article class="content-entry">
              <h4 class="article-title"><i></i>Registration Details</h4>
              <div class="accordion-content">
                <br/>
                <div class="well well-lg">
                  <form action="{{ url('editmember/'.$member->userid) }}" method="post" enctype="multipart/form-data">{{ csrf_field() }}
                    <div class="form-group">
                      <label>First Name</label>
                      <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" class="span11" required="" value="{{$member->firstname}}" />
                    </div>
                    <div class="form-group">
                      <label>LastName</label>
                      <input type="text" name="lastname" id="lastname" class="form-control inline-block" placeholder="LastName" class="span11" required="" value="{{$member->lastname}}" />
                    </div>
                    <div class="form-group">
                      <label>User Name</label>
                      <input type="text" name="username" id="username" class="form-control" placeholder="User Name" class="span11" required="" value="{{$member->username}}" readonly="" /><span id="error_username"></span>
                    </div>
                    <div class="form-group">
                      <label>Gender</label>
                      <label>
                        <input type="radio" name="gender" value="Female" {{ $member->gender == "Female"? 'checked' :''}}> Female</label>
                      <label>
                        <input type="radio" name="gender" value="Male" {{ $member->gender == "Male"? 'checked' :''}}> Male</label>
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Email Id" class="span11" value="{{$member->email}}" />
                    </div>
                    <div class="form-group">
                      <label>Cell Phone Number</label>
                      <input type="text" value="{{$member->mobileno}}" name="CellPhoneNumber" id="MobileNo" minlength="10" maxlength="10"  class="form-control number" placeholder="Mobile No" required="" class="span11" /><span class="errmsg"></span>
                    </div>
                    <div class="form-group">
                      <label>Birthdate</label>
                      <input placeholder="Birthdate" type="date" onkeypress="return false" class="form-control" name="birthday" class="span11" value="{{$member->birthday}}" max="<?php echo date('Y-m-d');?>">
                    </div>
                    <div class="form-group">
                      <label>Anniversary</label>
                      <input placeholder="Anniversary" type="date" onkeypress="return false" class="form-control" name="anniversary" class="span11" value="{{$member->anniversarydate}}">
                    </div>
                    <div class="form-group">
                      <label>Timing</label>
                      <br> <span><label>From</label></span>
                      <?php $date=date( "H:i", strtotime($member->mworkinghourfrom)); ?>
                      <select type="time" class="form-control" name="working_hour_from_1" id="fromtime">
                        <option value="06:00" {{$date=='06:00' ? 'selected': ''}}>06:00 AM</option>
                        <option value="07:00" {{$date=='07:00' ? 'selected': ''}}>07:00 AM</option>
                        <option value="08:00" {{$date=='08:00' ? 'selected': ''}}>08:00 AM</option>
                        <option value="09:00" {{$date=='09:00' ? 'selected': ''}}>09:00 AM</option>
                        <option value="10:00" {{$date=='10:00' ? 'selected': ''}}>10:00 AM</option>
                        <option value="11:00" {{$date=='11:00' ? 'selected': ''}}>11:00 AM</option>
                        <option value="12:00" {{$date=='12:00' ? 'selected': ''}}>12:00 PM</option>
                        <option value="13:00" {{$date=='13:00' ? 'selected': ''}}>01:00 PM</option>
                        <option value="14:00" {{$date=='14:00' ? 'selected': ''}}>02:00 PM</option>
                        <option value="15:00" {{$date=='15:00' ? 'selected': ''}}>03:00 PM</option>
                        <option value="16:00" {{$date=='16:00' ? 'selected': ''}}>04:00 PM</option>
                        <option value="17:00" {{$date=='17:00' ? 'selected': ''}}>05:00 PM</option>
                        <option value="18:00" {{$date=='18:00' ? 'selected': ''}}>06:00 PM</option>
                        <option value="19:00" {{$date=='19:00' ? 'selected': ''}}>07:00 PM</option>
                        <option value="20:00" {{$date=='20:00' ? 'selected': ''}}>08:00 PM</option>
                        <option value="21:00" {{$date=='21:00' ? 'selected': ''}}>09:00 PM</option>
                        <option value="22:00" {{$date=='22:00' ? 'selected': ''}}>10:00 PM</option>
                      </select>
                      <label>To</label>
                      <?php $date=date( "H:i", strtotime($member->mworkinghourto)); ?>
                      <select type="time" class="form-control" id="totime" name="working_hour_to_1">
                        <option value="07:00" {{$date=='07:00' ? 'selected': ''}}>07:00 AM</option>
                        <option value="08:00" {{$date=='08:00' ? 'selected': ''}}>08:00 AM</option>
                        <option value="09:00" {{$date=='09:00' ? 'selected': ''}}>09:00 AM</option>
                        <option value="10:00" {{$date=='10:00' ? 'selected': ''}}>10:00 AM</option>
                        <option value="11:00" {{$date=='11:00' ? 'selected': ''}}>11:00 AM</option>
                        <option value="12:00" {{$date=='12:00' ? 'selected': ''}}>12:00 PM</option>
                        <option value="13:00" {{$date=='13:00' ? 'selected': ''}}>01:00 PM</option>
                        <option value="14:00" {{$date=='14:00' ? 'selected': ''}}>02:00 PM</option>
                        <option value="15:00" {{$date=='15:00' ? 'selected': ''}}>03:00 PM</option>
                        <option value="16:00" {{$date=='16:00' ? 'selected': ''}}>04:00 PM</option>
                        <option value="17:00" {{$date=='17:00' ? 'selected': ''}}>05:00 PM</option>
                        <option value="18:00" {{$date=='18:00' ? 'selected': ''}}>06:00 PM</option>
                        <option value="19:00" {{$date=='19:00' ? 'selected': ''}}>07:00 PM</option>
                        <option value="20:00" {{$date=='20:00' ? 'selected': ''}}>08:00 PM</option>
                        <option value="21:00" {{$date=='21:00' ? 'selected': ''}}>09:00 PM</option>
                        <option value="22:00" {{$date=='22:00' ? 'selected': ''}}>10:00 PM</option>
                        <option value="22:00" {{$date=='23:00' ? 'selected': ''}}>11:00 PM</option>
                      </select>
                    </div>
                     <!-- <div class="form-group">
                      <label>Form no.</label>
                      <input type="number" name="refno" id="refno" class="form-control" placeholder="Form no." class="span11" required="" value="{{$member->refno}}" />
                    </div> -->
                </div>
              </div>
              <!--/.accordion-content-->
            </article>
            <article class="content-entry">
              <h4 class="article-title"><i></i>Contact Details</h4>
              <div class="accordion-content">
                <br/>
                <div class="well well-lg">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea rows="2" cols="20" name="Address" wrap="soft" class="form-control" placeholder="Address" class="span11">{{$member->address}}</textarea>
                  </div>
                  <div class="form-group">
                    <label>City</label>
                    <input type="text" name="City" class="form-control" placeholder="City" value="{{$member->city}}" class="span11" />
                  </div>
                  <div class="form-group">
                    <label>Home Phone Number</label>
                    <input type="text" name="HomePhoneNumber" class="form-control number" id="HomePhoneNumber" placeholder="Home Phone Number" minlength="10" maxlength="10" class="span11" value="{{$member->homephonenumber}}" /> <span class="errmsg"></span>
                  </div>
                  <div class="form-group">
                    <label>Office Phone Number</label>
                    <input type="text" name="OfficePhoneNumber" class="form-control number" id="OfficePhoneNumber" placeholder="Office Phone Number" minlength="10" maxlength="10" class="span11" value="{{$member->officephonenumber}}" /> <span class="errmsg"></span>
                  </div>
                  <!--/.accordion-content-->
            </article>
            <article class="content-entry">
              <h4 class="article-title"><i></i>Emergancy Contact Details </h4>
              <div class="accordion-content">
                <br/>
                <div class="well well-lg">
                  <div class="form-group">
                    <label>Emergancy Contact Name</label>
                    <input type="text" name="emergancyname" class="form-control" placeholder="EmergancyName" class="span11" value="{{$member->emergancyname}}" />
                  </div>
                  <div class="form-group">
                    <label>Emergancy Contact Relation</label>
                    <input type="text" name="emergancyrelation" class="form-control" placeholder="EmergancyRelation" class="span11" value="{{$member->emergancyrelation}}" />
                  </div>
                  <div class="form-group">
                    <label>Emergancy Contact Address</label>
                    <textarea rows="2" cols="20" name="emergancyaddress" wrap="soft" class="form-control" placeholder="Emergancy Address" class="span11">{{$member->emergancyaddress}}</textarea>
                  </div>
                  <div class="form-group">
                    <label>Emergancy Contact Number</label>
                    <input type="text" name="EmergancyPhoneNumber" class="form-control number" id="EmergancyPhoneNumber" placeholder="EmergancyPhoneNumber" minlength="10" maxlength="10" class="span11" value="{{$member->emergancyphonenumber}}" />&nbsp;<span class="errmsg"></span>
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
                    <br>
                    <input type="text" name="bloodgroup" class="form-control" value="{{$member->bloodgroup}}" class="span10" />
                  </div>
                  <div class="form-group">
                    <label>Medical group</label>
                    <br>
                    <label>A</label>
                    <input type="text" name="SpecificGoalsa" class="form-control" value="{{$member->specificgoalsa}}" class="span10" />
                  </div>
                  <div class="form-group">
                    <label>B</label>
                    <input type="text" name="SpecificGoalsb" class="form-control" class="span10" value="{{$member->specificgoalsb}}" />
                  </div>
                  <div class="form-group">
                    <label>C</label>
                    <input type="text" name="SpecificGoalsc" class="form-control" class="span10" value="{{$member->specificgoalsc}}" />
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
                      <option value="Fitness Five Member" {{$member->hearabout == 'Fitness Five Member' ? 'selceted':'' }}>Fitness Five Member</option>
                      <option value="We Called Them" {{$member->hearabout == 'We Called Them' ? 'selected':'' }}>We Called Them</option>
                      <option value="Friends/Family" {{$member->hearabout == 'Friends/Family' ? 'selected':'' }}>Friends/Family</option>
                      <option value="Via Internet" {{$member->hearabout == 'Via Internet' ? 'selected':'' }}>Via Internet</option>
                      <option value="Word Of Mouth" {{$member->hearabout == 'Word Of Mouth' ? 'selected':'' }}>Word Of Mouth</option>
                      <option value="Radio Advertise" {{$member->hearabout == 'Radio Advertise' ? 'selected':'' }}>Radio Advertise</option>
                      <option value="Magazine Advertise" {{$member->hearabout == 'Magazine Advertise' ? 'selected':'' }}>Magazine Advertise</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Profession</label>
                    <input type="text" class="form-control" name="profession" placeholder="Profession" class="span11" value="{{$member->profession}}" />
                  </div>
                  <div class="form-group">
                    <label>Are you coming from any company?</label>(if Yes than select)
                    <select name="bycompany" type="text" class="form-control">
                      <option disabled="" selected>--Select Any--</option>@foreach($company as $comp)
                      <option value="{{$comp->companyid}}" {{$member->companyid == $comp->companyid ? 'selected': ''}}>{{$comp->companyname}}</option>@endforeach</select>
                  </div>
                </div>
              </div>
              <!--/.accordion-content-->
            </article>
            <article class="content-entry">
              <h4 class="article-title"><i></i>Fitness Goals & Exercise Program</h4>
              <div class="accordion-content">
                <br/>
                <div class="well well-lg">
                  <label>Fitness Goals</label>
                  <table class="table table-bordered table-striped dataTable table-wrapper" aria-describedby="example1_info">
                    <tr>
                      <td>
                        <label>LoseBodyFat
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="1" {{$member->losebodyfat == 1 ? 'checked':''}}><span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                      <td>
                        <label>DevelopMuscle
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="2" {{$member->developmuscle == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>ImproveBalance
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="4" {{$member->improvebalance == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                      <td>
                        <label>RehabilitateAnInjury
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="3" {{$member->rehabilitateaninjury == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                    </tr>
                    <tr></tr>
                    <td>
                      <label>ImproveFlexibility
                        <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="5" {{$member->improveflexibility == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                      </label>
                    </td>
                    <td>
                      <label>NutritionalEducation
                        <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="6" {{$member->nutritionaleducation == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                      </label>
                    </td>
                    </tr>
                    <tr>
                      <td>
                        <label>DesignBeginnersProgram
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="7" {{$member->designbeginnersprogram == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                      <td>
                        <label>DesignAdvancedProgram
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="8" {{$member->desigadvancedprogram == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>TrainSpecific
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="9" {{$member->trainspecific == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                      <td>
                        <label>Safety
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="10" {{$member->safety == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>MakeExerciseFun
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="11" {{$member->makeexercisefun == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                      <td>
                        <label>Motivation
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="12" {{$member->motivation == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Other
                          <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="13" {{$member->fother == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                        </label>
                      </td>
                      <td>
                        <textarea name="OtherHelp" placeholder="OtherHelp">{{$member->otherhelp}}</textarea>
                      </td>
                    </tr>
                  </table>
                  <div class="form-group">
                    <label>What activities interest you ?</label>
                    <br>
                    <table class="table table-bordered table-striped dataTable table-wrapper" role="grid" aria-describedby="example1_info">
                      <tr>
                        <td>
                          <label>Baseball
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="1" {{$member->baseball == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Basketball
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="2" {{$member->basketball == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Boxing
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="3" {{$member->boxing == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>KickBoxing
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="4" {{$member->kickboxing == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Skiing
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="5" {{$member->skiing == 1 ? 'checked':''}}><span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Football
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="6" {{$member->football == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Golf
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="7" {{$member->golf == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Hiking
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="8" {{$member->hiking == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Pilates
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="9" {{$member->pilates == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Racquetball
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="10" {{$member->racquetball == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>IndoorCycling
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="11" {{$member->indoorcycling == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Kayaking
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="12" {{$member->kayaking == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>RockClimbing
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="13" {{$member->rockclimbing == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Running
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="14" {{$member->running == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Soccer
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="15" {{$member->soccer == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Swimming
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="16" {{$member->swimming == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Tennis
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="17" {{$member->tennis == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Triathlon
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="18" {{$member->triathlon == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Walking
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="19" {{$member->walking == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>WeightTrainning
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="20" {{$member->weighttrainning == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Yoga
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="21" {{$member->yoga == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Stretching
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="22" {{$member->stretching == 1 ? 'checked':''}}><span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <label>Other
                            <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="23" {{$member->eother == 1 ? 'checked':''}}> <span class="badge bg-orange">&check;</span>
                          </label>
                        </td>
                        <td>
                          <textarea name="OtherActivity" placeholder="OtherActivity" class="span2">{{$member->otheractivity}}</textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="form-group">
                    <label>How often a week whould you like to exercise ?</label>
                    <input type="text" name="OftenWeekExercise" class="form-control" placeholder="Often Week Exercise" class="span11" value="{{$member->oftenweekexercise}}" />
                  </div>
                  <div class="form-group">
                    <label>Where do you rank in health in your life ?</label>
                    <br>
                    <label>
                      <input type="radio" name="rank" value="h1" {{$member->highpriority == 1 ? 'checked':''}}> HighPriority</label>
                    <label>
                      <input type="radio" name="rank" value="m1" {{$member->mediumpriority == 1 ? 'checked':''}}> MediumPriority</label>
                    <label>
                      <input type="radio" name="rank" value="l1" {{$member->lowpriority == 1 ? 'checked':''}}> LowPriority</label>
                  </div>
                  <div class="form-group">
                    <label>How commited are you towards reaching your goals ?</label>
                    <br>
                    <label>
                      <input type="radio" name="goal" value="v1" {{$member->very == 1 ? 'checked':''}}> Very</label>
                    <label>
                      <input type="radio" name="goal" value="s1" {{$member->semi == 1 ? 'checked':''}}> Semi</label>
                    <label>
                      <input type="radio" name="goal" value="b1" {{$member->barely == 1 ? 'checked':''}}> Barely</label>
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
                    <input type="file" name="file" class="form-control" id="profileimage" class="span11" />
                    <input type="hidden" name="base64image" class="image-tag">@if($member->photo)
                    <img src="/files/{{$member->photo}}" id="img" height="100px">@endif
                    <div id="my_camera"></div>
                    <input type=button class="btn bg-orange margin" value="Start Camera" onClick="configure()">
                    <input type=button class="btn bg-orange margin" value="Capture" onClick="take_snapshot()">
                    <div id="results"></div>
                    <input type=button value="Save image" id="profileimagesave" class="btn bg-orange margin" onClick="saveSnap()" style="display: none;">
                  </div>
                </div>
            </article>
            <article class="content-entry">
              <h4 class="article-title"><i></i>ID Proof</h4>
              <div class="accordion-content">
                <br/>
                <div class="well well-lg">
                  <div class="field" align="left">
                    <!-- <form action="{{url('IDupload')}}" method="post" enctype="multipart/form-data">  -->
                    <h3>ID Proofs </h3>
                    <h5>(can attach more than one):</h5>
                    <input type="hidden" id="oldfiles" name="oldfiles" value="{{$img}}" />
                    <input type="hidden" id="allfiles" name="allfiles" value="{{$img}}" />
                    <input type="file" id="files" name="attachments[]" accept="image/png, image/jpeg, image/jpg" multiple />
                    <br>
                    <ul id="fn"></ul> <i id="file"></i>
                  </div>
                  <br>
                </div>
              </div>
              <input type="hidden" name="oldidproof" value="" id="olddocs">
              <input type="submit" name="IDupload" class="btn bg-orange" value="Update" onclick="return chekform()">
              </form>
            </article>
            </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="packagedetails" style="overflow: auto">
              <!-- The timeline -->
              <!-- timeline time label -->
              <!--  -->
              <div class="table-wrapper">
                <div class="table-title">
                  <div class="box">
                    <div class="box-header">
                      <!-- <a href="{{ url('addterms') }}" class="btn add-new bg-navy"><i class="fa fa-plus"></i>Add New</a> -->
                      <h3 class="box-title">All Packages</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body ">
                      <div>
                        <div class="col-sm-12">
                          <table id="paymenthistorytable" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <thead>
                              <tr>
                                <th>Invoice No</th>
                                <th>Scheme Name</th>
                                <th>Current Status</th>
                                <th>JoinDate</th>
                                <th>EndDate</th>
                                <th>Assigned date</th>
                                <th>Remaining Amount</th>
                                 @if(Session::get('role')  == 'admin' || Session::get('role')  == 'Admin')
                                <th>Deactive  Package</th>
                                @endif
                                <!-- <th>Actions</th> -->
                              </tr>
                            </thead>
                            <tbody>@php $key=''; @endphp
								@foreach($packages as $key => $package)
                              @if($package->transferid > 0)
                              @php  $paymentprocess =2;@endphp
                              @else
                              @php  $paymentprocess = App\Payment::where('invoiceno',$package->memberpackagesid)->get()->count();@endphp
                              @endif

                              <tr @if($paymentprocess <= 0) style="color:#abaaaa" @endif>

                                <td id="packagid">{{ $package->memberpackagesid }} </td>
                                <td>{{$package->Scheme->schemename}}</td>
                                <td>@if ($package->status == 1) {{ 'Active'}} @endif @if($package->status == 0) {{'Inactive' }} @endif @if($package->status == 3) {{ 'Tranfered'}} @endif</td>
                                @if($package && (!($paymentprocess <= 0)) )
                                <td id="joindate{{$key}}">

                                  <input type="date" onkeypress="return false"onkeydown="return false" name="" value="{{$package->joindate}}" min="<?php echo date(" Y-m-d ");?>"  {{ Session::get('role')  == 'admin' ?  '': 'disabled'}}>
                                </td>
                                <td id="enddate{{$key}}">
                                  <input type="date"  onkeypress="return false"onkeydown="return false" name="" value="{{$package->expiredate}}"   {{ Session::get('role')  == 'admin' ?  '': 'disabled'}}>
                                  <button type="button" id="otpbtn" data-toggle="modal" data-target="#otpmodel"></button>
                                </td>
                                @else

                                <td>{{date('d-m-Y', strtotime($package->joindate)) }}</td>
                                <td>{{date('d-m-Y', strtotime($package->expiredate)) }}</td>@endif
                                <td>{{date('d-m-Y', strtotime($package->created_at)) }}</td>
                                <td>@if($package->remainingamount > 0) <a class="btn bg-light-navy" href="{{url('remainingplaceorder/'.$package->invoiceno)}}">{{$package->remainingamount}}</a>
                                  @else {{$package->remainingamount}} @endif</td>
                                </td>
                                @if($package->status == 1)
                                @if(Session::get('role')  == 'admin' || Session::get('role')  == 'Admin')
                                  <td> <a href="{{url('changeStatus/'.$package->memberpackagesid )}}"  onclick="return myFunction();"  class="btn bg-light-navy"  > <span class="label label-warning" >Deactive</a></span> </td>
                                  @endif
                                    @endif
						                  	@if($paymentprocess <= 0)  <td>Incomplete</td> @endif
                              </tr>@endforeach</tbody>
                          </table>
                        </div>
                        <!-- /.box-body -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="paymenthistory" style="overflow: auto">
              <div class="box-body">
                <div class="col-sm-12">
                  <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr>
                        <th>Payment Date</th>
                        <th>Mode</th>
                        <th>Actual Amount</th>
                        <th>Paid Amount</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Receipt No</th>
                        <th>Print</th>
                        <!-- <th>Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>@foreach($payment as $key => $payment) @if($payment->mode != 'total')
                      <tr>
                        <td>{{date('d-m-Y', strtotime( $payment->paymentdate)) }}</td>
                        <td>{{ $payment->mode }}</td>
                        <td>{{ $payment->actualamount }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->tax }}</td>
                        <td>{{ $payment->discountamount > 0 ? $payment->discountamount : '0' }}</td>
                        <td>{{ $payment->receiptno}}</td>

                        <td> @if($payment->invoicetype == 'm' || $payment->invoicetype == 'O') <a href="{{url('transactionpaymentreceipt/'.$payment->invoiceno.'/'.$member->mobileno)}}" target="_blank"><i class="fa fa-print"></i></a> @endif
                        <a id="emailafterpack"    onclick="return emailafterpacsdck({{$payment->invoiceno}},{{$member->userid}});" class="red"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                        </td>
                        </td>
                      </tr>@endif @endforeach</tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
            <div class="tab-pane" id="settings" style="overflow: auto">
              <div class="box-body">
                <div class="col-sm-12">
                  <div id="accordion" class="accordion-container">
                    <article class="content-entry">
                      <h4 class="article-title"><i></i>Biometrics</h4>
                      <div class="accordion-content">
                        <br/>
                        <div class="well well-lg">
                          <!-- @if(!$deviceuser)
                    <a href="#" class="btn bg-orange" id="setuser" data-toggle="modal" data-target="#modal-default">set user</a>
                @elseif($deviceuser->status == 0)
                   <a href="#" class="btn btn-default" id="setuser" data-toggle="modal" data-target="#modal-default1">set user</a>
                @else
                <a href="#" class="btn btn-default" id="setuser" data-toggle="modal" data-target="#modal-default1">set user</a>
                @endif -->
                          <!--  @if($deviceuser)
                  @if($deviceuser->status == 2)
                    <a href="#" class="btn bg-orange" id="enrolluser">Enroll User</a>
                  @endif
                @endif

                @if($deviceuser)
                  @if($deviceuser->status == 3)
                    <a href="#" class="btn bg-orange" id="enrollcard">Enroll card</a>
                  @endif
                @endif -->@if($deviceuser) @if($deviceuser->status == 0) <a href="#" class="btn bg-green" data-toggle="modal" data-target="#activedeviceuser">Active User</a>
                          @endif @endif @if($deviceuser) @if($deviceuser->status == 3)
                          <button class="btn bg-orange" id="userfetchlogs" data-toggle="modal" onclick="fetchlogs('{{$member->mobileno}}')" data-target="#fetchlogs">Fetch Logs</button>
                          <!-- <a href="#" class="btn bg-orange" data-toggle="modal"  data-target="#reassigncardmodel">Reassign Card</a> --> <a class="btn bg-orange" id="deactiveuser">Deactive User</a>
                          @endif @endif
                          <!-- <a href="#" class="btn bg-orange" id="setuser" data-toggle="modal" data-target="#addusermodel">Add user</a> -->
                          <!-- <a href="#" class="btn bg-orange">Access Controller</a>
                 <a href="#" class="btn bg-orange">Fetch Logs</a> -->
                        </div>
                        <div class="modal fade" id="modal-default">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><b>Set User To device</b></h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="form-group">
                                    <div class="col-md-5 col-md-offset-1">
                                      <!-- <label>User id</label> -->
                                      <input type="hidden" id="setuserid" class="form-control" name="deviceuserid" value=" {{$member->memberid}}" disabled="">
                                    </div>
                                    <div class="col-md-5">
                                      <!-- <label>User Reference id</label> -->
                                      <input type="hidden" id="setuserrefid" name="deviceuserreferenceid" class="form-control" value="{{$member->memberid}}" disabled="">
                                      <input type="hidden" id="devicemobileno" name="" class="form-control" value="{{$member->mobileno}}">
                                    </div>
                                  </div>
                                </div>
                                <br/>
                                <div class="row">
                                  <div class="form-group">
                                    <div class="col-md-10 col-md-offset-1">
                                      <label>User Name</label>
                                      <input type="text" class="form-control" name="username" placeholder="Enter User Name" id="setusername" value="{{ucfirst($member->firstname)}}{{ucfirst($member->lastname)}}" disabled>
                                    </div>
                                  </div>
                                </div>
                                <br/>
                                <!--  <div class="row">
                                  <div class="form-group">
                                     <div class="col-md-10 col-md-offset-1">
                                      <label>User Pin</label>
                                      <input type="text" id="setuserpin" class="form-control number" name="pin" placeholder="Enter User Pin" maxlength="4">
                                    </div>
                                  </div>
                                </div>
                                 -->
                                <div class="row">
                                  <div class="col-md-6 col-md-offset-1">
                                    <label>Set User Expiry</label>
                                  </div>
                                </div>
                                <div class="row">@if($lastpackage != null) @php $lastpackage = $lastpackage; @endphp @else @php $lastpackage = date('Y-m-d'); @endphp @endif
                                  <div class="form-group col-md-6 col-md-offset-1">
                                    <input type="date" onkeypress="return false" value="{{$lastpackage}}" id="setuserexpiry" class="form-control" name="sdate" required="" min="<?php echo date('Y-m-d') ?>">
                                  </div>
                                </div>
                                <!-- <div class="form-group">
                                <div class="row">

                                     <div class="col-md-3 col-md-offset-1">
                                      <label>Status</label>
                                    </div>
                                    <div class="col-md-3">
                                      <select class="form-control" name="status" id="setuserstatus">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                      </select>
                                    </div>
                                  </div>
                                </div> -->
                                <br/>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button> <a type="submit" id="setusersave" data-dismiss="modal" class="btn  bg-green">Save</a>
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <div class="modal fade" id="modal-default1">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><b>Set User To device</b></h4>
                              </div>
                              <div class="modal-body">
                                <h4>User Already Set In Device !</h4>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="activedeviceuser">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><b>Active User</b></h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-4">
                                    <label>Set User Expiry date</label>
                                  </div>
                                  <div class="col-md-8">
                                    <input type="text" name="activationdate" class="form-control" id="activationdate" value="<?php echo date('d-m-Y', strtotime($lastpackage))?>" disabled>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button> <a class="btn bg-green" id="activeuser">Active</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="modal-default2">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><b>Enroll User To device</b></h4>
                              </div>
                              <div class="modal-body">
                                <h4>User Already Enroll In Device !</h4>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="fetchlogs">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close close1" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><b>Users PunchIn/PunchOut Time</b></h4>
                              </div>
                              <div class="modal-body">
                                <div class="table-wrapper">
                                  <div class="table-title">
                                    <div class="box">
                                      <div class="box-body">
                                        <div class="col-lg-12">
                                          <div class="row">
                                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                              <thead>
                                                <tr>
                                                  <th>date</th>
                                                  <th>Check IN Time</th>
                                                  <th>Check Out Time</th>
                                                </tr>
                                              </thead>
                                              <tbody id="tbody">
                                                <tr>
                                                  <td id="t1"></td>
                                                  <td></td>
                                                  <td></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger close1" data-dismiss="modal">Close</button>
                                <!-- <a type="submit" id="setusersave" data-dismiss="modal"  class="btn  bg-green">Save</a> -->
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <div class="modal fade" id="reassigncardmodel">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close close1" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><b>Reassign Card</b></h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-4 col-md-offset-1"> <a href="#" class="btn btn-default" id="reassigncard" style="padding: 50px;">Deactive Old Card</a>
                                  </div>
                                  <div class="col-md-4 col-md-offset-1"> <a href="#" class="btn btn-default" id="enrollnewcard" style="padding: 50px;">Enroll New Card</a>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger close1" data-dismiss="modal">Close</button> <a type="submit" id="setusersave" data-dismiss="modal" class="btn  bg-green">Save</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="addusermodel">
                          <div class="modal-dialog" style="width: 1002px;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><b><!-- Set User To device --></b></h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <!-- <img src="{{asset('/images/8.png')}}" class="cloud" id="a" height="300">
                                          <img src="{{asset('/images/2.png')}}" id="martix" height="300">
                                          <div class="circle">
                                            <span class="circle__el"></span>
                                          </div>
                                          <div class="circle">
                                            <span class="circle__el circle__el_two"></span>
                                          </div>
                                          <div class="circle">
                                            <span class="circle__el circle__el_three"></span>
                                          </div>    -->
                                  </div>
                                  <div class="col-md-6">
                                    <ul id="progressbar">
                                      <li class="active"><b>Personal Details</b>
                                      </li>
                                      <li><b>Tell us something more about you</b>
                                      </li>
                                      <li><b>Package And Inquiry Details</b>
                                      </li>
                                      <li><b>Create Inquiry</b>
                                      </li>
                                    </ul>
                                    <fieldset>
                                      <h2 class="fs-title">Personal Details</h2>
                                      <h3 class="fs-subtitle">Tell us something about you</h3>
                                      <input type="text" name="firstname" placeholder="First Name" onchange="valid()" required id="firstname" class="noonumber" />
                                      <input type="text" name="lastname" placeholder="Last Name" required id="lastname" class="noonumber" />
                                      <ul class="donate-now">
                                        <li>
                                          <!-- <input type="text"> --> <span id="title"><b>Select Gender</b></span>
                                        </li>
                                        <li>
                                          <input type="radio" id="a25" name="gender" value="male" onchange="valid()" />
                                          <label for="a25">Male</label>
                                        </li>
                                        <li>
                                          <input type="radio" id="a50" name="gender" value="female" onchange="valid()" />
                                          <label for="a50">Female</label>
                                        </li>
                                      </ul>
                                      <!-- <input type="radio" name="gender" value="male" checked>Male
                  <input type="radio" name="gender" value="female">Female -->
                                      <input type="email" name="email" id="email" placeholder="Enter your Email" id="email" onchange="valid()">
                                      <input type="text" name="phoneno" id="mobileno" placeholder="Phone No" maxlength="10" class="number" required="" onkeyup="valid()" id="mobileno" />
                                      <input type="button" name="next" class="next action-button" value="Next" id="next1" />
                                    </fieldset>
                                    <fieldset>
                                      <h2 class="fs-title">Tell us something more about you</h2>
                                      <h3 class="fs-subtitle">Tell us something more about you</h3>
                                      <input type="text" name="profession" placeholder="Profession" id="profession" />
                                      <label>Already Member in other GYM ?</label>
                                      <select name="menberinothergym" onchange="memberinothergym();" id="mg">
                                        <option value="Yes" id="yes">Yes</option>
                                        <option value="No" id="no" selected="">No</option>
                                      </select>
                                      <br/>
                                      <br/>
                                      <textarea type="text" name="note" placeholder="Please Give Details About GYM !" id="am"></textarea>
                                      <!--   <input type="text" name="menberinothergym" placeholder="Already Member in ohther GYM ?"/> -->
                                      <label>How Did You Here about us ?</label>
                                      <select name="hereaboutus" id="country" required="">
                                        <option value="null" disabled="">-- How Did You Here about us ? --</option>
                                        <option value="Fitness Five Member">Fitness Five Member</option>
                                        <option value="We Called Them">We Called Them</option>
                                        <option value="Friends/Family">Friends / Family</option>
                                        <option value="Internet Search Engine">Internet Search Engine</option>
                                        <option value="Word of Mouth">Word of Mouth</option>
                                        <option value="Radio Advertise">Radio Advertise</option>
                                        <option value="Magazine Advertise">Magazine Advertise</option>
                                        <option value="other" selected="">Other</option>
                                      </select>
                                      <label>Reference By :</label>
                                      <select name="reference">
                                        <option value="null">-- Reference By --</option>
                                        <option value="advertise">advertise</option>
                                        <option value="club_member">club Member</option>
                                        <option value="other">other</option>
                                      </select>
                                      <br/>
                                      <br/>
                                      <textarea type="text" name="remark" placeholder="Remark"></textarea>
                                      <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                      <input type="button" name="next" class="next action-button" value="Next" id="next2" />
                                    </fieldset>
                                    <!-- ------------------- before change ------------------ -->
                                    <div class="row">
                                      <div class="col-md-6 col-md-offset-1">
                                        <label>Set User</label>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="form-group">
                                        <div class="col-md-5 col-md-offset-1">
                                          <!-- <label>User id</label> -->
                                          <input type="hidden" id="setuserid" class="form-control" name="deviceuserid" value="{{$member->memberid}}" disabled="">
                                        </div>
                                        <div class="col-md-5">
                                          <!-- <label>User Reference id</label> -->
                                          <input type="hidden" id="setuserrefid" name="deviceuserreferenceid" class="form-control" value="{{$member->memberid}}" disabled="">
                                        </div>
                                      </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                      <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                          <label>User Name</label>
                                          <input type="text" class="form-control" name="username" placeholder="Enter User Name" id="setusername1" value="{{ucfirst($member->firstname)}}{{ucfirst($member->lastname)}}">
                                        </div>
                                      </div>
                                    </div>
                                    <br/>
                                    <!--  <div class="row">
                                  <div class="form-group">
                                     <div class="col-md-10 col-md-offset-1">
                                      <label>User Pin</label>
                                      <input type="text" id="setuserpin" class="form-control number" name="pin" placeholder="Enter User Pin" maxlength="4">
                                    </div>
                                  </div>
                                </div>
                                 -->
                                    <div class="row">
                                      <div class="col-md-6 col-md-offset-1">
                                        <label>Set User Expiry</label>
                                      </div>
                                    </div>
                                    <div class="row">@if($lastpackage != null) @php $last_date = $lastpackage; @endphp @else @php $last_date = date('Y-m-d'); @endphp @endif
                                      <div class="form-group col-md-6 col-md-offset-1">
                                        <input type="date" onkeypress="return false" value="{{$last_date}}" id="setuserexpiry" class="form-control" name="sdate">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="row">
                                        <div class="col-md-3 col-md-offset-1">
                                          <label>Status</label>
                                        </div>
                                        <div class="col-md-3">
                                          <select class="form-control" name="status" id="setuserstatus">
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <br/>
                                    <div class="modal-footer">
                                      <button type="button" class="btn  btn-info center-block" data-dismiss="modal">Next</button>
                                      <!-- <a type="submit" id="setusersave" data-dismiss="modal"  class="btn  bg-green left">Save</a> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </article>
                    <article class="content-entry">
                      <form action="{{ url('Printconsentform')}}" method="post"  target="_blank">
                        @csrf
                        <h4 class="article-title"><i></i>Consent Form</h4>
                        <div class="accordion-content">
                          <br/>
                          <div class="well well-lg">
                            <div class="tab-pane" id="Consent">
                              <!-- The timeline -->
                              <!-- timeline time label -->
                              <!--  -->
                              <div class="table-wrapper">
                                <div class="table-title">
                                  <div class="box-header">

                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body" style="font-family: Calibri; display: none">
                                    <div class="wrap-contact100">
                                      <!-- style="background-image: url(/images/FITNESSFIVE-logo.jpg);" --> <span class="contact100-form-title-1">
                                    <img src="{{ asset('/images/fitness5.png')}}" width="100" height="100">
                                  </span>
                                                                <span class="contact100-form-title-2">
                                    <h3>Consent Form</h3>
                                  </span>
                                    </div>
                                    <form class="contact100-form validate-form" action="{{ url('Printconsentform')}}" method="post"  target="_blank" >
                                      <div class="wrap-input100 validate-input" data-validate="Name is required"> <span class="label-input100">Date</span>
                                        <input class="input100 form-control" type="date" onkeypress="return false" name="date" placeholder="Enter full name" value="{{Carbon\Carbon::today()->format('Y-m-d')}}"> <span class="focus-input100"></span>
                                      </div>
                                      <div class="wrap-input100 validate-input" data-validate="Name is required"> <span class="label-input100">Full Name :</span>
                                        <input class="input100" type="text" name="firstname" placeholder="Enter full name" value="{{$member->firstname}}">
                                        <input type="hidden" name="lastname" value="{{$member->lastname}}"> <span class="focus-input100"></span>
                                      </div>
                                      <div class="wrap-input100 validate-input" data-validate="Name is required"> <span class="label-input100">Member ID :</span>
                                        <input class="input100" type="text" name="memberid" placeholder="MemberID" value="{{$member->mid}}" id="memberidforworkout"> <span class="focus-input100"></span>
                                      </div>
                                      <div class="wrap-input100 validate-input" data-validate="Message is required"> <span class="label-input100">Address :</span>
                                        <textarea class="input100" name="Address" placeholder="Your Address">{{$member->address}}</textarea> <span class="focus-input100"></span>
                                      </div>
                                      <div class="wrap-input100 validate-input" data-validate="Phone is required"> <span class="label-input100">Phone No:</span>
                                        <input class="input100" type="text" name="phone" value="{{$member->mobileno}}" placeholder="Enter phone number" readonly=""> <span class="focus-input100"></span>
                                      </div>
                                      <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz"> <span class="label-input100">Email:</span>
                                        <input class="input100" type="text" name="email" value="{{$member->email}}" placeholder="Enter email addess"> <span class="focus-input100"></span>
                                      </div>
                                      <div class="wrap-input100 validate-input" data-validate="Phone is required"> <span class="label-input100">Emergency Contact No:</span>
                                        <input class="input100" type="text" name="emergancyphoneno" value="{{$member->emergancyphonenumber}}" placeholder="Enter phone number"> <span class="focus-input100"></span>
                                      </div>
                                      <div>
                                        <p style="font-family: Calibri; size: 3px;">In consideration of my desire to engage in an exercise programme at the FITNESSFIVE.I understand and agree to following :</p> <span class="focus-input100"></span>
                                      </div>
                                      <br/>
                                      <div>
                                        <ol>
                                          <li>Participation by me in this activity is entirely voluntaty</li>
                                          <br/>
                                          <li>Before i Engage in any activity i have informed all my medical history to the team member of FITNESSFIVE and have complated health history form as well as an evaluation with physical therapist to determine my risk of participating exercise.i m sumbmitting all helth report to FITNESSFIVE.</li>
                                          <br/>
                                          <li>If the health history,physical activity evaluation indicate that i should see my physical before exercising,i will do that.</li>
                                          <br/>
                                          <li>I understand that the possibility exists that certain changes may occur during exercise,they may include musclar strain,sprain and delayed onset muscle soreness abnormal B.P,fainting,disturbance of heart rhythm and very rare instances of heart attack.</li>
                                          <br/>
                                          <li>I understand that i can minimize the risk of adverse changes occurring during exercise by adhering to exercise guideline which include warm up and cool down.</li>
                                        </ol> <span class="focus-input100"></span>
                                      </div>
                                      <div>
                                        <p>This agressment is binding on my assigns.</p> <span class="focus-input100"></span>
                                      </div>
                                      <br/>
                                      <br/>
                                      <br/>
                                      <div class="row">
                                        <div class="col-sm-4">SIGNATURE
                                          <br/>(MEMBER)</div>
                                        <div class="col-sm-4">SIGNATURE
                                          <br/>(WITNESS)</div>
                                        <div class="col-sm-4">TEAM FITNESSFIVE</div>
                                      </div>
                                      <br>
                                      <div class="col-sm-9" style="margin-top: 15px; float: right; margin-left: 120px;"></div>
                                  </div>
                                </div>
                                <br>Download Consent Form &nbsp;
                                <button type="submit" class="btn bg-orange fa fa-download" value="print"><font style="font-family: fantasy;"></font> Download</button>
                                <br>
                                </form>
                              </div>
                            </div>
                          </div>
                          <!-- /.tab-pane -->
                        </div>
                    </article>
                    <article class="content-entry">
                      <h4 class="article-title"><i></i>ManagePin</h4>
                      <div class="accordion-content">
                        <br/>
                        <div class="well well-lg">
                          <!-- <h4 class="article-title"><i></i>Manage Member Pin</h4> -->
                          <div class="row">
                            <!--   <div class="col-md-3">
                         <a href="#" class="btn bg-orange btn-block" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-send">Send</a>
                      </div> -->
                            <div class="col-md-3"> <a href="#" class="btn bg-orange btn-block" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-change">New</a>
                            </div>
                            <div class="col-md-3"> <a href="#" class="btn bg-orange btn-block" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-new">Edit</a>
                            </div>
                          </div>
                          <!-- /.modal-dialog -->
                          <!-- </form> -->
                          <div class="modal fade" id="modal-new">
                            <div class="modal-dialog">
                              <form action="{{url('pinchange/'.$member->memberid)}}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Edit Member Pin</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group ">
                                      <div class="col-md-10">
                                        <?php $p=str_split($member->memberpin); $c = ($p>0) ? count($p) : 0 ; ?>
                                        <div class="row">
                                          <div class="col-md-2">
                                            <input type="text" class="number form-control" required maxlength="1" name="cn1" value="{{ !empty($p[0]) ? $p[0] : '0'}}">
                                          </div>
                                          <div class="col-md-2">
                                            <input type="text" class="number form-control" required maxlength="1" name="cn2" value="{{!empty($p[1]) ? $p[1] : '0'}}">
                                          </div>
                                          <div class="col-md-2 ">
                                            <input type="text" class="number form-control" required maxlength="1" name="cn3" value="{{ !empty($p[2]) ? $p[2] : '0'}}">
                                          </div>
                                          <div class="col-md-2 ">
                                            <input type="text" class="number form-control" required maxlength="1" name="cn4" value="{{ !empty($p[3]) ? $p[3] : '0'}}">
                                          </div>
                                          <div class="col-md-2 ">
                                            <button type="submit" class="btn bg-orange">Edit</button>
                                          </div>
                                        </div>
                                      </div>
                                      <br/>
                                    </div>
                                    <div class="modal-footer">
                                      <!-- <button type="button" class="btn bg-orange" id="savenotes">Save</button>
                                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                              </form>
                            </div>
                          </div>
                          <div class="modal fade" id="modal-change">
                            <div class="modal-dialog">
                              <form action="{{url('pinchange/'.$member->memberid)}}" method="post">{{ csrf_field() }}
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Change Member Pin</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group ">
                                      <div class="col-md-10">
                                        <div class="row">
                                          <div class="col-md-2">
                                            <input type="text" class="number form-control" maxlength="1" name="cn1" required>
                                          </div>
                                          <div class="col-md-2">
                                            <input type="text" class="number form-control" maxlength="1" name="cn2" required>
                                          </div>
                                          <div class="col-md-2 ">
                                            <input type="text" class="number form-control" maxlength="1" name="cn3" required>
                                          </div>
                                          <div class="col-md-2 ">
                                            <input type="text" class="number form-control" maxlength="1" name="cn4">
                                          </div>
                                          <div class="col-md-2">
                                            <button type="submit" class="btn bg-orange">Send</button>
                                          </div>
                                        </div>
                                      </div>
                                      <br/>
                                    </div>
                                    <div class="modal-footer">
                                      <!-- <button type="button" class="btn bg-orange" id="savenotes">Save</button>
                                       <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </article>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
            <div class="active  tab-pane" id="timeline">

              <div class="content">
                <ul class="timeline timeline-inverse">@foreach($notify as $notify)
                  <li class="time-label"> <span class="bg-lightorange">
                         {{ Carbon\Carbon::parse($notify->created_at)->format('d-m-Y')}}
                        </span>
                  </li>
                  <li> <i class="fa fa-clock-o bg-orange"></i>
                    <div class="timeline-item">
                      <div class="timeline-header" style="color: #fff !important;">{{$notify->details}}</div>
                    </div>
                  </li>@endforeach</ul>
              </div>
            </div>
            <div class="tab-pane" id="workout">
              <div class="content">
                <div id="accordion" class="accordion-container">
                  <article class="content-entry">
                    <h4 class="article-title"><i></i>Workout</h4>
                    <div class="accordion-content">
                      <br>
                      <div class="well well-lg">
                        <div id="buttons"> <a href="{{ url('assignExercise/'.$member->mid) }}" class="btn bg-orange" id="assignexercise">Assign</a>
                          <a class="btn bg-orange" id="viewexercise">View</a>
                          <a class="btn bg-orange" id="todaysexercise">Today's Workout</a>
                          <br>
                          <br>Download ExercisePDF &nbsp; <a href="{{url('exercisepdf/'.$member->mid)}}" class="btn bg-orange fa fa-download" value="print"><font style="font-family: fantasy;"></font>   ExercisePDF</a>
                        </div>
                        <div class="box-body">
                          <div id="pages">
                            <div class="box" id="viewexercise" style="display: none">
                              <br>
                              <table id="tableworkout" class="table  table-striped table-wrapper" style="border-width: 1px; margin-left: 8px;margin-bottom: 8px;" width="70%">
                                <thead>
                                  <th>Workout</th>
                                  <th>Action</th>
                                </thead>
                                <tbody>
                                  <tr class="txt" style="display: none;"></tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="box" id="todaysexercise" style="display: none;overflow: auto;">
                              <br>
                              <table class="table  table-bordered table-striped table-wrapper" style="padding: 300px; " cellpadding="2px" cellspacing="3px;">@if($todayexercise)
                                <thead>
                                    <th>Header</th>
                                  <th>Workout</th>
                                  <th>Day</th>
                                  <th>Time</th>
                                  <th>Set</th>
                                  <th>Rep</th>
                                  <th>Instruction</th>
                                </thead>
                                <tbody>@if(date('N')==0) @php $t=7; @endphp @else @php $t=date('N'); @endphp @endif @foreach($todayexercise as $te) @if($t == $te->exerciseday)
                                  <tr>
                                    <td colspan="6">Name: {{$te->Workout->workoutname}}</td>
                                  </tr>
                                  <tr>
                                    <td>{{$te->header}}</td>
                                    <td>{{$te->Exercise->exercisename}}</td>
                                    <td>{{ date('l')}}</td>
                                    <td>{{$te->memberexercisetime}}</td>
                                    <td>{{$te->memberexerciseset}}</td>
                                    <td>{{$te->memberexerciserep}}</td>
                                    <td>{{$te->memberexerciseins}}</td>
                                  </tr>@else @endif @endforeach @else {{'No any Workout'}} @endif</tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                  </article>
                  <article class="content-entry">
                    <h4 class="article-title"><i></i>Measurement</h4>
                    <div class="accordion-content">
                      <br>
                      <div class="well well-lg"> <a href="{{url('addMeasurement/'.$member->mid)}}" class="btn bg-orange" id="addmeasurement">Add</a>
                        <a class="btn bg-orange" id="viewmeasurement">View</a>
                        <!-- <h4 class="article-title"><i></i>Manage Member Pin</h4> -->
                        <div class="viewmeasurement" style="overflow: auto;display: none">
                          <br>
                          <table class="table  table-bordered table-striped table-wrapper" style="padding: 300px; " cellpadding="2px" cellspacing="3px;">
                            <thead>
                              <th>Takendate</th>
                              <th>Height</th>
                              <th>Weight</th>
                              <th>neck</th>
                              <th>left Arm</th>
                              <th>rigt Arm</th>
                              <th>chest</th>
                              <th>waist</th>
                              <th>hips</th>
                              <th>lefthigh</th>
                              <th>righthigh</th>
                              <th>leftcalf</th>
                              <th>rightcalf</th>
                            </thead>
                            <tbody>@foreach($measurement as $te)
                              <tr>
                                <td>{{ date('j F, Y', strtotime($te->todaydate)) }}</td>
                                <td>{{$te->height}}</td>
                                <td>{{$te->weight}}</td>
                                <td>{{$te->neck}}</td>
                                <td>{{$te->leftupperarm}}</td>
                                <td>{{$te->rightupperarm}}</td>
                                <td>{{$te->chest}}</td>
                                <td>{{$te->waist}}</td>
                                <td>{{$te->hips}}</td>
                                <td>{{$te->leftthigh}}</td>
                                <td>{{$te->rightthigh}}</td>
                                <td>{{$te->leftcalf}}</td>
                                <td>{{$te->rightcalf}}</td>
                              </tr>@endforeach</tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </article>
                  <article class="content-entry">
                    <h4 class="article-title"><i></i>DietPlan</h4>
                    <div class="accordion-content">
                      <br>
                      <div class="well well-lg">
                        <div id="buttons2"> <a href="{{url('assigndiettomember/'.$member->mid)}}" class="btn bg-orange" id="adddietplan">Add</a>
                          <a class="btn bg-orange" id="viewdietplan">View</a>
                          <a class="btn bg-orange" id="todaydietplan">Today's DietPlan</a>
                          <br>
                          <br>
                          <br>Download DietPDF &nbsp; <a href="{{url('dietpdf/'.$member->mid)}}" class="btn bg-orange fa fa-download" value="print"><font style="font-family: fantasy;"></font>   Dietplanpdf</a>
                        </div>
                        <div class="box-body">
                          <div id="pages2">
                            <div class="box" id="viewdietplan" style="display: none">
                              <table id="tabledietplan" class="table  table-striped table-wrapper" style="border-width: 1px; margin-left: 8px;margin-bottom: 8px;" width="70%">
                                <thead>
                                  <th>Diet Plan</th>
                                  <th>Action</th>
                                </thead>
                                <tbody>
                                  <tr class="txtdiet" style="display: none;"></tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="box" id="todaydietplan" style="display: none">
                              <table class="table  table-bordered table-striped table-wrapper" style="padding: 300px; " cellpadding="2px" cellspacing="3px;">@if($todaydietplan)
                                <thead>
                                  <th>Diet Plan</th>
                                  <th>Day</th>
                                  <th>Time</th>
                                  <th>Meal</th>
                                  <th>Compulsary</th>
                                  <th>Remark</th>
                                </thead>
                                <tbody>@if(date('N')==0) @php $t=7; @endphp @else @php $t=date('N'); @endphp @endif @foreach($todaydietplan as $te) @if($t == $te->dietday)
                                  <tr>
                                    <td>{{$te->DietPlanname->dietplanname}}</td>
                                    <td>{{ date('l')}}</td>
                                    <td>{{$te->diettime}}</td>
                                    <td>{{$te->mealname}}
                                      <td>{{$te->compulsary == 1 ? 'Yes': 'No'}}</td>
                                      <td>{{$te->remark}}</td>
                                  </tr>@else @endif @endforeach @else {{'No any Diet Plan'}} @endif</tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                  </div>
                  </div>
                </div>
                <!---conset form-->
                <div class="tab-pane" id="notes1">
                  <div class="box-body">
                    <div class="col-sm-12"></div>
                  </div>
                </div>
                <div class="modal fade out" id="dietmodal" role="dialog">
                  <div class="modal-dialog  modal-dialog-scrollable">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
                        <h4 class="modal-title">DietPlan Details</h4>
                      </div>
                      <div class="modal-body modal-content" style="overflow: auto!important;">
                        <p id="text"></p>
                        <table id="diethistory" class="table table-bordered" style="overflow: auto;">
                          <!-- <caption >Diet Plan On:<input type="text" name="" id="dietdate1"></caption> -->
                          <tbody>
                            <tr class="txtdietdetail">
                              <td></td>
                              <th scope="col">Diet Plan Name</th>
                              <th scope="col">Diet time</th>
                              <th scope="col">Compulsary</th>
                              <th scope="col">Remark</th>
                              <th scope="col">Status</th>
                              <!-- <th scope="col">Assigned On</th> -->
                            </tr>
                            <tr class="txtdietdetail"></tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!--  <div class="modal fade" id="workoutmodal" role="dialog">
              <div class="modal-dialog  modal-dialog-scrollable"> -->
                <div class="modal fade" id="workoutmodal">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
                        <h4 class="modal-title">Workout Details</h4>
                      </div>
                      <div class="modal-body modal-content" style="overflow: auto;">
                        <p id="text"></p>
                        <table id="exercisehistory" class="table table-bordered">
                          <thead>
                            <th>Day</th>
                            <th>Header</th>
                            <th>Workoutname</th>
                            <th>Workout time</th>
                            <th>workout set</th>
                            <th>workout rep</th>
                            <th>workout ins</th>
                            <th>Status</th>
                          </thead>
                          <tbody>
                            <tr class="workoutmember"></tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-content -->
                <div class="col-lg-10" style="margin-left: -23px">
                  <br>
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">ID Proof Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table class="table table-striped">@if($img) @php $img= json_decode($img); @endphp

                        @foreach($img as $img)
                        <tr>
                          <td><a href="/files/{{$img}}" target="_blank">{{$img}}</a>
                          </td>
                        </tr>@endforeach</table>@else {{ 'No Any Id Proof uploaded' }} @endif</div>
                    <!-- /.box-body -->
                  </div>
                </div>
                <!-- /.nav-tabs-custom -->
                <!-- /.row -->
                <!-- /.content -->
                </section>

    <script>

      /////////////////////////////////////////// OTP start /////////////////////////////////////////////

      $('#send_otp').click(function(){

        let admin_id = $('#admin_id').val();
        $('#otp_error').hide();
        $('#otp_value').val('');

        if(admin_id){
          $('#process').show();
          $('#send_otp').hide();
          $.ajax({
            type : 'POST',
            url : '{{ route('sendotp') }}',
            data : {admin_id:admin_id,_token:'{{ csrf_token() }}'},
            success : function(data){
              if(data == true){
                alert('OTP is send');
                $('#send_otp').hide();
                $('#verify').show();
                $('#process').hide();
              }else{
                $('#send_otp').show();
                $('#send_otp').text('Resend OTP');
                $('#process').hide();
              }
            }
          });
        }else{
          $('#admin_error').show();
        }
      });


     function verify(){
        let otp = $('#otp_value').val();

        let changedatetype = $('#changedatetype').val();
        if(otp){
          $('#otp_error').hide();
          $('#otp_required').hide();
          $.ajax({
            type : 'POST',
            url : '{{ route('verifyotpforpackage') }}',
            data : {admin_id:'',otp:otp, _token:'{{ csrf_token() }}'},
            success : function(data){
              if(data == 'true'){
                  // alert('right')
                  var id = "<?php echo $member->userid;?>";
                  var devicemobileno = "<?php echo $member->mobileno;?>";
                  // alert(newdate);
                  newdate = $('#exdate').val();
                  extendreason = $('#extendreason').val();
                  packageid = $('#pkgid').val();
                  var _token = $('input[name="_token"]').val();

                  if(changedatetype=='enddate') {
                    $.ajax({
                      url: "{{ route('changeenddate') }}",
                      method: "POST",
                      data: {
                        id: id,
                        packageid: packageid,
                        newdate: newdate,
                        extendreason: extendreason,
                        _token: _token
                      },
                      success: function (result) {
                        $.ajax({
                          url: "{{ url('setvaliditytodevice') }}",
                          method: "POST",
                          data: {
                            id: id,
                            devicemobileno: devicemobileno,
                            _token: _token
                          },
                          success: function (data) {
                            location.reload();
                          },
                        });
                      },
                      // dataType:"json"
                    })
                  }
                  else{
                    // for changes joindate
                    $.ajax({
                      url: "{{ route('changedate') }}",
                      method: "POST",
                      data: {
                        id: id,
                        packageid: packageid,
                        newdate: newdate,
                        extendreason: extendreason,
                        _token: _token
                      },
                      success: function (result) {
                        var dt = result;
                        dt = dt.replace(/\"/g, "");
                        $.ajax({
                          url: "{{ url('setvaliditytodevice') }}",
                          method: "POST",
                          data: {
                            id: id,
                            devicemobileno: devicemobileno,
                            _token: _token
                          },
                          success: function (data) {
                            location.reload();
                          },
                        });
                        // alert(result);
                        // alert('succesfully changedate');
                      },
                    })
                  }
              }else{
                alert('otp Wrong!');
              }
            }
          });

          {{--$.ajax({--}}
          {{--  type : 'POST',--}}
          {{--  url : '{{ route('verifyotpforpackage') }}',--}}
          {{--  data : {admin_id:admin_id,otp:otp, _token:'{{ csrf_token() }}'},--}}
          {{--  success : function(data){--}}
          {{--    if(data == 'true'){--}}
          {{--      $('#otp_error').hide();--}}
          {{--    }else{--}}
          {{--      $('#otp_error').show();--}}
          {{--      $('#verify').hide();--}}
          {{--      $('#send_otp').show();--}}
          {{--      $('#send_otp').text('Resend OTP');--}}
          {{--    }--}}
          {{--  }--}}
          // });



        }else{
          $('#otp_required').show();
        }
      };

      $('#admin_id').change(function(){
        $('#admin_error').hide();

      });
    </script>
    <div class="modal fade" id="otpmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">OTP for Extend</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="changedatetype" id="changedatetype" >
            <input type="hidden" name="exdate" id="exdate" >
            <input type="hidden" name="pkgid" id="pkgid" >
{{--            <div class="row">--}}
{{--              <div class="form-group col-md-6">--}}
{{--                <label>Select Admin<span style="color: red;">*</span></label>--}}
{{--                <select name="admin" class="form-control" id="admin_id">--}}
{{--                  <option value="">Select</option>--}}
{{--                  @if(!empty($admin))--}}
{{--                    @foreach($admin as $admin_data)--}}
{{--                      <option value="{{ $admin_data->employeeid}}">{{ ucfirst($admin_data->first_name) }} {{ ucfirst($admin_data->last_name) }} ({{ $admin_data->mobileno }})</option>--}}
{{--                    @endforeach--}}
{{--                  @endif--}}
{{--                </select>--}}
{{--                <span id="admin_error" style="color: red;display: none;">Please Select admin</span>--}}
{{--              </div>--}}
{{--            </div>--}}

            <div class="row">
              <div class="form-group col-md-12" id="otp_box">
                <label>Password<span style="color:red;">*</span></label>
                <input type="password" name="otp_extend" id="otp_value" class="form-control" >
                <span id="otp_error" style="color: red;display: none;">Password is incorrect</span>
                <span id="otp_required" style="color: red;display: none;">Please enter Password</span>
              </div>

              <div class="form-group col-md-12" id="otp_box">
                <label>Reason<span style="color:red;">*</span></label>
                <textarea name="extendreason" id="extendreason" class="form-control"></textarea>
{{--                <input type="text" name="extendreason" id="extendreason" class="form-control">--}}
              </div>
            </div>
          </div>
          <div class="modal-footer">
{{--            <button type="button" id="send_otp" class="btn bg-green">Send OTP</button>--}}
            <button type="button" id="verify" onclick="verify()" class="btn bg-green">Verify OTP</button>
            <a class="btn btn-warning" id="process" style="display: none;" disabled=""><span id="btn_text">Sending...</span></a>
            <a id="closeotpmodal" data-dismiss="modal" class="btn btn-danger">Close</a>
          </div>
        </div>
      </div>
    </div>
               <script>
                $(document).ready(function () {
                  console.log("ready!");
                  var token = $('input[name="_token"]').val();
                  // console.log(_token);
                  var member = $('#memberidforworkout').val();
                  $.ajax({
                    url: "{{ url('workoutload') }}",
                    method: "GET",
                    data: {
                      member: member,
                      _token: token
                    },
                    success: function (data) {
                      // alert(data);
                      if (data) {
                        // $("#tableworkout tbody tr:not(:first)").empty();
                        $.each(data, function (i, item) {
                          var apnd = '<tr class="txt" style="font-size: 17px;"><td>' + item.workout.workoutname + '</td><td><a data-toggle="modal" data-target="#workoutmodal"  id="view' + item.workoutid + '"onclick="view(' + item.workoutid + ',' + item.memberid + ')">view</a></td></tr>';
                          $('.txt:last').after(apnd);
                        });
                      } else {
                        $('#tableworkout').html('No any workout assigned');
                        $('.txt:last').after('No any workout assigned');
                      }
                    },
                    dataType: 'json',
                  });
                  var _token = $('input[name="_token"]').val();
                  var member = $('#memberidforworkout').val();
                  $.ajax({
                    url: "{{ url('dietplanload') }}",
                    method: "GET",
                    data: {
                      member: member,
                      _token: _token
                    },
                    success: function (data) {
                      // alert(data);
                      if (data) {
                        //   $('#tableworkoutdisplay').css('display','block');
                        // $("#tableworkout tbody tr:not(:first)").empty();
                        $.each(data, function (i, item) {
                          // alert(item);
                          var apnd = '<tr class="txtdiet"><td>' + item.diet_planname.dietplanname + '</td><td><a  data-toggle="modal" data-target="#dietmodal" id="view' + item.plannameid + '"onclick="viewdietplan(' + item.plannameid + ',' + item.memberid + ')">view</a></td></tr>';
                          $('.txtdiet:last').after(apnd);
                        });
                      } else {
                        $('.txtdiet:last').after('No any Diet Plan');
                      }
                    },
                    dataType: 'json',
                  });
                });
                var key = "<?php echo $key;?>";
                for (var i = 0; i <= key; i++) {
                  console.log( $('#paymenthistorytable td#enddate' + i));
                  $('#paymenthistorytable td#joindate' + i).on('change', function () {
                    console.log("new value : " + $(this).find('input[type=date]').val());
                    var newdate = $(this).find('input[type=date]').val();
                    var id = "<?php echo $member->userid;?>";
                    var devicemobileno = "<?php echo $member->mobileno;?>";
                    var packageid = $(this).parent().find("td:first-child").text();
                    $('#exdate').val(newdate);
                    $('#pkgid').val(packageid);
                    $('#changedatetype').val('joindate');
                    $('#otpbtn').trigger('click');
                    return false;

                    //****** Extra code but dont remove ****//
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                      url: "{{ route('changedate') }}",
                      method: "POST",
                      data: {
                        id: id,
                        packageid: packageid,
                        newdate: newdate,
                        _token: _token
                      },
                      success: function (result) {
                        var dt = result;
                        dt = dt.replace(/\"/g, "");
                        location.reload();
                        // alert(result);
                        // alert('succesfully changedate');
                      },
                    })
                    $.ajax({
                      url: "{{ url('setvaliditytodevice') }}",
                      method: "POST",
                      data: {
                        id: id,
                        devicemobileno: devicemobileno,
                        _token: _token
                      },
                      success: function (data) {},
                    });
                    //******End  Extra code but dont remove ****//
                  });

  function myFunction() {
      if(!confirm("Are You Sure to Deactive Package ?"))
      event.preventDefault();
  }


                }
                var allenddate= $('[id*="enddate"]').length;
                for (var i = 0; i <= allenddate; i++) {
                $('#paymenthistorytable td#enddate' + i).on('change', function () {
                    var newdate = $(this).find('input[type=date]').val();
                    var id = "<?php echo $member->userid;?>";
                    var devicemobileno = "<?php echo $member->mobileno;?>";
                    // alert(newdate);
                    var packageid = $(this).parent().find("td:first-child").text();
                    $('#exdate').val(newdate);
                    $('#pkgid').val(packageid);
                    $('#changedatetype').val('enddate');
                    $('#otpbtn').trigger('click');
                    return false;

                    //****** Extra code but dont remove ****//
                    // alert(packageid);
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                      url: "{{ route('changeenddate') }}",
                      method: "POST",
                      data: {
                        id: id,
                        packageid: packageid,
                        newdate: newdate,
                        _token: _token
                      },
                      success: function (result) {
                        $.ajax({
                          url: "{{ url('setvaliditytodevice') }}",
                          method: "POST",
                          data: {
                            id: id,
                            devicemobileno: devicemobileno,
                            _token: _token
                          },
                          success: function (data) {

                          },
                        });
                        // location.reload();
                      },
                      // dataType:"json"
                    })
                  //****** End Extra code but dont remove ****//
                  // });

                });
                }
                </script>

                <script src="../../bower_components/jquery/src/ajax/jquery.min.js"></script>
                   <script src="{{asset('/js/memberprofile.js')}}"></script>
 @endsection
