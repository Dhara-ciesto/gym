<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
</head>
<style>
  td {
    border-bottom: 1px solid #ddd;
    margin: 5px;
    border-color: #CACFD2;

  }
  p { page-break-after: always; }
  .footer {
    bottom: 0px;
  }
  .footer {
    width: 100%;
    text-align: right;
    position: fixed;
    font-size: 12px;
  }


</style>
<body>
  <div>
    <div style="float: left">
      <img style="width: 100px" src="images/fitness5.png">
    </div>
    <div style="float: left;margin-left: 8px;">
      <b><font size="3">Fitness5</font></b>
      <br>   
      <font size="2">
       <br>
       @php $total_amount_display = 0; $add_discount = 0;@endphp             
      C/o. “Siddhi Vinayak Health Care",<br/>  
GSTIN:  27ADVFS1013R1ZD <br/>
35/148, Laxmi Vijay Premises <br/>
Laxmi Industrial Estate.<br/>
New Link Road. Andheri (W).<br/> Mumbai 400053
Mo. : +917048880005
     </p>
   </div>
   <div style="float: right">
    <b>Invoice No:</b>  O{{$payment[0]->invoiceno}}
    <br>
    <b>Date:</b>  {{ date('d-m-Y', strtotime($total_payment->paymentdate))}}
    <br>
    <b>MemberId:</b>  {{$payment[0]->memberid}}
    <br>

    <b>Mobile No.</b>  {{$phoneno}}
    @if($companyName)
    <br>  <b>{{ ucfirst($companyName)  }}</b>
    <br>
    <b>C/O.</b> {{ucfirst($member_data->firstname)}} {{ucfirst($member_data->lastname)}}
    <br> <b>GST No: </b> {{ $Gstno }}
    @else
    <br>
    <b>{{ ucfirst($member_data->firstname) }} {{ ucfirst($member_data->lastname) }}</b>

    @endif
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
      <tr><th style="border:none;"><font size="3">FreezeMembership Information</font></th></tr>
      <tr style=" border-left: thick solid; border-top: thick solid;border-bottom:bold solid; border:1px; border-color: #CACFD2:">

        <th style="border-left:thick solid; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Name</th>
        <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Freeze Start Date</th>
        <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Freeze End Date</th>

        <th  style="border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: #CACFD2;" >Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border-left:thick solid;border-color: #CACFD2;">
          {{ ucfirst($member_data->firstname) }} {{ ucfirst($member_data->lastname) }}
        </td>
        <td>{{date('j F, Y', strtotime($freezememberhipstartdate))}}</td>

        <td>{{date('j F, Y', strtotime($freezememberhipenddate))}}</td>
        <td  style="text-align: right;border-right:thick solid;border-color: #CACFD2;"
        ><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $transaction_data->transactionbaseamount }}</td>
      </tr>
                      <tr>
                        <td colspan="1"style="border-left:thick solid;border-color: #CACFD2;">

                        </td>
                        <td></td>
                        <td style="text-align: right"><b>GST ( {{ $transaction_data->transactiontax }} %)</b></td>
                        <td  style="text-align: right;border-right:thick solid;border-color: #CACFD2;" border-right:thick solid;><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$transaction_data->transactiontaxamount}}</td>
                      </tr>
                      <tr>
                        <td colspan="1"style="border-left:thick solid;border-color: #CACFD2;">
                        </td>
                        <td></td>
                        <td  style="text-align: right;border-color: #CACFD2"><b>Total</b></td>
                        <td  style="text-align: right;border-right:thick solid;border-color: #CACFD2;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$transaction_data->transactionamount}}</td>
                      </tr>
                      <tr>
                        <td colspan="1"style="border-left:thick solid;border-bottom:thick solid;border-color: #CACFD2;">

                        </td>
                        <td style="border-bottom:thick solid;border-color: #CACFD2;"></td>
                        <td  style="text-align: right;border-bottom:thick solid;border-color: #CACFD2;"><b>Total In Words</b></td>
                        <td  style="text-align: right;border-right:thick solid; border-bottom:thick solid;border-color: #CACFD2; "> {{$word}} 

                        </td>
                      </tr>
                    </tbody>
                  </table>

                </div>
                <font size="1">
                  <table style="margin: 5px;  margin-top:60px;" width=100% cellpadding="5px;" cellspacing="0px">
                    <thead>
                     <tr><th style="border:none; width: 160px;"><font size="3">Payment Information</font></th></tr><tr style="border-color: #CACFD2;border-right: thick solid; border-left: thick solid; border-top: thick solid;border-bottom:thick solid; border:1px;border-color: #CACFD2;">
                      <th style=" border-left: thick solid; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Receipt No & Date</th>
                      <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Payment Type</th>
                      <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Cheque/
                        <br>Card Info</th>
                        <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Collected By</th>
                        <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2; width: 100px;">Details</th>
                        <th  style="border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: #CACFD2;">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($payment as $key=>$payment)

                      <tr>

                        <td style="width: 120px;border-left:thick solid;border-color: #CACFD2;"><span style="font-size: 13px;">{{ $payment->receiptno }}</span> <b>#</b> {{date('j F, Y', strtotime($payment->paymentdate))}}</td>
                        <td>{{$payment->mode}}</td>
                        <td>{{$payment->remarks}}</td>
                        <td>{{ !empty($takenby) ? ucfirst($takenby) : ''}}</td>
                        @php
                        $percentage = $payment->tax;
                        $perc = ($percentage / 100) * $payment->amount;
                        $amount_added = $payment->amount - $perc;
                        $total_amount_display = $total_amount_display + $amount_added + $perc;
                        @endphp
                        <td style=" border-color: #CACFD2; width: 100px;">Amount :<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payment->amount - $perc}} <br>
                          Tax :<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$perc}} </td>
                          <td style="text-align: right;border-right:thick solid;border-color: #CACFD2;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$payment->amount}}</td>

                        </tr>


                        @endforeach
                        <tr>

                          <td style="border-left:thick solid;border-color: #CACFD2;"></td>
                          <td></td>
                          <td><b>Total</b></td>
                          <td></td>

                          <td style="width: 100px;"></td>
                          <td  style="text-align: right;border-right:thick solid;border-color: #CACFD2;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$total_amount_display}}</td>
                        </tr>
                        @if($totalpay)
                       <tr>
                       
                        <td style="border-left:thick solid; border-bottom: thick solid; border-color: #CACFD2;"></td>
                       <td style="border-bottom: thick solid;border-color: #CACFD2;"></td>
                           <td style="border-bottom: thick solid;border-color: #CACFD2;"><b>Total In Words</b></td>
                       
                        <td colspan="3" style="text-align: right;border-right:thick solid;border-bottom: thick solid;border-color: #CACFD2;"> {{  $totalpay}}</td>
                     </tr> 
                     @endif 
                      </tbody>
                    </table>
                    <div>
                  </font>
                </div>
                <br>
                <br>
                <br>
                <table  width="100%"> 
                  <br>
                  <br><br>
                  <br>
                  <br>
                  <tr>
                    <td style="border:none">
                     MEMBER  SIGNATURE<br/>
                   </td>


                   <td  style="border:none; text-align:right;">  ADMIN SIGNATURE</td></tr></table>
                 </div>
                 <div class="footer"> {{ !empty($takenby) ? ucfirst($takenby) : ''}} : {{ date('d-m-Y', strtotime(date('Y-m-d'))) }}</div>
               </body>
               </html>  
