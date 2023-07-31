@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

 <style type="text/css">
   .table-bordered {
    border: 1px solid #f4f4f4;
  }

   .btn-app {
        width: 130px;
        height: 100px;
       
        padding: 29px 8px;
    }
      .content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
  }
  .td{
  max-width: 20% !important;
}
.select2{
   max-width: 100% !important;
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
.green{
  color:green;
}
 </style>


<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>

  <div class="content-wrapper">
   
     
         <section class="content-header"><h2> Members</h2></section>
          <!-- general form elements -->
        
         <section class="content">
       @if ($message = Session::get('message'))
<div class="alert alert-success alert-block" id="#success-alert">
  <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>
@endif 
     <div class="row">
        <div class="col-md-12">
          <div class="row">
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
              <form method="post" action="{{ url('members') }}">
                {{ csrf_field() }}
                <div class="table-responsive">
                  <table class="table no-margin">
                  <!-- <div class="form-group"> -->
                  <thead>
                    <tr>
                      <th>Username :</th>
                      <th>MobileNo</th>
                    
                      <th>From</th>
                    <th>To</th>
                      
                    </tr>
                  </thead>
                      <tr>
                          <td class="td" style="width: 20%;">
                      <!-- <label for="user" class="sr-only">User Name</label> -->
                      <select  name="username" class="form-control select2 " width="100%" data-placeholder="Select a Username"  id="username" >
                        <option value="" selected disabled>Select User Name</option>
                      
                        @foreach($users as $user)


                          <option value="{{ $user->userid }}" @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>{{ $user->username }}</option>

                        @endforeach
                      </select>
                    </td>
                    <td class="td" style="width: 20%;">

                    <?php $useridmobile_select = !empty($userid_mobile) ? $userid_mobile : '' ?>
                  
                      <!-- <label for="username" class="sr-only">Mobile No.</label> -->
                      <select  name="mobileno" class="form-control select2" data-placeholder="Select MobileNo"  id="mobileno">
                        <option value="" selected disabled>Select Mobile No.</option>
                        <option value="" >All</option>
                        @foreach($users as $user)

                    

                          <option value="{{ $user->userid }}" @if(isset($query['mobileno'])) {{$query['mobileno'] == $user->userid ? 'selected':''}} @endif>{{ $user->mobileno }}</option>

                        @endforeach
                      </select>
                    </td>
              
            
                    <td class="td" style="width: 20%;">
                        <!-- <label>From</label> -->

                        <!-- <div class="input-group date" style="max-width:180px" id="startdate"> -->
                          <input type="date" onkeypress="return false" class="form-control " @isset($query['fdate']) value="{{$query['fdate']}}"@endisset name="fdate" placeholder="From Date" />
                        
                        <!-- </div> -->
                        </td>
                            <td class="td" style="width: 20%;">

                        <!-- <div class="input-group date" style="max-width:180px" id="enddate"> -->

                          <input type="date" onkeypress="return false" class="form-control" name="tdate"  placeholder="To Date" @isset($query['tdate']) value="{{$query['tdate']}}"@endisset />
                        <!-- </div> -->
                        </td>
                    </tr>
                    <tr>
                      <td class="td" style="width: 10%;">
                    <!-- <label class="sr-only" for="search">Any Keyword</label> -->
                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Any Keyword"@isset($query['keyword']) value="{{$query['keyword']}}"@endisset>
                    </td>



                  <td colspan="20">
                      <button name="submit" type="submit" class="btn bg-primary">Search</button> <a href="{{ url('members') }}" class="btn bg-red">Clear</a>
                      <button data-toggle="modal" data-target="#exampleModalLong" type="button" class="btn bg-green">Excel</button>
                      <button name="excel" id="excel" type="submit" class="btn bg-green" style="display: none"></button>
                    </td>
                  </tr>
                  </div>
                </table>
          </form>
        </div>  
      </div>
    </div>

    @if($message=="User Is Already Exits")
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>

@endif 

  <div class="box box-info">
            <div class="box-header with-border">
                <?php $permission = unserialize(session()->get('permission')); ?>
      @if(isset($permission["'add_member'"]))
    
      @endif
<!--               <h3 class="box-title">All Members</h3>
 -->
              <div class="box-tools pull-right">
               
                  <a href="{{ url('addMember') }}" title="Add New Member" class="btn add-new bg-orange"><i class="fa fa-plus"></i> New Member</a>
              </div>
            </div>

 <!--       <div class="box content-fit-box">
    <div class="box-header">
      <?php $permission = unserialize(session()->get('permission')); ?>
      @if(isset($permission["'add_member'"]))
      <a href="{{ url('addMember') }}" class="btn add-new bg-navy"><i class="fa fa-plus"></i> Add New</a>
      @endif

    <h3 class="box-title">All Members</h3>
    </div> -->
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
      
<!--         <table id="contractdata" cellspacing="0" width="100%" class="table table-striped table-bordered dt-responsive"> -->
        <table class="table no-margin" role="grid" aria-describedby="example1_info" id="memberdata1">
          <thead>

             <tr>       
              <th style="display: none">id</th>
              <th>view</th>
                      
                        <th>Full Name</th>
                        
                        <th>UserName</th>
                      
                        <th>Email</th>
                        <th>Cell Phone Number</th>
                        <th>Working Hours From</th>
                        <th>Working Hours To</th>
                      
                       
                       
                          <th>City</th>
                        <!-- <th>Form No.</th> -->
                       
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
             
                <tbody>@if($members)

                  @foreach($members as $member)

                    <tr>
                      <td  style="display: none"> {{$member->memberid}}</td>
                      <td>
                        @if(isset($permission["'edit_member'"]))
                        <a href="{{ url('memberProfile/'.$member->memberid) }}"class="edit" title="Edit"><i class="fa fa-eye"></i></a>

                        <a type="button" class="green"   data-toggle="modal" data-target="#modal-default"  onclick="asd('{{$member->mobileno}}')" title="Notification"><i class="fa fa-bell" aria-hidden="true"></i><input type="hidden" name="notification"  value="{{$member->mobileno}}" id="notofication"></a>

                        @endif
                      </td>
                  
                        <td>{{ucwords($member->firstname)}} {{ ucwords($member->lastname) }} </td>
                        <td> {{ $member->username }}</td>
                        <td> {{ $member->email }}</td>
                        <td> {{ $member->mobileno }}</td>
                 
                        <td> {{date('h-i a', strtotime($member->workinghourfrom)) }}</td>
                        <td>{{date('h-i a', strtotime($member->workinghourto)) }}</td>
                        
                        <td> {{ $member->city }}</td>
                       <!-- <td> {{ $member->FormNo }}</td>  -->
                     
                        <!-- <td> {{ $member->Birthday }}</td> -->
                       <!--  <td>
                            <a href="{{ url('editMember/'.$member->id) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>-->
                            <!-- <a href="{{ url('deleteuser/'.$member->id) }}"class="delete" title="Delete"><i class="fa fa-trash"></i></a> -->
                        <!--</td> -->
                   
                    </tr>
              @endforeach
              @endif
            </tbody>
            </table>
           <div class="datarender" style="text-align: center">
            
         
            {{ $members->appends($query)->links() }}
        </div></div>
<!-- /.box-body -->
          
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
                                                <i class="fa fa-comment"></i><br/><b>SMS</b>
                                              </a>       
                                            </div>
                                              <div class="col-md-4">
                                                <input type="checkbox" name=""  class="" value="1" id="emailcheck">
                                                <a class="btn btn-app" id="emaillinkcheck" onclick="emailcheck();">
                                                <i class="fa fa-envelope"></i><br/><b>Email</b>
                                              </a>
                                              </div>
                                              <div class="col-md-4">
                                                <input type="checkbox" name="" class="" value="1" id="callcheck">
                                                <a class="btn btn-app" id="calllinkcheck" onclick="callcheck();">
                                                <i class="fa fa-phone"></i><br/><b>Call</b>
                                              </a>
                                              </div>                                              
                                              </div> 
                                             
                                           
                                          </div>
                                          <div class="modal-footer">
                                           <!--  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
                                     
                                            <button id="notify" class="btn bg-blue" onclick="ss()"
                                            data-dismiss="modal">Save</button>

                                           </div>
                                        </div>
                                        <!-- /.modal-content -->
                                      </div>
                                     
                                      <!-- /.modal-dialog -->
                                      
                                    </div>
</div>
        </div>
 
      
   
    </div>

    </div>
  </div>

</div>

</section>
</div>
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
@endsection
@push('script')
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
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
           
                $("#success-alert").fadeOut(2000, 500).slideUp(500, function(){
               $("#success-alert").slideUp(500);
                });  
                });
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
<script type="text/javascript">
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
@endpush
