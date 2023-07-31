<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\MemberPackages;
use App\RootScheme;
use App\User;
use App\Smssetting;
use App\Emailsetting;
use Mail;
use App\Emailnotificationdetails;
use PDF;
use App\Notificationmsgdetails;
use App\TransactionModel;
use App\Scheme;
use DB;
use Ixudra\Curl\Facades\Curl;

class SendSmsEmailController extends Controller
{
    public function smsafterpack(Request $request){

    	 $invoice_no = $request->get('invoiceid');

    	 $transactionId=Payment::where('invoiceno',$invoice_no)->pluck('paymentTransactionId')->first();
   	 	$amount_paid=Payment::where('invoiceno',$invoice_no)->whereIn('mode',['no mode','total'])->pluck('amount')->first();
   	 	$due_date=Payment::where('invoiceno',$invoice_no)->whereIn('mode',['no mode','total'])->pluck('duedate')->first();

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
		$scheme=Scheme::where('schemeid', $memberpackages_data->schemeid)->first();
		$schemeid=$scheme->schemeid;
        $RootSchemeId=$scheme->rootschemeid;
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
      $member_id=$user->memberid;
      $mobileno=$user->mobileno;
      if(!empty($user)){
        $fullname = ucfirst($user->firstname).' '.ucfirst($user->lastname);
        $fname = ucfirst($user->firstname);
        $lname = ucfirst($user->lastname);
      }
      $pdflink = url('/').'/transactionpaymentreceipt/'.$invoice_no.'/'.$mobileno;
//      $pdflink = app('bitly')->getUrl($pdflink);
      //msg make
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

       $action = new Notificationmsgdetails();
       $action->user_id = session()->get('admin_id');
       $action->mobileno = $mobileno;
       $action->smsmsg = $msg2;
       $action->smsrequestid = $otpsend;
       $action->subject = 'Payment Successfully';
       $action->save();

       }

      if (strpos($otpsend, '"ErrorCode":"000"') == 1) {
          $success = 'true';
      }else{
      	 $success = 'false';
      }
      return $success;




    }
    public function emailafterpack(Request $request){
      $storagePath='';
      $invoice_no = $request->get('invoiceid');
      $userid=$request->get('userid');
      $user = User::leftjoin('member', 'users.memid', 'member.memberid')->where('users.userid', $userid)->get()->first();

      $mobileno=$user->mobileno;
      $filename=Payment::where('invoiceno',$invoice_no)
      ->where('receiptname','!=',null)->pluck('receiptname')->first();

      $emailsetting =  Emailsetting::where('status',1)->first();
      $email=$user->email;
      $storagePath='mailpdf/'.$filename;
      if($emailsetting) {
        $data = [
               'msg' => 'Your Invoice',
               'mail'=> $email,
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
        ];

            // dd(public_path().'\mailpdf\\'.$filename.'');
        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data, $filename){
          $message->from($data['senderemail'], 'Payment Message');
          $message->to($data['mail']);
          $message->subject($data['subject']);
          $message->attach(public_path().'/mailpdf/'.$filename.'', ['mime' => 'application/pdf']);

        });

          $action = new Emailnotificationdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->message = $data['msg'];
          $action->emailform = $data['senderemail'];
          $action->emailto = $data['mail'];
          $action->subject = $data['subject'];
          $action->messagefor = 'Payment Mail';
          $action->save();
           $success = true;
           return $success;
        }
    }

}
