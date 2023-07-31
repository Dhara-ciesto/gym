@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" type="text/css" href="../css/style.css">
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Notification Settings</h2></section>
          <!-- general form elements -->
           <section class="content">
 

 
      @if ($message = Session::get('message'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
      </div>
      @endif
      <script>
      $(document).ready(function(){
    $('.alert-success').delay(5000).fadeOut();
      });
  </script>
    <div class="table-wrapper">
    <div class="table-title">

  <div class="box">
    <div class="box-header">
      <!-- <a href="{{ url('addterms') }}" class="btn add-new bg-navy"><i class="fa fa-plus"></i>Add New</a> -->


    <h3 class="box-title">Notification Settings</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     <div class="col-lg-3"></div>
      <div class="col-lg-10 col-lg-offset-1">
       <div class="row">
        @if($urlstatus)
          @if($urlstatus == 'Active')
          <div class="form-group">
              <textarea class="form-control" rows="5" id="turl">{{$url}}</textarea>
          </div>
          
          <div class="row">
            <div class="col-lg-2 col-sm-3 col-xs-3 col-lg-offset-3">
                <button class="btn btn-block bg-orange" id="testurl" value="testurl">Test Url</button>
            </div>
            <div class="col-lg-2 col-sm-3 col-xs-3">
                <button class="btn btn-block bg-orange" id="saveurl" value="saveurl">Save</button>
            </div>
          </div>
          @else
          <div class="row">

            <label class="form-control">SMS Is Deactiveted !! You Can't Send SMS To Any User !</label>

             <div class="mt-2 col-md-12" style="padding: 10px;"></div>

            <div class="col-lg-4 col-lg-offset-3">
                <button class="btn btn-block bg-orange" id="dashboard">Return To Dashboard</button>
            </div>
          </div>
          @endif
          @endif
          </div>
       </div>
      </div>
    </div>

    </div>
  </div>
 </div>
</div>

<script type="text/javascript">

 $(document).ready(function(){
   $('#saveurl').prop('disabled', true);
 }); 

  $('#testurl').click(function()
  {
      $.ajax({
            url : '{{url("urltest")}}',
            type : 'post',
            data : { _token:'{{ csrf_token() }}',testurl:$('#testurl').val(),saveurl:$('#saveurl').val(),turl:$('#turl').val()},
            success : function(data){

              var a = JSON.parse(data.smsrequestid);
              console.log(data.smsrequestid);


               if (a['ErrorCode'] == '000') {
                      alert('sms send successfully');
                      $('#saveurl').prop('disabled', false);

                    }else{
                      alert('Something Wrong ! Sms Not Send')
                    }

              // alert(a);

            },
            dataType : 'json',
    });
  });

   $('#saveurl').click(function(){
      $.ajax({
            url : '{{url("urltestsave")}}',
            type : 'post',
            data : { _token:'{{ csrf_token() }}',saveurl:$('#saveurl').val()},
            success : function(data){
              alert(data);

               window.location.href = '{{url("editsmssettings")}}';
            },
    });
  });

   $('#dashboard').click(function(){

    window.location.href = "/";

   });
</script>

@endsection