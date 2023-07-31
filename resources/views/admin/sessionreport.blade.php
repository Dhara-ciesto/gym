<?php 
 include('..///config/database.php');
 include('..///config/session.php');
?>

@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<!-- <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> --}}
 <style type="text/css">
   .table-bordered {
    border: 1px solid #f4f4f4;
}
 </style>
 {{-- <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> --}}
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
<script src="../../bower_components/datatables.net/js/jquery.js"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net/js/dataTables.bootstrap.min.js"></script>
<script src="../../bower_components/datatables.net/js/dataTables.responsive.js"></script>
  <style type="text/css">
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

  
  @php
 
  if(isset($_POST['trainerid'])){
     $tid=$_POST['trainerid'];
     $employee=\App\Employee::where('employeeid',$tid)->get()->first();
     $employeename=$employee->username;
  }
  else{
    $tid=0;
  }
  if(isset($_POST['memberid'])){

    $mid=$_POST['memberid'];
    $membername=\App\Member::where(['memberid' => $mid])->get(['firstname','lastname'])->first();
    $membername=$membername->firstname.' '.$membername->lastname;
    
  }
  else{
    $mid=0;
  }
  if(isset($_POST['packageid'])){
    $pid=$_POST['packageid'];
    $package=\App\MemberPackages::where('memberpackagesid',$pid)->get()->first();
    $schemeid=$package->schemeid;
    $scheme= \App\Scheme::where('schemeid',$schemeid)->where('status',1)->get()->first();
    $schemename=$scheme->schemename;
  }
  else{
    $pid=0;
  }
@endphp
@if(request()->route('tid'))
@php 
  $tid=request()->route('tid');
@endphp
@endif
@if(request()->route('mid'))
@php 
  $mid=request()->route('mid');
@endphp
@endif
@if(request()->route('pid'))
@php 
 $pid=request()->route('pid');
@endphp

