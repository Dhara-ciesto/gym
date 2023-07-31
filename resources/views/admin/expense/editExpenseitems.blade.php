@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
@endpush
@section('content')
<!-- left column -->
<div class="content-wrapper">
  <section class="content-header">
     <h2>Edit Expense</h2>
  </section>
  <!-- general form elements -->
  <section class="content">
     <div class="box box-primary">
        <div class="box-header with-border">
           <h3 class="box-title">Edit Expense </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
           <div class="col-lg-4"></div>
           <div class="col-lg-4">
              <form role="form"action="{{ url('editExpenseitems/'.$categoryname->expensepaymentid) }}" 
                 method="post" id="dietitemform" >
                 {{ csrf_field() }}
                  <!-- text  input --> <!-- text input -->
                 <div class="form-group">
                    <label>Amount<span style="color: red">*</span></label>
                    <input type="text" class="form-control" value="{{$categoryname->amount }}"  maxlength="255" name="amount"  placeholder="Expense amount">
                    @if($errors->has('amount'))
                    <span class="help-block">
                    <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                    @endif
                 </div>
                 <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Company</label>
                        <input type="text" class="form-control" value="{{$categoryname->company }}"   name="companyname"  placeholder="Enter Company">
                     </div>
                  </div>
                
               </div>
                
                 <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                          <label>Bill Number</label>
                          <input type="text" class="form-control" value="{{$categoryname->billno }}"   name="billno"  placeholder="Bill Number">
                       </div>
                    </div>
                    <div class="col-md-6">
                       <label>GST</label>
                       <input type="text" class="form-control" value="{{$categoryname->gstamount }}"  name="gstamount"  placeholder="GST">
                    </div>
                 </div>
                 <div class="form-group">
                    <label>Mode of Payment<span style="color: red">*</span></label> 
                    <br>   
                    <input type="radio" name="paymenttype"value="Cash"  <?php if ($categoryname->paymenttype=='Cash' ) {
                       echo "checked";
                       } ?>  class="paymenttype">
                    <label>Cash</label>
                    <input type="radio" name="paymenttype"   onclick="ShowHideDiv()" value="Cheque" 
                       class="paymenttype"  <?php if ($categoryname->paymenttype=='Cheque' ) {
                          echo "checked";
                          } ?> > <label>Cheque </label>
                    <input type="radio"    onclick="ShowHideBank()" name="paymenttype" value="Bank"   class="paymenttype" <?php if ($categoryname->paymenttype=='Bank' ) {
                       echo "checked";
                       } ?> >
                    <label>Bank </label>
                    @if($errors->has('paymenttype'))
                    <span class="help-block">
                    <strong>{{ $errors->first('paymenttype') }}</strong>
                    </span>
                    @endif
                 </div>
                 <div    id="Chequeno"   class="form-group"> 
                    <input type="text" class="form-control" value="{{$categoryname->Chequeno }}" name="Chequeno"  placeholder="Cheque Number">
                 </div>
                 <div   id="bankname"       class="form-group">
                    <input type="text" class="form-control" value="{{$categoryname->expensepaymentbkname }}" readonly=""  id="bankname" name="bankname"  placeholder="Bank Name">
                 </div>
                 <div class="form-group">
                    <label>User<span style="color: red"></span></label>
                    <input type="text" class="form-control" value="{{$categoryname->first_name.' '.$categoryname->last_name }}"  id="employee"  name="employee"  readonly="" placeholder="Expense amount">
                    <input type="hidden" class="form-control" value="{{$categoryname->employeeid }}"  id="employeeid"  name="employeeid"  readonly="" placeholder="Expense amount">
                    <br>
                    <div class="form-group">
                       <label>Expense Category<span style="color: red">*</span></label>
                       <input type="text" class="form-control" value="{{$categoryname->categoryname }}" readonly=""  name="categoryname"  placeholder="Expense amount">
                       <input type="hidden" class="form-control" value="{{$categoryname->expensecategoryid }}" readonly=""  name="expensecategoryid"  placeholder="Expense amount">
                    </div>
                    @if($errors->has('categoryname'))
                    <span class="help-block">
                    <strong>{{ $errors->first('categoryname') }}</strong>
                    </span>
                    @endif
                    <div class="form-group">
                       <label>Date of Expesne<span style="color: red">*</span></label>
                       <input value="{{$categoryname->dte }}" type="date" id="dte" class="form-control" name="dte" placeholder="<?php echo date("d-m-Y"); ?>"  >
                       @if($errors->has('dte'))
                       <span class="help-block">
                       <strong>{{ $errors->first('dte') }}</strong>
                       </span>
                       @endif
                    </div>
                    <div class="form-group">
                     <label>Remarks
                     </label>
                  <textarea name="remark" class="form-control"  placeholder="Remarks">{{$categoryname->remark}}</textarea>
                     @if($errors->has('remark'))
                     <span class="help-block">
                     <strong>{{ $errors->first('remark') }}</strong>
                     </span>
                     @endif
                  </div>
                    <div class="form-group">
                       <div class="col-sm-6">
                          <button type="submit" class="btn bg-green btn-block">
                          Save</button>
                       </div>
                       <div class="col-sm-6"> <a href="{{ url('viewexpenses') }}"class="btn btn-danger btn-block">Cancel</a></div>
                    </div>
                    <!-- Select multiple-->
              </form>
              </div>
              <div class="col-lg-3"></div>
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
function ShowHideDiv() {
    $('input[name="paymenttype"]').on('click', function() {
        if ($(this).val() == 'Cheque') {
            $('#Chequeno').show();
                        $('#bankname').show();


        }
        else {
            $('#Chequeno').hide();
                        $('#bankname').hide();

        }
    });
}
function ShowHideBank() {
    $('input[name="paymenttype"]').on('click', function() {
        if ($(this).val() == 'Bank') {
            $('#bankname').show();
                      

        }
        else {
            $('#bankname').hide();
                 
        }
    });
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#dietitemform').validate({
    
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#dietitemform').validate({
    
    });
  });
</script>
@endpush