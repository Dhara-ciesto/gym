<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <style>
        td {
            border-bottom: 1px solid #ddd;
            margin: 5px;


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

            <font size="2">
 <br>
  @php $total_amount_display = 0; $add_discount = 0;@endphp
GSTIN:  24BDLPG2978J1Z7 <br/>
"Kruna Nidhan" <br/>
Kotecha Chowk, <br/>
Rajkot 360005. <br/>
Email:info@fitness5.in <br/>
Mo. : 0281 2583005/2587005 <br></font>
                </p>
            </div>
            <div style="float: right">
                <b>Invoice No:</b>  M{{$payment[0]->invoiceno}}
                <br>
                <b>Date:</b>  {{$request->paymentdate}}
                <br>
                <b>MemberId:</b>  {{$payment[0]->memberid}}
                <br>

                <b>Mobile No.</b>  {{$phoneno}}
                @if($companyName)
                <br>  <b>{{ ucfirst($companyName)  }}</b>
                <br>
                <b>C/O.</b> {{ucfirst($member->firstname)}} {{ucfirst($member->lastname)}}
                <br> <b>GST No: </b> {{ $Gstno }}
                @else
                <br>
                <b>{{ ucfirst($member->firstname) }} {{ ucfirst($member->lastname) }}</b>

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
                    <tr><th style="border:none;"><font size="3">Package Information</font></th></tr>
                    <tr style="border-left: thick solid; border-top: thick solid;border-bottom:bold solid; border:1px; border-color: #CACFD2:">

                    <th style="border-left:thick solid; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Package</th>
                <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Duration</th>
                <th  style="border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: #CACFD2;" >Amount</th>
                </tr>
                </thead>
       <tbody>
                    <tr>
                        <td style="border-left:thick solid;border-color: #CACFD2;">
                            @if($tax == 0)
                                Physiotherapy Services
                            @else
                                {{$scheme->schemename}}
                            @endif
                        </td>

                        <td>{{date('j F, Y', strtotime($memberpackage->joindate))}}  to {{date('j F, Y', strtotime($memberpackage->expiredate))}}</td>
                          <td  style="text-align: right; border-right:thick solid;border-color: #CACFD2;"
                          ><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $payment1->schemebaseprice }}</td>
                    </tr>


                     @if($discount > 0 )
                    <tr>

                        <td colspan="1"style="border-left:thick solid;border-color: #CACFD2;">


                        </td>
                        <td  style="text-align: right">  <b>Discount </b></td>
                        <td  style=" text-align: right;border-right:thick solid;border-color: #CACFD2;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>   {{$discount}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="1"style="border-left:thick solid;border-color: #CACFD2;">

                        </td>
                        <td style="text-align: right"><b>GST ( {{ $tax }} %)</b></td>
                        <td  style="text-align: right;border-right:thick solid;border-color: #CACFD2;" border-right:thick solid;><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$payment1->taxamount}}</td>
                    </tr>
                    <tr>
                        <td colspan="1"style="border-left:thick solid;border-color: #CACFD2;">
                        <?php
                            $discount_amount = $payment1->schemebaseprice - $discount;
                            $total_amount = $discount_amount + $payment1->taxamount;
                            $total_amount= round($total_amount);

                        ?>
                        </td>
                        <td  style="text-align: right;border-color: #CACFD2"><b>Total</b></td>
                        <td  style="text-align: right;border-right:thick solid;border-color: #CACFD2;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$total_amount}}</td>
                    </tr>
                     <tr>
                        <td colspan="1"style="border-left:thick solid;border-bottom:thick solid;border-color: #CACFD2;">

                        </td>
                        <?php
                          $no = round($total_amount);

                           $point = round($total_amount - $no, 2) * 100;
                              //dd($point);
                           $hundred = null;
                           $digits_1 = strlen($no);
                           $i = 0;
                           $str = array();
                           $words = array('0' => '', '1' => 'One', '2' => 'Two',
                            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
                            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
                            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
                            '13' => 'Thirteen', '14' => 'Fourteen',
                            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
                            '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
                            '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
                            '60' => 'Sixty', '70' => 'Seventy',
                            '80' => 'Eighty', '90' => 'Ninety');
                           $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                           while ($i < $digits_1) {
                             $divider = ($i == 2) ? 10 : 100;
                             $number = floor($no % $divider);
                             $no = floor($no / $divider);
                             $i += ($divider == 10) ? 1 : 2;
                             if ($number) {
                                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                $str [] = ($number < 21) ? $words[$number] .
                                    " " . $digits[$counter] . $plural . " " . $hundred
                                    :
                                    $words[floor($number / 10) * 10]
                                    . " " . $words[$number % 10] . " "
                                    . $digits[$counter] . $plural . " " . $hundred;
                             } else $str[] = null;
                          }
                          $str = array_reverse($str);
                          $result = implode('', $str);
                          $points = ($point) ?
                            "." . $words[$point / 10] . " " .
                                  $words[$point = $point % 10] : '';
                          $word= $result."Rupees  " . $points . " ";



                        ?>
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
                    <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Collected By</th>
                     <th style=" border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2; width: 100px;">Details</th>
                <th  style="border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right;border-color: #CACFD2;">Amount</th>
                </tr>
                </thead>
       <tbody>
                    @if(!empty($oldpayment_data))
                      @foreach($oldpayment_data as $key=>$oldpayment)
                      <?php

                        $discount_amount = $oldpayment->discountamount;
                        $apply_tax = $oldpayment->tax;
                        if($apply_tax > 0){
                          $tax_calculation = (int)round(($discount_amount/100) * $apply_tax);
                          $add_discount = (int)round($discount_amount + $tax_calculation);
                        }else{
                          $add_discount = (int)round($discount_amount);
                        }



                      ?>
                      <tr>

                        <td style="width: 120px;border-left:thick solid;border-color: #CACFD2;"><span style="font-size: 13px;">{{ $oldpayment->receiptno }}</span> <b>#</b> {{date('j F, Y', strtotime($oldpayment->paymentdate))}}</td>
                        <td>{{$oldpayment->mode}}</td>
                        <td>{{$oldpayment->remarks}}</td>
                        <td>{{ !empty($takenby) ? ucfirst($takenby) : ''}}</td>
                        @php
                        $old_percentage = $oldpayment->tax;
                        $perc = ($old_percentage / 100) * $oldpayment->amount;
                        $amount_added = $oldpayment->amount - $perc;
                        $total_amount_display = $total_amount_display + $amount_added + $perc;
                        @endphp
                        <td style="border-color: #CACFD2; width: 100px;">Amount :<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$oldpayment->amount - $perc}} <br>
                          Tax :<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$perc}} </td>
                          <td style="text-align: right;border-right:thick solid;border-color: #CACFD2;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$oldpayment->amount}}</td>

                        </tr>
                      @endforeach

                    @endif

                      @foreach($payment as $key=>$payment)

                    <tr>

                        <td style="width: 120px;border-left:thick solid;border-color: #CACFD2;"><span style="font-size: 13px;">{{ $payment->receiptno }}</span> <b>#</b> {{date('j F, Y', strtotime($payment->paymentdate))}}</td>
                       <td>{{$payment->mode}}</td>
                        <td>{{$payment->remarks}}</td>
                        <td>{{ !empty($takenby) ? ucfirst($takenby) : ''}}</td>
                         @php
            $percentage = $tax;
             $perc = ($percentage / 100) * $payment->amount;
             $amount_added = $payment->amount - $perc;
            //  $total_amount_display = $total_amount_display + $amount_added + $perc + $add_discount;
            $total_amount_display = $total_amount_display + $amount_added + $perc ;

           @endphp
            <td style="border-color: #CACFD2; width: 100px;">Amount :<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payment->amount - $perc}} <br>
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
                           <?php

                          $no = round($total_amount_display);
                         $point = round($total_amount_display - $no, 2) * 100;
                         $hundred = null;
                         $digits_1 = strlen($no);
                         $i = 0;
                         $str = array();
                         $words = array('0' => '', '1' => 'One', '2' => 'Two',
                          '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
                          '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
                          '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
                          '13' => 'Thirteen', '14' => 'Fourteen',
                          '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
                          '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
                          '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
                          '60' => 'Sixty', '70' => 'Seventy',
                          '80' => 'Eighty', '90' => 'Ninety');
                         $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                         while ($i < $digits_1) {
                           $divider = ($i == 2) ? 10 : 100;
                           $number = floor($no % $divider);
                           $no = floor($no / $divider);
                           $i += ($divider == 10) ? 1 : 2;
                           if ($number) {
                              $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                              $hundred = ($counter == 1 && $str[0]) ? ' and  ' : null;
                              $str [] = ($number < 21) ? $words[$number] .
                                  " " . $digits[$counter] . $plural . " " . $hundred
                                  :
                                  $words[floor($number / 10) * 10]
                                  . " " . $words[$number % 10] . " "
                                  . $digits[$counter] . $plural . " " . $hundred;
                           } else $str[] = null;
                        }
                        $str = array_reverse($str);
                        $result = implode('', $str);
                        $points = ($point) ?
                          "." . $words[$point / 10] . " " .
                                $words[$point = $point % 10] : '';
                        $totalpay= $result . "Rupees  " . $points . " ";
                        ?>

                        <td colspan="3" style="text-align: right;border-right:thick solid;border-bottom: thick solid;border-color: #CACFD2;"> {{  $totalpay}}</td>
                     </tr>
                     @endif
                   </tbody>
            </table>
