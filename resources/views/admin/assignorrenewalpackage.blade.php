@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">

</style>
@endpush
@section('content')
<!-- left column -->
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

</style>
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Assign Package</h2></section>
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
            @if (!empty($success))
    <h1>{{$success}}</h1>
      @endif
   @if ($message = Session::get('message'))
   
      <div class="alert alert-danger alert-block" class="danger-alert">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
  
@endif 
<script type="text/javascript">
  $(document).ready (function(){
                $(".danger-alert").fadeTo(5000, 500).slideUp(500, function(){
               $(".danger-alert").slideUp(1000);
                });   
 });
</script>
 @if(request()->route('id'))
                @php 
                $i=request()->route('id');
                @endphp
                @else
                 @php 
                 $i='';
                @endphp
                @endif
 <form role="form" action="{{ url('assignPackage') }}" name="frmMr" method="POST" id="package_form">
  {{ csrf_field() }}
<div class="box box-primary" id="secondstep" >

           <div class="box-header with-border">
              <h3 class="box-title">Select Member</h3>
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
        <option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}" {{$user->memberid  == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
        </select>
      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4">
 
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo1" class="form-control " disabled="" ><option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}" {{$user->memberid  == $i?'selected':''}}>{{ $user->mobileno }}</option>@endforeach
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

       <select name="selectusername" id="username2"  class="form-control " disabled="" ><option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}">{{ $user->username }}</option>@endforeach
        </select>
      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4" >
      
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo2" class="form-control selectpicker"title="Select Mobileno" data-live-search="true"  data-actions-box="true" ><option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}">{{ $user->mobileno }}</option>@endforeach
        </select>
      
<!-- /input-group -->
    </div>
    <br>

    <div class="col-lg-4" style="margin-top: -20px;">
      <div class="form-group">
       <button type="button" id="next2" class="btn bg-orange">Next</button>
      </div>
    </div>
  </div>
 
<!-- /.box-header -->
  <!--   <div class="box-body">  
      <div class="col-lg-4">
  
      <div class="input-group">
        <label>Username<span style="color: red">*</span></label>

       <select name="selectusername" id="username"  class="form-control selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Username" required><option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}">{{ $user->username }}</option>@endforeach
        </select>
      </div> -->
      <!-- /input-group -->
    <!--   </div> -->
<!-- /.col-lg-6 -->
    <!-- <div class="col-lg-4">
      <div class="input-group">
        <label>Mobile No:</label>
        <select name="selectmobileno" id="mobileNo" class="form-control" disabled="" ><option selected >--Please choose an option--</option>@foreach($users as $user)
        <option value="{{ $user->memberid }}">{{ $user->mobileno }}</option>@endforeach
        </select>
      </div>

    </div>
    <br> -->

  <!--   <div class="col-lg-4" style="margin-top: 5px;">
      <div class="form-group">
       <button type="button" id="assignPackage" class="btn bg-blue">Next</button>
      </div>
    </div>
  </div>
 -->
           <div class="box-body">
               <div class="col-lg-12" id="Package" style="display: none" class="Package">
                     <hr style="border-width: 2px;border-color: black"> <h4><u>Assign Package</u></h4> 
               <div class="col-lg-5">
              
              <div class="form-group">
             <label>Select Root Scheme<span style="color: red">*</span></label>
             
                <select name="RootSchemeId" id="rootscheme" class="form-control"class="span11" required><option value="" selected readonly>--Please choose an option--</option>@foreach($RootScheme as $rscheme)
              <option value="{{ $rscheme->rootschemeid }}">{{ $rscheme->rootschemename }}</option>@endforeach
          </select>
              </div>
              <div class="form-group">
             <label>Select Package<span style="color: red">*</span></label>
             
                <select name="SchemeID" id="scheme" onchange="assigndate()" class="form-control"class="span11" required=""><option value="" selected readonly>--Please choose an option--</option>
          </select><span id="package_error" style="color:red"></span>

              </div>
             
             <div class="form-group">
             <label>Membership Amount</label>
             <input type="text" name="MembershipAmount" id="MembershipAmount" class="form-control number" placeholder="Membership Amount" readonly=""  class="span11" />
               
              </div>
              <div class="form-group">
             <label>Base Amount</label>
             <input type="text" name="BaseAmount" id="BasePrice" class="form-control number" placeholder="Base Amount"   class="span11" disabled="" />
               
              </div>
              <div class="form-group">
             <label>Final Amount</label>
             <input type="text" name="ActualAmount" id="FinalAmount"class="form-control" placeholder="Final Amount" class="span11" readonly="" />
              </div>
         </div>

          <div class="col-md-5">
                
