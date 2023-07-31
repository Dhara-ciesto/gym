@extends('layouts.adminLayout.admin_design')

@push('css')
<style type="text/css">
  .help-block{
    color: red;
  }
  .error{
    color: red;
  }


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
  background-color: #F6C968;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #F5B01B;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #F5B01B;
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
.pointer {
  cursor: pointer;
}
.tagcolor{
  background-color: #DF9A04;
  color: #fff;
}
.tagcolor:hover{
  color: #fff;
}
.scrollit {
    overflow:scroll;
    height:290px;
    width: 500px;
}
</style>
@endpush
@section('content')

<script type="text/javascript">
   $(document).ready(function(){
    $('#example1').DataTable();
   });
</script>
<!-- left column -->
  <div class="content-wrapper">
   
     
         <section class="content-header"><!-- <h2>Add Notification</h2> --></section>
          <!-- general form elements -->
           <section class="content">
          
           <!--    @if ($errors->any())
            <div class="alert alert-danger">
               <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif -->

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title"><b>Send SMS to Member</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> 
              <div class="col-lg-12">
                <div class="row">

                  <div class="col-lg-3">
                    <div class="input-group">
                    <label>Root Scheme</label>
                       <select name="selectusername" id="rootscheme"   multiple="multiple" class="form-control selectpicker"title="Select Root Scheme" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Root Scheme Name Selected" data-header="Root Scheme">
                          <!-- <option selected value="" disabled="">--Please choose an option--</option> -->
                          @foreach($rootscheme as $r)
                          <option value="{{$r->rootschemeid}}">{{ $r->rootschemename }}</option>
                          @endforeach
                        </select>
                  </div>
                </div>

                <div class="col-lg-3">
                    <div class="input-group">
                    <label>Scheme</label>
                       <select name="selectusername"  multiple="multiple" id="scheme"  class="form-control selectpicker" title="Select Scheme" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Schemes Selected" data-header="Select Scheme Template">
                          <!-- <option selected value="" disabled="">--Please choose an option--</option> -->
                          @foreach($scheme as $s)
                          <option value="{{$s->schemeid}}">{{ $s->schemename}}</option>
                          @endforeach
                        </select>
                  </div>
                </div>

                  

                

                <div class="col-lg-3">
                    <div class="input-group">
                    <label>From date</label>
                      <input type="date" class="form-control" id="fdate" name="fdate">
                  </div>
                </div>

                <div class="col-lg-3">
                    <div class="input-group">
                    <label>To date</label>
                      <input type="date" class="form-control" id="tdate" name="tdate">
                  </div>
                </div>
              </div>

              <div class="mt-2 col-md-12" style="padding: 10px;"></div>

              <div class="row">

                  <div class="col-lg-3">
                    <div class="input-group">
                    <label>Member Status</label>
                       <select name="mstatus" multiple="multiple" id="mstatus"  class="form-control selectpicker" title="Select Member Status" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Member Status">
                          <!-- <option selected value="" disabled="" >--Please choose an option--</option> -->
                          <option value="1">Active Member</option>
                          <option value="0">Deactive Member</option>
                          <option value="2">Freeze Member</option>
                          <option value="3">Cancel Member</option>
                          <option value="4">Expiry Member</option>
                      </select>
                  </div>
                </div>

                <div class="col-lg-3">
                    <div class="">
                    <label>Tags</label>
                       <select multiple="multiple" id="smstag" class="form-control selectpicker" title="Select Tags" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Tags By Name">
                          <!-- <option value="" disabled="" >--Please choose an option--</option> -->
                          @foreach($tags as $t)
                            <option value="{{$t->exerciselevelid}}">{{$t->exerciselevel}}</option>
                          @endforeach
                      </select>
                  </div>
                </div>

               <!--  <div class="col-lg-3">
                    <div class="form-group">
                    <label>Tages</label>
                       <select class="form-control" id="smstag" multiple="multiple" class="form-control selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Notification Template">
                          <option selected value="">--Please choose an option--</option>
                          @foreach($tags as $t)
                            <option value="{{$t->exerciselevelid}}">{{$t->exerciselevel}}</option>
                          @endforeach
                        </select>
                  </div>
                </div> -->

                <div class="col-lg-2">
                    <div class="input-group">
                      <label class="container">Male
                        <input type="checkbox" name="smsgender" class="smsgender" id="smsmale" value="male">
                        <span class="checkmark"></span>
                      </label>
                  </div>
                </div>

                <div class="col-lg-2">
                    <div class="input-group">
                      <label class="container">Female
                        <input type="checkbox" name="smsgender" class="smsgender" id="smsfemale" value="female">
                        <span class="checkmark"></span>
                      </label>
                  </div>
                </div>

                <div class="col-lg-2">
                    <button class="btn btn-block bg-green" id="search">Search</button>
                    <button  class="btn btn-danger btn-block" id="clear">Clear</button>
                </div>
                
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6" id="allmembers">
            <div class="box box-primary">

                <div class="box-header with-border">
                  <h3 class="box-title">Member List &nbsp; &nbsp; &nbsp;</h3>
                   <label>
      <input type="checkbox"  name="uncheckall" class="uncheckall" id="uncheckall" checked="">Check All/Uncheck All
    </label>
     <!--  <label>
      <input type="checkbox" class="checkall" id="checkAll">Check All
    </label>
           -->      </div>

                <div class="box-body"> 
                  <div class="table-responsive" id="memberlist" style="overflow-y: scroll;">
                    <table id="example1" class="table">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>MobileNo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody"></tbody>
                      </table>

                  </div>
                </div>
            </div>
          </div>

          <div class="col-lg-6" id="messagebox">
            <div class="box box-primary">

                <div class="box-header with-border">
                  <h3 class="box-title">Message</h3>
                </div>

                <!-- <div class="box-header with-border pull-right">
                  <h3 class="box-title">Notification For</h3>
                </div> -->

                <div class="box-body">

                  <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                      <select name="messagestemplate" id="messagestemplatename"  class="form-control messagebox selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Notification Template"><option selected disabled=""> Please choose an Template </option>
                          @foreach($message as $m)
                          <option value="{{ $m->messagesid }}">{{ ($m->subject) }}</option>
                          @endforeach
                          </select>
                          <input type="hidden" name="msgid" id="msgid">
                    </div>
                  </div>

                  <div class="mt-2 col-lg-12" style="padding: 10px;"></div>


                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-10 col-lg-offset-1">
                        <span id="rchars">250</span> Character(s) Remaining
                        <textarea class="form-control messagebox" rows="5" id="textareasmsotp" maxlength="250" style="resize: none;"></textarea>
                      </div>
                    </div>


                 <!--    <div class="col-lg-4">
                        <div class="row">
                          <div class="col-lg-3">
                            <label class="container">SMS
                              <input type="checkbox" name="generalfitness" id="otpcsms">
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3">
                            <label class="container">Email
                              <input type="checkbox"  name="fatloss" id="otpcemail">
                              <span class="checkmark"></span>
                            </label>
                          </div>
                      </div>
                    </div> -->

                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-12 col-lg-offset-1">

                                      <div class="table-responsive">
                                                  <table>
                                          <tbody>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor messagebox margin ">[FirstName]</div></td>
                                              <td><div class="smstag pointer btn tagcolor messagebox margin">[LastName]</div></td>
                                            </tr>
                                          
                                          </tbody>
                                        </table>
                                      </div>
                <!--         <div class="col-lg-3">
                          <div class="smstag pointer btn tagcolor messagebox btn1"><b>[FirstName]</b></div>
                        </div>
                       <div class="col-lg-3">
                         <div class="smstag pointer btn tagcolor messagebox btn1"><b>[LastName]</b></div>
                       </div> -->
                       <!-- <div class="col-lg-3">
                         <div class="smstag pointer btn tagcolor"><b>[schemename]</b></div>
                       </div> -->
                     <!-- <div class="col-lg-3">
                       <div class="smstag pointer btn tagcolor"><b>[other]</b></div>
                     </div> -->
                  </div>
                </div>
                <input type="hidden" id="response" name="response[]">
                <input type="hidden" id="failres" name="failres[]">
                <input type="hidden" id="demo" name="demo">

                <div class="row">
                  <div class="form-group">
                    <div class="mt-2 col-lg-12" style="padding: 10px;"></div>
                      <div class="row">
                        <center>
                            <button class="btn bg-green margin  messagebox" id="sendsmsuser">Send</button>
                        
                            <button class="btn btn-danger margin messagebox" id="canclebtn">Cancel</button>
                     </center>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
 

