
@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
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
</style>
@endpush
@section('content')

  <div class="content-wrapper">
   <section class="content-header">
      <h2>Upgrade Package</h2>
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

      <form role="form" action="{{ url('packageupgradeorder') }}" name="frmMr" method="POST" id="package_form">
         {{ csrf_field() }}

         <div class="box box-primary" id="secondstep" >
            <div class="box-header with-border">
               <h3 class="box-title">Select Member</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <h4><u></u></h4>
               <div class="col-lg-4">
                  <div class="input-group">
                     <label>User Name<span style="color: red">*</span></label>
                     <select name="userid" id="userid"  class="form-control select2"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Username" required>
                        @if(!empty($users))
                        <option selected value="">Please choose an option</option>
                        @foreach($users as $user)
                        <option value="{{ $user->userid }}">{{ ucfirst($user->username) }}</option>
                        @endforeach
                        @else
                        <option value="">No Member Available </option>
                        @endif
                     </select>
                  </div>
                  <!-- /input-group -->
               </div>
               <!-- /.col-lg-6 -->
               <div class="col-lg-4">
                  <div class="input-group">
                     <label>Mobile No:</label>
                     <select name="selectmobileno" id="mobileNo" class="form-control" disabled="" >
                        @if(!empty($users))
                        <option selected >Please choose an option</option>
                        @foreach($users as $user)
                        <option value="{{ $user->userid }}">{{ $user->mobileno }}</option>
                        @endforeach
                        @else
                        <option value="">No Member Available </option>
                        @endif
                     </select>
                  </div>
                  <!-- /input-group -->
               </div>
               <br>
               <div class="col-lg-4" style="margin-top: 5px;">
                  <div class="form-group">
                     <button type="button" id="assignPackage" class="btn bg-green">Next</button>
                  </div>
               </div>

                <div class="col-lg-12" id="Package" style="display: none" class="Package">

                  <hr style="border-width: 2px;border-color: black">
