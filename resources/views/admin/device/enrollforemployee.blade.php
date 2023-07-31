@extends('layouts.adminLayout.admin_design')
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
@section('content')


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
  background-color: #f39c12;
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

.disabled {
   color: darkgrey;
   background-color: grey;
}
</style>

  <div class="content-wrapper">
   <form role="form" action="#" name="addmeasurment" method="POST" id="package_form">
  {{ csrf_field() }}
     
         <section class="content-header"><h2>Assign Card</h2></section>
          <!-- general form elements -->
           <section class="content">
          @if($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif

            @if(request()->route('id')) 
            @php 
            $i=request()->route('id');
            @endphp
            @else
             @php 
             $i='';
            @endphp
            @endif


            <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>

          <div class="box-body">
    <div class="col-lg-4">
      <label class="container">Search By Username
  <input type="radio" name="rbnNumber" class="btnGetValue" value="1" checked="">
  <span class="checkmark"></span>
</label>
     <!-- <input type="radio" name="rbnNumber" class="btnGetValue" value="1" /> Search By Username -->
     </div>
     <div class="col-lg-4">
          <label class="container">Search By Mobileno
  <input type="radio" name="rbnNumber" class="btnGetValue" value="2">
  <span class="checkmark"></span>
</label>


     </div>
   </div>
      <!-- /**********************start serachbyusername **********************/ --> 
    <div class="box-body" id="serachbyusername" style="display: none; margin-top: -20px;">  
 
      <div class="col-lg-4">

        <!-- <label>Username<span style="color: red">*</span></label> -->

       <select  name="selectusername" id="username1" class="form-control span11 selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Member" required="">
        <option value="" selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->userid }}"{{$user->userid  == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
        </select>
      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4">
 
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo1" class="form-control " disabled="" ><option value="" selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->userid }}"{{$user->userid  == $i?'selected':''}}>{{ $user->usermobileno }}</option>@endforeach
        </select>
    
<!-- /input-group -->
    </div>
    <br>

    <div class="col-lg-4" style="margin-top: -20px;">
      <div class="form-group">
       <button type="button" id="next1" class="btn bg-orange">Next</button>
      </div>
    </div>
  </div>

  <!-- /**********************end serachbyusername **********************/ --> 
   <!-- /**********************start serachbymobileno **********************/ --> 
     <div class="box-body" id="serachbymobileno" style="display: none; margin-top: -20px;"> 
 
      <div class="col-lg-4">
  
      
        <!-- <label>Username<span style="color: red">*</span></label> -->

       <select name="selectusername" id="username2"  class="form-control " disabled="" ><option value="" selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->userid }}"{{$user->userid  == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
        </select>
      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4" >
      
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo2" class="form-control selectpicker"title="Select Mobileno" data-live-search="true"  data-actions-box="true" ><option value="" selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->userid }}"{{$user->userid  == $i?'selected':''}}>{{ $user->usermobileno }}</option>@endforeach
        </select>

        <input type="hidden" id="joindate" name="">
        <input type="hidden" id="enddate" name="">
        <input type="hidden" id="dusername" name="">
        <input type="hidden" id="reassigncard" name="">
