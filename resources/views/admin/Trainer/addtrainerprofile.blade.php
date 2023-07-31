@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
  .content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
  }
td{
  max-width: 10%;
}
table td{
  width: 10% !important;
  max-width: 10% !important;
}
.select2{
  width: 100% !important;
  
}

.badgebox
{
    opacity: 0;
}

.badgebox + .badge
{
    /* Move the check mark away when unchecked */
    text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
  width: 27px;


}
.wrapper {
  margin-right: auto; /* 1 */
  margin-left:  auto; /* 1 */

  max-width: 960px; /* 2 */

  padding-right: 10px; /* 3 */
  padding-left:  10px; /* 3 */
}
.badgebox:focus + .badge
{
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */
    
    /* Adding a light border */
    box-shadow: inset 0px 0px 5px;
     Taking the difference out of the padding 
}

.badgebox:checked + .badge
{
    /* Move the check mark back when checked */
  text-indent: 0;
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
<!--         <h1 style="text-decoration: none;">Trainer Profile</h1>
 -->    </section>
    <section class="content">

        @if($errors->any())
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{$errors->first()}}</strong>
        </div>
        @endif
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Trainer Profile</h3>

                        </div>
                        <div class="box-body">
                            <div class="box-body">
                                <form name="refreshForm">
                                    <input type="hidden" name="visited" value="" />
                                </form>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-8">
                                    <form action="{{ url('addtrainerprofile')}}" role="form" method="post" class="form-horizontal" enctype="multipart/form-data">
                                        {{csrf_field()}}

                                        <div id="specific">
                                            <div class="form-group">
                                                <label for="productid" class="col-sm-4 control-label">Select Trianer</label>
                                                <div class="col-sm-8">
                                                    @if(Session('role')== 'trainer' || Session('role')== 'Trainer')
                                                        <input type="text" class="form-control" readonly="" id="trainername" value="{{Session('username')}}">
                                                         <input type="text" class="form-control hide" readonly=""  id="trainerid" name="trainerid" value="{{Session('employeeid')}}">
                                                    @else
                                                        <select id="trainerid" class="form-control select2" data-placeorder="--Select Trainer--" name="trainerid">
                                                            @if(!empty($trainer))
                                                            <option value="" disabled="" selected="">Select Trainer</option>
                                                            @foreach($trainer as $tr )
                                                            <option value="{{ $tr->employeeid }}">{{ $tr->username }}</option>
                                                            @endforeach @else
                                                            <option value="">No Company Available</option>
                                                            @endif
                                                        </select>
                                                    @endif
                                                    @if($errors->has('companyid'))
                                                    <span class="help-block">
                                                      <strong>{{ $errors->first('companyid') }}</strong>
                                                        </span> @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="city" class="col-sm-4 control-label">City</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="city" class="form-control" id="city" readonly="">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="level" class="col-sm-4 control-label">Level Of Trainer</label>
                                                <div class="col-sm-8">
                                                    <select name="level" class="form-control" id="leveloftrainer">
                                                        <option value="">Please Select</option>
                                                        @foreach($levels as $lvl)
                                                        <option value="{{$lvl->id}}">{{$lvl->level}}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- <input type="text" name="level" class="form-control" id="leveloftrainer" readonly=""> -->

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Exp" class="col-sm-4 control-label">Exp.</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="exp" id="exp"></textarea>
                                                    <!-- <input type="text" name="exp" class="form-control"> -->

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Achievments" class="col-sm-4 control-label">Achievments</label>
                                                <div class="col-sm-8">
                                                    <textarea name="achievments" class="form-control" id="achievments"></textarea>
                                                    <!-- <input type="text" name="achievments" class="form-control"> -->

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="AvailableSlot" class="col-sm-4 control-label">Available slots :</label>

                                                <div class="col-sm-12 col-sm-offset-4" style="margin-top: -30px;">

                                                    <div class="col-sm-4">
                                     
                                                        <label class="btn btn-default margin">06:00 AM To 07:00 AM
                                                            <input type="checkbox" name="slots[]" id="chkbx1" class="badgebox" value="06:00 AM To 07:00 AM">
                                                             <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                        <label class="btn btn-default margin">09:00 AM To 10:00 AM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="09:00 AM To 10:00 AM">
                                                            <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                        <label class="btn btn-default margin">12:00 PM To 01:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="12:00 PM To 01:00 PM">
                                                             <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">03:00 PM To 04:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="03:00 PM To 04:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                        <label class="btn btn-default margin">06:00 PM To 07:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="06:00 PM To 07:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">09:00 PM To 10:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="09:00 PM To 10:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="btn btn-default margin">07:00 AM To 08:00 AM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="07:00 AM To 08:00 AM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">10:00 AM To 11:00 AM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="10:00 AM To 11:00 AM"> <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                        <label class="btn btn-default margin">01:00 PM To 02:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="01:00 PM To 02:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">04:00 PM To 05:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="04:00 PM To 05:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">07:00 PM To 08:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="07:00 PM To 08:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">10:00 PM To 11:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="10:00 PM To 11:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="btn btn-default margin">08:00 AM To 09:00 AM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="08:00 AM To 09:00 AM"> <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                        <label class="btn btn-default margin">11:00 AM To 12:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="11:00 AM To 12:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">02:00 PM To 03:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="02:00 PM To 03:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">05:00 PM To 06:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="05:00 PM To 06:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                        <label class="btn btn-default margin">08:00 PM To 09:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="08:00 PM To 09:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>
                                                        <label class="btn btn-default margin">11:00 PM To 12:00 PM
                                                            <input type="checkbox" name="slots[]" class="badgebox" value="11:00 PM To 12:00 PM"> <span class="badge bg-orange">&check;</span>
                                                        </label>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="results" class="col-sm-4 control-label">Photo</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="photo" id="photo" class="form-control" accept="image/jpg, image/jpeg, image/png" onchange="loadImageFile()">
                                                    <span id="img_error"></span>
                                                    <img src="" id="img" height="100px">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="results" class="col-sm-4 control-label">Results</label>
                                                <div class="col-sm-8">
                                                    <input id="file-input" type="file" multiple name="results[]" class="form-control error">
                                                    <span id="file_error"></span>
                                                    <div id="preview"></div>

                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <div class="col-sm-offset-6 col-sm-6">
                                                    <button name="add" type="submit" id="submitbutton" class="btn btn-success"><span class="fa fa-plus"></span> Add
                                                    </button>
                                                    <button name="deduct" type="submit" id="deduct" class="btn btn-danger" style="display: none;">
                                                        <span class="fa fa-minus"></span> Deduct
                                                    </button>
                                                    <a href="{{ url('viewtrainers') }}" type="button" class="btn btn-default">Cancel</a>
                                                </div>
                                            </div>
                                    </form>

                                    </div>

                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    </div>
    @php $trainerid=session()->get('employeeid'); @endphp