<!--                   <h4><u>Upgrade Package</u ></h4>
 -->                  <div class="row">
                    <input type="hidden" name="joindate_hidden" id="joindate_hidden">
                    <div class="col-md-6 col-lg-6">
                     <div class="form-group">
                        <input type="hidden" name="old_package_price" id="old_package_price">
                        <input type="hidden" name="tax" id="tax">
                        <input type="hidden" name="tax_amount" id="tax_amount">
                        <input type="hidden" name="price_difference_global" id="price_difference_global">
                        <input type="hidden" name="new_price_global" id="new_price_global">
                        <label>Member Package<span style="color: red">*</span></label>
                        <select name="memberpackage" id="memberpackage" class="form-control select2"class="span11" required>
                           {{-- <option value="" selected readonly>Please choose an option</option>
                           @foreach($RootScheme as $rscheme)
                           <option value="{{ $rscheme->rootschemeid }}">{{ $rscheme->rootschemename }}</option>
                           @endforeach --}}
                        </select>
                        <span id="memberpackageprice_error" style="color: red;display: none;">Please select package</span>
                        <span id="exist_error" style="color: red;display: none;">Package already upgraded.Please select different package</span>
                     </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                       <label>Upgrade Package<span style="color: red">*</span></label>
                       <select name="upgradepackage" class="form-control select2" id="upgradepackage">
                          <option value="">Select Memberpackage</option>
                        {{-- @if(!empty($packages))
                          @foreach($packages as $package)
                            <option value="{{ $package->schemeid }}">{{ $package->schemename }}</option>
                          @endforeach
                        @else
                          <option value="">No Package Available</option>
                        @endif --}}

                       </select>

                      </div>
                    </div>

                  </div>

                  <div class="row">
                     <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                        <label>Package Price</label>
                        <input type="text" name="memberpackageprice" id="memberpackageprice" class="form-control number" placeholder="Package Price"   class="span11" readonly="" />
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                         <label>Upgrade Package Price</label>
                         <input type="text" placeholder="Upgrade Package Price"  id="upgradepackage_price" class="form-control" name="upgradepackage_price" class="span11" readonly="" >
                      </div>
                    </div>
                  </div>

                  <div class="row">

                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label>Old Discount</label>
                          <input type="text"  name="discount" autocomplete="off" id="discount" class="form-control number" placeholder="Discount" class="span11" readonly="" />
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label>Price Difference</label>
                          <input type="text"  name="price_difference" autocomplete="off" id="price_difference" class="form-control number" placeholder="Price Difference"  value="0" class="span11" readonly="" />
                      </div>
                    </div>
                  </div>

                  <div class="row">

                   <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                      <label>Discount</label>
                      <input type="text" name="apply_discount" class="form-control number" placeholder="Apply Discount" id="apply_discount"  class="span11" autocomplete="off" />
                         <div class="col-md-6 col-lg-6 col-sm-6">
                         <input type="radio" name="discount_radio" checked="" id="rs" value="rs"><label>Rs</label>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6">
                           <input type="radio" name="discount_radio" id="percentage" value="percentage"><label>Percentage</label>
                        </div>
                      <input type="hidden" name="PaymentDate"  value="{{Carbon\Carbon::today()->format('Y-m-d')}}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                      <label>Total Discount</label>
                      <input type="text" name="total_discount" readonly="" class="form-control number" placeholder="Total Discount" id="total_discount"  class="span11" autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="row">

                  <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label>Final Amount</label>
                          <input type="text"  name="final_amount" autocomplete="off" id="final_amount" class="form-control number" placeholder="Final Amount"  value="0" class="span11" readonly="" />
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label>Amount To Be Paid<span style="color: red">*</span></label>
                          <input type="text" name="amount_paid" class="form-control number" placeholder="Amount To Be Paid" id="amount_paid"  class="span11" autocomplete="off" required="" />
                          <input type="hidden" name="PaymentDate"  value="{{Carbon\Carbon::today()->format('Y-m-d')}}" />
                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                        <label>Remaining Amount</label>
                        <input type="text" name="remaining_amount" class="form-control number" placeholder="Remaining Amount" id="remainingamount"  class="span11" readonly="" />
                      </div>
                    </div>


                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                           <label>Due Date</label>
                           <input type="date" name="due_date" id="due_date" class="form-control" placeholder="Final Amount" class="span11" min="{{ date('Y-m-d')}}" onkeypress="return false" />
                           <span id="due_date_error" style="color: red;display: none;">Please Select Due Date</span>
                      </div>
                    </div>
                  </div>

                    <div class="row">
                    <div class="col-md-6 col-lg-6">
                      <label>Join Date</label>
                      <input placeholder="Joining date" type="date" onkeypress="return false" id="startingdate" readonly=""  class="form-control" name="Join_date" class="span11">
                    </div>
                    <div class="col-md-6 col-lg-6">
                      <label>Finish Date</label>
                      <input placeholder="Finishing date"  id="finishdate" class="form-control" name="Expire_date" class="span11" readonly="" >
                    </div>
                  </div>

                  {{ session()->put('packageupgrade','1') }}
                  <div class="row">
                    <div class="col-lg-8">
                     <div class="form-group">
                        <div class="col-sm-offset-6">
                           <button type="button"   id="save" value="button" name="order_btn"  class="btn bg-green margin" disabled="">Next</button>

                           <button type="button" data-toggle="modal" data-target="#otpmodel"  id="next_otp" value="button" name="order_btn"  class="btn bg-orange margin" style="display: none;">Next</button>

                           <a disabled class="btn bg-orange" id="btnnew" style="display: none;">Submitting</a>
                           <a href="{{ url('packageupgrade') }}"class="btn bg-red margin">Cancel</a>
                        </div>
                     </div>
                    </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /.box-body -->
         <div class="modal fade" id="otpmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">OTP for Upgrade Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Select Admin<span style="color: red;">*</span></label>
                    <select name="admin" class="form-control select2" id="admin_id">
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
                <button type="button" id="send_otp" class="btn bg-orange">Send OTP</button>
                <button type="button" id="verify" class="btn bg-green" style="">Verify OTP</button>
                <a class="btn btn-warning" id="process" style="display: none;" disabled=""><span id="btn_text">Sending...</span></a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

</div>
</form>
</section>
</div>






