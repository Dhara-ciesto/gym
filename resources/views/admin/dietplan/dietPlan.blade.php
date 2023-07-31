@extends('layouts.adminLayout.admin_design')
@section('content')

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

   <style type="text/css">
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 24px;
}
   
    .li{
   /*width: 15%;*/
   padding-left: 15px;
    padding-right: 15px;
  }
.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  right: -30px;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 15px;
  left: 4px;

  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #f39c12;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
  width: 45px;
}

.slider.round:before {
  border-radius: 50%;
}


 td{
     width: auto !important;
  }
  td,th{
    margin: 15px; padding: 10px;
    width: auto !important;
  }
  .select2-selection__choice{
    background-color: #e4e4e4 !important;
    color: black !important;
  }
 .nav-tabs-custom{
  box-shadow: none !important;
  }

</style>
      <div class="content-wrapper">
         <section class="content-header"><h2></h2></section>
          <!-- general form elements -->
          <section class="content">
          <div class="box box-primary">
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
            <div class="box-header with-border">
              <h3 class="box-title">Plan Diet </h3>
            </div>
            <!-- /.box-header -->
             <div class="box-body"> 
              
              <form action="{{url('planDiet')}}" method="post" name="formtab" id="formtab">
                {{csrf_field()}}
                <div class="col-lg-12"> 
              <div class="col-lg-12" style="text-align: left;margin-left: -15px;">
                   <div class="col-lg-4">
        
                <div class="form-group">
                  <label>Diet </label>
                  <input type="text" name="dietplanname" class="form-control" placeholder="Diet Name" required="" id="dietname"><span id="error_username"></span>
                </div>
                <br>

                </div>

    <!-- <button type="button" id="button-a">Check the  minutes</button>
    <button type="button" id="button-b">Check the  hours</button> -->

                <div class="col-lg-4">
                    <div class="form-group">
                  <label>Tags </label>
                    
                  <select  class="form-control select2" multiple="" data-placeholder="Select Multiple Tags" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="exerciselevel[]" required="">
                    
                  @foreach($tags as $tag)
                  <option value="{{$tag->exerciselevelid}}">{{$tag->exerciselevel}}</option>
                  @endforeach
                  </select>
                </div>
             
                </div>
                <div class="col-lg-4">
                        <div class="form-group">
                  <label>Diet Notes </label>
                   <select  class="form-control select2" multiple="" data-placeholder="Select a Tags" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="dietnotes[]" required="">
                    
                  @foreach($dietnotes as $dietnote)
                  <option value="{{$dietnote->dietnoteid}}">{{$dietnote->dietnote}}</option>
                  @endforeach
                  </select>
                </div>

                </div>
           </div>
            </div> 
              <br>

            <div class="col-md-12" style="overflow: auto;"> 
     <br>
          <div class="nav-tabs-custom" >
            <ul class="nav nav-tabs " id="tabs">
              <li class="li active"><a href="#day1" data-toggle="tab" onclick="change(2)" aria-expanded="true">Monday</a></li>
              <li class="li"><a href="#day2" data-toggle="tab"  onclick="change(3)" aria-expanded="false">Tuesday</a></li>
              <li class="li"><a href="#day3" data-toggle="tab"  onclick="change(4)" aria-expanded="false">Wednesday</a></li>
              <li class="li"><a href="#day4" data-toggle="tab"  onclick="change(5)" aria-expanded="false">Thrusday</a></li>
              <li class="li"><a href="#day5" data-toggle="tab" aria-expanded="false" onclick="change(6)">Friday</a></li>
              <li class="li"><a href="#day6" data-toggle="tab" aria-expanded="false" onclick="change(7)">Saturday</a></li>
               <li class="li"><a href="#day7" data-toggle="tab" aria-expanded="false" onclick="change(8)">Sunday</a></li>

            </ul>
          </div>
            <div class="tab-content">
              <div class="tab-pane active" id="day1">
                  <textarea name="daynote1" placeholder="Day 1 Note...." class="form-control"></textarea>
                <!-- Post -->
                <!-- tab1 -->
                <table>
                  <thead>
                    <th>Meal Type</th>
                    <th>Is Compulsary</th>
                    <th>Time </th>
                    
                     <th>Diet Food</th>
                    <th>Remark</th>
             
                  </thead>
                  <tbody id="firsttd">
                    <input class="form-control " style="display: none" type="hidden" value="1" name="tab1mycount" id="mycounttab1">
                      <input type="hidden" name="tab1exerciselevelday" id="tab1exerciselevelday" value="1">
                    <tr id="tab1firsttr1" class="tab1item">
                  <td style="width: 30%!important">
              
                  <div class="form-group">
                  <select class="form-control selectpicker"data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  name="tab1mealname1"  >
                    <option value="" disabled="" selected="">--Please select--</option>
                  @foreach($meals as $meal) 
                  <option value="{{$meal->mealmasterid}}" {{$meal->mealmasterid == 1 ?'selected':'' }} >{{$meal->mealname}}</option>
                  @endforeach
                    </select>
                   </div>
                </td>
                <td>
                   <div class="form-group">
                    <label class="switch" style="margin-bottom: 0px !important;">
                    <input type="checkbox" name="tab1iscompulsary1" value="1">
                     <span class="slider round"></span>
                    </label>
                  </div>
                </td>
                <td>
                   <div class="form-group">
             
                  <input id="" value="" data-default="20:48" class="form-control input-a number" placeholder="Time" name="tab1time1" autocomplete="off" onkeypress="return false">
               
                 
                </div>
         
                
                </td>
              
                  <td style="width: 30%!important">
                  <div class="form-group">

                  <select class="select2" data-placeholder="Select Multiple Items" multiple=""  style="width:100%;" tabindex="-1" aria-hidden="true" name="tab1items1[]">
                    @foreach($dietitems as $dietitem)
                    <option value="{{$dietitem->dietitemid}}">{{$dietitem->dietitem}}</option>
                    @endforeach
                  </select>
                 </div>
                 
                </td>
                <td>
                  <div class="form-group addafter">

                  <input type="text"  name="tab1instruction1" class="form-control">
                  </div>
                </td>
                
                
              </tr>
        </tbody>
      
              </table>
          <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-5"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1">
                    <div class="form-group"  >
                  <div class="tab1rmvitem" >
              
            </div>
                </div>
                </div>
                <div class="col-lg-5"></div>

              </div>
        
              </div>

              <!-- /.tab-pane -->
            
