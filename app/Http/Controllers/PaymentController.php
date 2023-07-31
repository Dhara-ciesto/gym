<?php

namespace App\Http\Controllers;
use App\Http\Controllers\sms\NotificationController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\User;
use App\PaymentType;
use App\Payment;
use App\AdminMaster;
use App\Member;
use App\Scheme;
use Dompdf\Dompdf;
use App\Notify;
use App\MemberPackages;
use App\RootScheme;
use App\TransactionModel;
use App\Deviceusers;
use App\Company;
use App\Registration;
use App\Employee;
use App\TransactionPaymentReceipt;
use App\RegstrationPaymentReceipt;
use Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use App\Actionlog;
use Ixudra\Curl\Facades\Curl;
use App\Smssetting;
use Session;
use App\Notificationmsgdetails;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;
use App\Emailnotificationdetails;
use App\Admin;
use PDF;
use App\PackageUpgradeModel;


class PaymentController extends Controller
{

   public function invoice(Request $request) {
  $method = $request->method();

    $pdf = new \App\Invoice;
    $pdf->generate($request);

}

// }public function invoice() {
//     $pdf = new \App\Invoice;
//     $output = $pdf->generate();
//     $headers = [
//         'Content-Type' => 'application/pdf',
//         'Content-Disposition' => 'attachment; filename="invoice.pdf"';
//     ];
//     return response($output)->withHeaders($headers);
// }
//     public function remainingpayment($id,Request $request){
//         $method = $request->method();
//         if ($request->isMethod('post')){
//          $loginuser = Session::get('username');
//         $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
//         $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

//         $sgst = (int)$sgst;
//         $cgst = (int)$cgst;
//         $tax =  $sgst + $cgst;
//         $userid = $request['Userid'];
//         $mode= $request['Mode'];
//         $remark= $request['Remark'];
//         $amount= $request['Amount'];
//         $ActualAmount = 0;
//         $member = Member::where('userid',$userid)->get()->first();
//         $mobileno=$member->mobileno;
//         $MemberId = $member->memberid;

//         for ($n=0; $n < count($mode) ; $n++) {
//           $ActualAmount += $amount[$n];
//           $payment =  Payment::create([
//             'memberid' =>  $MemberId,
//             'userid' => $userid,
//             'actualamount' =>  $request['ActualAmount'],
//             'amount' =>  $amount[$n],
//             'tax' => $tax,
//             'taxamount' => $request['TaxAmount'],
//             'discount' => $request['Discount'],
//             'discountAmount' => $request['TotalDiscount'],
//             'discount2' => $request['Discount2'],
//             'discount2amount' => $request['Discount2Amount'],
//             'date' => $request['Date'],
//             'paymentdate' => now(),
//             'mode' => PaymentType::find($request['Mode'][$n])->paymenttype,
//             'schemeid' => $request['SchemeID'],
//             'otherchargesdetailsid' => $request['OtherChargesDetailsId'],
//             'expenseid' => $request['ExpenseId'],
//             'expensedetailsid' => $request['ExpenseDetailsId'],
//             'employeeid' => $request['EmployeeId'],
//             'voucherid' => $request['VoucherId'],
//             'billid' => $request['BillId'],
//             'storebillid' => $request['StoreBillId'],
//             'receiptno' =>  $request['RecieptNo'],
//             'employeesalaryid' => $request['EmployeeSalaryId'],
//             'Type' => 'Credit',
//             'Remarks' =>  $remark[$n],
//             'remainingamount'=> $request['rtotal'],
//             'duedate'=>$request['duedate'],
//             'takenby' => $loginuser,
//           ]);
//         }

//         $payment =  Payment::create([
//           'memberid' =>  $MemberId,
//           'userid' => $userid,
//           'actualamount' =>  $request['ActualAmount'],
//           'amount' =>  $ActualAmount,
//           'tax' => $tax,
//           'taxAmount' => $request['TaxAmount'],
//           'discount' => $request['Discount'],
//           'discountamount' => $request['DiscountAmount'],
//           'discount2' => $request['Discount2'],
//           'discount2Amount' => $request['Discount2Amount'],
//           'date' => $request['Date'],
//           'paymentdate' => now(),
//           'mode' =>'-',
//           'schemeid' => $request['SchemeID'],
//           'otherchargesdetailsid' => $request['OtherChargesDetailsId'],
//           'expenseid' => $request['ExpenseId'],
//           'expensedetailsid' => $request['ExpenseDetailsId'],
//           'employeeid' => $request['EmployeeId'],
//           'voucherid' => $request['VoucherId'],
//           'billid' => $request['BillId'],
//           'storebillid' => $request['StoreBillId'],
//           'receiptno' => $request['RecieptNo'],
//           'employeesalaryid' => $request['EmployeeSalaryId'],
//           'type' => 'Debit',
//           'remarks' =>  '-',
//           'remainingamount'=> $request['rtotal'],
//           'duedate'=>$request['duedate'],
//            'takenby' => $loginuser,
//         ]);


//             $Memberpackages=Memberpackages::where('schemeid',$payment->schemeid)->get()->first();
//             $mem = Member::where('userid',$userid)->get()->first();
//             $pack=Scheme::where('schemeid',$Memberpackages->schemeid)->get()->first();
//             $pack=$pack->schemename;
//             $fname=$mem->firstname;
//             $lname=$mem->lastname;
//             $date=$payment->paymentdate;
//             $fname=$fname . ' ' . $lname;
//             $id=$mem->memberid;
//             $joindate=$Memberpackages->joindate;
//             $joindate = date("d-m-Y", strtotime($joindate));
//             $enddate=$Memberpackages->expiredate;
//             $enddate= date("d-m-Y", strtotime($enddate));
//             $date=date("d-m-Y", strtotime($date));
//             $amnt=$payment->amount;
//             $InvoiceID=$payment->receiptno;
//             $TransactionType='Fully';
//             $duedate='';
//             $dueamnt='';
//           if($payment->duedate){
//             $duedate=$payment->duedate;
//             $duedate= date("d-m-Y", strtotime($duedate));
//             $dueamnt=$payment->remainingamount;
//             $TransactionType='Partially';
//           }


//           $msg=   DB::table('messages')->where('messagesid','14')->get()->first();
//           $msg =$msg->message;
//           $msg = str_replace("[Name of Member]",$fname,$msg);
//           $msg= str_replace("[ID]",$id,$msg);
//           // $msg= str_replace("[Name of Packge]",$pack,$msg);
//           $msg= str_replace("[Full/Partial]",$TransactionType,$msg);
//           $msg= str_replace("[Amount]",$amnt,$msg);
//           $msg= str_replace("[InvoiceID]",$InvoiceID,$msg);
//           $msg= str_replace("[Date]",$date,$msg);

//           $due='';
//           if($TransactionType == 'Partially'){
//             $due="Due Amount:[Due Amount] Next Due Date: [Due Date]";
//             $due= str_replace("[Due Amount]",$dueamnt,$due);
//           $due= str_replace("[Due Date]", $duedate,$due);

//             $msg=''.$msg.' '.$due.'';
//           }
//  $msg = urlencode($msg);

//           $otpsend = Curl::to('http://sms.weybee.in/api/sendapi.php?auth_key=2169KrEMnx2ZgAqSfavSSC&mobiles='.$mobileno.'&message='.$msg.'message&sender=senderid&route=4')->get();


//                     $notify=Notify::create([

//                   'userid'=> $id,
//                  'details'=> 'User has made Payment'.$ActualAmount,
//                 ]);

//             $Memberpackages=Memberpackages::where('schemeid',$payment->schemeid)->get()->first();
//             $mem = Member::where('userid',$userid)->get()->first();
//             $pack=Scheme::where('schemeid',$Memberpackages->schemeid)->get()->first();
//             $pack=$pack->schemename;
//             $fname=$mem->firstname;
//             $lname=$mem->lastname;
//             $date=$payment->paymentdate;
//             $fname=$fname . ' ' . $lname;
//             $id=$mem->id;
//             $joindate=$Memberpackages->joindate;
//             $joindate = date("d-m-Y", strtotime($joindate));
//             $enddate=$Memberpackages->expiredate;
//             $enddate= date("d-m-Y", strtotime($enddate));
//             $date=date("d-m-Y", strtotime($date));
//             $amnt=$payment->amount;
//             $InvoiceID=$payment->receiptno;
//             $TransactionType='Fully';
//             $duedate='';
//             $dueamnt='';
//           if($payment->duedate){
//             $duedate=$payment->duedate;
//             $duedate= date("d-m-Y", strtotime($duedate));
//             $dueamnt=$payment->remainingamount;
//             $TransactionType='Partially';
//           }
//            $summry = array("firstname"=>$fname, "joindate"=>$joindate,
//                   "enddate"=>$enddate, "amnt"=>$amnt,  "InvoiceID"=>$InvoiceID, "TransactionType"=>$TransactionType, "duedate"=>$duedate,
//                   "dueamnt"=>$dueamnt,"pack"=>$pack);


//           return view('admin.summry')->with('summry',$summry);

//             // $method = $request->method();
//             // $pdf = new \App\paymentreceipt;
//             // $pdf->generate($request,$payment);


//             }
//             else{
//                 $Payment = Payment::findOrFail($id);
//                 $user=User::where('userid',$Payment->userid)->get()->first();

//                 $Scheme = Scheme::where('schemeid',$Payment->schemeid)->get()->first();
//                      $PaymentTypes = PaymentType::get()->all();

//                 return view('admin.transaction.makePayment',compact('Payment','PaymentTypes','Scheme','user','id'));
//             }

//     }
//     public function summry($data){
//       return view('admin.summry',compact('data',$data));
// }
//     public function create(Request $request)
//     {

//             $loginuser = Session::get('username');
//         $method = $request->method();
//         if ($request->isMethod('post')){

//          $mode= $request['Mode'];
//          $remark= $request['Remark'];
//          $amount= $request['Amount'];
//          $ReceiptNo =  Payment::max('ReceiptNo')+1;

//          $UserId = $request['selectusername'];
//          $ActualAmount=0;
//          $member= Member::where('userid',$UserId)->get()->first();
//          $member->id;


//         for ($n=0; $n < count($mode) ; $n++) {

//         $ActualAmount += $amount[$n];
//         $payment =  Payment::create([
//         'MemberId' => $member->id,
//         'UserId' => $request['selectusername'],
//         'ActualAmount' =>  $request['ActualAmount'],
//         'Amount' =>  $amount[$n],
//         'Tax' => '0',
//         'TaxAmount' => $request['TaxAmount'],
//         'ReceiptNo' => $ReceiptNo,
//         'Date' => $request['Date'],
//         'PaymentDate' => now(),
//         'Mode' => PaymentType::find($request['Mode'][$n])->PaymentType,
//         'Type' => 'Credit',
//         'Remarks' =>  $remark[$n],
//          'takenby' => $loginuser,


//      ]);

//       $last_id = DB::getPdo()->lastInsertId();
//       $action = new Actionlog();
//       $action->user_id = session()->get('admin_id');
//       $action->ip = $request->ip();
//       $action->action_type = 'insert';
//       $action->action = 'payment';
//       $action->action_on = $last_id;
//       $action->save();
//      }

//       $member = Member::Where('userid',$UserId)->get()->first();
//         // $MemberId = $UserId->Member->id;
//        $member->amount =  $ActualAmount;
//        $member->save();

//         //      $payment =  Payment::create([
//         //     'UserId' => $request['selectusername'],
//         //      'description' => $request['description'],
//         // ]);
//     //                  $request->validate([
//     // 'PaymentType' => 'required',
//     // 'description' => 'max:255',
//     //     ]);
//         //   Payment::create([
//         //     'PaymentType' => $request['PaymentType'],
//         //      'description' => $request['description'],
//         // ]);
//          return redirect('paymenttypes')->with('message','Succesfully added');
//         }
//         $users=User::get()->all();
//          $PaymentTypes = PaymentType::get()->all();
//         return view('admin.CashCredit',compact('users','PaymentTypes'));

//     }