@endsection
@push('script')
<script type="text/javascript">
  //var tax = '';
  //var joindate = '';
  $(document).ready(function(){

    /*`var old_package_price = 0;
        var discount = 0;
        var tax = 0;
        var price_difference_global = 0;
        var new_price_global = 0;`*/

  });

  $('#userid').on('change',function(){
    $('#Package').css('display','none');
    clearform();
    var username = $('#userid').val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:"{{ route('getuseridforpayment') }}",
      method:"POST",
      data:{username:username, _token:_token},
      success:function(result)
      {
        var data=result;
        $('select[name=selectmobileno]').val(data.userid);
      },
      dataType:"json"
    });
  });

  //////////////// check from server side start /////////////////////////

  $('#assignPackage').on('click',function(){

    var username = document.getElementById("userid").value;
    var MobileNo = document.getElementById("mobileNo").value;
    clearform();
    if(username){
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:"{{ route('PackageController.getuser') }}",
        method:"POST",
        data:{username:username, MobileNo:MobileNo, _token:_token},
        success:function(result){
          if(result!= null){
            var data=result;
            $('#CashCredit').val(data);
            $('#Package').css('display','block');
          }else{
            $('#Package').css('display','block');
          }
        },
        dataType:"json"
      });
    }else{
      alert('Please Select Username');
    }
  });

  //////////////// check from server side end   /////////////////////////

  /////////////////////// load selected member package start ///////////////////////

  $('#assignPackage').on('click',function(){
    clearform();
    var userid = document.getElementById("userid").value;
    $('#memberpackage').html('');
    if(userid){
      $.ajax({

        type : 'POST',
        url : '{{ route('memberpackageforupgrade') }}',
        data : {userid:userid, _token: '{{ csrf_token() }}'},
        success: function(data){
          $('#memberpackage').append(data);
          $('#next_otp').hide();
          $('#save').show();
          calculate();
        }
      });
    }else{
      //alert('Please Select Username');
    }
  });

  /////////////////////// load selected member package end ////////////////////////

  //////////////////////// package price start ////////////////////////////////////

  $('#memberpackage').change(function(){
    let packageid = $(this).val();
    let userid = $('#userid').val();
    $('#exist_error').hide();


    $.ajax({
      type : 'POST',
      url : '{{ route('peiceformemberpackage') }}',
      data : {packageid:packageid, userid:userid, _token: '{{ csrf_token() }}'},
      success : function(data){
        $('#memberpackageprice').val(data[0]);
        old_package_price = data[0];
        discount = data[1];
        $('#discount').val(discount);
        $('#old_package_price').val(old_package_price);
        calculate();
        $.ajax({
          type : 'POST',
          url : '{{ route('rootschemeforpackageupgrade') }}',
          data : {packageid:packageid, userid:userid, _token: '{{ csrf_token() }}'},
          success : function(data){
            $('#upgradepackage').html(data);

            $.ajax({
              type : 'POST',
              url : '{{ route('checkifupgrade') }}',
              data : {packageid:packageid, userid:userid,  _token: '{{ csrf_token() }}'},
              success : function(data){
                if(data == 201){
                  $('#exist_error').show();
                }else{
                  $('#exist_error').hide();
                }
              }
            });

          }
        });

      }
    });

  });

  //////////////////////// package price end ////////////////////////////////////

  ////////////////////////////////////////// old details of package strat////////////////////////////

  $('#upgradepackage').change(function(){
    let oldpackage = $('#memberpackage').val();
    let upgradepackageid = $(this).val();
    let userid = $('#userid').val();
    let new_price = 0;
    let final_amount_tax = 0;
    if(oldpackage){
      $('#amount_paid').val('');
      $.ajax({
        type : 'POST',
        url : '{{ route('oldpackagedetail') }}',
        data : {oldpackage:oldpackage, userid:userid, _token:'{{ csrf_token() }}'},
        success : function(data){
          var tax = data.tax;
          var joindate = data.joindate;
          $('#tax').val(tax);
          $('#joindate_hidden').val(joindate);
          $.ajax({
            type : 'POST',
            url : '{{ route('peiceforupgradepackage') }}',
            data : {upgradepackageid:upgradepackageid, _token: '{{ csrf_token() }}'},
            success : function(data){
              let tax_apply = $('#tax').val();
              if(discount > 0){
                new_price = data[0];
                new_price_global = data[0];
                $('#new_price_global').val(new_price_global);
                if(tax_apply > 0){
                  let tax_calculation = Number(Number(new_price/100)) * Number(tax_apply);
                  $('#tax_amount').val(Math.round(tax_calculation));
                  let final_amount_tax = Number(new_price) + Number(tax_calculation);
                  $('#upgradepackage_price').val(Math.round(final_amount_tax));

                  let old_tax_calculation = Number(Number(old_package_price/100)) * Number(tax_apply);
                  let old_final_amount_tax = Number(old_package_price) + Number(old_tax_calculation);
                  $('#memberpackageprice').val(old_final_amount_tax);

                }else{
                  $('#upgradepackage_price').val(new_price);
                }
              }else{
                if(tax_apply > 0){
                  let tax_calculation = Number(Number(data[0]/100)) * Number(tax_apply);
                  $('#tax_amount').val(Math.round(tax_calculation));
                  let final_amount_tax = Number(data[0]) + Number(tax_calculation);
                  $('#upgradepackage_price').val(Math.round(final_amount_tax));

                  let old_tax_calculation = Number(Number(old_package_price/100)) * Number(tax_apply);
                  let old_final_amount_tax = Number(old_package_price) + Number(old_tax_calculation);
                  $('#memberpackageprice').val(old_final_amount_tax);

                }else{
                  $('#upgradepackage_price').val(data[0]);
                }
              }
              $('#startingdate').val(joindate);
              var x = new Date(joindate);

              var date = new Date();

              var days=data[1]-1;


              date.setDate(date.getDate(x) + parseInt(days));

              var month = date.getUTCMonth() + 1;
              var day = date.getUTCDate();
              var year = date.getUTCFullYear();
              if(day.toString().length <= 1) {
               day = '0' + day;
             }
             if(month.toString().length <= 1) {
              month = '0' + month;
            }
            newdate = day + "-" + month + "-" + year ;

            $('#finishdate').val('');
            $('#finishdate').val(newdate);
            calculate_price_difference(new_price)
          }
        });
        //end of success
        }
      });
    }else{
      alert('Please select memberpackage');
    }




  });

  ////////////////////////////////////////// old details of package end  ////////////////////////////

  //////////////////////// upgradepackage price start ////////////////////////////////////

 /* $('#upgradepackage').change(function(){
    let upgradepackageid = $(this).val();
    let userid = $('#userid').val();

    $.ajax({
      type : 'POST',
      url : '{{ route('peiceforupgradepackage') }}',
      data : {upgradepackageid:upgradepackageid, _token: '{{ csrf_token() }}'},
      success : function(data){
        let tax_apply = $('#tax').val();
        //let tax_apply = tax;
        console.log('tax'+tax_apply);
        if(tax_apply > 0){
          let tax_calculation = Number(Number(data[0]/100)) * Number(tax_apply);
          let final_amount_tax = Number(data[0]) + Number(tax_calculation);
          console.log(final_amount_tax);
          $('#upgradepackage_price').val(final_amount_tax);
        }else{
          $('#upgradepackage_price').val(data[0]);
        }
        $('#startingdate').val(joindate);
        var x = joindate;

        var date = new Date();

        var days=data[1]-1;

        date.setDate(date.getDate(x) + parseInt(days));

        var month = date.getUTCMonth() + 1;
        var day = date.getUTCDate();
        var year = date.getUTCFullYear();
        if(day.toString().length <= 1) {
         day = '0' + day;
        }
        if(month.toString().length <= 1) {
          month = '0' + month;
        }
        newdate = day + "-" + month + "-" + year ;

        $('#finishdate').val('');
        $('#finishdate').val(newdate);
        calculate_price_difference(data[0])
      }
    });
  });*/

  //////////////////////// upgradepackage price end ////////////////////////////////////

  //////////////////////// price difference start ////////////////////////////////////

  function calculate_price_difference(upgradepackageprice){

    let upgradepackage_price = $('#upgradepackage_price').val();;
    let package_price = $('#memberpackageprice').val();
    let discount = $('#total_discount').val();

    if(package_price.length > 0){
      $('#memberpackageprice').css('border', '');
      $('#memberpackageprice_error').hide();

      let price_difference = Number(upgradepackage_price) - Number(package_price);
      price_difference_global = Math.round(price_difference);
      $('#price_difference_global').val(price_difference_global);
      let final_amount = Number(price_difference_global) - Number(discount);


      $('#final_amount').val(Math.round(final_amount));
      $('#remainingamount').val(Math.round(final_amount));

      if(Math.round(price_difference) > 0){
        $('#price_difference').val(Math.round(price_difference));
        //calculate();
      }else{
        alert('Price is lower than old package.');

        $('#price_difference').val(0);
        $('#upgradepackage_price').val('');
        $('#upgradepackage').val('');
        $('#amount_paid').val('');
        $('#remainingamount').val(0);
        $('#startingdate').val('');
        $('#finishdate').val('');
        $('#final_amount').val('');
      }

    }else{
      $('#memberpackageprice').css('border', '1px solid red');
      $('#memberpackageprice_error').show();
    }
  }

  $('#memberpackage').focus(function(){
    $('#memberpackageprice').css('border', '');
    $('#memberpackageprice_error').hide();
  });


  //////////////////////// price difference end //////////////////////////////////////


  ////////////////////////////// remaining amount start //////////////////////////////

 /* $('#amount_paid').on('input',function(){
    let amount_paid = $(this).val();
    let price_difference = $('#price_difference').val();
    let due_date = $('#due_date').val();


    if(Number(amount_paid) <= Number(price_difference)){
      let remainingamount = Number(price_difference) - Number(amount_paid);
      $('#remainingamount').val(Math.round(remainingamount));
      let updated_remainingamount = $('#remainingamount').val();
      if(Math.round(updated_remainingamount) == 0){

        $('#due_date_error').hide();
        $('#save').removeAttr('disabled');
      }else{
        if(due_date.length > 0){
          $('#due_date_error').hide();
          $('#save').removeAttr('disabled');
        }else{
          $('#due_date_error').show();
          $('#save').attr('disabled', true);
        }
      }
    }else{
      alert('Please alert valid amount');
      $(this).val('');
      $('#remainingamount').val('');
    }


  });*/

  /*$('#memberpackage').change(function(){
    calculate();
  });

  $('#upgradepackage').change(function(){
    calculate();
  });*/




  /////////////////////////////////////////// OTP start /////////////////////////////////////////////

    $('#send_otp').click(function(){

      let admin_id = $('#admin_id').val();
      $('#otp_error').hide();
      $('#otp_value').val('');

      if(admin_id){
      $('#process').show();
      $('#send_otp').hide();
        $.ajax({
          type : 'POST',
          url : '{{ route('sendotp') }}',
          data : {admin_id:admin_id,_token:'{{ csrf_token() }}'},
          success : function(data){
            if(data == true){
              alert('OTP is send');
              $('#send_otp').hide();
              $('#verify').show();
              $('#process').hide();
            }else{
              // $('#send_otp').show();
              // $('#send_otp').text('Resend OTP');
              // $('#process').hide();
                $('#send_otp').hide();
                $('#verify').show();
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
              $('#verify').show();
              $('#send_otp').show();
              $('#send_otp').text('Resend OTP');
            }
          }
        });



      }else{
        $('#otp_required').show();
      }
    });

    $('#admin_id').change(function(){
      $('#admin_error').hide();

    });










  /////////////////////////////////////////// OTP end ///////////////////////////////////////////////


  ///////////////////////////////////////////// calculate strat //////////////////////////////////////