<!--***********************************tab2************************************************ -->
                  <div class="tab-pane" id="day2">
                      <textarea name="daynote2" placeholder="Day 2 Note...." class="form-control"></textarea>
                    <!-- tab2 -->
                <table>
                  <thead> 
                    <th>Meal Type</th>
                    <th>Is Compulsary</th>
                    <th>Time</th>
                    
                    <th>Diet Food</th>
                    <th>Remark</th>
             
                  </thead>
                  <tbody id="firsttd">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab2mycount" id="mycounttab2">
                      <input type="hidden" name="tab2exerciselevelday" value="2">
                    <tr id="tab2firsttr1" class="tab2item">
                  <td style="width: 30%!important">
                <div class="form-group">
                  
                  <select class="form-control selectpicker"data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  name="tab2mealname1" >
                    <option value="" disabled="" selected="">--Please select--</option>
                  @foreach($meals as $meal)
                  <option value="{{$meal->mealmasterid}}" {{$meal->mealmasterid == 1 ?'selected':'' }} >{{$meal->mealname}}</option>
                  @endforeach
                  </select>
                </div>   
                </td>
                  <td>
                   <div class="form-group">
                    <label class="switch" style="margin-bottom: 0px !important;">
                    <input type="checkbox" name="tab2iscompulsary1" value="1">
                     <span class="slider round"></span>
                    </label>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                        <input id="input-a" value="" data-default="20:48" class="form-control input-a number" placeholder="Time" name="tab2time1" autocomplete="off" onkeypress="return false">
                 
                  </div>
                </td>
                
                  <td style="width: 30%!important">
                       <div class="form-group">

                  <select class="select2" date-placeholder="Select Multiple Items" multiple=""  style="width: 100%;" tabindex="-1" aria-hidden="true"name="tab2items1[]">
                    @foreach($dietitems as $dietitem)
                    <option value="{{$dietitem->dietitemid}}">{{$dietitem->dietitem}}</option>
                    @endforeach
                  </select>
                 
                  </div>
                </td>
                <td>
                  <div class="form-group">

                  <input type="text" name="tab2instruction1" class="form-control">
                  </div>
                </td>
                
                
              </tr>
        </tbody>
      
              </table>
                  <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-5"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab2" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1" >
                    <div class="form-group"  >
                  <div class="tab2rmvitem" >
              
            </div>
                </div>
                </div>
                <div class="col-lg-5"></div>

              </div>
    
              </div>



              <!-- /.tab-pane -->
