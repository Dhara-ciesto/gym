@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
  .content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
  }
td{
  max-width: 20%;
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
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
<!--       <h1 style="text-decoration: none;">Payment Report</h1>
 -->   </section>
    <section class="content">
    <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="box box-info">
               <div class="box-header with-border">
                  <h3 class="box-title">Filters</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form action="{{url('paymentreport')}}" method="post"  id="gstform">
                    {{csrf_field()}}
            <div class="table-responsive">
              <table class="table no-margin">
              <thead>
              <tr>
                <th>From :</th>
                <th>To :</th>
                <th>Mode</th>
                <th>Username</th>
               <th>Amount</th>
                
              </tr>
            </thead>
            <tbody>
        
            <tr>
            <td><input type="date" name="fdate" class="form-control" value="{{$query['fdate']}}"></td>
            <td><input type="date" name="tdate" class="form-control" value="{{$query['tdate']}}"></td>
            <td><select name="mode" class="form-control select2" id="mode" data-placeholder="Select a Mode" >
              <option value="" selected="" disabled="">Select a Mode</option>
              @foreach($modes as $mode)
              <option value="{{$mode->paymenttype}}" @if(isset($query['mode'])) {{$query['mode'] == $mode->paymenttype ? 'selected':''}} @endif>
                {{$mode->paymenttype}}
                 </option>
                @endforeach</select></td>




            <td><select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
              <option value="" selected="" disabled="">Select a Username</option>
              @foreach($users as $user)

              <option value="{{$user->userid}}"  @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>
                
              {{ $user->username }}              
            
                 </option>
                @endforeach</select></td>
                <td><input type="text" name="amount" class="form-control"value="{{$query['amount']}}"></td>
            
            
            </tr>
            <tr>
              
              <td><input type="text" name="keyword" placeholder="Search Keyword" class="form-control" value="{{$query['keyword']}}"></td>
              <td style="text-align: left" colspan="4"><button type="submit"  id="submitbutton" name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('paymentreport') }}" class="btn bg-red">Clear</a></td>
              
            </tr>
            

            </tbody>
            </table>

            </div>
        
                </div>  
            </div>
            <div class="box box-info">
          <div class="box-header with-border">
 <input type="hidden" name="excel" value="0" id="excel">
               <button type="button" class="btn btn-warning fa fa-file-excel-o" id="modalpopup" style="float: right; margin-right: 15px;"  data-toggle="modal" data-target="#exampleModalLong">
                  Excel</button> 
              <button type="button" class="btn btn-default" id="getexcel" style="display:none;" ><i class="fa fa-minus"></i>
                 Get Excel</button> 
                  {{-- <button id="getexcel" type="submit" class="btn bg-orange" style="float: right; margin-right: 15px;"><i class="fa fa-file-excel-o"></i>   getexcel </button> --}}
                  <h3 class="box-title">Payment Report</h3>
           
          </div>
          <!-- /.box-header -->
         <div class="box-body">
                  @foreach($paymentdatahidden as $paymentdatahidden1)
                  <input type="hidden" name="paymentreport[]" value="{{$paymentdatahidden1}}">
                  @endforeach
                </form>
                 
            <div class="table-responsive">
              <table id="paymentreport" class="table no-margin">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Invoice ID</th>
                  <th>Name</th>
                   <th>Package</th>
                  <th>Mode</th>
                  <th>Amount</th>
                  <th>TakenBy</th>
                  <th>ReceiptNo</th>
                  <th>Company Name</th>
                </tr>
                </thead>
                <tbody>
             
                  @if(count($paymentdata)>0)

                  @foreach($paymentdata as $paymentreport1)
                  <tr>
                    <td>{{date('d-m-Y',strtotime($paymentreport1->date))}}</td>
                    <td>{{$paymentreport1->invoiceno}}</td>
          <td>
            @if($paymentreport1->firstname) {{ucwords( $paymentreport1->firstname )}} {{ucwords($paymentreport1->lastname)}}
              @else {{ ucwords( $paymentreport1->rfirstname )}} {{ucwords($paymentreport1->rlastname)}} @endif </td>
                  
   
                                        <td>{{$paymentreport1->schemename}}</td>

                    <td>{{$paymentreport1->mode}}</td>
                    <td>{{$paymentreport1->pamount}}</td>
                    <td>{{$paymentreport1->name}}</td>
                    <td>{{$paymentreport1->receiptno}}</td>
                    <td>{{$paymentreport1->companyname}}</td>
                    
                  </tr>
                    @endforeach
                    @else
                    <tr><td colspan="8" style="text-align: center">{{ 'No Data Found'}}</td></tr>
                    @endif
                  
                </tbody>
              </table>
                  <div class="datarender" style="text-align: center">
          {!! $paymentdata->render() !!}  </div>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
      <!--     <div class="box-footer clearfix">
            <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
          </div> -->
          <!-- /.box-footer -->
        </div>
          </div>
        </div>

       </div>
   </section>
   <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLongTitle">Password</h5>
         <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
          <label>Enter Excel Password</label>
         <input type="password" class="form-control" name="pwd" id="pwd">
         <span id="wrongpwd" style="color:red"></span>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="button" class="btn btn-primary" id="checkpwd">Submit</button>
       </div>
     </div>
   </div>
</div>
</div>
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
<script type="text/javascript">
  $('#getexcel').click(function(e){
  e.preventDefault();
  $('#excel').val(1);

  $('#gstform').submit();

});
$('#submitbutton').click(function(e){
  e.preventDefault();
  $('#excel').val(0);
  $('#gstform').submit();

});

$('#checkpwd').on('click',function(){
      var password=$('#pwd').val();

      var pwdchecked='false';
      $.ajax({
            url:"{{ url('checkexcelpwd') }}",
            method:"POST",
            data:{excelpassword:password,"_token": "{{ csrf_token() }}"},
            success: function (response) {
              var res=response;
               if(res == true){
                  console.log('pwdcheck  :'+res);
                  pwdchecked='true';
                  $('#pwd').removeClass('error');
                  $('#getexcel').trigger('click');
                  $('#closemodal').trigger('click');
               }else{
                  $('#wrongpwd').html('wrong password');
                  $('#pwd').addClass('error');
               }
            },
            dataType:"json"
      });
  }); 

</script>
<script type="text/javascript">
  $("#mode").select2({
    placeholder: "Select a Mode"
});
</script>
@endsection