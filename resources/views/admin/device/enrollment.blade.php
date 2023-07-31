@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<!-- <script type="text/javascript" src="../js/sweetalert.min.js"></script>
@include('sweet::alert') -->

<style type="text/css">

/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 18px;
  margin-top: 20px;
  cursor: pointer;
  font-size: 15px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color:#FACB79;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ECA426;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #ECA426;
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

/* Style the checkmark/indicator */
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

.scrollbar{


}


#scroll::-webkit-scrollbar {
  width: 15px;
}

/* Track */
#scroll::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 5px;
}
 
/* Handle */
#scroll::-webkit-scrollbar-thumb {
  background: #ECA426; 
  border-radius: 5px;
}

/* Handle on hover */
#scroll::-webkit-scrollbar-thumb:hover {
  background: #DC9822; 
}

</style>

  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Member Enrollment</h2></section>
          <!-- general form elements -->
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
      @if($message=="Your timing is different from package timimg")
      <div class="alert alert-danger alert-block" id="danger-alert">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
     @if($message=="You Cant  assign  same package untill its not completed")
      <div class="alert alert-danger alert-block" id="danger-alert">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
@endif 
<script type="text/javascript">
  $(document).ready (function(){
                $("#danger-alert").fadeTo(5000, 500).slideUp(500, function(){
               $("#danger-alert").slideUp(1000);
                });   
 });
</script>
 <form role="form" action="{{ url('assessment') }}" name="frmMr" method="POST" id="form1">
  {{ csrf_field() }}
<div class="box box-primary" id="secondstep" >

           <div class="box-header with-border">
              <h3 class="box-title">Select Member For Enrollment To Device</h3>
            </div>

<!-- /.box-header -->
    <div class="box-body">  <h4><u></u></h4> 
      <div class="col-lg-4">
  
      <div class="input-group">
        <label>Enroll Username</label>

       <select name="selectusername" id="username"  class="form-control selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Username"><option selected >--Please choose an option--</option>
        @foreach($users as $user)
        <option value="{{ $user->userid }}">{{ $user->username }}</option>@endforeach
        </select>
      </div>
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4">
      <div class="input-group">
        <label>Mobile No:</label>
        <select name="selectmobileno" id="mobileNo" class="form-control" ><option selected >--Please choose an option--</option>
        @foreach($users as $user)
        <option value="{{ $user->userid }}">{{ $user->mobileno }}</option>
        @endforeach
        </select>
      </div>
