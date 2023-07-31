  @extends('layouts.adminLayout.admin_design')
@section('content')
<!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>

<style type="text/css">
  .rating {
    float:left;
}
.table-bordered {
    border: 1px solid #f4f4f4;
}
.hide {
    display:none; 
}

/* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
   follow these rules. Every browser that supports :checked also supports :not(), so
   it doesn’t make the test unnecessarily selective */
.rating:not(:checked) > input {
    position:absolute;
    top:-9999px;
    clip:rect(0,0,0,0);
}

.rating:not(:checked) > label {
    float:right;
    width:1em;
    padding:0 .1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:200%;
    line-height:1.2;
    color:#ddd;
    text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
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
   
.rating:not(:checked) > label:before {
    content: '★';
}

.rating > input:checked ~ label {
    color: #f70;
    text-shadow:1px 1px #c60, 2px 2px #940, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
    color: gold;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > input:checked + label:hover,
.rating > input:checked + label:hover ~ label,
.rating > input:checked ~ label:hover,
.rating > input:checked ~ label:hover ~ label,
.rating > label:hover ~ input:checked ~ label {
    color: #ea0;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > label:active {
    position:relative;
    top:2px;
    left:2px;
}

/* end of Lea's code */

/*
 * Clearfix from html5 boilerplate
 */

.clearfix:before,
.clearfix:after {
    content: " "; /* 1 */
    display: table; /* 2 */
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
.Add{
  color: #32BE24;
}
.call{
  color: #7758EE;
}
  .btn span.fa-check {              
    opacity: 0;             
}
.btn.active span.fa-check {             
    opacity: 1;             
}
.btn-app{
  width: 130px;
  height: 100px;
  padding: 29px 8px;
}



/* my stuff */
/*#status, button {
    margin: 20px 0;
}*/
</style>
  <div class="content-wrapper">
   @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
     
         <section class="content-header"><h2>All Inquiry</h2></section>
          <!-- general form elements -->
        <br>

          <div class="content">
            <div class="box box-info">
               <div class="box-header with-border">
                    <!-- <h3 class="box-title">Filters</h3> -->
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
               </div>
              <div class="box-body"> 
                <form class="form-inline" method="post" action="{{ url('inquiry') }}">
                  {{ csrf_field() }}
                  <div class="row"> 
                    <div class="form-group col-md-3">
                      <div class="input-group date" id="startdate">
                        <label>Inquiry Date From</label>
                        <input type="date" onkeypress="return false"  class="form-control" name="fdate" placeholder="Inquiry Date"  @isset($query['fdate']) value="{{$query['fdate']}}"@endisset/>
                      </div>
                    </div>

                    <div class="form-group  col-md-3">
                      <div class="input-group date" id="startdate">
                        <label>Inquiry Date To</label>
                        <input type="date" onkeypress="return false" class="form-control" name="tdate" placeholder="Inquiry Date"  @isset($query['tdate']) value="{{$query['tdate']}}"@endisset/>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <div class="input-group date" id="enddate">
                        <label>Follow Up From</label>
                        <input type="date" onkeypress="return false" class="form-control"  name="followupdatefrom" placeholder="To Date"  @isset($query['followupdatefrom']) value="{{$query['followupdatefrom']}}"@endisset/> 
                      </div>
                  </div>
                    <div class="form-group col-md-3">
                      <div class="input-group date" id="enddate">
                        <label>Follow Up To</label>
                        <input type="date" onkeypress="return false" 
                        class="form-control" name="followupdateto"
                        placeholder="To Date" 
                        @isset($query['followupdateto']) 
                        value="{{$query['followupdateto']}}"
                        @endisset /> 
                      </div>
                    </div>
                    </div>
                    <br>
                  <div class="row"> 
                
                    <div class="form-group col-sm-3">
                      <label>User Name</label>
                      <select  name="firstname" class="form-control select2"title="Select Username" data-live-search="true" id="username">
                        <!-- <option value="" selected disabled>Select First Name</option> -->
                        <option value="">Select Username</option>
                        @foreach($users as $user)
                          <option value="{{ $user->inquiriesid }}"@if(isset($query['firstname'])) {{$query['firstname'] == $user->inquiriesid ? 'selected':''}} @endif>{{ $user->firstname }}  {{ $user->lastname }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-sm-3">
                    
                      <label >Mobile No</label>
                      <select data-width="180px" name="mobileno" class="form-control select2" id="mobileno" title="Select Mobileno" data-live-search="true" >
                        <!-- <option value="" selected disabled>Select Mobile No.</option> -->
                        <option value="" >Select Mobileno</option>
                        @foreach($users as $user)
                          <option value="{{ $user->inquiriesid }}" @if(isset($query['mobileno'])) {{$query['mobileno'] == $user->inquiriesid ? 'selected':''}} @endif>{{ $user->mobileno }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-sm-3">
                          <label >How did you here about us?</label>

                          <br>
                                  <select  class="form-control select2" name="hearabout"><option disabled="" selected >Select Option</option>

                            <option value="Fitness Five Member"@if(isset($query['hearabout'])) {{$query['hearabout'] == 'Fitness Five Member' ? 'selected':''}} @endif>Fitness Five Member</option>
                          <option value="We Called Them" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'We Called Them' ? 'selected':''}} @endif>We Called Them</option>
                                <option value="Friends/Family" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Friends/Family' ? 'selected':''}} @endif>Friends/Family</option>
                                  <option value="Via Internet" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Via Internet' ? 'selected':''}} @endif>Via Internet</option>
                                    <option value="Word Of Mouth" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Word Of Mouth' ? 'selected':''}} @endif>Word Of Mouth</option>
                                    <option value="Radio Advertise" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Radio Advertise' ? 'selected':''}} @endif>Radio Advertise</option>
                                    <option value="Magazine Advertise" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Magazine Advertise' ? 'selected':''}} @endif>Magazine Advertise</option>
                                      <option value="Other" @if(isset($query['hearabout'])){{$query['hearabout'] == 'Other' ? 'selected':''}} @endif>Other</option>

                                  </select>
                    </div>
                    
                    <div class="form-group col-sm-3">
                      
                    
                      <label>Inquiry Rate</label>
                    
                      <select class="form-control select2" max-width="30" name="rating">
                      <option disabled="" selected>Select Rate</option>
                      <option value="superhot" @if(isset($query['rating'])) {{$query['rating'] == 'superhot' ? 'selected':''}} @endif>Super Hot</option>
                      <option value="hot" @if(isset($query['rating'])) {{$query['rating'] == 'hot' ? 'selected':''}} @endif>Hot</option>
                        <option value="warm"@if(isset($query['rating'])) {{$query['rating'] == 'warm' ? 'selected':''}} @endif>Warm</option>
                        <option value="cold"@if(isset($query['rating'])) {{$query['rating'] == 'cold' ? 'selected':''}} @endif>Cold</option>
                        <option value="notinterested" @if(isset($query['rating'])) {{$query['rating'] == 'notinterested' ? 'selected':''}} @endif >Not Interested</option>
                      </select>
                    </div>
                  </div>
                   <div class="form-group col-sm-3"style="margin-top:1%;" >
                     <div class="input-group">
                      <label>Keyword</label>
                        <input type="text" name="keyword" class="form-control" value="{{ isset($query['keyword']) ? $query['keyword'] : '' }}"placeholder="Keyword">
                      </div>
                    </div>
                    <div class="form-group "style="margin-top:2.5%;">
                      <button name="submit" type="submit" class="btn bg-primary margin">Search</button><a href="{{ url('inquiry') }}" class="btn bg-red">Clear</a>
                        <button data-toggle="modal" data-target="#exampleModalLong" type="button" class="btn bg-green">Excel</button>
                        <button name="excel" id="excel" type="submit" class="btn bg-green" style="display: none"></button>
                    </div>
                </form>
              </div>
            </div>

  <hr> 
  @if ($message = Session::get('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
    </div>
  @endif
   @if ($ermessage = Session::get('ermessage'))
  @if($ermessage=="Inquiry Already Exists")
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $ermessage }}</strong>
    </div>
  @endif
  @endif
 
<div class="table-wrapper">
  <div class="table-title">

       <div class="box">
    <div class="box-header">
      <?php $permission = unserialize(session()->get('permission')); ?>
      
      @if(isset($permission["'add_inquiry'"]))
      <a href="{{ url('addinquiry') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i> Add New</a>
      @endif
      @if(isset($permission["'view_confirminquiry'"]))
      <a href="{{ url('viewconfirmedinquiry') }}" class="btn add-new bg-orange"><i class="fa fa-eye"></i> Confirmed Inquiry</a>
               <a href="{{ url('viewclosedinquiry') }}" class="btn add-new bg-orange"><i class="fa fa-eye"></i>Closed Inquiry</a>

      @endif
    <!--   <button id="getinquiryexcelreport" type="button" class="btn add-new bg-orange">Get Inquiry Excel</button> --> 
    <h3 class="box-title"></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      
          <table id="example123" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
                        <!-- <th>Created Date</th> -->
                        <th style="display:none;">ID</th>
                        <th>Inquiry Date</th>
                        <th>Name</th>
                        <th>Inquiry Rate</th>
                        <th>Type</th>
                        <th>POC</th>
                        <th>Mobile No</th> 
                        <th>Status</th> 
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                  
                  @if($members)
                  <?php $i=0; ?> 
                 @foreach($members as $member)
                    <tr>
                        <td style="display: none;">{{$member->inquiriesid}}</td>
                        <td><span class='hide'>{{$member->createddate}}</span>{{ date('d-m-Y', strtotime($member->createddate))}}</td>
                        <td> 
                          <span class="pull-left">
                                @if($member->gender == 'male')
                                  <i class="fa fa-male text-info" style="font-size: 18px;"></i>
                                @else
                                  <i class="fa fa-female text-danger" style="font-size: 18px;"></i>
                                @endif
                            </span> &nbsp;  &nbsp; 
                            {{ucwords($member->firstname)}} &nbsp; {{ ucwords($member->lastname )}}
                         </td>
                        <td> {{ $member->rating }} </td>
                        <td> {{ $member->inquirytype }}</td>
                        <td> {{ $member->poc }}</td>
                        <td> {{ $member->mobileno }}</td>
                         <td> {{ $member->status == 3 ? 'Converted' : ($member->status == 2 ? 'Confirmed' : ($member->status == 0 ? 'Closed' : 'Active')) }}</td>
                        <td>
                        
                           @if(isset($permission["'view_inquiry'"]))
                           <a href="{{url('viewfollowupprofile/'.$member->inquiriesid)}}"class="Add" title="View Inquiry Profile" id="viewfollowupprofile{{$i}}"><i class="fa fa-eye"></i></a>
                           @endif
                         
                           <a href="{{ url('viewfollowup/'.$member->inquiriesid) }}"class="call" id="addfollowup{{$i}}" title="Add Followup" onclick="call()"><i class="fa fa-phone"></i></a>
                           <a href="{{ url('followup/'.$member->inquiriesid) }}" class="blue" title="View Followup"><i class="fa fa-arrow-circle-right"></i></a>
                           @if(isset($permission["'edit_inquiry'"]))
                            <a href="{{ url('editinquiry/'.$member->inquiriesid) }}"class="btn-xs edit" id="editinquiry" title="Edit Inquiry"><i class="fa fa-edit"></i></a>
                            @endif
                            @if($member->status != 3 && $member->status != 2 )

                            <a onclick="return myFunction();" href="{{ url('confirminquiry/'.$member->inquiriesid) }}"class="btn-xs check" title="Confirm Inquiry"><i class="fa fa-users"></i></a>  
                            @endif
                            <a type="button" class=""   data-toggle="modal" data-target="#modal-default"  onclick="asd('{{$member->mobileno}}')" title="Notification"><i class="fa fa-bell" aria-hidden="true"></i>
                              <input type="hidden" name="notification"  value="{{$member->mobileno}}" id="notofication" >
                            </a>

                            <script type="text/javascript">

                                function myFunction() {
                                    if(!confirm("Are You Sure to Confirm Inquiry ?"))
                                    event.preventDefault();
                                }

                               $(document).ready(function(){
                                        var mobileno = "{{$member->mobileno}}";
                                        var inquiriesid = "{{$member->inquiriesid}}";
                                        // alert(mobileno);

                                          $.ajax({  
                                 
                                 type:"GET",  
                                data: {"_token": "{{ csrf_token() }}","notificationid": mobileno},
                                url:'{{ URL::route("getnotification") }}', 
                                async:false,  
                                 success:function(data){
                                      
                                      $.each(data,function(i,item){
                                        // alert(item.call);
                                        if (item.call== 0) 
                                        {

                                          $('#addfollowup{{$i}}').attr('href','#');

                                          $('#addfollowup{{$i}}').click(function(){
                                            alert("Please Turn On DND Option !");
                                           });                           
                                        }
                                      });                         
                                 },
                                 dataType:'json',
                                });
                              });
                            </script>

                            <div class="modal fade" id="modal-default">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Notification</h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="box-body">
                                              <p>Select The Notification With convenience via SMS / Email / Call ! </p>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-4">
                                                <input type="checkbox" name="" class="" value="1" id="smscheck">
                                                <a class="btn btn-app" id="smslinkcheck" onclick="smscheck();"> 
                                                <i class="fa fa-comment"></i><br/>SMS
                                              </a>       
                                            </div>
                                              <div class="col-md-4">
                                                <input type="checkbox" name=""  class="" value="1" id="emailcheck">
                                                <a class="btn btn-app" id="emaillinkcheck" onclick="emailcheck();">
                                                <i class="fa fa-envelope"></i><br/>Email
                                              </a>
                                              </div>
                                              <div class="col-md-4">
                                                <input type="checkbox" name="" class="" value="1" id="callcheck">
                                                <a class="btn btn-app" id="calllinkcheck" onclick="callcheck();">
                                                <i class="fa fa-phone"></i><br/>Call
                                              </a>
                                              </div>                                              
                                              </div> 
                                             
                                           
                                          </div>
                                          <div class="modal-footer">
                                           <!--  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
                                     
                                            <button id="notify" class="btn bg-orange" onclick="ss()"
                                            data-dismiss="modal">Save</button>

                                           </div>
                                        </div>
                                        <!-- /.modal-content -->
                                      </div>
                                     
                                      <!-- /.modal-dialog -->
                                      
                                    </div>

                             @if(isset($permission["'delete_inquiry'"]) && $member->status != 0)
                             <a href="{{ url('closeinquiry/'.$member->inquiriesid) }}"class="btn-xs delete" title="Close Inquiry"><i class="fa fa-times"></i></a>
                             @endif

                                     <!-- Button trigger modal -->
                             
                            
                        </td>
                        
                    </tr>
                    <?php $i++; ?>
                @endforeach
               </tbody>
            </table>
              <div class="datarender" style="text-align: center">
                {!! $members->appends($query)->render() !!}    </div>
            @else

              @endif
          </div>
        </div>
 
      
   
    </div>

    </div>
  </div>

</div></div>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Password</h5>
                <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Enter Excel Password</label>
                <input type="password" class="form-control" name="pwd" id="pwd">
                <span id="wrongpwd" style="color:red"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="checkpwd">Submit</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#checkpwd').on('click',function(){
        var password=$('#pwd').val();

        var pwdchecked='false';
        $.ajax({
            url:"{{ url('checkexcelpwd') }}",
            method:"POST",
            data:{excelpassword:password,"_token": "{{ csrf_token() }}"},
            success: function (response) {
                var res=response;
                if(res == true){
                    console.log('pwdcheck  :'+res);
                    pwdchecked='true';
                    $('#pwd').removeClass('error');
                    $('#excel').trigger('click');
                    $('#closemodal').trigger('click');
                }else{
                    $('#wrongpwd').html('wrong password');
                    $('#pwd').addClass('error');
                }
            },
            dataType:"json"
        });
    });
</script>
<script type="text/javascript">

    $('.select2').select2()
    function asd(mid) {

        $('#smscheck').hide();
        $('#emailcheck').hide();
        $('#callcheck').hide();

        $('#notofication').val(mid);

        var notificationid = $('#notofication').val();

        $.ajax({

            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
                "notificationid": notificationid
            },
            url: '{{ URL::route("getnotification") }}',
            async: false,
            success: function(data) {
                // alert(data); 
                $.each(data, function(i, item) {
                    // alert(item.sms);
                    if (item.sms == 1) {
                        $('#smscheck').attr('checked', true);
                        $("#smslinkcheck").css("background-color", "#E8C534");
                        $("#smslinkcheck").css("color", "#ffffff");
                    }
                    if (item.email == 1) {
                        $('#emailcheck').attr('checked', true);
                        $("#emaillinkcheck").css("background-color", "#E8C534");
                        $("#emaillinkcheck").css("color", "#ffffff");
                    }
                    if (item.call == 1) {
                        $('#callcheck').attr('checked', true);
                        $("#calllinkcheck").css("background-color", "#E8C534");
                        $("#calllinkcheck").css("color", "#ffffff");
                    }
                });
            },
            dataType: 'json',
        });

        // console.log(notificationid);

    }