<!-- value="{{Carbon\Carbon::today()->format('Y-m-d')}}" -->
             <div class="form-group">
             <label>Join Date</label>
             
                <input placeholder="Joining date" onchange="assigndate()" type="date" onkeypress="return false" id="startingdate"  value="<?php echo date('Y-m-d'); ?>"class="form-control" name="Join_date" class="span11">
            
            </div>
               <div class="form-group">
             <label>Finish Date</label>
             
                <input placeholder="Finishing date"  id="finishdate" class="form-control" name="Expire_date" class="span11" readonly="" >
            
            </div>
                 <div class="form-group">
             <label>Discount (%)</label>
             
               <input type="text" name="Discount" id="Discount1" class="form-control number" placeholder="Discount (in %)"  value="0" class="span11" />
            
            </div>
             <div class="form-group">
             <label>Discount (Rs.)</label>
             
               <input type="text" name="Discount" id="Discount2" class="form-control number" placeholder="Discount(in Rs.)"  value="0" class="span11" />
            
            </div>
             <!--    <div class="form-group">
             <label>Discount 2</label>
             
               <input type="text" name="Discount2" id="Discount2"  class="form-control" placeholder="Discount2" value="0"  class="span11" disabled="" />
            
            </div> -->
            <input type="hidden" name="TaxAmount" value="" id="gsttaxamount">
            <div class="form-group">
             <label>Total Discount</label>
             
               <input type="text" name="TotalDiscount" class="form-control number" placeholder="TotalDiscount" id="totaldiscount"  class="span11" readonly="" />
                 <input type="hidden" name="PaymentDate"  value="{{Carbon\Carbon::today()->format('Y-m-d')}}" />
            
            </div>
              
         </div>

      
       <div class="col-lg-8" >
        <table>
    <!--   <div class="form-group">
       
            
             <tr><td>
                    <input type="checkbox" name="" id="disabled" value="21"> <label>Cash Credit </label> &emsp;</td>
             <td> <input type="text"  id="CashCredit" class="form-control" placeholder="CashCredit" class="span9" disabled="" /></td>&emsp;
              <td> <input type="text"  name="CashCredit"  class="form-control price" placeholder="CashCreditAmount" id="CashCreditAmount"  class="span9" disabled="" /></td></tr>
            
            </div> -->
          </table>
            <br>
            <table>
             <div class="form-group">
               
        <thead>
             <tr>       <th></th>
                        <th>Amount</th>
                        <th>Remarks</th>
            </tr>
            </thead> 
            @php $i=0; @endphp
             @foreach($PaymentTypes as $PaymentType)
           <tr><td><input type="checkbox" class="check" name="Mode[]" value="{{$PaymentType->paymenttypeid}}"> &emsp;<label>{{$PaymentType->paymenttype}}</label>&emsp;</td><td><input type="text" class="form-control price  number " id="amount<?php echo $i;?>" disabled="" name="Amount[]"></td>&emsp;<td><input type="text"class="form-control" name="Remark[]" disabled=""></td>
            @php $i++; @endphp
        @endforeach</tr> <!--
          <tr><td><input type="checkbox" name="terms[]" value=""><label>Cash</label></td><td><input type="text"class="form-control" name="value[]"></td>
            <td><input type="text"class="form-control" name="value[]"></td>
       </tr>
          <tr><td><input type="checkbox" name="terms[]" value=""><label>Cheque</label></td><td><input type="text" class="form-control" name="value[]"></td>
            <td><input type="text"class="form-control" name="value[]"></td>
       </tr>
        <tr><td><input type="checkbox" name="terms[]" value=""><label>Cheque</label></td><td><input type="text"  class="form-control"name="value[]"></td>
          <td><input type="text"class="form-control" name="value[]"></td>
       </tr> -->
       

                </div>
             </table>
                 
             <div class="col-lg-7">
         <table>
               <div class="form-group">

                    <tr><td>
                     <label>Total Amount</label>&emsp;</td>  
                 
             <td><input type="text" name="Total" class="form-control form-inline" placeholder="Total" id="total"  class="span11" readonly="" /></td></tr>
              <tr><td><label>Remaining amount</label>&emsp;</td>  
             <td><input type="text"  name="rtotal" class="form-control form-inline " placeholder="Remaining amount" id="remainingamount"  class="span11"  readonly="" /></td></tr>
            <tr style="display: none;" id="duedatetr"><td ><label>Due Date</label></td><td ><input type="date" onkeypress="return false" name="duedate"  class="form-control" id="duedate" name="duedate"  min="<?php echo date("Y-m-d");?>"> </td></tr>
          </div></table></div>
           

             <div class="col-lg-5"><table>  <div class="form-group"><tr>
              <td><!-- <label>Reciept No. </label> --> &emsp; </td><td><input type="hidden" name="RecieptNo"  id="RecieptNo" class="form-control" value="{{ $ReceiptNo }}" readonly="" /></td></tr></div></table>
              </div> </div>
              <input type="hidden" name="ok" id="ok" value="">
              <div class="col-lg-8">
          <div class="form-group">
         <div class="col-sm-offset-6">
             <!--  data-backdrop="static" data-keyboard="false" -->
           <!--    <p class="btn bg-blue margin" data-toggle="modal" data-target="#myModalpayment" id="check2" onclick="return checkform()">Save</p> -->
         <button type="button"   id="save" value="button" onclick="checkform()" class="btn bg-blue margin" >
         Save</button>
         <a href="{{ url('assignPackageOrRenewalPackage') }}"class="btn bg-red margin">Cancel</a>

        </div></div></div></div>

             
           </div>
        </div>
            
            <!-- /.box-body -->
       
  
  <div class="modal fade" id="myModalpayment" role="dialog" style="display: none;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close"  data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Print</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to pay ?</p>
        </div>
          
        <div class="modal-footer">

          <button id="submit" type="submit" class="btn bg-blue margin" style="display: none;"> Save </button>
           <button id="saveprint" style="margin-top: -1px;" type="button" class="btn bg-blue margin" onclick="abcd()">Save </button>
          <a href="{{ url('members') }}"  class="btn bg-blue">View Members</a>
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        </div>
      </div>
      
    </div>
  </div>
    </div>
  </form>