<!-- /input-group -->
    </div>
    <br>


    <div class="col-lg-4" style="margin-top: 5px;">
      <div class="form-group">
       <button type="button" id="assignPackage" class="btn bg-orange">Next</button>
      </div>
    </div>

        </form>

               <div class="col-lg-12" id="Enrollment" style="display: none" class="Package">
                   <form action="{{route('setuser')}}" method="post">
                          {{ csrf_field() }}

                <div class="well well-lg">
                     <h4 class="article-title"><i></i>Biomatric Device</h4>
                     <div class="row">

                      <div class="col-md-8" style='overflow:auto; height:200px;' class="scrollbar" id="scroll">
                                @foreach($ipdata as $d)
                                 <label class="container">{{$d->devicename}}
                                  <input type="checkbox" checked="checked" name="devicename[]"  value="{{$d->deviceinfoid}}" {{ $d->devicename ? 'checked' : '' }}>
                                  <span class="checkmark"></span>
                                </label>
                                <!-- <input type="hidden"  name="serial[]"  value="{{$d->serialno}}"> -->
                                @endforeach
                                <!-- <label class="container">{{$d->devicename}}
                                  <input type="checkbox" checked="checked" name="devicename[]"  value="1" {{ $d->devicename ? 'checked' : '' }}>
                                  <span class="checkmark"></span>
                                </label>
                                <label class="container">{{$d->devicename}}
                                  <input type="checkbox" checked="checked" name="devicename[]"  value="1" {{ $d->devicename ? 'checked' : '' }}>
                                  <span class="checkmark"></span>
                                </label>
                                <label class="container">{{$d->devicename}}
                                  <input type="checkbox" checked="checked" name="devicename[]"  value="1" {{ $d->devicename ? 'checked' : '' }}>
                                  <span class="checkmark"></span>
                                </label>
                                <label class="container">{{$d->devicename}}
                                  <input type="checkbox" checked="checked" name="devicename[]"  value="1" {{ $d->devicename ? 'checked' : '' }}>
                                  <span class="checkmark"></span>
                                </label> -->
                      </div>

                      <div class="col-md-4">
                        <a href="#" class="btn bg-orange btn-block" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Set User To device</a>
                        <a href="#" class="btn bg-orange btn-block" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default1">Enroll User To Device</a>
                        <a href="#" class="btn bg-orange btn-block" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default2">others</a>
                      </div>

                      <div class="modal fade" id="modal-default">

                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><b>Set User To device</b></h4>
                              </div>
                              <div class="modal-body">
                            <div class="row">
                               
                                  <div class="form-group">
                                    <div class="col-md-5 col-md-offset-1">
                                      <label>User id</label>
                                      <input type="text" class="form-control" name="deviceuserid" value="{{$deviceusersidsum->deviceusersid + 1}}">
                                    </div>
                                    <div class="col-md-5">
                                      <label>User Reference id</label>
                                      <input type="text" name="deviceuserreferenceid" class="form-control" value="{{$deviceusersidsum->deviceusersid + 1}}">
                                    </div>
                                  </div>
                                </div>
                                <br/>

                                <div class="row">
                                  <div class="form-group">
                                    <div class="col-md-10 col-md-offset-1">
                                      <label>User Name</label>
                                      <input type="text" class="form-control" name="username" placeholder="Enter User Name">
                                    </div>
                                  </div>
                                </div>
                                <br/>

                                 <div class="row">
                                  <div class="form-group">
                                     <div class="col-md-10 col-md-offset-1">
                                      <label>User Pin</label>
                                      <input type="text" class="form-control number" name="pin" placeholder="Enter User Pin" maxlength="4">
                                    </div>
                                  </div>
                                </div>
                                <br/>

                                <div class="row">
                                <div class="col-md-6 col-md-offset-1">
                                  <label>Set User Expiry</label>
                                </div>
                              </div>

                                <!-- <div class="row">

                                  <div class="col-md-3 col-md-offset-1">
                                    <select name="birth_day">
                                      <?php 
                                        $start_date = 1;
                                        $end_date   = 31;
                                        for( $j=$start_date; $j<=$end_date; $j++ ) {
                                          echo '<option value='.$j.'>'.$j.'</option>';
                                        }
                                      ?>
                                    </select>
                                  </div>

                                  <div class="col-md-3">
                                    <select name="birth_month">
                                      <?php for( $m=1; $m<=12; ++$m ) { 
                                        $month_label = date('F', mktime(0, 0, 0, $m, 1));
                                      ?>
                                        <option value="<?php echo $month_label; ?>"><?php echo $month_label; ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>

                                  <div class="col-md-3">
                                    <select name="birth_year">
                                      <?php 
                                        $year = date('Y');
                                        $min = $year ;
                                        $max = $year + 60;
                                        for( $i=$max; $i>=$min; $i-- ) {
                                          echo '<option value='.$i.'>'.$i.'</option>';
                                        }
                                      ?>
                                    </select>
                                  </div>
    
                                </div><br/> -->

                                <div class="row">
                                  <div class="form-group col-md-6 col-md-offset-1">
                                    <input type="date" onkeypress="return false" class="form-control" name="date" min="<?php echo date('Y-m-d'); ?>">
                                  </div>
                                </div>
                              

                                 <div class="form-group">
                                <div class="row">
                                 
                                     <div class="col-md-3 col-md-offset-1">
                                      <label>Status</label>
                                    </div>
                                    <div class="col-md-3">
                                      <select class="form-control" name="status">
                                        <option value="1">1</option>
                                        <option value="0">0</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <br/>


                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn  bg-green">Save</button>
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                          </form>
                        </div>

                        <div class="modal fade" id="modal-default1">
                          <div class="modal-dialog">
                            <form action="{{ url('device/configuser') }}" method="post">
                              {{ csrf_field() }}

                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Enroll User To Device</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-10 col-md-offset-1"> 
                                    <label>Select User Name For Enrollment</label>
                                    <select class="form-control" name="config">
                                      <option value=""> -- Select User Name --</option>
                                       @foreach($deviceusers as $duser)
                                       <option value="{{$duser->deviceusersid}}">{{$duser->username}}</option>
                                      @endforeach
                                    </select>
                                    
                                </div>
                              </div><br/>

                              
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn bg-green">Enroll</button>
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                          </form>
                        </div>
                      </div>

                        <div class="modal fade" id="modal-default2">
                          <div class="modal-dialog">
                            <form action="{{ url('device/deleteuserfromdevice') }}" method="post">
                                 {{ csrf_field() }}
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Delete User From Device</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-10 col-md-offset-1"> 
                                    <label>Select User Name For Enrollment</label>
                                    <select class="form-control" name="delete">
                                      <option value=""> -- Select User Name --</option>
                                       @foreach($deviceusers as $duser)
                                       <option value="{{$duser->deviceusersid}}">{{$duser->username}}</option>
                                      @endforeach
                                    </select>
                                    
                                </div>
                              </div><br/>

                              
                              <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                                <button type="submit" class="btn btn-danger">Delete</button>
                              </div>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                            </form>
                          </div>
                          <!-- /.modal-dialog -->
                        </div>




                  
                 
                      <!-- <label class="container">General Fitness
                          <input type="checkbox" checked="checked" name="generalfitness" value="1">
                          <span class="checkmark"></span>
                        </label>
                        <label class="container">Fat Loss
                          <input type="checkbox"  name="fatloss" value="1">
                          <span class="checkmark"></span>
                        </label>
                        <label class="container">Muscles Gain Body Building
                          <input type="checkbox"  name="musclesgainbodybuilding" value="1">
                          <span class="checkmark"></span>
                        </label>
                        <label class="container">Other
                          <input type="checkbox"  name="other" value="1">
                          <span class="checkmark"></span>
                        </label> -->
                      </div>
                    </div>
<br/>
                      <div class="form-group">
               
                  <div class="col-sm-2">
         <button type="submit" class="btn bg-green btn-block">
         Save</button></div>   <div class="col-sm-2"> <a href="{{ url('staticip/Enrollment') }}"class="btn btn-danger btn-block" >Cancel</a></div>
     
      </div>
        </div> 
      </div>
  </div>
  <!-- <div class="modal fade" id="myModalpayment" role="dialog" style="display: none;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
       Modal content
      <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Print</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to pay ?</p>
        </div>
          
        <div class="modal-footer">

          <button id="submit" type="submit" class="btn bg-blue margin" style="display: none;"> Save </button>
           <button id="saveprint"style="margin-top: -1px;" type="button" class="btn bg-green margin" onclick="abcd()">Save </button>
          <a href="{{ url('members') }}"  class="btn bg-teal">View Members</a>
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
        </div>
      </div>
      
    </div>
  </div> -->
    <!-- </form> -->  

</section>
<script type="text/javascript">
  function abcd(){
    $('#submit').trigger('click');
    $('#saveprint').hide();
    $('#mobileNo').attr("disabled", false);
  }
   $('#submit').on('click',function(){
   // var ok = confirm('Are you want message?');
   // if(ok){
   //    $('#ok').val('ok');
     
   // }
   // else{
   //   $('#ok').val('not ok');
    
   // }
 });
</script>

<script type="text/javascript">
   $('#assignPackage').on('click',function(){
    
     var username = document.getElementById("username").value;
     var MobileNo = document.getElementById("mobileNo").value;
     var _token = $('input[name="_token"]').val();
       $.ajax({
      url:"{{ route('PackageController.getuser') }}",
      method:"POST",
      data:{username:username, MobileNo:MobileNo, _token:_token},
      success:function(result)
      {
      
       if(result!= null)
       {
      
        var data=result;
        
         $('#Enrollment').css('display','block');
       
       }
       else
       {
       
         $('#Enrollment').css('display','block');
       }
      },
       dataType:"json"
     })

   });
</script>

<script type="text/javascript">
   $('#username').on('change',function(){
    
    var username = $('#username').val();
    // alert(username);
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('assessmentajax') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
       $('select[name=selectmobileno]').val(data.userid);
      // $('#mobileNo').val();
      },
       dataType:"json"
     });
   });
</script>
<script type="text/javascript">
   $('#mobileNo').on('change',function(){
    var user = $('#mobileNo').val();
    var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:user, _token:_token},
      success:function(result)
      {
      var data=result;

      // $('#username').attr("value",data.username).val(data.username);
     $("#username").val(data.userid);
      },
       dataType:"json"
     });
   });
// </script>
@endsection