<!--***********************************tab2************************************************ -->
              <div class="tab-pane" id="day3">
                  <textarea name="daynote3" placeholder="Day 3 Note...." class="form-control"></textarea>
           <!--  tab3 -->
             <table>
                  <thead> 
                      <th>Meal Type</th>
                      <th>Is Compulsary</th>
                    <th>Time </th>
                    
                     <th>Diet Food</th>
                    <th>Remark</th>
                  </thead>
                  <tbody id="firsttd">
                    <input class="form-control"  style="display: none" type="hidden" value="1" name="tab3mycount" id="mycounttab3">
                      <input type="hidden" name="tab3exerciselevelday" value="3">
                    <tr id="tab3firsttr1" class="tab3item">
                  <td style="width: 30%!important">
                <div class="form-group">
                  
                  <select class="form-control selectpicker"data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" name="tab3mealname1" >
                    <option value="" disabled="" selected="">--Please select--</option>
                  @foreach($meals as $meal)
               <option value="{{$meal->mealmasterid}}" {{$meal->mealmasterid == 1 ?'selected':'' }} >{{$meal->mealname}}</option>
                  @endforeach
                  </select>
                </div>   
                </td>
                  <td>
                   <div class="form-group">
                    <label class="switch" style="margin-bottom: 0px !important;">
                    <input type="checkbox" name="tab3iscompulsary1" value="1">
                     <span class="slider round"></span>
                    </label>
                  </div>
                </td>
                <td>
                  <div class="form-group">

                  <input id="" value="" data-default="20:48" class="form-control input-a number" placeholder="Time" name="tab3time1" autocomplete="off" onkeypress="return false">
                  </div>
                </td>
               
                <td style="width: 30%!important">
                     <div class="form-group">
                  <select  class="select2" data-placeholder="Select Multiple Tags" multiple=""  style="width: 100%;" tabindex="-1" aria-hidden="true" name="tab3items1[]">
                    @foreach($dietitems as $dietitem)
                    <option value="{{$dietitem->dietitemid}}">{{$dietitem->dietitem}}</option>
                    @endforeach
                  </select>
                 
                  </div>
                </td>
                <td>
                  <div class="form-group ">

                  <input type="text" name="tab3instruction1" class="form-control">
                  </div>
                </td>
                
                
              </tr>
        </tbody>
      
              </table>
               <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-5"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab3" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1" >
                    <div class="form-group"  >
                  <div class="tab3rmvitem" >
              
            </div>
                </div>
                </div>
                <div class="col-lg-5"></div>

              </div>
       <!--    <div class="col-lg-12" style="text-align: center;">
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
              </div>
              <!-- /.tab-pane -->

<!--***********************************tab4************************************************ -->              
              <div class="tab-pane" id="day4">
                  <textarea name="daynote4" placeholder="Day 4 Note...." class="form-control"></textarea>
            <!-- tab4 -->
             <table>
                  <thead> 
                    <th>Meal Type</th>
                    <th>Is Compulsary</th>
                    <th>Time </th>
                    
                    <th>Diet Food</th>
                    <th>Remark</th>
             
                  </thead>
                  <tbody id="firsttd">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab4mycount" id="mycounttab4">
                      <input type="hidden" name="tab4exerciselevelday" value="4">
                    <tr id="tab4firsttr1" class="tab4item">
                  <td style="width: 30%!important">
                <div class="form-group">
                  
                  <select class="form-control selectpicker"data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" name="tab4mealname1">
                    <option value="" disabled="" selected="">--Please select--</option>
                  @foreach($meals as $meal)
                  <option value="{{$meal->mealmasterid}}" {{$meal->mealmasterid == 1 ?'selected':'' }} >{{$meal->mealname}}</option>
                  @endforeach
                  </select>
                </div>   
                </td>
                  <td>
                   <div class="form-group">
                    <label class="switch" style="margin-bottom: 0px !important;">
                    <input type="checkbox" name="tab4iscompulsary1" value="1">
                     <span class="slider round"></span>
                    </label>
                  </div>
                </td>
                  <td >
                  <div class="form-group">

                 <input id="input-a" value="" data-default="20:48" class="form-control input-a number" placeholder="Time" name="tab4time1" autocomplete="off" onkeypress="return false">
                  </div>
                </td>
               
                  <td style="width: 30%!important">
                       <div class="form-group">
                  <select class="select2" data-placeholder="Select Multiple Tags" multiple=""  style="width: 100%;" tabindex="-1" aria-hidden="true"name="tab4items1[]">
                    @foreach($dietitems as $dietitem)
                    <option value="{{$dietitem->dietitemid}}">{{$dietitem->dietitem}}</option>
                    @endforeach
                  </select>
                 
                  </div>
                </td>
                <td>
                  <div class="form-group ">

                  <input type="text"  name="tab5instruction1" class="form-control">
                  </div>
                </td>
                
                
              </tr>
        </tbody>
      
              </table>
                    <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-5"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab4" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1" >
                    <div class="form-group"  >
                  <div class="tab4rmvitem" >
              
            </div>
                </div>
                </div>
                <div class="col-lg-5"></div>

              </div>
      <!--     <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-6">
                   <div class="form-group" style="text-align: right">
                  <button type="button"id="add1" class="btn bg-green addtab4" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group"  style="text-align: left">
                  <div class="col-lg-1 tab4rmvitem" style="margin-top: -990px;">
              
            </div>
                </div>
                </div>

              </div> -->
              </div>

