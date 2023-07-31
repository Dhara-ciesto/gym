@extends('layouts.adminLayout.admin_design')
@section('content')
 <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/js/cdnjs-extra/jquery.easing.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">



<div class="content-wrapper">
  <section class="content-header">
      <h2>Users</h2>
  </section>
  <!-- general form elements -->
  <div class="content">
     @if ($message = Session::get('message'))
     <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
     </div>
     @endif 
     @if (Session::get('errors'))
     @foreach ($errors->all() as $error)
     <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button> 
      <strong>{{ $error }}</strong>
      </div>
 @endforeach
     
     @endif 
      <div class="">
            <div class="box">
               <div class="box-header with-border">
               Filters
                    <!-- <h3 class="box-title">Filters</h3> -->
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
               </div>
               <div class="box-body">           
                  <form method="post" action="{{ url('users') }}">
                     {{ csrf_field() }}
                     <div class="row"> 
                        <div class="form-group col-md-3">
                           <div class="date" id="startdate">
                              <label>Username</label>
                              <select  name="username" class="form-control select2 " width="100%" data-placeholder="Select a Username"  id="username" >
                                 <option value="" selected disabled>Select User Name</option>
                              
                                 @foreach($allusers as $user)


                                 <option value="{{ $user->userid }}" @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>{{ $user->username }}</option>

                                 @endforeach
                              </select>
                           </div>
                        </div>

                        <div class="form-group  col-md-3">
                           <div class="date" id="startdate">
                              <label>MobileNo</label>
                                 <?php $useridmobile_select = !empty($userid_mobile) ? $userid_mobile : '' ?>
                                 
                                 <!-- <label for="username" class="sr-only">Mobile No.</label> -->
                                 <select  name="mobileno" class="form-control select2" data-placeholder="Select MobileNo"  id="mobileno">
                                    <option value="" selected disabled>Select Mobile No.</option>
                                    <option value="" >All</option>
                                    @foreach($allusers as $user)
                                    <option value="{{ $user->userid }}" @if(isset($query['mobileno'])) {{$query['mobileno'] == $user->userid ? 'selected':''}} @endif>{{ $user->mobileno }}</option>
                                    @endforeach
                                 </select>
                           </div>
                        </div>
                        <div class="form-group col-md-3">
                           <div class="date" id="enddate">
                              <label>Status</label>
                              <select  name="status" class="form-control select2" data-placeholder="Select Status"  id="status">
                                 <option value="" selected>All</option>
                                    <option value="1" {{ $query['status'] == '1' ? 'selected' : ''}}>Active</option>
                                       <option value="2" {{ $query['status'] == '2' ? 'selected' : ''}}>Deactive</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group col-md-3">
                           <div class="date" id="enddate">
                              <label>Any KeyWord</label>
                              <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Any Keyword"@isset($query['keyword']) value="{{$query['keyword']}}"@endisset>
                           </div>
                        </div>
                     </div>
                     <div class="row"> 
                       
                         <div class="form-group col-md-3">
                           <div class="date" id="enddate">
                              <label>Role</label>
                              <select  name="roleid" class="form-control select2" data-placeholder="Select Role"  id="role">
                                 <option value="" selected>All</option>
                                   @foreach($roles as $role)
                                 <option value="{{ $role->roleid }}" @if(isset($query['roleid'])) {{$query['roleid'] == $role->roleid ? 'selected':''}} @endif>{{ $role->employeerole }}</option>

                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="form-group col-md-3 ">
                           <div class="date" id="enddate" style="margin-top:8%">
                              <button name="submit" type="submit" class="btn bg-green">Search</button>
                              <a href="{{ url('users') }}" class="btn bg-red">Clear</a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
         </div>
      </div>
     <div class="table-wrapper">
        <div class="table-title">
           <div class="box">
              <div class="box-header  with-border">
                 <?php $permission = unserialize(session()->get('permission')); ?>
                 @if(isset($permission["'add_employee'"]))
                 <a href="{{ url('addUser') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i> Add New</a>
                 @endif
                 <h3 class="box-title">View Users</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                 <div class="table-responsive" >
                    <table id="example12"class="table no-margin">
                       <thead>
                          <tr>
                             <th>FirstName</th>
                             <th>LastName</th>
                             <th>UserName</th>
                             <th>Role</th>
                             <th>Email id</th>
                             <!-- <th>Address</th> -->
                             <th>City</th>
                             <th>Department</th>
                             <th>Salary</th>

                             <!-- <th colspan="2">Working Hour</th> -->
                             <!--  <th>Birthdate</th> -->
                             <!-- <th>Gender</th>
                                <th>Mobile No</th> -->
                             <th>Actions</th>
                          </tr>
                       </thead>
                       <tbody>
                          @if($users)
                          @foreach($users as $user)
                          <tr>
                             <td> {{ ucwords($user->first_name) }}</td>
                             <td> {{ucwords( $user->last_name )}}</td>
                             <td> {{ $user->username }}</td>
                             <td>{{$user->employeerole}} </td>
                             <td> {{ $user->email }}</td>
                             <!-- <td> {{ $user->address }}</td> -->
                             <td> {{ $user->city }}</td>
                             <td> {{ $user->department }}</td>
                             <td> {{ $user->salary }}</td>
                          
                             <td>
                                @if(isset($permission["'edit_employee'"]))
                                <a href="{{ url('edituser/'.$user->employeeid) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>
                                @endif
                                @if($user->enroll == 1)
                                <a id="setuser" title="Device Asscess"><i class="fa fa-universal-access" style="color: red;"></i>
                                @else
                                <a href="#" id="setuser" title="Device Asscess" data-toggle="modal" data-target="#modal-default" onclick="da('{{$user->employeeid}}','{{$user->username}}','{{ $user->mobileno }}')"><i class="fa fa-universal-access"></i>
                                @endif
                                <input type="hidden" name="deviceaccess" id="deviceaccess" value="{{$user->employeeid}}">
                                </a>
                                <a href="" class="" id="userfetchlogs" data-toggle="modal" onclick="fetchlogs('{{$user->mobileno}}')" data-target="#fetchlogs" title="Logs"><i class="fa fa-history"></i></a>
                                @if($user->status == 1)
                                <a href="" class="" id="deactiveuserq" data-toggle="modal" data-target="#deactiveuser" onclick="deactiveuser('{{$user->mobileno}}')"  title="Deactive User"><i class="fa fa-user"></i></a>
                                @else
                                <a href="" data-toggle="modal" id="activeuserq" data-target="#activedeviceuser" onclick="activeuser('{{$user->mobileno}}')" title="Active User"><i class="fa fa-user" style="color: #B49168;"></i></a>
                                @endif
                              
                                <a href="" data-toggle="modal" id="activeuserq"class="delete" data-target="#extendsexpiry" onclick="extendexpiry('{{$user->employeeid}}')" title="Extend Expiry"><i class="fa fa-plus" ></i></a>
                             </td>
                          </tr>
                          @endforeach
                    </table>
                    <div class="datarender" style="text-align: center">  {!! $users->appends($query)->render() !!} </div>
                    @else
                    @endif
                 </div>
                 <!-- /.box-body -->
              </div>
           </div>
           <div class="modal fade" id="fetchlogs">
              <div class="modal-dialog">
                 <div class="modal-content">
                    <div class="modal-header">
                       <button type="button" class="close close1"  data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title"><b>Users Punch In/Out Time</b></h4>
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
                       <button type="button" class="btn btn-danger close1"  data-dismiss="modal">Close</button>
                       <!-- <a type="submit" id="setusersave" data-dismiss="modal"  class="btn  bg-green">Save</a> -->
                    </div>
                 </div>
                 <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->                        
           </div>
           <div class="modal fade" id="deactiveuser">
              <div class="modal-dialog">
                 <div class="modal-content">
                    <div class="modal-header">
                       <button type="button" class="close close1"  data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title"><b>Deactive User</b></h4>
                    </div>
                    <div class="modal-body">
                       <h4>Are You Sure To Deactive User From Device!</h4>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-danger close1"  data-dismiss="modal">No</button>
                       <a  id="deactiveusersave" data-dismiss="modal" class="btn bg-green">Yes</a>
                    </div>
                 </div>
                 <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->                        
           </div>
           <div class="modal fade" id="modal-default"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                 <div class="modal-content">
                    <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Enroll Card</h5>
                    </div>
                    <div class="modal-body">
                       <div id="firststage">
                          <div class="row">
                             <div class="col-md-12">
                                <div class="empexpiry">
                                   <!-- first stage start -->
                                   <div class="row">
                                      <div class="col-md-12">
                                         <input type="hidden"  id="setuserid" class="form-control" name="deviceuserid" value="{{$user->employeeid}}" disabled="">
                                         <input type="hidden" id="setuserrefid" name="deviceuserreferenceid" class="form-control" value="{{$user->employeeid}}" disabled="">
                                         <input type="hidden" id="devicemobileno" name="devicemobileno" class="form-control" value="{{$user->mobileno}}">
                                      </div>
                                      <div class="row">
                                         <div class="form-group">
                                            <div class="col-md-10 col-md-offset-1">
                                               <label>User Name</label>
                                               <input type="text" class="form-control" name="username" placeholder="Enter User Name" id="setusername" disabled="">
                                            </div>
                                         </div>
                                      </div>
                                      <br/>
                                      <div class="row">
                                         <div class="col-md-6 col-md-offset-1">
                                            <label>Set User Expiry</label>
                                         </div>
                                      </div>
                                      <div class="row">
                                         <div class="col-md-10 col-md-offset-1">
                                            <input type="date" class="form-control" onkeypress="return false" name="" id="setuserexpiry" required="" value="<?php echo date('Y-m-d', strtotime('+3 years'))?>" min="<?php echo date('Y-m-d') ?>">
                                         </div>
                                      </div>
                                   </div>
                                   <center><button id="firststage_next" class="btn btn-success" style="margin-top: 15px;">Next</button></center>
                                </div>
                                <!-- first stage end -->
                                <!-- second stage start -->
                                <div class="cardcheckform" style="display: none;">
                                   <input type="hidden" name="cardunique" id="cardunique">
                                   <label>Scan card to verify</label>
                                   <input type="text" name="cardno" id="cardno" style="height: 0;width: 0;"><br/>
                                   <span id="scanning mt-3"><button class="btn btn-danger" style="margin-top: 5px;margin-bottom: 10px;
                                      ">Scanning...</button></span><br/>
                                   <span style="color: red;">Please do not click anywhere on screen</span><br/>
                                   <div class="row" style="display: none;" id="card_detail">
                                      <center>
                                         <label>Card Detail</label>
                                         <div class="col-md-12">
                                            <span><img id="img_card" src="" style="height: 100px;width: 100px;" alt="User Image"></span>
                                         </div>
                                         <div class="col-md-12" style="margin-top: 5px;">
                                            <center>
                                               <h3><span id="fullname_card"></span></h3>
                                            </center>
                                         </div>
                                      </center>
                                   </div>
                                   <div class="row">
                                      <div class="col-md-12" style="margin-top: 10px;">
                                         <span style="color: red;display: none;" id="card_err">Card is already in device. Please change  other card.</span>
                                      </div>
                                   </div>
                                   <center><button id="secondtage_next" class="btn btn-success" style="display: none;">Next</button></center>
                                </div>
                                <!-- second stage end -->
                                <!-- third stage start -->
                                <div class="secondstageform" style="display: none;">
                                   <label>Scan a card to enroll</label>
                                   <input type="text" name="cardno" id="finalcardno" style="height: 0;width: 0;">
                                   <div class="row">
                                      <div class="col-md-12">
                                         <span id="scanning_second"><button class="btn btn-danger">Scanning...</button></span><br/>  
                                      </div>
                                   </div>
                                </div>
                                <center><button  style="display: none;" class="btn btn-success">Next</button></center>
                             </div>
                          </div>
                       </div>
                       <!-- third stage end -->
                    </div>
                    <div class="modal-footer">
                       <a href="{{ url('users') }}" class="btn btn-danger">Close</a>
                    </div>
                 </div>
              </div>
           </div>
           <div class="modal fade" id="modal-defaultpon" aria-hidden="true">
              <div class="modal-dialog">
                 <div class="modal-content">
                    <div class="modal-header">
                       <button type="button" class="close" id="modelclose" data-dismiss="modal" aria-label="Close"> 
                       <span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title"><b>Set User To device</b></h4>
                    </div>
                    <div class="modal-body">
                       <form id="msform" action="#encard" method="post">
                          <!-- <form id="msform" action="{{url('addinquirydata')}}" method="post"> -->
                          {{ csrf_field() }}
                          <!-- progressbar -->
                          <ul id="progressbar">
                             <li class="active"><b>Set User</b></li>
                             <li><b>Enroll User</b></li>
                             <li><b>Enroll in to System</b></li>
                          </ul>
                          <!-- fieldsets -->
                          <fieldset>
                             <h2 class="fs-title">Set User</h2>
                             <h3 class="fs-subtitle">Tell us something about you</h3>
                             <div class="row">
                                <div class="form-group">
                                   <div class="col-md-5 col-md-offset-1">
                                      <!-- <label>User id</label> -->
                                      <input type="hidden"  id="setuserid" class="form-control" name="deviceuserid" value="{{$user->employeeid}}" disabled="">
                                   </div>
                                   <div class="col-md-5">
                                      <!-- <label>User Reference id</label> -->
                                      <input type="hidden" id="setuserrefid" name="deviceuserreferenceid" class="form-control" value="{{$user->employeeid}}" disabled="">
                                      <input type="hidden" id="devicemobileno" name="devicemobileno" class="form-control" value="{{$user->mobileno}}">
                                   </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="form-group">
                                   <div class="col-md-10 col-md-offset-1">
                                      <label>User Name</label>
                                      <input type="text" class="form-control" name="username" placeholder="Enter User Name" id="setusername" disabled="">
                                   </div>
                                </div>
                             </div>
                             <br/>
                             <div class="row">
                                <div class="col-md-6 col-md-offset-1">
                                   <label>Set User Expiry</label>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-6 col-md-offset-1">
                                   <input type="date" onkeypress="return false" name="" id="setuserexpiry" required="" value="<?php echo date('Y-m-d', strtotime('+3 years'))?>" min="<?php echo date('Y-m-d') ?>">
                                </div>
                             </div>
                             <!-- <div class="form-group">
                                <div class="row"> 
                                     <div class="col-md-3 col-md-offset-1">
                                      <label>Status</label>
                                </div>
                                
                                    <div class="col-md-6">
                                      <select class="form-control" name="status" id="setuserstatus" required="">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                      </select>
                                    </div>
                                  </div>
                                
                                </div> -->
                             <br/>
                             <input type="button" name="next" class="next action-button" value="Next" id="setusersave" onclick="setuser();" />
                          </fieldset>
                          <fieldset>
                             <h2 class="fs-title">Enroll User</h2>
                             <h3 class="fs-subtitle">Tell us something more about you</h3>
                             <a href="#" class="btn bg-orange" id="enrolluser" style="padding: 50px;" onclick="enroll();">Enroll User</a>
                             <input type="button" name="next" class="next action-button" value="Next"id="next2" />
                          </fieldset>
                          <fieldset>
                             <h2 class="fs-title">Enroll card</h2>
                             <h3 class="fs-subtitle">Tell us something more about you</h3>
                             <a  name="submit" style="padding: 50px;color: #FFA233;" title="Enroll Card"  value="EnrollCard" onclick="enrollcard();" id="enrolluser"><i class="fa fa-id-card fa-5x"></i></a>
                          </fieldset>
                       </form>
                    </div>
                 </div>
              </div>
           </div>
           <br/>  
           <script type="text/javascript">
              function enrollcard(){
                var did =  $('#deviceaccess').val();
                // alert('{{ url("enrollemployeecard")}}'+'/'+did);
                $('#msform').attr('action','{{ url("enrollemployeecard")}}'+'/'+did);
                $('#msform').submit();
              }
           </script>
        </div>
        <div class="modal fade" id="activedeviceuser">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Active User</b></h4>
                 </div>
                 <div class="modal-body">
                    <div class="row">
                       <div class="col-md-4">
                          <label>Set User Expiry date</label>
                       </div>
                       <div class="col-md-8">
                          <input type="date" class="form-control" name="activationdate" id="activationdate" min="<?php echo date('Y-m-d')?>" value="<?php echo date('Y-m-d')?>">
                       </div>
                    </div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                    <a href="" class="btn bg-green" id="activeuser">Active</a>
                 </div>
              </div>
           </div>
        </div>
        <div class="modal fade" id="extendsexpiry">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Extend Expiry</b></h4>
                 </div>
                 <div class="modal-body">
                    <div class="row">
                       <div class="col-md-4">
                          <label>Extend Expiry Date</label>
                       </div>
                       <div class="col-md-8">
                         <input type="hidden" id="employeeid">
                       <input type="date" onkeypress="return false" value="{{ date('Y-m-d') }}" id="setuserexpiry" class="form-control" name="sdate" required="" min="<?php echo date('Y-m-d') ?>">
                       </div>
                    </div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                    <button  type="button"  class="btn bg-green" id="extends">Extend</button>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>