@endif
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Session Report</h2></section>
 -->          <!-- general form elements -->
           <div class="content">
          
              @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
            @if(session('success'))
            <div class="alert alert-success">
              <li>{{session('success')}}</li>
          </div>
           
          @endif
            <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Session Report</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="{{ url('sessionreport')}}" method="post" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="col-md-3">
                <div class="form-group">
                  <label>Trainer</label>
                  @if(Session::get('role')=="trainer")
                  
                    @php
                    $trainerid=Session::get('employeeid');
                    $trainername=Session::get('username');
                    @endphp 
                    <input type="text" class="form-control" name="trainername" id="trainername" readonly="" value="{{$trainername}}">
                     <input type="hidden" name="trainerid" id="trainerid"  value="{{$trainerid}}">
                  @else
                      <select name="trainerid" class="form-control select2" id="trainerid" title="Select Trainer" data-header="Select Trainer" required data-placeholder="Select Trainer">
                   
                    <option></option>
                    @foreach ($employees as $employee)
                      <option value="{{$employee->employeeid}}" {{ $tid == $employee->employeeid ? 'selected':''}}>{{$employee->username}}</option>
                    @endforeach
                  </select>
                  @endif
                </div>
              </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Member</label>
                    <select name="memberid" class="form-control select2" id="memberid" required>
                      <option value="">Select Member</option>
                    </select>
                  </div>
              </div>
            <!--   <div class="col-md-3">
                  <div class="form-group">
                  <label>Mobile No.</label>
                  <input type="text" class="form-control" placeholder="Mobile No." name="mobileno" id="mobileno" readonly>
                </div>
              </div> -->
               
              <div class="col-md-6">
                <div class="form-group">
                  <label>Package</label>
                  <select name="packageid" class="form-control select2" id="packageid" title="Select Package"  required>
               <option value="">Select Package</option>
   
                  </select>

                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>From Date</label>
                <input type="date" name="fromdate" class="form-control" id="fromdate" value="{{ $fromdate ? $fromdate : ''}}" >
               
                  </select>
                </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>To Date</label>
                <input type="date" name="todate" class="form-control" id="todate"  value="{{$todate}}">
             
                </select>
              </div>
          </div>
               <div class="form-group">
                    <button name="view" type="submit" id="view" class="btn bg-green margin" style="margin-top: 25px">View</button>   <a href="{{ URL::route('sessionreport') }}"class="btn btn-danger margin" style="margin-top: 25px">Cancel</a>
                </div>
                <!-- Select multiple-->
               </form>
            </div>
          </div>


                <div class="box box-primary" style="display: block;" id="sessionreport">
  <div class="box-header with-border"></div>
    <div class="box-body" > 
      <button id="getexcel"  class="btn bg-orange" style="float: right; margin-right: 15px;"><i class="fa fa-file-excel-o"></i>   getexcel </button>
     <br>
      <br> <br>
     <div class="col-lg-12" style="overflow: auto;">
     <table id="measurement" class="table table-bordered table-striped" width="100%" >
                <thead>
                <tr>
                  @if(Session::get('role') == 'admin' || Session::get('role') == 'Admin')
                  <th>Action</th>
                  @endif
                <th>Trainer</th>
                <th>Member</th>
                <th>Day</th>
                <th>Date</th>
               
                <th>Hoursfrom</th>
                <th>Hoursto</th>
                <th>Actualdate</th>
                <th>Actualtime</th>
                <th>Status</th>
                <!-- <th>Packageid</th>
                <th>Schemeid</th> -->
                <th>Commision</th>
                {{-- <th>Persessioncommision</th>
                <th>Persessionamount</th> --}}
                <th>Paymentstatus</th>
                
                
                </tr>
                </thead>
                <tbody>
               @foreach($grid as $key=>$g)
                <tr class="ClassName">

                  @if(Session::get('role') == 'admin' || Session::get('role') == 'Admin' )
                <td>@if($g->status != 'Deleted')<a href="{{ url('deletesession/'.$g->ptmemberid.'/'.$tid.'/'.$mid.'/'.$pid) }}"class="text-danger"  title="Delete"><i class="fa fa-close "></i></a>@endif</td>
                  @endif
                <td>{{$employeename !== '' ?$employeename: $g->ptrainerid}}</td>
                <td>{{ucwords($membername !== '' ? $membername : $g->pmemberid)}} </td>
                <td>{{date('D',strtotime($g->scheduledate))}} </td>
                <td>{{date('d-m-Y',strtotime($g->scheduledate))}}</td>
                <td>{{$g->hoursfrom}} </td>
                <td>{{$g->hoursto}} </td>
                <td>@if($g->actualdate){{ date('d-m-Y',strtotime($g->actualdate))}} @endif</td>
               <td>{{$g->actualtime}}</td>


                <td>{{$g->status}} </td>
           <!--      <td>{{$g->ppackageid}}</td>
                <td>{{$schemename != '' ? $schemename : $g->schemeid}}</td>
                 {{-- <td>{{'finaltrainerid'}}</td> --}}
                 -->
                
                <td>{{$g->comission}} </td>
                {{-- <td>{{$g->persessioncommision}}</td>
                <td> {{$g->persessionamount}}</td> --}}
                <td>{{$g->paymentstatus}} </td>
              
                          
                </tr>
                 @endforeach
                </tbody>
            
              </table>
              Total Session : {{ count($grid) }}
              @php 
              $grid1 = json_decode(json_encode($grid), true);
                          
              @endphp
              <input type="hidden" name="griddata" id="griddata" value="">


<script type="text/javascript">
 

</script>
    

              <!-- <a href="{{url('generatexcel')}}">gen Excel</a> -->
      </div>
    </div>