<!-- /input-group -->
    </div>
    <br>

    <div class="col-lg-4" style="margin-top: -20px;">
      <div class="form-group">
       <button type="button" id="next2" class="btn bg-orange">Next</button>
      </div>
    </div>
  </div>
  </div> 

      <div class="table-wrapper" style="display: none;" id="memberpackagedetails">
        <div class="table-title">

             <div class="box">
          <div class="box-header">
      <!--       <a href="{{ url('addrole') }}" class="bowercomponentscustomedarkbluebtn btn add-new bg-navy" style="height: 35px;"><i class="fa fa-plus"></i> Add New</a> -->

          <h3 class="box-title">Package Details</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body"><div class="col-lg-12">
            <div class="row">
              <table id="example1" class="table table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                   <tr>
                      <th>Package Name</th>
                      <th>Join Date</th>
                      <th>Expire Date</th>
                    </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                  </table>
                </div>
      <!-- /.box-body -->
                </div>
              </div>

          </div>
        </div>
      </div>
          
          <div class="mt-2 col-md-12" style="padding: 10px;"></div>

     

  <div class="box box-primary" style="display: none;" id="addmeasurment">
    <div class="row">

          <br/>
           <!--  <div class="col-lg-6 col-lg-offset-3">
                <select name="messagestemplate" id="messagestemplatename"  class="form-control selectpicker"title="Select Member"    data-actions-box="true">
                  <option selected disabled=""> Please choose an Option </option>
                    <option value="new">New</option>              
                    <option value="reassign">Reassign</option>                  
                </select>
               
          </div -->

          <div class="mt-2 col-md-12" style="padding: 10px;"></div>

          
          <div class="col-lg-3 col-lg-offset-1">
              <label><a href="#" class="btn bg-orange" id="setuser" style="width: 200px;height: 50px;"><b style="text-align: center;">Set User To Device</b></a></label>
          </div>

          <div class="col-lg-3">
              <label><a href="#" class="btn bg-orange" id="enrollcard" style="width: 200px;height: 50px;"><b style="text-align: center;">Enroll Card</b></a></label>

          </div>

          <div class="col-lg-3">
              <label><a href="#" class="btn bg-orange" id="eemb" data-toggle="modal" data-target="#modal-default" style="width: 200px;height: 50px;"><b style="text-align: center;">Extend Expiry</b></a></label>
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

                                <div class="row">
                                <div class="col-md-6 col-md-offset-1">
                                  <label>Set User Expiry</label>
                                </div>
                              </div>

                                <div class="row">
                                  <div class="form-group col-md-6 col-md-offset-1">
                                    <input type="date" onkeypress="return false" value="" id="setuserexpiry" class="form-control" name="sdate" required="" min="<?php echo date('Y-m-d') ?>">
                                  </div>
                                </div>
                              
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                                <a type="submit" id="setusersave" data-dismiss="modal"  class="btn  bg-green">Save</a>
                              </div>
                            </div>
                          </div>                     
                        </div>

          
          <div class="mt-2 col-md-12" style="padding: 10px;"></div>

        

      </div>
  </div>

              <!-- ============================================== -->

            <div class="box-body">
              
            </form>
          </div>
        </div>
              
<script type="text/javascript">
  $(document).ready (function(){
                $("#danger-alert").fadeTo(5000, 500).slideUp(500, function(){
               $("#danger-alert").slideUp(1000);
                });

  // $('#addmeasurment').css('display','none');
  // alert($('#username2').val());

    if ($('#username1').val() != '' || $('#username2').val() != '') {

      $('#next1').show();
    
  }
                           
 });
</script>

</section>
</div>
<script type="text/javascript">
 $( document ).ready(function() {

   if ($('#username1').val() == '' || $('#username2').val() == '') {

      $('#next1').hide();
      $('#next2').hide();
}

     var selValue = $('input[name=rbnNumber]:checked').val(); 
  if(selValue == 1){
          $('#serachbyusername').css('display','block');
          $('#serachbymobileno').css('display','none');
        }
        else if(selValue == 2 ){
          $('#serachbyusername').css('display','none');
          $('#serachbymobileno').css('display','block');
        }
    // $('#username').trigger('change');
     $('.btnGetValue').click(function() {
        var selValue = $('input[name=rbnNumber]:checked').val(); 
        // console.log(selValue);
        if(selValue == 1){
          $('#serachbyusername').css('display','block');
          $('#serachbymobileno').css('display','none');
        }
        else if(selValue == 2 ){
          $('#serachbyusername').css('display','none');
          $('#serachbymobileno').css('display','block');
        }
        // $('p').html('<br/>Selected Radio Button Value is : <b>' + selValue + '</b>');
    });
  });
  $('.btnGetValue').on('change',function(){
    clear_form_elements();
   $('#addmeasurment').css('display','none');
  });
</script>
 <script>
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
function clear_form_elements() {

  $('#addmeasurment').find(':input').each(function() {

    switch(this.type) {
        case 'password':
        case 'text':
        case 'textarea':
        case 'file':
        case 'select-one':
        case 'select-multiple':
        case 'number':
        case 'tel':
        case 'email':

            jQuery(this).val('');
            break;
        case 'checkbox':
        case 'radio':
        case 'select':
            this.selected =false;
            this.checked = false;
        $(this).closest('tr').find('[type=text]').attr("disabled", "disabled");
        // $('#scheme').find('option:not(:first)').remove();
        
            break;
    }
  });
  // $('#RecieptNo').val(s);
}
</script>
<script type="text/javascript">
  $('#username1').change(function(){

    $.ajax({
      url : '{{url("getuserajax")}}',
      type : 'GET',
      data : { _token:'{{ csrf_token() }}',uid:$('#username1').val()},
      success : function(data){
         // alert(data.userid);

        $('#mobileNo1').val(data.userid);
        $('#joindate').val(data.joindate);
        // $('#enddate').val(data.expiredate);
        $('#dusername').val(data.username);
        $('#next1').show();

        


      },
      dataType : 'json'
    });
  });

  $('#mobileNo2').change(function(){


    $.ajax({
      url : '{{url("getuserajax")}}',
      type : 'GET',
      data : { _token:'{{ csrf_token() }}',uid:$('#mobileNo2').val()},
      success : function(data){
        // alert(data.usermobileno);

        $('#username2').val(data.userid);
        $('#next2').show();
      },
      dataType : 'json'
    });
  });

