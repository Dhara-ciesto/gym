@extends('layouts.adminLayout.admin_design')
@section('content')
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>All Reason</h2></section>
 -->          <!-- general form elements -->
        

<div class="container-fluid">
  <hr> 
  @if ($message = Session::get('message'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>
@endif 
<div class="table-wrapper">
  <div class="table-title">
<?php $permission = unserialize(session()->get('permission'));   ?>
       <div class="box">
    <div class="box-header">
       @if(isset($permission["'add_reason'"]))
      <a href="{{ url('addquestion') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i> Add New</a>
      @endif

    <h3 class="box-title">View Question</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
      <div class="row">
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
             <tr>
                <th>Question</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>@foreach($reasons as $reason)
              <tr>
                <td> {{ $reason->qustionname }}</td>
      
              <td>
                 @if(isset($permission["'edit_reason'"]))
                 <a href="{{ url('editquestion/'.$reason->questionmasterid) }}" class="edit" title="Edit"><i class="fa fa-edit"></i></a>
                 @endif

                 
              </td>
              </tr>
              
              @endforeach
            </tbody></div>
            </table>
<!-- /.box-body -->
</div>
        </div>

    </div>
  </div>
</div>
</div>
</div></div>
</div>
@endsection