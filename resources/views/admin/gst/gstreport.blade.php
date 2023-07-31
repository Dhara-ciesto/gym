<?php 
   include('..///config/database.php');
   include('..///config/session.php');
   ?>
@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/js/cdnjs-extra/jquery.easing.min.js') }}"></script>
<style type="text/css">
   .table-bordered {
   border: 1px solid #f4f4f4;
   }
   .customcheck {
   display: block;
   position: relative;
   padding-left: 35px;
   margin-bottom: 12px;
   cursor: pointer;
   font-size: 22px;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
   }
   /* Hide the browser's default checkbox */
   .customcheck input {
   position: absolute;
   opacity: 0;
   cursor: pointer;
   }
   /* Create a custom checkbox */
   .checkmark {
   position: absolute;
   top: 0;
   left: 0;
   height: 25px;
   width: 25px;
   background-color: #babbba;
   border-radius: 5px;
   }
   /* On mouse-over, add a grey background color */
   .customcheck:hover input ~ .checkmark {
   background-color: #ccc;
   }
   /* When the checkbox is checked, add a blue background */
   .customcheck input:checked ~ .checkmark {
   background-color: #00c0ef;
   border-radius: 5px;
   }
   /* Create the checkmark/indicator (hidden when not checked) */
   .checkmark:after {
   content: "";
   position: absolute;
   display: none;
   }
   /* Show the checkmark when checked */
   .customcheck input:checked ~ .checkmark:after {
   /*display: block;*/
   content: "";
   color: #20b904;
   }
   /* Style the checkmark/indicator */
   .customcheck .checkmark:after {
   left: 9px;
   top: 5px;
   width: 5px;
   height: 10px;
   border: solid white;
   border-width: 0 3px 3px 0;
   -webkit-transform: rotate(45deg);
   -ms-transform: rotate(45deg);
   transform: rotate(45deg);
   }
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
<section class="content-header">
<!--    <h2>GST Report</h2>
 --></section>
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
              <form role="form" action="{{ url('gstreport')}}" method="post" id="gstform">
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
                              <td>
                                 <select name="mode" class="form-control select2" id="mode" data-placeholder="Select a Mode" >
                                    <option value="" selected="" disabled="">Select a Mode</option>
                                    @foreach($modes as $mode)
                                    <option value="{{$mode->paymenttype}}" @if(isset($query['mode'])) {{$query['mode'] == $mode->paymenttype ? 'selected':''}} @endif>
                                    {{$mode->paymenttype}}
                                    </option>
                                    @endforeach
                                 </select>
                              </td>
                              <td>
                                 <select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
                                    <option value="" selected="" disabled="">Select a Username</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->userid}}"  @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>
                                    {{ $user->username }}              
                                    </option>
                                    @endforeach
                                 </select>
                              </td>
                              <td><input type="text" name="amount" class="form-control"value="{{$query['amount']}}"></td>
                           </tr>
                           <tr>
                              <td><input type="text" name="keyword" placeholder="Search Keyword" class="form-control" value="{{$query['keyword']}}"></td>
                              <td style="text-align: left" colspan="4"><button type="submit" id="submitbutton"name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('gstreport') }}" class="btn bg-red">Clear</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
            </div>
         </div>
         <div class="box box-primary">
   
               <div class="box-header with-border">
               <input type="hidden" name="excel" value="0" id="excel">
               <button type="button" class="btn btn-warning fa fa-file-excel-o" id="modalpopup" style="float: right; margin-right: 15px;"  data-toggle="modal" data-target="#exampleModalLong">
                  Excel</button> 
              <button type="button" class="btn btn-default" id="getexcel" style="display:none;" ><i class="fa fa-minus"></i>
                 Get Excel</button> 
                  {{-- <button id="getexcel" type="submit" class="btn bg-orange" style="float: right; margin-right: 15px;"><i class="fa fa-file-excel-o"></i>   getexcel </button> --}}
                  <h3 class="box-title">GST Report</h3>
               </div>
             
               <!-- /.box-header -->
               <div class="box-body">
                  @foreach($gstall as $g)
                  <input type="hidden" name="gstreport[]" value="{{$g}}">
                  @endforeach
                </form>
                  {{ csrf_field() }}
                  <div class="table-responsive">
                     <table id="gstreport" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                           @if($gst)
                           <th>InvoiceID</th>
                           <th>Member</th>
                           <th>Payment Date</th>
                           <th>Amount</th>
                           <th>Type</th>
                           <th>GST</th>
                           <th>GST amount</th>
                           <th>GST No</th>
                           <th>Company Name</th>
                        </thead>
                        <tbody>
                           @foreach($gst as $g)
                           <tr>
                              <td>{{$g->receiptno}}</td>
                              <td>{{$g->firstname}}{{$g->lastname}}</td>
                              <td>{{date('d-m-Y', strtotime( $g->paymentdate))  }}</td>
                              <td>{{$g->pamount}}</td>
                              <td>@if($g->mode != 'no mode') {{$g->mode}} @else{{'No mode'}}@endif</td>
                              <td>{{$g->ptax}}</td>
                              <td>{{$g->taxamount}}</td>
                              @php 
                              $companyname='';
                              $gstno='';
                              if($g->companyid != ''){
                              $companyname1=\App\Company::where('companyid',$g->companyid)->where('status',1)->get()->first();
                              $companyname=$companyname1->companyname;
                              $gstno=$companyname1->gstno;
                              }
                              @endphp
                              <td>{{$gstno}}</td>
                              <td>{{$companyname}}</td>
                           </tr>
                           @endforeach
                        </tbody>
                        @endif
                     </table>
                     <div class="datarender" style="text-align: center">
                      
                      @if(isset($query)) 
                      @else 
                        {{ $gst->links() }}
                      @endif  
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
</div>

<!-- Modal Code -->
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
<!--End Modal Code -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script  src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<script>
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

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
  
  })
</script>
@endsection