    public function demopayment(Request $request){

      $loginuser = Session::get('username');
      $method = $request->method();

      $username = $request->get('username');
      $MobileNo = $request->get('MobileNo');


      $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->where('users.userstatus', 'mem')->whereIn('member.status',[1,2,0])->get()->all();


      $RootScheme = RootScheme::get()->all();
      $PaymentTypes = PaymentType::get()->all();
      $ReceiptNo = '';
      $receipt = Payment::latest()->first();

      if($receipt==null){
        $ReceiptNo = '1';
      }
      elseif($request['ReceiptNo']){
        $ReceiptNo = $request['ReceiptNo'];
      }
      else{
        $ReceiptNo = Payment::max('ReceiptNo');

      }
      $ReceiptNo = (Payment::max('receiptno')+1);
      $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
      $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

      $sgst = (int)$sgst;
      $cgst = (int)$cgst;
      $tax =  $sgst + $cgst;

      $admin = Employee::where('role', 'admin')->get()->all();

      return view('admin.transaction.order')->with(compact('users','tax','RootScheme','PaymentTypes','ReceiptNo', 'admin'));

    }

    public function placeorder(Request $request){

      $RootSchemeId = !empty($request->RootSchemeId) ? $request->RootSchemeId : 0;
      $schemeid = !empty($request->SchemeID) ? $request->SchemeID : 0;
      $userid = !empty($request->userid) ? $request->userid : 0;
      $ActualAmount = !empty($request->ActualAmount) ? (int)round($request->ActualAmount) : 0;//3540
      $tax_radio = !empty($request->tax_radio) ? $request->tax_radio : '';//withtax
      $Discount = !empty($request->Discount) ? $request->Discount : 0;//100
      $discount_radio = !empty($request->discount_radio) ? $request->discount_radio : '';//rs
      $total_amount = !empty($request->total_amount) ? (int)round($request->total_amount) : 0;//3422
      $amount_paid = !empty($request->amount_paid) ? (int)round($request->amount_paid) : 0;//3000
      $BaseAmount = !empty($request->BaseAmount) ? (int)round($request->BaseAmount) : 0;//3000
      $BaseAmounthidden = (int)round($request->BasePrice_hidden);//3000
      $tax = $request->order_tax;//18
      $remainingamount = (int)round($request->remaining_amount);//422
      $joindate = date('Y-m-d', strtotime($request->Join_date));
      $expiredate = date('Y-m-d', strtotime($request->Expire_date));
      $due_date = $request->due_date;
      $orderbtn = $request->order_btn;
      $taxamount = 0;
      //dd($discount_radio);
      $request->validate([

        'userid' => 'numeric',
        'RootSchemeId' => 'numeric',
        'SchemeID' => 'numeric',
        'BaseAmount' => 'numeric',
        'ActualAmount' => 'numeric',
        'Discount' => 'nullable|numeric',
        'total_amount' => 'numeric',
        'Join_date' => 'date',
      'Expire_date' => 'date',
        'amount_paid' => 'nullable|numeric',
        'remaining_amount' => 'numeric',
        'due_date' => 'nullable|date'
      ]);

      $pay=Payment::where('userid',$userid)->get()->last();

      if($pay){
        if($pay->remainingamount){
          $memberid_redirect = $pay->memberid;
          return redirect('memberProfile/'.$memberid_redirect)->with('message','Please Complete Your Payment of remaining package.');
        }
      }

      //$Discount_calculation = $BaseAmount - $total_amount;
      //$Discount = $Discount_calculation;

      $scheme_exist = Scheme::where('schemeid', $schemeid)->first();
      if(empty($scheme_exist)){
        return redirect()->route('assignPackageOrRenewalPackage')->with('message', 'Scheme does not exist');
      }

      if(is_numeric($Discount)){
        if($Discount > 0){
          if($discount_radio == 'rs'){
            $ActualAmount = (int)round($BaseAmount - $Discount);
          } else {
            $Discount_calculation = ($BaseAmount/100) * $Discount;
            $ActualAmount = (int)round($BaseAmount - $Discount_calculation);
          }
        }
      } else {
        return redirect()->route('assignPackageOrRenewalPackage')->with('message', 'Discount must be a number');
      }

      if(!is_numeric($BaseAmount) || !is_numeric($Discount) || !is_numeric($total_amount) || !is_numeric($amount_paid) || !is_numeric($remainingamount)){
        return redirect()->route('assignPackageOrRenewalPackage')->with('message', 'Discount must be a number');
      }

      //dd($ActualAmount);

       // tax calculation start
      if($tax_radio == 'withtax'){
        $tax = $tax;
        if($discount_radio == 'rs'){
          $Discount = $Discount;

          $discount_amount = $BaseAmount - $Discount;
          $apply_tax = ($discount_amount/100) * $tax;
          $taxamount = (int)round($apply_tax);
        } else {

          $Discount_calculation = ($BaseAmount/100) * $Discount;
          $Discount = (int)round($Discount_calculation);
          $discountamountper = $BaseAmount - $Discount_calculation;
          $taxamount = (int)round(($discountamountper/100) * $tax);
        }

      } else {

        if($discount_radio != 'rs'){
          $Discount_calculation = ($BaseAmount/100) * $Discount;
          $Discount = (int)round($Discount_calculation);
          $discountamountper = (int)round($BaseAmount - $Discount_calculation);
        }
        $tax = 0;
        $taxamount = 0;
      }
      // tax calculation end

      $total_amount_calculation = (int)round($ActualAmount + $taxamount);
     $companyid ='';
$gstno='';


     /* if($amount_paid > $total_amount_calculation){
        return redirect()->route('assignPackageOrRenewalPackage')->with('message', 'Amount to be paid is greater then total amount. please enter vaild details.');
      }
*/
      //dd('sfsdfsdf');

      // if refersh page the redirect orderform start
      $orderview = session()->get('orderview');

      if(session()->get('orderview') != null){
        session()->forget('orderview');
      } else {
        return redirect()->route('assignPackageOrRenewalPackage');
      }
      // if refersh page the redirect orderform end

      $memberData = Member::where('userid', $userid)->first();

      if(!empty($memberData)){
        $memberid = $memberData->memberid;
        $mobileno = $memberData->mobileno;
        $companyid = $memberData->companyid;
      } else {
        $memberid = 0;
      }

      //company detail start
      if($tax_radio == 'withtax'){
        $company_data = Company::where('companyid', $companyid)->first();
        if(!empty($company_data)){
          $gstno = $company_data->gstno;
        } else {
          $gstno = 0;

        }
      } else {
        $gstno = 0;

      }
      //company detail end

      $memberfortimimg = Member::where('memberid',$memberid)->get()->first();
      /*$userid=$memberfortimimg->userid;*/
      if(!empty($memberfortimimg)){
        $mfrom =  date("H:i", strtotime($memberfortimimg->workinghourfrom));
        $mto =  date("H:i", strtotime($memberfortimimg->workinghourto));

      }

      $scheme_check='';
      $scheme_check= Scheme::where('schemeid',$schemeid)->get()->first();
      if($scheme_check){
       $sfrom =  date("H:i", strtotime($scheme_check->workinghourfrom));
       $sto =  date("H:i", strtotime($scheme_check->workinghourto));
       if(!($sfrom <= $mfrom &&  $sto >= $mto)){
         return redirect('memberProfile/'.$memberid)->with('message', 'Your timing is different from package timimg');
       }
     }

      // if memebr has already package start


      // if memebr has already package end


      $remaining_amount = $total_amount_calculation - $amount_paid;


      $result_of_transaction = DB::transaction(function () use($RootSchemeId, $schemeid, $userid, $ActualAmount, $tax_radio, $Discount, $discount_radio, $total_amount, $amount_paid, $BaseAmount, $BaseAmounthidden, $tax, $remainingamount, $due_date, $joindate, $expiredate, $taxamount, $gstno){
        $mobileno = '';
        $transaction_no = hexdec(uniqid());

        $memberData = Member::where('userid', $userid)->first();
        if(!empty($memberData)){
          $memberid = $memberData->memberid;
          $mobileno = $memberData->mobileno;
        } else {
          $memberid = 0;
        }

        if($remainingamount == 0){
          $transaction_type = 'Fully';
        } else {
          $transaction_type = 'Partially';
        }

        $due_date_transaction = !empty($due_date) ? date('Y-m-d', strtotime($due_date)) : null;

        //////////////// begin transaction -> Entry in transaction table with 0 status ///////////////////////

        $transaction = new TransactionModel();

        $transaction->transactionno = $transaction_no;
        $transaction->paymenttypeid = 1;
        $transaction->transactionuserid = $userid;
        $transaction->transactionmemberid = $memberid;
        $transaction->transactiontax = $tax;
        $transaction->transactiongstno = $gstno;
        $transaction->transactiontype = $transaction_type;
        $transaction->transactiondate = date('Y-m-d');
        $transaction->transactionstatus = 0;
        $transaction->transactionresponse = '';
        $transaction->transactionrefid = 0;
        $transaction->transactionschemeid = $schemeid;
        $transaction->transactionamount = !empty($amount_paid) ? (int)round($amount_paid) : 0;
        $transaction->transactionactualamount = !empty($total_amount) ? (int)round($total_amount) : 0;
        $transaction->transactionbaseamount = !empty($BaseAmount) ? (int)round($BaseAmount) : 0;
        $transaction->transactiondiscount = !empty($Discount) ? (int)round($Discount) : 0;
        $transaction->transactionduedate = date('Y-m-d', strtotime($due_date_transaction));
        $transaction->transactiontaxamount = (int)round($taxamount);
        if($amount_paid == 0){
          $transaction->transactionremainingamount = 0 ;
        } else {
          $transaction->transactionremainingamount = !empty($remainingamount) ? (int)round($remainingamount) : 0 ;
        }

        $transaction->save();

        $inerted_transaction_id = DB::getPdo()->lastInsertId(); // for member and payment table

        /////////////////////// end of transaction table //////////////////////////////////////


        // start of memberpackages

        $scheme_data = Scheme::where('schemeid', $schemeid)->first();
        if(!empty($scheme_data)){
          $noofdays = $scheme_data->numberofdays;
        }
        $today_date = date('Y-m-d');
        $packageendate = date('Y-m-d', strtotime($today_date.'+ '.$noofdays.' days'));

        $memberpackages = new Memberpackages();
        $memberpackages->userid = $userid;
        $memberpackages->schemeid = $schemeid;
        $memberpackages->memberTransactionId = $inerted_transaction_id;
        $memberpackages->joindate = $joindate;
        $memberpackages->expiredate = $expiredate;
        $memberpackages->status = 0;

        $memberpackages->save();

        return $inerted_transaction_id;

      });


      //$last_memberpackageid = Memberpackages::orderBy('memberpackagesid', 'desc')->first();

      $rootscheme_name = RootScheme::where('rootschemeid', $RootSchemeId)->first();
      $scheme_name = Scheme::where('schemeid', $schemeid)->first();
      $user = User::leftjoin('member', 'users.memid', 'member.memberid')->where('users.userid', $userid)->get()->first();

      $PaymentTypes = PaymentType::get()->all();

      $receipt_data = Payment::where('status', 1)->orderBy('paymentid', 'desc')->first();
      if(!empty($receipt_data)){
        $last_receipt_no = $receipt_data->receiptno;
      }

      if(empty($last_receipt_no)){
        $receiptno = 1;
      } else {
        $receiptno = $last_receipt_no + 1;
      }

      if($amount_paid == 0){

        $memberData = Member::where('userid', $userid)->first();

         if(!Session::get('role')=='admin'){

         $admin_no = Employee::where('employeeid', $request->admin)->select('mobileno')->first();


        DB::table('otpverify')->where('mobileno', $admin_no->mobileno)->orderBy('otpverifyid', 'desc')->update(['isexpired' => 1]);
         }
         // DB::table('otpverify')->where('mobileno', $memberData->mobileno)->orderBy('otpverifyid', 'desc')->update(['isexpired' => 1]);


        if(!empty($memberData)){
          $memberid = $memberData->memberid;
          $fullname = ucfirst($memberData->firstname).' '.ucfirst($memberData->lastname);
        } else {
          $memberid = 0;
        }

        if($remainingamount == 0){
          $transaction_type = 'Fully';
        } else {
          $transaction_type = 'Partially';
        }

        if($discount_radio == 'rs'){
          $discount_type = 1;
        } else {
          $discount_type = 2;
        }

        // receipt no autoincrement start
        $rr_no = Payment::where('status', 1)->orderBy('paymentid', 'desc')->first();
        if(!empty($rr_no) || $rr_no != null ){
          $rr_no_insert = $rr_no->receiptno + 1;
        } else {
          $rr_no_insert = 1;
        }
        // receipt no autoincrement end

        $memberpackage = Memberpackages::where('memberTransactionId', $result_of_transaction)->first();
        if(!empty($memberpackage)){
          $memberpackagesid = $memberpackage->memberpackagesid;
        }
        $schemeactualprice=   $scheme_name->actualprice;
      $schemebaseprice= $scheme_name->baseprice ;
        //dd($taxamount);
        $payment =  Payment::create([
            'memberid' =>  $memberid,
            'userid' => $userid,
            'actualamount' =>  (int)round($total_amount),
            'amount' =>  0,
            'tax' =>   (int)round($tax),
            'taxamount' =>  (int)round($taxamount),
            'discount' => (int)round($discount_type),
            'discountamount' => (int)round($Discount),
            'date' => date('Y-m-d'),
            'paymentdate' => date('Y-m-d H:i:s'),
            'mode' => 'no mode',
            'schemeid' => $schemeid,
            'type' => 'Debit',
            'remarks' =>  'no mode',
            'receiptno' => $rr_no_insert,
            'invoiceno' => $memberpackagesid,
            'invoicetype' => 'm',
            'remainingamount'=> 0 ,
            'takenby' => session()->get('admin_id'),
            'duedate' => NULL,
            'paymentTransactionId' => $result_of_transaction,
            'schemeactualprice'=>$schemeactualprice,
            'schemebaseprice'=>$schemebaseprice,
          ]);

        $last_payment_id_for_free = DB::getPdo()->lastInsertId();

        $invoice = Payment::where('paymentid', $last_payment_id_for_free)->first();
        if(!empty($invoice)){
          $invoice_no = $invoice->invoiceno;
          $remainingamount = $invoice->remainingamount;
        }

        $transaction_data = TransactionModel::where('transactionid', $result_of_transaction)->first();
        if(!empty($transaction_data)){
          $transaction_type = $transaction_data->transactiontype;
          $transaction_data->transactionstatus = 1;
          $transaction_data->save();
        }

        $memberpackages_data = MemberPackages::where('memberTransactionId', $result_of_transaction)->first();
        if(!empty($memberpackages_data)){
          $userid = $memberpackages_data->userid;
          $memberpackages_data->status = 1;
          $memberpackages_data->save();
        }

        $scheme = Scheme::where('schemeid', $schemeid)->first();
        if(!empty($scheme)){
          $scheme_name = $scheme->schemename;
          $rootschemeid = $scheme->rootschemeid;
        }
        $loginuser = session()->get('username');
        $actionbyid=session()->get('employeeid');
          $notify=Notify::create([
           'userid'=> $userid,
           'details'=> ''.$loginuser.' assign package '.$scheme_name,
           'actionby'=>$actionbyid,
         ]);

        if(empty($amount_paid)){
          $amount_paid = 0;
        }
          /*****for pt button in summry page****** */
          $memberid=0;
          if(Member::where('userid',$userid)->pluck('memberid')->first()){
            $memberid = Member::where('userid',$userid)->pluck('memberid')->first();
          }
          $member_data = Member::where('userid', $userid)->first();
          if($memberpackages_data->joindate  <= date('Y-m-d')){
            if(!empty($member_data)){
              $member_data->status = 1;
              $member_data->save();
            }
          }
           /****End *for pt button in summry page****** */
        /*$summry = array("fullname"=>$fullname, "joindate"=>$joindate,
                 "enddate"=>$expiredate, "amount"=>$amount_paid,  "InvoiceID"=>$invoice_no, "TransactionType"=>$transaction_type, "duedate"=>$due_date,
                 "dueamnt"=>$remainingamount,"package"=>$scheme_name, "transactionid"=>$result_of_transaction, 'userid'=>$userid);*/
        $summry = array("fullname"=>$fullname, "joindate"=>$joindate,
                  "enddate"=>$expiredate, "amount"=>$amount_paid, 'mobileno'=>$mobileno, 'userid'=>$userid, 'memberid'=>$memberid,   "InvoiceID"=>$invoice_no, "TransactionType"=>$transaction_type, "duedate"=>$due_date,
                  "dueamnt"=>$remainingamount,"package"=>$scheme_name, "transactionid"=>$result_of_transaction ,"rootschemeid"=>$rootschemeid,"msg" => '');



      return view('admin.transaction.summry')->with('summry',$summry);

      } else {


        return view('admin.transaction.transcation')->with(compact('rootscheme_name', 'scheme_name', 'user', 'userid', 'schemeid', 'RootSchemeId', 'tax_radio', 'Discount', 'discount_radio', 'ActualAmount','total_amount', 'amount_paid', 'BaseAmount', 'remaining_amount', 'PaymentTypes', 'tax', 'remainingamount', 'due_date', 'BaseAmounthidden','result_of_transaction'));
      }
}