</div></div>
<script>
  $('#extends').on('click',function(){

    let setuserexpiry = $('#setuserexpiry').val();
    let employeeid=$('#employeeid').val();
    $.ajax({
          url: "{{ url('extendemployee') }}",
          method: "POST",
          data: {
            date: setuserexpiry,
            employeeid:employeeid,
            _token: '{{ csrf_token() }}'
          },
          success: function (data) {
            if(data == 200){
              alert('Expiry extend successfully');
              location.reload();
            }
            // 
          },
      });
    });
</script>
<script type="text/javascript">

                  function deactiveuser(mobileno){

                      $('#deactiveuserq').val(mobileno);

                      $('#deactiveusersave').click(function(){

                        var devicemobileno = $('#deactiveuserq').val();
                        var _token = $('input[name="_token"]').val();

                          
                           $.ajax({
                             url:"{{ url('deactivedeviceemployee') }}",
                             method:"POST",
                             data:{devicemobileno:devicemobileno, _token:_token},
                             success:function(data)
                             {
                                alert(data);
                               window.location.reload();
                            },

                          });
                      });
                  }

                  function activeuser(mobileno){

                    $('#activeuserq').val(mobileno);
                    // alert($('#activeuserq').val());

                    $("#activeuser").click(function(){
                           
                           var devicemobileno = $('#activeuserq').val();
                           var activuserdate = $('#activationdate').val();
                           var _token = $('input[name="_token"]').val();



                           $.ajax({
                             url:"{{ url('activedeviceemployee') }}",
                             method:"POST",
                             data:{devicemobileno:devicemobileno,activuserdate:activuserdate,_token:_token},
                             success:function(data)
                             {
                                 alert(data);
                                  window.location.reload();
                            },

                          });
                         });
                  }

                  function fetchlogs(id){

                      $('#userfetchlogs').val(id);
                      var userfetchlogs = $('#userfetchlogs').val();
                      var _token = $('input[name="_token"]').val();
                      $('#tbody').empty();
                      $.ajax({
                             url:"{{ url('userfetchlogs') }}",
                             method:"POST",
                             data:{userfetchlogs:userfetchlogs, _token:_token},
                             success:function(data)
                             {
                               

                              
                              var html="";
                              // var data = [];

                              $.each(data,function(i,item){

                                for (var i=0; i<item['checkin'].length; i++) {
                                   
                                   //alert(item['checkin'][2].time);
                               html +="<tr>"+"<td>"+item['checkin'][i].date+"</td>"+"<td>"+item['checkin'][i].time+"</td>"+"<td>"+item['checkout'][i].time+"</td>"+"</tr>";
                               //alert('response');
                                  }
                              });
                              // $('#t1').html(data[1]);
                              $('#tbody').append(html);

                            },
                            dataType:'json'

                          });

                  }

               </script>
