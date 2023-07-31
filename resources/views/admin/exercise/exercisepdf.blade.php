<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
</head>

<style>
    body {
        text-align: justify;
        text-justify: inter-word;
        margin-left: 10px;
        margin-right: 10px;
        font-size: 11;
    }

    .text {
        font-size: 10;
    }

    #footer {
        position: fixed;
        bottom: -30px;
        left: 0px;
        right: 0px;
        height: 50px;
        /** Extra personal styles **/
        background-color: white;
        color: black;
        text-align: right;
    }

  /*  #footer.page:after {
        content: counter(page, upper-roman);
    }
    */
    td {
       border-bottom: 1px solid #ddd;
        margin-left: 5px;
        border-color: #CACFD2 ;

       /* border-bottom: 1px solid #ddd;
        border-right: 1px thin gray;
        margin: 5px;
        border-color: gray;*/
    }

    p {}

    table {}

    .pagenum:before {
        content: counter(page);
    }
</style>

<body>
        <!--   <div><span class="pagenum"  style="float: left; margin-top: 2px; margin-bottom: 2px;"></span></div>
          <div style="float: right;" ><span >signature</span></div> -->
    </footer>

    <div>
      <div style="float: left">
        <img style="width: 100px" src="images/fitness5.png">
      </div>
      <div style="float: left;margin-left: 8px;"> <b><font size="3">Fitness 5</font></b>
        <br> <font size="2">

					GSTIN:  24BDLPG2978J1Z7 <br/>
					"Kruna Nidhan" <br/>
					Kotecha Chowk, <br/>
					Rajkot 360005. <br/>
					Email:info@fitness5.in <br/>
					Mo. : 0281 2583005/2587005 <br></font>
      </div>
      <div style="float: right"> <b>Name: {{ ucfirst($data['firstname'])}} {{ucfirst($data['lastname'])}}</b>
        <br> <b>MobileNo:</b>{{$data['mobileno']}}</div>
    </div>
    <br>
    <br>


    <div>
      <br>
        <table style="margin: 5px;  margin-top:70px;" width=100% cellpadding="5px;" cellspacing="0px" >

                <thead>
                    <tr><th style="border:none;text-align:center;" colspan="7" ><font size="3">WorkoutPlan 1 Information</font> <b style="text-align: right; font-size: 16px;"></b></th></tr>
                    <tr><th style=" text-align:left;  border-top: thick solid;border-left: thick solid;border-right: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;" colspan="7"><font size="3">  {{ ucfirst($data['workoutname'])}}
 </font></th></tr>
                    <tr style=" border-left: thick solid; border-top: thick solid;border-bottom:bold solid; border:1px; border-color: #CACFD2  :">
                     <th style="border-left:thick solid;color:white; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;">&nbsp;</th>
                     <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;">Header</th>
                <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;">Exercise</th>
   <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;">Exercise Set</th>
                <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;">Time(Min)</th>

                <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;">Repetition</th>

                   <th  style="border-right: thick solid; border-top: thick solid;border-bottom:thick solid; border-color: #CACFD2  ;">Instruction</th>

                <!--   <th style="border-color: #CACFD2  ; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2  ;">Duration</th>
                <th  style="border-color: #CACFD2  ;border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: #CACFD2  ;">Amount</th> -->
                </tr>
                </thead>
       <tbody style="border-bottom: thick solid; border-color: #CACFD2  ;">

         @foreach($exe as $key=>$exe1)
 @if($key > 0)
         @if($exe[$key-1]['exerciseday'] != $exe[$key]['exerciseday'])
         <tr ><td style="text-align:left" font-size: 12; border-left:thick solid;border-right:thick solid;border-color: #CACFD2  ;" colspan="7"><b>{{$exe1['exerciseday'] == 1 ? 'Monday' :''}} {{$exe1['exerciseday'] == 2 ? 'Tuesday' :''}} {{$exe1['exerciseday'] == 3 ? 'Wednesday' :''}} {{$exe1['exerciseday'] == 4 ? 'Thrusday' :''}} {{$exe1['exerciseday'] == 5 ? 'Friday' :''}} {{$exe1['exerciseday'] == 6 ? 'Saturday' :''}}{{$exe1['exerciseday'] == 7 ? 'Sunday' :''}} </b></td></tr>
         @endif
         @else
         <tr><td style=" font-size: 12;border-left:thick solid;border-right:thick solid;border-color: #CACFD2  ;"colspan="7"> <b>{{$exe1['exerciseday'] == 1 ? 'Monday' :''}}</b></td></tr>
         @endif
                    <tr>
                      <td style="border-left:thick solid;border-color: #CACFD2  ;">&nbsp;</td>
                      <td >{{ ucfirst($exe1->header)}}</td>

                      <td >{{ ucfirst($exe1->exercise->exercisename)}}</td>

                      <td>{{ $exe1->memberexerciseset != '0' && $exe1->memberexerciseset != ''? $exe1->memberexerciseset : '' }}
                      </td>
                      <td>{{ $exe1->memberexercisetime != '0' ? $exe1->memberexercisetime : '' }} <!-- {{date('j F, Y', strtotime($exe1['fromdate']))}}  to {{date('j F, Y', strtotime($exe1['todate']))}} --></td>
                      <td> {{ $exe1['memberexerciserep'] > 0 ? $exe1['memberexerciserep'] :'' }}</td>

                      <td style="border-right:thick solid;border-color: #CACFD2  ;"> {{$exe1['memberexerciseins']}}  </td>

                    </tr>


                    @endforeach

                 </tbody>
              </table>




              </font>
         </div>

          <div  style="font-size: 10px; text-align: right;"> {{ !empty($assignby) ? ucfirst($assignby) : ''}} <br> {{ date('d-m-Y', strtotime(date('Y-m-d'))) }}</div>
            <div id="footer">
              <p class="pagenum"></p>
            </div>
   </body>

   </html>