    public function placeorderfinal(Request $request){
      //dd($request->toArray());
      $RootSchemeId = $request->RootSchemeId;
      $transactionId = $request->transactionId;
      $schemeid = $request->SchemeID;
      $userid = $request->userid;
      $ActualAmount = $request->ActualAmount;
      $tax_radio = $request->tax_radio;
      $Discount = $request->Discount;
      $discount_radio = $request->discount_radio;
      $total_amount = $request->total_amount;
      $amount_paid = $request->amount_paid;
      $BaseAmount = $request->BaseAmount;
      $BaseAmounthidden = $request->BaseAmount;
      $tax = $request->tax;
      $remainingamount = $request->remainingamount;
      $due_date = !empty($request->due_date) ? $request->due_date : null;
      $mode_payment= $request->Mode;
      $remark= $request->Remark;
      $amount= $request->Amount;
      $ActualAmount_payment = 0;
      $memberid = 0;
      $discount_type = 0;

      $check_transaction = TransactionModel::where('transactionid', $transactionId)->first();
      if(!empty($check_transaction)){
        if($check_transaction->transactionstatus == 1){
          return redirect()->route('assignPackageOrRenewalPackage');
        }
      }
     /* if(session()->get('transactionsecond') != null){
        session()->forget('transactionsecond');
      } else {
        return redirect()->route('demopayment');
      }*/



       $payment_process = DB::transaction(function () use($RootSchemeId, $schemeid, $userid, $ActualAmount, $tax_radio, $Discount, $discount_radio, $total_amount, $amount_paid, $BaseAmount, $BaseAmounthidden, $tax, $remainingamount, $due_date, $transactionId, $mode_payment, $remark, $amount, $ActualAmount_payment ){


        $transcation_data = TransactionModel::where('transactionid', $transactionId)->first();

        if(!empty($transcation_data)){
          $transcation_data->transactionStatus = 1;
          $transcation_data->save();
        }

        $memberpackages_data = MemberPackages::where('memberTransactionId', $transactionId)->first();
        if(!empty($memberpackages_data)){
          $userid = $memberpackages_data->userid;
          $memberpackages_data->status = 1;
          $memberpackagesid = $memberpackages_data->memberpackagesid;
          $memberpackages_data->save();
        }

        $member_data = Member::where('userid', $userid)->first();
        if(!empty($member_data)){
          $memberid = $member_data->memberid;
        }

        /// start entry in payment table
        if($discount_radio == 'rs'){
          $discount_type = 1;
        } else {
          $discount_type = 2;
        }
        //dd($BaseAmounthidden);
        // tax calculation start
        if($tax_radio == 'withtax'){
          $tax = $tax;
          if($discount_radio == 'rs'){
            $Discount = $Discount;
            $discount_amount = (int)round($BaseAmount - $Discount);
            $apply_tax = ($discount_amount/100) * $tax;
            $taxamount = (int)round($apply_tax);
          //dd($taxamount);
          } else {
            /*$Discount_calculation = ($BaseAmount/100) * $Discount;
            $Discount = $Discount_calculation;*/
            $discountamountper = $BaseAmount - $Discount;
            $taxamount = (int)round(($discountamountper/100) * $tax);
            //$taxamount = $apply_tax;

          }


        } else {
          if($discount_radio != 'rs'){
            //$Discount_calculation = ($BaseAmount/100) * $Discount;
            //$Discount = $Discount_calculation;
            $discountamountper = (int)round($BaseAmount - $Discount);

          }
          $tax = 0;
          $taxamount = 0;
        }
      // tax calculation end

        //dd($discountamountper);

        //if no mode selected or 100% discount
        if(empty($mode_payment)){

          $mode = array();
          array_push($mode, 'no mode');

          // receipt no autoincrement start
          $rr_no = Payment::where('status', 1)->orderBy('paymentid', 'desc')->first();
          if(!empty($rr_no) || $rr_no != null ){
            $rr_no_insert = $rr_no->receiptno + 1;
          } else {
            $rr_no_insert = 1;
          }
          // receipt no autoincrement end

        $scheme_name = Scheme::where('schemeid', $schemeid)->first();
        $schemeactualprice=   $scheme_name->actualprice;
        $schemebaseprice= $scheme_name->baseprice ;

          $payment =  Payment::create([
            'memberid' =>  $memberid,
            'userid' => $userid,
            'actualamount' =>  (int)round($ActualAmount),
            'amount' =>  (int)round($ActualAmount),
            'tax' =>   (int)round($tax),
            'taxamount' =>   (int)round($taxamount),
            'discount' => (int)round($discount_type),
            'discountamount' => (int)round($Discount),
            'date' => date('Y-m-d H:i:s'),
            'paymentdate' => now(),
            'mode' => PaymentType::find($mode_payment[$n])->paymenttype,
            'schemeid' => $schemeid,
            'type' => 'Debit',
            'remarks' =>  'no mode',
            'invoiceno' => $memberpackagesid,
            'receiptno' => $rr_no_insert,
            'remainingamount'=> !empty($remainingamount) ? $remainingamount : 0 ,
            'duedate' => $due_date,
            'invoicetype' =>  'm',
            'takenby' => session()->get('admin_id'),
            'paymentTransactionId' => $transactionId,
            'schemeactualprice'=>$schemeactualprice,
            'schemebaseprice'=>$schemebaseprice,
          ]);

          $last_payment_id = DB::getPdo()->lastInsertId();

          $transaction_update = TransactionModel::where('transactionid', $transactionId)->first();
          if(!empty($transaction_update)){
            $transaction_update->transactionStatus = 1;
            $transaction_update->save();
          }

        } else {
          //if multiple mode
                $rr_no_insert = 0;
                 $rr_no = Payment::where('status', 1)->max('receiptno');
                 if(!empty($rr_no) || $rr_no != null ){
                   $rr_no_insert = $rr_no + 1;
                 } else {
                   $rr_no_insert = 1;
                 }

          $scheme_name = Scheme::where('schemeid', $schemeid)->first();
          $schemeactualprice=   $scheme_name->actualprice;
          $schemebaseprice= $scheme_name->baseprice;
          for ($n=0; $n < count($mode_payment) ; $n++) {

            $ActualAmount_payment += $amount[$n];

            // receipt no autoincrement start
            // $rr_no_insert = 0;

            // $rr_no = Payment::where('status', 1)->orderBy('paymentid', 'desc')->first();
            // if(!empty($rr_no) || $rr_no != null ){
            //   $rr_no_insert = $rr_no->receiptno + 1;

            // } else {

            //   $rr_no_insert = 1;
            // }


            $payment =  Payment::create([
              'memberid' =>  $memberid,
              'userid' => $userid,
              'actualamount' =>  (int)round($total_amount),
              'amount' =>  $amount[$n],
              'amountwithtax' => (int)round($total_amount),
              'tax' =>   (int)round($tax),
              'taxamount' =>   (int)round($taxamount),
              'discount' => $discount_type,
              'discountamount' => (int)round($Discount),
              'date' => date('Y-m-d H:i:s'),
              'paymentdate' => now(),
              'mode' => PaymentType::find($mode_payment[$n])->paymenttype,
              'schemeid' => $schemeid,
              'type' => 'Debit',
              'remarks' =>  $remark[$n],
              'invoiceno' => $memberpackagesid,
              'receiptno' => $rr_no_insert,
              'remainingamount'=> !empty($remainingamount) ? (int)round($remainingamount) : 0 ,
              'duedate' => $due_date,
              'invoicetype' =>  'm',
              'takenby' => session()->get('admin_id'),
              'paymentTransactionId' => $transactionId,
                'schemeactualprice'=>$schemeactualprice,
            'schemebaseprice'=>$schemebaseprice,
            ]);
          }//end of for


          //dd($total_amount);
          $payment =  Payment::create([
            'memberid' =>  $memberid,
            'userid' => $userid,
            'actualamount' =>  (int)round($total_amount),
            'amount' =>  (int)round($ActualAmount_payment),
            'amountwithtax' => (int)round($total_amount),
            'tax' =>   (int)round($tax),
            'taxamount' =>   (int)round($taxamount),
            'discount' => $discount_type,
            'discountamount' => (int)round($Discount),
            'date' => date('Y-m-d'),
            'paymentdate' => now(),
            'mode' => 'total',
            'schemeid' => $schemeid,
            'type' => 'Debit',
            'remarks' =>  '',
            'invoiceno' => $memberpackagesid,
            'receiptno' => $rr_no_insert,
            'remainingamount'=> !empty($remainingamount) ? (int)round($remainingamount) : 0 ,
            'duedate' => date('Y-m-d',strtotime($due_date)),
            'invoicetype' =>  'm',
            'takenby' => session()->get('admin_id'),
            'paymentTransactionId' => $transactionId,
              'schemeactualprice'=>$schemeactualprice,
            'schemebaseprice'=>$schemebaseprice,
          ]);

          $last_payment_id = DB::getPdo()->lastInsertId();

          $transaction_update = TransactionModel::where('transactionid', $transactionId)->first();
          if(!empty($transaction_update)){
            $transaction_update->transactionStatus = 1;
            $transaction_update->save();
          }
        }
        /// end entry in payment table

        return $last_payment_id;


       });


      if(!empty($payment_process)){
        $invoice = Payment::where('paymentid', $payment_process)->first();
        if(!empty($invoice)){
          $invoice_no = $invoice->invoiceno;
        }
      }

      //transaction data start
      $transaction_data = TransactionModel::where('transactionid', $transactionId)->first();
      if(!empty($transaction_data)){
        $transaction_type = $transaction_data->transactiontype;
        $remainingamount = $transaction_data->transactionremainingamount;
        $userid = $transaction_data->transactionuserid;
        $memberid = $transaction_data->transactionmemberid;
      }
      //transaction data end

      // memberpackage data start
      $memberpackages_data = MemberPackages::where('memberTransactionId', $transactionId)->first();
      if(!empty($memberpackages_data)){
        $join_date = date('d-m-Y', strtotime($memberpackages_data->joindate));
        $end_date = date('d-m-Y', strtotime($memberpackages_data->expiredate));
      }
      $member_data = Member::where('userid', $userid)->first();
      if($memberpackages_data->joindate  <= date('Y-m-d')){
        if(!empty($member_data)){
           $member_data->status = 1;
           $member_data->save();
        }
      }

      // memberpackage data end
      $scheme_name='';
      $rootscheme_name = RootScheme::where('rootschemeid', $RootSchemeId)->first();
      $scheme = Scheme::where('schemeid', $schemeid)->first();
      if(!empty($scheme)){
        $scheme_name = $scheme->schemename;
      }
      $fullname='';
      $user = User::leftjoin('member', 'users.memid', 'member.memberid')->where('users.userid', $userid)->get()->first();
      if(!empty($user)){
        $fullname = ucfirst($user->firstname).' '.ucfirst($user->lastname);
        $fname = ucfirst($user->firstname);
        $lname = ucfirst($user->lastname);
      }
      $loginuser = session()->get('username');
       $actionbyid=session()->get('employeeid');
       $notify=Notify::create([
       'userid'=> $userid,
       'details'=> ''.$loginuser.' assign package '.$scheme_name,
        'actionby'=>$actionbyid,
     ]);

      //maxexpirydate find start

      $maxdateforexpiry = '1970-01-01';
      $all_memberpackages = Memberpackages::where('userid', $userid)->get()->all();
      if(!empty($all_memberpackages)){
        foreach ($all_memberpackages as $key => $memberpackages) {
          if($memberpackages->expiredate > $maxdateforexpiry){
            $maxdateforexpiry = $memberpackages->expiredate;
          }
        }
      }
      //maxexpirydate find end



      //update deviceuser start

      $deviceuser_data = Deviceusers::where('userid', $userid)->first();
      if(!empty($deviceuser_data)){
        $deviceuser_data->expirydate = date('Y-m-d', strtotime($maxdateforexpiry));
        $deviceuser_data->save();
      }

      //update deviceuser end

      //update user start

      $user_data = User::where('userid', $userid)->first();
      if(!empty($user_data)){
        $user_data->userexpirydate = date('Y-m-d', strtotime($maxdateforexpiry));
        $user_data->save();
      }
$memberactive = Member::where('userid',$userid)->get()->first();
	$memberactive->status = 1;
	$memberactive->save();
      //update user end

      //memberdata for message start





      $oldpayment_data = '';
      $request = $invoice_no;
      $payment= Payment::where('invoiceno',$request)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->get()->all();

   /* if(empty($payment)){
      $payment= Payment::where('invoiceno',$request)->where('mode','!=','total')->where('invoicetype', 'o')->get()->all();
    }*/


        $payment1 = Payment::where('invoiceno',$request)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->get()->first();
        /*if(empty($payment1)){
          $payment1 = Payment::where('invoiceno',$request)->where('mode','!=','total')->where('invoicetype', 'o')->get()->first();
        }*/

        $schemeactualprice =$payment1->schemeactualprice;
        $schemebaseprice =$payment1->schemebaseprice;

        $total_payment = Payment::where('invoiceno',$request)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->first();
        /*if(empty($total_payment)){
          $total_payment = Payment::where('invoiceno',$request)->where('mode','!=','total')->where('invoicetype', 'o')->first();
        }*/

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
        $rootschemeid=$scheme->rootschemeid;
          //echo $id;

        $memberpackage = MemberPackages::where('userid',$id)->where('schemeid',$payment1->schemeid)->where('status',1)->where('memberpackagesid', $request)->get()->first();

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


      /*dd($payment[0]);*/
      $filename = time().'invoice.pdf';
       $pdflink = url('/').'/transactionpaymentreceipt/'.$invoice_no.'/'.$phoneno;

//      $pdflink = app('bitly')->getUrl($pdflink);

      $tax = $payment_tax;
      $pdf = PDF::loadView('admin.paymenttransactionreceipt', compact('member','totalpay','request','payment','phoneno','scheme','memberpackage','word','companyName','Gstno','duedate','takenby','discount','tax', 'total_payment', 'oldpayment_data','payment1'));
      $pdf->save(public_path('mailpdf/'.$filename));

      $payment_data = Payment::where('paymentid', $payment_process)->first();
      if(!empty($payment_data)){
        $payment_data->receiptname = $filename;
        $payment_data->save();
      }


    $member_message = Member::where('userid', $userid)->first();
      if(!empty($member_message)){
        $mobileno = $member_message->mobileno;
        $member_id = $member_message->memberid;
        $email = $member_message->email;
      }

      //memberdata for message end

      //sms start

      $msg=   DB::table('messages')->where('messagesid','13')->get()->first();

      $msg =$msg->message;
      $msg = str_replace("[Name of Member]",$fullname,$msg);
      $msg= str_replace("[ID]",$member_id,$msg);
      $msg= str_replace("[Name of Packge]",$scheme_name,$msg);
      $msg= str_replace("[Fully/Partially]",$transaction_type,$msg);
      $msg= str_replace("100",$amount_paid,$msg);
      $msg= str_replace("[join date]",$join_date,$msg);
      $msg= str_replace("[End Date]", $end_date,$msg);
      $msg= str_replace("[InvoiceID]",$invoice_no,$msg);
      $msg= str_replace("[url]", $pdflink,$msg);


      $due='';
      if($transaction_type == 'Partially'){
        $due="Due Amount:[Due Amount] Next Due Date: [Due Date]";
        $due= str_replace("[Due Amount]",$remainingamount,$due);
        $due= str_replace("[Due Date]", $due_date,$due);

        $msg=''.$msg.''.$due.'';
      }


      $msg2 = $msg;
      $msg = urlencode($msg);

      $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

      if($smssetting) {

       $u = $smssetting->url;
       $url= str_replace('$mobileno', $mobileno, $u);
       $url=str_replace('$msg', $msg, $url);

       $otpsend = Curl::to($url)->get();
          $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($mobileno),$msg2);

       $action = new Notificationmsgdetails();
       $action->user_id = session()->get('admin_id');
       $action->mobileno = $mobileno;
       $action->smsmsg = $msg2;
       $action->smsrequestid = $otpsend;
       $action->subject = 'Payment Successfully';
       $action->save();

       }

