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
   .error{
      border:1px solid red; 
   }
</style>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
<!--       <h1 style="text-decoration: none;">Expiration Report</h1>
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
                     <form action="{{url('expirereport')}}" method="post">
                        {{csrf_field()}}
                        <div class="table-responsive">
                           <table class="table no-margin">
                              <thead>
                                 <tr>
                                    <th width="20%">Expire Date <br>From :</th>
                                    <th  width="20%">To :</th>
                                    <th  width="20%">Username</th>
                                    <th width="20%">Gender</th>
                                    <th  width="20%">Keyword</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td><input type="date" name="fdate" class="form-control" value="{{$query['fdate']}}" if="fdate"></td>
                                    <td><input type="date" name="tdate" class="form-control" value="{{$query['tdate']}}" if="tdate"></td>
                                    <td>
                                       <select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
                                          <option value="" selected="" disabled="">Select a Username</option>
                                          @foreach($users as $user)
                                             <option value="{{$user->memberid}}" {{ $query['username'] ==  $user->memberid ? 'selected' : ''}}>{{$user->firstname}} {{$user->lastname}}</option>
                                          @endforeach
                                       </select>
                                    </td>
                                    <td>
                                        <select name="gender" class="form-control select2 span8" data-placeholder="Select a Gender" >
                                           <option value="" selected="" disabled="">Select a Gender</option>
                                              <option value="Female" {{ $query['gender'] == 'Female' ? 'selected' : ''}}>Female</option>
                                              <option value="Male" {{ $query['gender'] == 'Male' ? 'selected' : ''}}>Male</option>
                                        </select>
                                     </td>
                                     <td><input type="text" name="keyword" placeholder="Search Keyword" class="form-control" value="{{$query['keyword']}}" id="keyword"></td>
                                 </tr>
                                 <tr>
                                    <th>Root Scheme</th>
                                    <th>Package</th>
                                    <th>Day</th>
                                    <th>Membership Status</th>
                                    <th>Package Status</th>
                                 </tr>
                                 <tr>
                                    <td><select name="rootschemeid" class="form-control select2 span8" data-placeholder="Select a RootScheme" >
                                       <option value="" selected="" disabled="">Select a RootScheme</option>
                                       @foreach($rootschemes as $rootscheme)
                                          <option value="{{$rootscheme->rootschemeid}}" {{ $query['rootschemeid'] ==  $rootscheme->rootschemeid ? 'selected' : ''}}>{{$rootscheme->rootschemename}}</option>
                                       @endforeach
                                    </select></td>
                                    <td><select name="schemeid" class="form-control select2 span8" data-placeholder="Select a Package" >
                                       <option value="" selected="" disabled="">Select a Package</option>
                                       @foreach($schemes as $scheme)
                                          <option value="{{$scheme->schemeid}}" {{ $query['schemeid'] ==  $scheme->schemeid ? 'selected' : ''}}>{{$scheme->schemename}}</option>
                                       @endforeach
                                    </select></td>
                                    <td><input type="text" name="day" class="form-control" placeholder="Day" value="{{$query['day']}}"></td>
                                    <td>
                                       <select name="status" class="form-control select2 span8" data-placeholder="Select a Status" >
                                          <option value="" selected="" disabled="">Select a Status</option>
                                             <option value="1" {{ $query['status'] == '1' ? 'selected' : ''}}>Active</option>
                                             <option value="1" {{ $query['status'] == '1' ? 'selected' : ''}}>To Be Expire</option>
                                             <option value="0" {{ $query['status'] == '0' ? 'selected' : ''}}>Expired</option>
                                       </select>
                                       
                                    </td>
                                    <td>
                                        <select name="pstatus" class="form-control select2 span8" data-placeholder="Select a Package Status" >
                                           <option value="" selected="" disabled="">Select a Package Status</option>
                                              <option value="1" {{ $query['pstatus'] == '1' ? 'selected' : ''}}>Active</option>
                                              <option value="0" {{ $query['pstatus'] == '0' ? 'selected' : ''}}>Expired</option>
                                        </select>
                                        
                                     </td>
                                 </tr>
                                 <tr>
                                
                                 <td style="text-align: left" colspan="4">
                                    <button type="submit" name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button>
                                    <a href="{{ url('expirereport') }}" class="btn bg-red">Clear</a></td>
                                 </tr>
                                 </tbody>
                           </table>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="box box-info">
                  <div class="box-header with-border">
                     <h3 class="box-title">Expiration Report</h3>
                     <div class="box-tools pull-right">
                        <button type="button" class="btn btn-warning fa fa-file-excel-o" id="modalpopup"  data-toggle="modal" data-target="#exampleModalLong">
                            Excel</button> 
                        <button type="button" class="btn btn-default hide" id="getexcel" ><i class="fa fa-minus"></i>
                           Get Excel</button> 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                     </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                     <div class="table-responsive">
                        <table class="table no-margin">
                           <thead>
                              <tr>
                                 <th>Memeber Name</th>
                                   <th>Mobileno</th>

                                 <th>Scheme Name</th>
                                 <th>Days</th>
                                 <th>Invoice No</th>
                                 <th>JoinDate</th>
                                 <th>ExpireDate</th>
                              </tr>
                           </thead>
                           <tbody>
                              @if($paymentdata)
                                 @foreach($paymentdata as $pdata)
                                    <tr>
                                       <td>{{$pdata->username}}</td>
                                              <td>{{$pdata->usermobileno}}</td>

                                       <td>{{$pdata->schemename}}</td>
                                       @php 
                                       $diff = strtotime($pdata->expiredate) - strtotime(date('Y-m-d')); 
                                       $d= abs(round($diff / 86400)); 
                                       @endphp
                                       <td>{{$d}}</td>
                                    <td>{{$pdata->memberpackagesid}}</td>
                                       <td>{{ date('d-m-Y',strtotime($pdata->joindate)) }}</td>
                                       <td>{{ date('d-m-Y',strtotime($pdata->expiredate))}}</td>
                                    </tr>
                                 @endforeach
                              @endif
                           </tbody>
                        </table>
                        <div class="datarender" style="text-align: center">
                      
                        </div>
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
</div>
<!-- Button trigger modal -->

 
 <!-- Modal -->
 <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLongTitle">Password</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
   $("#mode").select2({
      placeholder: "Select a Mode"
   });