</section>
</div>
<!--   <div class="modal fade" id="modal-default" style="display: none">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          /.modal-content
          </div>
     /.modal-dialog 
        </div>  --> 
</section>
<script type="text/javascript">
 $( document ).ready(function() {
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
   $('#Package').css('display','none');
  });
</script>
<script type="text/javascript">
  function abcd(){
    $('#submit').trigger('click');
    $('#saveprint').hide();
    $('#mobileNo').attr("disabled", false);
  }
   $('#submit').on('click',function(){

 });
</script>
<script type="text/javascript">
   $('#username1').on('change',function(){
    clear_form_elements();
    // alert('sdfs');

    $('#Package').css('display','none');



    var username = $('#username1').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
      // alert(data.memberid);
  
       $('#mobileNo1').val(data.memberid);
       $("#username2").val(data.memberid);
       $('#mobileNo2').val(data.memberid);
    // $('#mobileNo').select2().trigger('change');

     
      },
       dataType:"json"
     });
   });
</script>
<script type="text/javascript">
  $('#mobileNo2').on('change',function(){

   $('#Package').css('display','none');
    var username = $('#mobileNo2').val();
    var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;

      // $('#username').attr("value",data.username).val(data.username);
     $("#username2").val(data.memberid);
     $("#username1").val(data.memberid);
     $("#mobileNo1").val(data.memberid);
     
      },
       dataType:"json"
     });
   });
 </script>

