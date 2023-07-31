<?php

namespace App\Http\Controllers;

use App\Passwordsettings;
use Illuminate\Http\Request;
use App\User;
use App\Scheme;
use App\Employee;
use App\Member;
use App\MemberPackages;
use App\PackageUpgradeModel;
use App\RootScheme;
use App\TransactionModel;
use App\PaymentType;
use App\Payment;
use App\Notify;
use App\Company;
use DB;
use DateTime;
use Ixudra\Curl\Facades\Curl;
use App\Smssetting;
use App\Notification;
use App\Notificationmsgdetails;
use App\Emailnotificationdetails;
use Session;

class PackageUpgradeController extends Controller
{
    public function packageupgrade(){

    	$users = User::leftjoin('member', 'users.memid', 'member.memberid')
    				   ->where('status', 1)
    				   ->where('memid', '!=', 0)
    				   ->get()->all();
    	$packages = Scheme::where('status', 1)->get()->all();

    	$admin = Employee::where('role', 'admin')->get()->all();

    	return view('admin.packageupgrade.packageupgradeview')->with(compact('users', 'packages', 'admin'));

    }

    public function memberpackageforupgrade(){

    	$userid = $_REQUEST['userid'];

    	$memberpackages = MemberPackages::leftjoin('schemes', 'memberpackages.schemeid', 'schemes.schemeid')
                      ->leftjoin('rootschemes', 'schemes.rootschemeid', 'rootschemes.rootschemeid')
                      ->leftjoin('transaction', 'transaction.transactionid', 'memberpackages.memberTransactionId')
    									->where('memberpackages.status', 1)
                                        ->where('transaction.transactionactualamount','!=','transaction.transactiondiscount')
    									->where('memberpackages.userid', $userid)
    									->get()->all();
                  
    	if(!empty($memberpackages)){
    		$select_menu = '<option value="">--Select Package--</option>';
    		foreach($memberpackages as $package){
          
      			$select_menu .= '<option value="'.$package->schemeid.'">'.ucfirst($package->schemename).' ('.(ucfirst($package->rootschemename)).')</option>';
          
    		}
    	}else{	
    		$select_menu = '<option value="">--No Package Available--</option>';
    	}

    	return $select_menu;

    }

    public function peiceformemberpackage(){

    	$packageid = $_REQUEST['packageid'];
      $userid = $_REQUEST['userid'];
      $package_price = 0;
      $discount = 0;
      $memberpackagesid = 0;

    	$memberpackage_data = MemberPackages::where('userid', $userid)->where('schemeid', $packageid)->where('status', 1)->first();
      if(!empty($memberpackage_data)){
        $memberpackagesid = $memberpackage_data->memberpackagesid;
        $joindate = $memberpackage_data->joindate;
      }
      
      
      /*$payment_data = Payment::where('invoiceno', $memberpackagesid)->whereIn('mode', ['total', 'no mode'])->get()->all();
      if(!empty($payment_data)){
        foreach($payment_data as $pay){
          $package_price = $pay->schemebaseprice;
          $discount = $discount + $pay->discountamount;
        }
      }*/
      
      $payment_data = Payment::where('invoiceno', $memberpackagesid)->where('mode', 'total')->where('invoicetype', 'm')->first();
      
      if(!empty($payment_data)){
        $package_price = $payment_data->schemebaseprice;
        $discount = $payment_data->discountamount;
      }

      if($discount > 0){
        $package_price = $package_price - $discount;
      }

    	return [$package_price, $discount];
    }

    public function peiceforupgradepackage(){

    	$upgradepackageid = $_REQUEST['upgradepackageid'];

    	$price = Scheme::where('schemeid', $upgradepackageid)->first();
    	if(!empty($price)){
    		$upgradepackage_price = $price->baseprice;
    		$days = $price->numberofdays;
    	}

    	return [$upgradepackage_price, $days];
    }

    public function checkifupgrade(){

      $userid = $_REQUEST['userid'];
      $packageid = $_REQUEST['packageid'];

      $if_upgraded = PackageUpgradeModel::where('upgradepackageuserid', $userid)->where('newpackageid', $packageid)->first();
      if(!empty($if_upgraded)){
        return 201;
      }else{
        return 203;
      }

    }