      $tax = $payment_tax;
        $pdf = PDF::loadView('admin.paymenttransactionreceipt', compact('member','totalpay','request','payment','phoneno','scheme','memberpackage','word','companyName','Gstno','duedate','takenby','discount','tax', 'total_payment', 'oldpayment_data','payment1'));
       $pdf->save(public_path('mailpdf/'.$filename));

       $emailsetting =  Emailsetting::where('status',1)->first();

       if ($emailsetting && $email) {

         if(!empty($email)){
          $email = $email;
         }else{
          $email ='non@gmail.com';
         }

       $data = [
                             //'data' => 'Rohit',
               'msg' => $msg2,
               'mail'=> $email,
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
            ];


      $tt= Mail::send('admin.name', ["data1"=>$data], function($message) use ($data, $filename){
               $message->from($data['senderemail'], 'Payment Message');
               $message->to($data['mail']);
               $message->subject($data['subject']);
              $message->attach(public_path().'/mailpdf/'.$filename.'');

         });



          $action = new Emailnotificationdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->message = $msg2;
          $action->emailform = $data['senderemail'];
          $action->emailto = $data['mail'];
          $action->subject = $data['subject'];
          $action->messagefor = 'Payment Mail';
          $action->save();

        }


      $loginuser = session()->get('username');
       $actionbyid=session()->get('employeeid');

