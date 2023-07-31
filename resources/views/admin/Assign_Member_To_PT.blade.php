@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 <style type="text/css">
   .table-bordered {
    border: 1px solid #f4f4f4;
}
 </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>

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
    background-color: #b9bbbf;
    border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.customcheck:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.customcheck input:checked ~ .checkmark {
    background-color: #20b904;
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
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Assign Member To Trainer</h2></section>
 -->          <!-- general form elements -->
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
            @if(request()->route('id'))
              @php 
                $id=request()->route('id');
              @endphp
            @else
              @php 
                $id='';
              @endphp
            @endif
            <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Assign Member To PT</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('') }}" method="post" id="as_form" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">

                  <label>Trainer<span style="color: red">*</span></label>
                   @if(Session::get('role')=="trainer")
                  
                    @php
                    $trainerid=Session::get('employeeid');
                    $trainername=Session::get('username');
                    @endphp 
                    <input type="text" class="form-control" name="trainername" id="trainername" readonly="" value="{{$trainername}}">
                     <input type="hidden" name="trainerid" id="trainerid"  value="{{$trainerid}}">
                  @else
                     

                   <select name="trainerid" class="form-control select2" id="trainerid" data-placeholder="-Select Trainer-" required="">
                    <option></option>
                    @foreach ($employees as $employee)
                      <option value="{{$employee->employeeid}}" >{{$employee->username}}</option>
                    @endforeach
                  </select>

                  @endif
                </div>

                <div class="form-group">
                  <label>Member<span style="color: red">*</span></label>
                   <select name="memberid" class="form-control select2" id="memberid" data-placeholder="Select Member" data-header="Select Memeber" required="">
                    <option></option>
                   
                  </select>
                </div>
                  <div class="form-group">
                  <label>Mobile No.</label>
                  <input type="text" class="form-control" value="{{ old('mobileno') }}" placeholder="Mobile No." name="mobileno" id="mobileno" readonly>
                  <!-- </select> -->
                </div>
                <script type="text/javascript">
                  $('#memberid').change(function(){
                       var member = $('#memberid').val();
                    // alert(member);
                 

                              $.ajax({
                                   url:"{{ URL::route('assignptmembermobileno') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member},
                                  success:function(data) {
                                    // alert(data);
                                      
                                      // $('#mobile_no').fadeIn().html(data);
                                     
                                     // $('#mobile_no').html('<option value="'+data+'">'+data+'</option>');
                                     // alert($('#mobileno').val());
                                     $('#mobileno').val(data);
                                  },

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
                </script>
                <div class="form-group">
                  <label>Package<span style="color: red">*</span></label>
                   <select name="packageid" class="form-control select2" id="packageid"  required="">
                    <option value="">Select Member Package</option>
                  </select>
                </div>
                <script type="text/javascript">
                  $('#memberid').change(function(){
                      $('#pthour').val('');
                       $('#packageid').find('option:not(:first)').remove();
                       var member = $('#memberid').val();
                    // alert(member);
                 

                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member,'type':'memberpackageassign','schemeid':''},
                                   async:false,
                                  success:function(data) {
                                    // alert(data);
                                      $.each(data, function(i, item){
                                        let current_datetime = new Date(item.joindate)
                                        let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
                                         let enddatetime = new Date(item.expiredate)
                                        let end_date = enddatetime.getDate() + "-" + (enddatetime.getMonth() + 1) + "-" + enddatetime.getFullYear();
                                        $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(' '+item.schemename+'  Start '+formatted_date+' End '+end_date));

                                      });
                                  },
                                  dataType:'json',

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
                </script>
                 <div class="form-group">
                  <div class="col-lg-6">
                    <label class=""><input value="3" @if(old('pkgtype') == 3) checked @else @endif name="pkgtype" type="radio" checked> Alternate</label>
                  </div>
                  <div class="col-lg-6">
                    <label class=""><input value="6"name="pkgtype" type="radio" @if(old('pkgtype') == 6) checked @endif> Daily</label>
                  </div>
                  
                </div>

                <div class="form-group">
                  <label>Trainer Hours</label>
                  <input type="text" class="form-control" placeholder="Trainer Hours" name="pthour" id="pthour" readonly>
                </div>
                <div class="form-group">
                  <label>Select Date From</label>
                  <input type="date" onkeypress="return false" class="form-control" name="date" id="date">
                </div>
                <div class="form-group">
                  <label>Select Date End</label>
                  <input type="date" onkeypress="return false" class="form-control" name="date" id="date1">
                </div>
                 <script type="text/javascript">
                  $('#packageid').change(function(){

                       var member = $('#memberid').val();
                       $('#date1').val('');
                       $('#date').val('');
                       $('#pthour').val('');
                    // alert(member);
                      
                    // alert($('#packageid').val());
                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":'','type':'pthour','schemeid':$('#packageid').val()},
                                  success:function(data) {
                                    // swal(data,"Successfully",'success');
                                    $('#pthour').val(data);

                                  },

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
                </script>
                <script type="text/javascript">
                  $('#memberid').change(function(){
                    $('#date1').val('');
                    $('#date').val('');
                  });
                </script>

                <div class="form-group">   <div class="col-sm-offset-3">
   <div class="col-sm-8">
      <button name="view" type="button" id="view"  class="btn bg-green margin">View</button>   <a href="{{ URL::route('assignmembertotrainer') }}"class="btn btn-danger">Cancel</a></div></div>
  
  </div>
                <!-- Select multiple-->
        

              </form></div><div class="col-lg-3"></div></div>
            </div>
            <!-- /.box-body -->
          </div>
                 
  </section>
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
    Date.prototype.getWeek = function() {
    var onejan = new Date(this.getFullYear(),0,1);
    var today = new Date(this.getFullYear(),this.getMonth(),this.getDate());
    var dayOfYear = ((today - onejan +1)/86400000);
    return Math.ceil(dayOfYear/7)
};
  </script>
  <script type="text/javascript">
     $('#view').click(function(){
        $('#grid').empty();
      $.ajax({
        url:"{{ URL::route('assigntimeslot') }}",
        method:"GET",
        data:{"_token": "{{ csrf_token() }}","trainerid":$('#trainerid').val(),'packageid':$('#packageid').val(),"memberid":$('#memberid').val()},
        // async:false,
        success:function(data) {
                                    // swal(data,"Successfully",'success');
        // alert(data);
        var html='<table id="example1" class="table table-bordered table-striped dataTable dt-responsive"  width="auto" style="overflow: auto;"><thead>';
        html+='<tr><th>Day</th><th>6:00 am</th><th>7:00 am</th><th>8:00 am</th><th>9:00 am</th><th>10:00 am</th><th>11:00 am</th><th>12:00 pm</th><th>13:00 pm</th><th>14:00 pm</th><th>15:00 pm</th><th>16:00 pm</th><th>17:00 pm</th><th>18:00 pm</th><th>19:00 pm</th><th>20:00 pm</th><th>21:00 pm</th><th>22:00 pm</th><th>23:00 pm</th><!-- <th>Action</th> --><!-- <th>Delete</th> --></tr></thead>';
  
        var n=0;
        var result=data;
        if(result=="noslots")
        {
          swal(" Please Add PT Time","Error!","error");
          $('#close').trigger('click');
        }
        if(data=="")
        {
          swal(" Member Can not Assign Second Time in Same Package","Error!","error");
          $('#close').trigger('click');
        }
        if(data!='')
        {
          var d = [];

         $.ajax({
          url:"{{ URL::route('ajaxgetptslot') }}",
          method:"GET",
          data:{"_token": "{{ csrf_token() }}","trainerid":$('#trainerid').val()},
          // async:false,
          success:function(data1) {

            $.each(data1, function(i, item1){   
            // alert(item1.day);   
          // alert(i[]);
        // if(item1.ptfromdate!=null && item1.todate !=null)
        // {
        //   if(item1.memberid==$('#memberid').val())
        //   {
        //     var today = new Date(item1.date);
        //     var weekno = today.getWeek();
        //     today=new Date($('#date').val())
        //     var wfd=today.getWeek();
        //        // alert(wfd);
        //        // alert(weekno);
        //   if(weekno==wfd)
        //   {
        //     if(jQuery.inArray(item1.Day,d) == -1 && item1.memberid==$('#memberid').val())
        //     {
            html +='<tr>';
            html +='<td>'+item1.day+'<input type="hidden" name="strainerid" value="'+$('#trainerid').val()+'"><input type="hidden" name="sday'+n+'" value="'+item1.day+'"><input type="hidden" name="memberid" value="'+$('#memberid').val()+'"><input type="hidden" name="memberpackagesid" value="'+$('#packageid').val()+'"></td>';

        
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="06:00" name="600'+n+'" type="checkbox"';
            // alert($('#date').val());
            $.each(data, function(i, item){
              // alert(item.memberid);
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="06:00" && item1.day==item.Day)
              {
                // alert('checked');
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
            }
            });
              if(item1.t600=='-1')
              {
                html+='disabled';
              }
            
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
              // alert(item.hoursfrom);
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="06:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t600=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="07:00" name="700'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="07:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
            }
            });
              if(item1.t700=='-1')
              {
                html+='disabled';
              }
            
            html+='><span class="checkmark"';
            $.each(data, function(i, item){
            if(new Date(item.todate) >=new Date($('#date').val()) && new Date(item.fromdate )<= new Date($('#date1').val()))
            {

              if(item.hoursfrom=="07:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t700=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="08:00" name="800'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="08:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
            }
          });
            if(item1.t800=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="08:00" && item1.day==item.Day)
              {

                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t800=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="09:00" name="900'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {
              // alert(item.todate);
              if(item.hoursfrom=="09:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
          });
            if(item1.t900=='-1')
            {
              html+='disabled';
            }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="09:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t900=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="10:00" name="1000'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="10:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
             
            }
             
          });
            if(item1.t1000=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.todate >= $('#date').val() && item.todate <= $('#date1').val())
            {

              if(item.hoursfrom=="10:00" && item1.day==item.Day)
              {
                // alert(item.hoursfrom);
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1000=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="11:00" name="1100'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="11:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  html+=' style="background-color:black;"';
                  // $('#1100').attr('style','background-color:black');
                  return false;
                }
              }
              
            }
            
           });
            if(item1.t1100=='-1')
              {
                html+='disabled';
              }
            html+=' ><span id="1100"'; 
             $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="11:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
             if(item1.t1100=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+= 'class="checkmark"></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="12:00" name="1200'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="12:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
           });
            if(item1.t1200=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="12:00" && item1.day==item.Day)
              {
                // alert(item.hoursfrom);
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1200=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="13:00" name="1300'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="13:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t1300=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="13:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1300=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="14:00" name="1400'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="14:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t1400=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="14:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1400=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="15:00" name="1500'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="15:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t1500=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="15:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1500=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="16:00" name="1600'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="16:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                   return false;
                }
              }
              
            }
            
          });
            if(item1.t1600=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="16:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1600=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="17:00" name="1700'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="17:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t1700=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="17:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1700=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="18:00" name="1800'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="18:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t1800=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="18:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1800=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="19:00" name="1900'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="19:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t1900=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="19:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t1900=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="20:00" name="2000'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="20:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t2000=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="20:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t2000=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="21:00" name="2100'+n+'" type="checkbox"'; 
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="21:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t2100=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="21:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t2100=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="22:00" name="2200'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="22:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t2200=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="22:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t2200=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='<td><label class="customcheck"><input class="cb'+n+'" value="23:00" name="2300'+n+'" type="checkbox"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="23:00" && item1.day==item.Day)
              {
                html+='checked ';
                if(item.memberid!=$('#memberid').val())
                {
                  html+='disabled';
                  return false;
                }
              }
              
            }
            
          });
            if(item1.t2300=='-1')
              {
                html+='disabled';
              }
            html+=' ><span class="checkmark"';
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {

              if(item.hoursfrom=="23:00" && item1.day==item.Day)
              {
                if(item.memberid!=$('#memberid').val())
                {
                  html+=' style="background-color:orange;"';
                  return false;
                }
              }
              
            }
          });
            if(item1.t2300=='-1')
              {
                html+=' style="background-color:red;"';
              }
            html+='></span></label></td>';
            html +='</tr>'; 
            $.each(data, function(i, item){
            if(item.date >=$('#date').val() && item.date <= $('#date1').val())
            {
              $('#assigntrainer').empty();
              $('#l1').empty();

              if(item.memberid!=$('#memberid').val())
              {
                $('#l1').attr('style','color: green');
                $('#l1').append('Assign Schedule');
                $('#assigntrainer').append('Save');
                $('#form').attr('action','{{URL::route("assignpttomember")}}');
              }
              else
              {
                $('#l1').attr('style','color: Orange');
                $('#l1').append('ReAssign Schedule');
                $('#assigntrainer').append('Update');
                $('#form').attr('action','{{URL::route("editassignpttomember")}}');
                return false;
              }
            }
            else
            {
              $('#assigntrainer').empty();
              $('#l1').empty();
              $('#l1').attr('style','color: green');
              $('#l1').append('Assign Schedule');
              $('#assigntrainer').append('Save');
              $('#form').attr('action','{{URL::route("assignpttomember")}}');
            }
            });
            n= Number(n)+1;
          //   d.push(item1.Day);
          // }
          // }
          // }
          // else
          // {
          //   // alert(d);
          //   // var data=[{'Day':'Sunday'},{'Day':'Monday'},{'Day':'Tuesday'},{'Day':'Wednesday'},{'Day':'Thursday'},{'Day':'Friday'},{'Day':'Saturday'}];
          //   // var n=0;
          //  // $.each(data, function(i, item1){
          //   if(jQuery.inArray(item1.Day,d) == -1)
          //   {
          //     html +='<tr>';
          //   html +='<td>'+item1.Day+'<input type="hidden" name="strainerid" value="'+$('#trainerid').val()+'"><input type="hidden" name="sday'+n+'" value="'+item1.Day+'"><input type="hidden" name="memberid" value="'+$('#memberid').val()+'"><input type="hidden" name="memberpackagesid" value="'+$('#packageid').val()+'"></td>';

        
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="06:00" name="600'+n+'" type="checkbox"';
          //   // alert($('#date').val());
          //   if(item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="06:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
          //   }
          //   if(item1.t600=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="07:00" name="700'+n+'" type="checkbox"';
          //   if(item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="07:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
          //   }
          //   if(item1.t700=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+='><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="08:00" name="800'+n+'" type="checkbox"';
          //   if(item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="08:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
          //   }
          //   if(item1.t800=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="09:00" name="900'+n+'" type="checkbox"';
          //   if(item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="09:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
          //   }
          //   if(item1.t900=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="10:00" name="1000'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="10:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1000=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="11:00" name="1100'+n+'" type="checkbox"';
          //   if(item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="11:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1100=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="12:00" name="1200'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="12:00")
          //     {
          //       html+='checked ';
          //       if(item.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1200=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="13:00" name="1300'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="13:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1300=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="1" name="1400'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="14:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1400=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="15:00" name="1500'+n+'" type="checkbox"';
          //   if(item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="15:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1500=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="16:00" name="1600'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="16:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1600=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="17:00" name="1700'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="17:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1700=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="18:00" name="1800'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="18:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1800=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="19:00" name="1900'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="19:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t1900=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="20:00" name="2000'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="20:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
             
          //   }
          //    if(item1.t2000=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="21:00" name="2100'+n+'" type="checkbox"'; 
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="21:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t2100=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="22:00" name="2200'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="22:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t2200=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='<td><label class="customcheck"><input class="cb'+n+'" value="23:00" name="2300'+n+'" type="checkbox"';
          //   if( item1.todate >= $('#date').val())
          //   {

          //     if(item1.hoursfrom=="23:00")
          //     {
          //       html+='checked ';
          //       if(item1.memberid!=$('#memberid').val())
          //       {
          //         html+='disabled';
          //       }
          //     }
              
          //   }
          //   if(item1.t2300=='-1')
          //     {
          //       html+='disabled';
          //     }
          //   html+=' ><span class="checkmark"></span></label></td>';
          //   html +='</tr>';  
          //       $('#assigntrainer').empty();
          //       $('#l1').empty();
          //       // if(item.MemberId!=$('#memberid').val())
          //       {
          //         $('#l1').attr('style','color: green');
          //         $('#l1').append('Assign Schedule');
          //         $('#assigntrainer').append('Save');
          //         $('#form').attr('action','{{URL::route("assignpttomember")}}');
          //       }
          //       n= Number(n)+1;
             
          //     d.push(item1.Day);
          //    }
          //   }

        // }
        // else
        // {
        //   //
        //   // var data=[{'Day':'Sunday'},{'Day':'Monday'},{'Day':'Tuesday'},{'Day':'Wednesday'},{'Day':'Thursday'},{'Day':'Friday'},{'Day':'Saturday'}];
        //   // var n=0;
        //  // $.each(data, function(i, item1){
        //   html +='<tr>';
        //     html +='<td>'+item1.Day+'<input type="hidden" name="strainerid" value="'+$('#trainerid').val()+'"><input type="hidden" name="sday'+n+'" value="'+item1.Day+'"><input type="hidden" name="memberid" value="'+$('#memberid').val()+'"><input type="hidden" name="memberpackagesid" value="'+$('#packageid').val()+'"></td>';

        
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="06:00" name="600'+n+'" type="checkbox"';
        //     // alert($('#date').val());
        //      if(item1.t600=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="07:00" name="700'+n+'" type="checkbox"';
        //      if(item1.t700=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+='><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="08:00" name="800'+n+'" type="checkbox"';
        //      if(item1.t800=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="09:00" name="900'+n+'" type="checkbox"';
        //      if(item1.t900=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="10:00" name="1000'+n+'" type="checkbox"';
        //     if(item1.t1000=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="11:00" name="1100'+n+'" type="checkbox"';
        //      if(item1.t1100=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="12:00" name="1200'+n+'" type="checkbox"';
        //      if(item1.t1200=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="13:00" name="1300'+n+'" type="checkbox"';
        //      if(item1.t1300=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="1" name="1400'+n+'" type="checkbox"';
        //      if(item1.t1400=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="15:00" name="1500'+n+'" type="checkbox"';
        //      if(item1.t1500=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="16:00" name="1600'+n+'" type="checkbox"';
        //      if(item1.t1600=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="17:00" name="1700'+n+'" type="checkbox"';
        //      if(item1.t1700=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="18:00" name="1800'+n+'" type="checkbox"';
        //      if(item1.t1800=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="19:00" name="1900'+n+'" type="checkbox"';
        //      if(item1.t1900=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="20:00" name="2000'+n+'" type="checkbox"';
        //      if(item1.t2000=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="21:00" name="2100'+n+'" type="checkbox"'; 
        //      if(item1.t2100=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="22:00" name="2200'+n+'" type="checkbox"';
        //      if(item1.t2200=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='<td><label class="customcheck"><input class="cb'+n+'" value="23:00" name="2300'+n+'" type="checkbox"';
        //      if(item1.t2300=='-1')
        //       {
        //         html+=' disabled';
        //       }
        //     html+=' ><span class="checkmark"></span></label></td>';
        //     html +='</tr>'; 
        //       $('#assigntrainer').empty();
        //       $('#l1').empty();
        //       // if(item.MemberId!=$('#memberid').val())
        //       {
        //         $('#l1').attr('style','color: green');
        //         $('#l1').append('Assign Schedule');
        //         $('#assigntrainer').append('Save');
        //         $('#form').attr('action','{{URL::route("assignpttomember")}}');
        //       }
        //       n= Number(n)+1;
          // }
          
        });

             $('#grid').append(html); 

          },
          dataType:'json',  
        });
          return false;
        // alert(data1);
      }
        html +='</table>';

          $('#grid').append(html);
        },
        dataType:'json',

      });

    $('#example1').DataTable({
       stateSave: false,
       paging:  true,

       "lengthMenu": [[7, 10, 15, -1], [7, 10, 15, "All"]]
   });

     });
  </script>