<script type="text/javascript">

    $(document).ready(function(){
        var trainerid='<?php echo $trainerid;?>';
        var _token = $('input[name="_token"]').val();
        $.ajax({
          type : 'POST',
          url : '{{ url('gettrainerdetail') }}',
          data : {trainerid:trainerid, _token:'{{ csrf_token() }}'},
          success : function(data){
            var result=data;
            console.log(result);
            if(result){

                if(!result.nodata){
                    $('#city').val(result.city);
                    $('#exp').text(result.exp); 
                    $('#achievments').text(result.achievments);
                    $('#leveloftrainer').val(result.level);
                    $('#submitbutton').attr('value','Update').text('Update');

                }else{
                    $('#city').val();
                    $('#exp').text(''); 
                    $('#achievments').text('');
                    $('#leveloftrainer').val(result.level);
                    $('#submitbutton').attr('value','Add').text('Add');
                }
            }
          }
        });
    
    });
</script>
<script type="text/javascript">
var fileReader = new FileReader();
var filterType = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

fileReader.onload = function (event) {
  var image = $('#photo');
  
  image.onload=function(){
      document.getElementById("photo").src=image.src;
      var canvas=document.createElement("canvas");
      var context=canvas.getContext("2d");
      canvas.width=image.width/4;
      canvas.height=image.height/4;
      context.drawImage(image,
          0,
          0,
          image.width,
          image.height,
          0,
          0,
          canvas.width,
          canvas.height
      );
      $('#img').attr('src', canvas.toDataURL());
      $('#photo').attr('src', canvas.toDataURL());

      // document.getElementById("photo").src = canvas.toDataURL();
  }
  image.src=event.target.result;
};

