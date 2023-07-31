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
/**
 * 
 */
class TransactionPaymentReceipt
{
  
    protected $pdf;
    public function __construct() {
        $this->pdf = new Dompdf;
    }
    public function generate($request,$memberid) {
      $oldpayment_data = '';

    $payment= Payment::where('invoiceno',$request)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->get()->all();
    /*if(empty($payment)){
      $payment= Payment::where('invoiceno',$request)->where('mode','!=','total')->where('invoicetype', 'o')->get()->all();
    }*/
    
  //   $payment1 = Payment::where('invoiceno', function($query){
  //     $query->select('invoiceno')
  //           ->from(with(new Payment)->getTable())
  //           ->whereIn('invoicetype', ['m', 'o'])
  //           ->where('mode','!=','total')
  //           ->where('invoiceno',3);
  // })->get()->first();
 
     $payment1 = Payment::where('invoiceno',$request)->where('memberid',$memberid)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->get()->first();
    
 
    // $schemeactualprice =$payment1->schemeactualprice;
    // $schemebaseprice =$payment1->schemebaseprice;

    $total_payment = Payment::where('invoiceno',$request)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->first();
 

      $user= User::where('userid',$payment1->userid)->get()->first();
      

      $taken_by = Admin::where('adminid', $payment1->takenby)->first();
      if(!empty($taken_by)){
        $emp_id = $taken_by->employeeid;
        $emp_data = Employee::where('employeeid', $emp_id)->first();
        if(!empty($emp_data)){
          $takenby = ucfirst($emp_data->first_name).' '.ucfirst($emp_data->last_name);

        }
      }
         
      $id=$user->userid;
      
      $phoneno = $user->usermobileno;
      $member = Member::where('userid',$id)->get()->first();
      $companyName='';
      $Gstno='';
      if($member->companyid){
      $company=Company::where('companyid',$member->companyid)->get()->first();
      $companyName=$company->companyname;
      $Gstno=$company->gstno;
  
      }

      $scheme=Scheme::where('schemeid',$payment1->schemeid)->get()->first();
      //echo $id;
      
      $memberpackage = MemberPackages::where('userid',$id)->where('schemeid',$payment1->schemeid)->where('memberpackagesid', $request)->get()->first();
      
      if(!empty($memberpackage)){
        $upgradepackageid = $memberpackage->upgradeid;
      }

      if(!empty($upgradepackageid)){
        $upgradepackage_data = PackageUpgradeModel::where('upgradepackageid', $upgradepackageid)->first();
        if(!empty($upgradepackage_data)){
          $oldpayment_data = Payment::where('invoiceno', $upgradepackage_data->oldinvoiceno)->where('mode', '!=', 'total')->where('invoicetype', 'm')->get()->all();
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
  
   if($pay->discount || $pay->discountamount){
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
$request->replace(['paymentdate' => $today,'username' => $user->username]);

  // $request->username=$user->username;
     
       $this->pdf->loadHtml(
        View::make('admin.paymenttransactionreceipt')->with(['member'=>$member,'totalpay'=>$totalpay,'request'=>$request,'payment'=>$payment,'phoneno'=> $phoneno,'scheme'=>$scheme,'memberpackage'=>$memberpackage,'word'=>$word,'companyName'=>$companyName,'Gstno'=>$Gstno,'duedate'=> $duedate,'takenby'=>$takenby,'discount'=>$discount,'tax'=>$payment_tax, 'total_payment' => $total_payment, 'oldpayment_data' => $oldpayment_data,'payment1'=>$payment1])->render());
       
      $this->pdf->render();
     
      $this->pdf->stream(''.$member->firstname.' '.$member->lastname.'.pdf');
      exit(0);
    
     }
}
 