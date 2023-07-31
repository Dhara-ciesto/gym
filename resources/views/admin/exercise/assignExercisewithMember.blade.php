@extends('layouts.adminLayout.admin_design')
@section('content')


 <div class="content-wrapper">
   <style type="text/css">

    .li{
   /*width: 15%;*/
   padding-left: 15px;
    padding-right: 15px;
  }
  td,th{
    margin: 15px; padding: 10px;"
  }
 .select2-selection__choice{
    background-color: #e4e4e4 !important;
    color: black !important;
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
.nav-tabs-custom{
  box-shadow: none !important;
  }
</style>

         <section class="content-header"><h2></h2></section>
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

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Assign WorkOut 1</h3>
            </div>
            <!-- /.box-header -->
             <div class="box-body">

              <form action="{{url('assignExercisetoMember')}}" method="post" name="formtab" id="formtab">
                {{csrf_field()}}
              <div class="col-lg-12" style="text-align: left;">
    <div class="col-lg-4">
                <div class="form-group" >
                  <label> Member </label>
                    <input class="form-control"  type="text" name="membername" value="{{$memberdisplay->firstname}} {{$memberdisplay->lastname}}" readonly="">
                  </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                  <label>Tags</label>

                  <select style="color: 000 !important;" class="form-control select2" multiple="" data-placeholder="Select a Tags" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="exerciselevel[]" required="" id="tagsid">

                  @foreach($tags as $tag)
                  <option value="{{$tag->exerciselevelid}}" selected>{{$tag->exerciselevel}}</option>
                  @endforeach
                  </select>
                </div>
                <input type="hidden" name="member" value="{{$member}}">
                <input type="hidden" name="package" value="{{$package}}">

              </div>
                <div class="col-lg-4">

                    <div class="form-group">
                  <label>WorkOut</label>
                  <select class="form-control select2" name="workout" id="workout">
                      @foreach($workout as $wkt)
                  <option value="{{$wkt->workoutid}}">{{$wkt->workoutname}}</option>
                  @endforeach
                  </select>

                <!--  <input type="text" name="workout" class="form-control" placeholder="WorkOut Name" required=""> -->

                </div>
                </div>

            <div class="col-md-3">
                  <div class="l"><button type="button" style="margin-top: 23px;"class="btn btn bg-green" name="plan" id="plan" value="plan">Assign</button>
                  <button type="submit">Save</button>
                  </div>
                </div>

                </div>



              <br>
            <div class="col-md-12 exercise" style="display:none;overflow: auto;">
          <div class="nav-tabs-custom">
            <input type="hidden"  id="headeryes" name="headeryes">
            <ul class="nav nav-tabs">
              <li class="li active"><a href="#day1" data-toggle="tab" aria-expanded="true"onclick="change(2)">Monday</a></li>
              <li class="li"><a href="#day2" data-toggle="tab" aria-expanded="false"onclick="change(3)">Tuesday</a></li>
              <li class="li"><a href="#day3" data-toggle="tab" aria-expanded="false"onclick="change(4)">Wednesday</a></li>
              <li class="li"><a href="#day4" data-toggle="tab" aria-expanded="false"onclick="change(5)">Thrusday</a></li>
              <li class="li"><a href="#day5" data-toggle="tab" aria-expanded="false"onclick="change(6)">Friday</a></li>
              <li class="li"><a href="#day6" data-toggle="tab" aria-expanded="false"onclick="change(7)">Saturday</a></li>
<!--               <li class="li"><a href="#day7" data-toggle="tab" aria-expanded="false"onclick="change(8)">Sunday</a></li>
 -->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="day1">
                <!-- Post -->

                <!-- tab1 -->
                <table id="tab1">
                  <thead>
                    <th></th>
                    <th>Header </th>
                    <th>Exercise</th>
                    <th>Time</th>
                    <th>Set </th>
                    <th>Rep (15*12*10)</th>


                    <th>Instruction</th>
                                 <th></th>

                  </thead>
                  <tbody id="tb1" class="tbodyid">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab1mycount" id="mycounttab1">
                      <input type="hidden" name="tab1exerciselevelday" value="1">

                       <tr id="tab1firsttr1" class="tab1item">
                        </tr>

        </tbody>

              </table>
       <!--    <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-6">
                   <div class="form-group" style="text-align: right">
                  <button type="button"id="add1" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group"  style="text-align: left">
                  <div class="col-lg-1 tab1rmvitem" style="margin-top: -990px;">

            </div>
                </div>
                </div>

              </div> -->
                 <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-4"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" >
                      <button type="button" class="btn bg-teal addheader2" onclick="addwithheader(1)"><i class="fa fa-plus">Add Header</i></button>
                    </div>
                  </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab1rmvitem" >

                </div>
                </div>
                </div>
                <div class="col-lg-4"></div>

              </div>

              </div>


              <!-- /.tab-pane -->

<!--***********************************tab2************************************************ -->
                  <div class="tab-pane" id="day2">
                    <!-- tab2 -->
                <table id="tab2">
                  <thead>
                    <th> </th>
                    <th>Header </th>
                    <th>Exercise</th>
                    <th>Time</th>
                    <th>Set </th>
                    <th>Rep (15*12*10)</th>

                    <th>Instruction</th>
                                              <th></th>

                  </thead>
                  <tbody id="tb2">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab2mycount" id="mycounttab2">
                      <input type="hidden" name="tab2exerciselevelday" value="2">
                    <tr id="tab2firsttr1" class="tab2item">


              </tr>
        </tbody>

              </table>
                    <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-4"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab2" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" >
                      <button type="button" class="btn bg-teal addheader2" onclick="addwithheader(2)"><i class="fa fa-plus">Add Header</i></button>
                    </div>
                  </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab2rmvitem" >

            </div>
                </div>
                </div>
                <div class="col-lg-4"></div>

              </div>

              </div>

              <!-- /.tab-pane -->
<!--***********************************tab2************************************************ -->
              <div class="tab-pane" id="day3">
            <!-- tab3 -->
             <table id="tab3">
                  <thead>
                  <th> </th>
                  <th>Header </th>
                      <th>Exercise</th>
                    <th>Time</th>
                    <th>Set </th>
                      <th>Rep (15*12*10)</th>

                    <th>Instruction</th>                                 <th></th>

                  </thead>
                  <tbody id="tb3">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab3mycount" id="mycounttab3">
                      <input type="hidden" name="tab3exerciselevelday" value="3">
                    <tr id="tab3firsttr1" class="tab3item">


              </tr>
        </tbody>

              </table>
      <!--     <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-6">
                   <div class="form-group" style="text-align: right">
                  <button type="button"id="add1" class="btn bg-green addtab3" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group"  style="text-align: left">
                  <div class="col-lg-1 tab3rmvitem" style="margin-top: -990px;">

            </div>
                </div>
                </div>

              </div> -->
                    <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-4"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab3" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" >
                      <button type="button" class="btn bg-teal addheader2" onclick="addwithheader(3)"><i class="fa fa-plus">Add Header</i></button>
                    </div>
                  </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab3rmvitem" >

            </div>
                </div>
                </div>
                <div class="col-lg-4"></div>

              </div>
              </div>
              <!-- /.tab-pane -->

<!--***********************************tab4************************************************ -->
              <div class="tab-pane" id="day4">
            <!-- tab4 -->
             <table id="tab4">
                  <thead>
                    <th></th>
                    <th>Header </th>
                    <th>Exercise</th>
                    <th>Time</th>
                    <th>Set </th>
                    <th>Rep (15*12*10)</th>

                    <th>Instruction</th>                                 <th></th>


                  </thead>
                  <tbody id="tb4">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab4mycount" id="mycounttab4">
                      <input type="hidden" name="tab4exerciselevelday" value="4">
                    <tr id="tab4firsttr1" class="tab4item">

              </tr>
        </tbody>

              </table>
              <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-4"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab4" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" >
                      <button type="button" class="btn bg-teal addheader2" onclick="addwithheader(4)"><i class="fa fa-plus">Add Header</i></button>
                    </div>
                  </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab4rmvitem" >

            </div>
                </div>
                </div>
                <div class="col-lg-4"></div>

              </div>
              </div>

<!--***********************************tab2************************************************ -->
  <div class="tab-pane" id="day5">
            <!-- tab5 -->
             <table id="tab5">
                  <thead>
                    <th> </th>
                    <th>Header </th>
                    <th>Exercise</th>
                    <th>Time</th>
                    <th>Set </th>
                    <th>Rep (15*12*10)</th>

                    <th>Instruction</th>                                 <th></th>



                  </thead>
                  <tbody id="tb5">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab5mycount" id="mycounttab5">
                      <input type="hidden" name="tab5exerciselevelday" value="5">
                    <tr id="tab5firsttr1" class="tab5item">



              </tr>
        </tbody>

              </table>
        <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-4"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab5" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab5rmvitem" >

                </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" >
                      <button type="button" class="btn bg-teal addheader2" onclick="addwithheader(5)"><i class="fa fa-plus">Add Header</i></button>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4"></div>

              </div>
              </div>



<!--***********************************tab2************************************************ -->
<div class="tab-pane" id="day6">
            <!-- tab6 -->
             <table id="tab6">
                  <thead>
                    <th> </th>
                    <th>Header </th>
                    <th>Exercise</th>
                    <th>Time</th>
                    <th>Set</th>
                    <th>Rep (15*12*10)</th>

                    <th>Instruction</th>
                    <th></th>

                  </thead>
                  <tbody id="tb6">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab6mycount" id="mycounttab6">
                      <input type="hidden" name="tab6exerciselevelday" value="6">
                    <tr id="tab6firsttr1" class="tab6item">




              </tr>
        </tbody>

              </table>
       <!--    <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-6">
                   <div class="form-group" style="text-align: right">
                  <button type="button"id="add1" class="btn bg-green addtab6" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group"  style="text-align: left">
                  <div class="col-lg-1 tab6rmvitem" style="margin-top: -990px;">

            </div>
                </div>
                </div>

              </div> -->
                    <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-4"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab6" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" >
                      <button type="button" class="btn bg-teal addheader2" onclick="addwithheader(6)"><i class="fa fa-plus">Add Header</i></button>
                    </div>
                  </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab6rmvitem" >

            </div>
                </div>
                </div>
                <div class="col-lg-4"></div>

              </div>
              </div>

<!--***********************************tab2************************************************ -->
<div class="tab-pane" id="day7">
            <!-- tab7 -->
             <table id="tab7">
                  <thead>
                    <th> </th>
                    <th>Header </th>
                    <th>Exercise</th>
                    <th>Time</th>
                    <th>Set </th>
                    <th>Rep (15*12*10)</th>

                    <th>Instruction</th>
                                              <th></th>

                  </thead>
                  <tbody id="tb7">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab7mycount" id="mycounttab7">
                      <input type="hidden" name="tab7exerciselevelday" value="7">
                    <tr id="tab7firsttr1" class="tab7item">


              </tr>
        </tbody>

              </table>
              <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-4"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab7" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" >
                      <button type="button" class="btn bg-teal addheader2" onclick="addwithheader(7)"><i class="fa fa-plus">Add Header</i></button>
                    </div>
                  </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab7rmvitem" >

            </div>
                </div>
                </div>
                <div class="col-lg-4"></div>

              </div>
              </div>

<!--***********************************tab2************************************************ -->
            </div>
          <div class="col-lg-12 box"> <center>
            <br><br>
                <div class="form-group">
                    <input type="button" name="day1btn" id="day1btn" class="btn bg-green " value="Tuesday">
                   <input type="button" name="day2btn" id="day2btn" class="btn bg-green " style="display: none;" value="Wednesday">
                   <input type="button" name="day3btn" id="day3btn" class="btn bg-green "style="display: none;" value="Thrusday">
                   <input type="button" name="day4btn"  id="day4btn" class="btn bg-green " style="display: none;" value="Friday">
                    <input type="button" name="day5btn"  id="day5btn" class="btn bg-green "style="display: none;" value="Saturday">
<!--                      <input type="button" name="day6btn"  id="day6btn" class="btn bg-green "style="display: none;" value="Sunday">
 -->                  <input type="submit" name="submit" id="day7btn" class="btn bg-green"style="display: none;">
                </div>
                </center>
              </form>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
       </div>
     </div>

  </section>
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

      for(var i=1;i<=7;i++){
          eval('var ' + 'countheader' + i + '= 0 ;');
      }

function addwithheader(tab){
    $('#headeryes').val(1);
    $(".addtab"+tab+':last').trigger('click');
}

  $(document).ready(function(){
// **********************************fottab1*********************************
var counttab1=1;

      $(document).on("click",'.addtab1',function(){
// alert(countheader1);
          var mycount = $(this).val();
          //     if ($("#mycounttab1").val()!='')
          // {
          //   counttab1= $("#mycounttab1").val();
          //
          // }

          counttab1++;

          var ap = '';
          if ($("#headeryes").val()==1)
          {
              countheader1++;
              ap += '<tbody id="tbody1'+countheader1+'" >';
          }
          ap+='<tr id="tab1firsttr'+counttab1+'" class="tab1item">';
          if ($("#headeryes").val()==1)
          {
              ap+='<td><div class="form-group"><button type="button" id="add1" value="'+countheader1+'" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button></div></td><td><div class="form-group"><input type="text" name="tab1header'+counttab1+'" class="form-control header"  id="tab1header'+counttab1+'" placeholder="Enter Header"></div></td>';

          }else{
              ap+='<td></td><td></td>';
          }
          // $("#headeryes").val(0);
          ap+='<td><div class="form-group"><select class="form-control exercisename" name="tab1exercisename'+counttab1+'"><option value="" disabled="" selected="">Please select<option><?php foreach($exercise as $exercisetab1)
          {
              echo '<option value="'.$exercisetab1->exerciseid.'">'.$exercisetab1->exercisename.'</option> ';
          }
              ?>
              </select></div></td><td><div class="form-group"><input type="text" name="tab1time'+counttab1+'" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab1set'+counttab1+'" class="form-control "></div></td><td><div class="form-group"><input id="tab1rep'+counttab1+'"type="text" name="tab1rep'+counttab1+'" class="form-control number exerciseset"></div></td><td><div class="form-group"><input type="text" name="tab1instruction'+counttab1+'" class="form-control"></div></td><td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab1('+counttab1+')" ><i class="fa fa-minus"></i></button></td></tr>';
          if ($("#headeryes").val()==1)
          {
              ap +='</tbody>';
              $('#tbody1'+(countheader1-1)).after(ap);
              $("#headeryes").val(0);
          }else{
              $('#tbody1'+mycount).append(ap);
          }

          // $('.tab1item:last').after(ap);

          // var rmv = '<div id="tab1rmvbtn'+counttab1+'"></div>';

          count2 = counttab1-1;
          // alert(counttab1);
          $("#tab1rmvbtn"+count2).hide();

          // $(".tab1rmvitem:last").after(rmv);

          $("#mycounttab1").val(counttab1);
          // var count2 = counttab1-1;

          // $("#firstremove"+count2).hide();
          // $(".remove:last").after(rmv);

          // $("#mycount").val(counttab1);
          $("#tab1rep"+counttab1).keypress(function(e){
              var keyCode = e.which;
              /*
              8 - (backspace)
              32 - (space)
              48-57 - (0-9)Numbers
              */
              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          //    $('input[name="tab1set'+counttab1+'"').keypress(function(e){
          //   var keyCode = e.which;

          //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
          //     return false;
          //   }
          // });
          $('input[name="tab1time'+counttab1+'"').keypress(function(e){
              var keyCode = e.which;

              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          $('.exercisename').select2()
      });

          });
        function removetab1(counttab1)
      {
        // alert(counttab1);

        $('#tab1firsttr'+counttab1).remove();
        $('#tab1rmvbtn'+counttab1).remove();


        var count3 = counttab1-1;
        $("#tab1rmvbtn"+count3).show();
        $("#mycounttab1").val(count3);

      }


// ******************************fortab1******************************
</script>
<script type="text/javascript">
  $(document).ready(function(){
// **********************************fottab2*********************************
var counttab2=1;

      $(document).on("click",'.addtab2',function(){

          var mycount = $(this).val();
          //     if ($("#mycounttab2").val()!='')
          // {
          //   counttab2= $("#mycounttab2").val();
          //
          // }


          counttab2++;
          var mycount = $(this).val();
          var ap = '';
          if ($("#headeryes").val()==1)
          {
              countheader2++;
              ap += '<tbody id="tbody2'+countheader2+'" >';
          }
          ap +='<tr id="tab2firsttr'+counttab2+'" class="tab2item">';
          if ($("#headeryes").val()==1)
          {
              ap+='<td><div class="form-group"> <button type="button" id="add1" value="'+countheader2+'" class="btn bg-green addtab2" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab2header'+counttab2+'" class="form-control header"  id="tab2header'+counttab2+'" placeholder="Enter Header"></div></td>';

          }else{
              ap+='<td></td><td></td>';
          }

          ap+='<td><div class="form-group"><select class="form-control select2"  data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" data-live-search="true"  name="tab2exercisename'+counttab2+'"><option value="" disabled="" selected="">Please select</option><?php foreach($exercise as $exercisetab2)
              {
                  echo '<option value="'.$exercisetab2->exerciseid.'">'.$exercisetab2->exercisename.'</option> ';
              }
                  ?>
                  </select></div></td><td><div class="form-group"><input type="text" name="tab2time'+counttab2+'" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab2set'+counttab2+'" class="form-control number"></div></td><td><div class="form-group"><input id="tab2rep'+counttab2+'"type="text" name="tab2rep'+counttab2+'" class="form-control number exerciseset"></div></td> <td><div class="form-group"><input type="text" name="tab2instruction'+counttab2+'" class="form-control"></div></td>' +
              '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab2('+counttab2+')" ><i class="fa fa-minus"></i></button></td></tr>';

          if ($("#headeryes").val()==1)
          {
              ap +='</tbody>';
              $('#tbody2'+(countheader2-1)).after(ap);
              $("#headeryes").val(0);
          }else{
              $('#tbody2'+mycount).append(ap);
          }

          // $('.tab2item:last').after(ap);
          $('.select2').select2()

          // var rmv = '<div id="tab2rmvbtn'+counttab2+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab2('+counttab2+')" ><i class="fa fa-close">Remove</i></button></div>';

          count2 = counttab2-1;
          // alert(counttab2);
          $("#tab2rmvbtn"+count2).hide();

          // $(".tab2rmvitem:last").after(rmv);

          $("#mycounttab2").val(counttab2);
          // var count2 = counttab1-1;

          // $("#firstremove"+count2).hide();
          // $(".remove:last").after(rmv);

          // $("#mycount").val(counttab1);
          $("#tab2rep"+counttab2).keypress(function(e){
              var keyCode = e.which;
              /*
              8 - (backspace)
              32 - (space)
              48-57 - (0-9)Numbers
              */
              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          //   $('input[name="tab2set'+counttab2+'"').keypress(function(e){
          //   var keyCode = e.which;

          //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
          //     return false;
          //   }
          // });
          $('input[name="tab2time'+counttab2+'"').keypress(function(e){
              var keyCode = e.which;

              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
      });

          });
        function removetab2(counttab2)
      {
        // alert(counttab2);

        $('#tab2firsttr'+counttab2).remove();
        $('#tab2rmvbtn'+counttab2).remove();


        var count3 = counttab2-1;
        $("#tab2rmvbtn"+count3).show();
        $("#mycounttab2").val(count3);

      }

</script>
<!-- *******************************************tab3******************************** -->
<script type="text/javascript">
  $(document).ready(function(){
// **********************************fottab2*********************************
var counttab3=1;

      $(document).on("click",'.addtab3',function(){

          var mycount = $(this).val();
          //     if ($("#mycounttab3").val()!='')
          // {
          //   counttab2= $("#mycounttab3").val();
          //
          // }

          counttab3++;

          var ap = '';
          if ($("#headeryes").val()==1)
          {
              countheader3++;
              ap += '<tbody id="tbody3'+countheader3+'" >';
          }
          ap +='<tr id="tab3firsttr'+counttab3+'" class="tab3item">';
          if ($("#headeryes").val()==1)
          {
              ap+='<td><div class="form-group" ><button type="button" value="'+countheader3+'" id="add1" class="btn bg-green addtab3" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab3header'+counttab3+'" class="form-control header"  id="tab3header'+counttab3+'" placeholder="Enter Header"></div></td>';

          }else{
              ap+='<td></td>';
          }
          // $("#headeryes").val(0);
          ap+='<td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  data-live-search="true"  name="tab3exercisename'+counttab3+'"><option value="" disabled="" selected="">Please select</option>         <?php foreach($exercise as $exercisetab3)
              {
                  echo '<option value="'.$exercisetab3->exerciseid.'">'.$exercisetab3->exercisename.'</option> ';
              }
                  ?>
                  </select></div></td><td><div class="form-group"><input type="text" name="tab3time'+counttab3+'" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab3set'+counttab3+'" class="form-control number"></div></td><td><div class="form-group"><input id="tab3rep'+counttab3+'"type="text" name="tab3rep'+counttab3+'" class="form-control number exerciseset"></div></td> <td><div class="form-group"><input type="text" name="tab3instruction'+counttab3+'" class="form-control"></div></td>' +
              '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab3('+counttab3+')" ><i class="fa fa-minus"></i></button></td></tr>';

          if ($("#headeryes").val()==1)
          {
              ap +='</tbody>';
              $('#tbody3'+(countheader3-1)).after(ap);
              $("#headeryes").val(0);
          }else{
              $('#tbody3'+mycount).append(ap);
          }

          // $('.tab3item:last').after(ap);
          $('.select2').select2()


          var rmv = '<div id="tab3rmvbtn'+counttab3+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab3('+counttab3+')" ><i class="fa fa-close">Remove</i></button></div>';

          count2 = counttab3-1;
          // alert(counttab3);
          $("#tab3rmvbtn"+count2).hide();

          // $(".tab3rmvitem:last").after(rmv);

          $("#mycounttab3").val(counttab3);
          // var count2 = counttab1-1;

          // $("#firstremove"+count2).hide();
          // $(".remove:last").after(rmv);

          // $("#mycount").val(counttab1);
          $("#tab3rep"+counttab2).keypress(function(e){
              var keyCode = e.which;
              /*
              8 - (backspace)
              32 - (space)
              48-57 - (0-9)Numbers
              */
              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          //  $('input[name="tab3set'+counttab3+'"').keypress(function(e){
          //   var keyCode = e.which;

          //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
          //     return false;
          //   }
          // });
          $('input[name="tab3time'+counttab3+'"').keypress(function(e){
              var keyCode = e.which;

              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
      });

          });
        function removetab3(counttab3)
      {
        // alert(counttab3);

        $('#tab3firsttr'+counttab3).remove();
        $('#tab3rmvbtn'+counttab3).remove();


        var count3 = counttab3-1;
        $("#tab3rmvbtn"+count3).show();
        $("#mycounttab3").val(count3);

      }

</script>
<!-- **********************************************************tab4************************ -->
<script type="text/javascript">
  $(document).ready(function(){
// **********************************fottab2*********************************
var counttab4=1;

      $(document).on("click",'.addtab4',function(){

          var mycount = $(this).val();
          //     if ($("#mycounttab4").val()!='')
          // {
          //   counttab4= $("#mycounttab4").val();
          //
          // }

          counttab4++;
          var ap = '';
          if ($("#headeryes").val()==1)
          {
              countheader4++;
              ap += '<tbody id="tbody4'+countheader4+'" >';
          }
          ap +='<tr id="tab4firsttr'+counttab4+'" class="tab4item">';
          if ($("#headeryes").val()==1)
          {
              ap+='<td><button type="button" value="'+countheader4+'" id="add1" class="btn bg-green addtab4" ><i class="fa fa-plus">Add</i></button></td><td><div class="form-group"><input type="text" name="tab4header'+counttab4+'" class="form-control header"  id="tab4header'+counttab4+'" placeholder="Enter Header"></div></td>';

          }else{
              ap+='<td></td><td></td>';
          }
          // $("#headeryes").val(0);
          ap+='<td><div class="form-group"><select class="form-control select2"  data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" data-live-search="true"  name="tab4exercisename'+counttab4+'"><option value="" disabled="" selected="">Please select</option>         <?php foreach($exercise as $exercisetab4)
              {
                  echo '<option value="'.$exercisetab4->exerciseid.'">'.$exercisetab4->exercisename.'</option> ';
              }
                  ?>
                  </select></div></td><td><div class="form-group"><input type="text" name="tab4time'+counttab4+'" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab4set'+counttab4+'" class="form-control number"></div></td><td><div class="form-group"><input id="tab4rep'+counttab4+'"type="text" name="tab4rep'+counttab4+'" class="form-control  exerciseset"></div></td> <td><div class="form-group"><input type="text" name="tab4instruction'+counttab4+'" class="form-control"></div></td>' +
              '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab4('+counttab4+')" ><i class="fa fa-minus"></i></button></td></tr>';

          if ($("#headeryes").val()==1)
          {
              ap +='</tbody>';
              $('#tbody4'+(countheader4-1)).after(ap);
              $("#headeryes").val(0);
          }else{
              $('#tbody4'+mycount).append(ap);
          }
          // $('.tab4item:last').after(ap);
          $('.select2').select2()

          // var rmv = '<div id="tab4rmvbtn'+counttab4+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab4('+counttab4+')" ><i class="fa fa-close">Remove</i></button></div>';

          count2 = counttab4-1;
          // alert(counttab4);
          $("#tab4rmvbtn"+count2).hide();

          // $(".tab4rmvitem:last").after(rmv);

          $("#mycounttab4").val(counttab4);
          // var count2 = counttab1-1;

          // $("#firstremove"+count2).hide();
          // $(".remove:last").after(rmv);

          // $("#mycount").val(counttab1);
          $("#tab4rep"+counttab4).keypress(function(e){
              var keyCode = e.which;
              /*
              8 - (backspace)
              32 - (space)
              48-57 - (0-9)Numbers
              */
              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          //  $('input[name="tab4set'+counttab4+'"').keypress(function(e){
          //   var keyCode = e.which;

          //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
          //     return false;
          //   }
          // });
          $('input[name="tab4time'+counttab4+'"').keypress(function(e){
              var keyCode = e.which;

              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
      });

          });
        function removetab4(counttab4)
      {
        // alert(counttab4);

        $('#tab4firsttr'+counttab4).remove();
        $('#tab4rmvbtn'+counttab4).remove();


        var count3 = counttab4-1;
        $("#tab4rmvbtn"+count3).show();
        $("#mycounttab4").val(count3);

      }

</script>
<!-- ********************************tab5***************************************** -->
<script type="text/javascript">
  $(document).ready(function(){
// **********************************fottab5*********************************
var counttab5=1;

      $(document).on("click",'.addtab5',function(){

          var mycount = $(this).val();
          //     if ($("#mycounttab5").val()!='')
          // {
          //   counttab5= $("#mycounttab5").val();
          //
          // }

          counttab5++;
          var ap = '';
          if ($("#headeryes").val()==1)
          {
              countheader5++;
              ap += '<tbody id="tbody5'+countheader5+'" >';
          }
          ap +='<tr id="tab5firsttr'+counttab5+'" class="tab5item">';
          if ($("#headeryes").val()==1)
          {
              ap+='<td> <div class="form-group" ><button type="button" value="'+countheader5+'" id="add1" class="btn bg-green addtab5" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab5header'+counttab5+'" class="form-control header"  id="tab5header'+counttab5+'" placeholder="Enter Header"></div></td>';

          }else{
              ap+='<td></td><td></td>';
          }
          // $("#headeryes").val(0);
          ap+='<td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  data-live-search="true"  name="tab5exercisename'+counttab5+'"><option value="" disabled="" selected="">Please select</option>         <?php foreach($exercise as $exercisetab5)
              {
                  echo '<option value="'.$exercisetab5->exerciseid.'">'.$exercisetab5->exercisename.'</option> ';
              }
                  ?>
                  </select></div></td><td><div class="form-group"><input type="text" name="tab5time'+counttab5+'" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab5set'+counttab5+'" class="form-control number"></div></td><td><div class="form-group"><input id="tab5rep'+counttab5+'"type="text" name="tab5rep'+counttab5+'" class="form-control number exerciseset"></div></td> <td><div class="form-group"><input type="text" name="tab5instruction'+counttab5+'" class="form-control"></div></td>' +
              '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab5('+counttab5+')" ><i class="fa fa-minus"></i></button></td></tr>';

          if ($("#headeryes").val()==1)
          {
              ap +='</tbody>';
              $('#tbody5'+(countheader5-1)).after(ap);
              $("#headeryes").val(0);
          }else{
              $('#tbody5'+mycount).append(ap);
          }
          // $('.tab5item:last').after(ap);
          $('.select2').select2()

          var rmv = '<div id="tab5rmvbtn'+counttab5+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab5('+counttab5+')" ><i class="fa fa-close">Remove</i></button></div>';

          count2 = counttab5-1;
          // alert(counttab5);
          $("#tab5rmvbtn"+count2).hide();

          // $(".tab5rmvitem:last").after(rmv);

          $("#mycounttab5").val(counttab5);

          $("#tab5rep"+counttab5).keypress(function(e){
              var keyCode = e.which;
              /*
              8 - (backspace)
              32 - (space)
              48-57 - (0-9)Numbers
              */
              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          //  $('input[name="tab5set'+counttab5+'"').keypress(function(e){
          //   var keyCode = e.which;

          //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
          //     return false;
          //   }
          // });
          $('input[name="tab5time'+counttab5+'"').keypress(function(e){
              var keyCode = e.which;

              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
      });

          });
        function removetab5(counttab5)
      {
        // alert(counttab5);

        $('#tab2firsttr'+counttab5).remove();
        $('#tab2rmvbtn'+counttab5).remove();


        var count3 = counttab5-1;
        $("#tab5rmvbtn"+count3).show();
        $("#mycounttab5").val(count3);

      }

</script>
<!-- *************************************tab6******************************************* -->
<script type="text/javascript">
  $(document).ready(function(){
// **********************************fottab6*********************************
var counttab6=1;

      $(document).on("click",'.addtab6',function(){

          var mycount = $(this).val();
          //     if ($("#mycounttab6").val()!='')
          // {
          //   counttab6= $("#mycounttab6").val();
          //
          // }

          counttab6++;
          var ap = '';
          if ($("#headeryes").val()==1)
          {
              countheader6++;
              ap += '<tbody id="tbody6'+countheader6+'" >';
          }
          ap +='<tr id="tab6firsttr'+counttab6+'" class="tab6item">';
          if ($("#headeryes").val()==1)
          {
              ap+='<td><div class="form-group" > <button type="button" value="'+countheader6+'" id="add1" class="btn bg-green addtab6" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab6header'+counttab6+'" class="form-control header"  id="tab6header'+counttab6+'" placeholder="Enter Header"></div></td>';

          }else{
              ap+='<td></td><td></td>';
          }
          // $("#headeryes").val(0);
          ap+=' <td><div class="form-group"><select class="form-control select2"  data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" data-live-search="true"  name="tab6exercisename'+counttab6+'"><option value="" disabled="" selected="">Please select</option>         <?php foreach($exercise as $exercisetab6)
              {
                  echo '<option value="'.$exercisetab6->exerciseid.'">'.$exercisetab6->exercisename.'</option> ';
              }
                  ?>
                  </select></div></td><td><div class="form-group"><input type="text" name="tab6time'+counttab6+'" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab6set'+counttab6+'" class="form-control number"></div></td><td><div class="form-group"><input id="tab6rep'+counttab6+'"type="text" name="tab6rep'+counttab6+'" class="form-control number exerciseset"></div></td> <td><div class="form-group"><input type="text" name="tab6instruction'+counttab6+'" class="form-control"></div></td>' +
              '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab6('+counttab6+')" ><i class="fa fa-minus"></i></button></td></tr>';

          if ($("#headeryes").val()==1)
          {
              ap +='</tbody>';
              $('#tbody6'+(countheader6-1)).after(ap);
              $("#headeryes").val(0);
          }else{
              $('#tbody6'+mycount).append(ap);
          }

          // $('.tab6item:last').after(ap);
          $('.select2').select2()

          // var rmv = '<div id="tab6rmvbtn'+counttab6+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab6('+counttab6+')" ><i class="fa fa-close">Remove</i></button></div>';

          count2 = counttab6-1;
          // alert(counttab6);
          $("#tab6rmvbtn"+count2).hide();

          // $(".tab6rmvitem:last").after(rmv);

          $("#mycounttab6").val(counttab6);
          // var count2 = counttab1-1;

          // $("#firstremove"+count2).hide();
          // $(".remove:last").after(rmv);

          // $("#mycount").val(counttab1);
          $("#tab6rep"+counttab6).keypress(function(e){
              var keyCode = e.which;
              /*
              8 - (backspace)
              32 - (space)
              48-57 - (0-9)Numbers
              */
              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          //  $('input[name="tab6set'+counttab6+'"').keypress(function(e){
          //   var keyCode = e.which;

          //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
          //     return false;
          //   }
          // });
          $('input[name="tab6time'+counttab6+'"').keypress(function(e){
              var keyCode = e.which;

              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
      });

          });
        function removetab6(counttab6)
      {
        // alert(counttab6);

        $('#tab6firsttr'+counttab6).remove();
        $('#tab6rmvbtn'+counttab6).remove();


        var count3 = counttab6-1;
        $("#tab6rmvbtn"+count3).show();
        $("#mycounttab6").val(count3);

      }

</script>
<!-- ****************************************tab7**************************** -->
<script type="text/javascript">
  $(document).ready(function(){
// **********************************7*********************************
var counttab7=1;

      $(document).on("click",'.addtab7',function(){

          var mycount = $(this).val();
          //     if ($("#mycounttab7").val()!='')
          // {
          //   counttab7= $("#mycounttab7").val();
          //
          // }

          counttab7++;
          var ap = '';
          if ($("#headeryes").val()==1)
          {
              countheader7++;
              ap += '<tbody id="tbody7'+countheader7+'" >';
          }
          ap +='<tr id="tab7firsttr'+counttab7+'" class="tab7item">';
          if ($("#headeryes").val()==1)
          {
              ap+='<td> <div class="form-group" > <button type="button" value="'+counttab7+'" id="add1" class="btn bg-green addtab7" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab7header'+counttab7+'" class="form-control header"  id="tab7header'+counttab7+'" placeholder="Enter Header"></div></td>';

          }else{
              ap+='<td></td><td></td>';
          }
          // $("#headeryes").val(0);
          ap+='<td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  data-live-search="true"  name="tab7exercisename'+counttab7+'"><option value="" disabled="" selected="">Please select</option>         <?php foreach($exercise as $exercisetab7)
              {
                  echo '<option value="'.$exercisetab7->exerciseid.'">'.$exercisetab7->exercisename.'</option> ';
              }
                  ?>
                  </select></div></td><td><div class="form-group"><input type="text" name="tab7time'+counttab7+'" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab7set'+counttab7+'" class="form-control number "></div></td><td><div class="form-group"><input id="tab7rep'+counttab7+'"type="text" name="tab7rep'+counttab7+'" class="form-control  exerciseset"></div></td> <td><div class="form-group"><input type="text" name="tab7instruction'+counttab7+'" class="form-control"></div></td>' +
              '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab7('+counttab7+')" ><i class="fa fa-minus"></i></button></td></tr>';

          if ($("#headeryes").val()==1)
          {
              ap +='</tbody>';
              $('#tbody7'+(countheader7-1)).after(ap);
              $("#headeryes").val(0);
          }else{
              $('#tbody7'+mycount).append(ap);
          }

          // $('.tab7item:last').after(ap);
          $('.select2').select2()

          var rmv = '<div id="tab7rmvbtn'+counttab7+'"></div>';

          count2 = counttab7-1;
          // alert(counttab7);
          $("#tab7rmvbtn"+count2).hide();

          // $(".tab7rmvitem:last").after(rmv);

          $("#mycounttab7").val(counttab7);
          // var count2 = counttab1-1;

          // $("#firstremove"+count2).hide();
          // $(".remove:last").after(rmv);

          // $("#mycount").val(counttab1);
          $("#tab7rep"+counttab7).keypress(function(e){
              var keyCode = e.which;
              /*
              8 - (backspace)
              32 - (space)
              48-57 - (0-9)Numbers
              */
              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
          // $('input[name="tab7set'+counttab7+'"').keypress(function(e){
          //    var keyCode = e.which;

          //    // if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
          //    //   return false;
          //    // }
          //  });
          $('input[name="tab7time'+counttab7+'"').keypress(function(e){
              var keyCode = e.which;

              if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                  return false;
              }
          });
      });

          });
        function removetab7(counttab7)
      {
        // alert(counttab7);

        $('#tab7firsttr'+counttab7).remove();
        $('#tab7rmvbtn'+counttab7).remove();


        var count3 = counttab7-1;
        $("#tab7rmvbtn"+count3).show();
        $("#mycounttab7").val(count3);

      }

</script>
<script type="text/javascript">

 $('#day1btn').on('click',function(){
$('a[href="#day2"]').click();

 $('#day1btn').hide();
 $('#day2btn').show();
 });
 $('#day2btn').on('click',function(){
$('a[href="#day3"]').click();
 $('#day2btn').hide();
 $('#day3btn').show();
 });

  $('#day3btn').on('click',function(){
$('a[href="#day4"]').click();
 $('#day3btn').hide();
 $('#day4btn').show();
 });
   $('#day4btn').on('click',function(){
$('a[href="#day5"]').click();
 $('#day4btn').hide();
 $('#day5btn').show();
 });
    $('#day5btn').on('click',function(){
$('a[href="#day6"]').click();
 $('#day5btn').hide();
 $('#day7btn').show();
 });
//  });
//  $('#day6btn').on('click',function(){
// $('a[href="#day7"]').click();
//  $('#day6btn').hide();
//  $('#day7btn').show();
//  });
//
 function  change(day)  {

      var tabs = $("#tabs .active a").attr('href');

 for (var i = 1; i <= 7; i++) {
 $('#day'+i+'btn').hide();
 }

var dayhide=day-1;
$('#day'+dayhide+'btn').show();
 // alert(tabs);

}
</script>

<script type="text/javascript">

   $('#workout').on('change',function(){
      $('a[href="#day1"]').click();
       $('#day2btn').hide();
    $('#day1btn').show();
     $('#day3btn').hide();
      $('#day4btn').hide();
       $('#day5btn').hide();
        $('#day6btn').hide();
         $('#day7btn').hide();

 $('.exercise').css('display','none');
  $("#tags:selected").prop("selected", false);
 $("#tab1 tbody tr:not(:first)").empty();

   $("#tab2 tbody tr:not(:first)").empty();

 $("#tab3 tbody tr:not(:first)").empty();

 $("#tab4 tbody tr:not(:first)").empty();
  $("#tab5 tbody tr:not(:first)").empty();
  $("#tab6 tbody tr:not(:first)").empty();
  $("#tab7 tbody tr:not(:first)").empty();
    });
  $('#plan').on('click',function(){
$('#workout').trigger('change');
    var exerciseplan =  $('#workout').val();

      var exerciseplanlevel = $.map($("#tagsid option:selected"), function (el, i) {
          return $(el).val();
      });
      var exerciseplanlevelid =  exerciseplanlevel.join(", ");

     var _token = $('input[name="_token"]').val();
     // alert(exerciseplan);


     $.ajax({
                                   url:"{{ url('exerciseload') }}",
                                   method:"GET",
                                       data:{exerciseplan:exerciseplan,exerciseplanlevel:exerciseplanlevelid, _token:_token},

                                  success:function(data) {

                                     // alert(data);

                                    if(data){
                                      $('.exercise').css('display','block');

                                    }

                                        count=1;

                                      $.each(data, function(i, item){


                                          var counttabedit=count;
                                          var ap = '';
                                          if (item.header !=null)
                                          {
                                              eval('countheader' + item.exerciseplanday + '++ ;');

                                              ap += '<tbody id="tbody'+item.exerciseplanday+eval('countheader' + item.exerciseplanday)+'" >';
                                          }
                                          ap +='<tr id="tab'+item.exerciseplanday+'firsttr'+counttabedit+'" class="tab'+item.exerciseplanday+'item">';

                                          if(item.header !=null)
                                          {

                                              ap+='<td><div class="form-group"><button type="button" id="add1" value="'+eval('countheader' + item.exerciseplanday)+'" class="btn bg-green addtab'+item.exerciseplanday+'" ><i class="fa fa-plus">Add</i></button></div></td><td><div class="form-group"><input type="text" name="tab'+item.exerciseplanday+'header'+counttabedit+'" id="tab'+item.exerciseplanday+'header'+counttabedit+'" class="form-control header" value="'+item.header+'"></div></td>';
                                          }else{
                                              ap+='<td></td><td></td>';
                                          }
                                          ap +='" <td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-header="Select Exercise"  data-live-search="true" name="tab'+item.exerciseplanday+'exercisename'+counttabedit+'" required><option value="" disabled="" selected="">Please select<option>';
                                          <?php foreach($exercise as $exercisetab){ ?>

                                              ap += '<option';
                                          if(item.exerciseid == "<?php echo $exercisetab->exerciseid ?>")
                                          {
                                              ap+=' selected';
                                          }
                                          ap+=' value="<?php echo $exercisetab->exerciseid ?>"><?php echo $exercisetab->exercisename ?></option> ';
                                          <?php } ?>

                                              ap+=' </select></div></td><td><div class="form-group"><input type="text" name="tab'+item.exerciseplanday+'time'+counttabedit+'" class="form-control"';
                                          ap+=' value=';
                                          if(item.exerciseplantime != null)
                                          {
                                              ap+=item.exerciseplantime;
                                          }
                                          else{
                                              ap+='0';
                                          }

                                          ap+='></div></td><td><div class="form-group"><input id="tab'+item.exerciseplanday+'set'+counttabedit+'"type="text" name="tab'+item.exerciseplanday+'set'+counttabedit+'"';
                                          ap+=' value=';
                                          if(item.exerciseplanset !=null)
                                          {
                                              ap+=item.exerciseplanset;
                                          }
                                          else{
                                              ap+='0';
                                          }
                                          ap+=' class="form-control number" ></div></td> <td><div class="form-group"><input type="text" id="tab'+item.exerciseplanday+'rep'+counttabedit+'" name="tab'+item.exerciseplanday+'rep'+counttabedit+'"';
                                          ap+=' value=';
                                          if(item.exerciseplanlevelrep !=null)
                                          {
                                              ap+=item.exerciseplanlevelrep;
                                          }
                                          else{
                                              ap+='0';
                                          }
                                          ap+='  class="form-control number exerciseset" ></div></td><td><div class="form-group"><input type="text" name="tab'+item.exerciseplanday+'instruction'+counttabedit+'" class="form-control"';
                                          ap+=' value=';
                                          if(item.exerciseplanins !=null)
                                          {
                                              ap+=item.exerciseplanins;
                                          }
                                          else{
                                              ap+='';
                                          }
                                          ap+=' ></div></td><td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab'+item.exerciseplanday+'('+counttabedit+')" ><i class="fa fa-minus"></i></button></td></tr>';
                                          if (item.header !=null)
                                          {
                                              ap +='</tbody>';

                                              // $("#headeryes").val(0);
                                          }

                                          $('#tb'+item.exerciseplanday).after(ap);
    // $('.tab'+item.exerciseplanday+'item:last').after(ap);
        count++;
                                          $('.select2').select2()

      $('#mycounttab'+item.exerciseplanday).val(count-1);





                                    $('#tags').find('option').each( function() {
                                        var $this = $(this);
                                        // alert($this.val());
                                       var strarray = item.exerciseplanlevel.split(',');
                                       for (var i = 0; i < strarray.length; i++) {
                                        // alert(strarray[i])


                                        if ($this.val() == strarray[i] ) {
                                        $this.attr('selected','selected');

                                        }
                                           }

                                        });

                            });

                                  },
                                  dataType:'json',

                              });


  })
</script>
<script type="text/javascript">
   function removetab72(day,counttabedit)
      {
        // alert(counttab7);
   alert("Are You Sure to Remove Exercise ?");

        $('#tab'+day+'firsttr'+counttabedit).remove();
     //   $('#tabew'+item.exerciseplanday+'instructionw'+counttabedit).remove();


        // var count3 = counttab7-1;
        // $("#tab7rmvbtn"+count3).show();
        // $("#mycounttab7").val(count3);

      }

</script>
  <script type="text/javascript">
        $('#formtab').on('submit', function() {
          $('#tagsid').prop("disabled",false);

     if($('.exercisename')[0]){
           var exercisename = $('.exercisename').val();
         // alert(exercisename);
      if(exercisename == null || exercisename == ''){
        alert('Please Select Exercise');
          return false;
        }
      }

       var value = [];
       var error = [];
       var day = [];
       $(document).find('.exerciseset').each(function(){
        var a=$(this).val();
        var b= $(this).attr("name");

          value.push({
    RoomName : a,
    item : b,
});


       });
      var  pattern=/[0-9]{2}[*][0-9]{2}[*][0-9]{2}$/;
       $.each(value,function(key, data){

          if(data.RoomName== 0 || data.RoomName == ''){
            // alert(data.RoomName);
            return true;
         }

          if (!pattern.test(data.RoomName)) {
            error.push('error'+key);
                     // alert(JSON.stringify(data.item));
            day.push(data.item);
            // alert(day);

          } else {
            // alert('match');
          }

       });
       // alert(error.length);
         if(error.length){

            var dayprint = [];
            for(i = 0 ;i < day.length ;i++){
             var res = day[i].charAt(3);
             if (!dayprint.includes(res)){
               dayprint.push(res);
              }

            }

          alert("Please Enter Proper format set value in Day "+ dayprint +" ");
          return false;
         }

     else{

     }
      return true;
         });
</script>
<script type="text/javascript">
  $('#formtab').submit(function(){
    $(this).find('input[type=submit]').prop('disabled', true);
});
</script>

@endsection
