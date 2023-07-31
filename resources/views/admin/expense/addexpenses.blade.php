@extends('layouts.adminLayout.admin_design')
@push('css')

<style type="text/css">
  strong{
    color: red;
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
</style>
@endpush
@section('content')

<!-- left column -->
<div class="content-wrapper">
  <section class="content-header">
<!--      <h2>Add Expense</h2>
 -->  </section>
  <!-- general form elements -->
  <section class="content">
     <div class="box box-primary">
        <div class="box-header with-border">
           <h3 class="box-title">Add Expense </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
           <div class="col-lg-3"></div>
           <div class="col-lg-6">
              <form role="form" action="{{ url('addexpenses') }}"
                 method="post" id="dietitemform" >
                 {{ csrf_field() }} 
                 <!-- text
                    input -->
                 <!-- text input -->
                 <div class="form-group">
                    <label>Amount
                    <span style="color: red">*</span>
                    </label>
                    <input type="text"  name="amount" value="{{ old('amount') }}" class="form-control number "autocomplete="off" placeholder="Expense amount"  class="span11" maxlength="16" />
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
                          <input type="text"name="companyname" value="{{ old('company') }}" class="form-control"autocomplete="off" placeholder="Enter Company"  class="span11" maxlength="255" />
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                          <label>Account No</label>
                          <input type="text"  name="billno" value="{{ old('billno') }}" class="form-control number "autocomplete="off" placeholder="Bill Number"  class="span11" maxlength="18" />
                       </div>
                    </div>
                    <div class="col-md-6">
                       <label>GST</label>
                       <input type="text"  class="form-control "autocomplete="off" value="{{ old('gstamount') }}"  name="gstamount"  placeholder="GST" class="span11" maxlength="16" />
                    </div>
                 </div>
                 <div class="form-group">
                    <label>Mode of Payment
                    <span style="color: red">*</span>
                    </label>
                    <br>
                    <input type="radio" name="paymenttype" value="Cash"  class="paymenttype">
                    <label>Cash</label>
                    <input type="radio"    name="paymenttype" 
                       value="Cheque"
                       class="paymenttype">
                    <label>Cheque </label>
                    <input type="radio"  name="paymenttype" value="Bank" class="paymenttype">
                    <label>Bank </label>
                    @if($errors->has('paymenttype'))
                    <span class="help-block">
                    <strong>{{ $errors->first('paymenttype') }}</strong>
                    </span>
                    @endif
                 </div>
                 <div  id="Chequeno" style="display: none"  class="form-group">
                    <input type="text" id="Chequenofield"  name="Chequeno" hidden="true" class="form-control number "autocomplete="off" placeholder="Enter Cheque Number" class="span11" maxlength="20" />
                 </div>
                 <div  id="bankname"  style="display: none"   class="form-group">
                    <select  hidden="true"  name="bankname" id="bankname" class="form-control span11 select2" title="Select Bank Name" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Bank" required="">
                       <option value=""  selected>Please choose an Bank</option>
                       @foreach($bankmaster as $bankname)
                       <option value="{{ $bankname->bankname }}">{{ $bankname->bankname }}</option>
                       @endforeach
                    </select>
                 </div>
                 <div class="form-group">
                    <label>User
                    <span style="color: red"></span>
                    </label>
                    <select  name="employeeid"  id="employeeid"       class="form-control span11 select2"title="Select User" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select User" required="">
                       <option value="" selected>Please choose an option</option>
                       @foreach($Employee as $Employee)
                       <option value="{{ $Employee->employeeid }}" 
                          <?php if( Session::get('employeeid')== $Employee->employeeid){ echo 'selected'; } ?> >{{ $Employee->username }}
                       </option>
                       @endforeach
                    </select>
                 </div>
                 <div class="form-group">
                    <label>Expense Category
                    <span style="color: red">*</span>
                    </label>
                    <select  name="expensecategoryid" id="expensecategoryid" class="form-control span11 select2"title="Select Category" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Category" required="">
                       <option value=""  selected>Please choose an option</option>
                       @foreach($expensemaster as $categoryname)
                       <option value="{{ $categoryname->expensecategoryid }}">{{ $categoryname->categoryname }}</option>
                       @endforeach
                    </select>
                 </div>
                 @if($errors->has('categoryname'))
                 <span class="help-block">
                 <strong>{{ $errors->first('categoryname') }}</strong>
                 </span>
                 @endif
                 <div class="form-group">
                    <label>Date of Expense
                    <span style="color: red">*</span>
                    </label>
                    <input  type="date" id="dte" class="form-control" name="dte" placeholder="
                       <?php echo date("d-m-Y"); ?>"  value="{{date('Y-m-d')}}" >
                    @if($errors->has('dte'))
                    <span class="help-block">
                    <strong>{{ $errors->first('dte') }}</strong>
                    </span>
                    @endif
                 </div>
                 <div class="form-group">
                  <label>Remarks
                  </label>
                  <textarea name="remark" class="form-control"  placeholder="Remarks"></textarea>
                  @if($errors->has('remark'))
                  <span class="help-block">
                  <strong>{{ $errors->first('remark') }}</strong>
                  </span>
                  @endif
               </div>
                 <div class="col-lg-12">
                    <div class="col-lg-2"></div>
                    <div class="form-group">
                       <div class="col-sm-3">
                          <button type="submit" class="btn bg-green btn-block">
                          Save</button>
                       </div>
                       <div class="col-sm-3">
                          <a href="{{ url('viewexpenses') }}"class="btn btn-danger btn-block">Cancel</a>
                       </div>
                    </div>
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
    $('input[name="paymenttype"]').on('click', function() {
      // alert($(this).val());
        if ($(this).val() == 'Cheque') {
            $('#Chequeno').show();
             $('#Chequenofield').attr('required',true);
            // $('#bankname').show();
        }
        else {
            $('#Chequeno').hide();
            $('#Chequenofield').attr('required',false);
            $('#bankname').hide();
        }
    });
    $('input[name="paymenttype"]').on('click', function() {
        if ($(this).val() == 'Bank') {
            $('#bankname').show();
        }
        else {
            $('#bankname').hide();
        }
    });
</script>
      <script type="text/javascript">
  $(document).ready(function(){

          $('.select2').select2()

    $('#dietitemform').validate({
    
    });
  });
</script>
@endpush