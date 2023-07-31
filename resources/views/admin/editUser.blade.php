@extends('layouts.adminLayout.admin_design')
@section('content')

<style>
* {
  box-sizing: border-box;
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

.close1 {
  cursor: pointer;
  position: absolute;
  top: 50%;
  right: 0%;
  padding: 12px 16px;
  transform: translate(0%, -50%);
}

.close1:hover {background: #bbb;}
.btn-new:hover{background-color: #ef5a5a;}
.btn-new{
   background-color: #EEEEEE;
       padding: 5px 12px;
    text-decoration:none;
    font-weight:bold;
    border-radius:5px;
    color: #101010;
    cursor:pointer;
}
</style>
<div class="content-wrapper">
  <section class="content-header"></section>
  <!-- general form elements -->
  <section class="content">
              @if($message = Session::get('message'))

    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
    </div>
@endif
@if($errors->any())

    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{$errors->first()}}</strong>
    </div>

@endif

    <div class="row">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit User </h3>
        </div>
        <!-- /.box-header -->
        <form role="form" action="{{ url('edituser/'.$user->employeeid) }}"  method="post" enctype="multipart/form-data" id="edituser">
          <div class="box-body">
            <div class="col-lg-5">
              <h4>Account Details</h4>

             {{ csrf_field() }}

              <div class="form-group">
                <label>Account No</label>
                <input type="text"   name="accountNo" class="form-control number"placeholder="account no" maxlength="20"  class="span11" value="{{ $user->accountno }}" />
                @if($errors->has('accountNo'))

                <span class="help-block">
                  <strong>{{ $errors->first('accountNo') }}</strong>
                </span>
                @endif

              </div>
              <div class="form-group">
                <label>Account Name</label>
                <input type="text"   name="accountName" maxlength="20" class="form-control" placeholder="account name"  class="span11" value="{{ $user->accountname }}" />
                 @if($errors->has('accountName'))

                <span class="help-block">
                  <strong>{{ $errors->first('accountName') }}</strong>
                </span>
                @endif

              </div>
              <div class="form-group">
                <label>IFSC Code</label>
                <input type="text"   name="IFSCcode" class="form-control"placeholder="IFSC Code" maxlength="20"  class="span11" value="{{$user->ifsccode}}" />
                 @if($errors->has('IFSCcode'))

                <span class="help-block">
                  <strong>{{ $errors->first('IFSCcode') }}</strong>
                </span>
                @endif

              </div>
              <div class="form-group">
                <label>Bank Name</label>
                <input type="text"   name="BankName" class="form-control"placeholder="bank name" maxlength="26"  class="span11" value="{{$user->bankname}}" />
                 @if($errors->has('BankName'))

                <span class="help-block">
                  <strong>{{ $errors->first('BankName') }}</strong>
                </span>
                @endif

              </div>
              <div class="form-group">
                <label>Branch Name</label>
                <input type="text"   name="BranchName" class="form-control"placeholder="branch name" maxlength="20"   class="span11" value="{{$user->branchname}}" />
                @if($errors->has('BranchName'))

                <span class="help-block">
                  <strong>{{ $errors->first('BranchName') }}</strong>
                </span>
                @endif

              </div>
              <div class="form-group">
                <label>Branch Code</label>
                <input type="text" name="BranchCode" class="form-control"placeholder="branch code"  class="span11" value="{{$user->branchcode}}" />
                 @if($errors->has('BranchCode'))

                <span class="help-block">
                  <strong>{{ $errors->first('BranchCode') }}</strong>
                </span>
                @endif

              </div>
              <div class="form-group">
               Change PIN:
                         <button class="btn bg-orange" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-new">Edit</button>
                      </div>



              <div class="form-group">
                <label>Documents Upload</label>
                <input type="file" name="docs[]"  id="docs" multiple="" class="form-control">
                  <input type="hidden" name="olddocs" value="{{$user->files}}" id="olddocs">
                    <input type="hidden" name="alldocs" value="{{$user->files}}" id="alldocs">
                      <br>
                        <div class="list-type5">

                        @if($user->files)
                         @php $fls=  json_decode($user->files);
                        @endphp

                          <ul class="ul">

                        @if(!empty($fls))
                          @foreach($fls as $key=>$file)

                            <!-- <li><a href="#" class="files">{{$file}} </a></li> -->
                            <li class="li1">
                              <a href="\files\{{$file}}"class="files" >{{$file}} </a>
                              <span style="float:right;margin-top: -6px;"class="closebtns btn btn-new">&times;</span>
                            </li>
                          @endforeach
                        @endif


                          </ul>
                         @endif

                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">



                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text"  name="first_name" value="{{ $user->first_name }}" class="form-control number " placeholder="account no"  class="span11" maxlength="16" />
                     @if($errors->has('accountNo'))

                        <span class="help-block">
                          <strong>{{ $errors->first('accountNo') }}</strong>
                        </span>
                     @endif

                      </div>
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text"  name="last_name" value="{{ $user->last_name }}" class="form-control  "placeholder="account name"  class="span11" maxlength="16"/>
                     @if($errors->has('accountName'))

                        <span class="help-block">
                          <strong>{{ $errors->first('accountName') }}</strong>
                        </span>
                     @endif

                      </div>
                      <!-- text input -->
                      <div class="form-group">
                        <label>User Name
                          <span style="color: red;">*</span>
                        </label>
                        <input type="text"class="form-control" placeholder="User name"value="{{ $user->username }}"readonly="" name="username" class="span11"  required/>
                 @if($errors->has('username'))

                        <span class="help-block">
                          <strong>{{ $errors->first('username') }}</strong>
                        </span>
                @endif


                      </div>
                      <div class="form-group">
                        <label>Select Role
                          <span style="color: red;">*</span>
                        </label>
                        <select name="Role_id"class="form-control" class="span11"required>
                          <option selected disabled="">--Please choose an option--</option>


              @foreach($roles as $role)

                          <option value="{{ $role->roleid }}" {{ ( $role->roleid == $user->roleid  ) ? 'selected' : '' }}>{{ $role->employeerole }}</option>
              @endforeach



                        </select>
          @if($errors->has('Role_id'))

                        <span class="help-block">
                          <strong>{{ $errors->first('Role_id') }}</strong>
                        </span>
                @endif


                      </div>
                      <div class="form-group">
                        <label>Email id
                          <span style="color: red;">*</span>
                        </label>
                        <input type="text"class="form-control" name="email"  value="{{ $user->email }}"  placeholder="Email" class="span11"required />
                 @if($errors->has('email'))

                        <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                @endif


                      </div>
                      <div class="form-group">
                        <label>Address
                          <span style="color: red;">*</span>
                        </label>
                        <textarea rows="2" class="form-control"cols="20" name="add" required  wrap="soft" placeholder="Address" class="span11">{{ $user->address }}</textarea>
            @if($errors->has('add'))

                        <span class="help-block">
                          <strong>{{ $errors->first('add') }}</strong>
                        </span>
                @endif


                      </div>
                      <div class="form-group">
                        <label>City</label>
                        <select name="city" class="form-control" value="{{ $user->city }}" class="span11">
                          <option selected disabled="">--Please choose an option--</option>
                          <!--  <option  selected value="{{ $user->city }}">{{ $user->city }}</option> -->
                          <option value="Rajkot"{{ ( $user->city == 'Rajkot'  ) ? 'selected' : '' }}>Rajkot</option>
                          <option  value="Ahemdabad"{{ ( $user->city == 'Ahemdabad'  ) ? 'selected' : '' }}>Ahemdabad</option>
                          <option  value="Surat"{{ ( $user->city == 'Surat'  ) ? 'selected' : '' }}>Surat</option>
                          <option  value="Vadodara"{{ ( $user->city == 'Vadodara'  ) ? 'selected' : '' }}>Vadodara</option>
                          <option  value="Jamnagar" {{ ( $user->city == 'Jamnagar'  ) ? 'selected' : '' }}>Jamnagar</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Department</label>
                        <input type="text"class="form-control" name="department"value="{{$user->department}}" placeholder="Department" class="span11" />
                 @if($errors->has('department'))

                        <span class="help-block">
                          <strong>{{ $errors->first('department') }}</strong>
                        </span>
                @endif


                      </div>
                      <div class="form-group">
                        <label>Salary</label>
                        <input type="text"class="form-control number" min="10000"step="5000" name="salary" value="{{ $user->salary}}"placeholder="Salary" class="span11" maxlength="15" />
                @if($errors->has('salary'))

                        <span class="help-block">
                          <strong>{{ $errors->first('salary') }}</strong>
                        </span>
                @endif



                      </div>
                      <div class="form-group">
                        <label>Working hours</label>
                        <br>
              Shift 1: From

                          <input type="time"class="form-control"name="workinghourfrom1"
                min="9:00 am" max="12:00 pm" class="span8" value="{{$user->workinghourfrom1}}" />
               To

                          <input type="time"class="form-control" name="workinghourto1"
                min="9:00 pm" max="12:00 pm" class="span8"value="{{$user->workinghourto1}}" />

               Shift 2: From

                          <input type="time"class="form-control"name="workinghourfrom2"
                min="9:00 am" max="12:00 pm" class="span8"value="{{$user->workinghourfrom2}}" />
               To

                          <input type="time"class="form-control" id="appt" name="workinghourto2"
                min="9:00 pm" max="12:00 pm" class="span8" value="{{$user->workinghourto2}}"/>
                        </div>
                        <div class="form-group">
                          <label>Working Hour(Per Day)
                            <span style="color: red;">*</span>
                          </label>
                          <input type="text" name="workinghour" class="form-control" max="3" required="" value="{{ $user->workinghour }}">
         @if($errors->has('workinghour'))

                            <span class="help-block">
                              <strong>{{ $errors->first('workinghour') }}</strong>
                            </span>
         @endif

                          </div>
                          <div class="form-group">
                            <label>Status</label>
                            <select name="status"class="form-control"class="span11">
                              <option selected disabled="">--Please choose an option--</option>
                              <!-- <option  selected value="{{ $user->status }}">{{ $user->status }}</option> -->
                              <option value="1" {{$user->status == '1' ? 'selected':''}}>Active</option>
                              <option value="0" {{$user->status == '0' ? 'selected':''}}>Inactive</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Birthdate</label>
                            <input id="dob" type="date" class="form-control" value="{{$user->dob}}"class="span11" name="dob">
                            </div>
                            <div class="form-group">
                              <label>Gender</label>
                              <label>
                                <input type="radio" name="gender"  value="female" {{ ( $user->gender == 'female'  ) ? 'checked' : '' }}>
                                       Female

                                </label>
                                <label>
                                  <input type="radio" name="gender"  value="male"{{ ( $user->gender == 'male'  ) ? 'checked' : '' }}>
                                        Male

                                  </label>
                                </div>
                                <div class="form-group">{{$user->photo}}

                                  <label>Photo</label>
                                  <input type="file"class="form-control" name="file" chosen="wqedqw" value="{{$user->photo}}"class="span11"id="profile-img"/>
                                  <img src="" id="profile-img-tag" width="200px">
                                  </div>
                                  <div class="form-group">
                                    <label>Mobile no
                                      <span style="color: red;">*</span>
                                    </label>
                                    <input type="text"class="form-control number" name="mobileno" placeholder="Mobile_no"value="{{$user->mobileno}}" class="span11" readonly="" />
                                  @if($errors->has('mobileno'))

                                    <span class="help-block">
                                      <strong>{{ $errors->first('mobileno') }}</strong>
                                    </span>
                                  @endif


                                  </div>
                                  <div class="form-group">
                                    <label>Update Password
                                      <span style="color: red;">*</span>
                                    </label>
                                    <span>Note: Minimum 6 characters are required</span>
                                    <input type="password" name="password" class="form-control"   placeholder="Password"class="span11" minlength="6" min="6" />
                                    @if($errors->has('password'))


                                    <span class="help-block">
                                      <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif

                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-3">
                                      <button type="submit" class="btn bg-green margin">Update</button>
                                      <a href="{{ url('users') }}"class="btn bg-red margin">Cancel</a>
                                    </div>
                                  </div>
                                  <!-- Select multiple-->
                                </form>
                              </div>
                            </div>
                            <!-- /.box-body -->
                          </div>

                        </section>
                      </div>
                    </div>
                  </div>

<div class="modal fade in" id="modal-new" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit Member Pin</h4>
              </div>
               <div class="modal-body">
                 <form method="post" action="{{ url('employeepinchange/'.$user->employeeid) }}">
                                  <div class="form-group ">
                                    <div class="col-md-10">

                                    <?php
                                       $p= str_split($user->fitpin);
                                       $c = ($p>0) ? count($p) : 0 ;

                                        ?>

                                    <div class="row">


                                       {{ csrf_field() }}
                                    <div class="col-md-2">
                                      <input type="text" class="number form-control" required  maxlength="1" name="cn1" value="{{ !empty($p[0]) ? $p[0] : '0'}}">
                                    </div>
                                    <div class="col-md-2">

                                      <input type="text" class="number form-control" required  maxlength="1" name="cn2" value="{{!empty($p[1]) ? $p[1] : '0'}}">
                                    </div>
                                    <div class="col-md-2 ">
                                      <input type="text" class="number form-control" required  maxlength="1" name="cn3" value="{{ !empty($p[2]) ? $p[2] : '0'}}">
                                    </div>
                                    <div class="col-md-2 ">
                                      <input type="text" class="number form-control"  required maxlength="1" name="cn4" value="{{ !empty($p[3]) ? $p[3] : '0'}}">
                                    </div>
                                    <div class="col-md-2 ">

                                    </div>
                                  </div>
                              </div><br/>
                              </div>
                             <!-- <button type="submit" class="btn bg-orange">Edit</button> -->
                             </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="employeepinchange" class="btn btn-primary">Save changes</button>
              </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

                  <script>
    var  filesname=[];
var closebtns = document.getElementsByClassName("close1");
var i;

var olddata=$('#olddocs').val();
if(olddata){


  var olddata = jQuery.parseJSON(olddata);
 $.each(olddata, function(index, value) {
  filesname.push(value);
 });
 }

  $('.closebtns').on("click", function() {
// $('#alldocs').val();
   var href =$(this).parents('li').find('a').text();
            // alert('sdfsd');
            var status = confirm("Are you sure you want to delete ?");
            if(status==true)
            {
               var href =$(this).parents('li').find('a').text();
        // alert(href);
              this.parentElement.style.display = 'none';
              var file = href;
              var _token = $('input[name="_token"]').val();
              var employee=
                    <?php echo $user->employeeid;?>;
              $.ajax({
                  url:"{{ url('deletedocs') }}",
                    method:"post",
                    data:{file:file,employee:employee, _token:_token},
                  success(html){
                    if(html=='101'){
                      alert('Deleted');
                  // alert(data);
                     }
                  else{
                    alert('No such file');
                  }
                  },
                  dataType:'json',
                });
              // alert('bar');
            var str=$('#alldocs').val();
            var data = jQuery.parseJSON(str);

            // alert('1'+data);
           // console.log(data);
                        var y=[];
            $.each(data, function(index, value) {
            // console.log(value+'vvvvv');
            //  console.log(href+'hhhhh');
            // console.log(data);
            var value1 = $.trim(value);
            var href1 = $.trim(href);
            if(value1!=href1){
            y.push(value);
             // alert('fhjf');
            }
            else{
              // alert('dcwcw');

            }





            });
            data=y;
             console.log(data);
            filesname=data;
           var save= JSON.stringify(filesname);
             $('#alldocs').val(save);
            // alert(filesname);
            }


            });


    $('input#docs').change(function(){
  var imageSizeArr = 0;
  var imageArr = document.getElementById('docs');
  var imageCount = imageArr.files.length;
  var imageToBig = false;
  for (var i = 0; i < imageArr.files.length; i++){
     var imageSize = imageArr.files[i].size;
     var imageName = imageArr.files[i].name;
     if (imageSize > 2000000){
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
   $('#docs').val('');
    }
    else{
        $('#save').attr('disabled',false);


          var files = $('#docs').prop("files");
          var names = $.map(files, function(val) { return val.name; });
          // console.log(files);
          if(names){
            var names = document.getElementById('docs');
            if (names.files.length > 0) {
              // RUN A LOOP TO CHECK EACH SELECTED FILE.
              for (var i = 0; i <= names.files.length-1; i++) {

                var fname = names.files.item(i).name;      // THE NAME OF THE FILE.
                var fsize = names.files.item(i).size;
                // THE SIZE OF THE FILE.
                var username="<?php echo $user->username;?>";
                fname= fname+'_'+username;
                // alert(fname);
                filesname.push(fname);
                // SHOW THE EXTRACTED DETAILS OF THE FILE.

                var ap='<li class="li1"><a class="files" >'+fname+'</a><span class="closebtns">&times;</span></li>';
                $('.li1:last').after(ap);
              }
            }
          }
      }
});


  // $('#docs').on('change',function(){


    $('#profile-img').bind('change', function(event) {

  //this.files[0].size gets the size of your file.
  if(this.files[0].size > 2000000){
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


$('#edituser').on('submit',function(e){
// e.PreventDefault();


              // alert('befor'+filesname);
              // filesname.push(obj);
            filesname=   JSON.stringify(filesname);
                // alert('after'+filesname);
                if(filesname){
                     $('#alldocs').val(filesname);
                }


             return true;
})
  // $('#olddocs'0
</script>
@endsection
