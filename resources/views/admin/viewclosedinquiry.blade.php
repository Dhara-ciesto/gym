  @extends('layouts.adminLayout.admin_design')
@section('content')
<!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>

<style type="text/css">
  .rating {
    float:left;
}
.table-bordered {
    border: 1px solid #f4f4f4;
}
.hide {
    display:none; 
}

/* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
   follow these rules. Every browser that supports :checked also supports :not(), so
   it doesn’t make the test unnecessarily selective */
.rating:not(:checked) > input {
    position:absolute;
    top:-9999px;
    clip:rect(0,0,0,0);
}

.rating:not(:checked) > label {
    float:right;
    width:1em;
    padding:0 .1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:200%;
    line-height:1.2;
    color:#ddd;
    text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:before {
    content: '★';
}

.rating > input:checked ~ label {
    color: #f70;
    text-shadow:1px 1px #c60, 2px 2px #940, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
    color: gold;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > input:checked + label:hover,
.rating > input:checked + label:hover ~ label,
.rating > input:checked ~ label:hover,
.rating > input:checked ~ label:hover ~ label,
.rating > label:hover ~ input:checked ~ label {
    color: #ea0;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > label:active {
    position:relative;
    top:2px;
    left:2px;
}

/* end of Lea's code */

/*
 * Clearfix from html5 boilerplate
 */

.clearfix:before,
.clearfix:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.clearfix:after {
    clear: both;
}

/*
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */

.clearfix {
    *zoom: 1;
}
.Add{
  color: #32BE24;
}
.call{
  color: #7758EE;
}
  .btn span.fa-check {              
    opacity: 0;             
}
.btn.active span.fa-check {             
    opacity: 1;             
}
.btn-app{
  width: 130px;
  height: 100px;
  padding: 29px 8px;
}



/* my stuff */
/*#status, button {
    margin: 20px 0;
}*/
</style>
  <div class="content-wrapper">
   @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
     
         <section class="content-header"><h2>Closed Inquiry</h2></section>
          <!-- general form elements -->
        <br>

<div class="container-fluid">
 <!--  <form class="form-inline" method="post" action="{{ url('inquiry') }}">
     {{ csrf_field() }}

    <div class="form-group">
      <div class="input-group date" style="max-width:180px" id="startdate">
        <label>Inquiry Date From</label>
        <input type="date" onkeypress="return false"  class="form-control" name="inquirydatefrom" placeholder="Inquiry Date"  @isset($query['fdate']) value="{{$query['fdate']}}"@endisset/>
      </div>
    </div>

    <div class="form-group">
      <div class="input-group date" style="max-width:180px" id="startdate">
        <label>Inquiry Date To</label>
        <input type="date" onkeypress="return false" class="form-control" name="inquirydateto" placeholder="Inquiry Date"  @isset($query['tdate']) value="{{$query['tdate']}}"@endisset/>
      </div>
    </div>

    <div class="form-group">
      <div class="input-group date" style="max-width:180px" id="enddate">
        <label>Follow Up From</label>
        <input type="date" onkeypress="return false" class="form-control"  name="followupdatefrom" placeholder="To Date"  @isset($query['ffromdate']) value="{{$query['ffromdate']}}"@endisset/> 
      </div>
    </div>

     <div class="form-group">
      <div class="input-group date" style="max-width:180px" id="enddate">
        <label>Follow Up To</label>
        <input type="date" onkeypress="return false" class="form-control" name="followupdateto" placeholder="To Date" @isset($query['ftodate']) value="{{$query['ftodate']}}"@endisset /> 
      </div>
    </div>
    <br/>

    <div class="form-group">
  
    
    <label for="user" class="sr-only">User Name</label>
    <select data-width="180px" name="firstname" class="form-control selectpicker"title="Select Username" data-live-search="true" id="username">

      <option value="">All</option>
     
    </select>
  </div>

  <div class="form-group">
  
    <label for="mobileno" class="sr-only">Mobile No.</label>
    <select data-width="180px" name="mobileno" class="form-control selectpicker" id="mobileno" title="Select Mobileno" data-live-search="true" > -->
    
<!--       <option value="" >All</option>
       
    </select>
  </div>

    <div class="form-group">
                
                 <select  class="form-control" name="hearabout"><option disabled="" selected>How did you hear about us ?</option>

           <option value="Fitness Five Member"@if(isset($query['hearabout'])) {{$query['hearabout'] == 'Fitness Five Member' ? 'selected':''}} @endif>Fitness Five Member</option>
 <option value="We Called Them" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'We Called Them' ? 'selected':''}} @endif>We Called Them</option>
               <option value="Friends/Family" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Friends/Family' ? 'selected':''}} @endif>Friends/Family</option>
                 <option value="Via Internet" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Via Internet' ? 'selected':''}} @endif>Via Internet</option>
                   <option value="Word Of Mouth" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Word Of Mouth' ? 'selected':''}} @endif>Word Of Mouth</option>
                   <option value="Radio Advertise" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Radio Advertise' ? 'selected':''}} @endif>Radio Advertise</option>
                   <option value="Magazine Advertise" @if(isset($query['hearabout'])) {{$query['hearabout'] == 'Magazine Advertise' ? 'selected':''}} @endif>Magazine Advertise</option>
                     <option value="Other" @if(isset($query['hearabout'])){{$query['hearabout'] == 'Other' ? 'selected':''}} @endif>Other</option>

                 </select>
                </div>
   <div class="form-group"> -->



   <!-- 
    <label class="sr-only" for="search">Quality</label>
    <select class="form-control" name="rating">
