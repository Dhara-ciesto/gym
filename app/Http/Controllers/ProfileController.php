<?php

namespace App\Http\Controllers;

use App\Http\Controllers\sms\NotificationController;
use Illuminate\Http\Request;

use App\Role;
use App\Member;
use App\ExerciseProgram;
use DB;
use App\User;
use App\MemberPackages;
use App\Fitnessgoals;
use App\RootScheme;
use App\Scheme;
use App\Payment;
use App\PaymentType;
use App\AdminMaster;
use App\PaymentDetails;
use Illuminate\Support\Facades\Hash;
use App\Company;
use App\Files;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Inquiry;
use Carbon\Carbon;
use App\Notify;
use PDF;
use Session;
use Ixudra\Curl\Facades\Curl;
use App\Notes;
use App\Deviceuser;
use App\Measurement;
use App\FreezeMembershipReceipt;
use App\FreezeMembershipModal;
use App\MemberExercise;
use App\Notificationmsgdetails;
use App\Actionlog;
use App\DeviceEvent;
use App\Employee;
use App\MemberDiet;
use App\Smssetting;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;
use App\Emailnotificationdetails;
use App\Apischedule;
use App\ApiTrack;
use App\ApiCronJob;
use App\DeviceFetchlogs;


class ProfileController extends Controller
{
  public function IDupload(Request $request){

       // dd($request['attachments']);

    if($request->hasfile('attachments'))
     {
        foreach($request->file('attachments') as $file)
        {
            $name=$file->getClientOriginalName();
            $file->move(public_path().'/files/', $name);
            $data[] = $name;
        }

     $file = new Files();
     $file->filename=json_encode($data);
     $file->memberid = $MemberId;
     $file->save();
     }
     return redirect()->back();

  }
   public function profile($id,Request $request)
    {


 $member = DB::table('member')->select('member.memberid AS mid','member.workinghourfrom AS mworkinghourfrom','member.workinghourto AS mworkinghourto','member.*','users.*','schemes.*','fitnessgoals.other AS fother','fitnessgoals.*','exerciseprogram.other As eother','exerciseprogram.*','member.anniversary as anniversarydate','member.status AS mstatus' )
    ->leftJoin('users','member.userid','=','users.userid')
    ->leftJoin('schemes', 'schemes.schemeid', '=', 'users.userid')
    ->leftJoin('fitnessgoals','member.memberid','=','fitnessgoals.memberid')
    ->leftJoin('exerciseprogram','member.memberid','=','exerciseprogram.memberid')

    ->where('member.memberid','=',$id)
    ->get()->first();


    $payment = Payment::where('memberid',$id)->where('mode','!=', 'total')->whereIn('invoicetype',['m','o'])->where('status', 1)->get()->all();


      $freezemembership_data = FreezeMembershipModal::where('freezememberhipuserid', $id)->get()->all();


    $allpackages = MemberPackages::with('Scheme')->where('userid',$member->userid)->get()->all();
    $packages=[];
    $lastpackage = MemberPackages::with('Scheme')->where('userid',$member->userid)->where('status',1)->max('expiredate');

    $memberid = Member::where('memberid',$id)->get()->first();
    $userid=Member::where('memberid',$id)->get()->first();

    // $pay = MemberPackages::leftJoin('payments','payments.receiptno','=','memberpackages.memberpackagesid')->where('memberpackages.userid',$userid->userid)->get()->all();
    $t= array();


    foreach ($allpackages as $key => $value) {
       // $a =  Payment::where('memberid',$id)->where('schemeid',$value->schemeid)->where('invoiceno',$value->memberpackagesid)->latest()->first();
      $a =  Payment::where('memberid',$id)
      ->where('schemeid',$value->schemeid)
      ->where('invoiceno',$value->memberpackagesid)->latest()->first();
      if($a){
      if($a->remainingamount > 0){
        $value->remainingamount = $a->remainingamount;
         $value->invoiceno = $a->invoiceno;
      }
      else{
          $value->remainingamount =0;
         $value->invoiceno = 0;
      }
    }
        $packages[]= $value;
    // else{
    //       $value->remainingamount =0;
    //      $value->invoiceno = 0;
    //   }
    //   if($a){
    //     array_push($t,$a);
    //   }

    }
    $images =  DB::table('files')->where('memberid', $id)->pluck('filename')->first();
    $img='';
    if($images){
        $img=$images;
    }else{
      $img='';
     }
    $company = Company::get()->all();

    $notes=Notes::where('userid',$userid->userid)->get()->all();
    // $fitnessgoals = Fitnessgoals::where('userid',$id)->get()->all();

    $activities = MemberPackages::where('created_at','<', Carbon::now()->subHours(2)->toDateTimeString())->where('userid',$userid->userid)->get()->all();
    $userid=$userid->userid;
    $notify = Notify::where('userid',$userid)->orderBy('notifyid', 'desc')->get()->all();


    $measurement=Measurement::where('memberid',$id)->get()->all();
    $todayexercise='';

    $todaydietplan='';


    // $pay = MemberPackages::leftJoin('payments','payments.receiptno','=','memberpackages.memberpackagesid')->where('memberpackages.userid',$userid->userid)->get()->all();

    $texercise=MemberExercise::with('Workout','Exercise')->where('memberid',$id)->where('status','1')->get()->all();
    if($texercise){
      $todayexercise=$texercise;
    }
 // dd($todayexercise);
    $tdietplan=MemberDiet::with('DietPlanname')->where('memberid',$id)
    ->leftJoin('mealmaster','mealmaster.mealmasterid','=','memberdiet.mealid')->where('memberdiet.status','=','1')
    ->get()->all();
     if($tdietplan){
      $todaydietplan=$tdietplan;
    }
// dd($todaydietplan);


    /***************************************######deviceusers table relasted ****************************************/

     // $deviceuser = Deviceuser::where('mobileno',$memberid->mobileno)->get()->first();

    /*****************************End *######deviceusers table relasted********************************************/





     // print_r($deviceuser->userid);exit;

$deviceuser='';
$deviceuser = Deviceuser::where('userid',$memberid->userid)->get()->first();
        return view('admin.memberprofile',compact('member','freezemembership_data','packages','payment','img','company','notes','activities','notify','t','lastpackage','measurement','todayexercise','deviceuser','todaydietplan'));


    }

public function pinchange($id,Request $request){

      $cn1 = $request->input('cn1');
      $cn2 = $request->input('cn2');
      $cn3 = $request->input('cn3');
      $cn4 = $request->input('cn4');

      $cns = $cn1.$cn2.$cn3.$cn4;

      $change = Member::findOrFail($id);
      $userid= $change->userid;
      $change->memberpin = $cns;
      $change->save();

      $email = $change->email;

      /**logs for pin change **/
     $last_id = $change->memberid;
     $action = new Actionlog();
     $action->user_id = session()->get('admin_id');
     $action->ip = $request->ip();
     $action->action_type = 'update';
     $action->action = 'memberpin';
     $action->action_on = $last_id;
     $action->save();
      /**End logs for pin change **/

      $mobileno= $change->mobileno;
      $fname=$change->firstname;
      $lname=$change->lastname;
      $fname=ucfirst($fname);
      $lname=ucfirst($lname);

        $msgformemberpin =  DB::table('messages')->where('messagesid','16')->get()->first();
        $msgformemberpin =$msgformemberpin->message;
        $msgformemberpin = str_replace("[firstname]",$fname,$msgformemberpin);
        $msgformemberpin= str_replace("[lastname]",$lname,$msgformemberpin);
        $msgformemberpin= str_replace("[pin]",$cns,$msgformemberpin);
        $msgformemberpin2=$msgformemberpin;
        $msgformemberpin = urlencode($msgformemberpin);

         $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

         if ($smssetting) {

         $u = $smssetting->url;
         $url= str_replace('$mobileno', $mobileno, $u);
         $url=str_replace('$msg', $msgformemberpin, $url);

//        $otpsend = Curl::to($url)->get();
        $otpsend = 0;
             $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($mobileno),$msgformemberpin2);

        $action = new Notificationmsgdetails();
        $action->user_id = session()->get('admin_id');
        $action->mobileno = $mobileno;
        $action->smsmsg = $msgformemberpin2;
        $action->smsrequestid = $otpsend;
        $action->subject = 'Member FitPin Change';
        $action->save();

       }

