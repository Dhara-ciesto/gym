@extends('layouts.adminLayout.admin_design')
@push('css')
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

/* On mouse-over, add a grey backgceil color */
.container:hover input ~ .checkmark round{
  background-color: #ccc;
}
  .select2{
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
/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #3a3938;
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
@endpush
@section('content')
<!-- left column -->
<style type="text/css">
</style>
<div class="content-wrapper">
   <section class="content-header">
      <h2>Assign/Renewal Package
</h2>
   </section>
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
      <div class="alert alert-danger alert-block" id="danger-alert">
         <button type="button" class="close" data-dismiss="alert">×</button> 
         <strong>{{ $message }}</strong>
      </div>
      @endif 
      <script type="text/javascript">
         $(document).ready (function(){
                       $("#danger-alert").fadeTo(5000, 500).slideUp(500, function(){
                      $("#danger-alert").slideUp(1000);
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
      <form role="form" action="{{ url('placeorder') }}" name="frmMr" method="POST" id="package_form">
         {{ csrf_field() }}

     <!--     <div class="box box-primary" id="secondstep" >
            <div class="box-header with-border">
               <h3 class="box-title">Select Member</h3>

            </div>>
            <!-- /.box-header -->
            <!--     <div class="box-body">
               <h4><u></u></h4>
               <div class="col-lg-4">
                  <div class="input-group">
                    <input type="hidden" name="order_tax" value="{{ $tax }}">
                     <label>Username<span style="color: red">*</span></label>
                     <select name="userid" id="username"  class="form-control select2"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Username" required>
                        <option selected value="">Please choose an option</option>
                        @foreach($users as $user)
                        <?php $userid = !empty(old('selectusername')) ? old('selectusername') : 0; ?>
                        <option value="{{ $user->userid }}" @if($userid == $user->userid) selected @endif>{{ $user->username }}</option>
                        @endforeach
                     </select>
                  </div>>
                  <!-- /input-group -->
               <!--     </div>>
               <!-- /.col-lg-6 -->
                 <!--   <div class="col-lg-4">
                  <div class="input-group">
                     <label>Mobile No:</label>
                     <select name="selectmobileno" id="mobileNo" class="form-control" disabled="" >
                        <option selected >Please choose an option</option>
                        @foreach($users as $user)
                        <option value="{{ $user->userid }}" @if($userid == $user->userid) selected @endif>{{ $user->mobileno }}</option>
                        @endforeach
                     </select>
                  </div>>
                  <!-- /input-group -->
                 <!--   </div>
               <br>
               <div class="col-lg-4" style="margin-top: 5px;">
                  <div class="form-group">
                     <button type="button" id="assignPackage" class="btn bg-green">Next</button>
                  </div>
               </div> -->


           <!-----------------------------for search option------------------------------------------>
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

       <select  name="userid" id="username1" class="form-control span11 select2"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Member" required="">
        <option selected >Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->userid }}" {{$user->userid  == $i?'selected':''}}>{{ $user->username }}</option>@endforeach
        </select>
        <span id="freeze_error1" style="color: red;display: none;">Member is freeze. Please unfreeze for assign package</span>
         <span id="Expire_error1" style="color: red;display: none;">Member is Expire. Please Renew The Package</span>
      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4">
 
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo1" class="form-control " disabled="" ><option selected >Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->userid }}" {{$user->userid  == $i?'selected':''}}>{{ $user->mobileno }}</option>@endforeach
        </select>
    
<!-- /input-group -->
    </div>
    <br>

    <div class="col-lg-4" style="margin-top: -20px;">
      <div class="form-group">
       <button type="button" id="next1" class="btn bg-green">Next</button>
      </div>
    </div>
  </div>

  <!-- /**********************end serachbyusername **********************/ --> 
   <!-- /**********************start serachbymobileno **********************/ --> 
     <div class="box-body" id="serachbymobileno" style="display: none; margin-top: -20px;"> 
 
      <div class="col-lg-4">
  
      
        <!-- <label>Username<span style="color: red">*</span></label> -->

       <select name="userid" id="username2"  class="form-control " disabled="" ><option selected >Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->userid }}">{{ $user->username }}</option>@endforeach
        </select>

      
      <!-- /input-group -->
      </div>
<!-- /.col-lg-6 -->
    <div class="col-lg-4" >
      
        <!-- <label>Mobile No:</label> -->
        <select name="selectmobileno" id="mobileNo2" class="form-control select2"title="Select Mobileno" data-live-search="true"  data-actions-box="true" ><option selected >Please choose an option</option>@foreach($users as $user)
        <option value="{{ $user->userid }}">{{ $user->mobileno }}</option>@endforeach
        </select>
         <span id="freeze_error2" style="color: red;display: none;">Member is freeze. Please unfreeze for assign package</span>
           <span id="Expire_error2" style="color: red;display: none;">Member is Expire. Please Renew The package</span>
      
<!-- /input-group -->
    </div>
    <br>

    <div class="col-lg-4" style="margin-top: -20px;">
      <div class="form-group">
       <button type="button" id="next2" class="btn bg-green">Next</button>
      </div>
    </div>
  </div>
   <div class="col-lg-10" id="package_detail" style="display: none;">
                   <br>
                    <div class="col-lg-12">
                     
                      <div id="package_data" class="table table-responsive"> <label>Member Packages</label></div>
                    </div>
                  
                  </div>
        <div class="box-body">
 <div class="col-lg-12" id="Package" style="display: none" class="Package">


            
                  <hr style="border-width: 2px;border-color: black">
<!--                   <h4><u>Assign Package</u></h4>
 -->                   <div class="col-lg-5">
                     <div class="form-group">
                      <input type="hidden" name="order_tax" value="{{ $tax }}">
                        <label>Select Root Scheme<span style="color: red">*</span></label>
                        <select name="RootSchemeId" id="rootscheme" class="form-control select2"class="span11" required>
                           <option value="" selected readonly>Please choose an option</option>
                           @foreach($RootScheme as $rscheme)
                           <option value="{{ $rscheme->rootschemeid }}">{{ $rscheme->rootschemename }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group">
                      <label>Join Date</label>
                      <input placeholder="Joining date" onchange="changedate()" type="date" readonly id="startingdate"  value="<?php echo date('Y-m-d'); ?>"class="form-control" name="Join_date" class="span11">
 
                    </div>
                    
                     <div class="form-group">
                        <label>Base Amount</label>
                        <input type="hidden" name="BasePrice_hidden" id="BasePrice_hidden" />
                        <input type="text" name="BaseAmount" id="BasePrice" class="form-control number" placeholder="Base Amount"   class="span11" readonly="" />
                     </div>

                    <div class="form-group">
                        <label>Discount</label>
                        <input type="text"  name="Discount" autocomplete="off" id="Discount1" class="form-control number" placeholder="Discount"  value="0" class="span11" />
                        <div class="col-md-6 col-lg-6 col-sm-6">
                           <input type="radio" name="discount_radio" checked="" id="rs" value="rs"><label>Rs</label>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6">
                           <input type="radio" name="discount_radio" id="percentage" value="percentage"><label>Percentage</label>
                        </div>
                    </div>

                     <div class="form-group">
                       <label>Final Amount</label>
                       <input type="text" name="ActualAmount" id="FinalAmount"class="form-control" placeholder="Final Amount" class="span11" readonly="" />
                       <div class="col-md-6 col-lg-6 col-sm-6">
                           <label><input type="radio" name="tax_radio" id="with_tax" checked="checked" value="withtax" />With Tax</label>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6">
                          <label> <input type="radio" name="tax_radio" id="without_tax" value="withouttax">Without Tax</label>
                        </div>
                     </div>

                    

                    <div class="form-group">
                        <label>Total</label>
                        <input type="hidden" name="total_hidden" id="total_hidden">
                        <input type="text" maxlength="10" name="total_amount" id="total_amount" class="form-control number" placeholder="Total"  value="0" class="span11" readonly="" />
                    </div>
                    
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Select Package<span style="color: red">*</span></label>
                      <select name="SchemeID" id="scheme" onchange="assigndate()" class="form-control select2"class="span11" required="">
                         <option value="" selected readonly>Please choose an option</option>
                      </select>
                      <span id="package_error" style="color:red"></span>
                   </div>
                    
                   <div class="form-group">
                     <label>Finish Date</label>
                     <input placeholder="Finishing date"  id="finishdate" class="form-control" name="Expire_date" class="span11" readonly="" >
                   </div>
                    

                    <div class="form-group">
                        <label>Amount To Be Paid</label>
                        <input type="text" name="amount_paid" class="form-control number" placeholder="Amount To Be Paid" id="amount_paid"  class="span11" autocomplete="off" required="" />
                        <input type="hidden" name="PaymentDate"  value="{{Carbon\Carbon::today()->format('Y-m-d')}}" />
                    </div>


                    <div class="form-group" style="margin-bottom: 28px;">
                        <label>Remaining Amount</label>
                        <input type="text" name="remaining_amount" class="form-control number" placeholder="Remaining Amount" id="remainingamount"  class="span11" readonly="" />
                        <input type="hidden" name="PaymentDate"  value="{{Carbon\Carbon::today()->format('Y-m-d')}}" />
                    </div>

                  <div class="form-group">
                       <label>Due Date</label>
                       <input type="date" name="due_date" id="due_date" class="form-control" placeholder="Final Amount" class="span11" min="{{ date('Y-m-d')}}" />
                       <span id="duedate_error" style="color: red;display: none;">Please Select Due Date</span>
                  </div>
                  </div>
                  {{session()->put('orderview','1')}}
                  
                   <div class="col-lg-8">
                     <div class="form-group">
                        <div class="col-sm-offset-6">
                           <button type="submit"   id="save" value="button" name="order_btn"  class="btn bg-green margin" disabled="">Next</button>
                           <button type="button"   id="otp_button" value="button" data-backdrop="static" data-keyboard="false" name="order_btn" data-toggle="modal" data-target="#otpmodel"  class="btn bg-green margin" style="display: none;">Next</button>
                           <a disabled class="btn bg-green" id="btnnew" style="display: none;">Submitting</a>
                           <a href="{{ url('assignPackageOrRenewalPackage') }}"class="btn bg-red margin">Cancel</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /.box-body -->
</div>
<div class="modal fade" id="otpmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">OTP for Assign Package</h5>

      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-6">
            <label>Select Admin<span style="color: red;">*</span></label>
            <select name="admin" class="form-control" id="admin_id">
              <option value="">Select</option>
              @if(!empty($admin))
              @foreach($admin as $admin_data)
              <option value="{{ $admin_data->employeeid}}">{{ ucfirst($admin_data->first_name) }} {{ ucfirst($admin_data->last_name) }} ({{ $admin_data->mobileno }})</option>
              @endforeach
              @endif
            </select>
            <span id="admin_error" style="color: red;display: none;">Please Select admin</span>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6" id="otp_box">
            <label>OTP<span style="color:red;">*</span></label>
            <input type="text" name="otp_extend" id="otp_value" class="form-control number" >
            <span id="otp_error" style="color: red;display: none;">OTP is incorrect</span>
            <span id="otp_required" style="color: red;display: none;">Please enter OTP</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="send_otp" class="btn bg-green">Send OTP</button>
        <button type="button" id="verify" class="btn bg-green" style="display: none;">Verify OTP</button>
        <a class="btn btn-warning" id="process" style="display: none;" disabled=""><span id="btn_text">Sending...</span></a>
        <a href="{{ url('assignPackageOrRenewalPackage') }}"class="btn bg-red">Cancel</a>
      </div>
    </div>
  </div>
</div>
</form>
</section>
</div>
 
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
   $('#next1').on('click',function(){
    
     var username = document.getElementById("username1").value;
     var MobileNo = document.getElementById("mobileNo1").value;
var _token = $('input[name="_token"]').val();
       $.ajax({
         url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, MobileNo:MobileNo, _token:_token},
      success:function(result)
      {
      
       if(result!= null)
       {
      
        var data=result;

         // $('#CashCredit').val(data);
          $('#with_tax').prop('checked', 'true');
       $('#rs').prop('checked', 'true');
         $('#Package').css('display','block');
           $.ajax({
          type : 'POST', 
          url : '{{ url('memberpackagehistory') }}',
          data : {userid:username, _token:'{{ csrf_token() }}'},
          success : function(data){
            if(data){

             $('#package_detail').show();
            $('#package_data').empty();
          $('#package_data').append(data);
          }
           }
        });

       
       }
       else
       {
       
         $('#Package').css('display','none');
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
      url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, MobileNo:MobileNo, _token:_token},
      success:function(result)
      {
      
       if(result!= null)
       {
      
        var data=result;
        // $('#CashCredit').val(data);
          $('#with_tax').prop('checked', 'true');
       $('#rs').prop('checked', 'true');
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
   $('#assignPackage').on('click',function(){
    
     var username = document.getElementById("username").value;
     var MobileNo = document.getElementById("mobileNo").value;
     
     if(username){
       $('#with_tax').prop('checked', 'true');
       $('#rs').prop('checked', 'true');
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
      } else {
        alert('Please Select Username');
      }
   
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
     
         // assigndate();
   // $('#scheme').find('option').remove();
        var name=document.getElementById("rootscheme").value;
   
        var _token = $('input[name="_token"]').val();
        if(name)
        {
        $.ajax({
             url:"{{ route('schemeforpayment') }}",
             method:"POST",
             data:{name:name,id:id, _token:_token},
             success:function(result)
             {
               var data=result;
               $.each(data, function(i,item){
                   // $('#scheme').append('<option value="'+item.id+'">'+item.SchemeName+'</option>');
                  $('#scheme').append($("<option></option>").attr("value",item.schemeid).text(item.schemename));
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
  
  function assigndate() {
    $('#MembershipAmount').val('');
    $('#finishdate').val('');
    $('#MembershipAmount').val('');
    $('#Discount2').val('');
    $('#Discount1').val('');

    $('#BasePrice').val('');
    $('#FinalAmount').val('');

    var name = document.getElementById("scheme").value;
    var _token = $('input[name="_token"]').val();
    let tax = <?php echo $tax; ?>;

    if (name) {
        $.ajax({
            url: "{{ route('schemeActualPrice') }}",
            method: "POST",
            data: {
                name: name,
                _token: _token
            },
            success: function(result) {
                var data = result;
                $.each(data, function(i, item) {

                    let baseprice = item.baseprice;
                    baseprice_tax = parseFloat((Math.ceil(baseprice)) / 100) * parseInt(tax);
                    let baseprice_final = parseFloat(Math.ceil(baseprice) + Number(baseprice_tax));

                    $('#MembershipAmount').attr("value", item.schemeid).val(Math.ceil(item.actualprice));
                    $('#BasePrice').attr("value", item.schemeid).val(Math.ceil(baseprice));
                    $('#BasePrice_hidden').attr("value", item.schemeid).val(Math.ceil(baseprice));
                    $('#FinalAmount').attr("value", item.schemeid).val(Math.ceil(baseprice_final));
                    $('#total_amount').attr("value", item.schemeid).val(Math.ceil(baseprice_final));
                    $('#total_hidden').attr("value", item.schemeid).val(Math.ceil(baseprice_final));
                    $('#amount_paid').val('');
                    $('#remainingamount').val(Math.ceil(baseprice_final));
                    $('#startingdate').attr('readonly',false);
                    var x = document.getElementById("startingdate").value;

                    var date = new Date();

                    var days = item.numberofdays - 1;

                    date.setDate(date.getDate(x) + parseInt(days));

                    var month = date.getUTCMonth() + 1; //months from 1-12
                    var day = date.getUTCDate();
                    var year = date.getUTCFullYear();
                    if (day.toString().length <= 1) {
                        day = '0' + day;
                    }
                    if (month.toString().length <= 1) {
                        month = '0' + month;
                    }
                    newdate = day + "-" + month + "-" + year;
                    // alert(newdate);
                    $('#finishdate').val('');
                    $('#finishdate').val(newdate);
                })

            },
            dataType: "json"
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
   $('#username1').on('change',function(){
    clear_form_elements();
   
   $('#Package').css('display','none');
   
   
    var username = $('#username1').val();
      var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
       // console.log(data);
     if(data.status == 2){
       $('#freeze_error1').show();
       $('#next1').attr('disabled', 'true');
      }else{
       $('#freeze_error1').hide();
       $('#next1').removeAttr('disabled');
      }
      if(data.status == 0){
       $('#Expire_error1').show();
      // $('#next1').attr('disabled', 'true');
      }else{
       $('#Expire_error1').hide();
      // $('#next1').removeAttr('disabled');
      }
      $('#mobileNo1').val(data.userid);
       $("#username2").val(data.userid);
       $('#mobileNo2').val(data.userid);
        $('#package_data').empty();
      // $('#mobileNo').val();
      },
       dataType:"json"
     });
   });
</script>
<script type="text/javascript">
   $('#mobileNo2').on('change',function(){
    var username = $('#mobileNo2').val();
    var _token = $('input[name="_token"]').val();
     $.ajax({
        url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
      var data=result;
        if(data.status == 2){
       $('#freeze_error2').show();
       $('#next2').attr('disabled', 'true');
      }else{
       $('#freeze_error2').hide();
       $('#next2').removeAttr('disabled');
      }
       if(data.status == 0){
       $('#Expire_error2').show();
      // $('#next2').attr('disabled', 'true');
      }else{
       $('#Expire_error2').hide();
     //  $('#next2').removeAttr('disabled');
      }
   
      // $('#username').attr("value",data.username).val(data.username);
      $("#username2").val(data.userid);
     $("#username1").val(data.userid);
     $("#mobileNo1").val(data.userid);
             $('#package_data').empty();
      },
       dataType:"json"
     });
   });
   // 
</script>
@endsection
@push('script')
<script type="text/javascript">
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
            $('#package_error').text('Package time is mismatched,Kindly select other package');
            // alert('Please select different package.');
          } else {
            //$('#save').removeAttr('disabled');
            $('#package_error').text('');
   
          }
        }
      });
  });



  $(document).on('change', '#amount_paid', function(){
    let amount_paid = $(this).val();
    let remainingamount = $('#remainingamount').val();
  });

  $(document).on('change', '#due_date', function(){
    let amount_paid = $('#amount_paid').val();
    
    if(amount_paid == 0 || amount_paid.length > 0 ){
      $('#save').removeAttr('disabled');
    }
  });

  $(document).on('focus', '#due_date', function(){
    $('#duedate_error').css('display', 'none');
  });




function changedate(){

  var name = document.getElementById("scheme").value;
  var _token = $('input[name="_token"]').val();
  let tax = {{ $tax }};

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



        var x = document.getElementById("startingdate").value;
        
        var date = new Date(x);

        var days=item.numberofdays-1;
        

        date.setDate(date.getDate(x) + parseInt(days));
                    
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
                   //alert(newdate);
                   $('#finishdate').val('');
                   $('#finishdate').val(newdate);
                 })

     },
     dataType:"json"
   })
  }
}// end of changedate() function

function calculate(){

  let baseprice = Number($('#BasePrice').val());
  let finalamount = Number($('#FinalAmount').val());
  let with_tax = $('#with_tax').is(':checked');
  let without_tax = $('#without_tax').is(':checked');
  let rs = $('#rs').is(':checked');
  let percentage = $('#percentage').is(':checked');
  let discount = Number($('#Discount1').val());
  let total_amount = Number($('#total_amount').val());
  let amount_paid = Number($('#amount_paid').val());
  let remaining_amount = Number($('#remaining_amount').val());
  let due_date = $('#due_date').val();
  let total_hidden = Number($('#total_hidden').val());
  let tax = {{$tax}};

  //without tax start
  if(without_tax == true){

    $('#FinalAmount').val(parseInt(baseprice));
    //if rs checked
    if(rs == true){
      if(discount > 0){

        if(Number(discount) <= Number(baseprice)){
          calculate_discount = baseprice - discount;
          $('#total_amount').val(Math.ceil(Number(calculate_discount)));


          //start of amount to be paid > 0
          let updated_total_amount = $('#total_amount').val();
          if(amount_paid > 0 && amount_paid <= updated_total_amount){
            let paid_remaining = updated_total_amount - amount_paid;
            $('#remainingamount').val(Math.ceil(paid_remaining));
            let update_remainingamount = $('#remainingamount').val();
            if(update_remainingamount == 0){
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }else{
              if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                  $('#duedate_error').show();
                  $('#save').attr('disabled', 'true');
                }else{
                  $('#duedate_error').hide();
                  $('#save').removeAttr('disabled');
                }
              }
            }  
          } else if(amount_paid > updated_total_amount){
            alert('Please enter valid paid amount');
            $('#amount_paid').val('');
            $('#remainingamount').val(Math.ceil(Number(calculate_discount)));
          } else {
            $('#remainingamount').val(Math.ceil(Number(calculate_discount)));

            let update_remainingamount = $('#remainingamount').val();  
            if(update_remainingamount == 0){
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }else{
              if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                  $('#duedate_error').show();
                  $('#save').attr('disabled', 'true');
                }else{
                  $('#duedate_error').hide();
                  $('#save').removeAttr('disabled');
                }
              }
            } 
          }
          //end of amount to be paid > 0
        } else {
          $('#Discount1').val('');
          $('#remainingamount').val('');
          alert('Amount shoud not be greater than Base Amount');
        }// end of Number(discount) < Number(baseprice)  
      }// end of discount > 0
      else{
        $('#total_amount').val(parseInt(Number(baseprice)));
        let updated_total_amount = $('#total_amount').val();
         if(amount_paid > 0 && amount_paid <= updated_total_amount){
            let paid_remaining = updated_total_amount - amount_paid;
            $('#remainingamount').val(Math.ceil(paid_remaining));
            let update_remainingamount = $('#remainingamount').val();
            if(update_remainingamount == 0){
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }else{
              if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                  $('#duedate_error').show();
                  $('#save').attr('disabled', 'true');
                }else{
                  $('#duedate_error').hide();
                  $('#save').removeAttr('disabled');
                }
              }
            }  
          } else if(amount_paid > updated_total_amount){
            alert('Please enter valid paid amount');
            $('#amount_paid').val('');
            $('#remainingamount').val(Math.ceil(Number(baseprice)));
          } else {
            $('#remainingamount').val(Math.ceil(Number(baseprice)));

            let update_remainingamount = $('#remainingamount').val();  
            if(update_remainingamount == 0){
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }else{
              if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                $('#duedate_error').show();
                $('#save').attr('disabled', 'true');
              }else{
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }
              }
            } 
          }
        //$('#FinalAmount').val(Math.ceil(Number(baseprice)));
        //$('#remainingamount').val(Math.ceil(Number(baseprice)));

        let update_remainingamount = $('#remainingamount').val();  
        if(update_remainingamount == 0){
          $('#save').removeAttr('disabled');
          $('#duedate_error').hide();
        }else{
          if(due_date.length > 0){
            $('#save').removeAttr('disabled');
            $('#duedate_error').hide();
          }else{
            if(Number(amount_paid) != 0){
              $('#duedate_error').show();
              $('#save').attr('disabled', 'true');
            }else{
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }
          }
        }
      }// end of else od discount > 0
    }
    //if rs checked end
    
    // if percentage start
    if(percentage == true){
      $('#FinalAmount').val(parseInt(baseprice));
      if(Number(discount) > 100){
        $('#Discount1').val('');
        $('#remainingamount').val(Math.ceil(baseprice));
        $('#total_amount').val(Math.ceil(baseprice));
        alert('Discount should not be greater than 100');
      } else {
        let baseamount_disount_cal = Number((baseprice/100)) * Number(discount);
        let percentage_discount = baseprice - baseamount_disount_cal;
        $('#total_amount').val(Math.ceil(percentage_discount));

        let updated_total_amount = $('#total_amount').val();

        if(amount_paid > 0 && amount_paid <= updated_total_amount){
          let paid_remaining = updated_total_amount - amount_paid;
          $('#remainingamount').val(Math.ceil(paid_remaining));

          let update_remainingamount = $('#remainingamount').val();  
          if(update_remainingamount == 0){
            $('#save').removeAttr('disabled');
            $('#duedate_error').hide();
          }else{
            if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                $('#duedate_error').show();
                $('#save').attr('disabled', 'true');
              }else{
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }
              }
          }  

        } else if(amount_paid > updated_total_amount){

          alert('Please enter valid paid amount');
          $('#amount_paid').val('');
          $('#remainingamount').val(Math.ceil(Number(percentage_discount)));

        } else {
          $('#remainingamount').val(Math.ceil(Number(percentage_discount)));

          let update_remainingamount = $('#remainingamount').val();
          if(update_remainingamount == 0){
            $('#save').removeAttr('disabled');
            $('#duedate_error').hide();
          }else{
            if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                $('#duedate_error').show();
                $('#save').attr('disabled', 'true');
              }else{
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }
              }
          }

        }
          //end of amount to be paid > 0
      }//end discount > 100  
    }
    // if percentage end

  }
  //without tax end


  //with tax start
    if(with_tax == true){
    
      let discount_tax = Number(Number(baseprice/100)) * Number(tax);
      let final_amount_tax = Number(baseprice) + Number(discount_tax);
      
      $('#FinalAmount').val(Math.ceil(final_amount_tax));
    //if rs checked
    if(rs == true){
      if(discount > 0){

        if(Number(discount) <= Number(baseprice)){
          let calculate_discount = baseprice - discount;
          let discount_tax = Number(Number(calculate_discount/100)) * Number(tax);
          let final_amount_tax = Number(calculate_discount) + Number(discount_tax);
         
          $('#total_amount').val(Math.ceil(Number(final_amount_tax)));


          //start of amount to be paid > 0
          let updated_total_amount = $('#total_amount').val();
          if(amount_paid > 0 && amount_paid <= updated_total_amount){
            let paid_remaining = updated_total_amount - amount_paid;
            $('#remainingamount').val(Math.ceil(paid_remaining));
            let update_remainingamount = $('#remainingamount').val();
            if(due_date.length > 0 || update_remainingamount == 0){
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }else{
              if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                  $('#duedate_error').show();
                  $('#save').attr('disabled', 'true');
                }else{
                  $('#save').removeAttr('disabled');
                  $('#duedate_error').hide();
                }
              }
            }  
          } else if(amount_paid > updated_total_amount){
            alert('Please enter valid paid amount');
            $('#amount_paid').val('');
            $('#remainingamount').val(Math.ceil(Number(final_amount_tax)));
          } 
          else {
            $('#remainingamount').val(Math.ceil(Number(final_amount_tax)));

            let update_remainingamount = $('#remainingamount').val();  
            if(update_remainingamount == 0){
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }else{
             if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                  $('#duedate_error').show();
                  $('#save').attr('disabled', 'true');
                }else{
                  $('#save').removeAttr('disabled');
                  $('#duedate_error').hide();
                }
              }
            } 
          }
          //end of amount to be paid > 0
        } else {
          $('#Discount1').val('');
          $('#remainingamount').val(Math.ceil(finalamount));
          $('#total_amount').val(Math.ceil(finalamount));
          alert('Amount shoud not be greater than Base Amount');
        }// end of Number(discount) < Number(baseprice)  
      }// end of discount > 0
      else{
        discount = 0;
        $('#total_amount').val(Math.ceil(final_amount_tax));
        let updated_total_amount = $('#total_amount').val();

        if(amount_paid > 0 && amount_paid <= updated_total_amount){
          let paid_remaining = updated_total_amount - amount_paid;
          $('#remainingamount').val(Math.ceil(paid_remaining));
          let update_remainingamount = $('#remainingamount').val();
          if(update_remainingamount == 0){
            $('#save').removeAttr('disabled');
            $('#duedate_error').hide();
          }else{
            if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                  $('#duedate_error').show();
                  $('#save').attr('disabled', 'true');
                }else{
                  $('#save').removeAttr('disabled');
                  $('#duedate_error').hide();
                }
              }
          }
        }else if(amount_paid > updated_total_amount){
          alert('Please enter valid paid amount');
          $('#amount_paid').val('');
          $('#remainingamount').val(Math.ceil(Number(final_amount_tax)));
        }else { 
          $('#FinalAmount').val(Math.ceil(Number(final_amount_tax)));
          $('#remainingamount').val(Math.ceil(Number(final_amount_tax)));
          $('#total_amount').val(Math.ceil(Number(final_amount_tax)));

          let update_remainingamount = $('#remainingamount').val();  
          if(update_remainingamount == 0){
            $('#save').removeAttr('disabled');
            $('#duedate_error').hide();
          }else{
            if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
               if(Number(amount_paid) != 0){
                  $('#duedate_error').show();
                  $('#save').attr('disabled', 'true');
                }else{
                  $('#save').removeAttr('disabled');
                  $('#duedate_error').hide();
                }
              }
          }

        }
      }// end of else od discount > 0
    }
    //if rs checked end
    
    // if percentage start
    if(percentage == true){
      if(Number(discount) > 100){

        $('#Discount1').val('');
        $('#remainingamount').val(Math.ceil(finalamount));
        $('#total_amount').val(Math.ceil(finalamount));
        alert('Discount should not be greater than 100');
      } else {
        let baseamount_disount_cal = Number((baseprice/100)) * Number(discount);
        let percentage_discount = baseprice - baseamount_disount_cal;
        let discount_tax = Number(Number(percentage_discount/100)) * Number(tax);
        
        let final_amount_tax = Number(percentage_discount) + Number(discount_tax); 

        $('#total_amount').val(Math.ceil(final_amount_tax));

        let updated_total_amount = $('#total_amount').val();
        if(amount_paid > 0 && amount_paid <= updated_total_amount){
          let paid_remaining = updated_total_amount - amount_paid;
          $('#remainingamount').val(Math.ceil(paid_remaining));
          let update_remainingamount = $('#remainingamount').val();
          if(update_remainingamount == 0){
            $('#save').removeAttr('disabled');
            $('#duedate_error').hide();
          }else{
            if(due_date.length > 0){
              $('#save').removeAttr('disabled');
              $('#duedate_error').hide();
            }else{
              if(Number(amount_paid) != 0){
                $('#duedate_error').show();
                $('#save').attr('disabled', 'true');
              }else{
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }
            } 
            //$('#save').attr('disabled', 'true');
          }

        } else if(amount_paid > updated_total_amount){
          alert('Please enter valid paid amount');
          $('#amount_paid').val('');
          $('#remainingamount').val(Math.ceil(Number(final_amount_tax)));
        } else {
          $('#remainingamount').val(Math.ceil(Number(final_amount_tax))); 

          let update_remainingamount = $('#remainingamount').val();  
          if(update_remainingamount == 0){
            $('#save').removeAttr('disabled');
            $('#duedate_error').hide();
          }else{
            if(due_date.length > 0){
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }else{
                if(Number(amount_paid) != 0){
                $('#duedate_error').show();
                $('#save').attr('disabled', 'true');
              }else{
                $('#save').removeAttr('disabled');
                $('#duedate_error').hide();
              }
              }
          }
        }
          //end of amount to be paid > 0
      }//end discount > 100  
    }
    // if percentage end

  }

  //with tax end 


  



}

