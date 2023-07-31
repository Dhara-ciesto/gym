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
      <h2>Assign Package</h2>
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
      <form role="form" action="{{ url('transactionfinalforpackage') }}" name="frmMr" method="POST" id="package_form">
         {{ csrf_field() }}
         <input type="hidden" name="RootSchemeId" value="{{ $RootSchemeId }}">
         <input type="hidden" name="schemeid" value="{{ $schemeid }}">
         <input type="hidden" name="selectusername" value="{{ $selectusername }}">
         <input type="hidden" name="ActualAmount" value="{{ $ActualAmount }}">
         <input type="hidden" name="tax_radio" value="{{ $tax_radio }}">
         <input type="hidden" name="Discount" value="{{ $Discount }}">
         <input type="hidden" name="discount_radio" value="{{ $discount_radio }}">
         <input type="hidden" name="total_amount" value="{{ $total_amount }}">
         <input type="hidden" name="amount_paid" value="{{ $amount_paid }}">
         <input type="hidden" name="BaseAmount" value="{{ $BaseAmount }}">
         <input type="hidden" name="tax" value="{{ $tax }}">
         <input type="hidden" name="remainingamount" value="{{ $remainingamount }}">
         <input type="hidden" name="due_date" value="{{ $due_date }}">
         <input type="hidden" name="memberpackage_id" value="{{ $memberpackages_data->memberpackagesid }}">
         <div class="box box-primary" id="secondstep" >
            <div class="box-header with-border">
               <h3 class="box-title">Transcation</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
               <div class="col-md-8">
                <table class="table">
                  <input type="hidden" name="no_of_days" id="no_of_days" value="{{ !empty($scheme_name->numberofdays) ? $scheme_name->numberofdays : 0}}">
                   <tr>
                     <th>Member Name</th>
                     <td>:</td>
                     <td>{{ !empty($user->firstname) ? ucfirst($user->firstname) : '' }} {{ !empty($user->lastname) ? ucfirst($user->lastname) : ''  }}</td>
                   </tr>
                    <tr>
                     <th>Member Package</th>
                     <td>:</td>
                     <td>{{ !empty($scheme_name->schemename) ? ucfirst($scheme_name->schemename) : '' }}</td>
                   </tr>
                   <tr>
                     <th>Joining Date</th>
                     <td>:</td>
                     <td><input type="date" name="join_date" class="form-control" id="join_date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" ></td>
                   </tr>
                   <tr>
                     <th>End Date</th>
                     <td>:</td>
                     <td><input type="text" name="end_date" class="form-control" id="end_date" readonly=""></td>
                   </tr>
                   <tr>
                     <th>Enroll in device</th>
                     <td>:</td>
                     <td><a href="javascript:void(0)" class="btn btn-success">Enroll In Device</a></td>
                   </tr>
                </table>
                <center><button type="submit"   id="save" value="button"  class="btn bg-green margin">
                Submit</button></center>
              </div>
            </div>
        </div>
      </form>
    </section>
  </div>

@endsection

@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    let no_of_days = $('#no_of_days').val();
    console.log(no_of_days);
    let today_date = $('#join_date').val();
    let end_date = new Date(today_date);
    end_date.setDate(end_date.getDate() + parseInt(no_of_days));
    
    let d = ''+end_date.getDate();
    let m = ''+(end_date.getMonth() + Number(1));
    let y = end_date.getFullYear();

    if(m.length < 2) m = '0'+m;
    if(d.length < 2) d = '0'+d;

    end_date_replace = d + '-' + m + '-' + y;

    $('#end_date').val(end_date_replace);
  });

  $(document).on('change', '#join_date', function(){
    let no_of_days = $('#no_of_days').val();
    let today_date = $('#join_date').val();
    let end_date = new Date(today_date);
    end_date.setDate(end_date.getDate() + parseInt(no_of_days));
    
    let d = ''+end_date.getDate();
    let m = ''+(end_date.getMonth() + Number(1));
    let y = end_date.getFullYear();

    if(m.length < 2) m = '0'+m;
    if(d.length < 2) d = '0'+d;

    end_date_replace = d + '-' + m + '-' + y;
    console.log(end_date_replace);

    $('#end_date').val(end_date_replace);
  });

</script>

@endpush