      $notify=Notify::create([
        'userid'=> $userid,
        'details'=> ''.$loginuser.' take payment of user '.$amount_paid,
        'actionby'=>$actionbyid,
      ]);

      //sms end


      $summry = array("fullname"=>$fullname, "joindate"=>$join_date,
                  "enddate"=>$end_date, "amount"=>$amount_paid, 'mobileno'=>$mobileno, 'userid'=>$userid, "InvoiceID"=>$invoice_no, "TransactionType"=>$transaction_type, "duedate"=>$due_date,
                  "dueamnt"=>$remainingamount,"package"=>$scheme_name,"rootschemeid"=>$rootschemeid,"memberid"=>$member_id,"msg"=>$msg2);

      return view('admin.transaction.summry')->with('summry',$summry);

    }


    public function transactionpaymentreceipt($id,$code){
      $payment= Payment::where('payments.invoiceno',$id)->whereIn('payments.mode',['total','no mode'])
      ->leftjoin('member','member.memberid','payments.memberid')->where('member.mobileno',$code)
      ->get()->first();
      if($payment){

        $invoiceid=$id;
        $id='';
       $memberid= $payment->memberid;
        /***********************************/
         $payment= Payment::where('invoiceno',$invoiceid)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->get()->all();


     $payment1 = Payment::where('invoiceno',$invoiceid)->where('memberid',$memberid)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->get()->first();


    // $schemeactualprice =$payment1->schemeactualprice;
    // $schemebaseprice =$payment1->schemebaseprice;

    $total_payment = Payment::where('invoiceno',$invoiceid)->where('mode','!=','total')->whereIn('invoicetype', ['m', 'o'])->first();


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
      $oldpayment_data='';
      $scheme=Scheme::where('schemeid',$payment1->schemeid)->get()->first();
      //echo $id;

      $memberpackage = MemberPackages::where('userid',$id)->where('schemeid',$payment1->schemeid)->where('memberpackagesid', $invoiceid)->get()->first();

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

     $tax=$payment_tax;
     if($oldpayment_data){
      $oldpayment_data=$oldpayment_data;
     }else{
      $oldpayment_data='';
     }
        $pdf = PDF::loadView('admin.paymenttransactionreceipt',compact('member','totalpay','request','payment','phoneno','scheme','memberpackage','word','companyName','Gstno','duedate','takenby','discount','tax', 'total_payment','oldpayment_data','payment1'));

        return $pdf->stream(''.$member->firstname.' '.$member->lastname.'.pdf');
         /******************* */

        // $pdf = new \App\TransactionPaymentReceipt;
        // $pdf->generate($id,$payment->memberid);
      }else{
        abort(404);
      }
    }
    //   public function pdfStream(Request $request,$id){

    //   $pdf = new \App\TransactionPaymentReceipt;
    //   $pdf->generate($id);

    // }
    public function remainingplaceorder($id, Request $request){
// dd($id);
      $Payment = '';
     $Payment = Payment::where('invoiceno',$id)->whereIn('invoicetype',['m','O'])->orderBy('paymentid', 'desc')->get()->first();
// dd($Payment);
      $user=User::where('userid',$Payment->userid)->get()->first();

      $Scheme = Scheme::where('schemeid',$Payment->schemeid)->get()->first();
      $PaymentTypes = PaymentType::get()->all();
      $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
      $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

      $sgst = (int)$sgst;
      $cgst = (int)$cgst;
      $tax =  $sgst + $cgst;
      $admin = Employee::where('role', 'admin')->get()->all();
      return view('admin.transaction.makePayment',compact('Payment','PaymentTypes','Scheme','user','id','tax', 'admin'));

    }

    public function remainingplaceorderprocess($id, Request $request){
      //dd($id);
        /*$request->validate([

          'userid' => 'numeric',
          'OldremainingAmount' => 'numeric',
          'paid_amount' => 'numeric',
          'remainingamount' => 'numeric',
          'PaidAmount' => 'nullable|numeric',
          'SchemeID' => 'numeric',
          'ActualAmount' => 'numeric',
          'OldPaymentDate' => 'nullable|date',
          'due_date' => 'nullable|date',

        ]);



        $orderview = session()->get('orderview');

        if(session()->get('orderview') != null){
          session()->forget('orderview');
        } else {
          return redirect()->route('remainingplaceorder', $id);
        }

        /*DB::beginTransaction();
        try{*/
        $userid = $request['userid'];
        $OldremainingAmount= $request->OldremainingAmount;
        $SchemeID= $request->SchemeID;
        $ActualAmount = $request->ActualAmount;
        $paid_amount = !empty($request->paid_amount) ? $request->paid_amount : 0;
        $payment_id = $request->payment_id;
        $remainingamount = $request->remainingamount;
        $due_date = !empty($request->due_date) ? date('Y-m-d',strtotime($request->due_date)) : null;
      //dd($due_date);
        $member = Member::where('userid',$userid)->get()->first();
        //dd($request->toArray());
        /*if($paid_amount > $remainingamount){
          return redirect()->back();
        }*/

        if($paid_amount == $OldremainingAmount){
          $transaction_type = 'Fully';
          $remainingamount_transaction = 0;
        } else {
          $transaction_type = 'Partially';
          $remainingamount_transaction = $remainingamount;
        }

        $scheme = Scheme::where('schemeid', $SchemeID)->first();
        if(!empty($scheme)){
          $rootscheme_id = $scheme->rootschemeid;
          $scheme_name = ucfirst($scheme->schemename);
        }

        $rootscheme = RootScheme::where('rootschemeid', $rootscheme_id)->first();
        if(!empty($rootscheme)){
          $rootscheme_name = $rootscheme->rootschemename;
        }

        $payment_data = Payment::where('paymentid', $payment_id)->first();
        if(!empty($payment_data)){
          $paymentTransactionId = $payment_data->paymentTransactionId;
          $invoiceno = $payment_data->invoiceno;
        }

        $payment_total = Payment::where('invoiceno', $invoiceno)->orderBy('paymentid', 'desc')->first();
        if(!empty($payment_total)){

          $actualamount = $payment_data->actualamount;
          $amount = $payment_data->amount;
          $amountwithtax = $payment_data->amountwithtax;
          $tax = $payment_data->tax;
          $discount = $payment_data->discount;
          $taxamount = $payment_data->taxamount;
          $remainingamount = $payment_data->remainingamount;
          $receiptno = $payment_data->receiptno;
          $schemeid = $payment_data->schemeid;
          $invoiceno = $payment_data->invoiceno;
          $invoicetype = $payment_data->invoicetype;
        }

        $memberpackage = MemberPackages::where('memberpackagesid', $invoiceno)->first();
        if(!empty($memberpackage)){
          $start_date = date('d-m-Y', strtotime($memberpackage->joindate));
          $end_date = date('d-m-Y', strtotime($memberpackage->expiredate));
        }

        if(!empty($member)){
          $mobileno=$member->mobileno;
          $memberid = $member->memberid;
        }

        // start transaction
        $transaction_no = hexdec(uniqid());


        $transaction = new TransactionModel();

        $transaction->transactionno = $transaction_no;
        $transaction->paymenttypeid = 1;
        $transaction->transactionuserid = $userid;
        $transaction->transactionmemberid = $memberid;
        $transaction->transactiontax = $tax;
        $transaction->transactiongstno = 0;
        $transaction->transactiontype = $transaction_type;
        $transaction->transactiondate = date('Y-m-d');
        $transaction->transactionstatus = 0;
        $transaction->transactionresponse = '';
        $transaction->transactionrefid = 0;
        $transaction->transactionschemeid = $schemeid;
        $transaction->transactionamount = !empty($request->paid_amount) ? (int)round($request->paid_amount) : 0;
        $transaction->transactionactualamount = !empty($request->ActualAmount) ? (int)round($request->ActualAmount) : 0;
        $transaction->transactiondiscount = !empty($Discount) ? (int)round($Discount) : 0;
        $transaction->transactionduedate = $due_date;
        $transaction->transactiontaxamount = (int)round($taxamount);
        if($paid_amount == 0){
          $transaction->transactionremainingamount = 0 ;
        } else {
          $transaction->transactionremainingamount = !empty($remainingamount_transaction) ? (int)round($remainingamount_transaction) : 0 ;
        }

        $transaction->save();
        // end transaction

        $last_transaction_id = DB::getPdo()->lastInsertId();

        if($request->paid_amount == 0){

          $admin_no = Employee::where('employeeid', $request->admin)->select('mobileno')->first();
          //dd($admin_no);

          DB::table('otpverify')->where('mobileno', $admin_no->mobileno)->orderBy('otpverifyid', 'desc')->update(['isexpired' => 1]);

          $rr_no_insert = 0;
          $rr_no = Payment::where('status', 1)->max('receiptno');
          if(!empty($rr_no) || $rr_no != null ){
            $rr_no_insert = $rr_no + 1;

          } else {

            $rr_no_insert = 1;
          }

          $member = Member::where('userid', $userid)->get()->first();
          if(!empty($member)){
            $fullname = ucfirst($member->firstname).' '.ucfirst($member->lastname);
          }

          $scheme_name_fetch = Scheme::where('schemeid', $SchemeID)->first();
          $schemeactualprice=   $scheme_name_fetch->actualprice;
          $schemebaseprice= $scheme_name_fetch->baseprice;

          $payment_total_all = Payment::where('invoiceno', $invoiceno)->where('mode', 'total')->orderBy('paymentid', 'desc')->first();
          if(!empty($payment_total_all)){
            $total_discount = $OldremainingAmount + $payment_total_all->discountamount;
          }

          $payment =  Payment::create([
              'memberid' =>  $memberid,
              'userid' => $userid,
              'paymentTransactionId' => $last_transaction_id,
              'actualamount' =>  (int)round($actualamount),
              'amount' =>  0,
              'amountwithtax' =>  (int)round($amountwithtax),
              'tax' => (int)round($tax),
              'taxamount' => (int)round($taxamount),
              'discount' => (int)round($discount),
              'discountamount' => (int)round($total_discount),
              'date' => date('Y-m-d H:i:s'),
              'paymentdate' => now(),
              'mode' => 'no mode',
              'schemeid' => $schemeid,
              'receiptno' =>  $rr_no_insert,
              'invoiceno' =>  $invoiceno,
              'invoicetype' =>  $invoicetype ,
              'type' => 'Debit',
              'remarks' =>  '',
              'remainingamount'=> 0,
              'takenby' => session()->get('admin_id'),
              'duedate'=>null,
              'schemeactualprice'=>$schemeactualprice,
              'schemebaseprice'=>$schemebaseprice,
          ]);

          $check_transaction = TransactionModel::where('transactionid', $last_transaction_id)->first();
          if(!empty($check_transaction)){
            $check_transaction->transactionstatus = 1;
            $check_transaction->save();
          }
          $actionbyid=session()->get('employeeid');
          $notify=Notify::create([

            'userid'=> $userid,
            'details'=> 'User has made Payment 0',
              'actionby'=>$actionbyid,
          ]);


      // sms end
          $transaction_amount = 0;
          $transactionduedate = '';
          $transactionremainingamount = 0;
          $transactiontype = 'Fully';




          //DB::commit();
          //$Success =true;
          return view('admin.transaction.remainingpaymentsummary')->with(compact('transactiontype','transaction_amount', 'invoiceno', 'mobileno', 'fullname', 'transactionduedate', 'transactionremainingamount', 'scheme_name', 'start_date', 'end_date'));

        }

        $transaction_data = TransactionModel::where('transactionid', $last_transaction_id)->first();

        if(!empty($transaction_data)){
          $transaction = $transaction_data;
        }

        //dd($transaction);
        //dd($transaction);
        $PaymentTypes = PaymentType::get()->all();

        return view('admin.transaction.remainingpaymentview')->with(compact('transaction', 'member', 'scheme_name', 'rootscheme_name','PaymentTypes', 'payment_id', 'scheme', 'rootscheme', 'userid', 'remainingamount_transaction', 'paymentTransactionId', 'invoiceno'));
         /*}catch(\Exception $e){

        $success = false;
        DB::rollback();

      }

      if($success == false){
        return redirect('dashboard');
      }*/

    }

    public function remainingpaymentstore(Request $request){

      $transactionId = $request->transactionId;
      $RootSchemeId = $request->RootSchemeId;
      $SchemeID = $request->SchemeID;
      $payment_id = $request->payment_id;
      $userid = $request->userid;
      $remainingamount_transaction = $request->remainingamount_transaction;
      $oldpaymentTransactionId= $request->oldpaymentTransactionId;
      $invoiceno_view= $request->invoiceno;
      $mode_payment= $request->Mode;
      $remark= $request->Remark;
      $amount= $request->Amount;
      $ActualAmountTotal = 0;
      //dd($oldpaymentTransactionId);

      $check_transaction = TransactionModel::where('transactionid', $transactionId)->first();
      if(!empty($check_transaction)){
        if($check_transaction->transactionstatus == 1){
          //dd($check_transaction->transactionstatus);
          return redirect()->to('dashboard');
        }
      }

      $payment_result = DB::transaction(function() use($transactionId, $RootSchemeId, $SchemeID, $payment_id, $userid, $mode_payment, $remark, $amount, $remainingamount_transaction, $ActualAmountTotal, $oldpaymentTransactionId, $invoiceno_view){

        $transaction_data = TransactionModel::where('transactionid', $transactionId)->first();
        if(!empty($transaction_data)){
          $memberid = $transaction_data->transactionmemberid;
          $due_date = date('Y-m-d', strtotime($transaction_data->transactionduedate));
        }
        //dd($oldpaymentTransactionId);
        /*$memberpackage_data = Memberpackages::where('memberTransactionId', $invoiceno_view)->first();
        if(!empty($memberpackage_data)){
          $invoiceno = $memberpackage_data->memberpackagesid;
        }*/

        $payment_data = Payment::where('invoiceno', $invoiceno_view)->orderBy('paymentid', 'desc')->first();
        //dd($payment_data);
        if(!empty($payment_data)){
          $actualamount = $payment_data->actualamount;
          $tax = $payment_data->tax;
          $amountwithtax = $payment_data->amountwithtax;
          $taxamount = $payment_data->taxamount;
          $discount = $payment_data->discount;
          $discountamount = $payment_data->discountamount;
        }

        //dd($discountamount);

        $member = Member::where('userid', $userid)->get()->first();
        $scheme_name = Scheme::where('schemeid', $SchemeID)->first();
        $schemeactualprice=   $scheme_name->actualprice;
        $schemebaseprice= $scheme_name->baseprice;

        $rr_no = Payment::where('status', 1)->orderBy('paymentid', 'desc')->first();
          if(!empty($rr_no) || $rr_no != null ){
            $rr_no_insert = $rr_no->receiptno + 1;
          } else {

            $rr_no_insert = 1;
          }

        for ($n=0; $n < count($mode_payment) ; $n++) {


          //dd($discountamount);

          $ActualAmountTotal += $amount[$n];
          $payment =  Payment::create([
              'memberid' =>  $memberid,
              'userid' => $userid,
              'paymentTransactionId' => $transactionId,
              'actualamount' =>  (int)round($actualamount),
              'amount' =>  $amount[$n],
              'amountwithtax' =>  (int)round($amountwithtax),
              'tax' => (int)round($tax),
              'taxamount' => (int)round($taxamount),
              'discount' => (int)round($discount),
              'discountamount' => (int)round($discountamount),
              'date' => date('Y-m-d H:i:s'),
              'paymentdate' => now(),
              'mode' => PaymentType::find($mode_payment[$n])->paymenttype,
              'schemeid' => $SchemeID,
              'receiptno' =>  $rr_no_insert,
              'invoiceno' =>  $invoiceno_view,
              'invoicetype' =>  'm',
              'Type' => 'Debit',
              'Remarks' =>  $remark[$n],
              'remainingamount'=> (int)round($remainingamount_transaction),
              'takenby' => session()->get('admin_id'),
              'duedate'=>$due_date,
               'schemeactualprice'=>$schemeactualprice,
            'schemebaseprice'=>$schemebaseprice,
          ]);

        }//end of foreach

        /*$rr_no = Payment::where('status', 1)->orderBy('paymentid', 'desc')->first();
        if(!empty($rr_no) || $rr_no != null ){
          $rr_no_insert = $rr_no->receiptno + 1;
        } else {

          $rr_no_insert = 1;
        }*/

        $payment =  Payment::create([
              'memberid' =>  $memberid,
              'userid' => $userid,
              'paymentTransactionId' => $transactionId,
              'actualamount' =>  (int)round($actualamount),
              'amount' =>  (int)round($ActualAmountTotal),
              'amountwithtax' =>  (int)round($amountwithtax),
              'tax' => (int)round($tax),
              'taxamount' => (int)round($taxamount),
              'discount' => (int)round($discount),
              'discountamount' => (int)round($discountamount),
              'date' => date('Y-m-d H:i:s'),
              'paymentdate' => now(),
              'mode' => 'total',
              'schemeid' => $SchemeID,
              'receiptno' =>  $rr_no_insert,
              'invoiceno' =>  $invoiceno_view,
              'invoicetype' =>  'm',
              'Type' => 'Debit',
              'Remarks' =>  '',
              'remainingamount'=> (int)round($remainingamount_transaction),
              'takenby' => session()->get('admin_id'),
              'duedate'=>$due_date,
               'schemeactualprice'=>$schemeactualprice,
            'schemebaseprice'=>$schemebaseprice,
          ]);

        return $transactionId;

      });//end of DB::transaction



      $transaction_data = TransactionModel::where('transactionid', $payment_result)->first();
      if(!empty($transaction_data)){
        $transaction_data->transactionstatus = 1;
        $transactiontype = $transaction_data->transactiontype;
        $transaction_amount = $transaction_data->transactionamount;
        $transactionduedate = date('d-m-Y', strtotime($transaction_data->transactionduedate));
        $transactionremainingamount = $transaction_data->transactionremainingamount;
        $transaction_data->save();
      }

      $member = Member::where('userid', $userid)->get()->first();
      if(!empty($member)){
        $fullname = ucfirst($member->firstname).' '.ucfirst($member->lastname);
        $memberid = $member->memberid;
        $mobileno = $member->mobileno;
        $email = $member->email;
        $fname = ucfirst($member->firstname);
           $lname = ucfirst($member->lastname);

      }

      $payment_data = Payment::where('paymentTransactionId', $transactionId)->orderBy('paymentid', 'desc')->first();
      if(!empty($payment_data)){
        $invoiceno = $payment_data->invoiceno;
      }

      $scheme_data = Scheme::where('schemeid', $SchemeID)->first();
      if(!empty($scheme_data)){
        $scheme_name = $scheme_data->schemename;
      }

      $memberpackage_data = Memberpackages::where('memberpackagesid', $invoiceno_view)->first();
      if(!empty($memberpackage_data)){
        $start_date = date('d-m-Y', strtotime($memberpackage_data->joindate));
        $end_date = date('d-m-Y', strtotime($memberpackage_data->expiredate));
      }

      // sms start
        $pdflink = url('/').'/transactionpaymentreceipt/'.$invoiceno.'/'.$mobileno;
//      $pdflink = app('bitly')->getUrl($link_send);

      $today_date = date('d-m-Y');
      $msg= DB::table('messages')->where('messagesid','14')->get()->first();
      $msg =$msg->message;
      $name=$fname.$lname;
      $msg = str_replace("[Name of Member]",$name,$msg);
      $msg= str_replace("[ID]",$memberid,$msg);
          // $msg= str_replace("[Name of Packge]",$pack,$msg);
      $msg= str_replace("[Full/Partial]",$transactiontype,$msg);
      $msg= str_replace("[Amount]",$transaction_amount,$msg);
      $msg= str_replace("[InvoiceID]",$invoiceno,$msg);
      $msg= str_replace("[Date]",$today_date,$msg);
      $msg= str_replace("[url]", $pdflink,$msg);


      $due='';
      if($transactiontype == 'Partially'){
        $due="Due Amount:[Due Amount] Next Due Date: [Due Date]";
        $due= str_replace("[Due Amount]",$transactionremainingamount,$due);
        $due= str_replace("[Due Date]", $transactionduedate,$due);

        $msg=''.$msg.' '.$due.'';
      }
      $msg2 = $msg;
      $msg = urlencode($msg);

      $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

       if ($smssetting) {

       $u = $smssetting->url;
       $url= str_replace('$mobileno', $mobileno, $u);
       $url=str_replace('$msg', $msg, $url);

      $otpsend = Curl::to($url)->get();
//      $otpsend = 0;
           $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($mobileno),$msg2);

      $action = new Notificationmsgdetails();
      $action->user_id = session()->get('admin_id');
      $action->mobileno = $mobileno;
      $action->smsmsg = $msg2;
      $action->smsrequestid = $otpsend;
      $action->subject = 'Remaing Payment';
      $action->save();
        # code...
       }

      $emailsetting =  Emailsetting::where('status',1)->first();

      if ($emailsetting && $email) {

       $data = [
                             //'data' => 'Rohit',
               'msg' => $msg2,
               'mail'=> $email,
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
            ];


       Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

               $message->from($data['senderemail'], 'Payment Message');
               $message->to($data['mail']);
               $message->subject($data['subject']);



         });

          $action = new Emailnotificationdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->message = $msg2;
          $action->emailform = $data['senderemail'];
          $action->emailto = $data['mail'];
          $action->subject = $data['subject'];
          $action->messagefor = 'Payment Mail';
          $action->save();

        }

      // $otpsend = Curl::to('http://sms.weybee.in/api/sendapi.php?auth_key=2169KrEMnx2ZgAqSfavSSC&mobiles='.$mobileno.'&message='.$msg.'&sender=senderid&route=4')->get();

      $actionbyid=session()->get('employeeid');

      $notify=Notify::create([

        'userid'=> $userid,
        'details'=> 'User has made Payment '.$transaction_amount,
        'actionby'=>$actionbyid,
      ]);
      // sms end

      return view('admin.transaction.remainingpaymentsummary')->with(compact('transactiontype','transaction_amount', 'mobileno', 'invoiceno', 'fullname', 'transactionduedate', 'transactionremainingamount', 'scheme_name', 'start_date', 'end_date','msg2'));

    }