<option disabled="" selected>Select Quality</option>
      <option value="superhot" @if(isset($query['rating'])) {{$query['rating'] == 'superhot' ? 'selected':''}} @endif>Super Hot</option>
  <option value="hot" @if(isset($query['rating'])) {{$query['rating'] == 'hot' ? 'selected':''}} @endif>Hot</option>
      <option value="warm"@if(isset($query['rating'])) {{$query['rating'] == 'warm' ? 'selected':''}} @endif>Warm</option>
      <option value="cold"@if(isset($query['rating'])) {{$query['rating'] == 'cold' ? 'selected':''}} @endif>Cold</option>
      <option value="notinterested" @if(isset($query['rating'])) {{$query['rating'] == 'notinterested' ? 'selected':''}} @endif >Not Interested</option>
    </select>
  </div>
  <br>
  
   <div class="form-group">
    <button name="submit" type="submit" class="btn bg-orange margin">Search</button><a href="{{ url('inquiry') }}" class="btn bg-red">Clear</a>
  </div>

 

</form> -->

  <hr> 
  @if ($message = Session::get('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
    </div>
  @endif
   @if ($ermessage = Session::get('ermessage'))
  @if($ermessage=="Inquiry Already Exists")
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $ermessage }}</strong>
    </div>
  @endif
  @endif
 
<div class="table-wrapper">
  <div class="table-title">

       <div class="box container-fluid">
    <div class="box-header">
      <?php $permission = unserialize(session()->get('permission')); ?>
      @if(isset($permission["'add_inquiry'"]))
      <a href="{{ url('addinquiry') }}" class="btn add-new bg-orange"><i class="fa fa-plus"></i> Add New</a>
      @endif
      @if(isset($permission["'view_confirminquiry'"]))
      <a href="{{ url('viewconfirmedinquiry') }}" class="btn add-new bg-orange"><i class="fa fa-eye"></i> View Confirmed Inquiry</a>
      @endif
    <!--   <button id="getinquiryexcelreport" type="button" class="btn add-new bg-orange">Get Inquiry Excel</button> --> 
    <h3 class="box-title"></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      
          <table id="example123" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
                        <!-- <th>Created Date</th> -->
                        <th style="display:none;">ID</th>
                        <th>Inquiry Date</th>
                        <th>Name</th>
                        <th>Quality</th>
                        <th>Type</th>
                        <th>POC</th>
                        <th>Mobile No</th> 
           
                       <!--  <th>Last Call</th> -->
                       
                        
                    </tr>
                </thead>
                <tbody>
                  
                  @if($members)
                  <?php $i=0; ?> 
                 @foreach($members as $member)
                    <tr>
                        <td style="display: none;">{{$member->inquiriesid}}</td>
                        <td><span class='hide'>{{$member->createddate}}</span>{{ date('d-m-Y', strtotime($member->createddate))}}</td>
                        <td>
                          <span class="pull-left">
                                @if($member->gender == 'male')
                                  <i class="fa fa-male text-info" style="font-size: 18px;"></i>
                                @else
                                  <i class="fa fa-female text-danger" style="font-size: 18px;"></i>
                                @endif
                            </span>
                             &nbsp; &nbsp;{{ucwords($member->firstname)}} &nbsp; {{ucwords( $member->lastname )}} 
                         </td>
                        <td> {{ $member->rating }} </td>
                        <td> {{ $member->inquirytype }}</td>
                        <td> {{ $member->poc }}</td>
                        <td> {{ $member->mobileno }}</td>
                      

                        <!-- <td> {{$member->calldate}}</td> -->

                       
                       
                      
           
                        
                    </tr>
                    <?php $i++; ?>
              @endforeach
               </tbody>
            </table>
              <div class="datarender" style="text-align: center">
            {!! $members->render() !!}  </div>
            @else

              @endif
             
              
 
           
            
<!-- /.box-body -->
</div>
        </div>
 
      
   
    </div>

    </div>
  </div>

