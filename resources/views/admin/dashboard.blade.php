@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

<link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script data-require="datatables@*" data-semver="1.10.12"
  src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
  .red {
    color: red;
  }

  a {
    color: #131313;
  }

  .green {
    color: green;
  }

  .info-box-icon {
    height: 110px;
    width: 100px;
  }

  .info-box-text {
    margin-left: 5px;
    text-transform: none;
    */
  }

  .call {
    color: #7758EE;
  }

  .label {
    font-size: 85%;
  }

  table,
  th,
  td {
    padding: 5px;
  }

  .ui-state-active,
  .ui-widget-content .ui-state-active,
  .ui-widget-header .ui-state-active,
  a.ui-button:active,
  .ui-button:active,
  .ui-button.ui-state-active:hover {
    border: 1px solid #003eff;
    background: #97a0b3;
    font-weight: normal;
    color: #000;
    border-color: #97a0b3;
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 style="text-decoration: none">
      Dashboard
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Dashboard</li>
    </ol>
  </section>

  <script type="text/javascript">
    $(document).ready( function () {
    $('#contractdata').DataTable();
} );
  </script>
  <!-- Main content -->

  <section class="content">


  </section>
</div>


<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-euro.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  function emailafterpacsdck(invoiceid,userid)
    {
    var invoiceid=invoiceid;
    var userid=userid;

    $.ajax({
        url : "emailafterpack",
        type: "POST",
        data : {_token:"{{csrf_token()}}",invoiceid:invoiceid,userid:userid},
        success : function(data){
         if(data == true){
          alert('SMS SuccessFully Send');
         }
        },
    });

           alert('SMS and Email Send');

  }
    $( "#project" ).autocomplete({
      minLength: 0,
      source: function( request, response )
        {
        var typehead=$('#project').val();
         var _token = $('input[name="_token"]').val();
              $.ajax({
                url:"{{ url('loaduserbytype') }}",
                method:"GET",
                data:{typehead:typehead, _token:_token},
                dataType: "json",
                // a jQuery ajax POST transmits in querystring format in utf-8
                     //return data in json format
                  success: function( data )
                    {
                        response( $.map( data, function( item)
                        {
                              var userstatus='';
                              if(item.status==1){ userstatus='Active';}
                              else{ userstatus='Deactive'; }
                          // console.log(item.userid);
                              return{
                                    label: item.username,
                                    value: item.userid,
                                     desc:userstatus,
                                      icon: "jquery_32x32.png"

                                   }
                        }));
                    }
                });
          },
      focus: function( event, ui ) {
        $( "#project" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#project" ).val( ui.item.label );
        $( "#project-id" ).val( ui.item.value );
        var userstatus='';
        if(ui.item.status==1){
          userstatus='Active';
        }else{
          userstatus='Deactive';
        }
        // $( "#project-description" ).html( userstatus );
        // $( "#project-icon" ).attr( "src", "images/" + ui.item.userid );

        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div style='overflow-y:auto;'>" + item.label + "<br>" + item.desc + "</div>" )
        .appendTo( ul );
    };

 $(document).ready(function () {
   $('#project').keyup(function(e){
    if(e.keyCode == 13)
    {
       userid=$( "#project-id" ).val();
       username=$( "#project" ).val();
        opendiv(userid,username);
    }
  });
});
function userload(){
  var typehead=$('#typehead').val();
  var _token = $('input[name="_token"]').val();
  if(typehead.length > 1){


   $.ajax({
      url:"{{ url('loaduserbytype') }}",
      method:"GET",
      data:{typehead:typehead, _token:_token},
      success:function(result)
      {
        var ap='';
        data=result;
        if(data){
          $('#useroptions').empty();

         $.each(data,function(item,i){
          ap+='<li class="li" style="border:1px solid; border-color:white; margin:5px;"><a id="'+i.userid+'" onclick="opendiv(' +i.userid+  ',\'' + i.username + '\')"><div class="item"><i class="fa fa-user margin" aria-hidden="true"></i> ' +i.username+  ' <span lass="pull-right"></span><div class="details d-inline pull-right margin ';
          if(i.status == 1) {
            ap+=' activeColor">';
          }
          else{
             ap+= 'deactiveColor">';
          }

          if (i.status == 1) {
            ap+=' Active';
          }
          else{
             ap+=' Deactive';
          }
          ap+='</div></div></a></li>';
         })

         $('#useroptions').append(ap);
         $('#useroptions').show();

         // $('#useroptions').FadeIn();


        }

      }
     });
    }
  }
  // var keycode = (window.event) ? event.keyCode : e.keyCode;
  //          if (keycode == 9)
  //          alert('tab key pressed');

function opendiv(userid,username){


    var _token = $('input[name="_token"]').val();
   $.ajax({
      url:"{{ url('loaduserprofile') }}",
      method:"GET",
      data:{userid:userid, _token:_token},
      success:function(result)
      {

          var userview=result;
          var userprofile='<div class="userprofile"><center><img';
          if (userview.photo != null) {
            userprofile+=' src="/files/'+userview.photo+'"';
          }else{
            userprofile+=' src="/files/default.png"';
          }
          userprofile+=' name="aboutme" id="profile" width="140" height="140" border="0" class="img-circle"><h3 class="media-heading">'+userview.firstname[0].toUpperCase()+userview.firstname.slice(1)+' '+userview.lastname[0].toUpperCase()+userview.lastname.slice(1)+'';
           if (userview.city != null) {
            userprofile+='(' +userview.city+ ')';
          }
          if (userview.professional != null) {
            userprofile+='<br>Professional:' +userview.professional;
          } userprofile+='<br><small>'; if (userview.status == 0) {
            userprofile+='Deactive';
          }if (userview.status == 1) {
            userprofile+='Active';
          }
          if (userview.status == 2) {
            userprofile+='Freeze';
          }



          userprofile+='</small></div><div class="nav-tabs-custom"><ul class="nav nav-tabs nav-justified"><li  class="active"><a href="#day" data-toggle="tab" id="inq">Packages</a></li><li><a href="#month" data-toggle="tab" id="reg">Fetch Logs</a></li><li><a href="#year" data-toggle="tab" id="ftstep"></a></li></ul><div class="tab-content"><div class="tab-pane active" id="day">';

          userprofile+='</h3><span></span></center><ul style=" margin-left:12px;">';
          userprofile+='<table class="table"><thead><th>Package</th><th>Joindate</th><th>Expiredate</th><th>Print</th><thead><tbody>';
          if(userview.packages){
              $.each(userview.packages,function(item,i){
              let current_datetime = new Date(i.joindate)
              let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
              let current = new Date(i.expiredate)
              let formatted = current.getDate() + "-" + (current.getMonth() + 1) + "-" + current.getFullYear();
              userprofile+='<tr><td>'+i.schemename+'</td><td>'+formatted_date+'</td><td>'+formatted+'</td><td><a href="transactionpaymentreceipt/'+i.memberpackagesid+'/'+userview.mobileno+'")}}"><i class="fa fa-print margin"></i></a><a id="emailafterpack"    onclick="return emailafterpacsdck('+i.memberpackagesid+','+userid+');" class="red"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></td></tr>';

            });
            userprofile+='</tbody></table></ul></div>';
          }
          userprofile+='<div class="tab-pane" id="month"><table class="table">'+
                                 '<thead>'+
                                    '<tr>'+
                                      '<th>#</th>'+
                                      '<th>PunchDate</th>'+
                                      '<th >PunchTime</th>'+
                                    '</tr>'+
                                 '</thead>'+
                                 '<tbody id="fetchlogtbody">';
          if(userview.logs){
            $.each(userview.logs,function(item,i){
              let current_datetime = new Date(i.PunchDateTime)
              let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
              let current = new Date(i.PunchDateTime);
              var hours = current.getHours();
              var minutes = current.getMinutes();
              var seconds = current.getSeconds();

              userprofile+='<tr><td>'+userid+'</td><td>'+formatted_date+'</td><td>'+hours+':'+minutes+':'+seconds+'</td></tr>';

            });

          }

          userprofile+='</tbody></table></div><div class="tab-pane" id="year"></div></div>';

          $('.userprofile').empty();
          $('#headermodal').empty();
          $('#search-bar').empty();
          $('#search-bar').append(userprofile);
          $('#menus').empty();
          if(userview.status!=1){
             $('.userprofile').after('<form action="Printconsentform" class="form-inline"><a href="assignPackageOrRenewalPackage/'+userid+'"class="btn bg-orange margin"><i class="fa fa-users"></i>  Assign Package</a><a href="addMeasurement/'+userid+'"class="btn bg-orange margin disabled"><i class="fa fa-plus"></i>  Add Measurment</a><a href="assigndiettomember/'+userview.memberid+'"class="btn bg-orange margin disabled"><i class="fa fa-cutlery"></i>   Assign Diet</a><a href="assignExercise/'+userview.memberid+'"class="btn bg-orange margin disabled"><i class="fa fa-cutlery"></i>   Assign Workout</a><input type="hidden" name="firstname" value="'+userview.firstname+'" ><input type="hidden" name="lastname" value="'+userview.lastname+'" ><input type="hidden" name="memberid" value="'+userview.memberid+'" ><input type="hidden" name="phone" value="'+userview.mobileno+'" ><input type="hidden" name="email" value="'+userview.email+'" ><button type="submit" disabled class="btn bg-orange margin"><i class="fa fa-print"></i> Print consentform</button></form>');
           }else{
             $('.userprofile').after('<form action="Printconsentform" class="form-inline"><a href="assignPackageOrRenewalPackage/'+userid+'"class="btn bg-orange margin"><i class="fa fa-users"></i>  Assign Package</a><a href="addMeasurement/'+userid+'"class="btn bg-orange margin"><i class="fa fa-plus"></i>  Add Measurment</a><a href="assigndiettomember/'+userview.memberid+'"class="btn bg-orange margin"><i class="fa fa-cutlery"></i>   Assign Diet</a><a href="assignExercise/'+userview.memberid+'"class="btn bg-orange margin"><i class="fa fa-cutlery"></i>  Assign Workout</a><input type="hidden" name="firstname" value="'+userview.firstname+'" ><input type="hidden" name="lastname" value="'+userview.lastname+'" ><input type="hidden" name="memberid" value="'+userview.memberid+'" ><input type="hidden" name="phone" value="'+userview.mobileno+'" ><input type="hidden" name="email" value="'+userview.email+'" ><button type="submit" class="btn bg-orange margin"><i class="fa fa-print"></i> Print consentform</button></form>');
           }


          $('#headermodal').append('<h4>'+userview.firstname[0].toUpperCase()+userview.firstname.slice(1)+'  '+userview.lastname[0].toUpperCase()+userview.lastname.slice(1)+'</h4>');
      }
     });

    $('#useroptions').hide();
    $('#typehead').val(username);
    if(username){
      // alert(username);
       $('#checkuser').trigger('click');
    }
   };
</script>
<script type="text/javascript">
  $(function () {
    $('#package').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });
    $('#duepayment').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });

    $('#packageexpire').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
        "info": false,
        order: [[2, 'asc']],
      });
    $('#clientsrenewal').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });
    $('#measurementpending').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false,


    });
    $('#membersession').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });


});

</script>
@endsection