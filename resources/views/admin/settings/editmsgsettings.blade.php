@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" type="text/css" href="../css/style.css">
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Edit SMS/Email Settings</h2></section>
 -->          <!-- general form elements -->
           <section class="content">
 

 
       @if(count($errors)>0)
      <ul>
        @foreach($errors->all() as $error)
        <li class="alert alert-danger">{{$error}}</li>
        @endforeach
      </ul>
      @endif
       <script type="text/javascript">
        $(".alert-danger").fadeTo(3000, 500).slideUp(500, function(){
        $(".alert-danger").slideUp(500);
        });
      </script>
    <div class="table-wrapper">
    <div class="table-title">

  <div class="box">
    <div class="box-header">
      <!-- <a href="{{ url('addterms') }}" class="btn add-new bg-navy"><i class="fa fa-plus"></i>Add New</a> -->


    <h3 class="box-title">Edit SMS/Email Settings</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     <div class="col-lg-3"></div>
     <div class="col-lg-12">
      <div class="row">
        <div class="col-sm-12">

          <div class="col-lg-6 col-lg-offset-3">
             <select name="logs" id="messagessetting"  class="form-control">
                <option selected disabled="">--Please choose an option--</option>
                <option value="sms">SMS Settings</option>
                <option value="email">Email Settings</option>
              </select>
          </div>

          <div class="mt-2 col-md-12" style="padding: 10px;"></div>

          <!-- <div id="smsdiv">

            @if($edit)
            <div class="row">
                <div class="col-lg-2 col-lg-offset-1"><label>Select Domain :</label></div> 
                <div class="col-lg-6 col-lg-offset-3">
                 <select name="domainname" id="domainname"  class="form-control">
                    <option selected disabled="">--Please Select Domain --</option>
                    @foreach($edit as $edit)
                      <option value="{{$edit->smssettingid}}">{{$edit->domailname}}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            @endif

          </div> -->

          <!-- <div class="mt-2 col-md-12" style="padding: 10px;"></div> -->

          <div id="editsmsdiv">

            <div class="row col-lg-offset-1">
              <label><h4><b>Edit Sms Settings</b></h4></label>
          </div>

          <div class="well row col-lg-10 col-lg-offset-1 from-group">
           <form action="{{url('editsmssettings')}}" method="post">                     
            {{ csrf_field() }}

            <input type="hidden" name="hid" id="hid" value="">

            <div class="row">
              <div class="col-lg-5"><label>URL :</label></div>
              <div class="col-lg-5"><input type="text" class="form-control" name="url" id="domailnameurl"></div>
            </div>

            <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Parameter & value For Mobile :</label></div>
              <div class="col-lg-2"><input type="text" class="form-control" id="pfmobile" name="pfmobile" placeholder="Set Parameter For Mobile" value="mobiles"></div>
              <div class="col-lg-3"><input type="text" class="form-control" id="vfmobile" name="vfmobile" placeholder="Set Parameter For Mobile" value="8200406933"></div>
            </div>

             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Parameter & value For Message :</label></div>
              <div class="col-lg-2"><input type="text" class="form-control" name="pfmessage" placeholder="Set Parameter For Message" value="message"></div>
              <div class="col-lg-3"><input type="text" class="form-control" name="vfmessage" placeholder="Set Parameter For Message" value="Message" ></div>
            </div>

            <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Status</label></div>
              <div class="col-lg-5">
                <select name="urlstatus" class="form-control">
                  <option value="Active" id="ac">Active</option>
                  <option value="Deactive" id="dac">Deactive</option>
                </select>
              </div>
            </div>

            <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Add Parameter Name :  </label></div>
              <div class="col-lg-5"><label>Add Parameter Value : </label></div>
            </div>

             <div class="mt-2 col-md-12" style="padding: 10px;"></div>
             <input type="hidden" name="i" id="i" value="0">


            <div class="row">
              <div id="item">
              <div class="col-lg-5"><input type="hidden" class="form-control" name="addpn" id="addpn" placeholder="Set User Name parameter"></div>
              <div class="col-lg-5"><input type="hidden" class="form-control" name="addv" placeholder="Set User Name parameter"></div>
              </div>
              <div class="col-lg-2" id="button"><i class="fa fa-plus-circle btn bg-green"></i></div>
            </div>
            

            <div class="mt-2 col-md-12" style="padding: 10px;"></div>


            <!-- <div class="row">
              <div class="col-lg-5"><label>Password Parameter:</label></div>
              <div class="col-lg-5"><input type="text" class="form-control" name="password" placeholder="Set Password Paramter"></div>
            </div> -->

            <!-- <div class="mt-2 col-md-12" style="padding: 10px;"></div> -->

            <!-- <div class="row">
              <div class="col-lg-5"><label>Set Route Parameter:</label></div>
              <div class="col-lg-5"><input type="text" class="form-control" name="routename" placeholder="Set Route"></div>
            </div>
 -->
            <!-- <div class="mt-2 col-md-12" style="padding: 10px;"></div> -->

            <!-- <div class="row">
              <div class="col-lg-5"><label>Set Route No :</label></div>
              <div class="col-lg-5"><input type="text"  maxlength="2" minlength="0" name="routeno" class="form-control number" name="" placeholder="Set Route No"></div>
            </div>

             <div class="mt-2 col-md-12" style="padding: 10px;"></div>
 -->
             <div class="row">
              <div class="col-lg-3 col-lg-offset-3">
                <button class="form-control bg-green btn-block" id="savesmssettings" >Save Changes</button>
                <!-- data-toggle="modal" data-target="#modal-smsurl" -->
              </div>
            </div>
          </form>
        </div>
      </div>

            
           <div id="emaildiv">

            <div class="row col-lg-offset-1">
              <label><h4><b>Email Settings</b></h4></label>
            </div>

            <div class="row table-responsive col-lg-offset-1">
            <table class=".table-hover">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><div class="well"><label>Header</label></div></td>
                  <td><div class="well col-lg-offset-1"><input type="text" class="form-control" name="hearder" placeholder="Enter Header" title="Enter Header" id="heardername"></div></td>
                  <!-- <td><div class="well col-lg-offset-1"><label href="#"><a id="hearderchange">Change</a></label></div></td> -->
                </tr>

                <tr>
                  <td><div class="well"><label>Sender Email ID</label></div></td>
                  <td><div class="well col-lg-offset-1"><input type="text" required="Email" class="form-control" name="senderemailid" placeholder="Enter Defalut Sender Email" id="senderemailid" title="Enter Defalut Sender Email"></div></td>
                  <!-- <td><div class="well col-lg-offset-1"><label href="#"><a>Change</a></label></div></td> -->
                </tr>

                <tr>
                  <td><div class="well"><label>Status</label></div></td>
                  <td><div class="well col-lg-offset-1">
                    <select class="form-control" name="emailstatus" id="emailstatus">
                      <option value="1">Active</option>
                      <option value="0">Deactive</option>
                    </select>
                  </td>
                </tr>

            </tbody>
            </table>
          </div>

            <div class="row">
              <div class="col-lg-3 col-lg-offset-3">
                <button class="form-control bg-green  btn-block" id="saveemailsettings">Save email setting</button>
              </div>
            </div>

            </div>
          </div>
        </div>
    </div>

    </div>
  </div>

