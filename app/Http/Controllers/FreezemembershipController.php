<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\MemberPackages;
use App\FreezeMembershipModal;
use App\TransactionModel;
use App\Actionlog;
use Ixudra\Curl\Facades\Curl;
use App\Smssetting;
use App\Notification;
use App\Notificationmsgdetails;
use App\Emailnotificationdetails;
use App\Emailsetting;
use App\PaymentType;
use App\MiscellaneousCharges;
use Dompdf\Dompdf;
use App\Notify;
use App\Employee;
use App\Payment;
use App\AdminMaster;
use App\Deviceusers;
use App\User;
use App\ApiTrack;
use App\Apischedule;
use Mail;
use DB;
use DateTime;
use Session;


class FreezemembershipController extends Controller
{
    public function freezemembership(){

        $member_data = Member::where('status', 1)->get()->all();
        $admin = Employee::where('role', 'admin')->get()->all();
        $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
        $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

        $sgst = (int)$sgst;
        $cgst = (int)$cgst;
        $tax =  $sgst + $cgst;


        return view('admin.freezemembership.freezemembership')->with(compact('member_data', 'admin', 'tax'));

    }



    public function selectactivemember(){

        $userid = $_REQUEST['userid'];

        $member_data = Member::leftjoin('memberpackages', 'member.userid', 'memberpackages.userid')
                               ->leftjoin('schemes', 'memberpackages.schemeid', 'schemes.schemeid')
                               ->where('member.status', 1)->where('memberpackages.status', 1)->where('member.userid', $userid)->get()->all();

        if(!empty($member_data)){
            $member_package = '<table class="table">';
            $member_package .= '<tr>';
            $member_package .= '<th>Scheme Name</td>';
            $member_package .= '<th>Join Date</td>';
            $member_package .= '<th>Expire Date</td>';
            $member_package .= '</tr>';
            foreach($member_data as $member){
            $member_package .= '<tr>';
            $member_package .= '<td>'.ucfirst($member->schemename).'</td>';
            $member_package .= '<td>'.date('d-m-Y', strtotime($member->joindate)).'</td>';
            $member_package .= '<td>'.date('d-m-Y', strtotime($member->expiredate)).'</td>';
            $member_package .= '</tr>';
            }
            $member_package .= '</table>';
        }else{  
            $member_package = '<option value="">--No Package Available--</option>';
        }

        return $member_package;

    }

    public function checkfreezedate(){

        $userid = $_REQUEST['userid'];
        $startdate = $_REQUEST['startdate'];
        $result = [];
        $found = '';

        $startdate_compare = date('Y-m-d', strtotime($startdate));


        $memberpackages = Memberpackages::where('userid', $userid)->where('status', 1)->get()->all();
        $memberpackages_maxdate = Memberpackages::where('userid', $userid)->where('status', 1)->max('expiredate');

        if(!empty($memberpackages)){
            /*foreach($memberpackages as $package){
                if($startdate_compare >= $package->expiredate){
                    $found = 1;
                    array_push($result, $found); // date found
                }
            }*/
            if($startdate >= $memberpackages_maxdate){
                $found = 1;
                array_push($result, $found); // date found
            }
        }else{
            return 203; // no package available
        }


        if(!empty($result)){
            return 201;
        }else{
            return 202;
        }

    }