<!--***********************************tab2************************************************ -->
  <div class="tab-pane" id="day5">
      <textarea name="daynote5" placeholder="Day 5 Note...." class="form-control"></textarea>
            <!-- tab5 -->
             <table>
                  <thead> 
                    <th>Meal Type</th>
                    <th>Is Compulsary</th>
                    <th>Time </th>
                    
                    <th>Diet Food</th>
                    <th>Remark</th>
                    
             
                  </thead>
                  <tbody id="firsttd">
                    <input class="form-control"  style="display: none" type="hidden" value="1" name="tab5mycount" id="mycounttab5">
                      <input type="hidden" name="tab5exerciselevelday" value="5">
                    <tr id="tab5firsttr1" class="tab5item">
                  <td style="width: 30%!important">
                <div class="form-group">
                  
                  <select class="form-control selectpicker"data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" name="tab5mealname1" >
                    <option value="" disabled="" selected="">--Please select--</option>
                  @foreach($meals as $meal)
                  <option value="{{$meal->mealmasterid}}" {{$meal->mealmasterid == 1 ?'selected':'' }} >{{$meal->mealname}}</option>
                  @endforeach
                  </select>
                </div>   
                </td>
                  <td>
                   <div class="form-group">
                    <label class="switch" style="margin-bottom: 0px !important;">
                    <input type="checkbox" name="tab5iscompulsary1" value="1">
                     <span class="slider round"></span>
                    </label>
                  </div>
                </td>
                <td >
                  <div class="form-group">

                 <input id="input-a" value="" class="form-control input-a number" placeholder="Time" name="tab5time1" autocomplete="off" onkeypress="return false">
                  </div>
                </td>
                
                  <td style="width: 30%!important">
                       <div class="form-group">
                  <select class="select2" data-placeholder="Select Multiple Tags" multiple=""  style="width: 100%;" tabindex="-1" aria-hidden="true"name="tab5items1[]">
                    @foreach($dietitems as $dietitem)
                    <option value="{{$dietitem->dietitemid}}">{{$dietitem->dietitem}}</option>
                    @endforeach
                  </select>
                 
                  </div>
                </td>
                <td>
                  <div class="form-group ">

                  <input type="text"  name="tab5instruction1" class="form-control">
                  </div>
                </td>
                
                
              </tr>
        </tbody>
      
              </table>
           <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-5"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab5" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1" >
                    <div class="form-group"  >
                  <div class="tab5rmvitem" >
              
            </div>
                </div>
                </div>
                <div class="col-lg-5"></div>

              </div>
              </div>



<!--***********************************tab2************************************************ -->
<div class="tab-pane" id="day6">
    <textarea name="daynote6" placeholder="Day 6 Note...." class="form-control"></textarea>
            <!-- tab6 -->
             <table>
                  <thead> 
                    <th>Meal Type</th>
                    <th>Is Compulsary</th>
                    <th>Time</th>
                   
                    <th>Diet Food</th>
                    <th>Remark</th>
                  </thead>
                  <tbody id="firsttd">
                    <input class="form-control " style="display: none" type="hidden" value="1" name="tab6mycount" id="mycounttab6">
                      <input type="hidden" name="tab6exerciselevelday" value="6">
                    <tr id="tab6firsttr1" class="tab6item">
                  <td style="width: 30%!important">
                <div class="form-group">
                  
                  <select class="form-control selectpicker"data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  name="tab6mealname1" >
                    <option value="" disabled="" selected="">--Please select--</option>
                  @foreach($meals as $meal)
                  <option value="{{$meal->mealmasterid}}" {{$meal->mealmasterid == 1 ?'selected':'' }} >{{$meal->mealname}}</option>
                  @endforeach
                  </select>
                </div>   
                </td>
                  <td>
                   <div class="form-group">
                    <label class="switch" style="margin-bottom: 0px !important;">
                    <input type="checkbox" name="tab6iscompulsary1" value="1">
                     <span class="slider round"></span>
                    </label>
                  </div>
                </td>
                <td >
                  <div class="form-group">
                      <input id="input-a" value="" class="form-control input-a number" placeholder="Time" name="tab6time1" autocomplete="off" onkeypress="return false">
                  <!-- <input type="time" value="0" name="tab6time1" class="form-control  number"> -->
                  </div>
                </td>
             
                  <td style="width: 30%!important">
                      <div class="form-group">
                  <select class="select2" data-placeholder="Select Multiple Tags" multiple=""  style="width: 100%;" tabindex="-1" aria-hidden="true" name="tab6items1[]">
                    @foreach($dietitems as $dietitem)
                    <option value="{{$dietitem->dietitemid}}">{{$dietitem->dietitem}}</option>
                    @endforeach
                  </select>
                 
                  </div>
                </td>
                <td>
                  <div class="form-group ">

                  <input type="text"  name="tab6instruction1" class="form-control">
                  </div>
                </td>
                
                
              </tr>
        </tbody>
      
              </table>
                 <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-5"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab6" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1" >
                    <div class="form-group"  >
                  <div class="tab6rmvitem" >
              
            </div>
                </div>
                </div>
                <div class="col-lg-5"></div>

              </div>
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
              </div>

