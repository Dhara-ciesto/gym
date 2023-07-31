@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<!-- <script type="text/javascript" src="../js/sweetalert.min.js"></script>
@include('sweet::alert') -->

<style type="text/css">

/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 18px;
  margin-top: 20px;
  cursor: pointer;
  font-size: 15px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color:#FACB79;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ECA426;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #ECA426;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

.scrollbar{


}


#scroll::-webkit-scrollbar {
  width: 15px;
}

/* Track */
#scroll::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 5px;
}
 
/* Handle */
#scroll::-webkit-scrollbar-thumb {
  background: #ECA426; 
  border-radius: 5px;
}

/* Handle on hover */
#scroll::-webkit-scrollbar-thumb:hover {
  background: #DC9822; 
}

</style>

  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Member Enrollment</h2></section>
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
    @if($message=="Succesfully added")
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
    @if($message=="User Is Already Exits")
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
      @if($message=="Your timing is different from package timimg")
      <div class="alert alert-danger alert-block" id="danger-alert">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
     @if($message=="You Cant  assign  same package untill its not completed")
      <div class="alert alert-danger alert-block" id="danger-alert">
        <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
      </div>
    @endif
@endif 
<script type="text/javascript">
  $(document).ready (function(){
                $("#danger-alert").fadeTo(5000, 500).slideUp(500, function(){
               $("#danger-alert").slideUp(1000);
                });   
 });
</script>

<div class="box box-primary" id="secondstep" >

           <div class="box-header with-border">
              <h3 class="box-title">Select Member For Enrollment To Device</h3>
            </div>

<!-- /.box-header -->
    <div class="box-body">  <h4><u></u></h4> 
     

                        




                  
                 
      
      </div>
    </div>   
  </div>
</section>

@endsection