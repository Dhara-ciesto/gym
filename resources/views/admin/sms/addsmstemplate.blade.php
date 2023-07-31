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
    height: 200px;
}
li {
    list-style-type: none;
}
</style>
@endpush
@section('content')

<!-- left column -->
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Add SMS Template</h2></section>
          <!-- general form elements -->
           <section class="content">
          
              @if ($errors->any())
            <div class="alert alert-danger">
               <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li><br/>
            @endforeach
            </ul>
            </div>
            @endif
        @if ($msg = Session::get('message'))
          <div class="alert alert-success alert-block" id="#success-alert">
           <button type="button" class="close" data-dismiss="alert">×</button>
                 <strong class="whitetext">{{ $msg }}</strong>
          </div>
        @endif

             <script type="text/javascript">
              $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert-danger").slideUp(500);
                });
           </script>

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add New Template</h3>
            </div>

          
            <!-- /.box-header -->
            <div class="box-body"> 
              <div class="col-lg-12">
                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                        <form action="{{url('addnewtemplate')}}" method="post" id="formid">
                          {{ csrf_field() }}
                             <div class="row">
                                <div class="form-group">
                                  <div class="row">

                                    <div class="col-lg-8 col-lg-offset-1">
                                      <input type="text" class="form-control" name="smstemplate" placeholder="Add Sms Template Subject Name" maxlength="50">

                                      <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                      <span id="rchars">250</span> Character(s) Remaining
                                      <textarea class="form-control" name="smstxt" rows="5" required id="textareasms" maxlength="250"></textarea>
                                    </div>

                                    <!-- <div class="row">
                                      <div class="well col-lg-5" id="scroll">
                                        <table>
                                          <thead>
                                            <tr>
                                              <th></th>
                                              <th></th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[FirstName]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[LastName]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[join date]</div></td>
                                            </tr>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[Fully/Partially]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[Name of Member]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[ID]</div></td>
                                            </tr>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[EmployeeLevel]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[EmployeeName]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[End Date]</div></td>
                                            </tr>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[InvoiceID]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[Amount]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[Date]</div></td>
                                            </tr>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[Packge]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[POC]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[otp]</div></td>
                                            </tr>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[From]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[To]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[Days]</div></td>
                                            </tr>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[UID]</div></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div> -->
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-8 col-lg-offset-1">
                                      
                                      <div class="table-responsive">

                                        <table >
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
                                   <div class="col-lg-6 col-lg-offset-1">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" id="csms" value="1" name="sms">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox" id="cemail" value="1"  name="email" value="1">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div> -->

                               <!--  <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3 form-group">
                                     <div class="col-lg-5">
                                      <label class="container">Notification Type :</label>
                                    </div>

                                      <div class="col-lg-5">
                                        <select class="form-control">
                                          <option value="transactional">Transactional</option>
                                          <option value="promotional">Promotional</option>
                                        </select>
                                      </div>
                                  </div>
                                </div> -->

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <center>
                               
                                    <button class="btn bg-green btn margin" id="InquiryAddedbtn">Save</button>
                                 
                                 
                                    <a class="btn btn-danger btn margin" id="msgclear">Clear</a>
                               
                                  </center>
                                </div>
                              </div>
                            </div>
                        </form>
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
<script type="text/javascript">
  $('#InquiryAddedbtn').click(function(){
     if ($('#formid').valid()){
         $('#formid').submit();
         $('#InquiryAddedbtn').attr('disabled',true);

     }
  });
</script>
@endpush