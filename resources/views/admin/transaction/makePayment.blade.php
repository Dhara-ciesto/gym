@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<div class="content-wrapper">
   <section class="content-header">
      <h2>Remaining amount Payment</h2>
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
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title"></h3>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
            <form role="form" action="{{ url('remainingplaceorderprocess/'.$id) }}" method="post" name="fr" id="remaining_form">
               <div class="col-lg-6">
                  {{ csrf_field() }}
                  <input type="hidden" name="payment_id" value="{{ $Payment->paymentid }}">
                  <div class="form-group">
                     <label>Username</label>
                     <input type="hidden" name="userid"  class="form-control" value="{{$user->userid}}" readonly="">
                     <input type="text" name="username"  class="form-control" value="{{$user->username}}" readonly="">
                  </div>
                  <div class="form-group">
                     <label>PaymentDate</label>
                     <input type="text" name="OldPaymentDate" class="form-control" readonly="" value="{{date('d-m-Y', strtotime($Payment->paymentdate)) }}">
                     <input type="hidden" name="paymentdate" value="{{Carbon\Carbon::today()->format('d-m-Y')}}">
                     <input type="hidden" name="tax" value="{{$tax}}">
                  </div>
                  <div class="form-group">
                     <label>Actual Amount</label>
                     <input type="text" name="ActualAmount" class="form-control" readonly="" value="{{$Payment->actualamount}}">
                  </div>
                  <div class="form-group">
                     <label>Paid Amount</label>
                     <input type="text" name="PaidAmount" class="form-control" readonly="" value="{{$Payment->actualamount-$Payment->remainingamount}}">
                  </div>
                  <div class="form-group">
                     <label>Package</label>
                     <select name="SchemeID" id="package"  class="form-control" readonly="">
                        <option selected value="{{$Scheme->schemeid}}" >
                           {{$Scheme->schemename}}
                        </option>
                     </select>
                  </div>
                  <!-- /input-group -->
               </div>
               <!-- /.col-lg-6 -->
               {{session()->put('orderview','1')}}

               <div class="col-lg-6">
                  <div class="form-group">
                     <label>Old Remaining Amount</label>
                     <input type="text" name="OldremainingAmount" class="form-control" id="OldremainingAmount" readonly="" value="{{$Payment->remainingamount}}">
                  </div>
                  <div class="form-group">
                     <?php $length = strlen($Payment->remainingamount); ?>
                     <label>Amount to be paid</label>
                     <input type="text" name="paid_amount" class="form-control number" id="paid_amount" maxlength="{{ $length }}"  value="{{$Payment->remainingamount}}">
                  </div>
                  <div class="form-group">
                     <label>Remaining Amount</label>
                     <input type="text" name="remainingamount" class="form-control" id="remainingamount" readonly=""  value="0">
                  </div>
                  <div class="form-group">
                     <label>Due Date</label>
                     <input type="date" min="{{ date('Y-m-d') }}" onkeypress="return false" name="due_date" class="form-control" id="due_date"  value="{{$Payment->remainingamount}}">
                     <span id="duedate_error" style="color: red;display: none;">Please Select Due Date</span>
                  </div>

               </div>

               <div class="col-md-12">
                  <center>
                     <button type="submit"   id="save" value="button" name="order_btn"  class="btn bg-green margin">Next</button>
                     <button type="button"   id="otp_button" value="button" data-backdrop="static" data-keyboard="false" name="order_btn" data-toggle="modal" data-target="#otpmodel"  class="btn bg-green margin" style="display: none;">Next</button>
                     <a disabled class="btn bg-green" id="btnnew" style="display: none;">Submitting</a>
                     <a href="{{ url('members') }}" class="btn bg-red margin" >Cancel</a>
                  </center>
               </div>
         </div>
<div class="modal fade" id="otpmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">OTP for Remaining Payment</h5>

      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-6">
            <label>Select Admin<span style="color: red;">*</span></label>
            <select name="admin" class="form-control" id="admin_id">
              <option value="">--Select--</option>
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
        <a href="{{ url('dashboard') }}"class="btn bg-red">Cancel</a>
      </div>
    </div>
  </div>
</div>
         </form>
      </div>
</div>

</section>
</div>
@endsection
@push('script')
<script type="text/javascript">
   $(".number").keypress(function (e) {
      //if the letter is not digit then display error and don't type anything
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
         //display error message
         $(this).find('.errmsg').html("Digits Only are allowed gbghbdfhbdbdfgbdfgfv").show().fadeOut("slow");
                return false;
     }
    });
   $('#paid_amount').on('input', function(){
      $('#save').attr('disabled', 'true');
      let paid_amount = $(this).val();
      let remainingamount = $('#remainingamount').val();
      let OldremainingAmount = $('#OldremainingAmount').val();
      let due_date = $('#due_date').val();
      //console.log(due_date);
      if(paid_amount == 0){
         $('#save').hide();
         $('#otp_button').show();
         $('#duedate_error').hide();
         $('#remainingamount').val(OldremainingAmount);
      }else{
         if(Number(paid_amount) > Number(OldremainingAmount)){
            $(this).val('');
            $('#remainingamount').val(OldremainingAmount);
            alert('Please enter vaild amount');
            $('#otp_button').hide();
            $('#save').show();
            $('#save').attr('disabled', 'true');
         } else {
            let remaining_calculation = Number(OldremainingAmount) - Number(paid_amount);
            $('#remainingamount').val(remaining_calculation);
            if(paid_amount == OldremainingAmount){
               $('#otp_button').hide();
               $('#save').show();
               $('#save').removeAttr('disabled');
               $('#duedate_error').hide();
            } else {
               $('#otp_button').hide();
               $('#save').show();
               $('#duedate_error').show();
            }
         }
      }
   });

   $('#due_date').change(function(){
      let due_date = $(this).val();
      if(due_date){
         $('#save').removeAttr('disabled');
         $('#duedate_error').hide();
      }
   });

   $('#save').click(function(){
     $('#btnnew').show();
     $('#save').hide();
   });

   /*$('#save').click(function(){
    $(this).attr('disabled', 'true');
 });*/

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
              $('#remaining_form').submit();
             
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
@endpush