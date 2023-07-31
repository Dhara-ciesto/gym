<?php
namespace App;

use Dompdf\Dompdf;
use App\PaymentType;
use App\Scheme;
use App\Payment;
use App\MemberPackages;
use App\Employee;
use App\PackageUpgradeModel;
use Illuminate\Support\Facades\View;
use App\AdminMaster;
use PDF;
use App\Member;
use App\MiscellaneousCharges;
use App\FreezeMembershipModal;
use App\TransactionModel;


/**
 * 
 */
class FreezeMembershipReceipt
{
  
    protected $pdf;
    public function __construct() {
        $this->pdf = new Dompdf;
    }
    public function generate($request) {
      $oldpayment_data = '';
      $phoneno = '';

    $payment= Payment::where('invoiceno',$request)->where('mode','!=','total')->where('invoicetype', 'o')->get()->all();
    

    $payment1 = Payment::where('invoiceno',$request)->where('mode','!=','total')->where('invoicetype', 'o')->get()->first();

    $total_payment = Payment::where('invoiceno',$request)->where('mode','!=','total')->where('invoicetype', 'o')->first();

      $member_data= Member::where('userid',$payment1->userid)->get()->first();
      if(!empty($member_data)){
        $fullname = ucfirst($member_data->firstname).' '.ucfirst($member_data->lastname);
        $phoneno = $member_data->mobileno;

      }

      $companyName='';
      $Gstno='';
      if($member_data->companyid){
      $company=Company::where('companyid',$member_data->companyid)->get()->first();
      $companyName=$company->companyname;
      $Gstno=$company->gstno;
  
      }

      $miscellaneouscharges_data = MiscellaneousCharges::where('miscellaneouschargesid', $request)->where('miscellaneouschargespaymenttype', 'f')->first();
      if(!empty($miscellaneouscharges_data)){
        $freezemembershipid = $miscellaneouscharges_data->miscellaneouschargesrefid;
        $transactionid = $miscellaneouscharges_data->miscellaneouschargestid;
        $miscellaneouscharges_data->miscellaneouschargesstatus = 1;
      }

      $freezemembership_data = FreezeMembershipModal::where('freezemembershipid', $freezemembershipid)->first();
      if(!empty($freezemembership_data)){
        $freezememberhipstartdate = $freezemembership_data->freezememberhipstartdate;
        $enddate=$freezemembership_data->freezememberhipenddate;
      }

      $transaction_data = TransactionModel::where('transactionid', $transactionid)->first();
      

      $taken_by = Admin::where('adminid', $payment1->takenby)->first();
      if(!empty($taken_by)){
        $emp_id = $taken_by->employeeid;
        $emp_data = Employee::where('employeeid', $emp_id)->first();
        if(!empty($emp_data)){
          $takenby = ucfirst($emp_data->first_name).' '.ucfirst($emp_data->last_name);

        }
      }

      /*----------------for words-----------------------*/
        $no = round($payment1->actualamount);

   $point = round($payment1->actualamount - $no, 2) * 100;
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
  $discount=0;
  $duedate = 0;
  $totalpay = 0;
  $payment_tax = 0;
  //dd($payment);
  foreach($payment as $key => $pay){
    
    if($pay->duedate){
      $duedate = $pay->duedate;

    }
    $payment_tax = $pay->tax;
 
   $totalpay += $pay->amount;
  
   if($pay->discount){
     $discount=$pay->discountamount;
     echo $discount;

  }  
}
  

   
   $no = round($totalpay);
   $point = round($totalpay - $no, 2) * 100;
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

  $today =date("d-m-Y");
  $request = new \Illuminate\Http\Request();

  // $request->username=$user->username;
     
       $this->pdf->loadHtml(
        View::make('admin.freezemembership.freezemembershipreceipt')->with(['member_data'=>$member_data,'totalpay'=>$totalpay,'request'=>$request,'payment'=>$payment,'phoneno'=> $phoneno,'word'=>$word,'companyName'=>$companyName,'Gstno'=>$Gstno,'takenby'=>$takenby,'tax'=>$payment_tax, 'total_payment' => $total_payment, 'freezememberhipstartdate' => $freezememberhipstartdate,'freezememberhipenddate' => $enddate, 'transaction_data'=>$transaction_data])->render());
       
      $this->pdf->render();
     
      $this->pdf->stream(''.$member_data->firstname.' '.$member_data->lastname.'.pdf');
    
     }
}
 