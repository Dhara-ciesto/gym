
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
<!--       <h2>Freeze Membership</h2>
 -->   </section>
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

      <form role="form" action="{{ url('freezemembershippayment') }}" name="frmMr" method="POST" id="package_form">
         {{ csrf_field() }}

         <div class="box box-primary" id="secondstep" >
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12" id="Package" class="Package">
                  <h4>Freeze Membership</h4>
                  <div class="row">
                    <input type="hidden" name="tax" id="tax">
                    <input type="hidden" name="joindate_hidden" id="joindate_hidden">
                    <div class="col-md-6 col-lg-3">
                     <div class="form-group">
                        <label>Member<span style="color: red">*</span></label>
                        <select name="userid" id="memberfrom" class="form-control select2 span8" class="span11" required>
                           @if($member_data)
                           <option value="" selected readonly>Please choose an option</option>
                           @foreach($member_data as $member)
                           <option value="{{ $member->userid }}">{{ ucfirst($member->firstname) }} {{ ucfirst($member->lastname) }}</option>
                           @endforeach
                           @else
                            <option value="" selected readonly>No Member Available</option>
                           @endif
                        </select>
                        <span id="memberpackageprice_error" style="color: red;display: none;">Please select package</span>
                     </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                     <input type="hidden" name="tax" value="{{ $tax }}">
                      <div class="form-group">
                        <label>Start Date<span style="color: red;">*</span></label>
                        <input type="date" name="startdate" id="startdate" class="form-control" value="<?php echo date('Y-m-d') ?>"   class="span11"  />
                        <span id="stratdate_error" style="color: red;"></span>
                      </div>
                    
                    </div>
                    <div class="col-md-6 col-lg-3">
                      <input type="hidden" name="tax" value="{{ $tax }}">
                       <div class="form-group">
                         <label>End Date<span style="color: red;">*</span></label>
                         <input type="date" name="enddate" id="enddate" class="form-control" value="<?php echo date('Y-m-d') ?>"   class="span11"  />
                         <span id="stratdate_error" style="color: red;"></span>
                       </div>
                     
                     </div>
                   
                  </div>

                  <div class="row" id="package_detail" style="display: none;">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <label>Member Packages</label>
                      <div id="package_data"></div>
                    </div>
                    <div class="col-md-3"></div>
                  </div>

                  <div class="row">
                     
                  </div>

                  <div class="row">
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label>Amount To Be Paid<span style="color: red;">*</span></label>
                          <input type="text" name="amount_paid" class="form-control number" placeholder="Amount To Be Paid" id="amount_paid"  class="span11" autocomplete="off" maxlength="5" />
                          <input type="hidden" name="PaymentDate"  value="{{Carbon\Carbon::today()->format('Y-m-d')}}" />
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                     <div class="form-group">
                       <label>Final Amount</label>
                       <input type="text" name="finalamount" id="FinalAmount"class="form-control" placeholder="Final Amount" class="span11" readonly="" />
                       <div class="col-md-6 col-lg-6 col-sm-6">
                           <label><input type="radio" name="tax_radio" id="with_tax" checked="checked" value="withtax" />With Tax</label>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6">
                          <label> <input type="radio" name="tax_radio" id="without_tax" value="withouttax">Without Tax</label>
                        </div>
                     </div>
                    </div>    

                   
                  </div>
                    
                  {{-- <div class="row">
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                        <label>Remaining Amount</label>
                        <input type="text" name="remaining_amount" class="form-control number" placeholder="Remaining Amount" id="remainingamount"  class="span11" readonly="" />
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                           <label>Due Date</label>
                           <input type="date" name="due_date" id="due_date" class="form-control" placeholder="Final Amount" class="span11" min="{{ date('Y-m-d')}}" />
                           <span id="due_date_error" style="color: red;display: none;">Please Select Due Date</span>
                      </div>
                    </div>
                  </div> --}}

                  {{-- <div class="row">
                    <div class="col-md-6 col-lg-6">
                      <label>Join Date</label>
                      <input placeholder="Joining date" type="date" onkeypress="return false" id="startingdate" readonly=""  class="form-control" name="Join_date" class="span11">
                    </div>
                    <div class="col-md-6 col-lg-6">
                      <label>Finish Date</label>
                      <input placeholder="Finishing date"  id="finishdate" class="form-control" name="Expire_date" class="span11" readonly="" >
                    </div>
                  </div>  --}}

                  {{ session()->put('freezemembership','1') }}
                  <div class="row">
                    <div class="col-lg-8">
                     <div class="form-group">
                        <div class="col-sm-offset-6">
                           <button type="button"   id="save" value="button" name="order_btn"  class="btn bg-green margin" disabled="">Next</button>
                           <button type="button" data-toggle="modal" data-target="#otpmodel"  id="next_otp" value="button" name="order_btn"  class="btn bg-green margin" style="display: none;">Next</button>
                           <a href="{{ url('freezemembership') }}"class="btn bg-red margin">Cancel</a>
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
                <h5 class="modal-title" id="exampleModalLabel">OTP for Freeze membership</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
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
                <a href="{{ route('freezemembership') }}" class="btn btn-danger">Close</a>
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
                $('#send_otp').hide();
                $('#verify').show();
                $('#process').hide();
              // $('#send_otp').show();
              // $('#send_otp').text('Resend OTP');
              // $('#process').hide();
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

    $('#admin_id').change(function(){
      $('#admin_error').hide();

    });

  