    public function verifyotpforpackage(){

    	$otp = $_REQUEST['otp'];
    	$admin_id = $_REQUEST['admin_id'];
        $admin_mobileno='';
    	$admin = Employee::where('employeeid', $admin_id)->first();
    	if(!empty($admin)){
    		$admin_mobileno = $admin->mobileno;
    	}

    	$otpverify = DB::table('otpverify')->where('mobileno', $admin_mobileno)->where('isexpired', 0)->orderBy('otpverifyid', 'desc')->first();

    	if(!empty($otpverify)){
    		$code = $otpverify->code;
    	}

    	$passwordoriginal=passwordsettings::where('passwordsettingsid', 1)->pluck('excelpassword')->first();

    	if((isset($code) && $code == $otp) || (isset($passwordoriginal) && $passwordoriginal==$otp)){
    		return 'true';
    	}else{
    		return 'false';
    	}
    }

    public function oldpackagedetail(){

    	$userid = $_REQUEST['userid'];
    	$oldpackageid = $_REQUEST['oldpackage'];
    	$joindate = '';
    	$tax = '';

    	$memberpackage_data = MemberPackages::where('userid', $userid)->where('schemeid', $oldpackageid)->where('status', 1)->first();
    	if(!empty($memberpackage_data)){
    		$memberpackagesid = $memberpackage_data->memberpackagesid;
    		$joindate = $memberpackage_data->joindate;
    	}
    	
    	$payment_data = Payment::where('invoiceno', $memberpackagesid)->where('mode', 'total')->first();
    	
    	if(!empty($payment_data)){
    		$tax = $payment_data->tax;
    	}

    	$payment = ['tax' => $tax, 'joindate' => $joindate];

    	return $payment;


    }

    public function rootschemeforpackageupgrade(){

      $scheme_id = $_REQUEST['packageid'];
      $user_id = $_REQUEST['userid'];
      $memberpackage = [];

      $select_menu = '';
      $scheme_data = Scheme::leftjoin('rootschemes', 'schemes.rootschemeid', 'rootschemes.rootschemeid')
                              ->where('schemes.status', 1)
                              ->where('schemes.validity', '>=', date('Y-m-d'))
                              ->get()->all();
      $userpackage = MemberPackages::where('userid', $user_id)->where('status', 1)->get()->all();
      if(!empty($userpackage)){
        foreach ($userpackage as $key => $package) {
          array_push($memberpackage, $package->schemeid);
        }
      }
      //dd($scheme_data);
      if(!empty($scheme_data)){
        $select_menu = '<option value="">--Select Package--</option>';
          foreach($scheme_data as $scheme){
            if($scheme->schemeid != $scheme_id && !in_array($scheme->schemeid , $memberpackage))
            $select_menu .= '<option value="'.$scheme->schemeid.'">'.ucfirst($scheme->schemename).' ('.ucfirst($scheme->rootschemename).')</option>';
          }
      }else{
        $select_menu .= '<option value="">--No Package Available--</option>';
      }

      return $select_menu;

    }