</script>

<script type="text/javascript">
    function ss() {

        var ss = $('#notofication').val();

        if ($('#smscheck').is(':checked')) {

            var smsck = $('#smscheck').val();
        } else {
            var smsck = 0;

        }
        if ($('#emailcheck').is(':checked')) {

            var emailck = $('#emailcheck').val();

        } else {
            var emailck = 0;
        }
        if ($('#callcheck').is(':checked')) {

            var callck = $('#callcheck').val();
            location.reload();

        } else {
            var callck = 0;
            location.reload();
        }

        $.ajax({

            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "mobileno": ss,
                "sms": smsck,
                "mail": emailck,
                "call": callck,
            },
            url: '{{ URL::route("notificationstatus") }}',
            success: function(data) {

            }
        });

    }
</script>

<script type="text/javascript">
    function sms() {

        if ($('#sms').is(":checked")) {

            var sms = $('#sms').val();


        }
    }

    function smscheck() {

        $('#smscheck').trigger('click');

        if ($('#smscheck').is(':checked')) {

            $("#smslinkcheck").css("background-color", "#E8C534");
            $("#smslinkcheck").css("color", "#ffffff");

        } 
        else
         {
            $("#smslinkcheck").css("color", "#666");
            $("#smslinkcheck").css("background-color", "#f4f4f4");

        }

            // p.hide(1500).show(1500);

        $('#asd').click(function() {

            var sms = $('#smscheck').val();


        });

    }

    function emailcheck() {

        $('#emailcheck').trigger('click');

        if ($('#emailcheck').is(':checked')) {

            $("#emaillinkcheck").css("background-color", "#E8C534");
            $("#emaillinkcheck").css("color", "#ffffff");
        } 
        else
         {
            $("#emaillinkcheck").css("color", "#666");
            $("#emaillinkcheck").css("background-color", "#f4f4f4");

        }
    }

    function callcheck() {

        $('#callcheck').trigger('click');

         if ($('#callcheck').is(':checked')) {

            $("#calllinkcheck").css("background-color", "#E8C534");
            $("#calllinkcheck").css("color", "#ffffff");
        } 
        else
         {
            $("#calllinkcheck").css("color", "#666");
            $("#calllinkcheck").css("background-color", "#f4f4f4");

        }
    }