<script type="text/javascript">

                                  function da(mid,name,mobileno){
                                        $('#deviceaccess').val(mid);
                                        var deviceaccess =  $('#deviceaccess').val();
                                        $('#setusername').val(name);
                                        $('#devicemobileno').val(mobileno);
                                  }

                                  function enroll(){

                                    var deviceaccess =  $('#deviceaccess').val();
                                    var devicemobileno = $('#devicemobileno').val();
                                    var _token = $('input[name="_token"]').val();

                                     $.ajax({
                                             url:"{{ url('enrollemployee') }}",
                                             method:"POST",
                                             data:{deviceaccess:deviceaccess,devicemobileno:devicemobileno, _token:_token},
                                             success:function(data)
                                             {
                                              
                                                alert(data);
                                            },

                                          });

                                  }

                                  function setuser(){

                           var setusername = $('#setusername').val();
                           var setuserexpiry = $('#setuserexpiry').val();
                           var setuserstatus = $('#setuserstatus').val();
                          var _token = $('input[name="_token"]').val();
                          var deviceaccess =  $('#deviceaccess').val();
                          var devicemobileno = $('#devicemobileno').val();
                          
                         

                           $.ajax({
                             url:"{{ url('setemployee') }}",
                             method:"POST",
                             data:{setusername:setusername,setuserstatus:setuserstatus,setuserexpiry:setuserexpiry,deviceaccess:deviceaccess,devicemobileno:devicemobileno,_token:_token},
                             success:function(data)
                             {
                              
                                alert(data);
                            },

                          });
                        }

                         </script>
