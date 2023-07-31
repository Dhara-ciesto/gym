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
  background-color: #3a3938;
  color: #fff;
}
.tagcolor:hover{
  color: #fff;
}
table {
  border-spacing: 15px;
}
table, th, td {
  padding: 5px;
}
#scroll{
   overflow: scroll;
    height: 150px;
}
li {
    list-style-type: none;
}
</style>
@endpush
@section('content')

<!-- left column -->
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Edit SMS Template </h2></section>
          <!-- general form elements -->
           <section class="content">
           @if ($msg1 = Session::get('message'))
          <div class="alert alert-success alert-block" id="#success-alert">
           <button type="button" class="close" data-dismiss="alert">×</button>
                 <strong class="whitetext">{{ $msg1 }}</strong>
          </div>
        @endif
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

            <script type="text/javascript">
              $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert-danger").slideUp(500);
              });
            </script>

          <div class="box box-primary">

            <div class="box-header with-border">
<!--               <h3 class="box-title">Add Notification</h3>
 -->               <a href="{{ url('addnewtemplate') }}" class="bowercomponentscustomedarkbluebtn btn pull-right add-new bg-orange" style="height: 35px;width: 210px;"><i class="fa fa-plus"></i> Add New Template</a>
            </div>

          
            <!-- /.box-header -->
            <div class="box-body"> 
              <div class="col-lg-12">
              
                <div class="row">
                                  <div class="col-lg-8 col-lg-offset-1">
                                
                                  <div class="">
                                    <form action="{{url('editsms')}}" method="post">
                                      {{ csrf_field() }}
                                    <label>Notification Template<span style="color: red;">*</span></label>

                                   <select name="messagestemplate" id="messagestemplatename"  class="form-control selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Notification Template"><option selected disabled=""> Please choose an Template </option>
                                    @if($msg)
                                    @foreach($msg as $m)
                                    <option value="{{ $m->messagesid }}">{{ ($m->subject) }}</option>
                                    @endforeach
                                    @endif
                                    </select>
                                  </div>
                                  <!-- /input-group -->
                                  </div>
                           </div>

                           <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                           <div id="commanfields">
                              

                             <div class="row">
                              <div class="form-group">
                                
                                <div class="col-md-8 col-md-offset-1">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasms" required name="textareasms" maxlength="250" ></textarea>
                                </div>

                                

                              
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                  <div class="col-lg-10 col-lg-offset-1">
                                      
                                      <div class="table-responsive">
                                                  <table>
                                          <tbody>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[FirstName]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[LastName]</div></td>
                                            </tr>
                                          
                                          </tbody>
                                        </table>
                                      </div>
                                  </div>
                                </div>
                                
                                <!-- <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <select multiple="multiple" class="form-control selectpicker smstag">
                                         <option value="" disabled="">--Please choose an option--</option>
                                         <option value="[FirstName]">[FirstName]</option>
                                         <option value="[LastName]">[LastName]</option>
                                         <option value="[join date]">[join date]</option>
                                         <option value="[Fully/Partially]">[Fully/Partially]</option>
                                         <option value="[ID]">[ID]</option>
                                         <option value="[Name of Member]">[Name of Member]</option>
                                         <option value="[EmployeeLevel]">[EmployeeLevel]</option>
                                         <option value="[EmployeeName]">[EmployeeName]</option>
                                         <option value="[End Date]">[End Date]</option>
                                         <option value="[InvoiceID]">[InvoiceID]</option>
                                         <option value="[Amount]">[Amount]</option>
                                         <option value="[Date]">[Date]</option>
                                         <option value="[Packge]">[Packge]</option>
                                         <option value="[POC]">[POC]</option>
                                         <option value="[otp]">[otp]</option>
                                         <option value="[From]">[From]</option>
                                         <option value="[To]">[To]</option>
                                         <option value="[Days]">[Days]</option>
                                         <option value="[UID]">[UID]</option>
                                       </select>
                                  </div>
                                </div> -->

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <!-- <div class="row">
                                   <div class="col-lg-6 col-lg-offset-1">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" id="csms"  name="sms" value="1">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox" id="cemail"  name="email" value="1">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div> -->

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                            <center>
                                    <button class="btn bg-green btn margin " id="InquiryAddedbtn">Update</button>
                                 
                                  
                                    <a class="btn btn-danger btn margin" id="msgclear">Clear</a>
                                 </center>
                                </div>
                              </div>
                            </div>
                            </form>
                        </div>
                      </div>
                   </div>


              </div><div class="col-lg-3"></div>
            </div>
            <!-- /.box-body -->
          </div>
      
  </section>
</div>
</div>
</div>
@endsection

@push('script')
<script type="text/javascript">
  $('#InquiryAddedbtn').hide();
  $('#msgclear').hide();
  $('#messagestemplatename').change(function(){

    // alert($('#messagestemplatename').val());
    $('#InquiryAddedbtn').show();
    $('#msgclear').show();

    $.ajax({
        url : '{{url("getsmsdata")}}',
        typle: 'get',
        data : {_token:'{{ csrf_token() }}',msgid:$('#messagestemplatename').val()},
        success : function(data){
          
          $('#textareasms').val(data.message);
          if(data.editablestatus != 1){
              $('#textareasms').attr('readonly',true);
          }
          $('#csms').prop('checked',data.sms);
          $('#cemail').prop('checked',data.email);
          $('#textareasms').trigger('keyup');
        },
         dataType:'json',
    });
  });
</script>
<script type="text/javascript">

    $(".smstag").click(function(){
        var txt = $.trim($(this).text());
        var box = $('textarea');
        box.val(box.val() + txt);
      });
               

   var maxLength = 250;
        $('#textareasms').keyup(function() {
          var textlen = maxLength - $(this).val().length;
          $('#rchars').text(textlen);
        });

    $('#msgclear').click(function(){
        $('#textareasms').val('');
    });

</script>
@endpush