<!--***********************************tab2************************************************ -->
<div class="tab-pane" id="day7">
    <textarea name="daynote7" placeholder="Day 7 Note...." class="form-control"></textarea>
            <!-- tab7 -->
             <table>
                  <thead> 
                    <th>Meal Type</th>
                    <th>Is Compulsary</th>
                    <th>Time </th>
                    
                    <th>Diet Food</th>
                    <th>Remark</th>
             
                  </thead>
                  <tbody id="firsttd">
                    <input class="form-control" style="display: none" type="hidden" value="1" name="tab7mycount" id="mycounttab7">
                      <input type="hidden" name="tab7exerciselevelday" value="7">
                    <tr id="tab7firsttr1" class="tab7item">
                  <td style="width: 30%!important">
                <div class="form-group">
                  
                  <select class="form-control selectpicker"data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  name="tab7mealname1">
                    <option value="" disabled="" selected="">--Please select--</option>
                  @foreach($meals as $meal)
                  <option value="{{$meal->mealmasterid}}" {{$meal->mealmasterid == 1 ?'selected':'' }} >{{$meal->mealname}}</option>
                  @endforeach
                  </select>
                </div>   
                </td>
                  <td>
                   <div class="form-group">
                    <label class="switch" style="margin-bottom: 0px !important;">
                    <input type="checkbox" name="tab7iscompulsary1" value="1">
                     <span class="slider round"></span>
                    </label>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                     <input value="" class="form-control input-a number" placeholder="Time" name="tab7time1" autocomplete="off" onkeypress="return false">
              
                  </div>
                </td>
               
                  <td style="width: 30%!important">
                       <div class="form-group">
                  <select class="select2" data-placeholder="Select Multiple Tags" multiple=""  style="width: 100%;" tabindex="-1" aria-hidden="true" name="tab7items1[]">
                    @foreach($dietitems as $dietitem)
                    <option value="{{$dietitem->dietitemid}}">{{$dietitem->dietitem}}</option>
                    @endforeach
                  </select>
                 
                  </div>
                </td>
                <td>
                  <div class="form-group ">

                  <input type="text"  name="tab7instruction1" class="form-control">
                  </div>
                </td>
                
                
              </tr>
        </tbody>
      
              </table>
                 <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-5"></div>
                <div class="col-lg-1">
                   <div class="form-group" >
                  <button type="button"id="add1" class="btn bg-green addtab7" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-1" >
                    <div class="form-group"  >
                  <div class="tab7rmvitem" >
              
            </div>
                </div>
                </div>
                <div class="col-lg-5"></div>

              </div>
       <!--    <div class="col-lg-12" style="text-align: center;">
                <div class="col-lg-6">
                   <div class="form-group" style="text-align: right">
                  <button type="button"id="add1" class="btn bg-green addtab7" ><i class="fa fa-plus">Add</i></button>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group"  style="text-align: left">
                  <div class="col-lg-1 tab7rmvitem" style="margin-top: -990px;">
              
            </div>
                </div>
                </div>

              </div> -->
              </div>

<!--***********************************tab2************************************************ -->
            </div>
           <div class="col-lg-12 box"> <center>
            <br><br>
                <div class="form-group">
                   <input type="button" name="day1btn" id="day1btn" class="btn bg-orange  " value="Tuesday" >
                   <input type="button" name="day2btn" id="day2btn" class="btn bg-orange " style="display: none;" value="Wednesday">
                   <input type="button" name="day3btn" id="day3btn" class="btn bg-orange "style="display: none;" value="Thrusday">
                   <input type="button" name="day4btn"  id="day4btn" class="btn bg-orange " style="display: none;" value="Friday">
                    <input type="button" name="day5btn"  id="day5btn" class="btn bg-orange "style="display: none;" value="Saturday">
                      <input type="button" name="day6btn"  id="day6btn" class="btn bg-orange "style="display: none;" value="Sunday">

                 <input type="submit" name="submit" id="day7btn" class="btn bg-orange" style="display: none;">
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
    
  
</div>

</div>


</div>
</div>
</section>


    <script type="text/javascript">
      var input = $('.input-a');
input.clockpicker({
    autoclose: true
});

// Manual operations
$('#button-a').click(function(e){
    // Have to stop propagation here
    e.stopPropagation();
    input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
});
$('#button-b').click(function(e){
    // Have to stop propagation here
    e.stopPropagation();
    input.clockpicker('show')
            .clockpicker('toggleView', 'hours');
});
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
 $('#day6btn').show();
 });


    
 $('#day6btn').on('click',function(){
$('a[href="#day7"]').click();
 $('#day6btn').hide();
 $('#day7btn').show();
 });
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
    var ap='<tr id="tab1firsttr'+counttab1+'" class="tab1item"><td><div class="form-group"><select class="form-control  exercisename select2" name="tab1mealname'+counttab1+'"><option value="" disabled  selected="">--Please select--</option>         <?php foreach($meals as $meal1)
    { 
      echo '<option value="'.$meal1->mealmasterid.'">'.$meal1->mealname.'</option> '; 
    } 
