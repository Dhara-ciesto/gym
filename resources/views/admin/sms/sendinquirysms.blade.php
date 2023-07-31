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
@push('css')
<style type="text/css">
  .help-block{
    color: red;
  }
  .error{
    color: red;
  }

  .container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 18px;
  margin-top: 20px;
  cursor: pointer;
  font-size: 15px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #F6C968;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #F5B01B;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #F5B01B;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
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
.pointer {
  cursor: pointer;
}
.tagcolor{
  background-color: #3a3938;
  color: #fff;
}
.tagcolor:hover{
  color: #fff;
}
li {
    list-style-type: none;
}
table, th, td {
  padding: 5px;
}
</style>
@endpush


<script type="text/javascript">
   $(document).ready(function(){
    $('#example2').DataTable();
   });
</script>
<!-- left column -->
  <div class="content-wrapper">
   
     
         <section class="content-header"><!-- <h2>Add Notification</h2> --></section>
          <!-- general form elements -->
           <section class="content">
          
           @if ($msg = Session::get('msg'))
<div class="alert alert-success alert-block" id="#success-alert">
 <button type="button" class="close" data-dismiss="alert">×</button>
       <strong class="whitetext">{{ $msg }}</strong>
</div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
   <strong>{{ $message }}</strong>
</div>
@endif 
@if ($errors->any())
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <ul>
     @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
     @endforeach
  </ul>
</div>
@endif

            

            <script type="text/javascript">
              $(".alert-danger").fadeTo(5000, 500).slideUp(500, function(){
              $(".alert-danger").slideUp(500);
                });

              $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
              $(".alert-success").slideUp(500);
                });
           </script>
<form action="{{url('sendinquirysms')}}" method="post" id="inqsmsform">
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title"><b>Send SMS to Inquiry</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> 
              <div class="col-lg-12">
                <div class="row">
                  
                    <input type="hidden" name="sendsms" id="sendsms" value="0">
                    {{ csrf_field() }}
                  <div class="col-lg-3">
                    <div class="">
                    <label>Status</label>
                       <select name="status[]" multiple="multiple" id=""  class="form-control selectpicker" title="Select Member Status" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Member Status">
                          <!-- <option selected value="" disabled="" >--Please choose an option--</option> -->
                          <option @if(isset($query['status'])) @if(in_array('2', $query['status'])) selected="" @endif  @endif value="2">Confirm Inquiry</option>
                          <option @if(isset($query['status'])) @if(in_array('3',  $query['status'])) selected="" @endif @endif  value="3">Conver Into Member</option>
                          <option @if(isset($query['status'])) @if(in_array('1',  $query['status'])) selected="" @endif  @endif  value="1">Pendding Inquiry</option>
                          <option @if(isset($query['status']))  @if(in_array('0',  $query['status']))selected="" @endif @endif  value="0">Closed Inquiry</option>

                      </select>
                  </div>
                </div>



                <div class="col-lg-3">
                    <div class="">
                    <label>Ratting</label>
                       <select name="ratting[]" multiple="multiple" id=""  class="form-control selectpicker" title="Select Member Status" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Member Status">
                          <!-- <option selected value="" disabled="" >--Please choose an option--</option> -->
                          <option @if(isset($query['ratting'])) @if(in_array('superhot',$query['ratting'])) selected="" @endif  @endif value="superhot">SuperHot</option>
                          <option @if(isset($query['ratting'])) @if(in_array('hot', $query['ratting'])) selected="" @endif  @endif value="hot">Hot</option>
                          <option @if(isset($query['ratting'])) @if(in_array('warm', $query['ratting'])) selected="" @endif  @endif value="warm">Warm</option>
                          <option @if(isset($query['ratting'])) @if(in_array('cold', $query['ratting'])) selected="" @endif  @endif value="cold">Cold</option>
                          <option @if(isset($query['ratting'])) @if(in_array('notinterested', $query['ratting'])) selected="" @endif  @endif value="notinterested">Not Intersted</option>

                      </select>
                  </div>
                </div>

                <div class="col-lg-3">
                    <div class="">
                    <label>From date</label>
                      <input type="date" class="form-control" @if(isset($query['fdate'])) value="{{ $query['fdate'] }}" @endif id="fdate" name="fdate">
                  </div>
                </div>

                <div class="col-lg-3">
                    <div class="">
                    <label>To date</label>
                      <input type="date" class="form-control" id="tdate"  @if(isset($query['tdate'])) value="{{ $query['tdate'] }}" @endif name="tdate">
                  </div>
                </div>
              </div>

              <div class="mt-2 col-md-12" style="padding: 10px;"></div>

              <div class="row">

                <div class="col-lg-2">
                    <div class="">
                      <label class="container">Male
                         <input type="checkbox" name="smsmale"  @if(isset($query['smsmale'])) checked  @endif  class="smsgender" id="smsmale" value="male">
                        <span class="checkmark"></span>
                      </label>
                  </div>
                </div>

                <div class="col-lg-2">
                    <div class="">
                      <label class="container">Female
                        <input type="checkbox" name="smsfemale"  @if(isset($query['smsfemale'])) checked  @endif class="smsgender" id="smsfemale" value="female">
                        <span class="checkmark"></span>
                      </label>
                  </div>
                </div>

                <div class="col-lg-2">
                  <input type="hidden" name="onlyserchform" value="0">
                    <button class="btn btn-block bg-green"  id="search">Search</button>
                    <!-- <a class="btn btn-block bg-green" id="clear">Clear</a> -->
                </div>

                <div class="col-lg-2">
                    <a href="{{url('sendinquirysms')}}"class="btn btn-block bg-red" id="clear">Clear</a>
                </div>
                
              </div>
            </div>
          </div>
        </div>

        @if($query = Session::get('query'))
        <input type="hidden" name="q1data" id="q1data" value="1">
        @else
         <input type="hidden" name="q1data" id="q1data" value="0">
        @endif


          <div class="table-wrapper">
            <div class="table-title">
             
                
                <div class="box-header">

                </div>
               
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Inquiry</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <!-- <th>Select</th> -->
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Mobile No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($inquiry)

                                            @foreach($inquiry as $q)
                                            <tr>
                                               <!-- <input type="hidden" name="q1data" id="q1data" value="{{$q->inquiriesid}}"> -->
                                              <!-- <td><input type="checkbox" name="checkval[]" checked="" value="{{ $q->inquiriesid }}"></td> -->
                                              <td>{{ ucwords($q->firstname) }}</td>
                                              <td>{{ ucwords($q->lastname) }}</td>
                                              <td>{{ $q->mobileno }}</td>
                                            </tr>
                                           @endforeach
                                           @endif
                                         
                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
              

                <!-- page script -->
          </div>

        
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Message</h3>
                </div>

                <div class="box-body">

                  <div class="row">
                      <div class="col-lg-10 col-lg-offset-1">
                        <select name="msgid" id="messagestemplatename"  class="form-control selectpicker"title="Select Notification Template" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Notification Template"><option> Please choose an Template </option>
                          @foreach($messagetemp as $m)
                          <option value="{{ $m->messagesid }}">{{ ($m->subject) }}</option>
                          @endforeach
                          </select>
                        
                      </div>
                    </div>

                    <div class="mt-2 col-lg-12" style="padding: 10px;"></div>

                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-10 col-lg-offset-1">
                        <span id="rchars">250</span> Character(s) Remaining
                        <textarea class="form-control" rows="5" name="textareasms" id="textareasms" maxlength="250" style="resize: none;"></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-2 col-lg-12" style="padding: 10px;"></div>

                <div class="row">
                  <div class="col-lg-6 col-lg-offset-1">
                         <table>
                                          <tbody>
                                            <tr>
                                              <td><div class="smstag pointer btn tagcolor">[FirstName]</div></td>
                                              <td><div class="smstag pointer btn tagcolor">[LastName]</div></td>
                                            </tr>
                                          
                                          </tbody>
                                        </table>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group">
                    <div class="mt-2 col-lg-12" style="padding: 10px;"></div>
                      <div class="row">
                        <div class="col-lg-10 col-lg-offset-3">
                          <div class="col-lg-3">
                            <button type="button" class="btn btn-block bg-green" id="sendsmsuser" onclick="submitclick()">send</button>
                            <!-- <button class="btn bg-green btn-block" id="sendsmsuser">Send</button> -->
                          </div>
                          <div class="col-lg-3">
                            <!-- <button class="btn btn-danger btn-block" id="msgclear">Clear</button> -->
                            <a class="btn btn-block bg-red" id="msgclear">Clear</a>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                
            </div>


      </div>
    </div>
  </form>
  </section>