/*  function calculate_old(){

    let price_difference = $('#price_difference').val();
    let due_date = $('#due_date').val();
    let upgradepackage_price = $('#upgradepackage_price').val();
    let upgradepackage = $('#upgradepackage').val();
    let memberpackageprice = $('#memberpackageprice').val();
    let remainingamount = $('#remainingamount').val();
    let amount_paid = $('#amount_paid').val();
    let discount = $('#apply_discount').val();
    let rs = $('#rs').val();
    let percentage = $('#percentage').val();
    let tax = $('#tax').val();

    if(upgradepackage_price.length > 0){
      let difference = Number(upgradepackage_price) - Number(memberpackageprice);
      if(difference > 0){
        $('#price_difference').val(difference);
        price_difference = $('#price_difference').val();
        if(Number(amount_paid.length) > 0){
          if(Number(amount_paid) <= Number(price_difference)){
            let remainingamount = Number(price_difference) - Number(amount_paid);
            $('#remainingamount').val(Math.round(remainingamount));
            let updated_remainingamount = $('#remainingamount').val();
            if(Math.round(updated_remainingamount) == 0){
              $('#due_date_error').hide();
              $('#save').hide();
              $('#next_otp').show();
            }else{
              if(due_date.length > 0){
                $('#due_date_error').hide();
                $('#save').hide();
                $('#next_otp').show();
              }else{
                $('#due_date_error').show();
                $('#save').show();
                $('#next_otp').hide();
              }
            }
          }else{
            alert('Please enter valid1 amount');
            $('#amount_paid').val('');
            $('#remainingamount').val(price_difference);
            $('#save').show();
            $('#next_otp').hide();
            $('#due_date_error').hide();
          }
        }else{
          $('#remainingamount').val(price_difference);
        }
      }else{
        alert('Please select difference package');
        $('#amount_paid').val();
        $('#price_difference').val(0);
        $('#remainingamount').val(0);
        $('#memberpackageprice').val(0);
        $('#memberpackage').val('');
      }
    }
  }

  function new_calculate(){

    let price_difference = $('#price_difference').val();
    let due_date = $('#due_date').val();
    let upgradepackage_price = $('#upgradepackage_price').val();
    let upgradepackage = $('#upgradepackage').val();
    let memberpackageprice = $('#memberpackageprice').val();
    let remainingamount = $('#remainingamount').val();
    let amount_paid = $('#amount_paid').val();
    let discount_apply = $('#apply_discount').val();
    let rs = $('#rs').is(':checked');
    let percentage = $('#percentage').is(':checked');
    let tax = $('#tax').val();
    let final_amount = $('#final_amount').val();
    let old_discount = discount;

    if(discount_apply){
      if(Number(discount_apply) > Number(price_difference)){
        alert('Please enter valid amount');
        $('#price_difference').val('');
        $('#apply_discount').val('');
        $('#remainingamount').val('');
        $('#total_discount').val('');
        $('#discount').val(old_discount);
        $('#price_difference').val(Math.round(price_difference_global));

      }else{
        if(rs == true){

          let calculate_discount = Number(new_price_global) - Number(discount);
          let update_discount = Number(discount_apply) + Number(old_discount);
          if(tax > 0){
            let tax_calculation_price = Number((calculate_discount/100)) * Number(tax);
            let final_amount_tax = Number(new_price_global) + Number(tax_calculation_price);
          }else{
            $('#total_discount').val(Math.round(update_discount));
          }
          let new_remainingamount = Number(price_difference_global) - Number(update_discount);
          $('#final_amount').val(Math.round(new_remainingamount));
          price_difference = $('#price_difference').val();
          $('#remainingamount').val(Math.round(new_remainingamount));
          if(Number(amount_paid) > Number(price_difference)){
            alert('Please enter valid2 amount');
            let calculate_discount = Number(price_difference_global) - Number(discount);
            $('#amount_paid').val('');
            $('#total_discount').val('');
            $('#remainingamount').val(calculate_discount);
            $('#price_difference').val(calculate_discount);
            $('#save').show();
            $('#next_otp').hide();
            $('#due_date_error').hide();

          }else{
            let final_amount = $('#final_amount').val();
            let remainingamount = Number(final_amount) - Number(amount_paid);
            $('#remainingamount').val(Math.round(remainingamount));
            let updated_remainingamount = $('#remainingamount').val();
              if(Math.round(updated_remainingamount) == 0){
                $('#due_date_error').hide();
                $('#save').hide();
                $('#next_otp').show();
              }else{
                if(due_date.length > 0){
                  $('#due_date_error').hide();
                  $('#save').hide();
                  $('#next_otp').show();
                }else{
                  $('#due_date_error').show();
                  $('#save').show();
                  $('#next_otp').hide();
                }
              }
          }
        }

        if(percentage == true){

          let calculate_discount = Number((price_difference/100)) * Number(discount_apply);
          let discount_amount = Number(price_difference) - Number(Math.round(calculate_discount));
          let update_discount = Number(discount) + Number(Math.round(calculate_discount));
          let calculate_tax = Number(discount_amount/100) * Number(tax);
          let final_amount = Number(price_difference) - Number(calculate_tax);
          $('#final_amount').val(Math.round(final_amount));
          $('#total_discount').val(update_discount);
          $('#remainingamount').val(final_amount);

          let updated_finalamount = $('#final_amount').val();

          if(Number(amount_paid) > Number(updated_finalamount)){
            alert('Please enter valid2 amount');
            let calculate_discount = Number(updated_finalamount) - Number(amount_paid);
            $('#amount_paid').val('');
            $('#total_discount').val('');
            $('#remainingamount').val(updated_finalamount);
            $('#save').show();
            $('#next_otp').hide();
            $('#due_date_error').hide();

          }else{
            let remainingamount = Number(updated_finalamount) - Number(amount_paid);
            $('#remainingamount').val(Math.round(remainingamount));
            let updated_remainingamount = $('#remainingamount').val();
              if(Math.round(updated_remainingamount) == 0){
                $('#due_date_error').hide();
                $('#save').hide();
                $('#next_otp').show();
              }else{
                if(due_date.length > 0){
                  $('#due_date_error').hide();
                  $('#save').hide();
                  $('#next_otp').show();
                }else{
                  $('#due_date_error').show();
                  $('#save').show();
                  $('#next_otp').hide();
                }
              }
          }
        }
      }

    }else{

    }//end of discount



  }
*/
  function calculate(){

    let price_difference = $('#price_difference').val();
    let due_date = $('#due_date').val();
    let upgradepackage_price = $('#upgradepackage_price').val();
    let upgradepackage = $('#upgradepackage').val();
    let memberpackageprice = $('#memberpackageprice').val();
    let remainingamount = $('#remainingamount').val();
    let amount_paid = $('#amount_paid').val();
    let discount_apply = $('#apply_discount').val();
    let rs = $('#rs').is(':checked');
    let percentage = $('#percentage').is(':checked');
    let tax = $('#tax').val();
    let final_amount = $('#final_amount').val();
    let price_difference_global = $('#price_difference_global').val();
    let new_price_global = $('#new_price_global').val();
    let old_discount = $('#discount').val();;



      if(upgradepackage){
        if(rs == true){
          if(Number(discount_apply) > Number(price_difference)){
              alert('Please enter valid amount');
              $('#price_difference').val('');
              $('#apply_discount').val('');
              $('#remainingamount').val('');
              $('#total_discount').val('');
              $('#discount').val(old_discount);
              $('#price_difference').val(Math.round(price_difference_global));
              if(amount_paid.length > 0)
              {

              $('#save').show();
              $('#next_otp').hide();
              }
          }else{

            let total_discount = Number(old_discount) + Number(discount_apply);
            $('#total_discount').val(Math.round(total_discount));

            let calculate_discount = Number(price_difference_global) - Number(total_discount);
            $('#final_amount').val(Math.round(calculate_discount));
            $('#remainingamount').val(Math.round(calculate_discount));

            if(Number(amount_paid) > Number(final_amount)){
              alert('Please enter vaild amount');
              $('#amount_paid').val('');
              $('#apply_discount').val();
              $('#remainingamount').val('');
               if(amount_paid.length > 0)
              {
              $('#save').show();
              $('#next_otp').hide();
              }
            }else if(Number(amount_paid) == 0 && amount_paid.length > 0){
              $('#save').hide();
              $('#next_otp').show();
              $('#due_date_error').hide();
            }else{
              let final_amount = $('#final_amount').val();
              let remainingamount = Number(final_amount) - Number(amount_paid);
              $('#remainingamount').val(Math.round(remainingamount));
              if(Number(remainingamount) == 0 && amount_paid.length > 0){
                $('#save').hide();
                $('#next_otp').show();
                $('#due_date_error').hide();

              }else{
                  if(due_date_error.length > 0 && amount_paid.length > 0){
                    $('#save').hide();
                    $('#next_otp').show();
                    $('#due_date_error').hide();
                  }else{
                    $('#due_date_error').show();
                    $('#save').show();
                    $('#next_otp').hide();
                  }
              }
            }
          }//else of Number(discount_apply) > Number(price_difference)

        }else{
          if(discount_apply > 100){
            alert('Please enter valid discound');
            $('#apply_discount').val('');
            $('#amount_paid').val('');
            $('#remainingamount').val('');
            $('#save').show();
            $('#next_otp').hide();
          }else{
            let calculate_discount = Number((price_difference_global/100)) * Number(discount_apply);
            let total_discount = Number(old_discount) + Number(Math.round(calculate_discount));
            $('#total_discount').val(Math.round(total_discount));
            let final_amount = Number(price_difference_global) - Number(calculate_discount);

            $('#final_amount').val(Math.round(final_amount));
            $('#remainingamount').val(Math.round(final_amount));
            if(Number(amount_paid) > Number(final_amount)){
              alert('Please enter vaild amount');
              $('#amount_paid').val('');
              $('#remainingamount').val('');
              $('#total_discount').val('');
              $('#apply_discount').val('');
              $('#save').show();
              $('#next_otp').hide();
            }else if(Number(amount_paid) > 0 && Number(amount_paid) <= Number(price_difference)){
              let remainingamount = Number(final_amount) - Number(amount_paid);
              $('#remainingamount').val(Math.round(remainingamount));
              if(Number(remainingamount) == 0 && amount_paid.length > 0){
                $('#save').hide();
                $('#next_otp').show();
                $('#due_date_error').hide();

              }else{
                  if(due_date_error.length > 0 && amount_paid.length > 0){
                    $('#save').hide();
                    $('#next_otp').show();
                    $('#due_date_error').hide();
                  }else{
                    $('#due_date_error').show();
                    $('#save').show();
                    $('#next_otp').hide();
                  }
              }
            }else if(Number(amount_paid) == 0 && amount_paid.length > 0){
              $('#save').hide();
              $('#next_otp').show();
              $('#due_date_error').hide();
            }else{
              alert('Please enter vaild amount');
              $('#amount_paid').val('');
              $('#discount_apply').val();
              $('#final_amount').val(Math.round(price_difference));
              $('#save').show();
              $('#next_otp').hide();
            }
          }
        }//end of rs== true
      }else{
        $('#save').show();
        $('#next_otp').hide();
      }
      //else of discount_apply











  }
  ///////////////////////////////////////////// calculate end //////////////////////////////////////

  function changedate(){

  var name = document.getElementById("upgradepackage").value;
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// clear form /////////////////////////////////////////////////
function clearform(){

  $('#memberpackage').html('');
  $('#upgradepackage').html('');
  $('#memberpackageprice').val('');
  $('#upgradepackage_price').val('');
  $('#price_difference').val('');
  $('#amount_paid').val('');
  $('#remainingamount').val('');
  $('#due_date').val('');
  $('#startingdate').val('');
  $('#finishdate').val('');

}
//////////////////////////////////////////// clear form end//////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////

  $(document).on('input', '#apply_discount', function(){
    calculate();
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

  $('#apply_discount').on('input',function(){
    calculate();
  });

  $('#due_date').change(function(){
    let amount_paid = $('#amount_paid').val();

    if(amount_paid == 0 || amount_paid.length > 0 ){
      $('#save').hide();
      $('#next_otp').show();
      $('#due_date_error').hide();
    }
  });


  $('#amount_paid').on('input',function(){

    let amount_paid = $(this).val();
    if(Number(amount_paid) == 0 && amount_paid.length > 0){
      $('#save').hide();
      $('#next_otp').show();
    }

    calculate();
  });







//////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>

<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy

  })
</script>
@endpush