    public function packageupgradeorder(Request $request){
    	//dd($request->toArray());
    	$userid = $request->userid;
    	$memberpackage = $request->memberpackage;
    	$memberpackageprice = $request->memberpackageprice;
    	$price_difference = $request->price_difference;
    	$remaining_amount = $request->remaining_amount;
    	$upgradepackage = $request->upgradepackage;
    	$upgradepackage_price = $request->upgradepackage_price;
    	$amount_paid = $request->amount_paid;
      $discount_radio = $request->discount_radio;
      $total_discount = !empty($request->total_discount) ? $request->total_discount : 0;
      $tax_amount = !empty($request->tax_amount) ? $request->tax_amount : 0;
      $final_amount = $request->final_amount;
    	$due_date = !empty($request->due_date) ? date('Y-m-d', strtotime($request->due_date)) : null ;
    	$startingdate = !empty($request->Join_date) ? date('Y-m-d', strtotime($request->Join_date)) : null ;
    	$Expire_date = !empty($request->Expire_date) ? date('Y-m-d', strtotime($request->Expire_date)) : null ;
    	$tax = $request->tax;
      $old_package_join = '';
    	$transactiontype = '';
    	/*$tax_amount = 0;
    	$numberofdays = 0;
    	$gstno = 0;
      $oldremainingamount = 0;
      $memberid= 0;
      $discount = 0;
      $oldbaseprice = 0;
      $newbaseprice = 0;*/

    	
    	if(session()->get('packageupgrade') != null){
    		session()->forget('packageupgrade');
    	} else {
    		return redirect()->route('packageupgrade');
      	}

      DB::beginTransaction();
      try{

          $admin_no = Employee::where('employeeid', $request->admin)->select('mobileno')->first();
          
          DB::table('otpverify')->where('mobileno', $admin_no->mobileno)->orderBy('otpverifyid', 'desc')->update(['isexpired' => 1]);

      $memberpackage_data = MemberPackages::where('schemeid', $memberpackage)->where('userid', $userid)->where('status', 1)->first();
      if(!empty($memberpackage_data)){
        //$memberpackage_price = $memberpackage_data->actualprice;
        $memberpackageid = $memberpackage_data->memberpackagesid;
        $old_package_join = $memberpackage_data->joindate; 
        $old_package_expiredate = $memberpackage_data->expiredate;

      }
        
           $pay=Payment::where('userid',$userid)->get()->last();

      if($pay){
        if($pay->remainingamount){
          $memberid_redirect = $pay->memberid;
          return redirect('memberProfile/'.$memberid_redirect)->with('message','Please Complete Your Payment of remaining package.');
        }
      }


       $oldpaymentdata = Payment::where('invoiceno', $memberpackageid)->whereIn('mode', ['total', 'no mode'])->where('invoicetype', 'm')->orderBy('paymentid', 'desc')->first();

      
      if(!empty($oldpaymentdata)){
        $tax = $oldpaymentdata->tax;
        $discount = $oldpaymentdata->discountamount;
        $oldbaseprice = $oldpaymentdata->schemebaseprice;
        $memberid = $oldpaymentdata->memberid;
        $oldremainingamount = $oldpaymentdata->remainingamount;
      }

      // if($oldremainingamount > 0){
      //   return redirect('memberProfile/'.$memberid)->with('message', 'Please Complete Your Payment of remaining package.');
      // }

    	

    	$member_data = Member::where('userid', $userid)->first();
    	if(!empty($member_data)){
    		$memberid = $member_data->memberid;
        $mobileno = $member_data->mobileno;
    		$companyid = $member_data->companyid;
    		$fullname = ucfirst($member_data->firstname).' '.ucfirst($member_data->lastname);
    	}

      

      $oldpackage_data = Scheme::where('schemeid', $memberpackage)->first();
      if(!empty($oldpackage_data)){
        $oldpackage_price_basic = $oldpackage_data->baseprice;
        $oldschemename = ucfirst($oldpackage_data->schemename);
      }



    	$upgradepackage_data = Scheme::where('schemeid', $upgradepackage)->first();
    	if(!empty($upgradepackage)){
    		$schemename = $upgradepackage_data->schemename;
        $days = $upgradepackage_data->numberofdays;
        $upgradepackage_price_basic = $upgradepackage_data->baseprice;
        $upgradepackage_price_actual = $upgradepackage_data->actualprice;
    	}

      if($tax > 0){
        if(!empty($companyid)){
          $company_data = Company::where('companyid', $companyid)->first();
          if(!empty($company_data)){
            $gstno = $company_data->gstno;
          } else {
            $gstno = 0;

          }
        }
      }

    	/*if($tax > 0){
    		if(!empty($companyid)){
    			$company_data = Company::where('companyid', $companyid)->first();
	    		if(!empty($company_data)){
	    			$gstno = $company_data->gstno;
	    		} else {
	    			$gstno = 0;

	    		}
    		}

        if($total_discount > 0){
          if($discount_radio == 'rs'){
              //////////// old package start ///////////////////////////////

            $oldpackage_price = $oldbaseprice - $total_discount;
            $old_tax_calculation = ($oldpackage_price/100) * $tax;
            $oldpackage_price = $oldpackage_price + $old_tax_calculation;
            $oldpackage_price = (int)round($oldpackage_price);
            //////////// old package end ////////////////////////////////


            //////////// upgrade package start ////////////////////////////
            $upgradepackage_price = $upgradepackage_price_basic - $total_discount;
            $tax_calculation =  ($upgradepackage_price/100) * $tax;
            $upgradepackage_price = $upgradepackage_price + $tax_calculation;
            $upgradepackage_price = (int)round($upgradepackage_price);
            $tax_amount = (int)round($tax_calculation);
            //////////// upgrade package end ////////////////////////////
          }else{
            
            $oldpackage_price = $oldbaseprice - $total_discount;
            $old_tax_calculation = ($oldpackage_price/100) * $tax;
            $oldpackage_price = $oldpackage_price + $old_tax_calculation;
            $oldpackage_price = (int)round($oldpackage_price);
            //////////// old package end ////////////////////////////////


            //////////// upgrade package start ////////////////////////////
            $upgradepackage_price = $upgradepackage_price_basic - $total_discount;
            $tax_calculation =  ($upgradepackage_price/100) * $tax;
            $upgradepackage_price = $upgradepackage_price + $tax_calculation;
            $upgradepackage_price = (int)round($upgradepackage_price);
            $tax_amount = (int)round($tax_calculation);
            //////////// upgrade package end ////////////////////////////


            
          }

          

        }else{

          //////////// upgrade package start ////////////////////////////
          $oldpackage_price = $oldbaseprice;
          $tax_calculation =  ($oldpackage_price/100) * $tax;
          $oldpackage_price = $oldpackage_price + $tax_calculation;
          $oldpackage_price = (int)round($oldpackage_price);
          $tax_amount = (int)round($tax_calculation);
          //////////// upgrade package end ////////////////////////////

          //////////// upgrade package start ////////////////////////////
          $upgradepackage_price = $upgradepackage_price_basic;
          $tax_calculation =  ($upgradepackage_price/100) * $tax;
          $upgradepackage_price = $upgradepackage_price + $tax_calculation;
          $upgradepackage_price = (int)round($upgradepackage_price);
          $tax_amount = (int)round($tax_calculation);
          //////////// upgrade package end ////////////////////////////


        }
    	}else{
        if($total_discount > 0){
          $upgradepackage_price = $upgradepackage_price_basic - $total_discount;
          $oldpackage_price = $oldbaseprice - $total_discount;
        }else{
          $upgradepackage_price = $upgradepackage_price_basic;
          $oldpackage_price = $oldbaseprice;
        }
        
    		$tax_amount = 0;
    	}

    	$price_difference_cal = (int)round($upgradepackage_price) - (int)round($oldpackage_price);*/

    /*	if($price_difference_cal < 0){
    		return back()->with('message', 'Please select vaild package');
    	}

    	if(!is_numeric($amount_paid) || !is_numeric($remaining_amount)){
    		return back()->with('message', 'Please select vaild details');
    	}

    	if($amount_paid > $price_difference_cal){
    		return back()->with('message', 'Please select vaild paid amount');
    	}

*/

    	if($amount_paid == $final_amount){
    		$transactiontype = 'Fully';
    	}else{
    		$transactiontype = 'Partially';
    	}
    	//dd($upgradepackage);
    	$upgrade_package_data = Scheme::where('schemeid', $upgradepackage)->first();
    	//dd($upgrade_package_data);
    	if(!empty($upgrade_package_data)){
    		$schemes_name = $upgrade_package_data->schemename;
    		$rootschemeid = $upgrade_package_data->rootschemeid;
    		$numberofdays = $upgrade_package_data->numberofdays;
    		$numberofdays = $numberofdays - 1;
    	}

      $now = new DateTime();
      
      $joing_date_old = new DateTime($old_package_join);
      
      $days_diff = $now->diff($joing_date_old)->format("%d");

      $remaining_days = $numberofdays - $days_diff;
     
    	$end_date = date('Y-m-d', strtotime($startingdate.'+'.$numberofdays.' days'));
    	
    	$rootscheme_data = RootScheme::where('rootschemeid', $rootschemeid)->first();
    	if(!empty($rootscheme_data)){
    		$rootscheme_name = $rootscheme_data->rootschemename;
    	}

    	$remaining_amount = (int)round($final_amount) - (int)round($amount_paid);  

    	//transaction begin
    	

    		$transaction_no = hexdec(uniqid());

    		$transaction = new TransactionModel();
    		$transaction->transactionno = $transaction_no;
    		$transaction->transactionuserid = $userid;
    		$transaction->transactionmemberid = $memberid;
    		$transaction->paymenttypeid = 1;
    		$transaction->transactiondate = date('Y-m-d');
    		$transaction->transactionstatus = 0;
    		$transaction->transactionamount = (int)round($amount_paid);
    		$transaction->transactionschemeid = $upgradepackage;
    		$transaction->transactionstatus = 0;
    		$transaction->transactionresponse = '';
    		$transaction->transactionrefid = 0;
    		$transaction->transactiontype = $transactiontype;
    		$transaction->transactionactualamount = !empty($upgradepackage_price) ? (int)round($upgradepackage_price) : 0;
    		$transaction->transactionbaseamount = !empty($upgradepackage_price_basic) ? (int)round($upgradepackage_price_basic) : 0;
    		$transaction->transactiondiscount = !empty($total_discount) ? (int)round($total_discount) : 0;
    		$transaction->transactionduedate = $due_date;
    		$transaction->transactiontax = $tax;
    		$transaction->transactiontaxamount = $tax_amount;
    		if($amount_paid == 0){
    			$transaction->transactionremainingamount = 0 ;
    		} else {
    			$transaction->transactionremainingamount = !empty($remaining_amount) ? (int)round($remaining_amount) : 0 ;
    		}

    		$transaction->save();

    		$last_transaction_id = $transaction->transactionid;

    		$packageupgrade = new PackageUpgradeModel();
    		$packageupgrade->upgradepackageuserid = $request->userid;
    		$packageupgrade->upgradepackagememberid = $memberid;
    		$packageupgrade->oldpackageid = $memberpackage;
    		$packageupgrade->newpackageid = $upgradepackage;
        $packageupgrade->oldinvoiceno = $memberpackageid;
    		$packageupgrade->upgradepackagedate = date('Y-m-d');
    		$packageupgrade->save();

    		$last_upgrade_id = $packageupgrade->upgradepackageid;

    		$memberpackage = new MemberPackages();
    		$memberpackage->userid = $userid;
    		$memberpackage->schemeid = $upgradepackage;
    		$memberpackage->memberTransactionId = $last_transaction_id;
    		$memberpackage->upgradeid = $last_upgrade_id;
    		$memberpackage->joindate = $startingdate;
    		$memberpackage->expiredate = $end_date;
    		$memberpackage->status = 0;
			  $memberpackage->save();

			  $last_memberpackage_id = $memberpackage->memberpackagesid;

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
            'actualamount' =>  (int)round($upgradepackage_price_actual),
            'amount' =>  0,
            'amountwithtax' => (int)round($upgradepackage_price_actual),
            'tax' =>   (int)round($tax),
            'taxamount' =>   (int)round($tax_amount),
            'discount' => 0,
            'discountamount' => (int)round($final_amount) + (int)round($total_discount),
            'date' => date('Y-m-d'),
            'paymentdate' => now(),
            'mode' => 'no mode',
            'schemeid' => $upgradepackage,
            'type' => 'Debit',
            'remarks' =>  '',
            'invoiceno' => $last_memberpackage_id,
            'receiptno' =>  $rr_no_insert,
            'remainingamount'=> 0 ,
            'duedate' => $due_date,
            'invoicetype' =>  'O',
            'takenby' => session()->get('admin_id'),
            'paymentTransactionId' => $last_transaction_id,
            'schemeactualprice'=>$upgradepackage_price_actual,
            'schemebaseprice'=>$upgradepackage_price_basic, 
          ]);

