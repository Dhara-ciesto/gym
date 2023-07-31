<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
   </head>
   <style>
      td {
      border-bottom: 1px solid #ddd;
      margin: 5px;
      border-color: gray;
      }
   </style>
   <body>
      <div>
         <div style="float: left">
            <img style="width: 100px" src="images/fitness5.png">
         </div>
         <div style="float: left;margin-left: 8px;">
            <b><font size="3">Fitness 5</font></b>
            
             <font size="2">
            <br>
            @php $total_amount_display = 0; @endphp    

           C/o. “Siddhi Vinayak Health Care",<br/>  
            GSTIN:  27ADVFS1013R1ZD <br/>
            35/148, Laxmi Vijay Premises <br/>
            Laxmi Industrial Estate.<br/>
            New Link Road. Andheri (W).<br/> Mumbai 400053
            Mo. : +917048880005</font>
            </p>
         </div>
         <div style="float: right">
            <b>Invoice No:</b>  {{$payment->invoiceno }} 
            <br>
            <b>Date:</b>  {{ date('d-m-Y', strtotime($payment->paymentdate)) }}
            <br>
            <b>UserId:</b>  {{$payment->userid}}
            <br/>
            <b>{{ ucfirst($registration_data->firstname) }} {{ ucfirst($registration_data->lastname) }}</b>
       
         </div>
      </div>
      <br>
      <br>
      <div>
         <br>
         <br>
         <font size="2">
         <table style="margin: 5px;  margin-top:70px;   " width=100% cellpadding="5px;" cellspacing="0px">
            <thead>
               <tr>
                  <th style="border:none;"><font size="3">Trial Package Information</font></th>
               </tr>
               <tr style=" border-left: thick solid; border-top: thick solid;border-bottom:bold solid; border:1px; border-color: gray:">

                  <th  style="border-color: gray;border-left:thick solid; border-top: thick solid;border-bottom:thick solid;border-color: gray;">Package</th>
                  <th style="border-color: gray; border-top: thick solid;border-bottom:thick solid;border-color: gray;">Duration</th>
                  <th  style="border-color: gray;border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: gray;" >Amount</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td style="border-color: gray;border-left:thick solid;border-color: gray;">{{$scheme->schemename}}</td>
                  <td>{{date('j F, Y', strtotime($registration_data->starting_date))}}  to {{date('j F, Y', strtotime($registration_data->ending_date))}}</td>
                  <td  style="border-color: gray;text-align: right;border-color: gray; border-right:thick solid;border-color: gray;"
                     ><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $payment->actualamount }}</td>
               </tr>
               <tr>
                  <td colspan="1"style="border-color: gray;border-left:thick solid;border-color: gray;">
                  </td>
                  <td  style="border-color: gray;text-align: right;border-color: gray"><b>Total</b></td>
                  <td  style="border-color: gray;text-align: right;border-right:thick solid;border-color: gray;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$payment->actualamount}}</td>
               </tr>
               <tr>
                  <td colspan="1"style="border-color: gray;border-left:thick solid;border-bottom:thick solid;border-color: gray;">
                  </td>
                  <td  style="border-color: gray;text-align: right;border-bottom:thick solid;border-color: gray;"><b>Total In Words</b></td>
                  <td  style="border-color: gray;text-align: right;border-right:thick solid; border-bottom:thick solid;border-color: gray; "> {{$word}} 
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <font size="1">
         <table style="margin: 5px;  margin-top:60px;" width=100% cellpadding="5px;" cellspacing="0px">
            <thead>
               <tr>
                  <th style="border:none; width: 160px;"><font size="3">Payment Information</font></th>
               </tr>
               <tr style="border-color: gray;border-right: thick solid; border-left: thick solid; border-top: thick solid;border-bottom:thick solid; border:1px;border-color: gray;">
                  <th style=" border-color: gray;border-left: thick solid; border-top: thick solid;border-bottom:thick solid;border-color: gray;">Receipt & Date</th>
                  <th style="border-top: thick solid;border-bottom:thick solid;border-color: gray;">Payment Type</th>
                  <th style="border-color: gray;border-top: thick solid;border-bottom:thick solid;border-color: gray;">Cheque/
                     <br>Card Info
                  </th>
                  <th style=" border-color: gray;border-top: thick solid;border-bottom:thick solid;border-color: gray;">Collected By</th>
                  <th style="border-color: gray; border-top: thick solid;border-bottom:thick solid;border-color: gray; width: 100px;">Details</th>
                  <th  style="border-color: gray;border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: gray;">Amount</th>
               </tr>
            </thead>
            <tbody>
               @foreach($payment_mode as $key=>$payment)

               <tr>
                  <td style="width: 120px; border-color: gray;border-left:thick solid;border-color: gray;">{{ $payment->receiptno }} <b>#</b> {{date('j F, Y', strtotime($payment->paymentdate))}}</td>
                  <td>{{$payment->mode}}</td>
                  <td>{{$payment->remarks}}</td>
                  <td>{{$takenby}}</td>
                  <td style="border-color: gray;border-color: gray; width: 100px;">Amount :<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payment->amount}} <br>
                  </td>
                  <td style="border-color: gray;text-align: right;border-right:thick solid;border-color: gray;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$payment->amount}}</td>
               </tr>
               @endforeach
               <tr>
                  <td style="border-color: gray;border-left:thick solid;border-color: gray;"></td>
                  <td></td>
                  <td><b>Total</b></td>
                  <td></td>
                  <td style="width: 100px;"></td>
                  <td  style="border-color: gray;text-align: right;border-right:thick solid;border-color: gray;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$payment->actualamount}}</td>
               </tr>
               
               <tr>
                  <td style="border-color: gray;border-left:thick solid; border-bottom: thick solid; border-color: gray;"></td>
                  <td style="border-color: gray;border-bottom: thick solid;border-color: gray;"></td>
                  <td style="border-color: gray;border-bottom: thick solid;border-color: gray;"><b>Total In Words</b></td>
                  <td colspan="3" style="border-color: gray;text-align: right;border-right:thick solid;border-bottom: thick solid;border-color: gray;"> {{$word}}</td>
               </tr>
               
            </tbody>
         </table>
         <br><br><br><br>
            
      <table  width="100%">
         <br>
         <br><br>
         <br>
         <br>
         <tr>
            <td style="border:none">
               MEMBER  SIGNATURE<br/>
            </td>
            <td  style="border:none; text-align:right;">  ADMIN SIGNATURE</td>
         </tr>
      </table>
      </div>
   </body>
</html>