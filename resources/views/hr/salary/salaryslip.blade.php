<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <style>
		.table{
			border-collapse: collapse;
			border : thick solid #CACFD2;
			border-color : #CACFD2;

		}
		.td{
			border : thick solid #CACFD2;
			padding: 7px;
		}
		.th{
			padding: 7px;
			border : thick solid #CACFD2;
		}
		/* .th{

			spacing:none;
			border: 1px solid #CACFD2;
		}
	   .td{

		border: 1px solid #CACFD2;
	   }
	   .tr{

		border: 1px solid #CACFD2;
	   } */
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
				   <?php
				   $amount=$salary->currentsalary;
					$no = floor($amount);
					$point = round($amount - $no, 2) * 100;
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
    " And " . $words[$point / 10] . " " .
          $words[$point = $point % 10] : '';
  $word= $result . "Rupees  " . $points . " Paise";
 ?>
    <body>
        <div>

            <div style="float: left">
                <img style="width: 100px" src="images/fitness5.png">
			</div>


            <div style="float: right;margin-left: 8px;">
                <b><font size="3">Fitness5</font></b>
            	<font size="2">
 				<br>
					GSTIN:  24BDLPG2978J1Z7 <br/>
					"Kruna Nidhan" <br/>
					Kotecha Chowk, <br/>
					Rajkot 360005. <br/>
					Email:info@fitness5.in <br/>
					Mo. : 0281 2583005/2587005 <br></font>
			</div>

		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<div style="float:center;">
			<div style="padding-left:240px;padding-top:-30px; font-size:20;">
			<b> Salary Slip </b>
			<br>
			 {{ $salary->month}}  : {{ $salary->year}}
			</div>
			<br>
			<br>
			   <font style="float:right;margin-left: 8px;"> Date: {{ date('d-m-Y',strtotime($salary->paiddate))}} &nbsp;&nbsp; &nbsp;  </font>
			<br>
			<br>
			<table>
				<tr><td style="padding: 8px;">NAME: </td> &nbsp;<td style="font-size:15;"><u><b>{{$employeefullname}}</b></u></td></tr>

			</table>
			<br>
			<br>
			<table class="table" border="1px" style="width:100%">
				<thead><tr><th class="th" style="width:80% !important;">PARTICULARS</th><th class="th">AMOUNT  <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span></th></tr></thead>
				<tbody><tr><td colspan="2" class="th">EARNINGS</td></tr><tr class="tr">
				<td  class="td">Salary</td><td class="td">{{ $salary->currentsalary - $salary->ptsessionsalary}}</td></tr>
					<tr><td class="td">PT salary</td><td class="td">{{$salary->ptsessionsalary}}</td></tr>
					<tr><td colspan="2" class="th">DEDUCTION</td></tr>
					<tr><td class="td">loan</td><td class="td">{{$salary->paidloan}}</td></tr>
					<tr><td class="td">TDS</td><td class="td">{{$salary->salaryothercharges}}</td></tr>
										<tr><td class="td">Payment Type</td><td class="td">{{$salary->paymenttype}}</td></tr>   @if($salary->paymenttype == 'Cheque')
											<tr><td class="td">Cheque No</td><td class="td">{{$salary->Chequeno}}</td></tr>
										                                                                    @endif

										<tr><td class="td">Payment Remarks</td><td class="td">{{$salary->remark2}}</td></tr>

						<tr><td class="td">Salary Remarks</td><td class="td">{{$salary->remark}}</td></tr>
				</tbody>
				<tfoot><tr><td class="th"><b>IN WORDS  </b> &nbsp;&nbsp; {{ $word }}</td><td>{{$salary->currentsalary}}</td></tr></tfoot>
			</table>
			<br>
			<table>
				<!-- <tr><th style="padding: 8px;">MODE OF PAYMENT</th> <td><span style="font-family: DejaVu Sans; sans-serif;">&#9633; </span> Cash  <span style="font-family: DejaVu Sans; sans-serif;">&#9633; </span> Credit Card  <span style="font-family: DejaVu Sans; sans-serif;">&#9633; </span> Cheque</td></tr> -->
				<tr><td style="padding: 8px;">Cheque No.</td> &nbsp;<td>_______________ Date_________________ Amount______________</td></tr>
				<tr><td style="padding: 8px;">Bank</td> &nbsp;		<td>_________________________________________________________</td></tr>

			</table>

		</div>
    </body>
</html>