$('#next1').on('click',function(){

    $('#memberpackagedetails').css('display','block');
    
    $.ajax({
        url : '{{url("userenrollstatus")}}',
        type : 'GET',
        data : { _token:'{{ csrf_token() }}',uid:$('#username1').val()},
        success : function(data){
           // alert(data.deviceusersid);

           // if (data.deviceusersid == null) {

           // }

           if (data != null) {

            $('#addmeasurment').css('display','block');

            var uid = data.muserid;
              $.ajax({
                url : '{{url("userenrollmemberpackagesdetails")}}',
                type : 'GET',
                data : { _token:'{{ csrf_token() }}',uid:uid},
                success : function(data){
                  // alert(data['maxex']);
                  var html="";
                  
                   $('#enddate').val(data['maxex']); 

                  $.each(data['packagedetails'], function(i, item) { 

                    var joindate = moment(item.joindate, "YYYY-MM-DD").format('DD-MM-YYYY');
                    var expiredate = moment(item.expiredate, "YYYY-MM-DD").format('DD-MM-YYYY');

                      html +='<tr><td>'+item.schemename+'</td><td>'+joindate+'</td><td>'+expiredate+'</td></tr>';
                  });

                    $('#tbody').empty();    
                    $('#tbody').html(html);
                   
                },
                dataType:'json'
              });
           }

           if (data == null) {

            $('#addmeasurment').css('display','none');

             var html="";
             html +='<tr><td colspan="2" style="text-align:center;font-weight: bold;">No Package Details Found!</td></tr>';
             $('#tbody').empty();    
             $('#tbody').html(html);

           }

          if (data.enroll == 1) {

            $('#setuser').addClass('disabled');
            $('#setuser b').css("color", "red");
            $('#enrollcard').removeClass('disabled');
            $('#enrollcard').html('<b>Reassign Card</b>');
            $('#reassigncard').val('reassigncard');
            $('#eemb').removeClass('disabled');
            $('#enrollcard b').css("color", "green");
            // $('#enrollcard').removeClass("bg-orange");
            // $('#enrollcard').css("background-color", "#00AD4C");

          }

          if (data.enroll != 1) {
            $('#setuser').removeClass('disabled');
            $('#enrollcard').addClass('disabled');
            $('#enrollcard b').css("color", "white");
            $('#setuser b').css("color", "white");
            $('#eemb').addClass('disabled');
          }

          if (data.status == 2) {
            $('#setuser').addClass('disabled');
            $('#enrollcard').removeClass('disabled');
            // $('#enrollcard').removeClass("bg-orange");
            $('#enrollcard b').css("color", "green");
            $('#setuser b').css("color", "red");
            $('#eemb').addClass('disabled');
          }
        },
        dataType:'json'
    });

    $('#enrollcard').click(function(){

      var specify = 'user';
      // alert($('#reassigncard').val());

   $.ajax({

        url : "{{url('enrolluserfromsummary')}}",
        type: "GET",
        data : {_token:"{{csrf_token()}}",userid:$('#username1').val(),specify:specify,reassigncard:$('#reassigncard').val()},
        success : function(data){

           if (data[0] != 0) {

            var specify = 'user';
            var userid = $('#username1').val();

            $.ajax({

            url : "{{url('enrollcardcomman')}}",
            type: "GET",
            data : {_token:"{{csrf_token()}}",userid:$('#username1').val(),specify:specify},
            success : function(data){

              alert('Enroll Successfuly').delay(50000);
              window.location.reload();

            },       
           });
          }

          if (data[0] == 0) {
            alert('Some Thing Wrong ! Please Enroll With Any Other Card !!');
            window.location.reload();
          }
        },
    });
});
     
  });