<div class="modal fade" id="trainertime" tabindex="-1" role="dialog" aria-labelledby="titleymodalLabel" aria-hidden="true">'

    <form data-toggle="validator" id="form" action="{{URL::route('assignpttomember')}}" role="form" method="POST" class="form-horizontal">
{{csrf_field()}}
    <div class="modal-dialog modal-lg" style="width: auto;">

        <div class="modal-content">
            
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                
                <h4 class="modal-title" id="Label">Trainer Time-Slot</h4>
            
            </div>
            
            <div class="modal-body" style="display:none; text-align:center" id="bagtypemodalprogress">
                
                <img src="./img/progress.gif" alt="Loading..." />
            
            </div>
            
            <div class="modal-body" id="trainermodalcontent"> 

                <div id="trainermodalalert" class="alert alert-danger alert-dismissable" style="display:none">
                    
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    
                    Can Not Assign Trainer.
                
                </div>
                
                  <div class="form-group">
                  <center><h4><label id="l1"> </label></h4><label>From date</label><div class="input-group " style="max-width:180px" >
                    <input type="date" onkeypress="return false" value="" class="form-control" name="fromdate" id="fromdate" required />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                  <label>End date</label>
                <div class="input-group " style="max-width:180px" >
                    <input type="date" onkeypress="return false" value="" class="form-control" name="enddate" id="enddate" required />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div></center>
                </div>
                <script type="text/javascript">
                  $('#fromdate').on('change',function(){
                    // alert('ddd');
                     $.ajax({
                              url:"{{ URL::route('checkfromdate') }}",
                              method:"GET",
                              data:{"_token": "{{ csrf_token() }}","fromdate":$('#fromdate').val(),'memberpackagesid':$('#packageid').val()},

                              success:function(data) {
                                // alert(data);
                                if(data=="invalid")
                                {
                                  swal(" Please Select Valid Date","Error!","error");
                                  // $('#close').trigger('click');
                                  checkfromdate();
                                }
                              },
                              // dataType:'json',

                            });
                  });
                </script>
                <div class="form-group" id="grid" style="overflow: auto;">
                
                </div>
            
            </div>
            
            
            <div class="modal-footer">
                
                <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                
                <button name="assigntrainer" id="assigntrainer" type="button" class="btn btn-primary">Save</button>
            
            </div>
            <script type="text/javascript">
              $('#assigntrainer').on('click',function(){
                // alert($("input[name='pkgtype']:checked").val());
                var countchecked = $('input[type="checkbox"]').filter(function() {
                        return this.checked && !this.disabled;
                    }).length;
                if(countchecked==$("input[name='pkgtype']:checked").val())
                {
                  for(var n=0; n<= 6; n++)
                  {
                    var cn = $('.cb'+n).filter(function() {
                        return this.checked && !this.disabled;
                    }).length;
                    // alert($('.cb'+n+':checked').length);
                    if(cn <= 1)
                    {
                      swal("Successfully Assigned Member to Trainer","Successfully!","success");
                      $('#assigntrainer').attr('type','submit');
                    }
                    else
                    {
                      swal("Can't Check Multiple in a Day","Error!","error");
                      $('#assigntrainer').attr('type','button');
                      return false;
                    }
                  }
                  // $('#assigntrainer').attr('type','submit');
                }
                else
                {
                  swal("Compulsory Check "+ $("input[name='pkgtype']:checked").val()+ " Value","Error!","error");
                  $('#assigntrainer').attr('type','button');
                }

              });
            </script>
        
        </div>
    
    </div>
    
    </form>

