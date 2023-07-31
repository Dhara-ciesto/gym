@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
</style>
@endpush
@section('content')
<!-- left column -->
<style type="text/css">
</style>
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
      <form role="form" action="{{ url('upgradepackagepayment') }}" name="frmMr" method="POST" id="package_form">
         {{ csrf_field() }}
         <input type="hidden" name="transactionId" value="{{ $last_transaction_id }}">
         <input type="hidden" name="upgradeid" value="{{ $last_upgrade_id }}">
         <input type="hidden" name="last_memberpackage_id" value="{{ $last_memberpackage_id }}">
         <input type="hidden" name="userid" value="{{ $userid }}">
         <input type="hidden" name="amount_paid" value="{{ $amount_paid }}">
         <input type="hidden" name="remainingamount" value="{{ $remaining_amount }}">
         <input type="hidden" name="due_date" value="{{ $due_date }}">
         <div class="box box-primary" id="secondstep" >
            <div class="box-header with-border">
               <h3 class="box-title">Transcation</h3>
            </div>
            <!-- /.box-header -->
            {{session()->put('transactionsecond','1')}}
            <div class="box-body">
               <div class="col-md-8">
                 <table class="table">
                   <tr>
                     <th>Member Name</th>
                     <td>:</td>
                     <td>{{ !empty($fullname) ? ucfirst($fullname) : '' }}</td>
                   </tr>
                    <tr>
                     <th>Root Scheme Name</th>
                     <td>:</td>
                     <td>{{ !empty($rootscheme_name) ? ucfirst($rootscheme_name) : '' }}</td>
                   </tr>
                    <tr>
                     <th>Scheme Name</th>
                     <td>:</td>
                     <td>{{ !empty($schemes_name) ? ucfirst($schemes_name) : '' }}</td>
                   </tr>
                    <tr>
                     <th>Base Amount</th>
                     <td>:</td>
                     <td>{{ !empty($upgradepackage_price_basic) ? $upgradepackage_price_basic : '' }} INR</td>
                   </tr>
                   <tr>
                     <th>Tax</th>
                     <td>:</td>
                     <td>{{ !empty($tax) ? $tax : 0 }} %</td>
                   </tr>
                   <tr>
                     <th>Tax Amount</th>
                     <td>:</td>
                     <td>{{ !empty($tax_amount) ? $tax_amount : 0 }} INR</td>
                   </tr>
                   <tr>
                    <th>Actual Amount</th>
                    <td>:</td>
                    <td>{{ !empty($upgradepackage_price) ? $upgradepackage_price : '' }} INR</td>
                  </tr>
                   <tr>
                     <th>Old Package Price</th>
                     <td>:</td>
                     <td>{{ $memberpackageprice }} INR</td>
                   </tr>
                   <tr>
                     <th>Price Difference</th>
                     <td>:</td>
                     <td>{{ $price_difference }} INR</td>
                   </tr>
                   <tr>
                     <th>Discount</th>
                     <td>:</td>
                     <td>{{ $total_discount }} INR</td>
                   </tr>
                   <tr>
                     <th>Remaining Amount</th>
                     <td>:</td>
                     <td><b><span style="color: red;">{{ $remaining_amount }}</span></b></td>
                   </tr>
                    <tr>
                     <th>Transcation Type</th>
                     <td>:</td>
                     <td>{{ $transactiontype }}</td>
                   </tr>
                   <tr>
                     <th>Due Date</th>
                     <td>:</td>
                     @if(!empty($due_date))
                     <td>{{ date('d-m-Y', strtotime($due_date)) }}</td>
                     @endif
                   </tr>
                    <tr>
                     <th>Amount To Be Paid</th>
                     <td>:</td>
                     <td><b><span id="amount_paid" style="color: green;">{{ $amount_paid }}</span></b></td>
                   </tr>
                 </table>

                 <table>
                   <div class="form-group">
                    <thead>
                     <tr>       
                      <th></th>
                      <th>Amount</th>
                      <th>Remarks</th>
                    </tr>
                  </thead> 
                  @php $i=0; @endphp
                  @foreach($PaymentTypes as $PaymentType)
                  <tr><td><input type="checkbox" class="check" name="Mode[]" value="{{$PaymentType->paymenttypeid}}"> &emsp;<label>{{$PaymentType->paymenttype}}</label>&emsp;</td><td><input type="text" class="form-control price  number " id="amount<?php echo $i;?>" disabled="" name="Amount[]"  autocomplete="off"></td>&emsp;<td><input type="text"class="form-control" name="Remark[]" disabled="" maxlength="60" autocomplete="off"></td>
                    @php $i++; @endphp
                  @endforeach</tr>
                </div>
              </table>
              <table>
                <div class="form-group">
                <tr>
                  <th>Paid Amount</th>
                  <th><span style="margin-left: 5px;">:</span></th>
                  <th><span id="total_paid" style="color: red;margin-left: 10px;">0</span></th>
                </tr>
              </div>
              </table>
              <center>
                {{-- <button type="button"  data-toggle="modal" data-target="#exampleModal"   id="save" value="button"  class="btn bg-green margin" disabled="">Next</button> --}}
                <button type="button" id="save" value="button"  class="btn bg-green margin" disabled="">Next</button>
                <a href="{{ url('demopayment') }}" class="btn bg-red margin" >Cancel</a>
              </center>
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Package Upgrade Payment</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure to confirm payment?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" id="pay" class="btn bg-green">Pay</button>
                      <button disabled class="btn bg-green" id="btnnew" style="display: none;">Submitting</button>
                    </div>
                  </div>
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


  let is_print = 0;
 $('.check').on('change',function(){
  // calculate();
  let amount = $('#amount_paid').text();
     var x= true;
          $('input[type="checkbox"]').map(function(){
            if($(this).prop("checked") == true){
            //  alert('if');
              var y=  $(this).closest('tr').find('[type=text]:first').val();
             $(this).closest('tr').find('[type=text]').prop("disabled", false);
               $(this).closest('tr').find('[type=text]:first').attr('required','');
                if($('#total_paid').text() == 0){
                  $(this).closest('tr').find('[type=text]:first').val(amount);
                }
                 
                if (y == "")
                {
                 x= false;
                }
            }
            else if($(this).prop("checked") == false){
                 $(this).closest('tr').find('[type=text]').attr("disabled", "disabled");
                  $(this).closest('tr').find('[type=text]').val('');


            }
            cal();
        });
          //alert(x);
       if (x == false)
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
                 x= false;
              }
            }
            else if($(this).prop("checked") == false){

                 $(this).closest('tr').find('[type=text]').attr("disabled", "disabled");
              
            }

       if (x == false)
         return false;
       else
        return true;
      cal();
  });
 $('.price').on('keyup',function(){

   
     cal();

 
});
 $('.price').on('keyup',function(){

   
     cal();

 
});
 function cal() {
    let sum = 0;
    let remaining_amount = $('#amount_paid').text();
     $('.price').each(function() {
        sum += Number($(this).val());
        $('#total_paid').text(sum);
    });
    if(Number(sum) == Number(remaining_amount)){
      $('#save').removeAttr('disabled');
      $('#total_paid').css('color', 'green');
    } else {
      $('#save').attr('disabled', 'true');
      $('#total_paid').css('color', 'red');
    }
 }

    
 /* function checkamount(){
    let sum = 0;
    let remaining_amount = $('input:enabled #amount_paid').text();
    for(n = 0 ; n < {{$i}}; n++){
      sum = Number(sum) + Number($('#amount'+n).val());
    }
    // $('#total_paid').text(sum);
    if(Number(sum) == Number(remaining_amount)){
      $('#save').removeAttr('disabled');
    } else {
      //alert('Please enter valid amount');
      $('#save').attr('disabled', 'true');
    }
  }*/
  $('#save').click(function () {
  let mod = [];
  var countchecked = $('input[type="checkbox"]').filter(function () {
    return this.checked
  }).length;

  if (countchecked > 0) {

    var countchecked = $('.amountclass').filter(function () {
      !this.disabled
    }).length;

    $('input[type="checkbox"]').map(function () {
      if ($(this).prop("checked") == true) {
        var y = $(this).closest('tr').find('[type=text]:first').val();

        if (y == '') {
          alert('kindly Uncheck the checkbox or fill data ');
          mod.push('error');

        }
      }

    });

    if (mod.length === 0) {
      $('#exampleModal').modal('show');
    }
  }
});
</script>

<script>
window.onunload=function() { return confirm("OnUnload?"); };
  
/*window.onload = function () {  
        document.onkeydown = function (e) {  
            return (e.which || e.keyCode) != 116;  
        };
    } 

 window.onbeforeunload = function() {
        return "Dude, are you sure you want to leave? Think of the kittens!";
    }
*/

/*window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = 'Any string';
    }

    // For Safari
    return 'Any string';
};*/


/*$('#save').click(function(){
  $(this).attr('disabled', 'true');
});*/


$('#pay').click(function(){
  $('#btnnew').show();
  $('#pay').hide();
});

 $(document).bind("contextmenu",function(e){
      return false;
   });
</script>

@endpush