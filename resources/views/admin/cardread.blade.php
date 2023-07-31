@extends('layouts.adminLayout.admin_design')

@push('css')

@endpush
@section('content')

<!-- left column -->
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Get Card Details</h2></section>
 -->          <!-- general form elements -->
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
            <div class="col-md-6"></div>
            <div class="box-header with-border">
              <h3 class="box-title">Get Card Details</h3>
            </div>
            <form action="{{url('cardread')}}" method="post">
              {{ csrf_field() }}
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">
              <button type="button" class="btn bg-orange" id="cardread" style="padding: 30px;" data-toggle="modal" data-target="#enrollmodal" data-backdrop="static" data-keyboard="false">Get Card Read</button>
            </div>
            <!-- /.box-body -->
          </div>
          </form>
      </div>
  </section>
</div>
</div>
</div>
<div class="modal fade" id="enrollmodal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Check Card</h5>
        </div>
        <div class="modal-body">
          <div id="firststage">
            <div class="row">
              <div class="col-md-12">
                <div class="cardcheckform">
                    <input type="hidden" name="cardunique" id="cardunique">
                    <label>Scan card to verify</label>
                    <input type="text" name="cardno" id="cardno" style="height: 0;width: 0;"><br/>
                    <span id="scanning mt-3"><button class="btn btn-danger" style="margin-top: 5px;margin-bottom: 10px;
                    ">Scanning...</button></span><br/>
                    <span style="color: red;">Please do not click anywhere on screen</span><br/>
                    <center><h3><span id="card_exist" style="display: none; color: red;">Card is not assigned</span></h3></center>
                    <div class="row" style="display: none;" id="card_detail">
                      <center>
                        <label>Card Detail</label>
                        <div class="col-md-12">
                          <span><img id="img_card" src="" style="height: 100px;width: 100px;" alt="User Image"></span>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px;">
                          <center><h3><span id="fullname_card"></span></h3></center>
                        </div>
                      </center>
                    </div>
                    <div class="row">
                      <div class="col-md-12" style="margin-top: 10px;">
                        <span style="color: red;display: none;" id="card_err">Card is already in device. Please change  other card.</span>
                      </div>
                    </div>
                    
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="{{ url('cardread') }}" class="btn btn-danger">Close</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')

<script type="text/javascript">
$(document).ready(function(){

  $('#cardread').click(function(){
    $('#enrollmodal').on('shown.bs.modal', function() {
      $('#cardno').trigger('focus');
    });
  });

   $('#cardno').change(function(){
      let cardno = $(this).val();
      $('#card_err').hide();
      if(cardno){
        $('#cardunique').val(cardno);
        $.ajax({
          type : 'POST',
          url : '{{ route('cardexist') }}',
          data : {cardno:cardno, _token:'{{ csrf_token() }}'},
          success : function(data){
            if(data == 201){
              $('#cardno').val('');
              $('#card_err').hide();
              $('#card_detail').hide();
              $('#card_exist').show();
            }else{
              $('#card_exist').hide();
              $('#cardno').val('');
              $('#cardno').focus();
              $('#card_err').show();
              $('#card_detail').show();
              $('#fullname_card').text(data[0]);
              if(data[1] == null){
                data[1] = 'default.png';  
              }
              $('#img_card').attr('src', '{{ asset('files/') }}'+'/'+data[1]);
              $('#firststage_next').hide();
            }
          }
        });
      }else{

      }
    });



});
</script>
@endpush