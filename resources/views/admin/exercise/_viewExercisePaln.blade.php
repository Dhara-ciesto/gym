@extends('layouts.adminLayout.admin_design')
@section('content')

        
 <div class="content-wrapper">
   <style type="text/css">
	.li{
		width: 13%;
	}
	td,th{
		margin: 15px; padding: 10px;"
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
              <h3 class="box-title">Plan WorkOut</h3>
            </div>
            <!-- /.box-header -->
             <div class="box-body"> 
             	
             	<form action="{{url('editplan')}}" method="post" name="formtab" id="formtab">
             		{{csrf_field()}}
             	<div class="col-lg-12" style="text-align: left;">
             		<div class="col-lg-4">
             				<div class="form-group">
	             		<label>WorkOut</label>
	             	<select name="workout" class="form-control" id="workout">
                  <option value="" disabled="" selected="">--Please Select--</option>
                  @foreach($workout as $workout1)
                 <option value="{{$workout1->workoutid}}">{{$workout1->workoutname}}</option> 
                 @endforeach
                </select>

             		</div>
             		</div>
             		<div class="col-lg-5">
             				<div class="form-group">
	             		<label>Tags </label>
	             			
           				<select id="tags" class="form-control " multiple="" data-placeholder="Select a Tags" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="exerciselevel[]" required="">
           					
           				@foreach($tags as $tag)
 
           				<option value="{{$tag->exerciselevelid}}">{{$tag->exerciselevel}}</option>
  @endforeach

          
           				</select>
             		</div>
              
             
				</div>
          <div class="col-md-3">
                  <div class="l"><button type="button"class="btn btn bg-orange" name="plan" id="plan" value="plan">Plan</button></div>
                </div>
                

             		</div>
             	
             
             	<br>
           	<div class="col-md-12 exercise" style="display:none">	
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="li active"><a href="#day1" data-toggle="tab" aria-expanded="true">Day 1</a></li>
              <li class="li"><a href="#day2" data-toggle="tab" aria-expanded="false">Day 2</a></li>
              <li class="li"><a href="#day3" data-toggle="tab" aria-expanded="false">Day 3</a></li>
              <li class="li"><a href="#day4" data-toggle="tab" aria-expanded="false">Day 4</a></li>
              <li class="li"><a href="#day5" data-toggle="tab" aria-expanded="false">Day 5</a></li>
              <li class="li"><a href="#day6" data-toggle="tab" aria-expanded="false">Day 6</a></li>
              <li class="li"><a href="#day7" data-toggle="tab" aria-expanded="false">Day 7</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="day1">
                <!-- Post -->

                tab1
                <table id="tab1">
                	<thead>
                		<th>Exercise</th>
                		<th>Time</th>
                		<th>Rep</th>
                		 <th>Set</th>
                		<th>Instruction</th>
             
                	</thead>
                	<tbody id="firsttd" class="tbodyid">
                		<input class="form-control" style="display: none" type="hidden" value="1" name="tab1mycount" id="mycounttab1">
                			<input type="hidden" name="tab1exerciselevelday" value="1">
                    
                       <tr id="tab1firsttr1" class="tab1item">
                        </tr>


                 
				</tbody>
			
           		</table>
					<div class="col-lg-12" style="text-align: center;">
             		<div class="col-lg-6">
             			 <div class="form-group" style="text-align: right">
	           			<button type="button"id="add1" class="btn bg-orange addtab1" ><i class="fa fa-plus">Add</i></button>
	           		</div>
             		</div>
             		<div class="col-lg-6">
             				<div class="form-group"	 style="text-align: left">
	           			<div class="col-lg-1 tab1rmvitem" style="margin-top: -990px;">
							
						</div>
	           		</div>
             		</div>

             	</div>
        
              </div>

              <!-- /.tab-pane -->
            
<!--***********************************tab2************************************************ -->
             	    <div class="tab-pane" id="day2">
             	    	tab2
             	  <table id="tab2">
                	<thead>	
                		<th>Exercise</th>
                		<th>Time</th>
                		<th>Rep</th>
                		 <th>Set</th>
                		<th>Instruction</th>
             
                	</thead>
                	<tbody id="firsttd">
                		<input class="form-control" style="display: none" type="hidden" value="1" name="tab2mycount" id="mycounttab2">
                			<input type="hidden" name="tab2exerciselevelday" value="2">
                		<tr id="tab2firsttr1" class="tab2item">
               		
	           		
	           	</tr>
				</tbody>
			
           		</table>
					<div class="col-lg-12" style="text-align: center;">
             		<div class="col-lg-6">
             			 <div class="form-group" style="text-align: right">
	           			<button type="button"id="add1" class="btn bg-orange addtab2" ><i class="fa fa-plus">Add</i></button>
	           		</div>
             		</div>
             		<div class="col-lg-6">
             				<div class="form-group"	 style="text-align: left">
	           			<div class="col-lg-1 tab2rmvitem" style="margin-top: -990px;">
							
						</div>
	           		</div>
             		</div>

             	</div>
              </div>

              <!-- /.tab-pane -->
<!--***********************************tab2************************************************ -->
              <div class="tab-pane" id="day3">
            tab3
             <table id="tab3">
                	<thead>	
                			<th>Exercise</th>
                		<th>Time</th>
                		<th>Rep</th>
                		 <th>Set</th>
                		<th>Instruction</th>
                	</thead>
                	<tbody id="firsttd">
                		<input class="form-control" style="display: none" type="hidden" value="1" name="tab3mycount" id="mycounttab3">
                			<input type="hidden" name="tab3exerciselevelday" value="3">
                		<tr id="tab3firsttr1" class="tab3item">
               		
	           		
	           	</tr>
				</tbody>
			
           		</table>
					<div class="col-lg-12" style="text-align: center;">
             		<div class="col-lg-6">
             			 <div class="form-group" style="text-align: right">
	           			<button type="button"id="add1" class="btn bg-orange addtab3" ><i class="fa fa-plus">Add</i></button>
	           		</div>
             		</div>
             		<div class="col-lg-6">
             				<div class="form-group"	 style="text-align: left">
	           			<div class="col-lg-1 tab3rmvitem" style="margin-top: -990px;">
							
						</div>
	           		</div>
             		</div>

             	</div>
              </div>
              <!-- /.tab-pane -->

<!--***********************************tab4************************************************ -->              
              <div class="tab-pane" id="day4">
            tab4
             <table id="tab4">
                	<thead>	
                		<th>Exercise</th>
                		<th>Time</th>
                		<th>Rep</th>
                		 <th>Set</th>
                		<th>Instruction</th>
             
                	</thead>
                	<tbody id="firsttd">
                		<input class="form-control" style="display: none" type="hidden" value="1" name="tab4mycount" id="mycounttab4">
                			<input type="hidden" name="tab4exerciselevelday" value="4">
                		<tr id="tab4firsttr1" class="tab4item">
               
	           		
	           		
	           	</tr>
				</tbody>
			
           		</table>
					<div class="col-lg-12" style="text-align: center;">
             		<div class="col-lg-6">
             			 <div class="form-group" style="text-align: right">
	           			<button type="button"id="add1" class="btn bg-orange addtab4" ><i class="fa fa-plus">Add</i></button>
	           		</div>
             		</div>
             		<div class="col-lg-6">
             				<div class="form-group"	 style="text-align: left">
	           			<div class="col-lg-1 tab4rmvitem" style="margin-top: -990px;">
							
						</div>
	           		</div>
             		</div>

             	</div>
              </div>

<!--***********************************tab2************************************************ -->
  <div class="tab-pane" id="day5">
            tab5
             <table id="tab5">
                	<thead>	
                		<th>Exercise</th>
                		<th>Time</th>
                		<th>Rep</th>
                		 <th>Set</th>
                		<th>Instruction</th>
                		
             
                	</thead>
                	<tbody id="firsttd">
                		<input class="form-control" style="display: none" type="hidden" value="1" name="tab5mycount" id="mycounttab5">
                			<input type="hidden" name="tab5exerciselevelday" value="5">
                		<tr id="tab5firsttr1" class="tab5item">
               		
	           		
	           		
	           	</tr>
				</tbody>
			
           		</table>
					<div class="col-lg-12" style="text-align: center;">
             		<div class="col-lg-6">
             			 <div class="form-group" style="text-align: right">
	           			<button type="button"id="add1" class="btn bg-orange addtab5" ><i class="fa fa-plus">Add</i></button>
	           		</div>
             		</div>
             		<div class="col-lg-6">
             				<div class="form-group"	 style="text-align: left">
	           			<div class="col-lg-1 tab5rmvitem" style="margin-top: -990px;">
							
						</div>
	           		</div>
             		</div>

             	</div>
              </div>



<!--***********************************tab2************************************************ -->
<div class="tab-pane" id="day6">
            tab6
             <table id="tab6">
                	<thead>	
                		<th>Exercise</th>
                		<th>Time</th>
                		<th>Rep</th>
                		 <th>Set</th>
                		<th>Instruction</th>
                	</thead>
                	<tbody id="firsttd">
                		<input class="form-control" style="display: none" type="hidden" value="1" name="tab6mycount" id="mycounttab6">
                			<input type="hidden" name="tab6exerciselevelday" value="6">
                		<tr id="tab6firsttr1" class="tab6item">
               		
           			
	           		
	           		
	           	</tr>
				</tbody>
			
           		</table>
					<div class="col-lg-12" style="text-align: center;">
             		<div class="col-lg-6">
             			 <div class="form-group" style="text-align: right">
	           			<button type="button"id="add1" class="btn bg-orange addtab6" ><i class="fa fa-plus">Add</i></button>
	           		</div>
             		</div>
             		<div class="col-lg-6">
             				<div class="form-group"	 style="text-align: left">
	           			<div class="col-lg-1 tab6rmvitem" style="margin-top: -990px;">
							
						</div>
	           		</div>
             		</div>

             	</div>
              </div>

<!--***********************************tab2************************************************ -->
<div class="tab-pane" id="day7">
            tab7
             <table id="tab7">
                	<thead>	
                		<th>Exercise</th>
                		<th>Time</th>
                		<th>Rep</th>
                		 <th>Set</th>
                		<th>Instruction</th>
             
                	</thead>
                	<tbody id="firsttd">
                		<input class="form-control" style="display: none" type="hidden" value="1" name="tab7mycount" id="mycounttab7">
                			<input type="hidden" name="tab7exerciselevelday" value="7">
                		<tr id="tab7firsttr1" class="tab7item">
               		
	           		
	           	</tr>
				</tbody>
			
           		</table>
					<div class="col-lg-12" style="text-align: center;">
             		<div class="col-lg-6">
             			 <div class="form-group" style="text-align: right">
	           			<button type="button"id="add1" class="btn bg-orange addtab7" ><i class="fa fa-plus">Add</i></button>
	           		</div>
             		</div>
             		<div class="col-lg-6">
             				<div class="form-group"	 style="text-align: left">
	           			<div class="col-lg-1 tab7rmvitem" style="margin-top: -990px;">
							
						</div>
	           		</div>
             		</div>

             	</div>
              </div>

<!--***********************************tab2************************************************ -->
            </div>
            <center>
             		<div class="form-group">
             			<input type="submit" name="submit" class="btn bg-orange">
             		</div>
             		</center>
             	</form>
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
	
		
	$(document).ready(function(){
// **********************************fottab1*********************************
var counttab1=1;
        		
        		$(".addtab1").on("click",function(){
        				if ($("#mycounttab1").val()!='')
						{
							counttab1= $("#mycounttab1").val();
							
						}
       
        counttab1++;
		var ap='<tr id="tab1firsttr'+counttab1+'" class="tab1item"><td><div class="form-group"><select class="form-control" name="tab1exercisename'+counttab1+'"required><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($exercise as $exercisetab1)
		{ 
			echo '<option value="'.$exercisetab1->exerciseid.'">'.$exercisetab1->exercisename.'</option> ';	
		} 
?>
										</select></div></td><td><div class="form-group"><input type="text" name="tab1time'+counttab1+'" class="form-control"></div></td><td><div class="form-group"><input id="tab1rep'+counttab1+'"type="text" name="tab1rep'+counttab1+'" class="form-control number"></div></td>	<td><div class="form-group"><input type="text" name="tab1set'+counttab1+'" class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab1instruction'+counttab1+'" class="form-control"></div></td></tr>';

		$('.tab1item:last').after(ap);	

				var rmv = '<div id="tab1rmvbtn'+counttab1+'"><button type="button" id="remove" class="btn bg-orange rmitm" onclick="removetab1('+counttab1+')" ><i class="fa fa-close">Remove</i></button></div>';

				count2 = counttab1-1;
				// alert(counttab1);
				$("#tab1rmvbtn"+count2).hide();

				$(".tab1rmvitem:last").after(rmv);

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
        		
        		$(".addtab2").on("click",function(){
        				if ($("#mycounttab2").val()!='')
						{
							counttab2= $("#mycounttab2").val();
							
						}
       
        counttab2++;
		var ap='<tr id="tab2firsttr'+counttab2+'" class="tab2item"><td><div class="form-group"><select class="form-control" name="tab2exercisename'+counttab2+'"required><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($exercise as $exercisetab2)
		{ 
			echo '<option value="'.$exercisetab2->exerciseid.'">'.$exercisetab2->exercisename.'</option> ';	
		} 
?>
										</select></div></td><td><div class="form-group"><input type="text" name="tab2time'+counttab2+'" class="form-control"></div></td><td><div class="form-group"><input id="tab2rep'+counttab2+'"type="text" name="tab2rep'+counttab2+'" class="form-control number"></div></td>	<td><div class="form-group"><input type="text" name="tab2set'+counttab2+'" class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab2instruction'+counttab2+'" class="form-control"></div></td></tr>';

		$('.tab2item:last').after(ap);	

				var rmv = '<div id="tab2rmvbtn'+counttab2+'"><button type="button" id="remove" class="btn bg-orange rmitm" onclick="removetab2('+counttab2+')" ><i class="fa fa-close">Remove</i></button></div>';

				count2 = counttab2-1;
				// alert(counttab2);
				$("#tab2rmvbtn"+count2).hide();

				$(".tab2rmvitem:last").after(rmv);

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
        		
        		$(".addtab3").on("click",function(){
        				if ($("#mycounttab3").val()!='')
						{
							counttab2= $("#mycounttab3").val();
							
						}
       
        counttab3++;
		var ap='<tr id="tab3firsttr'+counttab3+'" class="tab3item"><td><div class="form-group"><select class="form-control" name="tab3exercisename'+counttab3+'"required><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($exercise as $exercisetab3)
		{ 
			echo '<option value="'.$exercisetab3->exerciseid.'">'.$exercisetab3->exercisename.'</option> ';	
		} 
?>
										</select></div></td><td><div class="form-group"><input type="text" name="tab3time'+counttab3+'" class="form-control"></div></td><td><div class="form-group"><input id="tab3rep'+counttab3+'"type="text" name="tab3rep'+counttab3+'" class="form-control number"></div></td>	<td><div class="form-group"><input type="text" name="tab3set'+counttab3+'" class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab3instruction'+counttab3+'" class="form-control"></div></td></tr>';

		$('.tab3item:last').after(ap);	

				var rmv = '<div id="tab3rmvbtn'+counttab3+'"><button type="button" id="remove" class="btn bg-orange rmitm" onclick="removetab3('+counttab3+')" ><i class="fa fa-close">Remove</i></button></div>';

				count2 = counttab3-1;
				// alert(counttab3);
				$("#tab3rmvbtn"+count2).hide();

				$(".tab3rmvitem:last").after(rmv);

				$("#mycounttab3").val(counttab2);
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
        		
        		$(".addtab4").on("click",function(){
        				if ($("#mycounttab4").val()!='')
						{
							counttab4= $("#mycounttab4").val();
							
						}
       
        counttab4++;
		var ap='<tr id="tab4firsttr'+counttab4+'" class="tab4item"><td><div class="form-group"><select class="form-control" name="tab4exercisename'+counttab4+'"required><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($exercise as $exercisetab4)
		{ 
			echo '<option value="'.$exercisetab4->exerciseid.'">'.$exercisetab4->exercisename.'</option> ';	
		} 
?>
										</select></div></td><td><div class="form-group"><input type="text" name="tab4time'+counttab4+'" class="form-control"></div></td><td><div class="form-group"><input id="tab4rep'+counttab4+'"type="text" name="tab4rep'+counttab4+'" class="form-control number"></div></td>	<td><div class="form-group"><input type="text" name="tab4set'+counttab4+'" class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab4instruction'+counttab4+'" class="form-control"></div></td></tr>';

		$('.tab4item:last').after(ap);	

				var rmv = '<div id="tab4rmvbtn'+counttab4+'"><button type="button" id="remove" class="btn bg-orange rmitm" onclick="removetab4('+counttab4+')" ><i class="fa fa-close">Remove</i></button></div>';

				count2 = counttab4-1;
				// alert(counttab4);
				$("#tab4rmvbtn"+count2).hide();

				$(".tab4rmvitem:last").after(rmv);

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
        		
        		$(".addtab5").on("click",function(){
        				if ($("#mycounttab5").val()!='')
						{
							counttab5= $("#mycounttab5").val();
							
						}
       
        counttab5++;
		var ap='<tr id="tab5firsttr'+counttab5+'" class="tab5item"><td><div class="form-group"><select class="form-control" name="tab5exercisename'+counttab5+'"required><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($exercise as $exercisetab5)
		{ 
			echo '<option value="'.$exercisetab5->exerciseid.'">'.$exercisetab5->exercisename.'</option> ';	
		} 
?>
										</select></div></td><td><div class="form-group"><input type="text" name="tab5time'+counttab5+'" class="form-control"></div></td><td><div class="form-group"><input id="tab5rep'+counttab5+'"type="text" name="tab5rep'+counttab5+'" class="form-control number"></div></td>	<td><div class="form-group"><input type="text" name="tab5set'+counttab5+'" class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab5instruction'+counttab5+'" class="form-control"></div></td></tr>';

		$('.tab5item:last').after(ap);	

				var rmv = '<div id="tab5rmvbtn'+counttab5+'"><button type="button" id="remove" class="btn bg-orange rmitm" onclick="removetab5('+counttab5+')" ><i class="fa fa-close">Remove</i></button></div>';

				count2 = counttab5-1;
				// alert(counttab5);
				$("#tab5rmvbtn"+count2).hide();

				$(".tab5rmvitem:last").after(rmv);

				$("#mycounttab5").val(counttab5);
					// var count2 = counttab1-1;
				
				// $("#firstremove"+count2).hide();
				// $(".remove:last").after(rmv);
			
				// $("#mycount").val(counttab1);
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
        		
        		$(".addtab6").on("click",function(){
        				if ($("#mycounttab6").val()!='')
						{
							counttab6= $("#mycounttab6").val();
							
						}
       
        counttab6++;
		var ap='<tr id="tab6firsttr'+counttab6+'" class="tab6item"><td><div class="form-group"><select class="form-control" name="tab6exercisename'+counttab6+'"required><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($exercise as $exercisetab6)
		{ 
			echo '<option value="'.$exercisetab6->exerciseid.'">'.$exercisetab6->exercisename.'</option> ';	
		} 
?>
										</select></div></td><td><div class="form-group"><input type="text" name="tab6time'+counttab6+'" class="form-control"></div></td><td><div class="form-group"><input id="tab6rep'+counttab6+'"type="text" name="tab6rep'+counttab6+'" class="form-control number"></div></td>	<td><div class="form-group"><input type="text" name="tab6set'+counttab6+'" class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab6instruction'+counttab6+'" class="form-control"></div></td></tr>';

		$('.tab6item:last').after(ap);	

				var rmv = '<div id="tab6rmvbtn'+counttab6+'"><button type="button" id="remove" class="btn bg-orange rmitm" onclick="removetab6('+counttab6+')" ><i class="fa fa-close">Remove</i></button></div>';

				count2 = counttab6-1;
				// alert(counttab6);
				$("#tab6rmvbtn"+count2).hide();

				$(".tab6rmvitem:last").after(rmv);

				$("#mycounttab6").val(counttab6);
					// var count2 = counttab1-1;
				
				// $("#firstremove"+count2).hide();
				// $(".remove:last").after(rmv);
			
				// $("#mycount").val(counttab1);
	$("#tab2rep"+counttab6).keypress(function(e){
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
        		
        		$(".addtab7").on("click",function(){
        				if ($("#mycounttab7").val()!='')
						{
							counttab7= $("#mycounttab7").val();
							
						}
       
        counttab7++;
		var ap='<tr id="tab7firsttr'+counttab7+'" class="tab7item"><td><div class="form-group"><select class="form-control" name="tab7exercisename'+counttab7+'"required><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($exercise as $exercisetab7)
		{ 
			echo '<option value="'.$exercisetab7->exerciseid.'">'.$exercisetab7->exercisename.'</option> ';	
		} 
?>
										</select></div></td><td><div class="form-group"><input type="text" name="tab7time'+counttab7+'" class="form-control"></div></td><td><div class="form-group"><input id="tab7rep'+counttab7+'"type="text" name="tab7rep'+counttab7+'" class="form-control number"></div></td>	<td><div class="form-group"><input type="text" name="tab7set'+counttab7+'" class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab7instruction'+counttab7+'" class="form-control"></div></td></tr>';

		$('.tab7item:last').after(ap);	

				var rmv = '<div id="tab7rmvbtn'+counttab7+'"><button type="button" id="remove" class="btn bg-orange rmitm" onclick="removetab7('+counttab7+')" ><i class="fa fa-close">Remove</i></button></div>';

				count2 = counttab7-1;
				// alert(counttab7);
				$("#tab7rmvbtn"+count2).hide();

				$(".tab7rmvitem:last").after(rmv);

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
  $('#workout').on('change',function(){
  $('.exercise').css('display','none');
  $("option:selected").prop("selected", false)
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
    // $('.exercise').css('display','none');
   var exerciseplan =  $('#workout').val();
         
     var _token = $('input[name="_token"]').val();
     // alert(exerciseplan);


     $.ajax({
                                   url:"{{ url('exerciseload') }}",
                                   method:"GET",
                                       data:{exerciseplan:exerciseplan, _token:_token},
                                 
                                  success:function(data) {

                                     // alert(data);

                                    if(data){
                                      $('.exercise').css('display','block');
                         
                                    }

                                        count=1;

                                      $.each(data, function(i, item){
                                      

                                              var counttabedit=count;
                                              var ap='<tr id="tab'+item.exerciseplanday+'firsttr'+counttabedit+'" class="tab'+item.exerciseplanday+'item"><td><div class="form-group"><select class="form-control" name="tab'+item.exerciseplanday+'exercisename'+counttabedit+'"required><option value="" disabled="" selected="">--Please select--</option>';
                                  <?php foreach($exercise as $exercisetab){ ?>

                                    ap += '<option';
                                    if(item.exerciseid == "<?php echo $exercisetab->exerciseid ?>")
                                    {
                                      ap+=' selected';
                                    } 
                                    ap+=' value="<?php echo $exercisetab->exerciseid ?>"><?php echo $exercisetab->exercisename ?></option> '; 
                                    <?php } ?> 

                    ap+=' </select></div></td><td><div class="form-group"><input type="text" name="tab'+item.exerciseplanday+'time'+counttabedit+'" class="form-control" value="'+item.exerciseplantime+'"></div></td><td><div class="form-group"><input id="tab'+item.exerciseplanday+'rep'+counttabedit+'"type="text" name="tab'+item.exerciseplanday+'rep'+counttabedit+'" value="'+item.exerciseplanlevelrep+'"class="form-control number"></div></td> <td><div class="form-group"><input type="text" name="tab'+item.exerciseplanday+'set'+counttabedit+'" value="'+item.exerciseplanset+'"class="form-control number"></div></td><td><div class="form-group"><input type="text" name="tab'+item.exerciseplanday+'instruction'+counttabedit+'" class="form-control"value="'+item.exerciseplanins+'" ></div></td></tr></div>';

    $('.tab'+item.exerciseplanday+'item:last').after(ap);  
        count++;

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
@endsection