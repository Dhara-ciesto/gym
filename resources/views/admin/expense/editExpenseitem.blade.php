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
  <section class="content-header">
<!--      <h2>Edit Expense Category</h2>
 -->  </section>
  <!-- general form elements -->
  <section class="content">
     <div class="box box-primary">
        <div class="box-header with-border">
           <h3 class="box-title">Edit Category</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
           <div class="col-lg-4"></div>
           <div class="col-lg-4">
              <form role="form" action="{{ url('editExpenseitem/'.$categoryname->expensecategoryid) }}" method="post" id="edititemform" >
                 {{ csrf_field() }}
                 <!-- text input -->
                 <div class="form-group">
                    <label>Item</label>
                    <input type="text"  name="categoryname" value="{{$categoryname->categoryname }}"  class="form-control  " autocomplete="off"placeholder="category name"  class="span11" maxlength="16"/>
                    @if($errors->has('categoryname'))
                    <span class="help-block">
                    <strong>{{ $errors->first('categoryname') }}</strong>
                    </span>
                    @endif
                 </div>
                 <div class="form-group">
                    <div class="col-sm-6">
                       <button type="submit" class="btn bg-green btn-block">
                       Save</button>
                    </div>
                    <div class="col-sm-6"> <a href="{{ url('viewexpense') }}"class="btn btn-danger btn-block">Cancel</a></div>
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
  $(document).ready(function(){
    $('#edititemform').validate({
    
    });
  });
</script>
@endpush