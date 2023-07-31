@extends('layouts.adminLayout.admin_design')
@section('content')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
@endpush
<style type="text/css">
    .content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
  }

.whitetext{
  color: white !important;
}
.active1{
  background-color: gray!important;
}
  
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
td{

  padding-top: 20px !important;
  padding-bottom: 20px !important;
  padding-right: 20px;
  padding-left: 20px;
   padding: 5px;
  border-left:15px solid white;
  border-right:15px solid white;
    border-bottom: 20px solid white;
  border-color:white !important;
  /*width: 20% !important;*/
    height: 5% !important;
  width: 20% !important;
  min-width: 50px !important;
    min-height: 5px !important;
  text-align: center!important;
  word-wrap:break-word !important;
  
    
}
.available{

}
.btn{
border-left:15px solid white;
  border-right:15px solid white;
    border-bottom: 30px solid white;
    border-top: 5px solid white;
  border-color:white !important;
}
.card-container {
  cursor: pointer;
  height: 110px;
  perspective: 500;
  position: relative;
  width: 50% !important;

}
.card {
  height: 100%;
  position: absolute;
  transform-style: preserve-3d;
  transition: all 0.5s ease-in-out;
  width: 200%;
  padding: 0px;
}
.card:hover {
  transform: rotateY(180deg);
}
.card .side {
  backface-visibility: hidden;
  border-radius: 0px;
  height: 100%;
  position: absolute;
  overflow: hidden;
  width: 100%;

}
.card .back {
  background: #eaeaed;
  color: #0087cc;
  line-height: 150px;
  text-align: center;
  transform: rotateY(180deg);
}
.available{
  border-radius: 6px;
}


</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
     </section>
      <section class="content">
         @if ($message = Session::get('message'))
<div class="alert alert-success alert-block" id="#success-alert">
  <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong class="whitetext">{{ $message }}</strong>
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
      <!-- Info boxes -->
       <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="box box-info">
               <div class="box-header with-border">
                    <h3 class="box-title">Assign Access Cards</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <form action="{{url('atacardassigntomember')}}" method="post">
                      {{csrf_field()}}
                      <div class="col-lg-5">
                        <div class="form-group" style="width: 100% !important">
                          <label>Select User</label>
                          <br>
                           <select class="select2 form-control" data-placeholder="Select a User"id="userid" required="" name="userid">
                              <option value="" selected="" disabled="">Select a User</option>
                            @foreach($users as $user)
                            <option value="{{$user->userid}}">{{$user->username}} </option>
                            @endforeach
                           </select>
                         </div>
                    </div>
                    
                    <div class="col-lg-5">
                        <div class="form-group">
                          <label>Valid UpTo</label>
                           <input type="date" name="returndate" class="form-control" required="" min="<?php echo date('Y-m-d');?>">
                      </div>
                      <input type="hidden" name="finalbeltno" id="finalbeltno" value="">
                      <input type="hidden" name="finalrfidno" id="finalrfidno" value="">
                  </div>
<!--                      beltno
returndate
userid
rfidno -->

                      <div class="cards">
                        
                  <table class="table" cellspacing="10" cellpadding="20">
                            <thead>
                            <tr>
                            <th colspan="7" style="text-align: center;"></th>
                            </tr>
                            </thead>
                            <tbody id="squrebox">
                           <tr>
                        
                              @if(count($cards)>0)
                            
                              @foreach($cards as $key=>$card)

                              @if($key%5 == 0)
                              <br>
                          
                              @endif
       
       
                          <td class="btn {{$card->beltstatus == 'free' ? 'available':'viewdata'}} " @if($card->beltstatus == 'free') style="background-color:#48f348bd;color:hover #F34848;" @else style="background-color:#ff6347d1" @endif>{{$card->beltno}}
                        <input type="hidden" name="beltno" class="beltno" value="{{$card->beltno}}"><input type="hidden" name="rfidno" class="rfidno" value="{{$card->rfidno1}}"></td>
                
                              
                              @endforeach
                              </tr>
                              @endif
                              
                            </tbody>
                        </table>
                        
                        
                      </div>
                      <center>
                      <button type="submit" class="btn bg-green">Assign</button>
                      </center>
                    </form>
                  </div>
              </div>
            
        </div>
       </div>
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>View AccessCard Details</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="returnform" method="post" action="{{url('returnuserbelt')}}">
                  {{csrf_field()}}
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Access Card</label>
                    <input type="text" class="form-control" name="userbeltno" id="userbeltno"readonly="" value="">
                  </div>
                  <div class="form-group">
                    <label for="message-text" class="col-form-label">Username</label>
                    <input type="text" class="form-control" id="username"readonly="" value="">
                     <input type="hidden" name="beltuserid" class="form-control" id="beltuserid"readonly="" value="">
                    
                  </div>
                </form>
            </div>

            <div class="modal-footer">
             
              <button type="button" class="btn bg-green" id="return">Return</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
    
<script type="text/javascript">
  $(document).ready(
function()
    {
        $(".available").click(
            function(event)
        {

          $('#squrebox tr>td').removeClass("bg-green");
          $('#squrebox tr>td').removeClass("active");
            $(this).addClass("active");
            $(this).addClass("bg-green");
            var beltno=$(this).find('.beltno').val();
             // alert(beltno);
            var rfidno=$(this).find('.rfidno').val();
            // alert(rfidno);
            $(document).find('#finalbeltno').val(beltno);
             $(document).find('#finalrfidno').val(rfidno);


             
        }
        );
    });
</script>
<script type="text/javascript">
  $('.viewdata').on('click',function(){

    var beltno=$(this).find('.beltno').val();
      // alert(beltno);
     var _token = $('input[name="_token"]').val();
       $.ajax({
                  url:"{{ url('viewbeltdataajax') }}",
                  method:"POST",
                  data:{beltno:beltno, _token:_token},
                  success:function(result)
                  {
                    var data=result;
                    if(data){
                      // alert(data);
                      $('#userbeltno').val('');
                      $('#username').val('');
                      $('#beltuserid').val('');
                     $('#userbeltno').val(data.userbeltno);
                     $('#username').val(data.username);
                     $('#beltuserid').val(data.userid);
                    $('#exampleModal').modal('show');
                    }
                  },
                   dataType:"json"
                 })
  });
  $('#return').on('click',function(){
    $('#returnform').trigger('submit');
    // location.reload();
  });

</script>
<script type="text/javascript">
  $(document).ready (function(){
                $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(1000);
                });   
 });
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
</script>
@endsection