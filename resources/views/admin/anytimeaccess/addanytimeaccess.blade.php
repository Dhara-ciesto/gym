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
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     	
     </section>
      <section class="content">
      <!-- Info boxes -->
     	 <div class="row">
     	 	<div class="col-md-12">
     	 		<div class="row">
     	 			<div class="box box-info">
     	 				 <div class="box-header with-border">
			              <h3 class="box-title">Add Access Cards</h3>

			              <div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                </button>
			                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			              </div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
			            	<form action="{{url('addanytimeaccesscard')}}" method="post">
			            		{{csrf_field()}}
			            		<div class="col-lg-3"></div>
			            		<div class="col-lg-6">
									<div class="form-group">
						               	<label>Access Card</label>
						               		<input type="hidden" name="" id="exist" value="0">
						              	 <input type="text" name="beltno" id="beltno" class="form-control" placeholder="Enter Access Card No/Name" class="span11" required="" maxlength="15" value="{{ old('beltno') }}" /><span id="error_username"></span>
						              	 <!-- @if($errors->has('beltno'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('beltno') }}</strong>
						                    </span>
						                  @endif -->

						                  @if($errors->any())
						                  <span class="help-block">
						                      <strong>{{ implode('', $errors->all(':message')) }}</strong>
						                    </span>
										@endif
										<span id="belt_err" style="color: red; display: none;">Belt name is already exists.</span>
					            	</div>
					            	<div class="form-group">
						               	<label>Validity</label>
						              	 <input type="date" name="validity" id="validity" min="<?php echo date('Y-m-d')?>" class="form-control" onkeypress="return false" placeholder="RFID No" class="span11" required="" value="{{ old('validity') }}" />
						              	 @if($errors->has('validity'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('validity') }}</strong>
						                    </span>
						                  @endif
					            	</div>
					            	<!-- <div class="form-group">
						               	<label>RFID No</label>
						              	 <input type="text" name="rfidno" id="rfidno" class="form-control" maxlength="15" placeholder="RFID No" class="span11" required=""value="{{ old('rfidno') }}" />
						              	 @if($errors->has('rfidno'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('rfidno') }}</strong>
						                    </span>
						                  @endif
					            	</div> -->
					            	<div class="form-group">
						               <center>
						              	<button type="button" class="btn bg-green margin" id="save" data-toggle="modal" data-target="#enrollmodal" disabled="">Save</button>
						              	<a href="{{url('viewanytimeaccesscard')}}" class="btn bg-red ">Cancel</a>
						              	</center>
					            	</div>
					            </div>
					            <div class="col-lg-3"></div>
			            	</form>
			            </div>
			        </div>
     	 			
     	 	</div>
     	 </div>
    </section>
</div>

 <div class="modal fade" id="enrollmodal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enroll Card</h5>
        </div>
        <div class="modal-body">
          <div id="firststage">
            <div class="row">
              <div class="col-md-12">
                <div class="cardcheckform">
                    <input type="hidden" name="cardunique" id="cardunique">
                    <label>Scan card to verify</label>
                    <input type="text" name="cardno" id="cardno" autocomplete="off" style="height: 0;width: 0;"><br/>
                    <span id="scanning mt-3"><button class="btn btn-danger" style="margin-top: 5px;margin-bottom: 10px;
                    ">Scanning...</button></span><br/>
                    <span style="color: red;">Please do not click anywhere on screen</span><br/>
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
                <div class="secondstageform" style="display: none;">
                 
                    <label>Scan a card to enroll</label>
                    <input type="text" name="cardno" id="finalcardno" autocomplete="off" style="height: 0;width: 0;">
                    <div class="row">
                      <div class="col-md-12">
                        <span id="scanning_second"><button class="btn btn-danger">Scanning...</button></span><br/>  
                      </div>
                    </div>
                 
                </div>
                <center><button id="firststage_next" style="display: none;" class="btn btn-success">Next</button></center>
              </div>
            </div>
          </div>
          <div id="secondstage" style="display: none;"></div>
        </div>
        <div class="modal-footer">
          <a href="{{ url('addanytimeaccesscard') }}" class="btn btn-danger">Close</a>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">
	$(document).ready(function(){
		$('#beltno').on('input', function(){
			let beltname = $(this).val();
			let validity_date = $('#validity').val();
			$.ajax({
				type : 'POST',
				url : '{{ route('Checkbeltname') }}',
				data : {beltname:beltname, _token : '{{ csrf_token() }}'},
				success : function(data){
					if(data == 201){
						$('#exist').val(1);
						$('#belt_err').show();
						$('#save').attr('disabled', 'true');
					}else{	
						$('#exist').val(0);
						$('#belt_err').hide();
						if(validity_date){
							$('#save').removeAttr('disabled');
						}else{
							$('#save').attr('disabled', 'true');
						}
					}
				}
			});
		});

		$('#validity').change(function(){
			let validity = $(this).val();
			let exist = $('#exist').val();

			if(validity && exist == 0){
				$('#save').removeAttr('disabled', 'true');
			}
		});

		$('#save').click(function(){
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
              $('#firststage_next').show();
              $('#card_err').hide();
              $('#card_detail').hide();
            }else{
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

    $('#firststage_next').click(function(){
      $('.cardcheckform').hide();
      $('.secondstageform').show();
      $('#finalcardno').focus();
      $(this).hide();
    });

    $('#finalcardno').change(function(){

      let finalcard = $(this).val();
      let beltno = $('#beltno').val();
      let validity_date = $('#validity').val();
      
      if(finalcard && beltno && validity_date){
        let unique_card = $('#cardunique').val();
        if(unique_card == finalcard){
          $.ajax({
            type : 'POST',
            url : '{{ route('enrollanytimeaccesscard') }}',
            data : {beltno:beltno, finalcard:finalcard, validity_date:validity_date, _token : '{{ csrf_token() }}'},
            success : function(data){
              if(data == 201){
                alert('card is enrolled successfully');
                window.location.href = '{{ url('viewanytimeaccesscard') }}';
              }else if(data == 205){
              	alert('Please add device');
                window.location.href = '';
              }else{
                alert('There is some problem occure');
                window.location.href = '';
              }
            }
          });
        }else{
          alert('Do not change card.Try again');
          window.location.href = '';
        }
        
      }else{
        alert('Please select cardno or username');
        window.location.href = '';
      }

    });





	});
</script>

@endsection