        $emailsetting =  Emailsetting::where('status',1)->first();

        if ($emailsetting) {

        $data = [
                             //'data' => 'Rohit',
               'msg' => $msgformemberpin2,
               'mail'=> $email,
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
            ];


       // Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

      //          $message->from($data['senderemail'], 'Member Pin Change');
      //          $message->to($data['mail']);
      //          $message->subject($data['subject']);

      //    });

          $action = new Emailnotificationdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->message = $msgformemberpin2;
          $action->emailform = $data['senderemail'];
          $action->emailto = $data['mail'];
          $action->subject = $data['subject'];
          $action->messagefor = 'Member Pin Change';
          $action->save();

        }


        // $msgformemberpinsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msgformemberpin.'&route=6')->get();

        // $nmdformemberpin = [

        // 'mobileno' => $mobileno,
        // 'smsmsg' => $msgformemberpin2,
        // 'mailmsg' => '0',
        // 'callnotes' => '0',
        // ];
        // DB::table('notoficationmsgdetails')->insert($nmdformemberpin);
         $loginusername= Session::get('username');
          $actionbyid=Session::get('employeeid');
          $notify=Notify::create([
     'userid'=> $userid,
     'details'=> ''.$loginusername. ' changed Fit PIN',
     'actionby' =>$actionbyid,

   ]);
          return redirect()->back()->with('successmsg','PIN changed Successfully');
  }


    public function consentform(){
      return view('admin.consentform');
    }

    public function Printconsentform(Request $request){

      $pdf = PDF::loadView('admin.consentformprint',compact('request'));

      return $pdf->stream(''.$request->firstname.' '.$request->lastname.'.pdf');

    }
    public function paymentreceipt(Request $request){

    $pdf = new \App\paymentreceipt;
    $pdf->generate($request);

    }

  public function paymentforreceiptNo($ReceiptNo){

    $pdf = new \App\PaymentforReceiptNo;
    $pdf->generate($ReceiptNo);

    }


    public function setuser(Request $request){

       $setuserid = $request->get('setuserid');
       $susername = $request->get('setusername');
       $sdate = $request->get('setuserexpiry');
       $sdate = explode('-', $sdate);
       $setuserstatus = $request->get('setuserstatus');
       $setuserrefid = $request->get('setuserrefid');
       $deviceaccess =  $request->get('deviceaccess');
       $devicemobileno = $request->get('devicemobileno');
         $portno_const = config('constants.port');
        $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'insert';
           $action->action = 'Set Member into Device';
           $action->action_on = $deviceaccess;
           $action->save();



        $duser = User::where('usermobileno',$devicemobileno)->get()->first();


        $en = Deviceuser::where('userid',$duser->userid)->get()->first();

        // print_r($status); exit;

                        if ($en) {
                        if ($en->userid == $duser->userid) {

                                 $data = [

                                'userrefid' => $duser->userid,
                                'userid' => $duser->userid,
                                'username' => $request->get('setusername'),
                                'status' => 2,
                                'mobileno' => $devicemobileno,
                                'expirydate' => $request->get('setuserexpiry'),

                              ];
                              DB::table('deviceusers')->where('userid',$duser->userid)->update($data);
                            }

                               // echo "user already set in device";

                          }else{

                            // $data = [

                            //     'userrefid' => $duser->userid,
                            //     'userid' => $duser->userid,
                            //     'username' => $request->get('setusername'),
                            //     'status' => 2,
                            //     'mobileno' => $devicemobileno,
                            //     'expirydate' => $request->get('setuserexpiry'),

                            //   ];
                            //   DB::table('deviceusers')->insert($data);

                          }

          $setuserexpiry = $request->get('setuserexpiry');

              try {

                 $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();

                    $url = 'http://'.$deviceinfo->ipaddress.'';

                    //Your username.
                    $username = 'admin';

                    //Your password.
                    $password = 'admin';

                    // $test = get_headers($url);
                    //  $test = 'connected';

                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$duser->userid.'&name='.$susername.'&ref-user-id='.$duser->userid.'&user-active='.$setuserstatus.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = explode('=', $response);

                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);

                    if ($response[1] == 0) {

                      // return response()->with('message','ok');
                      echo "User Set Success In Device Plese Go To Enroll User and Put Your RFID Card Near To Reader !";

                      $data = [

                                'userrefid' => $duser->userid,
                                'userid' => $duser->userid,
                                'username' => $request->get('setusername'),
                                'status' => 2,
                                'mobileno' => $devicemobileno,
                                'expirydate' => $request->get('setuserexpiry'),

                              ];
                              DB::table('deviceusers')->insert($data);

                      $status = Deviceuser::where('userid',$en->userid)->update(['status' => 2,]);

                    }

                     // print_r($response);exit;

         } catch (\Exception $e) {

                echo "Your Device Not connected !";

        }



        // }
        //else{

      //     echo "asdf";

      // }

      // }


    }

    public function enrolluser(Request $request){

      $setuserid = $request->get('setuserid');
      $devicemobileno = $request->get('devicemobileno');
       $portno_const = config('constants.port');
      $duser = User::where('usermobileno',$devicemobileno)->get()->first();
      $en = Deviceuser::where('userid',$duser->userid)->get()->first();

       $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'insert';
           $action->action = 'Enroll Member into Device';
           $action->action_on = $duser->userid;
           $action->save();

      if ($en){
      if ($en->enroll == 0) {

        try {

          $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                     // print_r($url);exit;
                    //Your username.
                    $username = 'admin';

                    //Your password.
                    $password = 'admin';

                    // $test = get_headers($url);
                    //  $test = 'connected';

                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/enrolluser?action=enroll&pdid=3&user-id='.$duser->userid.'&type=1');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = explode('=', $response);

                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);


                    if ($response['1'] == 0) {

                      // curl_setopt($ch, CURLOPT_URL,'http://192.168.1.50/device.cgi/users?action=get&user-id='.$setuserid.'');
                      // $response = curl_exec($ch);
                      // print_r($response);exit;
                      // if () {
                      //   # code...
                      // }
                      // $d = ['enroll' => 1,];

                      // $n = Deviceuser::where('userid',$setuserid)->update($d);
                      echo "User Enroll Success In Device";

                      $status = Deviceuser::where('userid',$en->userid)->update(['status' => 3,]);

                     }
                      //else{

                    //   echo "Plese Connect Your Device !";

                    // }

                     // print_r($response);exit;

         } catch (\Exception $e) {

                //$test = 'Disconnected';
                 echo "Your Device Not connected !";

        }

      }else{

          echo "User Already Enrolled !";

      }

    }

    }

    public function enrollcard(Request $request){

      $setuserid = $request->input('setuserid');
      $devicemobileno = $request->get('devicemobileno');
       $portno_const = config('constants.port');
      $duser = User::where('usermobileno',$devicemobileno)->get()->first();
      $en = Deviceuser::where('userid',$duser->userid)->get()->first();

       $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'insert';
           $action->action = 'Enroll Card into Device';
           $action->action_on = $duser->userid;
           $action->save();

       try {
                    $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;


                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=get&user-id='.$duser->userid.'&format=xml');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                   // print_r($response);exit;

                     $xml_file = simplexml_load_string($response);
                     $json = json_encode($xml_file);
                    $array = json_decode($json,TRUE);


                    $cuserdata = [
                                    'userid' => $array['user-id'],
                                    'rfidcardno1'   => $array['card1'],
                                  ];


                    DB::table('deviceusers')->where('userid',$duser->userid)->update($cuserdata);

                    $rfidcard = DB::table('rfid')->where('userid',$duser->userid)->get()->all();

                    if ($rfidcard) {
                      DB::table('rfid')->where('userid',$duser->userid)->update($cuserdata);
                    }else{
                    DB::table('rfid')->insert($cuserdata);
                        }
                    if ($response['1'] == 0) {

                      echo "enroll card Successfully and id is :";

                      $status = Deviceuser::where('userid',$en->userid)->update(['status' => 4,]);

                      }

                     // print_r($response);exit;

         } catch (\Exception $e) {

                echo "User Already Enrolled !";

        }

      echo $setuserid;

    }


    public function userfetchlogs(Request $request){

      $userfetchlogsm = $request->get('userfetchlogs');

      $deviceuserm = User::where('usermobileno',$userfetchlogsm)->first();

       // dd($deviceuserm);

      if (!empty($deviceuserm)) {

         $uflall = DeviceFetchlogs::where('detail1',$deviceuserm->userid)->get()->all();

        $dateresult = DB::select(DB::raw("select distinct date from devicefetchlogs where detail1=".$deviceuserm->userid.""));
        $row1=array();
        foreach ($dateresult as $key) {
          $row1[]=$key->date;
        }
        // dd($row1);
        $idsmin=array();
        $idsmax=array();
        for($i=0;$i<count($row1);$i++)
        {

          // dd($deviceuserm->userid);


          $resultmax=DB::select(DB::raw("SELECT MAX( CAST( `deviceeventid` AS UNSIGNED) ) as maxid FROM `devicefetchlogs` WHERE `date` = '".$row1[$i]."' AND `detail1` = '".$deviceuserm->userid."'"));

          // dd($resultmax);
          $resultmin=DB::select(DB::raw("SELECT Min( CAST( `deviceeventid` AS UNSIGNED) ) as maxid FROM `devicefetchlogs` WHERE `date` = '".$row1[$i]."' AND `detail1` = '".$deviceuserm->userid."'"));
            foreach ($resultmax as $key) {
              $idsmax[]=$key->maxid;
            }
            // dd($idsmax);
            foreach ($resultmin as $key) {
              $idsmin[]=$key->maxid;
            }
        }




        $result1min=DB::select(DB::raw("select * from devicefetchlogs where deviceeventid IN(".implode(',', $idsmin).")"));
  // DB::enableQueryLog();
         $result1max=DB::select(DB::raw("select * from devicefetchlogs where deviceeventid IN(".implode(',', $idsmax).")"));
         // dd(DB::getQueryLog());
        // print_r($result1max);
        // print_r($result1min);
        // exit;


        //         echo json_encode($resultSet);
        //         exit;

      //   foreach ($uflall as $all) {

      //     // $all = $all->count($all->date);

      //     $mindate = DeviceEvent::where('detail1',$deviceuserm->userid)->select('date')->min('date');
      //     $maxdate = DeviceEvent::where('detail1',$deviceuserm->userid)->select('date')->max('date');

      //     if ($all->date  == $mindate) {

      //       echo "string";

      //     }else{
      //       echo "differ";
      //     }
      //      print_r($all);
      //   }
      //    exit;

      // $uflfirst = DeviceEvent::where('detail1',$deviceuserm->userid)->where('eventid',101)->get()->first();

      // $ufllast = DeviceEvent::where('detail1',$deviceuserm->userid)->where('eventid',101)->get()->last();
                $arr = array();
                $arr[0]=['checkin' => $result1min ,'checkout' => $result1max];
                echo json_encode($arr);


       // if ($uflfirst->date == $ufllast->date) {
       //  $arr = array();
       //  // print_r($arr[2] = "dsdvb");
       //  $arr[0]=['checkin' => $uflfirst ,'checkout' => $ufllast];
       //  // $arr[1]=  $ufllast;
       //  echo json_encode($arr);

       //  }else{

       //    $arr = array();

       //    $arr[1]=['checkin' => $uflfirst ,'checkout' => $ufllast];

       //  echo json_encode($arr);

       //  }

      }
       // print_r($ufllast->date);exit;


      // echo json_encode($ufllast);

    }

    public function reassigncard(Request $request){

      $setuserid = $request->get('setuserid');
      $devicemobileno = $request->get('devicemobileno');
       $portno_const = config('constants.port');
      $duser = User::where('usermobileno',$devicemobileno)->get()->first();
      $en = Deviceuser::where('userid',$duser->userid)->get()->first();

       $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'insert';
           $action->action = 'Reassign Card into Device';
           $action->action_on = $duser->userid;
           $action->save();

         try {

          $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();

                    $url = 'http://'.$deviceinfo->ipaddress.'';

                    $username = 'admin';
                    $password = 'admin';

                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$duser->userid.'&card1=0');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = explode('=', $response);

                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);


                    if ($response['1'] == 0) {

                      // curl_setopt($ch, CURLOPT_URL,'http://192.168.1.50/device.cgi/users?action=get&user-id='.$setuserid.'');
                      // $response = curl_exec($ch);
                      // print_r($response);exit;
                      // if () {
                      //   # code...
                      // }
                      // $d = ['enroll' => 1,];

                      // $n = Deviceuser::where('userid',$setuserid)->update($d);
                      //echo "User Enroll Success In Device";

                     }


         } catch (\Exception $e) {


                 echo "Your Device Not connected !";

        }

    }

    public function setvaliditytodevice(Request $request){

      $id = $request->get('id');
      $devicemobileno = $request->get('devicemobileno');
      $memberpackages = Memberpackages::where('userid',$id)->max('expiredate');

      $newdate = explode('-', $memberpackages);
      // dd($newdate);
      $portno_const = config('constants.port');

      $action = new Actionlog();
      $action->user_id = session()->get('admin_id');
      $action->ip = $request->ip();
      $action->action_type = 'update';
      $action->action = 'change package expiry From Member Profile';
      $action->action_on = $id;
      $action->save();
      //dd($portno_const);

      $deviceinfo = DB::table('deviceinfo')
      ->where('devicetype','independent')
      ->where('portno', $portno_const)
      ->first();
      $url = 'http://'.$deviceinfo->ipaddress.'';

      $username = $deviceinfo->username;
      $password = $deviceinfo->password;

      $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$id.'&ref-user-id='.$id.'&validity-enable=1&validity-date-dd='.$newdate[2].'&validity-date-mm='.$newdate[1].'&validity-date-yyyy='.$newdate[0].'';


      $data = ['api' => $api, 'status'=> 0, 'apiuserid' => $id, 'apitype' => 'Extend Expiry From Member Profile', 'response_code' => 0];

      ApiCronJob::insert($data);


    }

    public function deactivedeviceuser(Request $request){

      $setuserid = $request->get('setuserid');
      $devicemobileno = $request->get('devicemobileno');
       $portno_const = config('constants.port');

      $duser = User::where('usermobileno',$devicemobileno)->get()->first();
      $en = Deviceuser::where('userid',$duser->userid)->get()->first();


      $newdate =  date("Y-m-d");
      $newdate = explode('-', $newdate);

           $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'update';
           $action->action = 'Deactive User';
           $action->action_on = $duser->userid;
           $action->save();

          try {

           $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;

                    // dump($url);

           $member_api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$duser->userid.'&ref-user-id='.$duser->userid.'&validity-enable=1&validity-date-dd='.$newdate[2].'&validity-date-mm='.$newdate[1].'&validity-date-yyyy='.$newdate[0].'';

           $cronjob = new ApiCronJob();
           $cronjob->apiuserid= $duser->userid;
           $cronjob->apitype= 'deactive member';
           $cronjob->api= $member_api;
           $cronjob->response_code= 0;
           $cronjob->status= 0;
           $cronjob->save();

           $admin = session()->get('username');
            $actionbyid=Session::get('employeeid');
           Notify::create([
            'userid' =>  $duser->userid,
            'details' => 'Deactivated by '.$admin,
               'actionby' =>$actionbyid,


           ]);

           $status = Deviceuser::where('userid',$en->userid)->update(['status' => 0,]);
           echo "User Deactiveted !";

         } catch (\Exception $e) {


                echo "Your Device Not connected !";


        }

    }

    public function activedeviceuser(Request $request){
       $portno_const = config('constants.port');
      $setuserid = $request->get('setuserid');
      $devicemobileno = $request->get('devicemobileno');

      $duser = User::where('usermobileno',$devicemobileno)->get()->first();
      $en = Deviceuser::where('userid',$duser->userid)->get()->first();

      $memberpackages_data = MemberPackages::where('userid', $duser->userid)->where('status', 1)->max('expiredate');

      $newdate =  $request->get('activuserdate');
      $newdate = explode('-', date('Y-m-d', strtotime($memberpackages_data)));

       $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'update';
           $action->action = 'Device User Active';
           $action->action_on = $duser->userid;
           $action->save();

          try {

           $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();


                    $url = 'http://'.$deviceinfo->ipaddress.'';
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;


                    $member_api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$duser->userid.'&ref-user-id='.$duser->userid.'&validity-enable=1&validity-date-dd='.$newdate[2].'&validity-date-mm='.$newdate[1].'&validity-date-yyyy='.$newdate[0].'';

                   $cronjob = new ApiCronJob();
                   $cronjob->apiuserid= $duser->userid;
                   $cronjob->apitype= 'active member';
                   $cronjob->api= $member_api;
                   $cronjob->response_code= 0;
                   $cronjob->status= 0;
                   $cronjob->save();

                   $admin = session()->get('username');
                   $actionbyid = session()->get('employeeid');
                  Notify::create([
                    'userid' =>  $duser->userid,
                    'details' => 'Activated by '.$admin,
                       'actionby' =>$actionbyid,
                  ]);



                   $status = Deviceuser::where('userid',$en->userid)->update(['status' => 3,]);
                   $empstatus = Employee::where('mobileno',$devicemobileno)->update(['status' => 1,]);
                   echo "User Activeted !";



         } catch (\Exception $e) {


                 echo "Your Device Not connected !";

        }

    }

    public function sendotptoadminforpackagedate(Request $request){

    $admin_id = $_REQUEST['admin_id'];

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
      $last_id = DB::getPdo()->lastInsertId();

      $action = new Actionlog();
      $action->user_id = session()->get('admin_id');
      $action->ip = $request->ip();
      $action->action_type = 'resend';
      $action->action = 'OTP';
      $action->action_on = $last_id;

      $action->save();

      $msg=   DB::table('messages')->where('messagesid','22')->get()->first();
      $fname = 'hello';
      $lname = 'hello';
      $msg =$msg->message;
      $msg = str_replace("[FirstName]",ucfirst($fname),$msg);
      $msg= str_replace("[LastName]",ucfirst($lname),$msg);
      $msg= str_replace("[otp]",$rndno,$msg);
      $msg2 = $msg;
      $msg = urlencode($msg);

$otpsend = '';
$success = '';
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
                  $action->subject = 'Package Extend Message';
                  $action->save();
              }

      // $otpsend = Curl::to('http://sms.weybee.in/api/sendapi.php?auth_key=2169KrEMnx2ZgAqSfavSSC&mobiles='.$mobileno.'&message='.$msg.'&sender=PYOFIT&route=4')->get();

      if (strpos($otpsend, '"ErrorCode":"000"') !== false) {
          $success = true;
      }
      if($success == true){
        return response()->json($success);
      }


  }
public function sendotp(Request $request){
   $admin_id = $_REQUEST['admin_id'];
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
      $last_id = DB::getPdo()->lastInsertId();
      $action = new Actionlog();
      $action->user_id = session()->get('admin_id');
      $action->ip = $request->ip();
      $action->action_type = 'resend';
      $action->action = 'OTP';
      $action->action_on = $last_id;
      $action->save();
      $otpsend='';
      $success='';
      $msg= DB::table('messages')->where('messagesid','22')->get()->first();

      $msg =$msg->message;
      $msg = str_replace("[FirstName]",ucfirst($fname),$msg);
      $msg= str_replace("[LastName]",ucfirst($lname),$msg);
      $msg= str_replace("[otp]",$rndno,$msg);
      $msg = urlencode($msg);
      $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

      if ($smssetting) {

      $u = $smssetting->url;
      $url= str_replace('$mobileno', $mobileno, $u);
      $url=str_replace('$msg', $msg, $url);
      $otpsend = Curl::to($url)->get();


      }

      if (strpos($otpsend, '"ErrorCode":"000"') !== false) {
              $success = true;
          }
      if($success == true){
          return response()->json($success);
      }
 }

}
