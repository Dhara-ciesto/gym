@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
   strong{
   color: red;
   }
.ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.ul .li1 {
  /*border: 1px solid #ddd;*/
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6;
    padding: 6px;
  margin-bottom: 10px;
  text-decoration: none;
  font-size: 15px;
  color: black;
  display: block;
  position: relative;
  border-radius: 10px;
}

.ul .li1:hover {
  background-color: #f7e5c8;
}
.close {
  cursor: pointer;
  position: absolute;
  top: 50%;
  right: 0%;
  padding: 12px 16px;
  transform: translate(0%, -50%);
}

.close:hover {background: #bbb;}
</style>
@endpush
@section('content')

<!-- left column -->
<div class="content-wrapper">
   <section class="content-header">
<!--       <h2>Add User</h2>
 -->   </section>
   <!-- general form elements -->
   <section class="content">
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

             @if ($message = Session::get('message'))
           
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>

    @endif
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title">Add User</h3>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
             <form  id="user_validation_form" action="{{ url('addUser') }}"  method="post" enctype="multipart/form-data" >
            <div class="col-lg-5">
             <br>
               <h4>Account Details</h4>
        <br>
                  {{ csrf_field() }}
                  <div class="form-group">
                     <label>Account No</label>
                     <input type="text"  name="accountNo" value="{{ old('accountNo') }}" class="form-control number "autocomplete="off" placeholder="account no"  class="span11" maxlength="16" />
                     @if($errors->has('accountNo'))
                     <span class="help-block">
                     <strong>{{ $errors->first('accountNo') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Account Name</label>
                     <input type="text"  name="accountName" value="{{ old('accountName') }}" class="form-control  " autocomplete="off"placeholder="account name"  class="span11" maxlength="16"/>
                     @if($errors->has('accountName'))
                     <span class="help-block">
                     <strong>{{ $errors->first('accountName') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>IFSC Code</label>
                     <input type="text"  name="IFSCcode" value="{{ old('IFSCcode') }}" class="form-control" autocomplete="off"placeholder="IFSC Code"  class="span11" maxlength="25"/>
                     @if($errors->has('IFSCcode'))
                     <span class="help-block">
                     <strong>{{ $errors->first('IFSCcode') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Bank Name</label>
                     <input type="text"  name="BankName" value="{{ old('BankName') }}" class="form-control " autocomplete="off"placeholder="bank name"  class="span11" maxlength="16"/>
                     @if($errors->has('BankName'))
                     <span class="help-block">
                     <strong>{{ $errors->first('BankName') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Branch Name</label>
                     <input type="text"  name="BranchName" value="{{ old('BranchName') }}" class="form-control" autocomplete="off"placeholder="branch name"  maxlength="20"class="span11" />
                     @if($errors->has('BranchName'))
                     <span class="help-block">
                     <strong>{{ $errors->first('BranchName') }}</strong>
                     </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Branch Code</label>
                     <input type="text"  name="BranchCode" value="{{ old('BranchCode') }}" class="form-control number" autocomplete="off" maxlength="20" placeholder="branch code"  class="span11" />
                     @if($errors->has('BranchCode'))
                     <span class="help-block">
                     <strong>{{ $errors->first('BranchCode') }}</strong>
                     </span>
                     @endif
                  </div>
              
                  <div class="form-group">
                    <button type="button" id=upload class="btn bg=ornage">Upload Documents  </button>
                    <p class="p"></p>
                        <p id="fp"></p>
                           <ul class="ul">
                         <li class="li1" style="display: none"></li>
                         </ul>
    <!-- <p>
        <input type="button" value="Show Details" 
            onclick="FileDetails()" >
    </p> -->
                  </div>

                </div>
       <!--      </div> -->
<br>
               <h4>User Details</h4>
               <br>
            <div class="col-lg-6">
                 <div class="form-group">
                    <label>First Name<span style="color: red;">*</span></label>
                    <input type="text"  id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control"placeholder="First name" required=""  maxlength="191" class="span11" />
                    @if($errors->has('first_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Last Name<span style="color: red;">*</span></label>
                    <input type="text"  id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control"placeholder="Last name" required=""  maxlength="191" class="span11" />
                    @if($errors->has('last_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>User Name<span style="color: red;">*</span></label>
                    <input type="text"  id="username" name="username" value="{{ old('username') }}" class="form-control"placeholder="User name" required=""  maxlength="255" class="span11" /><span id="error_username"></span>
                    @if($errors->has('username'))
                    <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Select Role<span style="color: red;">*</span></label>
                    <select name="Role_id" id="Role_id"  class="form-control"class="span11">
                    <option selected disabled="" required="" value="">--Please choose an option--</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->roleid }}" @if(old('Role_id') ==  $role->roleid) selected @endif>{{ $role->employeerole }}</option>
                    @endforeach
                    </select>
                    @if($errors->has('Role_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('Role_id') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Email Id<span style="color: red;">*</span></label>
                    <input type="email" maxlength="255" name="email" id="email" value="{{ old('email') }}" class="form-control span11" placeholder="Email"  required="" class="" />
                    @if($errors->has('email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Address<span style="color: red;">*</span></label>
                    <textarea rows="2" cols="20" name="add" id="add" maxlength="255"  wrap="soft" class="form-control" required="" placeholder="Address" class="span11">{{ old('add') }}</textarea>
                    @if($errors->has('add'))
                    <span class="help-block">
                    <strong>{{ $errors->first('add') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>City</label>
                    <select name="city" class="form-control" class="span11">
                    <option selected disabled="" value="">--Please choose an option--</option>
                    <option value="Rajkot" @if(old('city') == 'Rajkot') selected @endif>Rajkot</option>
                    <option  value="Ahemdabad" @if(old('city') == 'Ahemdabad') selected @endif>Ahemdabad</option>
                    <option  value="Surat" @if(old('city') == 'Surat') selected @endif>Surat</option>
                    <option  value="Vadodara" @if(old('city') == 'Vadodara') selected @endif>Vadodara</option>
                    <option  value="Jamnagar" @if(old('city') == 'Jamnagar') selected @endif>Jamnagar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <input type="text" value="{{ old('department') }}" name="department" class="form-control" placeholder="Department" class="span11" />
                    @if($errors->has('department'))
                    <span class="help-block">
                    <strong>{{ $errors->first('department') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Salary<span style="color: red;">*</span></label>
                    <input type="text" value="{{ old('salary') }}" class="form-control number" name="salary" placeholder="Salary" class="span8" maxlength="8" required="" />
                    @if($errors->has('salary'))
                    <span class="help-block">
                    <strong>{{ $errors->first('salary') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Working hours</label><br>
                    <span><label> Shift 1: From</label></span>
                    <input type="time" class="form-control"  name="working_hour_from_1"
                    min="9:00 am" max="12:00 pm" @if(!empty(old('working_hour_from_1'))) value="{{ old('working_hour_from_1') }}" @else value="09:30" @endif required />
                    <label>To</label> 
                    <input type="time" class="form-control"  name="working_hour_to_1"
                    min="9:00 pm" default="09:pm" max="12:00 pm" @if(!empty(old('working_hour_to_1'))) value="{{ old('working_hour_from_1') }}" @else value="11:30" @endif required />
                    <label>Shift 2: From</label>
                    <input type="time" class="form-control"  name="working_hour_from_2"
                    min="9:00 am" max="12:00 pm" @if(!empty(old('working_hour_from_2'))) value="{{ old('working_hour_from_1') }}" @else value="09:30" @endif required/>
                    <label>To</label> 
                    <input type="time"class="form-control"  name="working_hour_to_2"
                    min="9:00 pm" max="12:00 pm" @if(!empty(old('working_hour_to_2'))) value="{{ old('working_hour_from_1') }}" @else value="11:30" @endif required/>
                </div>
                <div class="form-group">
                    <label>Working Hour(Per Day)<span style="color: red;">*</span></label>
                    <input type="text" name="workinghour" class="form-control" maxlength="5" required="" value="{{ old('workinghour') }}">
                    @if($errors->has('workinghour'))
                     <span class="help-block">
                     <strong>{{ $errors->first('workinghour') }}</strong>
                     </span>
                     @endif
                </div>
                <div class="form-group">
                    <label>Birthdate</label>
                    <input placeholder="Birthdate" value="{{ old('dob') }}" type="date" onkeypress="return false" class="form-control" name="dob" requiredclass="span11" max="{{ date('Y-m-d') }}">
                </div>

                <div class="form-group">  <label>Gender</label>
                    <label>
                        <input type="radio" name="gender" @if(old('gender') == 'female') checked @endif  value="female"  checked="">Female
                    </label>
                    <label>
                        <input type="radio" name="gender" @if(old('gender') == 'male') checked @endif  value="male"> Male
                    </label>
                </div>
                <div class="form-group">
                    <label>Photo</label>
                    <input type="file" id="profile-img" name="file"class="form-control"  class="span11" accept="image/jpg, image/jpeg, image/png" />
                    <img src="" id="profile-img-tag" width="200px">
                </div>
                <div class="form-group">
                    <label>Mobile No<span style="color: red;">*</span></label>
                    <input type="text" id="mobileno" name="mobileno" value="{{ old('mobileno') }}" class="form-control number" required placeholder="Mobile no" class="span11" minlength="10" maxlength="10"  /><span id="error_mobileno"></span>
                    @if($errors->has('mobileno'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mobileno') }}</strong>
                    </span>
                    @endif

                </div>
                <div class="form-group">
                    <label>Password<span style="color: red;">*</span></label>
                    <span>Note: Minimum 6 characters are required</span>

              
                    <input type="password" name="password" class="form-control" required  placeholder="Password"class="span11" minlength="6" min="6" />
                    @if($errors->has('password'))

                    <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <input type="hidden" name="attachfiles" value="" id="attachfiles">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="col-sm-6">
                            <button type="submit"class="btn bg-green btn-block">
                            Save</button></div> <div class="col-sm-6">
                            <a href="{{ url('users') }}"class="btn btn-danger btn-block">Cancel</a></div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Upload Files</h5>
      <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
    

      </div>
      <div class="modal-body">
        <!-- <label>Docs Type</label> -->
 <!--        <select name="docstype" class="form-control span8" id="docstype">
            <option value="" selected="" disabled="">--Select Document Type--</option>
            <option value="adharcard">adharcard</option>
        <option value="drvinglicence">Drvinglicence</option>
    <option value="other">Other</option></select>
    <br> -->
              <input type="file" name="docs[]" id="docs" multiple="" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save" class="btn btn-primary" disabled="true">Save changes</button>
      </div>
    </div>
  </div>
</div>
        </form>  
            </div>
         </div>
      </div>
      <!-- /.box-body -->
   </section>
</div>
</div>
</div>
<script type="text/javascript">
$(function() {
    $('#username').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});
</script>

<script type="text/javascript">
   $('#username').on('keyup',function(){
   
     
      
     var error_username = '';
      var username = $('#username').val();
       var mobileno = $('#mobileno').val();
      var _token = $('input[name="_token"]').val();
   
       $.ajax({
        url:"{{ route('UserController.check') }}",
        method:"POST",
        data:{username:username,mobileno:mobileno, _token:_token},
        success:function(result)
        {
        console.log(result);
         if(result == 202)
         {
          $('#error_username').html('<label class="text-success"></label>');
          $('#username').removeClass('has-error');
          $('#firstbtn').attr('disabled', false);
         }
         else
         {
          // alert("hi1");
          $('#error_username').html('<label class="text-danger">User Name is Already Exist</label>');
          $('#username').addClass('has-error');
          $('#firstbtn').attr('disabled', 'disabled');
         }
        }
       })
     });
   $('#mobileno').on('keyup',function(){
   
     
      
     var error_username = '';
      var username = $('#username').val();
       var mobileno = $('#mobileno').val();
      var _token = $('input[name="_token"]').val();
   if(mobileno.length>9){
          $.ajax({
        url:"{{ route('UserController.check') }}",
        method:"POST",
        data:{username:username,mobileno:mobileno, _token:_token},
        success:function(result)
        {
          // alert(result);
           // console.log(result);
         if(result == 202)
         {
          $('#error_mobileno').html('<label class="text-success"></label>');
          $('#username').removeClass('has-error');
          $('#firstbtn').attr('disabled', false);
         }
         else
         {
          // alert("hi1");
          $('#error_mobileno').html('<label class="text-danger">Mobileno is already exist</label>');
          $('#username').addClass('has-error');
          $('#firstbtn').attr('disabled', 'disabled');
         }
        }
       })
   }
 
     });
</script>
<script type="text/javascript">
    $('input#docs').change(function(){
  var imageSizeArr = 0;
  var imageArr = document.getElementById('docs');
  var imageCount = imageArr.files.length;
  var imageToBig = false;
  for (var i = 0; i < imageArr.files.length; i++){
     var imageSize = imageArr.files[i].size;
     var imageName = imageArr.files[i].name;
     if (imageSize >8000000){
         var imageSizeArr = 1;
     }
     if (imageSizeArr == 1){
         console.log(imageName+imageSize+ ': file too big\n');
         imageToBig = true;
     }
     else if (imageSizeArr == 0){
         // console.log(imageName+': file ok\n');
     }
  }
  if(imageToBig){
    //give an alert that at least one image is to big
    window.alert("At least one of your images is too large to process, see the console for exact file details.");
    $('#save').attr('disabled',true);
    }
    else{
        $('#save').attr('disabled',false); 
    }
});  
</script>
@endsection
@push('script')
<script type="text/javascript">
   $(document).ready(function(){
     $('#user_validation_form1').validate({

     });
   });

</script>
<script type="text/javascript">
    var file_array = [];
    $('#upload').on('click',function(){
          $('#exampleModalCenter').modal('toggle');
          $('#docs').val('');
          $('#docstype').val('');

    });
     var attachfiles1 = new Array();
    $('#save').on('click',function(){

 

        // GET THE FILE INPUT.
        var fi = document.getElementById('docs');

        // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
        if (fi.files.length > 0) {

            // THE TOTAL FILE COUNT.
            document.getElementById('fp').innerHTML =
                'Total Files: <b>' + fi.files.length + '</b></br >';

            // RUN A LOOP TO CHECK EACH SELECTED FILE.
            for (var i = 0; i <= fi.files.length - 1; i++) {

                var fname = fi.files.item(i).name;      // THE NAME OF THE FILE.
                var fsize = fi.files.item(i).size;      // THE SIZE OF THE FILE.

                // SHOW THE EXTRACTED DETAILS OF THE FILE.
                     var ap=' <li class="li1"><a class="files" >'+fname+' </a>  ('+fsize+'      bytes )  </li>';
                     $('.li1:last').after(ap); 

            }
        }
        else { 
            // alert('Please select a file.') 
        }
    

     $('#exampleModalCenter').modal('toggle'); 
     // alert(filename1);
        
  
    });
</script>
<script type="text/javascript">
  $('#first_name').change(function(){
    var firstname= $('#first_name').val();
    firstname = firstname.replace(/[^a-z\u00D1\u00F10-9]*/ig,'');
    $('#first_name').val(firstname);
    $('#last_name').trigger('change');
  });
  $('#last_name').change(function(){
    let fname = $('#first_name').val();
    let lname = $('#last_name').val();

    lname = lname.replace(/[^a-z\u00D1\u00F10-9]*/ig,'');
    $('#last_name').val(lname);
    let username = fname+lname;
    $('#username').val(username);
    var el = $('#username').val();
    var val = el.replace(/\s/g, "");
    $('#username').val(val);
    $('#username').trigger('keyup');

  });
</script>
<script type="text/javascript">
    $('#profile-img').bind('change', function(event) {

  //this.files[0].size gets the size of your file.
  if(this.files[0].size > 8000000){
    alert('Profile Picture size is too Big');
$('#profile-img').val('');
  }
  else{
     readURL(this);
  }

});
       function readURL(input) {
         if (input.files && input.files[0]) {
             var reader = new FileReader();
             
             reader.onload = function (e) {
                 $('#profile-img-tag').attr('src', e.target.result).height(150).width(150);
             }
             reader.readAsDataURL(input.files[0]);
         }
     }
  
</script>
@endpush