</div>
</div>
</div>
<script>
function doSearch(fr,t) {
var d1 = fr.split("-");
var d2 = t.split("-");
var from = new Date(d1[2], d1[1]-1, d1[0]);  
var to   = new Date(d2[2], d2[1]-1, d2[0]);


        var targetTable = document.getElementById('measurement');
        var targetTableColCount;
        for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++) {
            var rowData = [];
            if (rowIndex == 0) {
                targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
                continue; 
            }

            for (var colIndex = 0; colIndex < targetTableColCount; colIndex++) {
                rowData.push(targetTable.rows.item(rowIndex).cells.item(colIndex).textContent);
            }
		for(var i=0;i<rowData.length;i++){
				var c = rowData[i].split("-");
				var check = new Date(c[2], c[1]-1, c[0]);
  
				if ((check >= from) && (check <= to))
				    targetTable.rows.item(rowIndex).style.display = 'table-row';
				else
				    targetTable.rows.item(rowIndex).style.display = 'none';                    
		}

        }
    }

</script>
<script>
  $(function () {
    $('#measurement').DataTable({
     "order": [[ 1, "Desc" ]],
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
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
  var tid=<?php echo $tid;?>;
      var mid=<?php echo $mid;?>;
      var pid=<?php echo $pid;?>;
 
 $( document ).ready(function() {
     var tid=<?php echo $tid;?>;
      var mid=<?php echo $mid;?>;
      var pid=<?php echo $pid;?>;

      if(trainerid == 0 && memberid == 0 && packageid ==0){
        $('#sessionreport').css('display','none');
      }
      if(trainerid !== 0){
        
      }
      if(memberid !== 0){
       
      }
    $('#trainerid').trigger('change');
 // $('#memberid').trigger('change'); 

     
});
 $('#view').on('click',function(){
 
 })
</script>
<script type="text/javascript">
  $('#getexcel').on('click',function(){
  var trainerid=<?php echo $tid;?>;
  var memberid=<?php echo $mid;?>;
  var packageid=<?php echo $pid;?>;
  if (trainerid!=0 || memberid!=0 || packageid!=0) {
    $.ajax({
      url:"{{ url('getqueryresultforexcel') }}",
      method:"GET",
      data:{"_token": "{{ csrf_token() }}","memberid":memberid,"trainerid":trainerid,"packageid":packageid},
        success:function(grid) {
          grid=JSON.parse("[" + grid + "]");;
          $.ajax({
            url:"{{ url('getexcel') }}",
            method:"POST",
            data:{"_token": "{{ csrf_token() }}","memberid":memberid,"trainerid":trainerid,"packageid":packageid},
            success: function (response, textStatus, request) {
              var a = document.createElement("a");
              a.href = response.file; 
              a.download = response.name;
              document.body.appendChild(a);
              a.click();
              a.remove();
            },
            dataType:'json',
          });
        },
      });
    }  
  });

  $('#trainerid').change(function(){
    var trainerid = $('#trainerid').val();
    $('#memberid').find('option:not(:first)').remove();
    $.ajax({
      url:"{{ url('getsessiontrainermember') }}",
      method:"GET",
      data:{"_token": "{{ csrf_token() }}","trainerid":trainerid},
      success:function(data) {
       var  result=data;
        if(result){
          $.each(result, function(i, item){
          $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.firstname+' '+item.lastname));
          });
          $("#memberid option[value="+mid+"]").attr("selected", "selected");
          if(mid){
            $("#memberid").trigger('change');
          }
        }
      },
      dataType:'json',
    });
  });
</script>
<script type="text/javascript">
  $('#memberid').change(function(){
    var member1 = $('#memberid').val();
    $.ajax({
      url:"{{ URL::route('getpackage') }}",
      method:"GET",
      data:{"_token": "{{ csrf_token() }}","memberid":member1},
      async:false,
      success:function(data) {
        if(data){
          $('#packageid').find('option:not(:first)').remove();
          $.each(data, function(i, item){
            
            $('#mobileno').val(item.mobileno);
            let current_datetime = new Date(item.joindate)
                        let joindate = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
                        let enddatetime = new Date(item.expiredate)
                        let end_date = enddatetime.getDate() + "-" + (enddatetime.getMonth() + 1) + "-" + enddatetime.getFullYear();
            $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(item.schemename+ ' Start ' +joindate+ ' End ' +end_date ));
          });
          $("#packageid option[value="+pid+"]").attr("selected", "selected");
        }
      },
      dataType:'json',
    });
  });
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection