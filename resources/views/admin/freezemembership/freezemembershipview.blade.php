@extends('layouts.adminLayout.admin_design') @section('content')
<style type="text/css">
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
<!--         <h2>Freezed Membership</h2></section>
 -->    <div class="container-fluid">
        @if ($message = Session::get('message'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <div class="table-wrapper">
            <div class="table-title">

                <div class="box-header">

                </div>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
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


                    <form action="{{url('viewfreezemembeship')}}" method="post">
                      {{csrf_field()}}
              <div class="table-responsive">
                <table class="table no-margin">
                <thead>
                <tr>
                 
                  <th>Username</th>
                
                  
                </tr>
              </thead>
              <tbody>
          
              <tr>
               <div class="col-xs-4">
              <td><select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
                <option value="" selected="" disabled="">Select a Username</option>
                @foreach($users as $user)

                <option value="{{$user->userid}}"  @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>
                  
                  {{ $user->username }} 
              
              
                   </option>
                  @endforeach
               </select></td>
                 </div> 
              
              </tr>
              <tr>
                
            
                <td style="text-align: left" colspan="4"><button type="submit" name="search" class="btn bg-green"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('viewfreezemembeship') }}" class="btn bg-red">Clear</a></td>
                
              </tr>
              

              </tbody>
              </table>

              </div>
            </form>
                              {{ csrf_field() }}

                  </div>  
            </div>
          

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Freezed Membership</h3>
                                    <div class="" style="float: right;"><a href="{{ url('freezemembership') }}" class="btn btn-primary bg-orange" title="Freeze Membership"><i class="fa fa-plus"></i> Freeze Membership</a></div>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body" style="overflow: scroll;">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Member Name</th>
                                                <th>Freeze Date</th>
                                                <th>Freeze Amount</th>
                                                <th>Unfreeeze</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($freezemembership_data))
                                            @foreach($freezemembership_data as $freezemembership)
                                            <tr>
                                                <td> {{ !empty($freezemembership->firstname) ? ucfirst($freezemembership->firstname) : '' }} {{ !empty($freezemembership->lastname) ? ucfirst($freezemembership->lastname) : '' }}</td>
                                                <td> {{ !empty($freezemembership->freezememberhipstartdate) ? date('d-m-Y', strtotime($freezemembership->freezememberhipstartdate)) : '' }}</td>
                                                <td> {{ !empty($freezemembership->freezeamount) ? ucfirst($freezemembership->freezeamount) : 0 }}</td>
                                                <td>
                           @if(date('Y-m-d')  >= $freezemembership->freezememberhipstartdate)
                                                      <a onclick="unfreeze({{$freezemembership->freezemembershipid}})" class="btn btn-success" data-toggle="modal" data-target="#unfreeze" >Unfreeze</a>
                                                   @else
                                                       <a class="btn btn-success" disabled="">Unfreeze</a>
                                                   @endif

                                                </td>

                                            </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4"><center>No Freezemembership Found</center></td>
                                                </tr>
                                            @endif
                                        </tbody>

                                    </table>
                                 <div class="datarender" style="text-align: center">
                      
                      @if(isset($query)) 
                      @else 
                        {{ $gst->links() }}
                      @endif  
                     </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>

                <div id="unfreeze" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Unfreeze Membership</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to want to unfreeze membership?</p>
                        <input type="hidden" id="unfreezeid" name="unfreezeid" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="unfreeze_btn">Unfreeze</button>
                        <button type="button" class="btn btn-warning" id="processing" style="display: none;">Processing...</button>
                        <button type="button" class="btn btn-" id="notset" style="display: none;">Not Unfreeze</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

                <!-- page script -->
                <script>
                    $(function() {
                        $('#example1').DataTable()
                        $('#example2').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': false,
                            'ordering': true,
                            'info': true,
                            'autoWidth': false
                        })
                    })
                </script>

            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    function unfreeze(id){
        $('#unfreeze #unfreezeid').val(id);
        //$('#unfreeze #unfreezeid').text(id);
    }

    $(document).ready(function(){
        $('#unfreeze_btn').click(function(){
            $('#processing').show();
            $('#unfreeze_btn').hide();

            let freezeid = $('#unfreezeid').val();

            $.ajax({

                type: 'POST',
                url : '{{ route('unfreezemembership') }}',
                data : {freezeid:freezeid, _token:"{{csrf_token()}}" },
                success : function(data){
                    
                    if(data == 0){
                        alert("membership is unfreezed");
                        window.location.href = '';
                    }else{

                        alert('There is some problem occure in device');  
                        window.location.href = '';

                       /* $('#processing').hide();
                        $('#notset').show();*/
                    }
                }




            });
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
@endpush