</div></div>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    // $.ajax({
    //   url : '{{url("smsbalance")}}',
    //   type : 'get',
    //   data : {_token:'{{ csrf_field() }}'},
    //   success : function(data){

    //     // alert(data.balence);

    //     $('#transationbalance').html(data.balence);

    //   },
    //   dataType:'json',
    // });
  });

     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                file = input.files[0];

                 if (file.size > 2000000) {
                alert('File is Too Large! Upload File less Then 2 MB !');
                var $el = $('#hearderfile');
                $el.wrap('<form>').closest('form').get(0).reset();
                $el.unwrap();
             }else{

                  reader.onload = function (e) {
                        $('#footer')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(100);
         
                    };                   
                    reader.readAsDataURL(input.files[0]);
                    
                 }
            }
        }

        function Upload(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

              file = input.files[0];

             if (file.size > 2000000) {
                alert('File is Too Large! Upload File less Then 2 MB !');
                var $el = $('#footerfile');
                $el.wrap('<form>').closest('form').get(0).reset();
                $el.unwrap();
             }else{

                  reader.onload = function (e) {
                        $('#footer')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(100);
         
                    };                   
                    reader.readAsDataURL(input.files[0]);
                    
                 }    
                }
          }


          var email = $('#senderemailid').val();
          function isEmail() {
          

      
        }


    $('#saveemailsettings').click(function(){

      var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,20})$/;
      var email = document.getElementById('senderemailid').value;

      if (reg.test(email) == false) {
         alert('Email Id is Wrong Enter Right Email Format');
       }else{

          $.ajax({
            url : '{{url("emailsettings")}}',
            type : 'post',
            data : { _token:'{{ csrf_token() }}',emailupdate:1,heardername:$('#heardername').val(),senderemailid:$('#senderemailid').val(),emailstatusupdate:$('#emailstatus').val()},
            success : function(data){

               alert(data);

               window.location.reload();

            },
        });
       }

      
    });

     $('#smsdiv').hide();
     $('#editsmsdiv').hide();
    $('#emaildiv').hide();



    

    $('#messagessetting').change(function(){

      // alert($('#messagessetting').val());

      if ($('#messagessetting').val() == 'sms') {

        // $('#editsmsdiv').show();
        $('#emaildiv').hide();


        $.ajax({
              url : '{{url("geteditsmssettings")}}',
              type : 'get',
              data : { _token:'{{ csrf_token() }}'},
              success : function(data,i){
                // $.each(data,function(i1,item1){});
                $('#hid').val(data.smssettingid);
                $('#domailnameurl').val(data.domailname);
                // $('#domailnameurl').val(data.domailname);

                if (data != 1) {
                  
                  $('#editsmsdiv').show();

                }else{
                  alert("Url Not Found For Edit !");

                  window.location.reload();
                }

                var as = data.smsonoff;
                // alert(as);

                if (as == 'Active') {
                  $('#ac').prop('selected',true);
                  // alert('jhk');
                }else{
                  $('#dac').prop('selected',true);
                  // $('#dac ').val();
                }
                
                var i = $('#i').val();
                
                var splitpara = data.parameters.split(',');
                 // alert(splitpara);
                var pfmoq = splitpara[0].split('=');
                var pfmsg = splitpara[1].split('=');
                // alert(pfmsg[0]);
                var pfmo1 = $('#pfmobile').val(pfmoq[0]);
                var pfmo2 = $('#vfmobile').val(pfmoq[1]);
                var mo1 = $('[name=pfmessage]').val(pfmsg[0]);
                // var mo2 = $('#vfmessage').val(pfmsg[1]);
                
                  // alert(mo1);alert(mo2);
                $.each(splitpara,function(i1,item)
                {
                  i = Number(i) + 1;
                  // alert(i);
                  var sitem = item.split('=');
                 
                  $('#item1').remove();
                   $('#item2').remove();

// vfmobile

                  $('#addpn'+i+'').val(sitem[0]);
                  $('#addv'+i+'').val(sitem[1]);

                  $('#item').append('<div id="item'+i+'"><div class="col-lg-5"><input type="text" class="form-control" placeholder="Add Parameter Name" name="addpn'+i+'" value="'+sitem[0]+'"></div><div class="col-lg-5"><input type="text" class="form-control" placeholder="Set User Name parameter" name="addv'+i+'" value="'+sitem[1]+'"></div><button type="button" id="item'+i+'" data-toggle="" data-placement="top" onclick="removeproduct('+i+');" data-original-title="Remove This Product" class="btn btn-danger" style="margin-left: auto;"><i class="glyphicon glyphicon-minus"></i></button></div></div><br/>');
                  $('#i').val(i);
                  //alert(sitem[0]); //parameter
                  //alert(sitem[1]); //value
                });
                //$('#domailnameurl').val(data.domailname);
              },
              dataType:'json',
      });

      }
      if ($('#messagessetting').val() == 'email') {

        $('#editsmsdiv').hide();
        $('#emaildiv').show();

        $.ajax({
            url : '{{url("emailsettings")}}',
            type : 'get',
            data : { _token:'{{ csrf_token() }}',getemaildata:1},

            success : function(data){

               $('#heardername').val(data.hearder);
               $('#senderemailid').val(data.senderemailid);
               $('select[name=emailstatus]').val(data.status);
 
            },
            dataType:"json"
        });

      }

    });

    //  $('#domainname').change(function(){

    //   $('#editsmsdiv').show();
    //   // alert($('#domainname').val());

      

    // });


    $('#savesmssettings').click(function(){

      // alert($('#pauthanticationkey').val());
      var i = $('#ipdomail').val();
      var a = $('#pauthanticationkey').val();

      

      $('#showurl').html(url);

    });


</script>
<script type="text/javascript">
  $("#button").click(function () {
     var i = $('#i').val();
         i = Number(i) + 1;

          // alert("addpn"+i);
        $('#item').append('<div id="item'+i+'"><div class="col-lg-5"><input type="text" class="form-control" placeholder="Add Parameter Name" name="addpn'+i+'" ></div><div class="col-lg-5"><input type="text" class="form-control" placeholder="Set User Name parameter" name="addv'+i+'"></div><button type="button" id="item'+i+'" data-toggle="" data-placement="top" onclick="removeproduct('+i+');" data-original-title="Remove This Product" class="btn btn-danger" style="margin-left: auto;"><i class="glyphicon glyphicon-minus"></i></button></div></div>');
        $('#i').val(i);

        // alert($('#addpn'+i).val());

      });

function removeproduct(i)
{
  $('#item'+i).remove();
}
</script>

@endsection