///////////////////////////////////////////////// to member start///////////////////////////////////////////
$('#memberfrom').change(function(){
  $('#package_data').html('');
  $('#package_detail').show();
  $('#amount_paid').val('');
  $('#noofdays').val('');
  $('#enddate').text('dd-mm-yyyy');
  let userid = $(this).val();
  if(userid){
    $.ajax({
      type : 'POST', 
      url : '{{ route('selectactivemember') }}',
      data : {userid:userid, _token:'{{ csrf_token() }}'},
      success : function(data){
        $('#package_data').append(data);
      }
    });
  }

});
///////////////////////////////////////////////// to member end///////////////////////////////////////////



//////////////////////////////////////////////////// check days /////////////////////////////////////////////////

  $('#startdate').change(function(){

    let startdate = $(this).val();
   
    checkvaliddate(startdate);

  });

 


//////////////////////////////////////////////////// check days /////////////////////////////////////////////////

//////////////////////////////////////////////////// check valid date ////////////////////////////////////////////
  function checkvaliddate(startdate_data){

    let startdate = startdate_data;
    let userid = $('#memberfrom').val();
    let amount_paid = $('#amount_paid').val();

    $('#stratdate_error').text('');
    if(userid){
      $.ajax({
        type : 'POST', 
        url : '{{ route('checkfreezedate') }}',
        data : {userid:userid, startdate:startdate, _token:'{{ csrf_token() }}'},
        success : function(data){
          if(data == 201){
            $('#stratdate_error').text('Start date should not be end date');
            $('#save').attr('disabled', 'true');
          }else{
            $('#stratdate_error').text('');
            if(amount_paid){
              $('#save').hide();
              $('#next_otp').show();
            }

          }
          //$('#package_data').append(data);
        }
      });
    }else{

    }
  }





//////////////////////////////////////////////////// check valid end /////////////////////////////////////////////

$('#amount_paid').on('input',function(){
  let amount_paid = $(this).val();

  if(amount_paid.length == 0){
    $('#FinalAmount').val(0);
    $('#save').show();
    $('#next_otp').hide();
  }else{
    $('#save').hide();
    $('#next_otp').show();
  }

  changes();
});

$('#without_tax').click(function(){
  changes();
});

$('#with_tax').click(function(){
  changes();
});

/////////////////////////////////////////////////// common function ///////////////////////////////////////////////

function changes(){

  let userid = $('#memberfrom').val();
  let days = $('#noofdays').val();
  let startdate = $('#startdate').val();
  let amount_paid = $('#amount_paid').val();
  let with_tax = $('#with_tax').is(':checked');
  let without_tax = $('#without_tax').is(':checked');
  let tax = {{ $tax }};

    if(startdate){
        if(amount_paid){
          if(with_tax == true){
            let tax_calculate = Number(amount_paid/100) * Number(tax);
            let final_amount = Number(amount_paid) + Number(tax_calculate);
            $('#FinalAmount').val(Math.round(final_amount));
            if(amount_paid.length > 0){ 
              $('#next_otp').show();
              $('#save').hide();
            }
          }else{
            $('#FinalAmount').val(Math.round(amount_paid));
            if(amount_paid.length > 0){  
            $('#save').hide();
            $('#next_otp').show();
            }
          }
        }else{
        }
    //else of startdate
    }else{
      $('#save').show();
      $('#next_otp').hide();

    }//end of stratdate
  //else of days
  

}
/////////////////////////////////////////////////// common function end////////////////////////////////////////////
</script>

<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
  
  })
</script>
@endpush