          $memberpackage_update = MemberPackages::where('memberpackagesid', $last_memberpackage_id)->first();
          if(!empty($memberpackage_update)){
            $memberpackage_update->status = 1;
            $memberpackage_update->save();
          }

          $transaction_data = TransactionModel::where('transactionid', $last_transaction_id)->first();
          if(!empty($transaction_data)){
            $transaction_data->transactionstatus = 1;
            $transaction_data->save();
          }

          $memberpackage_data = MemberPackages::where('memberpackagesid', $memberpackageid)->first();
          if(!empty($memberpackage_data)){
            $memberpackage_data->status = 0;
            $memberpackage_data->save();            

          }

          $oldpayment_data = Payment::where('invoiceno', $memberpackageid)->where('invoicetype', 'm')->get()->all();
          if(!empty($oldpayment_data)){
            foreach($oldpayment_data as $oldpayment){
              $oldpayment->status = 0;
              $oldpayment->save();
            }
          }

          $ActualAmount_payment = 0;
          $invoiceno = $last_memberpackage_id;
          $transactiontype = 'Fully';
          $remainingamount = 0;
          $end_date = date('d-M-Y', strtotime($end_date));
          $join_date = date('d-M-Y', strtotime($startingdate));

          $msg=   DB::table('messages')->where('messagesid','33')->get()->first();