</div>
@endsection
@push('script')
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script type="text/javascript">
  $('#example1').DataTable({
       stateSave: false,
       paging:  true,
       "lengthMenu": [[10, 15, 20,-1], [10, 15, 20,"All"]]
   });
</script>



<script type="text/javascript">

    $(document).ready(function(){
    if($('#q1data').val() == 1){
        $('#search').attr('disabled', true);
       }
  });
  $('#sendsmsuser').click(function(e){
    e.preventDefault();
    $('#sendsms').val(1);
    $('#inqsmsform').submit();
    
  });
   $('#sendsmsuser').prop('disabled', true);
   $('#msgclear').prop('disabled', true);
   // $('#msgclear').hide();

  $('#messagestemplatename').change(function(){ 

    // alert($('#messagestemplatename').val());
      $('#sendsmsuser').prop('disabled', false);
      $('#msgclear').prop('disabled', false);

    $.ajax({
        url : '{{url("getsmsdata")}}',
        typle: 'get',
        data : {_token:'{{ csrf_token() }}',msgid:$('#messagestemplatename').val()},
        success : function(data){
           // alert(data.message);

        $('#textareasms').val('');
       $('#textareasms').val(data.message);
       $('#textareasms').trigger('keyup');
          $('#msgid').val(data.messagesid);
        },
         dataType:'json',
    });
  });

  var maxLength = 250;
        $('#textareasms').keyup(function() {
          var textlen = maxLength - $(this).val().length;
          $('#rchars').text(textlen);
          if ($('#textareasms').val().length > 0) {
             $('#sendsmsuser').prop('disabled', false);
          }else{
            $('#sendsmsuser').prop('disabled', true);
          }
        });

  $('#msgclear').click(function(){

        $('#textareasms').val('');
        $('#sendsmsuser').prop('disabled', true);
    });

  $('#clear').click(function(){
    window.location.reload();
  });



  // $('#textareasms').change(function(){
  //   alert('gk');
  // });



$(".smstag").click(function(){
        var txt = $.trim($(this).text());
        var box = $('textarea');
        box.val(box.val() + txt);

      });
</script> 

search

@endpush