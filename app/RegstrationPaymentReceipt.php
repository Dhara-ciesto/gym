<?php
namespace App;

use Dompdf\Dompdf;
use App\PaymentType;
use App\Scheme;
use App\Payment;
use App\User;
use App\MemberPackages;
use App\TransactionModel;
use Illuminate\Support\Facades\View;
use App\AdminMaster;
use App\Registration;
/**
 * 
 */
class RegstrationPaymentReceipt
{
	
	  protected $pdf;
    public function __construct() {
        $this->pdf = new Dompdf;
    }
    public function generate($request) {
      //dd($request);
    $payment= Payment::leftjoin('transaction', 'payments.paymentTransactionId', 'transaction.transactionid')
              ->where('payments.invoiceno',$request)
              ->where('payments.mode','=','-')
              ->where('payments.invoicetype', 'r')
              ->get()->first();
              // dd($payment);

    $payment_mode= Payment::where('payments.invoiceno',$request)->where('payments.mode','!=','-')->where('payments.invoicetype', 'r')->get()->all();
    //dd($payment_mode);

    $taken_by = Admin::where('adminid', $payment->takenby)->first();
     if(!empty($taken_by)){
       $takenby = $taken_by->name;
     }
    
    if(!empty($payment)){
      $userid = $payment->userid;
      $transactionid = $payment->paymentTransactionId;
      $schemeid = $payment->transactionschemeid;
    }

    $user_data = User::where('userid', $userid)->first();
    if(!empty($user_data)){
      $registration_id = $user_data->regid;
    }
    $transaction_data = TransactionModel::where('transactionuserid', $transactionid)->first();
    $scheme_data = Scheme::where('schemeid', $schemeid)->first();
    $registration_data = Registration::where('id', $registration_id)->first();
  
      //dd($payment1->schemeid);
    

      /*----------------for words-----------------------*/
        $no = round($payment->actualamount);

   $point = round($payment->actualamount - $no, 2) * 100;
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

  /*-----------wordss-----------------*/
 
/************************************************/

   $this->pdf->loadHtml(
    View::make('admin.transaction.regstration.regstrationpaymentreceipt')->with(['word'=>$word,'scheme'=>$scheme_data, 'transaction_data'=>$transaction_data,'user'=>$user_data,'payment'=>$payment,'registration_data'=>$registration_data,'takenby' => $takenby,'payment_mode'=>$payment_mode])->render());
       
      $this->pdf->render();
     
      $this->pdf->stream(''.$registration_data->firstname.' '.$registration_data->lastname.'.pdf');
    
     }
}
 