?>
                    </select></div></td><td><div class="form-group">                   <label class="switch" style="margin-bottom: 0px !important;"><input type="checkbox" name="tab1iscompulsary'+counttab1+'" value="1"></input><span class="slider round"></span></label></div></td><td><div class="form-group"><input value="" class="form-control input-a number" placeholder="Time" name="tab1time'+counttab1+'" autocomplete="off" onkeypress="return false"></div></td><td><div class="form-group"><select  class="form-control select2 mealname" multiple="" data-placeholder="Select Multiple Items" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="tab1items'+counttab1+'[]">                <?php foreach($dietitems as $dietitem1)
    { 
      echo '<option value="'.$dietitem1->dietitemid.'">'.$dietitem1->dietitem.'</option> '; 
    } 
?>  </select> </div></td><td><div class="form-group"><input type="text" name="tab1instruction'+counttab1+'" class="form-control"></div></td></tr>';

    $('.tab1item:last').after(ap);  
 $('.mealname').select2({
     //configuration
    });
  var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
        var rmv = '<div id="tab1rmvbtn'+counttab1+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab1('+counttab1+')"><i class="fa fa-close">Remove</i></button></div>';

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
  
  //   $('input[name="tab1set'+counttab1+'"').keypress(function(e){
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
  });


 
          });

  function removetab1(counttab1)
      {
      
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
    var ap='<tr id="tab2firsttr'+counttab2+'" class="tab2item"><td><div class="form-group"><select class="form-control exercisename" name="tab2mealname'+counttab2+'"><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($meals as $meal2)
    { 
      echo '<option value="'.$meal2->mealmasterid.'">'.$meal2->mealname.'</option> '; 
    } 
?>
                    </select></div></td><td><div class="form-group">                   <label class="switch" style="margin-bottom: 0px !important;"><input type="checkbox" name="tab2iscompulsary'+counttab2+'" value="1"></input><span class="slider round"></span></label></div></td><td><div class="form-group"><input value="" class="form-control input-a number" placeholder="Time" name="tab2time'+counttab2+'" autocomplete="off" onkeypress="return false"></div></td><td><div class="form-group"><select  class="form-control select2 mealname" multiple="" data-placeholder="Select Multiple Items" style="width: 100%;" tabindex="-1" aria-hidden="true"   name="tab2items'+counttab2+'[]">                <?php foreach($dietitems as $dietitem2)
    { 
      echo '<option value="'.$dietitem2->dietitemid.'">'.$dietitem2->dietitem.'</option> '; 
    } 
?>  </select> </div></td><td><div class="form-group"><input type="text" name="tab2instruction'+counttab2+'" class="form-control"></div></td></tr>';

    $('.tab2item:last').after(ap);  
 $('.mealname').select2({
     //configuration
    });
  var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
        var rmv = '<div id="tab2rmvbtn'+counttab2+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab2('+counttab2+')" ><i class="fa fa-close">Remove</i></button></div>';

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
            
            $(".addtab3").on("click",function(){
                if ($("#mycounttab3").val()!='')
            {
              counttab2= $("#mycounttab3").val();
              
            }
       
        counttab3++;
    var ap='<tr id="tab3firsttr'+counttab3+'" class="tab3item"><td><div class="form-group"><select class="form-control exercisename" name="tab3mealname'+counttab3+'"><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($meals as $meal3)
    { 
      echo '<option value="'.$meal3->mealmasterid.'">'.$meal3->mealname.'</option> '; 
    } 
?>
                    </select></div></td><td><div class="form-group">                   <label class="switch" style="margin-bottom: 0px !important;"><input type="checkbox" name="tab3iscompulsary'+counttab3+'" value="1"></input><span class="slider round"></span></label></div></td><td><div class="form-group"><input value="" class="form-control input-a number" placeholder="Time" name="tab3time'+counttab3+'" autocomplete="off" onkeypress="return false"></div></td><td><div class="form-group"><select  class="form-control select2 mealname" multiple="" data-placeholder="Select Multiple Items" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="tab3items'+counttab3+'[]" >                <?php foreach($dietitems as $dietitem3)
    { 
      echo '<option value="'.$dietitem3->dietitemid.'">'.$dietitem3->dietitem.'</option> '; 
    } 
?>  </select> </div></td><td><div class="form-group"><input type="text" name="tab3instruction'+counttab3+'" class="form-control"></div></td></tr>';

    $('.tab3item:last').after(ap);  
 $('.mealname').select2({
     //configuration
    });
  var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
        var rmv = '<div id="tab3rmvbtn'+counttab3+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab3('+counttab3+')" ><i class="fa fa-close">Remove</i></button></div>';

        count2 = counttab3-1;
        // alert(counttab3);
        $("#tab3rmvbtn"+count2).hide();

        $(".tab3rmvitem:last").after(rmv);

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
            
            $(".addtab4").on("click",function(){
                if ($("#mycounttab4").val()!='')
            {
              counttab4= $("#mycounttab4").val();
              
            }
       
        counttab4++;
    var ap='<tr id="tab4firsttr'+counttab4+'" class="tab4item"><td><div class="form-group"><select class="form-control exercisename" name="tab4mealname'+counttab4+'"><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($meals as $meal4)
    { 
      echo '<option value="'.$meal4->mealmasterid.'">'.$meal4->mealname.'</option> '; 
    } 
?>
                    </select></div></td><td><div class="form-group">                   <label class="switch" style="margin-bottom: 0px !important;"><input type="checkbox" name="tab4iscompulsary'+counttab4+'" value="1"></input><span class="slider round"></span></label></div></td><td><div class="form-group"><input value="" class="form-control input-a number" placeholder="Time" name="tab4time'+counttab4+'" autocomplete="off" onkeypress="return false"></div></td><td><div class="form-group"><select  class="form-control select2 mealname" multiple="" data-placeholder="Select Multiple Items" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="tab4items'+counttab4+'[]">                <?php foreach($dietitems as $dietitem4)
    { 
      echo '<option value="'.$dietitem4->dietitemid.'">'.$dietitem4->dietitem.'</option> '; 
    } 
?>  </select> </div></td><td><div class="form-group"><input type="text" name="tab4instruction'+counttab4+'" class="form-control"></div></td></tr>';

    $('.tab4item:last').after(ap);  
 $('.mealname').select2({
     //configuration
    });
  var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
        var rmv = '<div id="tab4rmvbtn'+counttab4+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab4('+counttab4+')" ><i class="fa fa-close">Remove</i></button></div>';

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
            
            $(".addtab5").on("click",function(){
                if ($("#mycounttab5").val()!='')
            {
              counttab5= $("#mycounttab5").val();
              
            }
       
        counttab5++;
    var ap='<tr id="tab5firsttr'+counttab5+'" class="tab5item"><td><div class="form-group"><select class="form-control exercisename" name="tab5mealname'+counttab5+'"><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($meals as $meal5)
    { 
      echo '<option value="'.$meal5->mealmasterid.'">'.$meal5->mealname.'</option> '; 
    } 
?>
                    </select></div></td><td><div class="form-group">                   <label class="switch" style="margin-bottom: 0px !important;"><input type="checkbox" name="tab5iscompulsary'+counttab5+'" value="1"></input><span class="slider round"></span></label></div></td><td><div class="form-group"><input value="" class="form-control input-a number" placeholder="Time" name="tab5time'+counttab5+'" autocomplete="off" onkeypress="return false"></div></td><td><div class="form-group"><select  class="form-control select2 mealname" multiple="" data-placeholder="Select Multiple Items" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="tab5items'+counttab5+'[]">                <?php foreach($dietitems as $dietitem5)
    { 
      echo '<option value="'.$dietitem5->dietitemid.'">'.$dietitem5->dietitem.'</option> '; 
    } 
?>  </select> </div></td><td><div class="form-group"><input type="text" name="tab5instruction'+counttab5+'" class="form-control"></div></td></tr>';

    $('.tab5item:last').after(ap);  
 $('.mealname').select2({
     //configuration
    });
  var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
        var rmv = '<div id="tab5rmvbtn'+counttab5+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab5('+counttab5+')" ><i class="fa fa-close">Remove</i></button></div>';

        count2 = counttab5-1;
        // alert(counttab5);
        $("#tab5rmvbtn"+count2).hide();

        $(".tab5rmvitem:last").after(rmv);

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
      
        $('#tab5firsttr'+counttab5).remove();
        $('#tab5rmvbtn'+counttab5).remove();
        
    
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
    var ap='<tr id="tab6firsttr'+counttab6+'" class="tab6item"><td><div class="form-group"><select class="form-control exercisename" name="tab6mealname'+counttab6+'"><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($meals as $meal6)
    { 
      echo '<option value="'.$meal6->mealmasterid.'">'.$meal6->mealname.'</option> '; 
    } 
?>
                    </select></div></td><td><div class="form-group">                   <label class="switch" style="margin-bottom: 0px !important;"><input type="checkbox" name="tab6iscompulsary'+counttab6+'" value="1"></input><span class="slider round"></span></label></div></td><td><div class="form-group"><input value="" class="form-control input-a number" placeholder="Time" name="tab6time'+counttab6+'" autocomplete="off" onkeypress="return false"></div></td><td><div class="form-group"><select  class="form-control select2 mealname" multiple="" data-placeholder="Select Multiple Items" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="tab6items'+counttab6+'[]">                <?php foreach($dietitems as $dietitem6)
    { 
      echo '<option value="'.$dietitem6->dietitemid.'">'.$dietitem6->dietitem.'</option> '; 
    } 
?>  </select> </div></td><td><div class="form-group"><input type="text" name="tab6instruction'+counttab6+'" class="form-control"></div></td></tr>';

    $('.tab6item:last').after(ap);  
 $('.mealname').select2({
     //configuration
    });
  var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
        var rmv = '<div id="tab6rmvbtn'+counttab6+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab6('+counttab6+')" ><i class="fa fa-close">Remove</i></button></div>';

        count2 = counttab6-1;
        // alert(counttab6);
        $("#tab6rmvbtn"+count2).hide();

        $(".tab6rmvitem:last").after(rmv);

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
            
            $(".addtab7").on("click",function(){
                if ($("#mycounttab7").val()!='')
            {
              counttab7= $("#mycounttab7").val();
              
            }
       
        counttab7++;
    var ap='<tr id="tab7firsttr'+counttab7+'" class="tab7item"><td><div class="form-group"><select class="form-control exercisename" name="tab7mealname'+counttab7+'"><option value="" disabled="" selected="">--Please select--</option>         <?php foreach($meals as $meal7)
    { 
      echo '<option value="'.$meal7->mealmasterid.'">'.$meal7->mealname.'</option> '; 
    } 
?>
                    </select></div></td><td><div class="form-group">                   <label class="switch" style="margin-bottom: 0px !important;"><input type="checkbox" name="tab7iscompulsary'+counttab7+'" value="1"></input><span class="slider round"></span></label></div></td><td><div class="form-group"><input value="" class="form-control input-a number" placeholder="Time" name="tab7time'+counttab7+'" autocomplete="off" onkeypress="return false"></div></td><td><div class="form-group"><select  class="form-control select2 mealname" multiple="" data-placeholder="Select Multiple Items" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="tab7items'+counttab7+'[]">                <?php foreach($dietitems as $dietitem7)
    { 
      echo '<option value="'.$dietitem7->dietitemid.'">'.$dietitem7->dietitem.'</option> '; 
    } 
?>  </select> </div></td><td><div class="form-group"><input type="text" name="tab7instruction'+counttab7+'" class="form-control"></div></td></tr>';

    $('.tab7item:last').after(ap);  
 $('.mealname').select2({
     //configuration
    });
  var input = $('.input-a');
input.clockpicker({
    autoclose: true
});
        var rmv = '<div id="tab7rmvbtn'+counttab7+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab7('+counttab7+')" ><i class="fa fa-close">Remove</i></button></div>';

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
  $('#dietname').on('keyup',function(){


    var dietname = $('#dietname').val();
    var _token = $('input[name="_token"]').val();

     $.ajax({
      url:"{{ url('checkdietname') }}",
      method:"POST",
      data:{dietname:dietname, _token:_token},
      success:function(result)
      {
       if(result == 'unique')
       {
        $('#error_username').html('<label class="text-success"></label>');
        $('#username').removeClass('has-error');
        $('#firstbtn').attr('disabled', false);
       }
       else
       {
        // alert("hi1");
        $('#error_username').html('<label class="text-danger" style="çolor:red;">Diet  is Already Exist</label>');
        $('#username').addClass('has-error');
        $('#firstbtn').attr('disabled', 'disabled');
       }
      }
     })
       });
</script>
<script type="text/javascript">
    $('#formtab').on('submit', function() { 

      var tab1exercisename1 = $('select[name="tab1mealname1"]').val();
      if(tab1exercisename1 == null || tab1exercisename1 == ''){
        alert('In Monday Please Select Meal Type');
          return false;
      }
      var tab2exercisename1 = $('select[name="tab2mealname1"]').val();
      if(tab2exercisename1 == null || tab2exercisename1 == ''){
        alert('In Tuesday Please Select  Meal Type');
          return false;
      }
      var tab3exercisename1 = $('select[name="tab3mealname1"]').val();
      if(tab3exercisename1 == null || tab3exercisename1 == ''){
        alert('In Wednesday Please Select  Meal Type');
          return false;
      }
        var tab4exercisename1 = $('select[name="tab4mealname1"]').val();
      if(tab4exercisename1 == null || tab4exercisename1 == ''){
        alert('In Day 4 Please Select  Meal Type');
          return false;
      }
        var tab5exercisename1 = $('select[name="tab5mealname1"]').val();
      if(tab5exercisename1 == null || tab5exercisename1 == ''){
        alert('In Thrusday Please Select  Meal Type');
          return false;
      }
        var tab6exercisename1 = $('select[name="tab6mealname1"]').val();
      if(tab6exercisename1 == null || tab6exercisename1 == ''){
        alert('In Friday Please Select  Meal Type');
          return false;
      }
        var tab7exercisename1 = $('select[name="tab7mealname1"]').val();
      if(tab7exercisename1 == null || tab7exercisename1 == ''){
        alert('In Saturday Please Select  Meal Type');
          return false;
      }
      if($('.exercisename')[0]){
             var exercisename = $('.exercisename').val();
     
      if(exercisename == null || exercisename == ''){
        // alert(exercisename);
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

@endsection