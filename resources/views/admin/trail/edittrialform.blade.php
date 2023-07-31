@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('dist/css/star-rating.min.css') }}">
<style type="text/css">
   input.trial {
   width: 20px; 
   height : 20px;
   }
   input.pt {
   width: 20px; 
   height : 20px;
   }
   input.gt {
   width: 20px; 
   height : 20px;
   }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1 style="text-decoration: none;">Edit Trial Form</h1>
</section>
<section class="content">
   @if($errors->any())
   <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{$errors->first()}}</strong>
   </div>
   @endif
   <!-- Info boxes -->
   <div class="row">
      <div class="col-lg-12">
         <div class="row">
            <div class="box box-info">
               <div class="box-header with-border">
                  <h3 class="box-title">Edit Trial Form</h3>
               </div>
               <div class="box-body">
                  <div class="box-body">
                     <form name="refreshForm">
                        <input type="hidden" name="visited" value="" />
                     </form>
                     <div class="col-lg-1"></div>
                     <div class="col-lg-8">
                        <form role="form" action="{{url('edittrialform/'.$trialform->trailformid)}}"  class="form-horizontal" method="post" id="edititemform" >
                           {{csrf_field()}}
                           <div id="specific">
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="date">Date<span style="color: red">*</span></label>
                                 <div class="col-sm-8">
                                    <input class="form-control" type="date" autocomplete="off" id="date" onkeypress="return false"  name="date"  value="{{$trialform->date}}"  required="">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="clientname">Client Name<span style="color: red">*</span></label>
                                 <div class="col-sm-8">
                                    <input class="form-control" type="text" onchange="valid()" id="clientname"   value="{{$trialform->clientname}}" name="clientname" placeholder="Enter Client Name" required=""> 
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="mobileno">Mobile No</label>
                                 <div class="col-sm-8">
                                    <input class="form-control number"   value="{{$trialform->mobileno}}"  id="mobileno"  onkeyup="valid()" name="mobileno" placeholder="Mobile No" type="text" maxlength="10"  />
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="mobileno">Trainer</label>
                                 <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{$trialform->first_name.' '.$trialform->last_name }}"  id="trainerid"  name="trainerid"  readonly="" placeholder="Trianer">
                                    <input type="hidden" class="form-control" value="{{$trialform->employeeid }}"  id="trainerid"  name="trainerid"  readonly="" placeholder="Trianer">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="Timing">Timing</label>
                                 <div class="col-sm-8">
                                    <input class="form-control" type="time" id="time" name="timing" value="{{$trialform->timing}}">
                                 </div>
                              </div>
                            
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="PT">PT</label>
                                 <div class="col-sm-8">
                                    <input type="checkbox" name="pt" class="pt" id="pt" value="pt" <?php if ($trialform->pt=='pt') {
                                       echo "checked";
                                       } ?>>
                                    <span class="checkmark"></span>
                                    &nbsp;     &nbsp;     &nbsp;     &nbsp;
                                    <label   for="GT">GT</label> &nbsp; 
                                    <input type="checkbox" name="gt" class="gt" id="gt" value="gt" <?php if ($trialform->gt=='gt') {
                                       echo "checked";
                                       } ?>>
                                    <span class="checkmark"></span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="Remarks">Remarks</label>
                                 <div class="col-sm-8">
                                   <input  name="rating" value="{{$trialform->remarks}}" type="text"  class="rating" data-min=0 data-max=5 data-step=1 data-size="sm"
                                       title="" >
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-4 control-label" for="remarks2"></label>
                                 <div class="col-sm-8">
                                    <textarea  name="remarks2"  rows="4" cols="50" class="remarks2" placeholder="Enter Remarks" required="" >{{{$trialform->remarks2}}} </textarea>
                                 </div>
                              </div>
                              <br>
                              <div class="form-group">
                                 <div class="col-sm-offset-6 col-sm-6">
                                    <button  type="submit"  class="btn btn-success"></span> Update
                                    </button>
                                    <a href="{{ url('viewtrialform') }}" type="button" class="btn btn-default">Cancel</a>
                                 </div>
                              </div>
                        </form>
                        </div>
                     </div>
                     <div class="col-lg-3"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
</section>
</div>
@php $trainerid=session()->get('employeeid'); @endphp
<script src="{{ asset('dist/js/star-rating.min.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function(){
     $('#edititemform').validate({
     
     });
   });
</script>
@endsection