@extends('layouts.adminLayout.admin_design')
@section('content')

<style type="text/css">
  td,th{
    margin: 7px; padding: 7px;"
    
    border-width: 2px;
     border:thin solid; 
     border-color: #ff851b;
  }
    .select2-selection__choice{
    background-color: #e4e4e4 !important;
    color: black !important;
  }
  tr{
    border-width: 3px;
    
       border:thin solid; 
          border-color: #ff851b;
  }
  hr { 
  display: block;
  margin-top: 0.5em;
  margin-bottom: 0.5em;
  margin-left: auto;
  margin-right: auto;
  border-style: inset;
  border-width: 1px;
}
  table{
     border-color: #ff851b;

  }
  .modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px) !important;
    overflow-y: auto  !important;
       overflow-x: auto  !important;
        overflow: auto !important;
}
.modal-open{
  overflow: auto !important;
}
.noBorder {

border-style: hidden;
    width: 100%;
    border-color: white !important;

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

</style>


<!-- left column -->
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Assign Diet Plan</h2> </section>
 -->          <!-- general form elements -->
           <section class="content ">
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
@if(session('success'))
 <div class="alert alert-success" role="alert">
   <button type="button" class="close" data-dismiss="alert">×</button> 
    <li>{{session('success')}}</li>
  </div>
@endif
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Assign Diet Plan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
            <form role="form" action="{{ url('memberdietassign') }}" method="post" id="assignexercise" >
            {{ csrf_field() }}
            <!-- text input -->
              <div class="form-group">
                <label>Member</label>
                @if(request()->route('id'))
                @php 
                $i=request()->route('id');
                @endphp
                @else
                 @php 
                 $i='';
                @endphp
                @endif
                <select name="member" id="member" class="form-control select2"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Member" required="">
                   <option value="" selected="" disabled="">Select Member</option>
                  @foreach($members as $member)

                  <option value="{{$member->memberid}}" {{$member->memberid == $i?'selected':''}}>{{$member->firstname}}  {{$member->lastname}}</option>
                  @endforeach
                </select>
              </div>
              <div  class="box" id="tableworkoutdisplay"  style="display: none">
                <div class="box-header"></div>
                <div class="box-body">
         <table id="tableworkout" class="noBorder" style="border-width: 0px;" width="100%">
            <thead>
        
            <th>Diet Plan</th>
            <th>Action</th>
            </thead>
            <tbody>
              <tr  class="txt" style="display: none">
               
                </tr>
            </tbody>
          </table>
                </div>
                
              </div>
               <div class="form-group">
                  <label>Package</label>
                   <select name="packageid" class="form-control span11 select2" id="packageid"  required>
                    
                    <option value="">Select Member Package</option>
                  </select>
                </div>
                 <div class="form-group">
                   <label>Tag</label>
                <select name="tags[]" id="tags" class="form-control span11 select2" data-placeholder="Select Multiple Tags" multiple=""  aria-hidden="true" >
                  
                  @foreach($tags as $tag)

               <option value="{{$tag->exerciselevelid}}">{{$tag->exerciselevel}}</option>
                  @endforeach
                </select>
              </div>

            <div class="form-group"> 

             <div class="col-sm-offset-3">
              <div class="col-sm-8">
                 <button name="submit" type="submit" class="btn bg-green margin">Assign</button>   <a href="{{ url('ExerciseplanView') }}"class="btn btn-danger">Cancel</a></div></div>
  
  </div>
                <!-- Select multiple-->
        

              </form>
            </div><div class="col-lg-3"></div></div>
            </div>
            <!-- /.box-body -->
          </div>
      
  </section>
</div>
</div>
</div>

  <div class="modal fade out" id="workoutmodal" role="dialog" style="overflow: auto!important;">
    <div class="modal-dialog  modal-dialog-scrollable">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
          <h4 class="modal-title">DietPlan Details</h4>
        </div>
        <div class="modal-body modal-content" style="overflow: auto!important;">
    
          <p id="text"></p>
           <table id="exercisehistory" class="table table-responsive" >
  <!-- <caption >Diet Plan On:<input type="text" name="" id="dietdate1"></caption> -->
  <tbody>
  <tr  class="workoutmember">
    <td></td>
    
    <th scope="col">Diet Plan Name</th>
    <th scope="col">Diet time</th>
    <th scope="col">Compulsary</th>
    <th scope="col">Remark</th>
    <th scope="col">Status</th>
    <!-- <th scope="col">Assigned On</th> -->
   
  </tr>
        
          
<!-- 
            <th>Day</th>
            <th>Diet Plan Name</th>
            <th>Diet time</th>
            
             <th>Compulsary</th>
              <th>Remark</th>

            <th>Status</th>
          </thead> -->
          
            <tr class="workoutmember">
              
            </tr>
          </tbody>
        </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

   <script>
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
<script type="text/javascript">
  $( document ).ready(function() {
    // alert($('#member').val());
    if($('#member').val() != '' && $('#member').val() != null){
      $('#member').trigger('change');
    }
    
  });
  
</script>
<script type="text/javascript">
  $('#member').on('change',function(){
     $('#packageid').find('option:not(:first)').remove();
      $('#tableworkoutdisplay').css('display','none');
     $("#tableworkout tbody tr:not(:first)").empty();
  var _token = $('input[name="_token"]').val();
      var member = $('#member').val();

  $.ajax({
                                   url:"{{ url('dietplanload') }}",
                                   method:"GET",
                                       data:{member:member, _token:_token},
                                 
                                  success:function(data) {
                                  // alert(data);
                                    if (data) {
                                      $('#tableworkoutdisplay').css('display','block');
                                    $("#tableworkout tbody tr:not(:first)").empty();
                                    
                                     
                                      $.each(data, function(i, item){
                                         // alert(item);
                                var  apnd='<tr class="txt"><td>'+item.diet_planname.dietplanname+'</td><td><a  id="view'+item.plannameid+'"onclick="view('+item.plannameid+','+item.memberid+')"><i class="fa fa-eye"></i></a></td></tr>';
                                       $('.txt:last').after(apnd); 

                                      });
                                    }
                                  },
                                   dataType:'json',

                              });


       $('#packageid').find('option:not(:first)').remove();
              $.ajax({
                                   url:"{{ url('dietpackageload') }}",
                                   method:"GET",
                                       data:{member:member, _token:_token},
                                 
                                  success:function(data) {
                                    // alert(data);
                                     
                                      $.each(data, function(i, item){
                                     
                                        $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(item.scheme.schemename));

                                      });
                                  },
                                  dataType:'json',

                              });
                          
        });