//
</script>
<script type="text/javascript">

  $('#search').click(function(){
    var rootschemeid = $('#rootscheme').val();
    var schemeid = $('#scheme').val();
    var mstatus = $('#mstatus').val();
    var smstag = $('#smstag').val();
    var fdate = $('#fdate').val();
    var tdate = $('#tdate').val();
    var smsfemale=$("#smsfemale" ).prop('checked');
    var smsmale= $( "#smsmale" ).prop('checked');
        // alert(mstatus);
 
    
      $.ajax({
        type:'get',
        url : '{{url("smssearch")}}',
        data : {  _token:'{{ csrf_token() }}',rootschemeid:rootschemeid,schemeid:schemeid,mstatus:mstatus,smsmale:smsmale,smsfemale:smsfemale,smstag:smstag,fdate:fdate,tdate:tdate},
        success : function(data){

          if (data == "1") {

            alert('No Data Found !');
            $('#messagebox').hide();
              $('#allmembers').hide();

            $('#tbody').empty();
             
          }

          if (data != "1") {

            $('#messagebox').show();
            $('#allmembers').show();
          }      
          

         var html="";
             $.each(data, function(i, item) { 
              // $.each(item, function(i1, item1) { 
               //alert(item.email);
               
                   html +='<tr><td><input class="check" type="checkbox" checked id="ajaxmlist'+i+'" value="'+item.firstname+'"></td><td>'+item.firstname+'</td><td>'+item.lastname+'</td><td>'+item.mobileno+'</td><input type="hidden" id="mobileno'+i+'" value="'+item.mobileno+'"><input type="hidden" id="lastname'+i+'" value="'+item.lastname+'"><input type="hidden" id="memail'+i+'" value="'+item.email+'"></tr>';
                 
                   
            });


             $('#tbody').empty();
                 
          $('#tbody').html(html);


   $(function () {
            $("#uncheckall").on("click", function () {
                var all = $(this);
                $('input:checkbox').each(function () {
                    $(this).prop("checked", all.prop("checked"));
                });
            });
        });

// $('.uncheckall').click(function() {
//                  $(":checkbox").attr("checked", false);
//              });

// $('.checkall').click(function() {
//                  $(":checkbox").attr("checked", true);
//              });
                //  $("#checkAll").click(function () {
                //     $('#ajaxmlist'+i).prop('checked', $(this).prop('checked'));
                // });
       },
        dataType:"json",
    });
      
  });