    public function freezemembershippayment(Request $request){
      
        $userid = $request->userid;
        $noofdays = $request->noofdays;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $amount_paid = $request->amount_paid;
        $final_amount = $request->finalamount;
        $admin_id = $request->admin;
        $tax_radio = $request->tax_radio;
        $tax = $request->tax;
        $total_amount = 0;
        $packages = [];
        $schemes = '';
        $admin_mobileno = '';
        $freezedate='';

        $admin_data = Employee::where('employeeid', $admin_id)->first();
        if(!empty($admin_data)){
            $admin_mobileno = $admin_data->mobileno;
        }
        DB::table('otpverify')->where('mobileno', $admin_mobileno)->update(['isexpired' => 1]);
        // if refersh page the redirect freezemembership start
        $orderview = session()->get('freezemembership');

        if(session()->get('freezemembership') != null){
            session()->forget('freezemembership');
        } else {
            return redirect()->route('freezemembership');
        }



        /********************************************************/
         $pay=Payment::where('userid',$userid)->get()->last();

      if($pay){
        if($pay->remainingamount){
          $memberid_redirect = $pay->memberid;
          return redirect('memberProfile/'.$memberid_redirect)->with('message','Please Complete Your Payment of remaining package.');
        }
      }
      // if refersh page the redirect freezemembership end

        $startdate_compare = date('Y-m-d', strtotime($startdate));

        if(!is_numeric($userid) || !is_numeric($amount_paid)){
            return back()->with('message', 'Please enter valid detail');
        }

        $memberpackages = MemberPackages::where('userid', $userid)->where('status', 1)->get()->all();

        if(!empty($memberpackages)){
            /*foreach($memberpackages as $package){
                array_push($packages, $package->memberpackagesid); 
                if($startdate_compare >= $package->expiredate){
                    $found = 1;
                    array_push($result, $found); // date found
                }
            }*/
        }else{
            return redirect()->route('freezemembership'); // no package available
        }

        if($tax_radio == 'withtax'){

            $tax_calculation = (int)round($amount_paid/100) * (int)round($tax);
            $total_amount = $amount_paid + (int)round($tax_calculation);
            $tax = $tax;


        }else{
            $tax_calculation = 0;
            $total_amount = $final_amount;
            $tax = 0;
        }

        if(!empty($package)){

            $schemes = implode(', ', $packages);

        }else{
            $schemes = '';
        }

        if(!empty($result)){
            return back()->with('message', 'Please enter valid detail');
        }

        $expiredate = date('Y-m-d', strtotime($startdate.' +'.$noofdays.'days'));

        $member_data = Member::where('userid', $userid)->first();
        if(!empty($member_data)){
            $memberid = $member_data->memberid;
            $fullname = ucfirst($member_data->firstname).' '.ucfirst($member_data->lastname);
        }

        DB::beginTransaction();
        try{

        $transaction_no = hexdec(uniqid());

        $transaction = new TransactionModel();
        $transaction->transactionno = $transaction_no; 
        $transaction->paymenttypeid = 3; 
        $transaction->transactionuserid = $userid; 
        $transaction->transactionmemberid = $memberid; 
        $transaction->transactionamount = $total_amount; 
        $transaction->transactionactualamount = $total_amount; 
        $transaction->transactionbaseamount = $amount_paid; 
        $transaction->transactionstatus = 0;
        $transaction->transactiontaxamount = $tax_calculation;
        $transaction->transactiondate = date('Y-m-d');
        $transaction->transactiontax = $tax;
        $transaction->transactiontype = 'Fully';
        $transaction->save();

        $last_transaction_id = $transaction->transactionid;

        $freezemembership = new FreezeMembershipModal();
        $freezemembership->freezememberhipuserid = $userid;
        $freezemembership->freezememberhipstartdate = date('Y-m-d', strtotime($startdate));
        $freezemembership->freezememberhipenddate = date('Y-m-d', strtotime($enddate));
        $freezemembership->freezeamount = $total_amount;
        $freezemembership->freezemembershiptid = $last_transaction_id;
        $freezemembership->freezemembershippackageid = $schemes;
        $freezemembership->actionby = session()->get('admin_id');
        $freezemembership->save();

        $last_freezemembership_id = $freezemembership->freezemembershipid;

        $miscellaneouscharges =  new MiscellaneousCharges();
        $miscellaneouscharges->miscellaneouschargesuserid = $userid;
        $miscellaneouscharges->miscellaneouschargestid = $last_transaction_id;
        $miscellaneouscharges->miscellaneouschargesrefid = $last_freezemembership_id;
        $miscellaneouscharges->miscellaneouschargespaymenttype = 'f';
        $miscellaneouscharges->miscellaneouschargesstatus = 0;
        $miscellaneouscharges->miscellaneouschargesactionby = session()->get('admin_id');
        $miscellaneouscharges->save();

        $last_miscellaneouscharges_id = $miscellaneouscharges->miscellaneouschargesid;

        if($amount_paid == 0){

            $rr_no_insert = 0;
            $rr_no = Payment::where('status', 1)->max('receiptno');
            if(!empty($rr_no) || $rr_no != null ){
              $rr_no_insert = $rr_no + 1;

            } else {

              $rr_no_insert = 1;
            }

            $payment =  Payment::create([
              'memberid' =>  $memberid,      
              'userid' => $userid,
              'paymentTransactionId' => $last_transaction_id,
              'actualamount' =>  0,
              'amount' =>  0,
              'amountwithtax' =>  0,
              'tax' => 0,
              'taxamount' => 0,
              'discount' => 0,
              'discountamount' => 0,
              'date' => date('Y-m-d H:i:s'),
              'paymentdate' => now(),
              'mode' => 'no mode',
              'schemeid' => 0,
              'receiptno' =>  $rr_no_insert,
              'invoiceno' =>  $last_miscellaneouscharges_id,
              'invoicetype' =>  'o',
              'type' => 'Debit',
              'remarks' =>  '',
              'remainingamount'=> 0,
              'takenby' => session()->get('admin_id'),
              'duedate'=>null   
            ]);

            $transaction_update = TransactionModel::where('transactionid', $last_transaction_id)->first();
            if(!empty($transaction_update)){
                $transaction_update->transactionStatus = 1;
                $transaction_update->save();
            }

            $freezemembership_update = FreezeMembershipModal::where('freezemembershipid', $last_freezemembership_id)->first();
            if(!empty($freezemembership_update)){
                $freezemembership_update->freezemembershipstatus = 1;
                $freezedate = $freezemembership_update->freezememberhipstartdate;
                $freezemembership_update->save();
            }

            $miscellaneouscharges_update = MiscellaneousCharges::where('miscellaneouschargesid', $last_miscellaneouscharges_id)->first();
            if(!empty($miscellaneouscharges_update)){
                $invoiceno = $last_miscellaneouscharges_id;
                $miscellaneouschargesid = $last_miscellaneouscharges_id;
                $miscellaneouscharges_update->miscellaneouschargesstatus = 1;
                $miscellaneouscharges_update->save();
            }

            $member_data = Member::where('userid', $userid)->get()->first();
            if(!empty($member_data)){
                $fullname = ucfirst($member_data->firstname).' '.ucfirst($member_data->lastname);
                $fname = ucfirst($member_data->firstname);
                $lname = ucfirst($member_data->lastname);
                $mobileno = $member_data->mobileno;
                $member_data->status = 2;
                $member_data->save();
            }

            /****************for add freeze date diff into current package duration******************** */
            
            $freezeenddate = new DateTime($enddate);
            $freezedate_diff = new DateTime($freezedate);
    
            if($freezedate_diff > $freezeenddate){
                $diff = $freezedate_diff->diff($freezeenddate)->format("%a");
            }else{
                $diff = $freezeenddate->diff($freezedate_diff)->format("%a");
            }
          
            $memberpackages_data = Memberpackages::where('userid', $userid)->where('status', 1)->get()->all();
    
            if(!empty($memberpackages_data)){
                foreach($memberpackages_data as $package){
                    $expiry_date = $package->expiredate;
                    $new_exp_date = date('Y-m-d', strtotime($expiry_date.' +'.$diff.' days'));
                    $package->expiredate = $new_exp_date;
                    $package->save();
                }
            }
            /************************************************** */
            $loginuser = session()->get('username');
             $actionbyid=Session::get('employeeid');

            $notify=Notify::create([

                'userid'=> $userid,
                'details'=> $loginuser.' freeze membership from '. date('d-m-Y', strtotime($freezedate)). ' to ' .date('d-m-Y', strtotime($enddate)) ,
                 'actionby' =>$actionbyid,

            ]);

            

            $msg=   DB::table('messages')->where('messagesid','8')->get()->first();

            $msg =$msg->message;
            $msg = str_replace("[FirstName]",$fname,$msg);
            $msg = str_replace("[LastName]",$lname,$msg);
            $msg= str_replace("[From]",date('d-m-Y', strtotime($freezedate)),$msg);
            $msg= str_replace("100",0,$msg);
            $msg= str_replace("[InvoiceID]",$invoiceno,$msg); 



            $msg2 = $msg;
            $msg = urlencode($msg);

            $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

            if ($smssetting) {

             $u = $smssetting->url;
             $url= str_replace('$mobileno', $mobileno, $u);
             $url=str_replace('$msg', $msg, $url);  
             $otpsend = Curl::to($url)->get();

             $action = new Notificationmsgdetails();
             $action->user_id = session()->get('admin_id');
             $action->mobileno = $mobileno;
             $action->smsmsg = $msg2;
             $action->smsrequestid = $otpsend;
             $action->subject = 'Freeze Membership';
             $action->save();

            }

           $transactionamount = 0;
           $transactiontype = 'Fully';

           DB::commit();
           $success = true;
           return view('admin.freezemembership.freezemembershipsummary')->with(compact('fullname', 'miscellaneouschargesid', 'transactionamount', 'freezedate', 'transactiontype', 'userid', 'invoiceno','enddate'));


        }

        $PaymentTypes = PaymentType::get()->all();
        $success = true;
         DB::commit();

        return view('admin.freezemembership.freezemembershippayment')->with(compact('PaymentTypes', 'userid', 'noofdays', 'startdate', 'amount_paid', 'expiredate', 'amount_paid', 'tax', 'total_amount','last_freezemembership_id', 'last_transaction_id', 'fullname', 'last_miscellaneouscharges_id'));

    }catch(\Exception $e){

            $success = false;
            DB::rollback();
    }

    if($success == false){
        return redirect('dashboard');
    }

}

