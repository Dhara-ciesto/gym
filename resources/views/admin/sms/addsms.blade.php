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
  background-color: #A1F3CD;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #1AC47A;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #00B968;
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
  background-color: #A1F3CD;
  color: #000;
}
</style>
@endpush
@section('content')

<!-- left column -->
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Add Notification </h2></section>
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
              <h3 class="box-title">Add Notification</h3>
               <a href="{{ url('addrole') }}" class="bowercomponentscustomedarkbluebtn btn pull-right add-new bg-green" style="height: 35px;width: 210px;"><i class="fa fa-plus"></i> Add New Template</a>
            </div>

          
            <!-- /.box-header -->
            <div class="box-body"> 
              <div class="col-lg-12">
              
                <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                              
                                  <div class="input-group">
                                    <label>Notification Template<span style="color: red;">*</span></label>

                                   <select name="selectusername" id="messages"  class="form-control selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Notification Template"><option selected >--Please choose an option--</option>
                                    @foreach($msg as $m)
                                    <option value="{{ $m->messagesid }}">{{ ($m->subject) }}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                  <!-- /input-group -->
                                  </div>
                           </div>

                           <div id="commanfields">
                              <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasms" maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[FirstName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[LastName]</b></div>
                                       </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" id="csms"  name="generalfitness">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox" id="cemail"  name="fatloss" value="1">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>
                           </div>

                           <div id="InquiryAdded">
                            <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="InquiryAddedbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="NewMemberhsip">
                            <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="NewMemberhsipbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>

                           <div id="BirthdayGrettings">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="BirthdayGrettingsbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>


                           <div id="AnniversaryGreetings">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="AnniversaryGreetingsbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="RenewalMembership">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="RenewalMembershipbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="CancelMembership">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="CancelMembershipbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="TransferMembership">
                             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasmstransfermembership" maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[FirstName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[LastName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[UID]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[NewMemberName]</b></div>
                                       </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" id="tcsms"  name="generalfitness" >
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox"  name="fatloss" id="tcemail">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="TransferMembershipbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="FreezeMemebership">
                             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasmsfreezemembership" maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[FirstName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[LastName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[UID]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[Days]</b></div>
                                       </div>

                                       <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[From]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[To]</b></div>
                                       </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" id="fmcsms"  name="generalfitness" >
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox"  name="fatloss" id="fmcemail">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="FreezeMemebershipbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="AbsentMember">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="AbsentMemberbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="MembershipReminder">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="MembershipReminderbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="PTMebershipNew">
                              <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasmsptmembershipnew" maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[FirstName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[LastName]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[EmployeeLevel]</b></div>
                                       </div>

                                        <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[EmployeeName]</b></div>
                                       </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" name="generalfitness" id="ptmncsms">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox"  name="fatloss" id="ptmncemail">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="PTMebershipNewbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="PTMembershipRenewal">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="PTMembershipRenewalbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="AssignPackage">
                             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasmsassignpackage" maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-5">
                                         <div class="smstag pointer btn tagcolor"><b>[Name of Member]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[ID]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[Fully/Partially]</b></div>
                                       </div>
                                       

                                       <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                        <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[join date]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[End Date]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[InvoiceID]</b></div>
                                       </div>

                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" name="generalfitness" id="apcsms">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox"  name="fatloss" id="apcemail">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="AssignPackagebtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="Paymenttaken">
                             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasmspaymenttaken" maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-5">
                                         <div class="smstag pointer btn tagcolor"><b>[Name of Member]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[ID]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[Fully/Partially]</b></div>
                                       </div>
                                       

                                       <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                        <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[Amount]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[InvoiceID]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[Date]</b></div>
                                       </div>

                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox"  name="generalfitness" id="ptcsms">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox"  name="fatloss" id="ptcemail">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="Paymenttakenbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="FollowupAdded">
                             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasmsfollowup"  maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[FirstName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[LastName]</b></div>
                                       </div>

                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[Packge]</b></div>
                                       </div>
                                       

                                       <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                        <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[Date]</b></div>
                                       </div>

                                       <div class="col-lg-4">
                                         <div class="smstag pointer btn tagcolor"><b>[POC]</b></div>
                                       </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                <div class="row">
                                   <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" name="generalfitness" id="facsms">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox"  name="fatloss" id="facsms">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="FollowupAddedbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="RegistrationAdded">
                             <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="RegistrationAddedbtn">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>

                           <div id="OTP">
                             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                             <div class="row">
                              <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                  <span id="rchars">250</span> Character(s) Remaining
                                  <textarea class="form-control" rows="5" id="textareasmsotp"  maxlength="250"></textarea>
                                </div>
                                
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                                 <div class="row">
                                  <div class="col-lg-6 col-lg-offset-3">
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[FirstName]</b></div>
                                       </div>
                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[LastName]</b></div>
                                       </div>

                                       <div class="col-lg-3">
                                         <div class="smstag pointer btn tagcolor"><b>[otp]</b></div>
                                       </div> 
                                    </div>
                                  </div>                                    

                                       
                                  <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                     <div class="col-lg-5">
                                      <label class="container">Notification For :</label>
                                    </div>
                                      <div class="col-lg-3">
                                        <label class="container">SMS
                                          <input type="checkbox" name="generalfitness" id="otpcsms">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="container">Email
                                          <input type="checkbox"  name="fatloss" id="otpcemail">
                                          <span class="checkmark"></span>
                                        </label>
                                      </div>
                                  </div>
                                </div>

                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>

                              </div>
                              </div>

                              <div class="row">
                              <div class="form-group">
                                <div class="mt-2 col-md-12" style="padding: 10px;"></div>
                                <div class="row">
                                  <div class="col-lg-2 col-lg-offset-5">
                                    <button class="btn btn-success btn-block" id="OTPbtn">Save</button>
                                  </div>
                                </div>
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
  $(document).ready(function(){

    $('#commanfields').hide();
    $('#InquiryAdded').hide();
    $('#NewMemberhsip').hide();
    $('#BirthdayGrettings').hide();
    $('#AnniversaryGreetings').hide();
    $('#RenewalMembership').hide();
    $('#CancelMembership').hide();
    $('#TransferMembership').hide();
    $('#FreezeMemebership').hide();
    $('#AbsentMember').hide();
    $('#MembershipReminder').hide();
    $('#PTMebershipNew').hide();
    $('#PTMembershipRenewal').hide();
    $('#AssignPackage').hide();
    $('#Paymenttaken').hide();
    $('#FollowupAdded').hide();
    $('#RegistrationAdded').hide();
    $('#OTP').hide();

  });

   var maxLength = 250;
        $('#textareasms').keyup(function() {
          var textlen = maxLength - $(this).val().length;
          $('#rchars').text(textlen);
        });


        function getsmsdata(){

        $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                 $('#csms').prop('checked',data.sms);
                 $('#cemail').prop('checked',data.email);

                $('#textareasms').html(data.message);
                var cs = $('#textareasms').val().length;
                var textlen = maxLength - $('#textareasms').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
        }


   $('#messages').on('change',function(){

     if ($('#messages').val() == 1) {
      $('#InquiryAdded').show();
      $('#commanfields').show();
      getsmsdata();
       $('#InquiryAddedbtn').click(function() {  
        alert($('#csms').val());
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val(),smscheck:$('#csms').val()},
          success : function(data){
            alert(data);
            //window.location.reload();
          }
         });
       });
     }
      else{
       $('#InquiryAdded').hide();
     //  $('#commanfields').hide();
     }

      if ($('#messages').val() == 2) {
      $('#NewMemberhsip').show();
      $('#commanfields').show();
      getsmsdata();
      $('#NewMemberhsipbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }
      else{
       $('#NewMemberhsip').hide();
     //  $('#commanfields').hide();
      }

      if ($('#messages').val() == 3) {
      $('#BirthdayGrettings').show();
      $('#commanfields').show();
      getsmsdata();
      $('#BirthdayGrettingsbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#BirthdayGrettings').hide();
     }

      if ($('#messages').val() == 4) {
      $('#AnniversaryGreetings').show();
      $('#commanfields').show();
      getsmsdata();
      $('#AnniversaryGreetingsbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#AnniversaryGreetings').hide();
     }

      if ($('#messages').val() == 5) {
      $('#RenewalMembership').show();
      $('#commanfields').show();
      getsmsdata();
      $('#RenewalMembershipbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#RenewalMembership').hide();
     }

      if ($('#messages').val() == 6) {
      $('#CancelMembership').show();
      $('#commanfields').show();
      getsmsdata();
      $('#CancelMembershipbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#CancelMembership').hide();
     }

      if ($('#messages').val() == 7) {
      $('#TransferMembership').show();
       $('#commanfields').hide();
       $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                 $('#tcsms').prop('checked',data.sms);
                 $('#tcemail').prop('checked',data.email);

                $('#textareasmstransfermembership').html(data.message);
                var cs = $('#textareasmstransfermembership').val().length;
                var textlen = maxLength - $('#textareasmstransfermembership').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
         $('#TransferMembershipbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasmstransfermembership').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#TransferMembership').hide();
      // $('#commanfields').show();
     }

      if ($('#messages').val() == 8) {
      $('#FreezeMemebership').show();
      //$('#commanfields').hide();
      $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                $('#fmcsms').prop('checked',data.sms);
                 $('#fmcemail').prop('checked',data.email);

                $('#textareasmsfreezemembership').html(data.message);
                var cs = $('#textareasmsfreezemembership').val().length;
                var textlen = maxLength - $('#textareasmsfreezemembership').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
      $('#FreezeMemebershipbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasmsfreezemembership').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#FreezeMemebership').hide();
      //$('#commanfields').show();
     }

      if ($('#messages').val() == 9) {
      $('#AbsentMember').show();
      $('#commanfields').show();
      getsmsdata();
      $('#AbsentMemberbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#AbsentMember').hide();
     }

      if ($('#messages').val() == 10) {
      $('#MembershipReminder').show();
      $('#commanfields').show();
      getsmsdata();
      $('#MembershipReminderbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#MembershipReminder').hide();
     }

      if ($('#messages').val() == 11) {
      $('#PTMebershipNew').show();
      $('#commanfields').hide();
      $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                $('#ptmncsms').prop('checked',data.sms);
                 $('#ptmncemail').prop('checked',data.email);

                $('#textareasmsptmembershipnew').html(data.message);
                var cs = $('#textareasmsptmembershipnew').val().length;
                var textlen = maxLength - $('#textareasmsptmembershipnew').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
      $('#PTMebershipNewbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasmsptmembershipnew').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#PTMebershipNew').hide();
     }

      if ($('#messages').val() == 12) {
      $('#PTMembershipRenewal').show();
      $('#commanfields').show();
      getsmsdata();
      $('#PTMembershipRenewalbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#PTMembershipRenewal').hide();
     }

      if ($('#messages').val() == 13) {
      $('#AssignPackage').show();
      $('#commanfields').hide();
      $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                $('#apcsms').prop('checked',data.sms);
                 $('#apcemail').prop('checked',data.email);

                $('#textareasmsassignpackage').html(data.message);
                var cs = $('#textareasmsassignpackage').val().length;
                var textlen = maxLength - $('#textareasmsassignpackage').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
      $('#AssignPackagebtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasmsassignpackage').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#AssignPackage').hide();
     }

      if ($('#messages').val() == 14) {
      $('#Paymenttaken').show();
      $('#commanfields').hide();
      $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                $('#ptcsms').prop('checked',data.sms);
                 $('#ptcemail').prop('checked',data.email);

                $('#textareasmspaymenttaken').html(data.message);
                var cs = $('#textareasmspaymenttaken').val().length;
                var textlen = maxLength - $('#textareasmspaymenttaken').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
      $('#Paymenttakenbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasmspaymenttaken').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#Paymenttaken').hide();
     }

     if ($('#messages').val() == 15) {
      $('#FollowupAdded').show();
      $('#commanfields').hide();
      $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                $('#facsms').prop('checked',data.sms);
                 $('#facemail').prop('checked',data.email);

                $('#textareasmsfollowup').html(data.message);
                var cs = $('#textareasmsfollowup').val().length;
                var textlen = maxLength - $('#textareasmsfollowup').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
      $('#FollowupAddedbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasmsfollowup').val()},
          success : function(data){
            alert(data);
          }
         });
       });
     }else{
      $('#FollowupAdded').hide();
     }

    if ($('#messages').val() == 16) {
        $('#RegistrationAdded').show();
        $('#commanfields').show();
        getsmsdata();
         $('#RegistrationAddedbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasms').val()},
          success : function(data){
            alert(data);
          }
         });
       });
       }else{
        $('#RegistrationAdded').hide();
       }

    if ($('#messages').val() == 17) {
        $('#OTP').show();
        $('#commanfields').hide();
        $.ajax({
            type : 'get',
            url  : '{{url("getsmsdata")}}', 
            data : {_token:'{{ csrf_token()}}',msgid:$('#messages').val()},
            success : function(data){

                data = JSON.parse(data);
                $('#otpcsms').prop('checked',data.sms);
                 $('#otpcemail').prop('checked',data.email);

                $('#textareasmsotp').html(data.message);
                var cs = $('#textareasmsotp').val().length;
                var textlen = maxLength - $('#textareasmsotp').val().length;
                $('#rchars').text(textlen);
              //console.log(textlen);
            }
          });
         $('#OTPbtn').click(function() {  
         $.ajax({
          url : '{{url("editsmsdata")}}',
          type : 'post',
          data : {_token:'{{ csrf_token() }}',msgid:$('#messages').val(),msgtext:$('#textareasmsotp').val()},
          success : function(data){
            alert(data);
          }
         });
       });
       }else{
        $('#OTP').hide();
       }
   
   });

      
       $(".smstag").click(function(){
        var txt = $.trim($(this).text());
        var box = $('textarea');
        box.val(box.val() + txt);
      });
    

   $('.number').keypress(function(evt){
     var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
   });
</script> 
@endpush