$('#sendsmsuser').click(function(){
    //var i = 0;
var table = document.getElementById("tbody");

var dx = [];
var failres = [];
  var res=[];
     var total = 0;
  var res1=[];
var response=0;
    for (var i = 0, row; row = table.rows[i]; i++) 
    {
     
                      var textareasmsotp = $('#textareasmsotp').val();

                      var ajaxmlistcheck = $('#ajaxmlist'+i+'').prop('checked');
                      var ajaxmlist = $('#ajaxmlist'+i+'').val();
                      var mobileno = $('#mobileno'+i+'').val();
                      var memail = $('#memail'+i+'').val();
                      var lastname = $('#lastname'+i+'').val();

                      // alert(lastname);
                      //var mobileno = ajaxmlist.replace(/\D/g, "");
                         

                      if (ajaxmlistcheck == true)
                       {
                        
                     $.ajax({
                      type:'post',
                      url : '{{url("sendsmsuser")}}',
                      data : {  _token:'{{ csrf_token() }}',ajaxmlist:ajaxmlist,textareasmsotp:textareasmsotp,mobileno:mobileno,memail:memail,lastname:lastname},
                      success : function(data)
                      {
                     //   console.log(data);
                        if(data)
                        {
                              if(data == 'Success')
                              {
                                      total=total+1;     
                             $('#demo').val(total);
                               
                              }
                         else if(data == 'Failure')

                         {
                           failres.push(data);
                         }
                      
                   }
                         else

                         {
                          failres.push(data);
                         }

                        res1=$('#failres').val(failres);
                         response=$('#demo').val();

                       //   res1=$('#response').val();
                     var count=$('#demo').val();
                     
                        },
                        
                      });
                      
   
             call(count);
                  }
               
               // console.log('count'+count);
                  }
                     
                  
               });


function call(count){
   // console.log(res);
    //console.log($('#response').val());
  alert(count+' '+"Messages are successfully Send");
  // window.location.reload();
}
// alert(count+' '+"Messages are successfully Send");


