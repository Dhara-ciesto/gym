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

    @if (session()->has('success'))
    <h1>{{ session('success') }}</h1>
@endif

  <div class="content-wrapper">

<!--          <section class="content-header"><h2>Edit Bank Details</h2></section>
 -->          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Edit Bank Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">

              <form role="form" action="{{ url('editbank/'.$bankmaster->bankid) }}" method="post" id="edititemform" >
                {{ csrf_field() }}
                  <div class="form-group">
                     <label>Account No</label>
                     <input type="text"  name="accountNo" value="{{$bankmaster->accountno }}" class="form-control number "autocomplete="off" placeholder="account no"  class="span11" maxlength="16" />
                     @if($errors->has('accountNo'))
                     <span class="help-block">
                     <strong>{{ $errors->first('accountNo') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Account Name</label>
                     <input type="text"  name="accountName" value="{{$bankmaster->accountname }}" class="form-control  " autocomplete="off"placeholder="account name"  class="span11" maxlength="16"/>
                     @if($errors->has('accountName'))
                     <span class="help-block">
                     <strong>{{ $errors->first('accountName') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>IFSC Code</label>
                     <input type="text"  name="IFSCcode" value="{{$bankmaster->ifsccode }}" class="form-control number" autocomplete="off"placeholder="IFSC Code"  class="span11" maxlength="25"/>
                     @if($errors->has('IFSCcode'))
                     <span class="help-block">
                     <strong>{{ $errors->first('IFSCcode') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Bank Name</label>
                     <input type="text"  name="BankName" value="{{$bankmaster->bankname }}" class="form-control " autocomplete="off"placeholder="bank name"  class="span11" maxlength="16"/>
                     @if($errors->has('BankName'))
                     <span class="help-block">
                     <strong>{{ $errors->first('BankName') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Branch Name</label>
                     <input type="text"  name="BranchName" value="{{$bankmaster->branchname }}" class="form-control" autocomplete="off"placeholder="branch name"  maxlength="20"class="span11" />
                     @if($errors->has('BranchName'))
                     <span class="help-block">
                     <strong>{{ $errors->first('BranchName') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Branch Code</label>
                     <input type="text"  name="BranchCode" value="{{$bankmaster->branchcode }}" class="form-control number" autocomplete="off" maxlength="20" placeholder="branch code"  class="span11" />
                     @if($errors->has('BranchCode'))
                     <span class="help-block">
                     <strong>{{ $errors->first('BranchCode') }}</strong>
                     </span>
                     @endif
                  </div>
               
                <div class="form-group">
               
               <div class="col-sm-6">
                <button type="submit" class="btn bg-green btn-block">
                 Save</button></div>   <div class="col-sm-6"> <a href="{{ url('viewbank') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
               </div>
                <!-- Select multiple-->


              </form></div><div class="col-lg-3"></div>
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
    $('#edititemform').validate({
    
    });
  });
</script>
@endpush