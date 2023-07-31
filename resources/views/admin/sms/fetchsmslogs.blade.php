@extends('layouts.adminLayout.admin_design')
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
  background-color: #A1F3CD;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #1AC47A;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #00B968;
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
  background-color: #A1F3CD;
  color: #000;
}
</style>
@endpush
@section('content')

<!-- left column -->
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Fetch SMS Logs</h2></section>
 -->
         <section class="content">
          
           <!--    @if ($errors->any())
            <div class="alert alert-danger">
               <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif -->


          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Email/SMS Logs</h3>
            </div>

          
            <!-- /.box-header -->
            <div class="box-body"> 
              <div class="col-lg-12">
              
                  <div class="row">
                      <form action="{{url('fetchsmslogs')}}" method="post">
                        {{ csrf_field() }}
                      <div class="col-lg-6 col-lg-offset-2">
                          <select name="logs" id="messages"  class="form-control">
                            <option selected disabled="">Please choose an option</option>
                            <option value="sms" @if($logs == "sms") selected @endif>Fetch SMS Logs</option>
                            <option value="email" @if($logs == "email") selected @endif>Fetch Email Logs</option>
                          </select>
                      </div>

                      <div class="col-lg-2">
                        <button type="submit" class="btn bg-green btn-block">Fetch</button>
                      </div>

                    </form>
                  </div>
              
            </div>
      </div>
    </div>
    


         <div class="table-wrapper">
    <div class="table-title">

   <div class="box-header">
       
    </div>

      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
             
              
             
<!--                <h3 class="box-title">All Logs</h3>
 -->            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <div class="table table-responsive">
              <table id="example1" class="table table-bordered">
                 <thead>
                <tr>
                  <tr>
                    <th>Date</th>
                    @if($logs == 'sms')<th>Status</th>@endif 
                    
                      <th>Mobileno</th>
               
                      <th>Email-Id</th>
                   
                     @if($logs == 'sms')<th>SMS</th>@endif
                     @if($logs == 'email')<th>Email</th>@endif             
                    <!-- <th>Actions</th> -->
                </tr>
                </tr>
                </thead>
                <tbody>
               @if($alllogs)
                @if($logs == 'sms')
                  @foreach($alllogs as $slogs)
                  <?php $string = $slogs->smsrequestid; $int = substr($string,12,3); ?>
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($slogs->created_at)) }}</td>
                        <td>@if($int)success @else unsuccessfully @endif</td>
                        <td>{{$slogs->mobileno}}</td>
                        <td> {{$slogs->smsmsg}}</td>
                    </tr>
                  @endforeach
                @else
                   @foreach($alllogs as $elogs)
                      <tr>
                          <td>{{ date('d-m-Y', strtotime($elogs->created_at)) }}</td>
                           <td> {{$elogs->mobileno}}</td>
                          <td> {{$elogs->emailto}}</td>
                          <td> {{$elogs->message}}</td>
                      </tr>
                   @endforeach
                @endif
              @endif
                </tbody>
            
              </table>
              </div>
              @if($alllogs)

              {{$alllogs->links()}}
              @endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

<!-- page script -->
</div>
</div>
          <!-- general form elements -->
           
</div>
@endsection

@push('script')
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<script>
  $('#example1').DataTable({
       stateSave: false,
       paging:  false,
       lengthMenu:false
   });
</script>
@endpush