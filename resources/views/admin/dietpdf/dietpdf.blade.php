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
        margin: 5px;
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
     <table style=" margin-top:70px; margin-bottom: 50px !important;" width=100% cellpadding="5px" cellspacing="0px" >

                <thead>
                    <tr><th style="border:none;text-align:center;" colspan="6" ><font size="3">DietPlan Information</font>  <b style="text-align: right; font-size: 16px;"></b>
    </th>
    </tr>
    <tr>
      <th style=" text-align:center;  border-top: thick solid;border-left: thick solid;border-right: thick solid;border-bottom:thick solid;border-color: #CACFD2 ;" colspan="6"><font size="3"> Diet : {{$data['planname']}} &nbsp; &nbsp;From {{ $data['fromdate'] ? date('j F, Y', strtotime($data['fromdate'])) :''}} &nbsp;&nbsp;To:   {{ $data['todate'] ? date('j F, Y', strtotime($data['todate'])) : '' }}
 </font>
      </th>
    </tr>
    <tr style=" border-left: thick solid; border-top: thick solid;border-bottom:bold solid; border:1px; border-color: #CACFD2 :">
      <th style="border-left:thick solid; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2 ;"></th>
      <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2 ;">Meal Type</th>
      <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2 ;">Items</th>
      <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2 ;">Time</th>
      <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2 ;">Compulsary</th>
      <th style="border-right: thick solid; border-top: thick solid;border-bottom:thick solid; border-color: #CACFD2 ;">Note</th>
      <!--   <th style="border-color: #CACFD2 ; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2 ;">Duration</th>
                <th  style="border-color: #CACFD2 ;border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: #CACFD2 ;">Amount</th> -->
    </tr>
    </thead>
    <tbody style="border-bottom: thick solid; border-color: #CACFD2  ;">@foreach($memberdiet as $key=>$memberdiet1) @if($key > 0) @if($memberdiet[$key-1]['dietday'] != $memberdiet[$key]['dietday'])
      <tr>
        <td style=" font-size: 12;border-left:thick solid;border-right:thick solid;border-color: #CACFD2 ;" colspan="6"><b>{{$memberdiet1['dietday'] == 1 ? 'Monday' :''}} {{$memberdiet1['dietday'] == 2 ? 'Tuesday' :''}} {{$memberdiet1['dietday'] == 3 ? 'Wednesday' :''}} {{$memberdiet1['dietday'] == 4 ? 'Thrusday' :''}} {{$memberdiet1['dietday'] == 5 ? 'Friday' :''}} {{$memberdiet1['dietday'] == 6 ? 'Saturday' :''}}{{$memberdiet1['dietday'] == 7 ? 'Sunday' :''}} </b>
        </td>
      </tr>@endif @else
      <tr>
        <td style=" font-size: 12;border-left:thick solid;border-right:thick solid;border-color: #CACFD2 ;" colspan="6"> <b>{{$memberdiet1['dietday'] == 1 ? 'Monday' :''}}</b>
        </td>
      </tr>@endif
      <tr>
        <td style="border-left:thick solid;border-color: #CACFD2 ;"></td>
        <td>{{ ucfirst($memberdiet1->mealmaster->mealname)}}</td>
        <td>@if($itemnames[$key]) @foreach($itemnames[$key] as $value) {{'' .ucfirst($value)}} @endforeach @endif</td>
        <td>{{ $memberdiet1->diettime != '00:00:00' ? date('h:i a', strtotime($memberdiet1->diettime)) : '' }}</td>
        <td>{{ $memberdiet1['compulsary'] == 1? 'Yes':'No' }}</td>
        <td style=" border-right:thick solid;border-color: #CACFD2 ;">{{$memberdiet1['remark']}}</td>
      </tr>@endforeach</tbody>

    </table>

    </font>
      <div class="footer"  style="font-size: 10px; text-align: right;"> {{ !empty($assignby) ? ucfirst($assignby) : ''}} <br> {{ date('d-m-Y', strtotime(date('Y-m-d'))) }}</div>
  </div>

   <div id="footer">
    <p class="pagenum"></p>
</div>
    </section>

</body>

</html>
