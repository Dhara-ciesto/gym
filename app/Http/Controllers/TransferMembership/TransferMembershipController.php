<?php

namespace App\Http\Controllers\TransferMembership;

use Illuminate\Http\Request;
use DB;
use App\Member;
use App\MemberPackages;
use App\Notify;
use App\TransferMembership;
use App\Payment;
use App\Ptmember;
use App\Employee;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use App\OTPVerify;
use App\Claimptsession;
use App\Smssetting;
use App\Notificationmsgdetails;
use Session;

class TransferMembershipController extends Controller
{
   public function addtransfermembership(Request $request){

       $users =  DB::table('member')
       ->join('users', 'member.userid', '=', 'users.userid')
       ->where('users.userstatus', 'mem')->where('member.status',1)->get()->all();

       $tousers =  DB::table('member')
       ->join('users', 'member.userid', '=', 'users.userid')
       ->where('users.userstatus', 'mem')->get()->all();

       $admin = Employee::where('role', 'admin')->get()->all();
        if ($request->isMethod('post'))
        {
          $fromuserid=$request->transferfrom;
          $touserid=$request->transferto;
          // dd($request->activepacks);
          $from=array();
          // dd($request->check);
          foreach ($request->check as $key => $activepackages) {
        
            $fromdata=MemberPackages::where('userid',$fromuserid)->where('memberpackages.schemeid',$activepackages)->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid')->get()->first();
            if($fromdata){
              array_push($from, $fromdata);
            }
          }
          // $from=MemberPackages::where('userid',$fromuserid)->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid')->get()->all();

          $to=MemberPackages::where('userid',$touserid)->get()->first();
          $loginuser = session()->get('username');
          $tousername=Member::where('userid',$touserid)->get()->first();

          $tousername=$tousername->firstname.' '.$tousername->lastname;
          $fromusername=Member::where('userid',$fromuserid)->get()->first();
          $fromusername=$fromusername->firstname.' '.$fromusername->lastname;



            
          /************************for remaining pay redirect back**************************/

          $pay=Payment::where('userid',$fromuserid)->get()->last();

          if($pay){
            if($pay->remainingamount){
              $memberid_redirect = $pay->memberid;
              return redirect('memberProfile/'.$memberid_redirect)->with('message','Please Complete Your Payment of remaining package.');
            }
          }

          $pay=Payment::where('userid',$touserid)->get()->last();

          if($pay){
            if($pay->remainingamount){
              $memberid_redirect = $pay->memberid;
              return redirect('memberProfile/'.$memberid_redirect)->with('message','Please Complete Your Payment of remaining package.');
            }
          }
          /************************for same user redirect back**************************/
          if($fromuserid == $touserid) {
              return redirect()->back()->withErrors(["You can't transfer package to same User"]);
          }



          /*****************for new user*********************************/

          DB::beginTransaction();
          try {
          foreach ($from as $key => $value) {

            // dd($value->userid);
            
            $fromjoindate=$value->joindate;
            $fromexpiredate=$value->expiredate;
            $frommemberpackagesid=$value->memberpackagesid;
            

            $memberpackages = new Memberpackages();
            $memberpackages->userid = $touserid;
            $memberpackages->schemeid = $value->schemeid;

            $memberpackages->joindate = $fromjoindate;
            $memberpackages->expiredate = $fromexpiredate;
            $memberpackages->status = 1;
            $memberpackages->transferid =0;

            $memberpackages->save();


          

            /*****************for old user*********************************/
            $value->status = 3;
        
            $value->save();
            $transfer= TransferMembership::create([
                      
                    'fromuserid'=> $fromuserid,
                    'touserid'=>  $touserid,
                    'schemeid'=> $value->schemeid,
                    'transfer_by'=> session()->get('admin_id'),
                    'transfer_on'=>now(),
                    'status'=>1,

                    ]); 

            $value->transferid=$transfer->transfermembershipid;
            $value->save();
            $memberpackages->transferid = $transfer->transfermembershipid;
            $memberpackages->save();


            $frommemberid= Member::where('userid',$fromuserid)->pluck('memberid')->first();
            $tomemberid= Member::where('userid',$touserid)->pluck('memberid')->first();
            if($value->rootschemeid == 2){


              $ptitems = Ptmember::where('memberid',$frommemberid)->where('packageid', $frommemberpackagesid)->get()->all();
              if($ptitems){
                foreach ($ptitems as $item) 
                {

                    $newitem=$item->replicate();
                    $newitem->memberid = $tomemberid;
                    
                    $newitem->packageid = $memberpackages->memberpackagesid;
                    $newitem->save();
                }
                $ptentrys=Ptmember::where('memberid',$frommemberid)->where('status','Active')->get()->all();
              $count = count($ptentrys);

                foreach ($ptentrys as $key => $ptentry) {
                
                  $ptentry->status = "Transferred";
                  $ptentry->save();
                }

              $claimentry=  Claimptsession::where('memberid',$frommemberid)->where('packageid', $frommemberpackagesid)->where('status','Active')->get()->all();

              if($claimentry){
                  foreach ($claimentry as $key => $clentry) {
                
                    $newitem=$clentry->replicate();
                    $newitem->memberid = $tomemberid;
                    
                    $newitem->packageid = $memberpackages->memberpackagesid;
                    $newitem->save();
                }
                  foreach ($claimentry as $key => $clentry) {
                
                  $clentry->status = "Transferred";
                  $clentry->save();
                }
              }
              }
              
            }

      

      
            /*********************for timeline entry in notify*****************************************/
      
            $actionbyid=Session::get('employeeid');
      

            $notify=Notify::create([
                  
                  'userid'=> $fromuserid,
                'details'=>  ''.$loginuser.' had Transfer "' . $value->schemename.'" Package to '.$tousername,
                'actionby' =>$actionbyid,
                ]); 
            $notify=Notify::create([
                  
                  'userid'=> $touserid,
                'details'=>  ''.$loginuser.' had Transfer "' . $value->schemename.'" Package from '.$fromusername,
                'actionby' =>$actionbyid,
                ]); 	 
          }


            /********************************for msg fromuser for membership transfer fromuser**************************************/


          $msg=   DB::table('messages')->where('messagesid','7')->get()->first();

          $msg =$msg->message;
            $tfname=Member::where('userid',$touserid)->get()->first();
            $ffname=Member::where('userid',$fromuserid)->get()->first();



          $msg = str_replace("[FirstName]",$ffname->firstname,$msg);
          $msg = str_replace("[LastName]",$ffname->lastname,$msg);
      
          $msg= str_replace("[NewMemberName]",ucfirst($tfname->firstname).' '.ucfirst($tfname->lastname),$msg);
      

      
          $msg = urlencode($msg);

          $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

          if ($smssetting) {

          $u = $smssetting->url;
          $url= str_replace('$mobileno', $ffname->mobileno, $u);
          $url=str_replace('$msg', $msg, $url);  
          $otpsend = Curl::to($url)->get();

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno =  $ffname->mobileno;
          $action->smsmsg = $msg;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Assign Package';
          $action->save();

          }
          /*************************************for touser****msg****************************************************/
          

            $msg=   DB::table('messages')->where('messagesid','32')->get()->first();

          $msg =$msg->message;
            $tfname=Member::where('userid',$touserid)->get()->first();
            $ffname=Member::where('userid',$fromuserid)->get()->first();



          $msg = str_replace("[FirstName]",$tfname->firstname,$msg);
          $msg = str_replace("[LastName]",$tfname->lastname,$msg);
          $msg= str_replace("[OldMemebrName]",ucfirst($ffname->firstname).' '.ucfirst($ffname->lastname),$msg);
      

      
          $msg = urlencode($msg);

          $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

          if ($smssetting) {

          $u = $smssetting->url;
          $url= str_replace('$mobileno', $tfname->mobileno, $u);
          $url=str_replace('$msg', $msg, $url);  
          $otpsend = Curl::to($url)->get();

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('employeeid');
          $action->mobileno =$tfname->mobileno;
          $action->smsmsg = $msg;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Transfer Package';
          $action->save();

          }

            /*******************************End ***for msg fromuser for membership transfer *************************************/

          DB::commit();
            $success = true;

            $TransferMembership = [

                      'TransferMembershipfromuser' => $fromuserid,
                      'TransferMembershiptouser'  => $touserid,

                                  ];

          $request->request->add(['TransferMembership' => $TransferMembership]);

          $TransferMembershipexpity = app()->call('App\Http\Controllers\DeviceController@extendexpiry');

          return redirect('viewtransfermembership')->withSuccess('Succesfully Transferd');

          } catch (\Exception $e) {
          /*************cache code**************************/
            $success = false;
            DB::rollback();

          }
          /*************if try code fails**************************/
          if ($success == false) { 
            return redirect('dashboard');
          }
   		 	 

   		  }
    
  	  return view('admin.transfermembership.addtransfermembership',compact('users','admin','tousers'));
   }
   public function viewtransfermembership(Request $request){

    $trans=TransferMembership::with('transfer')->join("member as r" ,'r.userid','=','transfermembership.fromuserid')
                ->join("member as rt",'rt.userid','=','transfermembership.touserid')->join('schemes','schemes.schemeid','transfermembership.schemeid')
                ->leftjoin('employee','employee.employeeid','transfermembership.transfer_by')
        ->get(['r.firstname as fromfirstname','r.lastname as fromlastname','rt.firstname as tofirstname','rt.lastname as tolastname','transfermembership.*','schemes.schemename','employee.first_name','employee.last_name'])->all();
// dd($trans);
      return view('admin.transfermembership.viewtransfermembership',compact('trans'));
  		
   }
   public function getactivepackages(Request $request){
    /**************************load active packs for transfer************************************/
        $username = $_REQUEST['username'];
        $user = Member::where('userid','=', $username)->where('status',1)->get()->first();
          $packages=MemberPackages::where('memberpackages.userid',$username)->join('schemes','schemes.schemeid','memberpackages.schemeid')->where('memberpackages.transferid','=','0')->where('memberpackages.userid',$username)->where('memberpackages.status',1)->get()->all();


            foreach ($packages as $key => $value) {
               // $a =  Payment::where('memberid',$id)->where('schemeid',$value->schemeid)->where('invoiceno',$value->memberpackagesid)->latest()->first();
              $a =  Payment::where('userid',$username)->where('schemeid',$value->schemeid)->where('invoiceno',$value->memberpackagesid)->latest()->first();
             
              if($a){
                $value->amount = $a->amount;
                 $value->discount = $a->discountamount;

              }
              else{
                
              }
            }
 
        echo json_encode($packages);
   }
 