</script>

<script type="text/javascript">
  
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
                  pwdchecked='true';
                  $('#pwd').removeClass('error');
                  $('#getexcel').trigger('click');
                  $('#exampleModalLong').modal('hide');
               }else{
                  $('#wrongpwd').html('wrong password');
                  $('#pwd').addClass('error');
               }
            },
            dataType:"json"
      });
  });
          /**************************************************************************************/
   $('#getexcel').on('click',function(){ 
      var fdate='<?php echo (!empty($query['fdate']) ? $query['fdate'] :  "empty"); ?>';
      var tdate='<?php echo (!empty($query['tdate']) ? $query['tdate'] :  "empty"); ?>';
      var keyword='<?php echo (!empty($query['keyword']) ? $query['keyword'] :  "empty"); ?>';
      var day='<?php echo (!empty($query['day']) ? $query['day'] :  "empty"); ?>';
      var user='<?php echo (!empty($query['username']) ? $query['username'] :  "empty"); ?>';

      $.ajax({
         url:"{{ url('expiredmemberreport/excel') }}",
         method:"POST",
         data:{user:user,fdate:fdate,tdate:tdate,day:day,keyword:keyword,"_token": "{{ csrf_token() }}"},
         success: function (response, textStatus, request) {
                        var a = document.createElement("a");
                        a.href = response.file; 
                        a.download = response.name;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        },
         dataType:"json"
      });
   });
 </script>
@endsection