@endsection
@push('script')
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
    <script>
  $(function () {
    $('#example1').DataTable()
  })
</script>
<script type="text/javascript" src="js/inquiry_multistep.js"></script>
<script type="text/javascript">


  $('#modelclose').on('click', function () {
    window.location.reload();
  })
  
  $(document).ready(function(){

    ////////////// first stage start /////////////////////////////////
    $('#firststage_next').click(function(){
      let setusername = $('#setusername').val();
      let setuserexpiry = $('#setuserexpiry').val();
      let setuserstatus = $('#setuserstatus').val();
      let deviceaccess =  $('#deviceaccess').val();
      let devicemobileno = $('#devicemobileno').val();
                          
      $.ajax({
        type : 'POST',
        url : '{{ url('setemployee') }}',
        data : {setusername:setusername, setuserexpiry:setuserexpiry, setuserstatus:setuserstatus, deviceaccess:deviceaccess, devicemobileno:devicemobileno, _token : '{{ csrf_token() }}'},
        success : function(data){
          if(data == 201){

            $('.empexpiry').css('display', 'none');
            $('.cardcheckform').css('display', 'block');
            $('#cardno').focus();
          }else{
            alert('There is something wrong! please try later');
            //window.location.href = '';
          }
        }
      });
    });
  ///////////////////////////// first stage end //////////////////////////////////////

  /////////////////////////////// second stage start /////////////////////////////////////////

  $('#cardno').change(function(){
      let cardno = $(this).val();
      $('#card_err').hide();
      if(cardno){
        $('#cardunique').val(cardno);
        $.ajax({
          type : 'POST',
          url : '{{ route('cardexist') }}',
          data : {cardno:cardno,empcard : 1, _token:'{{ csrf_token() }}'},
          success : function(data){
            if(data == 201){
              $('#cardno').val('');
              $('#secondtage_next').show();
              $('#card_err').hide();
              $('#card_detail').hide();
            }else{
              $('#cardno').val('');
              $('#cardno').focus();
              $('#card_err').show();
              $('#card_detail').show();
              $('#fullname_card').text(data[0]);
              console.log(data[1]);
              if(data[1] == null){
                //data[1] = 'default.png';  
                $('#img_card').attr('src', '{{ asset('images/default.png') }}');
              }else{
                $('#img_card').attr('src', '{{ asset('files/') }}'+'/'+data[1]);
              }
              $('#secondtage_next').hide();
            }
          }
        });
      }else{

      }
    });


    $('#secondtage_next').click(function(){
      $('.cardcheckform').hide();
      $('.secondstageform').show();
      $('#finalcardno').focus();
      $(this).hide();
    });

    $('#finalcardno').change(function(){

      let finalcard = $(this).val();
      let mobileno = $('#devicemobileno').val();
      let reassigncard = $('#reassigncard').val();
      if(finalcard && mobileno){
        let unique_card = $('#cardunique').val();
        if(unique_card == finalcard){
          $.ajax({
            type : 'POST',
            url : '{{ route('enrollfinalcard') }}',
            data : {mobileno:mobileno, finalcard:finalcard, reassigncard:reassigncard, _token : '{{ csrf_token() }}'},
            success : function(data){
              if(data == 201){
                alert('card is enrolled successfully');
                window.location.href = '';
              }else{
                alert('There is some problem occure');
                window.location.href = '';
              }
            }
          });
        }else{
          alert('Do not change card.Try again');
          window.location.href = '';
        }
        
      }else{
        alert('Please select cardno or username');
        window.location.href = '';
      }

    });





  /////////////////////////////// second stage end //////////////////////////////////////////



  });

  function myFunction() {
      if(!confirm("Are You Sure to Deactive User ?"))
      event.preventDefault();
  }

  function extendexpiry(empid){
    console.log(empid);
    $('#extendsexpiry #employeeid').val(empid);
  }
</script>
 
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
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
@endpush