function view(plannameid,memberid){

// alert(workoutid);
// alert(memberid);
var _token = $('input[name="_token"]').val();
  $.ajax({
                                   url:"{{ url('dietmemberload') }}",
                                   method:"GET",
                                       data:{plannameid:plannameid,memberid:memberid, _token:_token},
                                 // <td> From:'item.diet_planname.fromdate+'</td><td>'item.diet_planname.todate+'</td>
                                  success:function(data) {
                                      // alert(data);
                                     $("#exercisehistory tbody tr:not(:first)").empty();
                                     $('#workoutmodal').modal('show');
                                    var seq1 = ''; 
                                    var seq2 = ''; 
                                   $.each(data, function(i, item){
                                    //alert(item.member_diet_plan);
                                    seq1=item.dietsequence;
                                    if (seq2!= item.dietsequence) {
                                      // console.log(item.created_at);
                                            var d = new Date(item.created_at);
                                           d1 = d.getDate();
                                        var day =  d.getDay();
                                        var month =  d.getMonth()+ Number(1);
                                        var year =  d.getFullYear();
                                           var  wrktm = '<tr class="workoutmember" style="border-bottom:3px;"><td colspan="3"> Name:  '+item.diet_planname.dietplanname+' </td><td colspan="5"> Assigned On :'+d1+'-'+month+'-'+year+' <br> From : ';if(item.fromdate){
                                              var d = new Date(item.fromdate);
                                              var d1 = d.getDate();
                                              var day =  d.getDay();
                                              var month =  d.getMonth()+ Number(1);
                                              var year =  d.getFullYear();
                                              var frdate=''+d1+'-'+month+'-'+year+'';
                                            wrktm+=frdate;
                                           }else{
                                               wrktm+='';
                                           }
                                            wrktm+='&nbsp; &nbsp; To : ';
                                            if(item.todate){
                                              var d = new Date(item.todate);
                                              var d1 = d.getDate();
                                              var day =  d.getDay();
                                              var month =  d.getMonth()+ Number(1);
                                              var year =  d.getFullYear();
                                              var tdate=''+d1+'-'+month+'-'+year+'';
                                            wrktm+=tdate;
                                           }else{
                                               wrktm+='';
                                           } 
                                           wrktm+=' </th></tr>';
                                      }
                                      else{
                                        wrktm = '';
                                      }
                                       wrktm +='<tr class="workoutmember" style="border-bottom:3px;"><th>';
                                         if (item.dietday==1) 
                                        wrktm+= ' Monday</th>';
                                        if (item.dietday==2) 
                                          wrktm+= ' Tuesday</th>';
                                         if (item.dietday==3) 
                                          wrktm+= ' Wednesday</th>';
                                         if (item.dietday==4) 
                                          wrktm+= ' Thursday</th>';
                                         if (item.dietday==5) 
                                          wrktm+= ' Friday</th>';
                                         if (item.dietday==6) 
                                          wrktm+= ' Saturday</th>';
                                        if (item.dietday==7) 
                                          wrktm+= ' Sunday</th>';
                                         wrktm+= '<th scope="row">'+item.meal_master.mealname+'</th>';
                                         if(item.diettime){
                                           wrktm+=' <td>'+item.diettime+'</td>';
                                         }
                                         else{
                                          wrktm+=' <td></td>';
                                         }
                                         
                                        if (item.compulsary==1) 
                                        wrktm+= ' <td>Yes</td><td>';
                                        else
                                          wrktm+= ' <td>No</td><td>';

                                       if(item.remark != null && item.remark !='')
                                        wrktm+= item.remark+' </td>';
                                        else
                                           wrktm+=' </td>';
                                       
                                        if (item.status==0) 
                                        wrktm+= ' <td>Inactive</td>';
                                        else
                                          wrktm+= ' <td>Active</td>';
                                        // wrktm+='<td>'+item.created_at+'</td></tr>';
                              
                                        
                                      seq2= item.dietsequence;
                                            $('.workoutmember:last').after(wrktm);

                                      });

                                  },
                                   dataType:'json',

                              });
}
</script>
<script type="text/javascript">
window.onkeyup = function(e) {
   var event = e.which || e.keyCode || 0; // .which with fallback

   if (event == 27) { // ESC Key
       $('#close').trigger('click'); // Navigate to URL
   }
}
</script>
<script type="text/javascript">
  $( "#assignexercise" ).submit(function( event ) {
    
      $('#tags').val();
      // alert($('#tags').val());
      if($('#tags').val()==''){
        $('#tags').find('option').each( function() {
           var $this = $(this);
            $this.attr('selected','selected');
        });
      }
 
});

</script>

@endsection