<script type="text/javascript">
  function checkform() {
var mod=[];
if(Number(document.frmMr.ActualAmount.value) == 0 ){

}

if(Number(document.frmMr.ActualAmount.value) > 0 ){

    if(Number(document.frmMr.total.value) > Number(document.frmMr.ActualAmount.value)) {
     
        alert("please enter right amount");
       mod.push('error');

    }

    if(Number(document.frmMr.total.value) == "" || Number(document.frmMr.total.value) == 0 ) {
     

        alert("please enter right amount");
        mod.push('error');
    }
   
  }
  
     if(document.frmMr.rootscheme.value == "")
    {
       alert("please select RootScheme");
        mod.push('error');
      
    }
     if(document.frmMr.scheme.value == "")
    {
      $('#FinalAmount').val('');
         $('#MembershipAmount').val('');
         $('#Discount2').val('');
          $('#Discount1').val('');
           $('.price').val('');
        $('#total').val('');
        $('#remainingamount').val('0');
           $( "#remainingamount" ).trigger( "change" );
        
       alert("please select scheme ");
        mod.push('error');


        
    }

    if(Number($("#FinalAmount").val()) < 0 ){
      alert('Please enter right amount');
     mod.push('error');
    }
    

    else
    {
   
       var countchecked = $('input[type="checkbox"]').filter(function() {
                        return this.checked
                    }).length;
       if(countchecked > 0){
                   
                      var countchecked = $('.amountclass').filter(function() {
                         !this.disabled
                    }).length;
                   
                        $('input[type="checkbox"]').map(function(){
                          if($(this).prop("checked") == true){
                            var y=  $(this).closest('tr').find('[type=text]:first').val();
                            // alert(y);
                            if(y==''){
                              alert('kindly Uncheck the checkbox or fill data ');
                              //$('#myModalpayment').modal('hide');
                              mod.push('error');
                               
                            } else {
                               
                              //$('#myModalpayment').modal('show');
                            }
                          }
                            else
                            {
                           
                              
                            }

                          });
                     
            
              }

        if(mod.length === 0){

              if($("#duedate").is(":visible")){
                let value = $('#duedate').val();
                // alert(value);
                if(value.length>0){

                  $('#myModalpayment').modal('show');
                } else {
                  alert('Please select due date');
                }
              }
              else{
                 $('#myModalpayment').modal('show');
              }
              }    
           
    }

}
</script>
<script type="text/javascript">
$('#remainingamount').on('change', function(){
//alert('asdas');

   if($("#remainingamount").val() != 0 && $("#remainingamount").val() > 0){
    $('#duedatetr').show();
    $('#duedate').attr('required', 'require');
    

    }
    else if($("#remainingamount").val() ==''){
 
        $('#duedatetr').hide();
    $('#duedate').attr('required', false);
    }

});
</script>
<script type="text/javascript">
   $('#next1').on('click',function(){
    
     var username = document.getElementById("username1").value;
     var MobileNo = document.getElementById("mobileNo1").value;
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
        $('#CashCredit').val(data);
         $('#Package').css('display','block');
       
       }
       else
       {
       
         $('#Package').css('display','block');
       }
      },
       dataType:"json"
     })

   });
</script>
<script type="text/javascript">
   $('#next2').on('click',function(){
    
     var username = document.getElementById("username2").value;
     var MobileNo = document.getElementById("mobileNo2").value;
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
        $('#CashCredit').val(data);
         $('#Package').css('display','block');
       
       }
       else
       {
       
         $('#Package').css('display','block');
       }
      },
       dataType:"json"
     })

   });
</script>

<script type="text/javascript">
    $('#Discount1').on('keyup',function(){
  
    var result=Number(0);
    var result1 = Number((Number($('#BasePrice').val()) / 100) * Number($("#Discount1").val()));
    var result2 = Number($("#Discount2").val());
    result=Number(result1);
    var per=Number(result1);
    $('#Discount2').val(Math.round(per));
    var result = Number((Number($('#BasePrice').val()) / 100) * Number($("#Discount1").val()));
    var sum=Number(0);
    var totaldiscount = Number($("#FinalAmount").val());
    $('#totaldiscount').val('');
    $('#totaldiscount').val(Math.round(isNaN(result) ? 0 : result)); 
    sum=Number((Number($("#BasePrice").val()))-result);
    if(result){
      $('#FinalAmount').val(Math.round(isNaN(sum) ? totaldiscount : sum));
    }
    else if(result==''){
      $('#FinalAmount').val(Math.round(totaldiscount));
    }
      else 
        $('#FinalAmount').val(Math.round(totaldiscount));
      var tax = "<?php echo $tax ?>";
      var ff = Number((Number(sum)) / 100) * Number(tax);
   
      ff=Number(sum+ff);
      $('#FinalAmount').val(Math.round(ff));
     
     // $('#total').val(Math.round(ff));
       calculate();
           //shows value in "#rate"
  

   });