var loadImageFile = function () {
  var uploadImage = document.getElementById("photo");
  
  //check and retuns the length of uploded file.
  if (uploadImage.files.length === 0) { 
    return; 
  }
  
  //Is Used for validate a valid file.
  var uploadFile = document.getElementById("photo").files[0];
  if (!filterType.test(uploadFile.type)) {
    alert("Please select a valid image."); 
    return;
  }
  
  fileReader.readAsDataURL(uploadFile);
}
              $('#photo').change(function(){

                   var input = this;
                   var url = $(this).val();
                   // alert( input.files[0].size);
                   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                  if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg") && input.files[0].size < 2097152) 
                   {
                     var reader = new FileReader();
   
                     reader.onload = function (e) {
                      $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                  }
                  else
                  {
                    $("#img_error").css('color','#FF0000');
                    $("#img_error").html("Please Select Valid Image");
                     $("#photo").val('');
                   // $('#img_error').attr('src', '/assets/no_preview.png');
                 }
               });

              function previewImages() {

                var $preview = $('#preview').empty();
                if (this.files) $.each(this.files, readAndPreview);

                  function readAndPreview(i, file) {

                  if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return alert(file.name +" is not an image");
                } // else...

                var reader = new FileReader();

                 $(reader).on("load", function() {
                   $preview.append($("<img/>", {src:this.result, height:100}));
                });

                reader.readAsDataURL(file);

                }

              }

$('#file-input').on("change", previewImages);
   </script>
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
    //Money Euro
    $('[data-mask]').inputmask();

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
<script type="text/javascript">
  $("#mode").select2({
    placeholder: "Select a Mode"
});
</script>
<script type="text/javascript">
    
  $('#trainerid').on('change',function(){
    var trainerid=$('#trainerid').val();
    var _token = $('input[name="_token"]').val();
        $.ajax({
          type : 'POST',
          url : '{{ url('gettrainerdetail') }}',
          data : {trainerid:trainerid, _token:'{{ csrf_token() }}'},
          success : function(data){
            var result=data;
            if(result){
                var i=0;
                var arr =[];
                       $('.badgebox').each(function () {
                           arr.push($(this).val());
                           $(this).prop('checked',false);
                       }); 
  
                if(!result.nodata){
                    $('#city').val(result.city);
                    $('#exp').text(result.exp); 
                    $('#achievments').text(result.achievments);
                    $('#leveloftrainer').val(result.level);
               
                      array1=result.freeslot;
                      var slotarray = array1.split(',');
                      $.each(arr,function(item,i){
                        for(var j=0;j<slotarray.length;j++){
                          if(i == slotarray[j]){
                            $("input[name='slots[]'][value='"+slotarray[j]+"']").prop('checked',true);
                          }
                        }
                      })
                      
            
                    $('#submitbutton').attr('value','Update').text('Update');

                }else{
                    $('#city').val();
                    $('#exp').text(''); 
                    $('#achievments').text('');
                    $('#leveloftrainer').val(result.level);
                    $('#submitbutton').attr('value','Add').text('Add');
                }
            }
          }
        });
        
  })
</script>
<script type="text/javascript">
     $('input#file-input').change(function(){
  var imageSizeArr = 0;
  var imageArr = document.getElementById('file-input');
  var imageCount = imageArr.files.length;
  var imageToBig = false;
  for (var i = 0; i < imageArr.files.length; i++){
     var imageSize = imageArr.files[i].size;
     var imageName = imageArr.files[i].name;
     if (imageSize > 2097152){
         var imageSizeArr = 1;
     }
     if (imageSizeArr == 1){

         // console.log(imageName+imageSize+ ': file too big\n');
         imageToBig = true;
     }
     else if (imageSizeArr == 0){
         // console.log(imageName+': file ok\n');
     }
  }
  if(imageToBig){
    $("#file_error").css('color','#FF0000');
    $("#file_error").html("File size is greater than 2MB");
    $(".error").css("border-color","#FF0000");
    //give an alert that at least one image is to big
    // window.alert("At least one of your images is too large to process, see the console for exact file details.");
    $('#add').attr('disabled',true);
    }
    else{
        $('#add').attr('disabled',false); 
         $("#file_error").html('');
          $(".error").css("border-color","#d2d6de");
    }
});  
</script>
@endsection