<div>
     @if($payment->actualamount == (($payment->actualamount) - ($payment->remainingamount)))
                 @php  $duedate = 0 ; @endphp
                   @endif

    @if($duedate)
    <table style="margin: 5px;  margin-top:60px;" width=100%  cellpadding="5px;" cellspacing="0px">
         <thead>
            <tr><th style="border:none;"><font size="3">Due Information</font></th></tr>
            <tr style="border-right: thick solid; border-left: thick solid;border-color: #CACFD2; border-top: thick solid;border-bottom:thick solid; border:1px;border-color: #CACFD2;">
            <th style="border-left: thick solid; border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">Due Date</th>
            <th style="border-top: thick solid;border-bottom:thick solid;border-color: #CACFD2;">State</th>
            <th  style="border-right: thick solid; border-top: thick solid;border-bottom:thick solid; text-align: right; border-right:thick solid;border-color: #CACFD2;">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="border-left: thick solid;border-bottom: thick solid;border-color: #CACFD2;">{{date('j F, Y', strtotime($duedate))}}</td>
              <td style="border-bottom: thick solid;border-color: #CACFD2;">Due Date Scheduled</td>
              <td style="text-align: right;border-bottom: thick solid; border-right:thick solid;border-color: #CACFD2;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $payment->remainingamount }}</td>
            </tr>
          </tbody>
    </table>
    @endif
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
