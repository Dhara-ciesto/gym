@extends('layouts.adminLayout.admin_design')
@section('content')
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Add Device</h2></section>
          <!-- general form elements -->
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
 
      @if ($message = Session::get('message'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
      </div>
      @endif 
    <div class="table-wrapper">
    <div class="table-title">

  <div class="box">
    <div class="box-header">
      <!-- <a href="{{ url('addterms') }}" class="btn add-new bg-navy"><i class="fa fa-plus"></i>Add New</a> -->


    <h3 class="box-title">Add Device</h3>
    </div>
       <div class="box-body"> <div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{url('adddevice')}}" method="post" id="device_form">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">

                  <div class="form-group">  
                  <label>Device Ip<span style="color: red;">*</span></label>
                </div>
                <div style="margin-top: -14px;">
                  <div class="form-group col-md-3" style="margin-left: -14px;">
                    <input type="text" class="form-control number" maxlength="3" name="deviceip_1" required="">
                    @if($errors->has('deviceip_1'))
                    <span class="help-block">
                      <strong>{{ $errors->first('deviceip_1') }}</strong>
                    </span>
                    @endif
                  </div>
​
                  <div class="form-group col-md-3">
                    <input type="text" class="form-control number" maxlength="3" name="deviceip_2" required="">
                    @if($errors->has('deviceip_2'))
                    <span class="help-block">
                      <strong>{{ $errors->first('deviceip_2') }}</strong>
                    </span>
                    @endif
                  </div>
​
                  <div class="form-group col-md-3">
                    <input type="text" class="form-control number" maxlength="3" name="deviceip_3" required="">
                    @if($errors->has('deviceip_3'))
                    <span class="help-block">
                      <strong>{{ $errors->first('deviceip_3') }}</strong>
                    </span>
                    @endif
                  </div>
​
                  <div class="form-group col-md-3">
                    <input type="text" class="form-control number" maxlength="3" name="deviceip_4" required="">
                    @if($errors->has('deviceip_4'))
                    <span class="help-block">
                      <strong>{{ $errors->first('deviceip_4') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
​
                <div class="form-group">
                  <label>Device Port<span style="color: red;">*</span></label>
                  <input type="text" class="form-control number" maxlength="4" required="" name="device_port" placeholder="Enter device port" >
                  @if($errors->has('device_port'))
                  <span class="help-block">
                    <strong>{{ $errors->first('device_port') }}</strong>
                  </span>
                  @endif
                </div>

                 <div class="form-group">
                  <label>Type</label>
                  <select class="form-control" id="dtype" name="dtype">
                    <option value="independent">Independent</option>
                    <option value="panellitev2">Panel Lite V2</option>
                  </select>
                </div>

                <div id="panellitev2div">
              
                  <div class="row">
                    <div class="form-group col-md-8">  
                      <label>Device Ip</label>
                    </div>
                    <div class="form-group col-md-4">  
                      <label>Device port No</label>
                    </div>
                  </div>

                <div class="row">
                <div style="margin-top: -1px;">
                  <div class="form-group col-md-2" style="margin-left: -1px;">
                    <input type="text" class="form-control number" maxlength="3" name="paneldeviceip_1" >
                    @if($errors->has('paneldeviceip_1'))
                    <span class="help-block">
                      <strong>{{ $errors->first('paneldeviceip_1') }}</strong>
                    </span>
                    @endif
                  </div>
​
                  <div class="form-group col-md-2">
                    <input type="text" class="form-control number" maxlength="3" name="paneldeviceip_2" >
                    @if($errors->has('paneldeviceip_2'))
                    <span class="help-block">
                      <strong>{{ $errors->first('paneldeviceip_2') }}</strong>
                    </span>
                    @endif
                  </div>
​
                  <div class="form-group col-md-2">
                    <input type="text" class="form-control number" maxlength="3" name="paneldeviceip_3" >
                    @if($errors->has('paneldeviceip_3'))
                    <span class="help-block">
                      <strong>{{ $errors->first('paneldeviceip_3') }}</strong>
                    </span>
                    @endif
                  </div>
​
                  <div class="form-group col-md-2">
                    <input type="text" class="form-control number" maxlength="3" name="paneldeviceip_4" >
                    @if($errors->has('paneldeviceip_4'))
                    <span class="help-block">
                      <strong>{{ $errors->first('paneldeviceip_4') }}</strong>
                    </span>
                    @endif
                  </div>

                  <div class="form-group col-md-2">
                  <input type="su" class="form-control number" maxlength="4" name="plvdevice_port0" placeholder="port no" >
                </div>
                <input type="hidden" name="i" id="i" value="0">
                <div class="form-group col-md-1">
                    <a class="btn bg-orange" title="add More Device" id="addfield"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                  </div>   
                </div>
              </div>
​
                </div>

              
                <div class="form-group">
                  <label>Location</label>
                  <textarea rows="2" class="form-control" name="location"></textarea>
                </div>
​
                <div class="form-group">
                  <label>Device Name<span style="color: red;">*</span></label>
                  <input type="text" class="form-control" maxlength="200" name="devicename"  placeholder="Enter Device Name" required="">
                  @if($errors->has('companyName'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companyName') }}</strong>
                    </span>
                  @endif
                </div>
                
                
                 <div class="form-group">  
                  <label>Username<span style="color: red;">*</span></label>
                  <input type="text" name="username" class="form-control" placeholder="Enter Device Username" required="">
                  @if($errors->has('companyName'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companyName') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">  
                  <label>Password<span style="color: red;">*</span></label>
                  <input type="password" name="password" class="form-control" placeholder="Enter Device Password" required="">
                  @if($errors->has('companyName'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companyName') }}</strong>
                    </span>
                  @endif
                </div>
                
                <!-- <div id="reader">
                 <div class="form-group">
                  <label>Reader</label>
                  <select class="form-control" id="readerval" name="reader">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                  </select>
                </div>
              </div> -->


​               <div class="row col-md-offset-4">
                <button type="submit" class="btn bg-orange">Submit</button>&nbsp;
                <a href="" class="btn btn-danger">Cancel</a>
​              </div>

              </form>
            </div>
          </div>
    </div>

    </div>
  </div>

</div></div>
</div>

<script type="text/javascript">

                  $('#panellitev2div').hide();
                  
                  

                  $('#dtype').change(function(){

                    if (this.value == 'panellitev2') {

                       $('#panellitev2div').show();
                       $('#reader').hide();

                    }else{

                         $('#panellitev2div').hide();
                          $('#reader').show();
                    }

                  });

                  $('#addfield').on('click', function(){
                    var i = $('#i').val();
                        i = Number(i) + 1;
                        //alert("paneldeviceip_1"+i);
                    $('#panellitev2div').append('<div id="paneldevicedelete'+i+'"><div class="row"></div><div class="row"><div style="margin-top: -1px;"><div class="form-group col-md-2" style="margin-left: -1px;"><input type="text" class="form-control number" maxlength="3" name="paneldeviceip_1'+i+'" ></div><div class="form-group col-md-2"><input type="text" class="form-control number" maxlength="3" name="paneldeviceip_2'+i+'"></div><div class="form-group col-md-2"><input type="text" class="form-control number" maxlength="3" name="paneldeviceip_3'+i+'"></div> <div class="form-group col-md-2"><input type="text" class="form-control number" maxlength="3" name="paneldeviceip_4'+i+'"></div> <div class="form-group col-md-2"><input type="su" class="form-control number" maxlength="4" name="plvdevice_port'+i+'" placeholder="port"></div><button type="button" id="removeitem'+i+'" data-toggle="" data-placement="top" onclick="removeproduct('+i+');" data-original-title="Remove This Product" class="btn btn-danger" style="margin-left: auto;"><i class="glyphicon glyphicon-minus"></i></button></div>');
                    $('#i').val(i);
                });
                         
</script>
  <script type="text/javascript">
  function removeproduct(i)
{
  $('#paneldevicedelete'+i).remove();
}
              </script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#device_form').validate({});
  });
</script>
@endsection