    public function freezemembershippaymentstore(Request $request){
        //dd($request->toArray());
        $transactionid = $request->transactionId;
        $userid = $request->userid;
        $freezemembershipid = $request->freezemembershipid;
        $miscellaneouschargesid = $request->miscellaneouschargesid;
        $mode_payment= $request->Mode;
        $remark= $request->Remark;
        $amount= $request->Amount;
        $ActualAmountTotal = 0;
        $memberid = 0;
        $invoiceno = 0;
        $fullname = '';

        $check_transaction = TransactionModel::where('transactionid', $transactionid)->first();
        if(!empty($check_transaction)){
            if($check_transaction->transactionstatus == 1){
                return redirect()->route('freezemembership');
            }
        }
        
        DB::beginTransaction();
        try{
            $transaction_data = TransactionModel::where('transactionid', $transactionid)->first();
            if(!empty($transaction_data)){
              $transamount = $transaction_data->transactionamount;
              $transactionamount = $transaction_data->transactionamount;
              $tax = $transaction_data->transactiontax;
              $transactiontype = $transaction_data->transactiontype;
              $baseamount = $transaction_data->transactionbaseamount;
              $taxamount = $transaction_data->transactiontaxamount;
              $transactiontype = $transaction_data->transactiontype;
                
            }


            $rr_no_insert = 0;
            $rr_no = Payment::where('status', 1)->max('receiptno');
            if(!empty($rr_no) || $rr_no != null ){
              $rr_no_insert = $rr_no + 1;

            } else {

              $rr_no_insert = 1;
            }

            $member_data = Member::where('userid', $userid)->get()->first();
            if(!empty($member_data)){
                $memberid = $member_data->memberid;
                $fullname = ucfirst($member_data->firstname).' '.ucfirst($member_data->lastname);
                $fname = ucfirst($member_data->firstname);
                $lname = ucfirst($member_data->lastname);
            }


            for ($n=0; $n < count($mode_payment) ; $n++) { 

              $ActualAmountTotal += $amount[$n];

              $payment =  Payment::create([
                  'memberid' =>  $memberid,      
                  'userid' => $userid,
                  'paymentTransactionId' => $transactionid,
                  'actualamount' =>  (int)round($transactionamount),
                  'amount' =>  $amount[$n],
                  'amountwithtax' =>  (int)round($transactionamount),
                  'tax' => (int)round($tax),
                  'taxamount' => (int)round($taxamount),
                  'discount' => 0,
                  'discountamount' => 0,
                  'date' => date('Y-m-d H:i:s'),
                  'paymentdate' => now(),
                  'mode' => PaymentType::find($mode_payment[$n])->paymenttype,
                  'schemeid' =>0,
                  'receiptno' =>  $rr_no_insert,
                  'invoiceno' =>  $miscellaneouschargesid,
                  'invoicetype' =>  'o',
                  'type' => 'Debit',
                  'remarks' =>  $remark[$n],
                  'remainingamount'=> 0,
                  'takenby' => session()->get('admin_id'),
                  'duedate'=>null   
              ]);

            }//end of foreach

            $payment =  Payment::create([
                  'memberid' =>  $memberid,      
                  'userid' => $userid,
                  'paymentTransactionId' => $transactionid,
                  'actualamount' =>  (int)round($transactionamount),
                  'amount' =>  (int)round($ActualAmountTotal),
                  'amountwithtax' =>  (int)round($transactionamount),
                  'tax' => (int)round($tax),
                  'taxamount' => (int)round($taxamount),
                  'discount' => 0,
                  'discountamount' => 0,
                  'date' => date('Y-m-d H:i:s'),
                  'paymentdate' => now(),
                  'mode' => 'total',
                  'schemeid' => 0,
                  'receiptno' =>  $rr_no_insert,
                  'invoiceno' =>  $miscellaneouschargesid,
                  'invoicetype' =>  'o',
                  'type' => 'Debit',
                  'remarks' =>  '',
                  'remainingamount'=> 0,
                  'takenby' => session()->get('admin_id'),
                  'duedate'=>null   
            ]);

            $transaction_update = TransactionModel::where('transactionid', $transactionid)->first();
            if(!empty($transaction_update)){
                $transaction_update->transactionStatus = 1;
                $transaction_update->save();
            }

            $freezemembership_update = FreezeMembershipModal::where('freezemembershipid', $freezemembershipid)->first();
            if(!empty($freezemembership_update)){
                $freezemembership_update->freezemembershipstatus = 1;
                $freezedate = $freezemembership_update->freezememberhipstartdate;
                $freezemembership_update->save();
            }

            $miscellaneouscharges_update = MiscellaneousCharges::where('miscellaneouschargesid', $miscellaneouschargesid)->first();
            if(!empty($miscellaneouscharges_update)){
                $invoiceno = $miscellaneouschargesid;
                $miscellaneouscharges_update->miscellaneouschargesstatus = 1;
                $miscellaneouscharges_update->save();
            }

            $member_data = Member::where('userid', $userid)->get()->first();
            if(!empty($member_data)){
                $mobileno = $member_data->mobileno;
                $member_data->status = 2;
                $member_data->save();
            }
            
            /****************for add freeze date diff into current package duration******************** */
            if($freezemembership_update->freezememberhipenddate){
                $enddate=$freezemembership_update->freezememberhipenddate;
                $freezeenddate = new DateTime($enddate);
                $freezedate_diff = new DateTime($freezedate);
        
                if($freezedate_diff > $freezeenddate){
                    $diff = $freezedate_diff->diff($freezeenddate)->format("%a");
                }else{
                    $diff = $freezeenddate->diff($freezedate_diff)->format("%a");
                }
            
                $memberpackages_data = Memberpackages::where('userid', $userid)->where('status', 1)->get()->all();
        
                if(!empty($memberpackages_data)){
                    foreach($memberpackages_data as $package){
                        $expiry_date = $package->expiredate;
                        $new_exp_date = date('Y-m-d', strtotime($expiry_date.'+'.$diff.' days'));
                        $package->expiredate = $new_exp_date;
                        $package->save();
                    }
                }
            }
          
            /************************************************** */
            $loginuser = session()->get('username');
              $actionbyid=Session::get('employeeid');

              $notify=Notify::create([

                'userid'=> $userid,
                'details'=> $loginuser.' freeze membership from '. date('d-m-Y', strtotime($freezedate)). ' to ' .date('d-m-Y', strtotime($enddate)) ,
                 'actionby' =>$actionbyid,

            ]);


            DB::commit();
            $success = true;

            $msg=   DB::table('messages')->where('messagesid','8')->get()->first();

            $msg =$msg->message;
            $msg = str_replace("[FirstName]",$fname,$msg);
            $msg = str_replace("[LastName]",$lname,$msg);
            $msg= str_replace("[From]",date('d-m-Y', strtotime($freezedate)),$msg);
            $msg= str_replace("100",$transactionamount,$msg);
            $msg= str_replace("[InvoiceID]",$invoiceno,$msg); 

          

          $msg2 = $msg;
          $msg = urlencode($msg);

          $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

          if ($smssetting) {

           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);  
           $otpsend = Curl::to($url)->get();

           $action = new Notificationmsgdetails();
           $action->user_id = session()->get('admin_id');
           $action->mobileno = $mobileno;
           $action->smsmsg = $msg2;
           $action->smsrequestid = $otpsend;
           $action->subject = 'Freeze Membership';
           $action->save();

       }

            return view('admin.freezemembership.freezemembershipsummary')->with(compact('fullname', 'miscellaneouschargesid', 'transactionamount', 'freezedate', 'transactiontype', 'userid', 'invoiceno','enddate'));

        }catch(\Exception $e){

            $success = false;
            DB::rollback();

        }