$('#without_tax').click(function(){

  if($(this).is(':checked')){
    calculate();
  }


});

$('#with_tax').click(function(){

  if($(this).is(':checked')){
    calculate();
  }


});

$('#percentage').click(function(){

  if($(this).is(':checked')){
    calculate();
  }


});

$('#rs').click(function(){

  if($(this).is(':checked')){
    calculate();
  }


});

$('#Discount1').keyup(function(){
  let discount = $(this).val();

 
    calculate();
  
});

$('#amount_paid').on('input',function(){
  let paid_amount = $(this).val();
  //console.log(paid_amount);
  var role='<?php echo session()->get('role');?>';

    calculate();
  if(paid_amount){
        if(paid_amount == 0 || paid_amount < 0 ){
          if(!role=='admin'){
            $('#otp_button').show();
            $('#save').hide();
          }

      }
 
  }

  
});

$('#save').click(function(){
  let amount_paid = $('#amount_paid').val();
  if(amount_paid.length > 0){
    $('#btnnew').show();
    $('#save').hide();
  }
});


  $('#send_otp').click(function(){
      let admin_id = $('#admin_id').val();
      $('#otp_error').hide();
      $('#otp_value').val('');

      if(admin_id){
      $('#process').show();
      $('#send_otp').hide();
        $.ajax({
          type : 'POST', 
          url : '{{ url('sendotp') }}',
          data : {admin_id:admin_id,_token:'{{ csrf_token() }}'},
          success : function(data){
            if(data == true){
              alert('OTP is send');
              $('#send_otp').hide();
              $('#verify').show();
              $('#process').hide();
            }else{
              $('#send_otp').show();
              $('#send_otp').text('Resend OTP');
              $('#process').hide();
            }
          }
        });
      }else{
        $('#admin_error').show();
      }
    });


    $('#verify').click(function(){
      let otp = $('#otp_value').val();
      let admin_id = $('#admin_id').val();
      if(otp){
        $('#otp_error').hide();
        $('#otp_required').hide();
        $.ajax({
          type : 'POST', 
          url : '{{ route('verifyotpforpackage') }}',
          data : {admin_id:admin_id,otp:otp, _token:'{{ csrf_token() }}'},
          success : function(data){
            if(data == 'true'){
              $('#otp_error').hide();
              $('#package_form').submit();
             
            }else{
              $('#otp_error').show();
              $('#verify').hide();
              $('#send_otp').show();
              $('#send_otp').text('Resend OTP');
            }
          }
        });



      }else{
        $('#otp_required').show();
      }
    });

</script>

<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
  
  })
</script>
@endpush