</div></div>
<script type="text/javascript">
   function asd(mid){

             $('#notofication').val(mid);

            var notificationid =  $('#notofication').val();

             $.ajax({  
                     
                     type:"GET",  
                    data: {"_token": "{{ csrf_token() }}","notificationid": notificationid},
                    url:'{{ URL::route("getnotification") }}', 
                    async:false,  
                     success:function(data){
                          // alert(data); 
                          $.each(data,function(i,item){
                            // alert(item.sms);
                            if (item.sms==1) 
                            {
                              $('#smscheck').attr('checked',true);                           
                            }
                            if (item.email==1) 
                            {
                              $('#emailcheck').attr('checked',true);                           
                            }
                            if (item.call==1) 
                            {
                              $('#callcheck').attr('checked',true);                           
                            }
                          });                         
                     },
                     dataType:'json',
                }); 

            // console.log(notificationid);

          }

</script>

 <script type="text/javascript">

                  function ss(){

             var ss=$('#notofication').val();

             if ($('#smscheck').is(':checked')) 
             {
              
              var smsck=$('#smscheck').val();
             }
             else
            {
                var smsck=0;

            }
            if ($('#emailcheck').is(':checked')) 
             {
             
              var emailck=$('#emailcheck').val();
            
             
             }
             else
            {
                var emailck=0;    
            }
              if ($('#callcheck').is(':checked')) 
             {
             
              var callck=$('#callcheck').val();
              location.reload();
            
             
             }
             else
            {
                var callck=0;
                location.reload();    
            }




               $.ajax({  
                     
                     type:"POST",  
                    data: {"_token": "{{ csrf_token() }}","mobileno": ss,"sms":smsck,"mail":emailck,"call":callck,},
                    url:'{{ URL::route("notificationstatus") }}',   
                     success:function(data){
                          
                          
                     }  
                }); 
  
                }
                </script>




 <script type="text/javascript">
    function sms(){

             if($('#sms').is(":checked")){

             var sms = $('#sms').val();
           
           }
              }

          function smscheck(){
            
            $('#smscheck').trigger('click');



            $('#asd').click(function(){
          
           var sms = $('#smscheck').val();   

               
                

        }); 
            
          }

           function emailcheck(){
 
            $('#emailcheck').trigger('click');
          }


           function callcheck(){
           
                      $('#callcheck').trigger('click');
                    }
                           
</script>



<script type="text/javascript">
  $(document).ready(function(){
var truefalse='';

var followupdatefrom = '<?php  if(!empty($followupdatefrom)) {echo $followupdatefrom;} ?>';
var inquirydatefrom = '<?php  if(!empty($inquirydatefrom)) {echo $inquirydatefrom;} ?>';
var followupdateto = '<?php  if(!empty($followupdateto)) {echo $followupdateto;} ?>';
var firstname_select = '<?php  if(!empty($firstname_select)) {echo $firstname_select;} ?>';
var mobileno = '<?php  if(!empty($mobileno)) {echo $mobileno;} ?>';
var hearabout = '<?php  if(!empty($hearabout)) {echo $hearabout;} ?>';
var quality = '<?php  if(!empty($quality)) {echo $quality;} ?>';

// alert(firstname_select);
if(followupdatefrom !=''|| inquirydatefrom !='' || followupdateto !='' || firstname_select !='' ||
mobileno !='' || hearabout !=''|| quality !='' ){
truefalse=false;
}
else{
truefalse=true;
}
// alert(truefalse);
 
      $('#example1').DataTable({
 "paging": truefalse,
   "order": [[ 0, "Desc" ]], //or asc 
    "columnDefs" : [{"targets":3, "type":"date-eu"}],
 language: { search: '', searchPlaceholder: "Search..." },
  "searching": false,
});
       
   });

    $("#ratingForm").change(function(e) 
    {
        e.preventDefault(); // prevent the default click action from being performed
        if ($("#ratingForm :radio:checked").length == 0) {
            $('#status').html("nothing checked");
            return false;
        } else {
          
            $('#status').html( 'You Rated ' + $('input:radio[name=rating]:checked').val() );
        }
    });

</script>
<script type="text/javascript">
  $(function () {
    $('.date').datetimepicker({format: 'DD/MM/YYYY',useCurrent: 'day'});
  });
</script>

<script type="text/javascript">
    $(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
</script>
<script type="text/javascript">
  $('#getinquiryexcelreport').on('click',function(){
            $.ajax({
                                        url:"{{ url('getinquiryexcelreport') }}",
                                        method:"POST",
                                        data:{"_token": "{{ csrf_token() }}"},
                                      success: function (response, textStatus, request) {
                                      var a = document.createElement("a");
                                      a.href = response.file; 
                                      a.download = response.name;
                                      document.body.appendChild(a);
                                      a.click();
                                      a.remove();
                                      },
                        
                                        dataType:'json',

                                        });
  });
</script>
@endsection