        if($success == false){
            return redirect('dashboard');
        }

    }


    public function freezemembershipreceipt($id){

        $pdf = new \App\FreezeMembershipReceipt;
        $pdf->generate($id);


    }

    public function viewfreezemembeship(Request $request)
    {

    $username=$request->get('username');
 
/*for pass to bladefile */
    $query=[];
   
    $query['username']=$username;


    $freezememberships = FreezeMembershipModal::leftjoin('member', 'freezemembership.freezememberhipuserid', 'member.userid')->where('freezemembershipstatus', 1)->orderBy('freezemembershipid','desc');
    
        $freezemembership_data = FreezeMembershipModal::leftjoin('member', 'freezemembership.freezememberhipuserid', 'member.userid')->orderBy('freezemembershipid','desc')->get()->where('freezemembershipstatus', 1)->all();

        
        $users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
            
            $users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
            $merged = $users1->merge($users2);
            $users = $merged->all();    
    
    if ($request->isMethod('post'))
    {     
     
        // dd($username);
        if($username != "")
        {
          $freezememberships->where('member.userid',$username);
        }
        // dd($paymentdata->paginate(5));
      
           $freezemembership_data=$freezememberships->get()->all();

        return view('admin.freezemembership.freezemembershipview')->with(compact('freezemembership_data','query','users','freezememberships'));

     }

        return view('admin.freezemembership.freezemembershipview')->with(compact('freezemembership_data','query','users','freezememberships'));

     
  }


    

    /*public function freezemembershipdevice(){

        $userid = $_REQUEST['userid'];
        $fullname = '';

        $deviceip = config('constants.localip');

        //$device_exdate = date('d-m-Y', strtotime($max_exp));

        $member_data = Member::where('userid', $userid)->first();
        if(!empty($member_data)){
            $fullname_member = $member_data->firstname.' '.$member_data->lastname;
            $fullname = str_replace(' ', '%20', $fullname_member);
        }

        $freezemembership = FreezeMembershipModal::where('freezememberhipuserid', $userid)->where('freezemembershipstatus', 1)->first();
        if(!empty($freezemembership)){
            $freezedate = $freezemembership->freezememberhipstartdate;
        }

        $freezedate_device = date('d-m-Y', strtotime($freezedate));

        $device_data = Deviceusers::where('userid', $userid)->first();
        if(!empty($device_data)){
            $device_data->expirydate = date('Y-m-d', strtotime($freezedate));
            $device_data->isactive = 1;
            $device_data->save();
        }

        $user_data = User::where('userid', $userid)->first();
        if(!empty($user_data)){
            $user_data->userexpirydate =  date('Y-m-d', strtotime($freezedate));
            $user_data->useractive =  1;
            $user_data->save();
        }

        $deviceuser_exist = DB::connection('mysql2')->table('StaffBios')->where('StaffBiometricCode', $userid)->first();
        if(!empty($deviceuser_exist)){
            if(date('Y-m-d', strtotime($freezedate)) != date('Y-m-d')){
             $freeze_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$freezedate_device.'';
             $start_date_apischedule = date('Y-m-d', strtotime($freezedate));

             $apischedule = new Apischedule();
             $apischedule->apiset = $freeze_desc;
             $apischedule->startdate = $start_date_apischedule;
             $apischedule->status = 0;
             $apischedule->save();

             return 203;

            }else{

            $freeze_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$freezedate_device.'';
            $regsetexpiry = Curl::to('http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$freezedate_device.'')->get();
            $success_msg = json_decode($regsetexpiry);
            //$success_msg = 'Upload Command Send Successfully.';
            if($success_msg != null){
                //if($success_msg == 'Upload Command Send Successfully.'){
                if($success_msg->Message == 'Upload Command Send Successfully.' || $success_msg->Message == 'Command Send Successfully.'){

                    $memberpackages_data = Memberpackages::where('userid', $userid)->where('status', 1)->get()->all();

                    $member=Member::where('userid',$userid)->first();


                    $device_data = Deviceusers::where('userid', $userid)->first();
                    if(!empty($device_data)){
                        $device_data->expirydate = date('Y-m-d', strtotime($freezedate));
                        $device_data->isactive = 1;
                        $device_data->save();
                    }

                    $user_data = User::where('userid', $userid)->first();
                    if(!empty($user_data)){
                        $user_data->userexpirydate =  date('Y-m-d', strtotime($freezedate));
                        $user_data->useractive =  1;
                        $user_data->save();
                    }

                    $apitrack = new ApiTrack();
                    $apitrack->userid = $userid;
                    $apitrack->api = $freeze_desc;
                    $apitrack->apitype = 'member freeze';
                    //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                    $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                    $apitrack->apistatus = 'Success';
                    $apitrack->save();

                    return 203;

                } else {

                    $apitrack = new ApiTrack();
                    $apitrack->userid = $userid;
                    $apitrack->api = $freeze_desc;
                    $apitrack->apitype = 'member not freeze';
                    //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                    $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                    $apitrack->apistatus = 'Failure';
                    $apitrack->save();

                    return 202;

                }//end of 

            //else of $success_msg != null
            } else {

                $apitrack = new ApiTrack();
                $apitrack->userid = $userid;
                $apitrack->api = $freeze_desc;
                $apitrack->apitype = 'member not freeze';
                $apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                //$apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                $apitrack->apistatus = 'Failure';
                $apitrack->save();

                return 202;

            }//end of $success_msg != null
        }

        }else{

            $memberupload_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/UploadUsersInBiometric?StaffName='.$fullname.'&StaffBiometricCode='.$userid.'&IsAdmin=false&SerialNumber=DC67C417C3749B37';
            $reguseradd =  Curl::to('http://'.$deviceip.':8080/iclock/api/WebAPI/UploadUsersInBiometric?StaffName='.$fullname.'&StaffBiometricCode='.$userid.'&IsAdmin=false&SerialNumber=DC67C417C3749B37')->get();
            $success_msg = json_decode($reguseradd);
            //$success_msg = 'Upload Command Send Successfully.';
            if($success_msg != null){
                if($success_msg->Message == 'Upload Command Send Successfully.' || $success_msg->Message == 'Command Send Successfully.'){
                //if($success_msg == 'Upload Command Send Successfully.'){

                    $apitrack = new ApiTrack();
                    $apitrack->userid = $userid;
                    $apitrack->api = $memberupload_desc;
                    $apitrack->apitype = 'member upload';
                    //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                    $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                    $apitrack->apistatus = 'Success';
                    $apitrack->save();

                    if(date('Y-m-d', strtotime($freezedate)) != date('Y-m-d')){
                       $freeze_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$freezedate_device.'';
                        $start_date_apischedule = date('Y-m-d', strtotime($freezedate));

                        $apischedule = new Apischedule();
                        $apischedule->apiset = $freeze_desc;
                        $apischedule->startdate = $start_date_apischedule;
                        $apischedule->status = 0;
                        $apischedule->save();

                        return 203;

                    }else{

                    $freeze_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$freezedate_device.'';
                    $regsetexpiry = Curl::to('http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$freezedate_device.'')->get();
                    $success_msg = json_decode($regsetexpiry);
                    //$success_msg = 'Upload Command Send Successfully.';
                    if($success_msg != null){
                    //if($success_msg == 'Upload Command Send Successfully.'){
                    if($success_msg->Message == 'Upload Command Send Successfully.' || $success_msg->Message == 'Command Send Successfully.'){

                        $memberpackages_data = Memberpackages::where('userid', $userid)->where('status', 1)->get()->all();


                        $device_data = Deviceusers::where('userid', $userid)->first();
                        if(!empty($device_data)){
                            $device_data->expirydate = date('Y-m-d', strtotime($freezedate));
                            $device_data->isactive = 1;
                            $device_data->save();
                        }

                        $user_data = User::where('userid', $userid)->first();
                        if(!empty($user_data)){
                            $user_data->userexpirydate =  date('Y-m-d', strtotime($freezedate));
                            $user_data->useractive =  1;
                            $user_data->save();
                        }

                        $apitrack = new ApiTrack();
                        $apitrack->userid = $userid;
                        $apitrack->api = $freeze_desc;
                        $apitrack->apitype = 'member freeze';
                        //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                        $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                        $apitrack->apistatus = 'Success';
                        $apitrack->save();

                        return 203;

                    } else {

                        $apitrack = new ApiTrack();
                        $apitrack->userid = $userid;
                        $apitrack->api = $freeze_desc;
                        $apitrack->apitype = 'member not freeze';
                        //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                        $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                        $apitrack->apistatus = 'Failure';
                        $apitrack->save();

                        return 202;

                    }//end of 
                }

            //else of $success_msg != null
            } else {

                $apitrack = new ApiTrack();
                $apitrack->userid = $userid;
                $apitrack->api = $freeze_desc;
                $apitrack->apitype = 'member not freeze';
                //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                $apitrack->apistatus = 'Failure';
                $apitrack->save();

                return 202;

            }//end of $success_msg != null


                    //else of $success_msg->Message
                } else {

                    $apitrack = new ApiTrack();
                    $apitrack->userid = $userid;
                    $apitrack->api = $memberupload_desc;
                    $apitrack->apitype = 'member not upload';
                    $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
                    //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                    $apitrack->apistatus = 'Failure';
                    $apitrack->save();

                    return 202;
                    

                }//end of 


            //end of $success_msg != null
            } else {

                $apitrack = new ApiTrack();
                $apitrack->userid = $userid;
                $apitrack->api = $memberupload_desc;
                $apitrack->apitype = 'member not upload';
                $apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
                $apitrack->apistatus = 'Failure';
                $apitrack->save();

                return 202;

            }//end of $success_msg != null

        }



    }*/

    public function freezemembershipdevicesetexpiry($request){
        app()->call('App\Http\Controllers\DeviceController@extendexpiry');
        if (!empty($request->messagestatus == 'Success')){
         $request->request->add(['freezemembershipdevicesetexpirystatus' => $request->messagestatus]);
        } 
    }

    public function freezemembershipdevice(Request $request){

        $userid = $_REQUEST['userid'];
        $fullname = '';

        $member_data = Member::where('userid', $userid)->first();
        if(!empty($member_data)){
            $fullname_member = $member_data->firstname.' '.$member_data->lastname;
            $mobileno = $member_data->mobileno;
        }

        $freezemembership = FreezeMembershipModal::where('freezememberhipuserid', $userid)->where('freezemembershipstatus', 1)->first();
        if(!empty($freezemembership)){
            $freezedate = $freezemembership->freezememberhipstartdate;
        }

        $deviceuser = Deviceusers::where('userid',$userid)->first();

        $freezemembershipdevice = ['freezemembershipuserid' => $userid,'freezemembershipname'=>$fullname_member,'freezemembershipdate'=>$freezedate,'freezemembershipmobileno'=> $mobileno,'freezemembershipfreezedate' => $freezedate];

        $request->request->add(['setuserforfreezemembershipdevice' => $freezemembershipdevice]);

        if (!empty($deviceuser)) {
            $this->freezemembershipdevicesetexpiry($request);
            if ($request->freezemembershipdevicesetexpirystatus == 'Success') {
                echo '0';
            }
          }else{
            $set = app()->call('App\Http\Controllers\DeviceController@setuserfromsummary');
            if ($request->freezemembershipapistatus == 'Success') {
             $this->freezemembershipdevicesetexpiry($request);
              if ($request->freezemembershipdevicesetexpirystatus == 'Success') {
               echo '0';
            }
           }else{
               echo '101';
            } 
        }

        // $deviceip = config('constants.localip');

        //$device_exdate = date('d-m-Y', strtotime($max_exp));

        // $freezedate_device = date('d-m-Y', strtotime($freezedate));

        // $device_data = Deviceusers::where('userid', $userid)->first();
        // if(!empty($device_data)){
        //     $device_data->expirydate = date('Y-m-d', strtotime($freezedate));
        //     $device_data->isactive = 1;
        //     $device_data->save();
        // }

        // $user_data = User::where('userid', $userid)->first();
        // if(!empty($user_data)){
        //     $user_data->userexpirydate =  date('Y-m-d', strtotime($freezedate));
        //     $user_data->useractive =  1;
        //     $user_data->save();
        // }

    }

    public function unfreezemembership(Request $request){

        $id = $_REQUEST['freezeid'];

        $freezemembership = FreezeMembershipModal::where('freezemembershipid', $id)->first();
        $userid = 0;
        $fullname = '';

        if(!empty($freezemembership)){
            $userid = $freezemembership->freezememberhipuserid;
            $freezedate = $freezemembership->freezememberhipstartdate;
            $freezemembership->freezemembershipstatus = 0;
            $freezemembership->freezemembershipunfreezedate = date('Y-m-d');
            $freezemembership->save();
        }

        $member_data = Member::where('userid', $userid)->first();
        if(!empty($member_data)){
            $fullname_member = $member_data->firstname.' '.$member_data->lastname;
            $fullname = str_replace(' ', '%20', $fullname_member);
        }
        
        $today_date = date('Y-m-d');
        $todaydate_diff = new DateTime($today_date);
        $freezedate_diff = new DateTime($freezedate);

        if($freezedate_diff > $todaydate_diff){
            $diff = $freezedate_diff->diff($todaydate_diff)->format("%a");
        }else{
            $diff = $todaydate_diff->diff($freezedate_diff)->format("%a");
        }

        $memberpackages_data = Memberpackages::where('userid', $userid)->where('status', 1)->get()->all();

        // if(!empty($memberpackages_data)){
        //     foreach($memberpackages_data as $package){
        //         $expiry_date = $package->expiredate;
        //         $new_exp_date = date('Y-m-d', strtotime($expiry_date.' +'.$diff.' days'));
        //         $package->expiredate = $new_exp_date;
        //         $package->save();
        //     }
        // }

        $max_exp = Memberpackages::where('userid', $userid)->where('status', 1)->max('expiredate');
        $deviceuser = Deviceusers::where('userid',$userid)->first();
        $unfreezemembershipdevice = ['unfreezemembershipuserid' => $userid,'unfreezemembershippdate'=>$max_exp];
        $request->request->add(['unfreezemembershipdevice' => $unfreezemembershipdevice]);

        if (!empty($deviceuser)) {
           $this->freezemembershipdevicesetexpiry($request);
            if ($request->freezemembershipdevicesetexpirystatus == 'Success') {
               echo '0';
            }
        }else{
            echo '101';
        }

        $device_exdate = date('d-m-Y', strtotime($max_exp));

        $member=Member::where('userid',$userid)->first();

        if(!empty($member)){ 
            $member->status = 1;
            $member->save();
        }

        // $device_data = Deviceusers::where('userid', $userid)->first();
        // if(!empty($device_data)){
        //     $device_data->expirydate = date('Y-m-d', strtotime($max_exp));
        //     $device_data->isactive = 1;
        //     $device_data->save();
        // }

        // $user_data = User::where('userid', $userid)->first();
        // if(!empty($user_data)){
        //     $user_data->userexpirydate =  date('Y-m-d', strtotime($max_exp));
        //     $user_data->useractive =  1;
        //     $user_data->save();
        // }


        $loginuser = session()->get('username');
        $actionbyid=Session::get('employeeid');
        Notify::create([
            'userid' => $userid,
            'details' => 'unfreeze by '.$loginuser,
             'actionby' =>$actionbyid,
                    ]);

        // $deviceip = config('constants.localip');

        // $deviceuser_exist = DB::connection('mysql2')->table('StaffBios')->where('StaffBiometricCode', $userid)->first();
        // if(!empty($deviceuser_exist)){
        //     $unfreeze_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$device_exdate.'';
        //     $regsetexpiry = Curl::to('http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$device_exdate.'')->get();
        //     $success_msg = json_decode($regsetexpiry);
        //     //$success_msg = 'Upload Command Send Successfully.';
        //     if($success_msg != null){
        //         //if($success_msg == 'Upload Command Send Successfully.'){
        //         if($success_msg->Message == 'Upload Command Send Successfully.' || $success_msg->Message == 'Command Send Successfully.'){

                    

                    

        //             $apitrack = new ApiTrack();
        //             $apitrack->userid = $userid;
        //             $apitrack->api = $unfreeze_desc;
        //             $apitrack->apitype = 'member unfreeze';
        //             //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //             $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //             $apitrack->apistatus = 'Success';
        //             $apitrack->save();

        //             return 203;

        //         } else {

        //             $apitrack = new ApiTrack();
        //             $apitrack->userid = $userid;
        //             $apitrack->api = $unfreeze_desc;
        //             $apitrack->apitype = 'member not unfreeze';
        //             //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //             $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //             $apitrack->apistatus = 'Failure';
        //             $apitrack->save();

        //             return 202;

        //         }//end of 

        //     //else of $success_msg != null
        //     } else {

        //         $apitrack = new ApiTrack();
        //         $apitrack->userid = $userid;
        //         $apitrack->api = $unfreeze_desc;
        //         $apitrack->apitype = 'member not unfreeze';
        //         //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //         $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //         $apitrack->apistatus = 'Failure';
        //         $apitrack->save();

        //         return 202;

        //     }//end of $success_msg != null

        // }else{

        //     $memberupload_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/UploadUsersInBiometric?StaffName='.$fullname.'&StaffBiometricCode='.$userid.'&IsAdmin=false&SerialNumber=DC67C417C3749B37';
        //     $reguseradd =  Curl::to('http://'.$deviceip.':8080/iclock/api/WebAPI/UploadUsersInBiometric?StaffName='.$fullname.'&StaffBiometricCode='.$userid.'&IsAdmin=false&SerialNumber=DC67C417C3749B37')->get();
        //     $success_msg = json_decode($reguseradd);
        //     //$success_msg = 'Upload Command Send Successfully.';
        //     if($success_msg != null){
        //         if($success_msg->Message == 'Upload Command Send Successfully.' || $success_msg->Message == 'Command Send Successfully.'){
        //         //if($success_msg == 'Upload Command Send Successfully.'){

        //             $apitrack = new ApiTrack();
        //             $apitrack->userid = $userid;
        //             $apitrack->api = $memberupload_desc;
        //             $apitrack->apitype = 'member upload';
        //             //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //             $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //             $apitrack->apistatus = 'Success';
        //             $apitrack->save();

                    

        //             $unfreeze_desc = 'http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$device_exdate.'';
        //             $regsetexpiry = Curl::to('http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$userid.'&ExpirationDate='.$device_exdate.'')->get();
        //             $success_msg = json_decode($regsetexpiry);
        //             //$success_msg = 'Upload Command Send Successfully.';
        //             if($success_msg != null){
        //             //if($success_msg == 'Upload Command Send Successfully.'){
        //             if($success_msg->Message == 'Upload Command Send Successfully.' || $success_msg->Message == 'Command Send Successfully.'){

        //                /* $memberpackages_data = Memberpackages::where('userid', $userid)->where('status', 1)->get()->all();

        //                 if(!empty($memberpackages_data)){
        //                     foreach($memberpackages_data as $package){
        //                         $expiry_date = $package->expiredate;
        //                         $new_exp_date = date('Y-m-d', strtotime($expiry_date.' +'.$diff.' days'));
        //                         $package->expiredate = $new_exp_date;
        //                         $package->save();
        //                     }
        //                 }*/

        //                 $apitrack = new ApiTrack();
        //                 $apitrack->userid = $userid;
        //                 $apitrack->api = $unfreeze_desc;
        //                 $apitrack->apitype = 'member unfreeze';
        //                 //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //                 $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //                 $apitrack->apistatus = 'Success';
        //                 $apitrack->save();

        //                 return 203;

        //             } else {

        //                 $apitrack = new ApiTrack();
        //                 $apitrack->userid = $userid;
        //                 $apitrack->api = $unfreeze_desc;
        //                 $apitrack->apitype = 'member not unfreeze';
        //                 //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //                 $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //                 $apitrack->apistatus = 'Failure';
        //                 $apitrack->save();

        //                 return 202;

        //             }//end of 

        //     //else of $success_msg != null
        //     } else {

        //         $apitrack = new ApiTrack();
        //         $apitrack->userid = $userid;
        //         $apitrack->api = $unfreeze_desc;
        //         $apitrack->apitype = 'member not unfreeze';
        //         //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //         $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //         $apitrack->apistatus = 'Failure';
        //         $apitrack->save();

        //         return 202;

        //     }//end of $success_msg != null


        //             //else of $success_msg->Message
        //         } else {

        //             $apitrack = new ApiTrack();
        //             $apitrack->userid = $userid;
        //             $apitrack->api = $memberupload_desc;
        //             $apitrack->apitype = 'member not upload';
        //             $apitrack->apiresponse = !empty($success_msg->Message) ? $success_msg->Message : '';
        //             //$apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //             $apitrack->apistatus = 'Failure';
        //             $apitrack->save();

        //             return 202;
                    

        //         }//end of 


        //     //end of $success_msg != null
        //     } else {

        //         $apitrack = new ApiTrack();
        //         $apitrack->userid = $userid;
        //         $apitrack->api = $memberupload_desc;
        //         $apitrack->apitype = 'member not upload';
        //         $apitrack->apiresponse = !empty($success_msg) ? $success_msg : '';
        //         $apitrack->apistatus = 'Failure';
        //         $apitrack->save();

        //         return 202;

        //     }//end of $success_msg != null

        // }





    }


}