      public function sendotp(Request $request){
   $admin_id = $_REQUEST['adminid'];
      $admin_data = Employee::where('employeeid', $admin_id)->first();
      if(!empty($admin_data)){
        $contact_no = $admin_data->mobileno;
        $first_name = $admin_data->first_name;
        $last_name = $admin_data->last_name;
        $email = $admin_data->email;
      }
      $rndno= mt_rand(100000, 999999);
      $mobileno = $contact_no;
      $fname = $first_name;
      $lname = $last_name;
      $email = $email;
      //insert into table
      $otpverify = [ 
        'mobileno'      => $mobileno,
        'email'         => $email,
        'code'          => $rndno,  
        'isexpired'    =>'0',            
        'created_at'     => date('Y-m-d  H:i:s'),
        'updated_at'     => date('Y-m-d  H:i:s'), 
      ];
      DB::table('otpverify')->insert($otpverify);
      // $last_id = DB::getPdo()->lastInsertId();
      // $action = new Actionlog();
      // $action->user_id = session()->get('admin_id');
      // $action->ip = $request->ip();
      // $action->action_type = 'resend';
      // $action->action = 'OTP';
      // $action->action_on = $last_id;
      // $action->save();
      $msg=   DB::table('messages')->where('messagesid','22')->get()->first();
   
      $msg =$msg->message;         
      $msg = str_replace("[FirstName]",ucfirst($fname),$msg);
      $msg= str_replace("[LastName]",ucfirst($lname),$msg);
      $msg= str_replace("[otp]",$rndno,$msg);
      $msg = urlencode($msg);
      
   $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get();
      // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get();
    
      if (strpos($otpsend, 'success') !== false) {
          $success = true;
      }
      else{
        $success = false;
      }
      if($success == true){
        return response()->json($success);
      }

 }
 public function transferotpverify(Request $request){

   $code = $request->get('txtotp');

            //dd($request->mobileno);

   $q=OTPVerify::where('code',$code)->where('isexpired','!=','1')->first();


   if($q){
    $q->isexpired = 1;
    $q->save();

    if($q){
      echo 'Verified';
    }
    }
  }
 
}