</script>



<script type="text/javascript">
  $(document).ready(function(){
var truefalse='';

var followupdatefrom = '<?php  if(!empty($followupdatefrom)) {echo $followupdatefrom;} ?>';
var inquirydatefrom = '<?php  if(!empty($inquirydatefrom)) {echo $inquirydatefrom;} ?>';
var followupdateto = '<?php  if(!empty($followupdateto)) {echo $followupdateto;} ?>';
var firstname_select = '<?php  if(!empty($firstname_select)) {echo $firstname_select;} ?>';
var mobileno = '<?php  if(!empty($mobileno)) {echo $mobileno;} ?>';
var hearabout = '<?php  if(!empty($hearabout)) {echo $hearabout;} ?>';
var quality = '<?php  if(!empty($quality)) {echo $quality;} ?>';

// alert(firstname_select);
if(followupdatefrom !=''|| inquirydatefrom !='' || followupdateto !='' || firstname_select !='' ||
mobileno !='' || hearabout !=''|| quality !='' ){
truefalse=false;
}
else{
truefalse=true;
}
// alert(truefalse);
 
      $('#example1').DataTable({
 "paging": truefalse,
   "order": [[ 0, "Desc" ]], //or asc 
    "columnDefs" : [{"targets":3, "type":"date-eu"}],
 language: { search: '', searchPlaceholder: "Search..." },
  "searching": false,
});
       
   });

    $("#ratingForm").change(function(e) 
    {
        e.preventDefault(); // prevent the default click action from being performed
        if ($("#ratingForm :radio:checked").length == 0) {
            $('#status').html("nothing checked");
            return false;
        } else {
          
            $('#status').html( 'You Rated ' + $('input:radio[name=rating]:checked').val() );
        }
    });

</script>
<script type="text/javascript">
  $(function () {
    $('.date').datetimepicker({format: 'DD/MM/YYYY',useCurrent: 'day'});
  });
</script>

<script type="text/javascript">
    $(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
</script>
<script type="text/javascript">
  $('#getinquiryexcelreport').on('click',function(){
            $.ajax({
                                        url:"{{ url('getinquiryexcelreport') }}",
                                        method:"POST",
                                        data:{"_token": "{{ csrf_token() }}"},
                                      success: function (response, textStatus, request) {
                                      var a = document.createElement("a");
                                      a.href = response.file; 
                                      a.download = response.name;
                                      document.body.appendChild(a);
                                      a.click();
                                      a.remove();
                                      },
                        
                                        dataType:'json',

                                        });
  });
</script>
@endsection