</script>
<script type="text/javascript">
 $('#Discount2').on('keyup',function(){

      var result=Number(0);
     var result1 = Number((Number($('#BasePrice').val()) / 100) * Number($("#Discount1").val()));
     var result2 = Number($("#Discount2").val());
     var per=Number((result2 / (Number($('#BasePrice').val())))*100);

     $('#Discount1').val(Math.round(per));

     result=Number(result2);
     var sum=Number(0);
     var totaldiscount = Number($("#FinalAmount").val());
     $('#totaldiscount').val('');
      $('#totaldiscount').val(Math.round(isNaN(result) ? 0 : result)); 
      sum=Number((Number($("#BasePrice").val()))-result);
      if(result){
          $('#FinalAmount').val(Math.round(isNaN(sum) ? totaldiscount : sum));

      }
      else if(result==''){
         $('#FinalAmount').val(Math.round(totaldiscount));
      }
      else 
        $('#FinalAmount').val(Math.round(totaldiscount));

       $('#FinalAmount').val(Math.round(sum));
             var tax = "<?php echo $tax ?>";
         var ff = Number((Number(sum)) / 100) * Number(tax);
      ff=Number(sum+ff);
      $('#FinalAmount').val(Math.round(ff));
     // $('#total').val(Math.round(ff));
       calculate();
           //shows value in "#rate"
  
   });
</script>

<script type="text/javascript">
 $('#CashCreditAmount').on('keyup',function(){
    
     var CashCreditAmount = document.getElementById("CashCreditAmount").value;
     var CashCredit = parseInt(document.getElementById("CashCredit").value);
      
     if((parseInt(CashCreditAmount)) < (parseInt(CashCredit))){
return true;
   }
 else{
   alert("You can not use Cashcredit Amount more than CashCredit");
     return false;
 }

   });
   </script>

<script>

$('.price').on('change',function(){

   
     calculate();

 
});
</script>
<script type="text/javascript">
  function calculate(){
    var sum = 0;
     $('.price').each(function() {
        sum += Number($(this).val());
    });
     $('#total').val(sum);
     $('#remainingamount').val('');
        $( "#remainingamount" ).trigger( "change" );
     var sum2 = $('#total').val();
   //  alert(sum2);
     var FinalAmount = $('#FinalAmount').val();
     
     if(Number(sum2) < Number(FinalAmount)){
      var r = Number(FinalAmount) - Number(sum2);
  //alert(r);
      if(Number(r)>0){

       $('#remainingamount').val(Math.round(Number(r)));
       $( "#remainingamount" ).trigger( "change" );
      }
      else{
        $('#remainingamount').val('');
        $( "#remainingamount" ).trigger( "change" );
      }

     }
     else if(Number(sum2) > Number(FinalAmount)){
        alert('Please Enter valid amount');
        $('.price').val('');
        $('#total').val('');

        // $('#save').removeAttr('data-toggle');
        return false;


     }

  }
</script>

<script type="text/javascript">
 $('.check').on('change',function(){
  // calculate();
     var x= true;
          $('input[type="checkbox"]').map(function(){
            if($(this).prop("checked") == true){
            //  alert('if');
              var y=  $(this).closest('tr').find('[type=text]:first').val();
             $(this).closest('tr').find('[type=text]').prop("disabled", false);
               $(this).closest('tr').find('[type=text]:first').attr('required','');
                if (y == "")
                {
                  // alert("kindly enter values of selected PaymentType !");
                 x= false;
              }
            }
            else if($(this).prop("checked") == false){
             //  alert('else');
                 $(this).closest('tr').find('[type=text]').attr("disabled", "disabled");
                  $(this).closest('tr').find('[type=text]').val('');

            }
            calculate();
        });
          //alert(x);
       if (x == false)
        // alert('sdfsd');
         return false;


       else
        return true;

  });

 $('#disabled').on('change',function(){
  
     var x = true;
       
            if($(this).prop("checked") == true){
              var y=  $(this).closest('tr').find('[type=text]:last').val();
             $(this).closest('tr').find('[type=text]:last').prop("disabled", false);
               $(this).closest('tr').find('[type=text]:last').attr('required','');
                if (y == "")
                {
                  // alert("kindly enter values of selected PaymentType !");
                 x= false;
              }
            }
            else if($(this).prop("checked") == false){

                 $(this).closest('tr').find('[type=text]').attr("disabled", "disabled");
              
            }
       
          //alert(x);
       if (x == false)
         return false;
       else
        return true;
  });