          $msg =$msg->message;
          $msg = str_replace("[Name of Member]",$fullname,$msg);
          $msg= str_replace("[ID]",$memberid,$msg);
          $msg= str_replace("[Name of Packge]",$oldschemename,$msg);
          $msg= str_replace("[new package name]",$schemename,$msg);
          $msg= str_replace("[Fully/Partially]",$transactiontype,$msg);
          $msg= str_replace("100",$ActualAmount_payment,$msg);
          $msg= str_replace("[join date]",$join_date,$msg);
          $msg= str_replace("[End Date]", $end_date,$msg);
          $msg= str_replace("[InvoiceID]",$invoiceno,$msg); 

          $due='';
          if($transactiontype == 'Partially'){
            $due=" Due Amount:[Due Amount] Next Due Date: [Due Date]";
            $due= str_replace("[Due Amount]",$remainingamount,$due);
            $due= str_replace("[Due Date]", date('d-m-Y', strtotime($due_date)),$due);

            $msg=''.$msg.''.$due.'';
          }

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
           $action->subject = 'Assign Package';
           $action->save();

         }

          $loginuser = session()->get('username');
           $actionbyid=Session::get('employeeid');
  
          $notify=Notify::create([
            'userid'=> $userid,
            'details'=> ''.$loginuser.' upgrade package '.$schemename,
            'actionby' =>$actionbyid,
          ]);

          // DB::commit();
          // $success = true;


          return view('admin.packageupgrade.orderpaymentsummary')->with(compact('fullname', 'schemename', 'join_date', 'end_date', 'ActualAmount_payment','invoiceno', 'rr_no_insert', 'transactiontype', 'due_date', 'remainingamount', 'userid'));

        }



			DB::commit();
			$success = true;

      		$PaymentTypes = PaymentType::get()->all();

			return view('admin.packageupgrade.orderpayment')->with(compact('userid', 'last_transaction_id', 'last_upgrade_id','PaymentTypes', 'schemes_name', 'rootscheme_name','fullname', 'amount_paid', 'remaining_amount', 'startingdate', 'end_date', 'last_memberpackage_id', 'transactiontype', 'due_date', 'upgradepackage_price_basic', 'upgradepackage_price', 'tax', 'price_difference','memberpackageprice','tax_amount', 'total_discount'));



    	}catch(\Exception $e){

    		$success = false;
    		DB::rollback();

    	}
    	//transaction end
    	if($success == false){
    		return redirect('dashboard');
    	}
    }

    public function upgradepackagepayment(Request $request){

      $transactionid = $request->transactionId;
      $upgradeid = $request->upgradeid;
      $last_memberpackage_id = $request->last_memberpackage_id;
      $userid = $request->userid;
      $mode_payment= $request->Mode;
      $remark= $request->Remark;
      $amount= $request->Amount;
      $ActualAmount_payment = 0;
      $oldpackage_invoice = 0;

      $check_transaction = TransactionModel::where('transactionid', $transactionid)->first();
      if(!empty($check_transaction)){
        if($check_transaction->transactionstatus == 1){
          return redirect()->route('packageupgrade');
        }
      }

      DB::beginTransaction();
      try{


        $member_data = Member::where('userid', $userid)->first();
        if(!empty($member_data)){
          $fullname = ucfirst($member_data->firstname).' '.ucfirst($member_data->lastname);
          $mobileno = $member_data->mobileno;

          DB::table('otpverify')->where('mobileno', $mobileno)->update(['isexpired' => 1]);
        }

        $upgradepackage_data = PackageUpgradeModel::where('upgradepackageid', $upgradeid)->first();
        if(!empty($upgradepackage_data)){
          $memberid = $upgradepackage_data->upgradepackagememberid;
          $oldpackageid = $upgradepackage_data->oldpackageid;
          $newpackageid = $upgradepackage_data->newpackageid;
          $oldpackage_invoice = $upgradepackage_data->oldinvoiceno;
        }

        $package_data = Scheme::where('schemeid', $newpackageid)->first();
        if(!empty($package_data)){
          $schemename = ucfirst($package_data->schemename);
        }

        $old_package_name = Scheme::where('schemeid', $oldpackageid)->first();
        if(!empty($old_package_name)){
          $oldschemename = ucfirst($old_package_name->schemename);
        }

        $transaction_data = TransactionModel::where('transactionid', $transactionid)->first();
        if(!empty($transaction_data)){
          $tax = $transaction_data->transactiontax;
          $transactionamount = $transaction_data->transactionamount;
          $baseamount = $transaction_data->transactionbaseamount;
          $actualamount = $transaction_data->transactionactualamount;
          $tax = $transaction_data->transactiontax;
          $taxamount = $transaction_data->transactiontaxamount;
          $due_date = $transaction_data->transactionduedate;
          $transactiontype = $transaction_data->transactiontype;
          $total_discount = $transaction_data->transactiondiscount;
          $remainingamount = $transaction_data->transactionremainingamount;
        }

        $memberpackages_data = MemberPackages::where('memberpackagesid', $last_memberpackage_id)->first();
        if(!empty($memberpackages_data)){
          $invoiceno = $memberpackages_data->memberpackagesid;
          $join_date = date('d-m-Y', strtotime($memberpackages_data->joindate));
          $end_date = date('d-m-Y', strtotime($memberpackages_data->expiredate));
        }

        $rr_no_insert = 0;
        $rr_no = Payment::where('status', 1)->max('receiptno');
        if(!empty($rr_no) || $rr_no != null ){
          $rr_no_insert = $rr_no + 1;

        } else {

          $rr_no_insert = 1;
        }

        $scheme_name = Scheme::where('schemeid', $newpackageid)->first();
        $schemeactualprice=   $scheme_name->actualprice;
        $schemebaseprice= $scheme_name->baseprice;

        for ($n=0; $n < count($mode_payment) ; $n++) { 

          $ActualAmount_payment += $amount[$n];

          $payment =  Payment::create([
            'memberid' =>  $memberid,      
            'userid' => $userid,
            'actualamount' =>  (int)round($actualamount),
            'amount' =>  $amount[$n],
            'amountwithtax' => (int)round($actualamount),
            'tax' =>   (int)round($tax),
            'taxamount' =>   (int)round($taxamount),
            'discount' => 0,
            'discountamount' => $total_discount,
            'date' => date('Y-m-d H:i:s'),
            'paymentdate' => now(),
            'mode' => PaymentType::find($mode_payment[$n])->paymenttype,
            'schemeid' => $newpackageid,
            'type' => 'Debit',
            'remarks' =>  $remark[$n],
            'invoiceno' => $invoiceno,
            'receiptno' => $rr_no_insert,
            'remainingamount'=> !empty($remainingamount) ? (int)round($remainingamount) : 0 ,
            'duedate' => $due_date,
            'invoicetype' =>  'O',
            'takenby' => session()->get('admin_id'),
            'paymentTransactionId' => $transactionid,
            'schemeactualprice'=>$schemeactualprice,
            'schemebaseprice'=>$schemebaseprice, 

          ]);
        }

        $payment =  Payment::create([
          'memberid' =>  $memberid,      
          'userid' => $userid,
          'actualamount' =>  (int)round($actualamount),
          'amount' =>  (int)round($ActualAmount_payment),
          'amountwithtax' => (int)round($actualamount),
          'tax' =>   (int)round($tax),
          'taxamount' =>   (int)round($taxamount),
          'discount' => 0,
          'discountamount' => $total_discount,
          'date' => date('Y-m-d'),
          'paymentdate' => now(),
          'mode' => 'total',
          'schemeid' => $newpackageid,
          'type' => 'Debit',
          'remarks' =>  '',
          'invoiceno' => $invoiceno,
          'receiptno' =>  $rr_no_insert,
          'remainingamount'=> !empty($remainingamount) ? (int)round($remainingamount) : 0 ,
          'duedate' => $due_date,
          'invoicetype' =>  'O',
          'takenby' => session()->get('admin_id'),
          'paymentTransactionId' => $transactionid,
          'schemeactualprice'=>$schemeactualprice,
          'schemebaseprice'=>$schemebaseprice, 
        ]);

        $transaction_data->transactionstatus = 1;
        $transaction_data->save();

        $memberpackages_data->status = 1;
        $memberpackages_data->save();

        $upgradepackage_data->upgradepackagestatus = 1;
        $upgradepackage_data->save();

        $oldpackage_data = MemberPackages::where('memberpackagesid', $oldpackage_invoice)->first();
        if(!empty($oldpackage_data)){
          $oldpackage_data->status = 0;
          $oldpackage_data->save();
        }

        $oldpayment_data = Payment::where('invoiceno', $oldpackage_invoice)->where('invoicetype', 'm')->get()->all();
        if(!empty($oldpayment_data)){
          foreach($oldpayment_data as $oldpayment){
            $oldpayment->status = 0;
            $oldpayment->save();
          }
        }

        $msg=   DB::table('messages')->where('messagesid','33')->get()->first();

        $msg =$msg->message;
        $msg = str_replace("[Name of Member]",$fullname,$msg);
        $msg= str_replace("[ID]",$memberid,$msg);
        $msg= str_replace("[Name of Packge]",$oldschemename,$msg);
        $msg= str_replace("[new package name]",$schemename,$msg);
        $msg= str_replace("[Fully/Partially]",$transactiontype,$msg);
        $msg= str_replace("100",$transactionamount,$msg);
        $msg= str_replace("[join date]",$join_date,$msg);
        $msg= str_replace("[End Date]", $end_date,$msg);
        $msg= str_replace("[InvoiceID]",$invoiceno,$msg); 

        $due='';
        if($transactiontype == 'Partially'){
          $due="Due Amount:[Due Amount] Next Due Date: [Due Date]";
          $due= str_replace("[Due Amount]",$remainingamount,$due);
          $due= str_replace("[Due Date]", date('d-m-Y', strtotime($due_date)),$due);

          $msg=''.$msg.''.$due.'';
        }

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
         $action->subject = 'Assign Package';
         $action->save();

        }

        $loginuser = session()->get('username');
        $actionbyid=Session::get('employeeid');
        $notify=Notify::create([
          'userid'=> $userid,
          'details'=> ''.$loginuser.' upgrade package '.$schemename,
          'actionby' =>$actionbyid,
        ]);

        $notify=Notify::create([
          'userid'=> $userid,
          'details'=> ''.$loginuser.' take payment of user '.$transactionamount,
           'actionby' =>$actionbyid,
        ]);

        DB::commit();
        $success = true;

        return view('admin.packageupgrade.orderpaymentsummary')->with(compact('fullname', 'schemename', 'join_date', 'end_date', 'ActualAmount_payment','invoiceno', 'rr_no_insert', 'transactiontype', 'due_date', 'remainingamount', 'userid'));




      }catch(\Exception $e){

        $success = false;
        DB::rollback();

      }

      if($success == false){
        return redirect('dashboard');
      }


    }

  public function upgradepackagedetails(){

    $upgradepackage_data = PackageUpgradeModel::with('newscheme','oldscheme','member')->orderBy('upgradepackageid','desc')->get()->all();
    //dd($upgradepackage_data);

    return view('admin.packageupgrade.upgradepackagedetails')->with(compact('upgradepackage_data'));



  }

}
