@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" type="text/css" href="../css/style.css">
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Notification Settings</h2></section>
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


    <h3 class="box-title">SMS/Email Settings</h3>
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

          <div id="smsdiv">

          <div class="row col-lg-offset-1">
              <label><h4><b>Sms Settings</b></h4></label>
          </div>

        <div class="well row col-lg-10 col-lg-offset-1 from-group">
          <form action="{{url('smssettings')}}" method="post">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-lg-5"><label>URL :</label></div>
              <div class="col-lg-5"><input type="text" class="form-control" name="url" id="url" placeholder="Enter SMS URL" value="http://vsms.vr4creativity.com/api/mt/SendSMS"></div>
            </div>

            <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Parameter & value For Mobile :</label></div>
              <div class="col-lg-2"><input type="text" class="form-control" id="pfmobile" name="pfmobile" placeholder="Set Parameter For Mobile" value="number"></div>
              <div class="col-lg-3"><input type="text" class="form-control" id="vfmobile" name="vfmobile" placeholder="Set Parameter For Mobile" value="7600640425"></div>
            </div>

             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Parameter & value For Message :</label></div>
              <div class="col-lg-2"><input type="text" class="form-control" name="pfmessage" placeholder="Set Parameter For Message" value="text"></div>
              <div class="col-lg-3"><input type="text" class="form-control" name="vfmessage" placeholder="Set Parameter For Message" value="Message"></div>
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


            <!-- <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Mobile No Parameter:</label></div>
              <div class="col-lg-5"><input type="text" name="mobileno" class="form-control" placeholder="Set Mobileno Parameter"></div>
            </div> -->

            <!-- <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Message Parameter</label></div>
              <div class="col-lg-5"><input type="text" name="text" class="form-control" placeholder="Set Message Parameter"></div>
            </div> -->

            <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="row">
              <div class="col-lg-5"><label>Add Parameter Name :  </label></div>
              <div class="col-lg-5"><label>Add Parameter Value : </label></div>
            </div>

             <div class="mt-2 col-md-12" style="padding: 10px;"></div>
             <input type="hidden" name="i" id="i" value="0">


            <div class="row">
              <div id="item">
              <div class="col-lg-5"><input type="text" class="form-control" name="addpn" id="addpn0" placeholder="Set User Name parameter"></div>
              <div class="col-lg-5"><input type="text" class="form-control" name="addv" placeholder="Set User Name parameter"></div>
              </div>
              <div class="col-lg-2" id="button"><i class="fa fa-plus-circle btn bg-green"></i></div>
            </div><br/>
            

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
                <button class="form-control bg-green btn-block" id="savesmssettings">Save Changes</button>
                <!-- data-toggle="modal" data-target="#modal-smsurl" -->
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="modal fade" id="modal-smsurl">
        <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">SMS URL</h4>
              </div>
              <div class="modal-body">
                <div id="showurl">
                  
                </div>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn bg-aqua" id="">save</button>
              </div>
             
           </div>
        </div>
     </div>
            
           <div id="emaildiv">
            <!-- <form action="{{url('emailsettings')}}" method="post">
              {{ csrf_field() }} -->
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
                  <td><div class="well col-lg-offset-1"><input type="text" class="form-control" name="hearder" placeholder="Enter Header" title="Enter Header" id="heardername" placeholder="Hearder"></div></td>
                  <!-- <td><div class="well col-lg-offset-1"><label href="#"><a id="hearderchange">Change</a></label></div></td> -->
                </tr>

                <tr>
                  <td><div class="well"><label>Sender Email ID</label></div></td>
                  <td><div class="well col-lg-offset-1"><input type="text" required="Email" class="form-control" name="senderemailid" placeholder="Enter Defalut Sender Email" id="senderemailid" placeholder="abc@gmail.com"></div></td>
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

               <!--  <tr>
                  <td><div class="well"><label>Hearder Image</label></div></td>
                  <td><div class="well col-lg-offset-1"><input type="file" class="form-control" onchange="readURL(this);" name="" id="hearderfile"><img id="blah" src="#" alt="your image" />
                  </div></td>
                  <td><div class="well col-lg-offset-1"><label href="#"><a>Upload</a></label></div></td>
                </tr>

                <tr>
                  <td><div class="well"><label>Footer Image</label></div></td>
                  <td><div class="well col-lg-offset-1"><input type="file" class="form-control" onchange="Upload(this);" name="" id="footerfile"><img id="footer" src="#" alt="your image" />
                  </div></td>
                  <td><div class="well col-lg-offset-1"><label href="#"><a>Upload</a></label></div></td>
                </tr> -->

            </tbody>
            </table>
          </div>

            <div class="row">
              <div class="col-lg-3 col-lg-offset-3">
                <button class="form-control bg-green  btn-block" id="saveemailsettings">Save Changes</button>
              </div>
            </div>
            <!-- </form> -->
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
            data : { _token:'{{ csrf_token() }}',emailinsert:1,heardername:$('#heardername').val(),senderemailid:$('#senderemailid').val(),emailstatusupdate:$('#emailstatus').val()},
            success : function(data){

               alert(data);

               window.location.reload();

            },
        });
       }

      
    });

     $('#smsdiv').hide();
    $('#emaildiv').hide();

    $('#messagessetting').change(function(){

      // alert($('#messagessetting').val());

      if ($('#messagessetting').val() == 'sms') {

        $('#smsdiv').show();
        $('#emaildiv').hide();

      }
      if ($('#messagessetting').val() == 'email') {

        $('#smsdiv').hide();
        $('#emaildiv').show();

      }

    });

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
        $('#item').append('</div><div id="item'+i+'"><div class="col-lg-5"><input type="text" class="form-control" placeholder="Add Parameter Name" name="addpn'+i+'" ></div><div class="col-lg-5"><input type="text" class="form-control" placeholder="Set User Name parameter" name="addv'+i+'"></div><button type="button" id="item'+i+'" data-toggle="" data-placement="top" onclick="removeproduct('+i+');" data-original-title="Remove This Product" class="btn btn-danger" style="margin-left: auto;"><i class="glyphicon glyphicon-minus"></i></button></div></div><br/>');
        $('#i').val(i);



        // alert($('#addpn'+i).val());

      });

function removeproduct(i)
{
  $('#item'+i).remove();
}
</script>

@endsection