/**************************REG Payment*************************************************/
    public function regpaymentview(Request $request){
            $loginuser = session()->get('username');

      $reg_fee_data = DB::table('registrationpayment')->get()->first();
      if(!empty($reg_fee_data)){
        $reg_fee = $reg_fee_data->payment;
      }

      $PaymentTypes = PaymentType::get()->all();
       $schemename='';
      $reg_data = Registration::where('id', 1)->first();
      if(!empty($reg_data)){
        $package = Scheme::where('schemeid',$reg_data->package_id)->get()->first();
        if(!empty($package)){
          $schemeid = $package->schemeid;
          $schemename = $package->schemename;
        }
      }

      $user_data = User::where('regid', 1)->first();

      return view('admin.transaction.regstration.orderview', compact('reg_fee', 'reg_data', 'PaymentTypes', 'schemeid','schemename', 'user_data'));

    }

    public function placeorderforregstration(Request $request){

      $loginuser = session()->get('username');

      $userid = $request->userid;
      $reg_fee = $request->reg_fee;
      $regid = $request->reg_id;
      $schemeid = $request->schemeid;
      $transaction_id= $request->transaction_id;
      $mode_payment= $request->Mode;
      $remark= $request->Remark;
      $amount= $request->Amount;
      $ActualAmount_payment = 0;

      $check_transaction = TransactionModel::where('transactionid', $transaction_id)->first();
      if(!empty($check_transaction)){
        if($check_transaction->transactionstatus == 1){
          //dd($check_transaction->transactionstatus);
          return redirect('registrationdetails');
        }
      }

      $payment_process = DB::transaction(function () use($userid, $reg_fee, $regid, $schemeid, $mode_payment, $remark, $amount,$ActualAmount_payment, $transaction_id){
  $rr_no_insert = 0;
   $reg_data = Registration::where('id', $regid)->first();

        if(!empty($reg_data)){
          $mobileno = $reg_data->phone_no;
          $regtypeid = $reg_data->regtypeid;
        }
            $rr_no = Payment::where('status', 1)->orderBy('paymentid', 'desc')->first();
            if(!empty($rr_no) || $rr_no != null ){
              $rr_no_insert = $rr_no->receiptno + 1;

            } else {

              $rr_no_insert = 1;
            }

        $schemeactualprice = $reg_fee;
        $schemebaseprice = $reg_fee;
        for ($n=0; $n < count($mode_payment) ; $n++) {

            $ActualAmount_payment += $amount[$n];

            // receipt no autoincrement start


            $loginuser = session()->get('username');
            $payment =  Payment::create([
              'memberid'=>'0',
              'userid' => $userid,
              'actualamount' =>  $reg_fee,
              'paymentTransactionId' =>  $transaction_id,
              'amount' =>  $amount[$n],
              'amountwithtax' => $reg_fee,
              'date' => date('Y-m-d H:i:s'),
              'paymentdate' => now(),
              'mode' => PaymentType::find($mode_payment[$n])->paymenttype,
              'schemeid' => $regtypeid,
              'type' => 'Debit',
              'remarks' =>  $remark[$n],
              'invoiceno' => $regid,
              'receiptno' => $rr_no_insert,
              'invoicetype' => 'r',
               'takenby' => session()->get('admin_id'),
                'schemeactualprice' => $schemeactualprice,
              'schemebaseprice' => $schemebaseprice,
            ]);
          }//end of for

          //dd($total_amount);

         $loginuser = Session::get('username');
          $payment =  Payment::create([
            'memberid'=>'0' ,
            'userid' => $userid,
            'actualamount' =>  $reg_fee,
            'paymentTransactionId' =>  $transaction_id,
            'amount' =>  $ActualAmount_payment,
            'amountwithtax' => $reg_fee,
            'date' => date('Y-m-d H:i:s'),
            'paymentdate' => now(),
            'mode' => 'total',
            'schemeid' => $schemeid,
            'type' => 'Debit',
            'remarks' =>  '',
            'invoiceno' => $regid,
            'receiptno' => $rr_no_insert,
            'invoicetype' => 'r',
             'takenby' => session()->get('admin_id'),
              'schemeactualprice' => $schemeactualprice,
              'schemebaseprice' => $schemebaseprice,
          ]);

          $last_payment_id = DB::getPdo()->lastInsertId();

          $transaction_update = TransactionModel::where('transactionid', $transaction_id)->first();
          if(!empty($transaction_update)){
            $transaction_update->transactionStatus = 1;
            $transaction_update->save();
          }

          $regid_update = Registration::where('id', $regid)->first();
          if(!empty($regid_update)){
            $regid_update->status = 1;
            $regid_update->save();
          }

          $user_data = User::where('regid', $regid)->first();
          if(!empty($user_data)){
            $user_data->useractive = 1;
            $userid  = $user_data->userid;
            $user_data->save();
          }

        /*  $device_user = Deviceusers::where('userid', $userid)->first();
          if(!empty($device_user)){
            $device_user->isactive = 1;
            $device_user->save();
          }*/

          return $last_payment_id;

      });//end of payment process

      $reg_data = Registration::where('id', $regid)->first();
      $regtypeid=0;
      if(!empty($reg_data)){
        $fname = $reg_data->firstname;
        $lname = $reg_data->lastname;
        $mobileno = $reg_data->phone_no;
          $regtypeid = $reg_data->regtypeid;
      }

      $reg_data->status=1;
      $reg_data->save();
      $payment_data = Payment::where('paymentid', $payment_process)->first();
      $schemename=Scheme::where('schemeid',$payment_data->schemeid)->get()->first();
      $schemename=$schemename->schemename;

      $msg=   DB::table('messages')->where('messagesid','20')->get()->first();

      $msg =$msg->message;
      $msg = str_replace("[FirstName]",$fname,$msg);
      $msg= str_replace("[LastName]",$lname,$msg);
      $msg2 = $msg;
      $msg = urlencode($msg);

       $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

       if ($smssetting) {

       $u = $smssetting->url;
       $url= str_replace('$mobileno', $mobileno, $u);
       $url=str_replace('$msg', $msg, $url);

      $otpsend = Curl::to($url)->get();
//      $otpsend = 0;
           $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($mobileno),$msg2);

      $action = new Notificationmsgdetails();
      $action->user_id = session()->get('admin_id');
      $action->mobileno = $mobileno;
      $action->smsmsg = $msg2;
      $action->smsrequestid = $otpsend;
      $action->subject = 'Place Order From Registration!';
      $action->save();

       # code...
       }



      // $otpsend = Curl::to('http://sms.weybee.in/api/sendapi.php?auth_key=2169KrEMnx2ZgAqSfavSSC&mobiles='.$mobileno.'&message='.$msg.'&sender=PYOFIT&route=4')->get();

      return view('admin.transaction.regstration.reg_summary')->with(compact('reg_data', 'payment_data', 'reg_fee','schemename'));


      //return redirect()->to('registrationdetails');
    }

    public function receiptforregister($id){

      $pdf = new \App\RegstrationPaymentReceipt;
      $pdf->generate($id);

    }
}