</script>
  <script type="text/javascript">
  $('#rootscheme').on('change',function(){
     $('#BasePrice').val('');
        $('#FinalAmount').val('');
         $('#MembershipAmount').val('');
         $('#Discount2').val('');
          $('#Discount1').val('');
          $('#totaldiscount').val('');

          $('#total').val('');
           $('#finishdate').val('');
      $('#scheme').find('option:not(:first)').remove();
      var id = $('#username1').val();
     // alert($('#username1').val());
      // alert($('#username2').val());
        // assigndate();
  // $('#scheme').find('option').remove();
       var name=document.getElementById("rootscheme").value;

       var _token = $('input[name="_token"]').val();
       if(name)
       {
       $.ajax({
            url:"{{ route('scheme') }}",
            method:"POST",
            data:{name:name,id:id, _token:_token},
            success:function(result)
            {
              var data=result;
              $.each(data, function(i,item){
                  // $('#scheme').append('<option value="'+item.id+'">'+item.SchemeName+'</option>');
                  $('#scheme').append($("<option></option>").attr("value",item.schemeid).text(item.schemename));
                  // alert(item.NumberOfDays);
                    // $('#scheme').append($("<option></option>").attr("value",+item.NumberOfDays).text(item.NumberOfDays));

              })
                 
            },
            dataType:"json"
           })
      }
  });
   $(".number").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $(this).find('.errmsg').html("Digits Only are allowed gbghbdfhbdbdfgbdfgfv").show().fadeOut("slow");
               return false;
    }
   });
      $('#scheme').on('click',function(){
    assigndate();

   });
  function assigndate(){
   $('#MembershipAmount').val('');
      $('#finishdate').val('');
         $('#MembershipAmount').val('');
         $('#Discount2').val('');
          $('#Discount1').val('');
       
            $('#BasePrice').val('');
        $('#FinalAmount').val('');
  // $('#scheme').find('option').remove();
       var name = document.getElementById("scheme").value;
       var _token = $('input[name="_token"]').val();
         
       if(name)
       {
       $.ajax({
            url:"{{ route('schemeActualPrice') }}",
            method:"POST",
            data:{name:name, _token:_token},
            success:function(result)
            {
              var data=result;
             $.each(data, function(i,item){

                
                   $('#MembershipAmount').attr("value",item.schemeid).val(item.actualprice);
                     $('#BasePrice').attr("value",item.schemeid).val(item.baseprice);
         $('#FinalAmount').attr("value",item.schemeid).val(item.actualprice);
        var gsttaxamount= Number(item.actualprice-item.baseprice);
  
          $('#gsttaxamount').val(gsttaxamount);
                var x = document.getElementById("startingdate").value;
                 var date = new Date(x);
                   
                      var days=item.numberofdays-1;
                     
                 date.setDate(date.getDate(x) + parseInt(days));
                   // alert(date);
                   var month = date.getUTCMonth() + 1; //months from 1-12
                  var day = date.getUTCDate();
                  var year = date.getUTCFullYear();
                  if(day.toString().length <= 1) {
                      day = '0' + day;
                  }
                   if(month.toString().length <= 1) {
                      month = '0' + month;
                  }  
                  newdate = day + "-" + month + "-" + year ;
                  // alert(newdate);
                   $('#finishdate').val('');
                  $('#finishdate').val(newdate);
              })
                  
            },
            dataType:"json"
           })
      }
  }

</script>
<script type="text/javascript">
function clear_form_elements() {
  var s=$('#RecieptNo').val();
  $('#Package').find(':input').each(function() {

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
        $('#scheme').find('option:not(:first)').remove();
        
            break;
    }
  });
  $('#RecieptNo').val(s);
}
</script>
<script type="text/javascript">
   $('#username').on('change',function(){
    clear_form_elements();

   $('#Package').css('display','none');


    var username = $('#username').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('PackageController.getusername') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;

       $('#mobileNo').val(data.memberid);
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
     $("#username").val(data.memberid);
      },
       dataType:"json"
     });
   });
// </script>


@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#package_form').validate({
      /*rules: {
        username : {
          required : true,
          maxlength : 255
        },
        email : {
          required : true,
          maxlength : 255
        }
      }*/
    });
  });
  $('#scheme').on('change', function(){
     let scheme = $(this).val();
     let user_id = $('#username1').val();

     $.ajax({
       type : 'post',
       url : '{{ route('checktime') }}',
       data : { scheme:scheme, user_id,user_id, _token:'{{ csrf_token() }}'},
       success : function(data){
         if(data == 202){
           $('#save').attr('disabled', 'true');
           $('#package_error').text('Please select different package.');
           // alert('Please select different package.');
         } else {
           $('#save').removeAttr('disabled');
           $('#package_error').text('');

         }
       }
     });
   });
</script>
@endpush