$(document).ready(function(){
    $('#sendsmsuser').prop('disabled', true);
    // $(".messagebox").attr('disabled','disabled');
    $('#messagebox').hide();
   $('#allmembers').hide();
    // $('.btn1').hide();
});



  
$(".smstag").click(function(){
        var txt = $.trim($(this).text());
        var box = $('textarea');
        box.val(box.val() + txt);
      });

 var maxLength = 250;
        $('#textareasmsotp').keyup(function() {
          var textlen = maxLength - $(this).val().length;
          $('#rchars').text(textlen);
          if ($('#textareasmsotp').val().length > 0) {
            $('#sendsmsuser').prop('disabled', false);
          }else{
            $('#sendsmsuser').prop('disabled', true);
          }
        });
        
  $('#canclebtn').click(function(){
      $('#textareasmsotp').val('');
      $('#rchars').text(maxLength);

  });

  $('#clear').click(function(){
    window.location.reload();
  });

  $('#messagestemplatename').change(function(){

        $.ajax({
        url : '{{url("getsmsdata")}}',
        typle: 'get',
        data : {_token:'{{ csrf_token() }}',msgid:$('#messagestemplatename').val()},
        success : function(data){
          // alert(data.message);
           $('#textareasms').val('');
       $('#textareasmsotp').val(data.message);
       $('#textareasmsotp').trigger('keyup');

          // $('#textareasmsotp').html(data.message);
          $('#msgid').val(data.messagesid);

          if ($('#textareasmsotp').val().length > 0) {
             $('#sendsmsuser').prop('disabled', false);
          }else{
            $('#sendsmsuser').prop('disabled', true);
          }

        },
         dataType:'json',
    });

     });
  // $('#rootscheme').change(function(){

  //   $.ajax({
  //       type:'get',
  //       url : '{{url("smsrootschemes")}}',
  //       data : {_token:'{{ csrf_token() }}',rootschemeid:$('#rootscheme').val()},
  //       success : function(data){
  //          // alert(data);
  //         var html="";
  //            $.each(data, function(i, item) { 
  //             $.each(item, function(i1, item1) { 
  //             // alert(item1.member.firstname);
  //                  html +='<tr><td>'+item1.member.firstname+'</td></tr>';
  //               });
  //           });
  //            $('#tbody').empty();
  //         $('#tbody').html(html);

  //       },
  //       dataType:"json",
  //   });
  // });

  //   $('#scheme').change(function(){

  //   $.ajax({
  //       type:'get',
  //       url : '{{url("smsschemes")}}',
  //       data : {_token:'{{ csrf_token() }}',schemeid:$('#scheme').val()},
  //       success : function(data){
          
  //         var html="";
  //            $.each(data, function(i, item) { 
  //             $.each(item, function(i1, item1) { 
  //             // alert(item1.member.firstname);
  //                  html +='<tr><td>'+item1.member.firstname+'</td></tr>';
  //               });
  //           });
  //            $('#tbody').empty();
  //         $('#tbody').html(html);

  //       }, 
  //       dataType:"json",
  //   });
  // });

  //   $('#mstatus').change(function(){

  //     $.ajax({
  //       type:'get',
  //       url : '{{url("smsmemberstatus")}}',
  //       data : {_token:'{{ csrf_token() }}',mstatus:$('#mstatus').val()},
  //       success : function(data){

  //         var html="";
  //            $.each(data, function(i, item) {
  //             // alert(item.firstname);

  //             html +='<tr><td>'+item.firstname+'</td></tr>';

  //            });
  //            $('#tbody').html(html);
  //       },
  //       dataType:"json",
          
  //     });
  //   });

     // $('#smsmale').click(function(){
     //  // $('#tbody').empty();
     //    var inputValue = $(this).attr("value");
     //    $("." + inputValue).toggle();

     //    if (this.checked){ 
     //    $.ajax({
     //    type:'get',
     //    url : '{{url("smsgender")}}',
     //    data : {_token:'{{ csrf_token() }}',smsgender:inputValue},
     //    success : function(data){
     //      var html="";
     //         $.each(data, function(i, item) {
     //          // alert(item.firstname);

     //          html +='<tr><td>'+item.firstname+'</td></tr>';

     //         });
     //         $('#tbody').append(html);
          
     //    },
     //      dataType:"json",  
     //  });
     //  }
     //  else
     //  {
     //    $('#tbody').empty();
     //  } 
        
     //  });
     // $('#smsfemale').click(function(){
     //  // $('#tbody').empty();
     //    var inputValue = $(this).attr("value");
     //    $("." + inputValue).toggle();

     //    if (this.checked){ 
     //    $.ajax({
     //    type:'get',
     //    url : '{{url("smsgender")}}',
     //    data : {_token:'{{ csrf_token() }}',smsgender:inputValue},
     //    success : function(data){
     //      var html="";
     //         $.each(data, function(i, item) {
     //          // alert(item.firstname);

     //          html +='<tr><td>'+item.firstname+'</td></tr>';

     //         });
     //         $('#tbody').append(html);
          
     //    },
     //      dataType:"json",  
     //  });
     //  } 
     //  else
     //  {
     //    $('#tbody').empty();
     //  }
        
     //  });


     // $('#smstag').change(function(){


     //  $.ajax({
     //    type:'get',
     //    url : '{{url("smstag")}}',
     //    data : {_token:'{{ csrf_token() }}',smstag:$('#smstag').val()},
     //    success : function(data){

     //      var html="";
     //         $.each(data, function(i, item) {
     //           // alert(item.firstname);

     //          html +='<tr><td>'+item.firstname+'</td></tr>';

     //         });
     //         $('#tbody').html(html);
     //    },
     //    dataType:"json",
          
     //  });

     // });

     // $('#fdate').change(function(){
     //  alert($('#fdate').val());
     // });

     // $('#tdate').change(function(){
     //  alert($('#tdate').val());
     // });


</script>                    
@endpush