$('#setusersave').click(function(){

  if ($('#setuserexpiry').val() == '') {
    alert('Please Select Date !');
  }

  if ($('#setuserexpiry').val() != '') {

    var extendexpiry = 'extendexpirycomman';

    $.ajax({

        url : "{{url('extendexpiry')}}",
        type : "POST",
        data : {_token:"{{ csrf_token() }}",extendexpiry:extendexpiry,userid:$('#username1').val(),setextendexpiry:$('#setuserexpiry').val()},
        success: function(data){
          // alert(data);
          if (data == 'Success') {
            alert('Command Successfully! Expiry Is Set In Device After Some Time Base On Your Internet Speed !!');
          }
        }

    });
  }
});

$('#setuser').click(function(){

  var specify = 'user';

  // alert('hh');
  
  $.ajax({
        url : "{{url('setuserfromsummary')}}",
        type: "POST",
        data : { _token:"{{ csrf_token() }}",userid:$('#username1').val(),specify:specify,fusername:$('#dusername').val(),joindate:$('#joindate').val(),enddate:$('#enddate').val()},
        success : function(data){
        alert(data);
          
           
        },
    });

  // alert('puru');
  
});



$('#next2').on('click',function(){

  $('#memberpackagedetails').css('display','block');

   $.ajax({
        url : '{{url("userenrollstatus")}}',
        type : 'GET',
        data : { _token:'{{ csrf_token() }}',uid:$('#username2').val()},
        success : function(data){

          if (data != null) {


            $('#addmeasurment').css('display','block');

            var uid = data.muserid;
              $.ajax({
                url : '{{url("userenrollmemberpackagesdetails")}}',
                type : 'GET',
                data : { _token:'{{ csrf_token() }}',uid:uid},
                success : function(data){
                  // alert(data['maxex']);
                 
                  var html="";
                  
                   $('#enddate').val(data['maxex']); 

                  $.each(data['packagedetails'], function(i, item) { 

                    var joindate = moment(item.joindate, "YYYY-MM-DD").format('DD-MM-YYYY');
                    var expiredate = moment(item.expiredate, "YYYY-MM-DD").format('DD-MM-YYYY');

                      html +='<tr><td>'+item.schemename+'</td><td>'+joindate+'</td><td>'+expiredate+'</td></tr>';
                  });

                     $('#tbody').empty();
                    $('#tbody').append(html);
                   
                },
                dataType:'json'
              });
           }

            if (data == null) {

            $('#addmeasurment').css('display','none');

             var html="";
             html +='<tr><td colspan="2" style="text-align:center;font-weight: bold;">No Package Details Found!</td></tr>';
             $('#tbody').empty();    
             $('#tbody').html(html);

           }

          if (data.enroll == 1) {

            $('#setuser').addClass('disabled');
            $('#setuser b').css("color", "red");
            $('#enrollcard').removeClass('disabled');
            $('#enrollcard').html('<b>Reassign Card</b>');
            $('#reassigncard').val('reassigncard');
            $('#eemb').removeClass('disabled');
            $('#enrollcard b').css("color", "green");
          }

          if (data.enroll != 1) {
            $('#setuser').removeClass('disabled');
            $('#enrollcard').addClass('disabled');
            $('#enrollcard b').css("color", "white");
            $('#setuser b').css("color", "white");
            $('#eemb').addClass('disabled');
          }

          if (data.status == 2) {
            $('#setuser').addClass('disabled');
            $('#enrollcard').removeClass('disabled');
            // $('#enrollcard').removeClass("bg-orange");
            $('#enrollcard b').css("color", "green");
            $('#setuser b').css("color", "red");
            $('#eemb').addClass('disabled');
          }

          if (data.status == 3) {
            $('#eemb').removeClass('disabled');
          }

        },
        dataType:'json'
    });

       $('#enrollcard').click(function(){

        var specify = 'user';
        // alert($('#reassigncard').val());


       $.ajax({

            url : "{{url('enrolluserfromsummary')}}",
            type: "GET",
            data : {_token:"{{csrf_token()}}",userid:$('#username2').val(),specify:specify,reassigncard:$('#reassigncard').val()},
            success : function(data){
               // alert(data);

                 if (data[0] != 0) {

                  var specify = 'user';
                  var userid = $('#username2').val();

                 $.ajax({

                      url : "{{url('enrollcardcomman')}}",
                      type: "GET",
                      data : {_token:"{{csrf_token()}}",userid:$('#username2').val(),specify:specify},
                      success : function(data){

                        alert('Enroll Card Successfuly').delay(50000);
                        window.location.reload();
                   },       
                })
              }

              if (data[0] == 0) {
                alert('Some Thing Wrong ! Please Enroll With Any Other Card !!');
                window.location.reload();
             }
            },
        });
    });
  });


  $(function () {
    $('#example1').DataTable()
  });



</script>

@endsection