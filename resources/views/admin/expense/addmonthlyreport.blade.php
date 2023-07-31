@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
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
<!-- left column -->
  <div class="content-wrapper">
    
     <!-- 
         <section class="content-header"><h2>Monthly Report
</h2></section> -->
          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Monthly Report
</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">


              <form role="form" action="{{ url('monthlyreport') }}" method="post" id="dietitemform" >
                 {{ csrf_field() }}
                <!-- text input -->
    <div class="form-group">
                 <label>Total Expense</label>

                  <input type="text" class="form-control"
                   readonly=""  value="{{$expensepayment1[0]->amount}}" name="totalamount" >
         
  
                </div>
               


                <div class="form-group">
                   <label for="year" class="control-label">Year</label>
           
                 
                                                        <select  class="form-control span11 select2"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Year" required="" id="year" name="year" data-sear value="{{ $year }}">
                                                                <option value="">Select year</option>
                                                            @for($i = 2019; $i<=2030; $i++)
                                                                <option value="{{ $i }}" @if($i == $year) selected="" @endif>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                   


                 
                </div>
               
              
  <div class="form-group">
                  <label for="month" class="control-label">Month</label>




  <select  class="form-control span11 select2"title="Select Month" dadta-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Month" required="" name="month" id="month" placeholder="Month">
                                                            <option value="">Select Month</option>
                                                            <option value='01' @if($month == '01') selected="" @endif>Janaury</option>
                                                            <option value='02' @if($month == '02') selected="" @endif>February</option>
                                                            <option value='03' @if($month == '03') selected="" @endif>March</option>
                                                            <option value='04' @if($month == '04') selected="" @endif>April</option>
                                                            <option value='05' @if($month == '05') selected="" @endif>May</option>
                                                            <option value='06' @if($month == '06') selected="" @endif>June</option>
                                                            <option value='07' @if($month == '07') selected="" @endif>July</option>
                                                            <option value='08' @if($month == '08') selected="" @endif>August</option>
                                                            <option value='09' @if($month == '09') selected="" @endif>September</option>
                                                            <option value='10' @if($month == '10') selected="" @endif>October</option>
                                                            <option value='11' @if($month == '11') selected="" @endif>November</option>
                                                            <option value='12' @if($month == '12') selected="" @endif>December</option>
                                                        </select>














                </div>
               


                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Search</button>
       </div> 

        <div class="col-sm-6">
         <a href="{{ url('monthlyreport') }}"class="btn btn-danger btn-block">Cancel</a>
             <br>

       </div>
   
     
      </div>

              <div class="form-group">
                 <label>Monthly Expense</label>


                  <input type="text" class="form-control"  readonly="" name="categoryname"   value="{{$expensepayment2[0]->amount == null ? '0' : $expensepayment2[0]->amount}}">
         
  
                </div>
               
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
    $('#dietitemform').validate({
    
    });
  });
</script>

<script type="text/javascript">

  $(function () {

var d = new Date(),
        
    y = d.getFullYear();

$('#year option[value="'+y+'"]').prop('selected', true);
      
    
    $('.select2').select2()

    //Datemask dd/mm/yyyy
  
  })
</script>
@endpush