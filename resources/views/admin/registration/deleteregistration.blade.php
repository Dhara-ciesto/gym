 @extends('layouts.adminLayout.admin_design')
@section('content')

  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
      <div class="row">
         @if ($message = Session::get('message'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
            <?php $permission = unserialize(session()->get('permission')); ?>
                <h3 class="box-title">Deleted Registration</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped dataTable">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Mobile No</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Package</th>
                </tr>
                </thead>
                <tbody >
                   @foreach($registration as $registration) 
                <tr>
                  <td>{{ucwords($registration->firstname)}} &nbsp; {{ucwords($registration->lastname)}}</td>
                  <td>{{$registration->phone_no}}</td>
                  <td>{{ date('d-m-Y', strtotime($registration->starting_date))}}</td>
                  <td>{{ date('d-m-Y', strtotime($registration->ending_date))}}</td>
                  <td>{{$registration->regpaymentname}}</td>
                </tr>
                
                @endforeach 
                
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
    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="modal-delete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Warning</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="" id="delete_id_user">
                <h3>Are you sure to want ot deactive?</h3>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-aqua" id="delete_confirm">Submit</button>
            <button type="button" class="btn bgcancel" data-dismiss="modal" >Close</button>
          </div>
        </form>
        </div>
      </div>
  </div>

  <div class="modal fade" id="modal-fetchlog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Fetch Log</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <form method="" action="" id="form_fetchlog">
                    <input type="hidden" id="emp_id_fetch">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>From<span style="color: red;">*</span></label>
                      <input type="date" onkeypress="return false" class="form-control" id="start_date_log" name="inquirydate" required="" placeholder="Inquiry Date">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>To<span style="color: red;">*</span></label>
                      <input type="date" onkeypress="return false" class="form-control" id="end_date_log" name="inquirydate" required="" placeholder="Inquiry Date">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <table class="table" id="fetch_log">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PunchDate</th>
                                <th >PunchTime</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                          
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bgcancel" data-dismiss="modal" id="fetch_close">Close</button>
                <button type="button" class="btn bg-aqua" id="fetchlog_submit">Submit</button>
              </div>
            </form>
            </div>
          </div>
  </div>

  <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enroll in Device</h4>
              </div>
              <div class="modal-body">
                <form method="post" action="{{ route('setexpiryofregister') }}">
                  <div class="form-group">
                    <input type="hidden" name="register_id" id="register_id">
                    <input type="hidden" name="lastname" id="lastname">
                    <input type="hidden" name="firstname" id="firstname">
                    <label>Name :     <span id="name" style="margin-left: 10px;"></span></label>
                  </div>
                  <div class="form-group">
                    <label>Start Date</label>
                   <div id="start_date">
                   </div>
                  </div>
                  <div class="form-group">
                    <label>End Date</label>
                    <div id="end_date">
                    </div>
                  </div>
                  <div class="form-group">
                    <div id="bio_message" style="display: none;">
                      <div class="text-danger">
                        <span>Something wrong with device.Please check your device.</span>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-aqua" id="expiry_submit">save</button>
                <button type="button" class="btn bgcancel" data-dismiss="modal">Close</button>
              </div>
            </form>
            </div>

          </div> 
  </div>

  <div class="modal fade" id="modal-expiryfound">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Warning</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="" id="delete_id">
                <h3>Expiry is already set.</h3>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bgcancel" data-dismiss="modal" >Close</button>
          </div>
        </form>
        </div>
      </div>
  </div>

  <div class="modal fade" id="modal-extend">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Extend Trial Date</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">

                <div class="col-md-8">
                  <div class="form-group">
                    <input type="hidden" name="" id="deviceusersid">
                    <label>Select Admin<span style="color: red;">*</span></label>
                    <select name="admin" class="form-control" id="admin_id">
                      <option value="">--Select--</option>
                      @if(!empty($admin))
                        @foreach($admin as $admin_data)
                          <option value="{{ $admin_data->employeeid}}">{{ ucfirst($admin_data->first_name) }} {{ ucfirst($admin_data->last_name) }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Extend Date<span style="color: red;">*</span></label>
                    <input type="date" name="extend_date" id="extend_date" class="form-control">
                  </div>

                  <div class="form-group" id="otp_box" style="display: none;">
                    <label>OTP<span style="color:red;">*</span></label>
                    <input type="text" name="otp_extend" id="otp_value" class="form-control number" >
                    <span id="otp_error" style="color: red;display: none;">OTP is incorrect</span>
                  </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-success" id="otp_btn"><span id="btn_text">Generate OTP</span></a>
            <a href="{{ url('registrationdetails')}}" class="btn btn-danger" >Close</a>
          </div>
        </form>
        </div>
      </div>
  </div>

  

 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

<script type="text/javascript">
                    function device(mid){

                      var d = $('#device').val(mid);
                      //alert($('#device').val());

                    }
</script>
<!-- ./wrapper -->
<!-- SlimScroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<!-- AdminLTE for demo purposes -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });

  $('#example1').DataTable({
       stateSave: false,
        paging:  true,
         "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
   });

</script>

@endsection
@push('script')
<script type="text/javascript">
  function device(fname,lname,start_date,end_date,rid,name){

      //alert('gdfgdfg');
      //let id = $(this).data(rid);
      //let name = $(this).data(name);
      //let start_date = $(this).data(start_date);
      //let end_date = $(this).data(end_date);
      //let firstname = $(this).data(fname);
      //let lastname = $(this).data(lname);

      //console.log(rid);
      //console.log(name);
      //console.log(start_date);
      //console.log(end_date);
      //console.log(fname);
      //console.log(lname);
      var newendDate = new Date(end_date);
      newendDate.setDate(newendDate.getDate());
      //var newendDate = date.toString('dd-MM-yy');

      let d = ''+newendDate.getDate();
      let m = ''+newendDate.getMonth();
      let y = newendDate.getFullYear();

      if(m.length < 2) m = '0'+m;
      if(d.length < 2) d = '0'+d;

      let enddate = d +'-'+ m +'-'+ y;
     

      $('#modal-default #register_id').val(rid);
      $('#modal-default #name').text(name);
      $('#modal-default #firstname').text(fname);
      $('#modal-default #firstname').val(fname);
      $('#modal-default #lastname').text(lname);
      $('#modal-default #lastname').val(lname);
      $('#modal-default #name').text(name);
      $('#modal-default #start_date').html('<input onkeypress="return false" type="date" name="start_date" class="form-control" id="set_start_date" value="'+start_date+'" min="<?php echo date('Y-m-d');?>">');
      $('#modal-default #end_date').html('<input onkeypress="return false" type="text" name="end_date" class="form-control" id="set_end_date" value="'+enddate+'" disabled>');
  }

  function extend_date(deviceusersid, expirydate){

    $('#modal-extend #deviceusersid').val(deviceusersid);
    $('#modal-extend #extend_date').attr('min', expirydate);
    $('#modal-extend #extend_date').val(expirydate);

  }

  $(document).on('change', '#set_start_date', function(){
    let start_date = $(this).val();
    let get_start_date = new Date(start_date);
    let get_day = get_start_date.getDay();
    let end_date = new Date(start_date);
    if(get_day == 5 || get_day == 6){

      end_date.setDate(end_date.getDate() + parseInt(3));
      let d = ''+end_date.getDate();
      let m = ''+(end_date.getMonth() + Number(1));
      let y = end_date.getFullYear();
      
      if(m.length < 2) m = '0'+m;
      if(d.length < 2) d = '0'+d;

      end_date_replace = d + '-' + m + '-' + y;

      $('#set_end_date').val(end_date_replace);

    } else {

      end_date.setDate(end_date.getDate() + parseInt(2));
      let d = ''+end_date.getDate();
      let m = ''+(end_date.getMonth() + Number(1));
      let y = end_date.getFullYear();

      if(m.length < 2) m = '0'+m;
      if(d.length < 2) d = '0'+d;

      end_date_replace = d + '-' + m + '-' + y;
      $('#set_end_date').val(end_date_replace);

    }
    //alert(start_date.getDay());
  });
  
   
    
  $(document).on('click', '#expiry_submit', function(){
    let id = $('#register_id').val();
    let start_date = $(document).find('#set_start_date').val();
    //alert(start_date);
    let end_date = $('#end_date').val();
    let firstname = $('#firstname').val();
    let lastname = $('#lastname').val();

    if(start_date){
      $.ajax({
        type : 'post',
        url : '{{ route("setexpiryofregister") }}',
        data : {id:id,start_date:start_date, end_date:end_date, firstname:firstname, lastname:lastname, _token:'{{ csrf_token() }}' },
        success: function(data){
          if(data == 203){
            alert('Now you can enroll user into device.');
            window.location.href = '';
            $('#bio_message').hide();
            $('#modal-default').modal('hide');
          } else if(data == 201 || data == 202) {
            $('#bio_message').show();
          }
        },error:function(){
          alert('error');
        }
      });
    } else {
      alert('Please select start date');
    }

  });

  function fetch(id){
    $('#modal-fetchlog #emp_id_fetch').val(id);
  }

  $(document).on('click','#otp_btn', function(){


    let admin_id = $('#admin_id').val();
    if(admin_id.length != 0){
      $('#otp_box').css('display', 'block');
      $('#btn_text').text('Submit');
      $('#otp_btn').attr('id', 'otp_submit');
      $.ajax({
        type : 'POST',
        url : '{{ route('sendotptoadmin') }}',
        data : {admin_id:admin_id, _token:'{{ csrf_token() }}'},
        success : function(data){
          if(data == true){
            alert('OTP is send');
          }
        }
      });
    } else {
      $(document).find('#admin_id').css('border-color', 'red');
    }

    //ajax for send OTP to selected admin
    
   
  });

  $(document).on('change', '#admin_id', function(){
    $(document).find('#admin_id').removeAttr('style');
  });

  $(document).on('click', '#otp_submit', function(){
    let otp = $('#otp_value').val();
    let admin_id = $('#admin_id').val();
    let extend_date = $('#extend_date').val();
    let deviceusersid = $('#deviceusersid').val();

    if(otp && admin_id && extend_date){
      $.ajax({
        type : 'post',
        url : '{{ route('setextendedregdate') }}',
        data : {otp:otp,admin_id:admin_id,extend_date:extend_date,deviceusersid:deviceusersid,_token:'{{ csrf_token() }}'},
        success : function(data){
          if(data == 'opt wrong'){
            $('#otp_error').css('display', 'block');
          }
          if(data == 'date is extended'){
            alert('Date is extended successfully');
            window.location.href = '';
          }
          if(data == 'device problem'){
            alert('There is something wrong with device');
            window.location.href = '';
          }
        }
      });
    } else {
      alert('Please fill required data.');
    }
  });

  $('#fetchlog_submit').on('click', function(e){
    e.preventDefault();
    let start_date = $('#start_date_log').val(); 
    let end_date = $('#end_date_log').val();
    let register_id = $('#emp_id_fetch').val();
   
     if(start_date && end_date){
      $('#tbody').empty();
      $.ajax({
        type : 'get',
        url : '{{ url("getallrecord") }}',
        data : {start_date:start_date, end_date:end_date,register_id:register_id, _token:'{{ csrf_token() }}' },
        success : function(data){
          $('#tbody').append(data);
        }

      });
    } else {
      alert('please select date');
    }
  });

   $(document).on('click', '#fetch_close', function(){
    window.location.href = '';
  });

  function deactivate(id){
    
    $('#modal-delete #delete_id_user').val(id);
  }

  $(document).on('click', '#delete_confirm',function(){
    var delete_id = $('#delete_id_user').val();
    $.ajax({
        type : 'post',
        url : '{{ route("deleteregistration") }}',
        data : {delete_id : delete_id,reg:1,_token:'{{ csrf_token() }}' },
        success : function(data){
         if(data == 203){
          alert('Registration is Deactivated');
          window.location.href = '';
         } else {
          alert('There is something wrong.');
         }
        }

      });
  });
  $('#set_start_date').datepicker({
    minDate: 0,
  });

 

</script>
@endpush
