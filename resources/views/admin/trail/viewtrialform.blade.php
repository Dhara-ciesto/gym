@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
  .content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
  }
td{
  max-width: 10%;
}
table td{
  width: 10% !important;
  max-width: 10% !important;
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
<!--        <h1 style="text-decoration: none;">View Trial Form Details</h1>
 -->     </section>
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
                    <form action="{{url('viewtrialform')}}" method="post" id="gstform">
                      {{csrf_field()}}
              <div class="table-responsive">
                <table class="table no-margin">
                <thead>
              <tr>
                  <th>From :</th>
                  <th>To :</th>
                
                  <th>Clientname</th>
                  <th>Mobile No</th>

                  
                </tr>
              </thead>
              <tbody>
          
              <tr>
              <td><input type="date" name="fdate" class="form-control" value="{{$query['fdate']}}"></td>
              <td><input type="date" name="tdate" class="form-control" value="{{$query['tdate']}}"></td>
          
              <td><select name="clientname" class="form-control select2 span8" data-placeholder="Select a clientname" >
                <option value="" selected="" disabled="">Select a Clientname</option>
                @foreach($users as $user)

                <option value="{{$user->trailformid}}"  @if(isset($query['clientname'])) {{$query['clientname'] == $user->trailformid ? 'selected':''}} @endif>
                  
                  {{ $user->clientname }} 
              
              
                   </option>
                  @endforeach</select></td>
                  
              <td><select name="mobileno" class="form-control select2 span8" data-placeholder="Select a Mobile No" >
                <option value="" selected="" disabled="">Select a Mobile</option>
                @foreach($users as $user)

                <option value="{{$user->mobileno}}"  @if(isset($query['mobileno'])) {{$query['mobileno'] == $user->mobileno ? 'selected':''}} @endif>
                  
                  {{ $user->mobileno }} 
              
              
                   </option>
                  @endforeach</select></td>
                  
              
              </tr>
              <tr>
              
                <td style="text-align: left" colspan="4"><button type="submit" id="submitbutton" name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('viewtrialform') }}" class="btn bg-red">Clear</a></td>
                
              </tr>
              

              </tbody>
              </table>

              </div>
                  </div>  
            </div>
            <div class="box box-info">
           
            <div class="box-header">
             <h3 class="box-title">Trial Form Details</h3>
                    <div class="box-tools pull-right">
                      <a href="{{ url('trialform') }} " class="btn add-new bg-orange">
                            <i class="fa fa-plus"></i>Add New
                          </a>
                           </div>
            </div>
            <!-- /.box-header -->
        <div class="box-body">
                  @foreach($data as $data1)
                  <input type="hidden" name="trialform[]" value="{{$data1}}">
                  @endforeach
                </form>
                  {{ csrf_field() }}
              <div class="table-responsive">
                 <table id="trialform" class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <th>Date</th>
                                    <th>Client Name</th>
                                    <th>Mobile No</th>
                                    <th>Trainer Name</th>
                                    
                                    <th>Remarks</th>
                                    <th>View</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($data as $trialform)
                                 <tr>
                                    <td>{{ date('d-m-Y', strtotime($trialform->date))}}</td>
                                    <td>{{$trialform->clientname}}</td>
                                    <td>{{$trialform->mobileno}}</td>
                                    <td>{{ucwords($trialform->first_name)}} {{ucwords($trialform->last_name)}}</td>
                                    
                                    <td>{{$trialform->remarks2}}</td>
                                    <td>
                                       <a href="{{url('edittrialform/'.$trialform->trailformid)}}"class="" title="Edit"><i class="fa fa-pencil"></i></a> 
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                    <div class="datarender" style="text-align: center">
          {!! $data->render() !!}  </div>
            </div>
              </div>
              <!-- /.table-responsive -->
            </div>
   
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