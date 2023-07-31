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
        <!-- <script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script> -->
        <!-- <script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script> -->
        <!-- <script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script> -->
        <!-- <script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script> -->
        <style type="text/css"></style>
        <div class="content-wrapper">
          <section class="content-header">
            <h2>View Expense</h2>
          </section>
         
  @if ($message = Session::get('success'))

            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{{ $message }}</strong>
            </div>
@endif 

          
                
                <section class="content">
                  <div class="row">
                    <div class="col-lg-12">
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
                    <form action="{{url('viewexpenses')}}" method="post">
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
              <td><input type="date" name="fdate" class="form-control" id="fdate" value="{{$query['fdate']}}"></td>
              <td><input type="date" name="tdate" class="form-control" id="tdate" value="{{$query['tdate']}}"></td>
              <td><select name="mode" class="form-control " id="mode" data-placeholder="Select a Mode" >
                <option value="" selected="" disabled="">Select a Mode</option>
                  @foreach($modes as $mode)
                <option value="{{$mode->paymenttype}}" @if(isset($query['mode'])) {{$query['mode'] == $mode->paymenttype ? 'selected':''}} @endif>
                  {{$mode->paymenttype}}
                   </option>
                  @endforeach
               </select></td>
              <td><select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
                <option value="" selected="" disabled="">Select a Username</option>
                @foreach($users as $user)

                <option value="{{$user->userid}}"  @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>
                  
                  {{ $user->username }} 
              
              
                   </option>
                  @endforeach
               </select></td>
                  <td><input type="text" name="amount" class="form-control"value="{{$query['amount']}}"></td>
              
              
              </tr>
              <tr>
                
                <td><input type="text" name="keyword" placeholder="Search Keyword" class="form-control" value="{{$query['keyword']}}"></td>
                <td style="text-align: left" colspan="4"><button type="submit" name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('viewexpenses') }}" class="btn bg-red">Clear</a></td>
                
              </tr>
              

              </tbody>
              </table>

              </div>
            </form>
                  </div>  
            </div>
          
                      <div class="box">
                        <div class="box-header">
                         
                          <a  id="getexcel" style="float: right; margin-right: 15px;" class="btn bg-orange">
                            <i  class="fa fa-file-excel-o"></i> Get Excel
                          </a>
                           <a href="{{ url('addexpenses') }}" class="btn add-new bg-primary ">
                            <i class="fa fa-plus"></i>Add New
                          </a>
<!--                           <h3 class="box-title">All Expense</h3>
 -->                        </div>
                         @foreach($dataall as $g)

                          <input type="hidden" name="dataall[]" value="{{$g}}">
                        @endforeach
                        <!-- /.box-header -->
                        <div class="box-body" style="overflow: scroll;">
                          <table id="expensepayment" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>User</th>
                                <th>Category</th>
                                <th>Company</th>
                                <th>Amount</th>
                                <th>BillNo</th>
                                <th>Mode</th>
                                <th>GST</th>
                                <th>Date</th>
                                {{-- <th>Time</th> --}}
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                @foreach($expensepayment as $categoryname)
                
                              <tr>
                                <td>{{$categoryname->username}}</td>
                                <td>{{$categoryname->categoryname}}</td>
                                <td>{{$categoryname->company}}</td>
                                <td>{{$categoryname->amount}}</td>
                                <td>{{$categoryname->billno}}</td>
                                <td>{{$categoryname->paymenttype}}</td>
                                <td>{{$categoryname->gstamount}}</td>
                                <td>{{date('d-m-Y', strtotime($categoryname->dte))}}</td>
                                <td>
                                  <a href="{{ url('editExpenseitems/'.$categoryname->expensepaymentid) }}"class="edit" title="Edit">
                                    <i class="fa fa-edit"></i>
                                  </a>
                                </tr>
              @endforeach
                
                              </tbody>
                            </table>
                            <center>
                            {{ $expensepayment->links() }}
                            </center>
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
                  <script>
  $(function () {
    $('#expensepayment23').DataTable()
    $('#expensepayment').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
  <!--                 <script type="text/javascript">
  $('#expensepayment23').DataTable({
       stateSave: false,
       paging:  true,
       "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
   });
</script> -->
             
       
          </div>
            
           <script type="text/javascript">
            $('#getexcel').on('click',function(){
          if ($('#fdate').val() != '' && $('#fdate').val() != null) { 
               var fdate=$('#fdate').val();
                }
                else{
                 var fdate ='empty'; 
                }
/**************************************************************************************/
             if ($('#tdate').val() != '' && $('#tdate').val() != null) { 
               var tdate=$('#tdate').val();
                }
                else{
                 var tdate ='empty'; 
                }
        
              var amount=<?php echo (!empty($query['amount']) ? $query['amount'] :  "'empty'"); ?>;
              var user=<?php echo (!empty($query['username']) ? $query['username'] :  "'empty'"); ?>;
              var keyword=<?php if(!empty($query['keyword'])){
                                echo "'".$query['keyword']."'";
                              } else{
                                echo "'empty'";
                              } ?>;

                             
              var mode=<?php if(!empty($query['mode'])){
                                echo "'".$query['mode']."'";
                              } else{
                                echo "'empty'";
                              } ?>;
         
                  $.ajax({
                    url:"{{ url('expensegstreport/excel') }}",
                    method:"POST",
                    data:{user:user,fdate:fdate,tdate:tdate,amount:amount,keyword:keyword,mode:mode,"_token": "{{ csrf_token() }}"},
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

<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
  
  })
</script>
@endsection

 