</div>
<script type="text/javascript">
    $('#packageid').on('change',function(){
      // alert('dfg');
    checkfromdate();
   });

    function checkfromdate(){
      $.ajax({
     url:"{{ URL::route('ajaxgetjoindate') }}",
      method:"GET",
       data:{"_token": "{{ csrf_token() }}",'memberpackagesid':$('#packageid').val()},

      success:function(data) {
    // alert(data);
   $.each(data,function(i,item){
      $('#fromdate').val(item.joindate);
      $('#date').val(item.joindate);
      $('#date1').val(item.expiredate);
      $('#enddate').val(item.expiredate);
   });
    },
    dataType:'json',

   });
    }
</script>
<script type="text/javascript">
                  $('#view').on('click',function(){
                    // alert('ddd');
                     $.ajax({
                              url:"{{ URL::route('checkfromdate') }}",
                              method:"GET",
                              data:{"_token": "{{ csrf_token() }}","fromdate":$('#date').val(),'memberpackagesid':$('#packageid').val()},

                              success:function(data) {
                                // alert(data);
                                if(data=="invalid")
                                {
                                  swal(" Please Select Valid Date","Error!","error");
                                  $('#close').trigger('click');
                                  checkfromdate();
                                }
                              },
                              // dataType:'json',

                            });
                  });
                </script>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).ready( function (){
  $('#trainerid').trigger('change');
});
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#view').click(function(){
      let trainerid = $('#trainerid').val();
      let memberid = $('#memberid').val();
      let packageid = $('#packageid').val();

      if(trainerid != '' && memberid != '' && packageid != ''){
        $('#view').attr('type','button');
        $('#view').attr('data-target','#trainertime');
        $('#view').attr('data-toggle','modal');
        
      } else {
        $('#view').attr('type','submit');
        $('#view').attr('data-target','');
        $('#view').attr('data-toggle','');
        $('#trainerid').attr('title', 'This field is required.');
        $('#memberid').attr('title', 'This field is required.');
        $('#packageid').attr('title', 'This field is required.');
        $('#as_form').validate({
        });
      }
    //$(document).find('#trainerid-error').text('This field is required.');

    });
  });
  $(document).on('keypress', '#ptp', function(e){
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
   });
      $('#trainerid').change(function(){
                      var routeid='<?php echo $id; ?>';
                       var trainerid = $('#trainerid').val();
                  
               // $('#sessionreport').css('display','none');
                         $('#memberid').find('option:not(:first)').remove();
                              $.ajax({
                                   url:"{{ url('gettrainermember') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","trainerid":trainerid},
                                  success:function(data) {
                                    // alert(data);
                                      
                                    if(data){
                                     
                                      $.each(data, function(i, item){
                                      
                                       $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.firstname+' '+item.lastname));

                                      });
                                      if(routeid){
                                        $("#memberid option[value="+routeid+"]").attr("selected", "selected");
                                       $("#memberid").trigger('change');
                                      }
                                   
                                    }
                                   // alert(mid);
                                   
                                      

                                    
                                        // $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.username));
                                  },
                                   dataType:'json',

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
</script>
@endpush
