<?php

namespace App\Http\Controllers\sms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\User;
use App\Message;
use DB;
use Session;

use App\RootScheme;
use App\Scheme;
use App\ExerciseLevel;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\Actionlog;
use App\Member;
use Carbon\Carbon;
use App\MemberPackages;
use App\Payment;
use App\Notification;
use Curl;
use App\Notificationmsgdetails;
use App\Emailnotificationdetails;
use App\Smssetting;
use App\Inquiry;
use App\Emailsetting;
use App\Registration;
use App\RegPaymentMaster;

class NotificationController extends Controller
{
    //

    public static function instance(){
        return new NotificationController();
    }

    public function index(){


        $msg = Message::all();

        // print_r($msg);exit;

        return view('admin.sms.addsms',compact('msg'));
        //return redirect('addsms');

    }

    public function getsmsdata(Request $request){

        $msgid = $request->get('msgid');

        $msg = Message::where('messagesid',$msgid)->first();

        echo json_encode($msg);

        // return $msg;

    }


    public function editsmsdata(Request $request){

        $msgid = $request->get('msgid');
        $msgtext = $request->get('msgtext');
        $smscheck = $request->get('smscheck');
         // print_r($smscheck);exit;

        $msg = DB::table('messages')
                ->where('messagesid',$msgid)
                ->update(['message' => $msgtext]);

        echo $msg;

    }

    public function sendsms(Request $request){

        $rootscheme = RootScheme::where('status',1)->get()->all();
        $scheme = Scheme::where('status',1)->where('validity' ,'>=',date('Y-m-d') )->get()->all();
        $tags = ExerciseLevel::all();
      $message = Message::where('editablestatus',1)->get()->all();
        // dd($rootscheme);

        return view('admin.sms.sendsms',compact('rootscheme','scheme','tags','message'));
    }

    public function addnewtemplate(Request $request){

        if($request->isMethod('post'))
        {

            $v = $request->validate([
                'smstxt' => 'required',
                'smstemplate' => 'required',
              ]);

            $data = [
                'message'  => $request->get('smstxt'),
                'subject'  => $request->get('smstemplate'),
                'type'     => '3',
                'sms'      => $request->get('sms'),
                'email'    => $request->get('email'),
          'editablestatus' => '1',
            ];

            // dd($data);


              $msg = Message::insert($data);

              $action = new Actionlog();
              $action->user_id = session()->get('admin_id');
              $action->ip = $request->ip();
              $action->action_type = 'insert';
              $action->action = 'Add New sms Template';
              $action->save();

            return redirect('editsms')->with('message','Message Template Successfully Added');

        }

        return view('admin.sms.addsmstemplate');

    }

    public function editsms(Request $request){

        $msg = Message::get()->all();

        if ($request->isMethod('post')) {

            $messagestemplate = $request->get('messagestemplate');
            $textareasms = $request->get('textareasms');

             $v = $request->validate([
                'messagestemplate' => 'required',
                'textareasms' => 'required',
              ]);


            if ($request->get('sms') == null) {
               $sms = '0';

            }else{
                $sms = $request->get('sms');

            }

            if ($request->get('email') == null ) {
               $email = '0';
            }else{
                $email = $request->get('email');
            }


            $data =  [
                        'message' => $textareasms,
                        'sms'      => $sms,
                        'email'    => $email,
                    ];



            DB::table('messages')->where('messagesid',$messagestemplate)->update($data);


              $action = new Actionlog();
              $action->user_id = session()->get('admin_id');
              $action->ip = $request->ip();
              $action->action_type = 'update';
              $action->action = 'Edit sms Template';
              $action->action_on = $messagestemplate;
              $action->save();

            return redirect('editsms');

        }



        return view('admin.sms.editsms',compact('msg'));

    }


        public function mail()
            {
                //$user = User::find(1)->toArray();
                $title = "Test";

                Mail::send('admin.name', ['title' => $title],function($message)  {
                    $message->from('rohit@weybee.com', 'Test');
                    $message->to('harshvegad33@gmail.com');
                    $message->subject('E-Mail Example');
                });


                 return response()->json(['message' => 'Request completed']);
            }

    public function reminder(Request $request){

            $todays =  Carbon::now()->toDateString();
            $member = Member::get()->all();
            $today =  Carbon::now();

            $bithday_msg = Message::where('messagesid','3')->get()->first();
            $anniversary_msg= Message::where('messagesid','4')->get()->first();
            $duedate_msg = Message::where('messagesid','19')->get()->first();
            $package_expiry_msg= Message::where('messagesid','21')->get()->first();

            $bithday_msg = $bithday_msg->message;
            $anniversary_msg = $anniversary_msg->message;
            $package_expiry_msg = $package_expiry_msg->message;
            $duedate_msg = $duedate_msg->message;
 DB::enableQueryLog();


            $memberpackage = MemberPackages::leftjoin('member','member.userid','=','memberpackages.userid')
                            ->join('notification','notification.mobileno','=','member.mobileno')
                            ->join('schemes','memberpackages.schemeid','=','schemes.schemeid')
                            ->whereIn('memberpackages.status',[1,3])
                            // ->whereDate('memberpackages.expiredate', '', $todays)
                            ->select('memberpackages.*','member.*','schemes.*','member.mobileno as mmobileno','notification.*','member.email as memail')
                            ->get()
                            ->all();

                             // dd($memberpackage);

            $emailsetting =  Emailsetting::where('status',1)->get()->first();

        foreach ($memberpackage as  $mp) {

                $datetime1 = date_create($todays);
                $datetime2 = date_create($mp->expiredate);
                $interval = date_diff($datetime1, $datetime2);
                 $interval = $interval->format('%R%a');
                 echo "".$interval."<br/>";


                     $fname = $mp->firstname;
                     $lname = $mp->lastname;
                     $mobileno = $mp->mobileno;
                     $date = $mp->expiredate;
                     $dnd  = $mp->sms;
                     $dndmpemail = $mp->memail;
                     $packagename = $mp->schemename;


                    $package_expiry_msg2 = str_replace(array('[FirstName]','[LastName]','[packgename]','[date]'),array($fname, $lname,$packagename,$date),$package_expiry_msg);

                   $package_expiry2 = $package_expiry_msg2;

                if ($interval == -2 || $interval == -1 || $interval == 0 || $interval == 1 || $interval == 2 || $interval == 3 || $interval == 7) {

                    $package_expiry = urlencode($package_expiry_msg2);

                    if ($mp->sms == 1) {


                        $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->get()->first();


                         if ($smssetting) {

                              $u = $smssetting->url;
                              $url= str_replace('$mobileno', $mobileno, $u);
                              $url=str_replace('$msg', $package_expiry, $url);

                               //  print_r($url);echo "<br/>";

                               $otpsend = Curl::to($url)->get();

                              $action = new Notificationmsgdetails();
                              $action->user_id = session()->get('admin_id');
                              $action->mobileno = $mobileno;
                              $action->smsmsg = $package_expiry2;
                              $action->smsrequestid = $otpsend;
                              $action->subject = 'Package Expiry Message By System Before '.$interval.' days';
                              $action->save();

                          }
                       }


                    if ($emailsetting) {
                        if ($dndmpemail) {
                          if ($mp->email == 1) {

                                 $data = [
                                                 //'data' => 'Rohit',
                                                 'msg' => $package_expiry2,
                                                 'mail'=> $dndmpemail,
                                                 'subject' => $emailsetting->hearder,
                                                 'senderemail'=> $emailsetting->senderemailid,
                                              ];

                                        // print_r($data);echo "<br/>";

                                        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                                              $message->from($data['senderemail'], 'Package Expiry Message');
                                              $message->to($data['mail']);
                                              $message->subject($data['subject']);

                                        });

                                        $action = new Emailnotificationdetails();
                                        $action->user_id = session()->get('admin_id');
                                        $action->mobileno = $mobileno;
                                        $action->message = $package_expiry2;
                                        $action->emailform = $data['senderemail'];
                                        $action->emailto = $data['mail'];
                                        $action->subject = $data['subject'];
                                        $action->messagefor = 'Package Expiry Mail By System Before '.$interval.' Days';
                                        $action->save();

                         }
                      }
                   }

               }

            }



                $due = Payment::join('member','member.userid','=','payments.userid')
                        ->join('notification','notification.mobileno','=','member.mobileno')->where('payments.duedate','!=',null)->where('payments.schemeid','!=',0)
                        ->select(DB::raw('MAX(paymentid) as pid'))
                        ->groupBy('payments.userid')
                        ->get()
                        ->all();

                   // dd($due);

                $pid=array();

                for($i=0;$i<count($due);$i++)
                {
                    $pid[]=$due[$i]['pid'];
                }
                // $pids= implode(',',$pid);
                 // dd($pid);
                // DB::enableQueryLog();
                $due = Payment::leftjoin('member','member.userid','=','payments.userid')
                        ->join('notification','notification.mobileno','=','member.mobileno')

                         ->join('schemes','payments.schemeid','=','schemes.schemeid')
                        ->select('payments.*','member.email as memail','member.*','notification.*')
                        ->whereIn('payments.paymentid',$pid)
                        // ->whereDate('payments.duedate', '>=', $todays)
                        ->where('duedate','!=',null)
                        ->where('payments.schemeid','!=',0)
                        ->get()
                        ->all();
  // dd(DB::getQueryLog());
                 // dd($due);

     // print_r( DB::getQueryLog());

                        // dd($due);


            foreach ($due as $u) {

                         // print_r($u->sms);

                     $datetime1 = date_create($todays);
                     $datetime2 = date_create($u->duedate);
                     $interval = date_diff($datetime1, $datetime2);
                     $interval = $interval->format('%R%a');


                     $fname = $u->firstname;
                     $lname = $u->lastname;
                     $mobileno = $u->mobileno;
                     $date = $u->duedate;
                     $dnd  = $u->sms;
                     $dndemail = $u->email;
                     $membermail = $u->memail;
                     $amount = $u->remainingamount;
                     $packagename = $u->schemename;
                     $pkgassigndate = $u->date;



                     $duedate_msg_2 = str_replace(array('[FirstName]','[LastName]','[packgename]','[date_of_packge_assign]','[amount]','[date]'),array($fname, $lname, $packagename, $pkgassigndate, $amount, $date) ,$duedate_msg);
                          echo "".$interval."<br>";

                     if ($interval == -2 || $interval == -1 || $interval == 0 || $interval == 1 || $interval == 2 || $interval == 3 || $interval == 7) {

                         $duedate_msg_send = urlencode($duedate_msg_2);

                           // print_r($duedate_msg_send); echo "<br/>";echo "<br/>";

                        if ($u->sms == 1) {


                         $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

                         if ($smssetting) {

                              $u = $smssetting->url;
                              $url= str_replace('$mobileno', $mobileno, $u);
                              $url=str_replace('$msg', $duedate_msg_send, $url);

                               // print_r($url); echo "<br/>";echo "<br/>";


                              $otpsend = Curl::to($url)->get();

                              $action = new Notificationmsgdetails();
                              $action->user_id = session()->get('admin_id');
                              $action->mobileno = $mobileno;
                              $action->smsmsg = $duedate_msg_2;
                              $action->smsrequestid = $otpsend;
                              $action->subject = 'DueDate Message By System Befor '.$interval.' days';
                              $action->save();

                            }
                        }


                      if ($emailsetting) {
                        if ($dndemail) {
                          if ($dndemail == 1) {

                                 $data = [
                                                 //'data' => 'Rohit',
                                                 'msg' => $duedate_msg_2,
                                                 'mail'=> $membermail,
                                                 'subject' => $emailsetting->hearder,
                                                 'senderemail'=> $emailsetting->senderemailid,
                                              ];

                                        // print_r($data);echo "<br/>";

                                        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                                              $message->from($data['senderemail'], 'DueDate Message');
                                              $message->to($data['mail']);
                                              $message->subject($data['subject']);

                                        });

                                        $action = new Emailnotificationdetails();
                                        $action->user_id = session()->get('admin_id');
                                        $action->mobileno = $mobileno;
                                        $action->message = $duedate_msg_2;
                                        $action->emailform = $data['senderemail'];
                                        $action->emailto = $data['mail'];
                                        $action->subject = $data['subject'];
                                        $action->messagefor = 'DueDate Expiry Mail By System Before '.$interval.' Days';
                                        $action->save();

                         }
                      }
                   }
                }
             }


    $member_birthday =Member::leftjoin('notification','notification.mobileno','=','member.mobileno')
                        ->where('member.status',1)
                        ->select('member.status','member.anniversary','member.birthday','notification.sms','notification.email','member.email as memail','member.firstname','member.lastname','member.mobileno')
                        ->whereDay('birthday','=',$today->format('d'))
                        ->whereMonth('birthday','=',$today->format('m'))
                        ->get()
                        ->all();
                        // dd($member_birthday);

    $member_anniversary =Member::leftjoin('notification','notification.mobileno','=','member.mobileno')
                        ->where('member.status',1)
                        ->select('member.status','member.anniversary','member.birthday','notification.sms','notification.email','member.email as memail','member.firstname','member.lastname','member.mobileno')
                        ->whereDay('member.anniversary','=',$today->format('d'))
                        ->whereMonth('member.anniversary','=',$today->format('m'))
                        ->get()
                        ->all();
                         // dd($member_anniversary);


     $msg= DB::table('messages')->where('messagesid','3')->get()->first();

            if ($member_birthday) {

                foreach ($member_birthday  as  $mb) {


                    $fname = $mb->firstname;
                    $lname = $mb->lastname;
                    $mobileno = $mb->mobileno;
                    $bemail = $mb->memail;

                    $bithday_msg_new =$msg->message;
                    $bithday_msg_new = str_replace("[FirstName]",$fname,$bithday_msg_new);
                    $bithday_msg_new= str_replace("[LastName]",$lname,$bithday_msg_new);
                    $bithday_msg_new2 = $bithday_msg_new;
                    $bithday_msg_new = urlencode($bithday_msg_new);

                    // print_r($bithday_msg_new2);echo "<br/>";


                    if ($mb->sms == 1) {

                        $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

                        if ($smssetting) {

                        $u = $smssetting->url;
                        $url= str_replace('$mobileno', $mobileno, $u);
                        $url=str_replace('$msg', $bithday_msg_new, $url);

                        // print_r($url);echo "<br/>";

                        $otpsend = Curl::to($url)->get();

                        $action = new Notificationmsgdetails();
                        $action->user_id = session()->get('admin_id');
                        $action->mobileno = $mobileno;
                        $action->smsmsg = $bithday_msg_new2;
                        $action->smsrequestid = $otpsend;
                        $action->subject = 'Bithday Massage';
                        $action->save();
                    }
                  }

                    // print_r($mb->memail);echo "<br/>";

                    if ($mb->email == 1) {

                        $data = [
                                 //'data' => 'Rohit',
                                 'msg' => $bithday_msg_new2,
                                 'mail'=> $bemail,
                                 'subject' => $emailsetting->hearder,
                                 'senderemail'=> $emailsetting->senderemailid,
                              ];


                        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                              $message->from($data['senderemail'], 'Birthday Message');
                              $message->to($data['mail']);
                              $message->subject($data['subject']);

                        });

                        $action = new Emailnotificationdetails();
                        $action->user_id = session()->get('admin_id');
                        $action->mobileno = $mobileno;
                        $action->message = $bithday_msg_new2;
                        $action->emailform = $data['senderemail'];
                        $action->emailto = $data['mail'];
                        $action->subject = $data['subject'];
                        $action->messagefor = 'Birthday Message By System';
                        $action->save();

                    }

            }

        }


    $msg= DB::table('messages')->where('messagesid','4')->get()->first();

            if ($member_anniversary) {

                foreach ($member_anniversary  as  $ma) {

                     $fname = $ma->firstname;
                     $lname = $ma->lastname;
                     $mobileno = $ma->mobileno;
                     $aemail = $ma->memail;

                     // print_r($ma->firstname);echo "<br/>";


                    $anniversary_msg_new =$msg->message;
                    $anniversary_msg_new = str_replace("[FirstName]",$fname,$anniversary_msg_new);
                    $anniversary_msg_new= str_replace("[LastName]",$lname,$anniversary_msg_new);
                    $anniversary_msg_new2 = $anniversary_msg_new;
                    $anniversary_msg_new = urlencode($anniversary_msg_new);

                    // print_r($anniversary_msg_new2);echo "<br/>";

                      //$bithday_msg_new = str_replace("[FirstName]",$fname,$bithday_msg);
                      //$bithday_msg_new2 = str_replace("[LastName]",$lname,$bithday_msg_new);
                     // $anniversary_msg_new = str_replace(array('[FirstName]','[LastName]'),array($fname, $lname),$anniversary_msg);

                    // $anniversary_encode =  urlencode($anniversary_msg_new);

                    if ($ma->sms == 1) {

                        // print_r($mobileno);

                        $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
                        if ($smssetting) {
                        $u = $smssetting->url;
                        $url= str_replace('$mobileno', $mobileno, $u);
                        $url=str_replace('$msg', $anniversary_msg_new, $url);

                        print_r($url);echo "<br/>";

                        $otpsend = Curl::to($url)->get();

                        $action = new Notificationmsgdetails();
                        $action->user_id = session()->get('admin_id');
                        $action->mobileno = $mobileno;
                        $action->smsmsg = $anniversary_msg_new2;
                        $action->smsrequestid = $otpsend;
                        $action->subject = 'Anniversary Message By System';
                        $action->save();

                    }

                  }

                    if ($ma->email == 1) {

                        $data = [
                                 //'data' => 'Rohit',
                                 'msg' => $anniversary_msg_new2,
                                 'mail'=> $aemail,
                                 'subject' => $emailsetting->hearder,
                                 'senderemail'=> $emailsetting->senderemailid,
                              ];

                        // print_r($data);

                        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                              $message->from($data['senderemail'], 'Anniversary Message');
                              $message->to($data['mail']);
                              $message->subject($data['subject']);

                        });

                        $action = new Emailnotificationdetails();
                        $action->user_id = session()->get('admin_id');
                        $action->mobileno = $mobileno;
                        $action->message = $anniversary_msg_new2;
                        $action->emailform = $data['senderemail'];
                        $action->emailto = $data['mail'];
                        $action->subject = $data['subject'];
                        $action->messagefor = 'Anniversary Message By System';
                        $action->save();

                    }

                }

            }
        }

        public function fetchsmslog(Request $request){

                   $sms = '';
                   $email = '';
                   $logs ='';
                   $alllogs = array();


                if ($request->isMethod('post')) {

                   $logs = $request->input('logs');


                   if ($logs == "") {
                      return redirect('fetchsmslogs');
                   }

                   if ($logs == 'sms') {

                        $alllogs = Notificationmsgdetails::orderBy('notoficationmsgdetailsid', 'DESC')->paginate(20);


                   }

                   if ($logs == 'email') {

                       $alllogs = Emailnotificationdetails::orderBy('emailnotificationdetailsid', 'DESC')->paginate(20);


                   }

                   return view('admin.sms.fetchsmslogs',compact('alllogs','logs'));

                }

            return view('admin.sms.fetchsmslogs',compact('sms','email','logs','alllogs'));

         }

        public function sendinquirysms(Request $request){

          $messagetemp = Message::where('editablestatus',1)->get()->all();
          $query1 = '';

          if ($request->isMethod('post')) {


            $istatus = $request->get('istatus');
            $rattingstatus = $request->get('rattingstatus');
            $fdate = $request->get('fdate');
            $tdate = $request->get('tdate');

            $smsmale = $request->get('smsmale');
            $smsfemale = $request->get('smsfemale');
            $selectedmsgid = $request->get('msgid');
            $selectedmsg = $request->get('textareasms');





               // print_r($istatus);echo "<br/>";exit;
             // print_r($rattingstatus);echo "<br/>";
            // print_r($fdate);echo "<br/>";
              // print_r($selectedmsgid);echo "<br/>";

              // if (!empty($selectedmsgid)) {
              //   echo "string";
              // }

              // exit;



            // if ($istatus != '' || $rattingstatus != '' || $fdate != '' || $tdate != '' || $smsmale == true || $smsfemale == true) {

              if (!empty($istatus) || !empty($rattingstatus) || !empty($fdate) || !empty($tdate) || !empty($smsmale) || !empty($smsfemale)) {

              // $istatus = array($istatus);

                // dd($smsmale);

              $action = new Actionlog();
              $action->user_id = session()->get('admin_id');
              $action->ip = $request->ip();
              $action->action_type = 'send sms';
              $action->action = 'Send Custom Inquiry SMS';
              $action->save();



                $querymax = Inquiry::leftjoin('followupcalldetails','inquiries.inquiriesid','=','followupcalldetails.inquiriesid')
                        ->leftjoin('notification','notification.mobileno','=','inquiries.mobileno')
                        ->select(DB::raw('MAX(followupcalldetailsid) as fid'))
                        ->groupBy('inquiries.inquiriesid')
                        ->get()
                        ->all();

  // dd($querymax);exit;

            $fid=array();

                for($i=0;$i<count($querymax);$i++)
                {
                  if($querymax[$i]['fid'] != '')
                  {
                    $fid[]=$querymax[$i]['fid'];
                  }
                }




           $query = DB::table('inquiries')
                  ->leftjoin('followupcalldetails','inquiries.inquiriesid','=','followupcalldetails.inquiriesid')
                  ->leftjoin('notification','notification.mobileno','=','inquiries.mobileno')
                  ->select('inquiries.*','followupcalldetails.*','notification.mobileno as nmb','notification.sms','notification.email as nemail')
                  ->whereIn('followupcalldetails.followupcalldetailsid',$fid);




                if (!empty($istatus)) {

                  // $istatus = implode(',', $istatus);

                     // print_r($istatus);exit;
                  $query->where(function($q) use ($istatus){
                    $q->whereIn('inquiries.status',$istatus);
                  });
                }

                if (!empty($rattingstatus)) {

                  // dd($rattingstatus[0]);
                  $query->where(function($q) use ($rattingstatus){
                    $q->whereIn('followupcalldetails.callrating',$rattingstatus);
                  });

                }

                if ($fdate != "") {

                    $from = date($fdate);
                    //$to = date($to);
                    if (!empty($tdate)) {
                        $to = date($tdate);
                    }else{
                        $to = date('Y-m-d');
                    }

                    $query->where(function($q) use ($fdate,$from,$to){
                      $q->whereBetween('inquiries.created_at',[$from,$to]);
                    });

                  }

                  if ($tdate != "") {

                              $to = date($tdate);

                              if (!empty($fdate)) {
                                  $from = date($fdate);
                              }else{
                                  $from = '';
                              }

                              $query->where(function($q) use ($tdate,$from,$to){
                                $q->whereBetween('inquiries.created_at',[$from,$to]);
                              });

                  }

                  if ($smsmale == 'male' && $smsfemale == 'female') {

            // $d = ['m' => 'Male','f'=>'Female'];

                    //$query->where('member.gender','Male')->orwhere('member.gender','Female');

                    $query->where(function($q) use ($smsmale,$smsfemale){
                        $q->where('inquiries.gender','male')
                          ->orwhere('inquiries.gender','female');
                    });


                      }else{

                           // dd($smsmale);
                      if ($smsmale == 'male') {

                                   $query->where('inquiries.gender','male');


                      }

                      if ($smsfemale == 'female') {

                                   $query->where('inquiries.gender','female');

                      }

                    }

                      // $query1 = $query->select('inquiries.*','followupcalldetails.*')->distinct()->get()->all();
                    $query1 = $query->distinct()->get('inquiries.mobileno')->all();
                  // $query1 = $query->get()->all();
                     // dd(DB::getQueryLog());


                     if (!empty($selectedmsg)) {

                      $q1 = array($query1,$selectedmsgid,$selectedmsg);

                       $this->sendsmsinquirytouser($q1);
                    }

               //      $msg = Message::where('messagesid',$selectedmsgid)->first();
               //      if ($msg) {

               //      // $msg = $msg->message;
               //      $msg = $selectedmsg;

               //      if (strpos($msg, '[FirstName]') !== false && strpos($msg, '[LastName]') !== false) {

               //      $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
               //      $emailsetting =  Emailsetting::where('status',1)->first();

               //  }

               //  // exit;

               //    if ($smssetting) {

               //      foreach ($query1 as $q) {

               //        $fname = $q->firstname;
               //        $lname = $q->lastname;
               //        $mobileno = $q->mobileno;
               //        $email = $q->email;

               //        if ($q->sms == 1) {

               //        $msg = str_replace("[FirstName]",$fname,$msg);
               //        $msg = str_replace("[LastName]",$lname,$msg);
               //        $msg2 = $msg;
               //        $msg = urlencode($msg);


               //         $u = $smssetting->url;
               //         $url= str_replace('$mobileno', $mobileno, $u);
               //         $url=str_replace('$msg', $msg, $url);

               //          $otpsend = Curl::to($url)->get();

               //        $action = new Notificationmsgdetails();
               //        $action->user_id = session()->get('admin_id');
               //        $action->mobileno = $mobileno;
               //        $action->smsmsg = $msg2;
               //        $action->smsrequestid = $otpsend;
               //        $action->subject = 'Send Custom Inquiry SMS';
               //        $action->save();

               //        }



               //      if ($q->nemail == 0) {

               //        $data = [
               //               //'data' => 'Rohit',
               //             'msg' => $msg2,
               //             'mail'=> $email,
               //             'subject' => $emailsetting->hearder,
               //             'senderemail'=> $emailsetting->senderemailid,
               //          ];

               //          Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

               //            $message->from($data['senderemail'], 'Send Custom Inquiry Mail');
               //            $message->to($data['mail']);
               //            $message->subject($data['subject']);

               //        });

               //          $action = new Emailnotificationdetails();
               //          $action->user_id = session()->get('admin_id');
               //          $action->mobileno = $mobileno;
               //          $action->message = $msg;
               //          $action->emailform = $data['senderemail'];
               //          $action->emailto = $data['mail'];
               //          $action->subject = $data['subject'];
               //          $action->messagefor = 'Send Custom Email';
               //          $action->save();

               //       }

               //      }

               //    }
               // }


                    // if (strpos($selectedmsg, '[FirstName]') !== false  && strpos($msg, '[FirstName]') !== false) {
                    //   $a = '[FirstName]';
                    // }
                    //  if (strpos($selectedmsg, '[LastName]') !== false && strpos($msg, '[LastName]') !== false) {
                    //   $b = '[LastName]';
                    // }
                    //  if (strpos($selectedmsg, '[Packge Name]') !== false && strpos($msg, '[Packge Name]') !== false) {

                    //      echo '<script type="text/javascript">alert("You Can Only Use [FirstName] And [LastName] PlaceHolders.");</script>';

                    // }
                    //  if (strpos($selectedmsg, '[Expiry date]') !== false && strpos($msg, '[Expiry date]') !== false) {
                    //   $d = '[Expiry date]';
                    // }
                    //  if (strpos($selectedmsg, '[Start date]') !== false && strpos($msg, '[Start date]') !== false) {
                    //   $e = '[Start date]';
                    // }

                    // print_r($c);

                    // if (strpos($msg, '[FirstName]') !== false) {

                    //   print_r($msg);
                    // }



                  //  if (strpos($msg, '[Packge Name]') == true || strpos($msg, '[Expiry date]') == true || strpos($msg, '[Start date]') == true) {

                  //   echo '<script type="text/javascript">alert("You Can Only Use [FirstName] And [LastName] PlaceHolders.");</script>';

                  // }

               return Redirect::back()->with(array('smsmale'=>$smsmale ,'istatus'=>$istatus ,'rattingstatus'=>$rattingstatus ,'fdate'=>$fdate ,'tdate'=>$tdate ,'smsmale'=>$smsmale ,'smsfemale'=>$smsfemale ,'query1' => $query1));


            }else{

              //echo '<script type="text/javascript">alert("Please Select Search Parameter");</script>';

              return Redirect::back()->withErrors('Please Select Search Parameter');

            }


          }
          return view('admin.sms.sendinquirysms',compact('messagetemp','query1'));

         }

        public function sendsmsinquirytouser($request){


          $msg = Message::where('messagesid',$request[1])->first();
                    // $msg = $selectedmsg;

                    if ($msg) {

                    // $msg = $msg->message;
                    $msg = $request[2];




                    if (strpos($msg, '[FirstName]') !== false && strpos($msg, '[LastName]') !== false) {

                    $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
                    $emailsetting =  Emailsetting::where('status',1)->first();

                }

                  if (!empty($smssetting)) {

                    foreach ($request[0] as $q) {


                      $fname = $q->firstname;
                      $lname = $q->lastname;
                      $mobileno = $q->mobileno;
                      $email = $q->email;

                      if (!empty($request[4])) {

                      if ($request[4] == "rrg") {
                        $email = $q->email_id;
                        $regmobileno = $q->phone_no;

                        // dd($email);
                        }
                       # code...
                      }

                    if (empty($request[4])) {
                      if ($q->sms == 1) {


                       $ismsg = str_replace(array("[FirstName]","[LastName]"),array($fname, $lname),$msg);

                       $msg2 = $msg;
                        // $msg = urlencode($ismsg);
                       // dump($msg);
                            // dump($msg);
                       $u = $smssetting->url;
                       $url= str_replace('$mobileno', $mobileno, $u);
                       $url=str_replace('$msg', $ismsg, $url);

                        // dump($url);
                        $url_send = str_replace(' ', '%20', $url);

                          $wp = $this->sendwhatsapp($mobileno,$msg2);
                          $otpsend=0;
                          $otpsend = Curl::to($url_send)->get();
                        // dd($otpsend);
                         // $dmsg = urldecode($msg);
                        // dump($msg);

                      $action = new Notificationmsgdetails();
                      $action->user_id = session()->get('admin_id');
                      $action->mobileno = $mobileno;
                      $action->smsmsg = $msg2;
                      $action->smsrequestid = $otpsend;
                      $action->subject = 'Send Custom Inquiry SMS';
                      $action->save();

                      }
                     }


                      if (!empty($request[4])) {

                      if ($request[4] == "rrg") {

                      $msg = str_replace("[FirstName]",$fname,$msg);
                      $msg = str_replace("[LastName]",$lname,$msg);
                      $msg2 = $msg;
                      $msg = urlencode($msg);
                          // dd($msg2);

                       $u = $smssetting->url;
                       $url= str_replace('$mobileno', $regmobileno, $u);
                       $url=str_replace('$msg', $msg, $url);

                          $wp = $this->sendwhatsapp($regmobileno,$msg2);
                          $otpsend=0;
                       $otpsend = Curl::to($url)->get();

                      $action = new Notificationmsgdetails();
                      $action->user_id = session()->get('admin_id');
                      $action->mobileno = $regmobileno;
                      $action->smsmsg = $msg2;
                      $action->smsrequestid = $otpsend;
                      $action->subject = 'Send Custom Registration SMS';
                      $action->save();

                        if (!empty($emailsetting)) {

                          if (!empty($email)) {

                                    $data = [
                                     //'data' => 'Rohit',
                                        'msg' => $msg2,
                                        'mail'=> $email,
                                        'subject' => $emailsetting->hearder,
                                        'senderemail'=> $emailsetting->senderemailid,
                                   ];

                         Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                          $message->from($data['senderemail'], 'Registration Mail');
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
                        $action->messagefor = 'Send Custom Email';
                        $action->save();

                        }
                     }
                    }
                   }else{

                    if (!empty($emailsetting)) {

                    if (!empty($email)) {

                    if ($q->nemail == 1) {

                      $data = [
                             //'data' => 'Rohit',
                           'msg' => $msg2,
                           'mail'=> $email,
                           'subject' => $emailsetting->hearder,
                           'senderemail'=> $emailsetting->senderemailid,
                        ];

                        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                          $message->from($data['senderemail'], 'Send Custom Inquiry Mail');
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
                        $action->messagefor = 'Send Custom Email';
                        $action->save();

                     }
                   }
                 }
                }
               }
              }
             }else{

                foreach($request[0] as $mdata){

                   $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
                   $emailsetting =  Emailsetting::where('status',1)->first();

                    if (!empty($request[4]) == 'rrg') {
                         $mobileno = $mdata->phone_no;
                         $email = $mdata->email_id;
                    }else{
                        $mobileno = $mdata->mobileno;
                        $email = $mdata->email;
                    }


                   $ismsg = str_replace(array("[FirstName]","[LastName]"),array($mdata->firstname, $mdata->lastname),$request[2]);
                   $msg2 = $ismsg;




                    if (!empty($request[4]) == 'rrg') {
                    if (!empty($smssetting)) {
                        $u = $smssetting->url;
                        $url= str_replace('$mobileno', $mobileno, $u);
                        $url=str_replace('$msg', $ismsg, $url);
                        $url_send = str_replace(' ', '%20', $url);

                        $wp = $this->sendwhatsapp($mobileno,$msg2);
                        $otpsend=0;
                        $otpsend = Curl::to($url_send)->get();

                        $action = new Notificationmsgdetails();
                        $action->user_id = session()->get('admin_id');
                        $action->mobileno = $mobileno;
                        $action->smsmsg = $msg2;
                        $action->smsrequestid = $otpsend;
                        $action->subject = 'Send Custom Register SMS';
                        $action->save();
                     }

                        if (!empty($emailsetting)) {

                          if (!empty($email)) {

                                    $data = [
                                     //'data' => 'Rohit',
                                        'msg' => $msg2,
                                        'mail'=> $email,
                                        'subject' => $emailsetting->hearder,
                                        'senderemail'=> $emailsetting->senderemailid,
                                   ];

                         Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                          $message->from($data['senderemail'], 'Registration Mail');
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
                        $action->messagefor = 'Send Custom Email';
                        $action->save();

                        }
                     }
                    }else{
                        if ($mdata->sms == 1) {
                            $u = $smssetting->url;
                            $url= str_replace('$mobileno', $mobileno, $u);
                            $url=str_replace('$msg', $ismsg, $url);
                            $url_send = str_replace(' ', '%20', $url);

                            $wp = $this->sendwhatsapp($mobileno,$msg2);
//                            $otpsend=0;
                            $otpsend = Curl::to($url_send)->get();

                            $action = new Notificationmsgdetails();
                            $action->user_id = session()->get('admin_id');
                            $action->mobileno = $mobileno;
                            $action->smsmsg = $msg2;
                            $action->smsrequestid = $otpsend;
                            $action->subject = 'Send Custom Inquiry SMS';
                            $action->save();
                        }

                        if ($emailsetting) {
                             if (!empty($email)) {
                                if ($mdata->nemail == 1) {
                                  $data = [
                                         //'data' => 'Rohit',
                                       'msg' => $msg2,
                                       'mail'=> $email,
                                       'subject' => $emailsetting->hearder,
                                       'senderemail'=> $emailsetting->senderemailid,
                                    ];

                                    Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                                      $message->from($data['senderemail'], 'Send Custom Inquiry Mail');
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
                                    $action->messagefor = 'Send Custom Email';
                                    $action->save();

                                 }
                            }
                        }
                    }

                }//for complated
             }
            return Redirect::back()->with(array('msg' => 'Message Send Successfully'));

          // dd($request[0]->firstname);

         }

         public function sendregistrationsms(Request $request){

          $messagetemp = Message::where('editablestatus',1)->get()->all();
          $registrationscheme = RegPaymentMaster::all();
          $query1 = '';

          if ($request->isMethod('post')) {

            $rtype = $request->get('rtype');
            $fdate = $request->get('fdate');
            $tdate = $request->get('tdate');
            $smsmale = $request->get('smsmale');
            $smsfemale = $request->get('smsfemale');
            $selectedmsgid = $request->get('msgid');
            $selectedmsg = $request->get('textareasms');
            $rrg = 'rrg';

            // print_r($rtype);echo "<br/>";
            // print_r($smsmale);echo "<br/>";
            // print_r($fdate);echo "<br/>";
            // print_r($tdate);echo "<br/>";
            // print_r($smsfemale);echo "<br/>";
            // print_r($selectedmsgid);echo "<br/>";
            // print_r($selectedmsg);echo "<br/>";



              // exit;

              if (!empty($rtype) || !empty($fdate) || !empty($tdate) || !empty($smsmale) || !empty($smsfemale)) {

              // $istatus = array($istatus);

                // dd($smsmale);

              // $action = new Actionlog();
              // $action->user_id = session()->get('admin_id');
              // $action->ip = $request->ip();
              // $action->action_type = 'send sms';
              // $action->action = 'Send Custom Inquiry SMS';
              // $action->save();

              $query = Registration::leftjoin('regpaymentmaster','registration.regtypeid','=','regpaymentmaster.regpaymentid')
              ->where('registration.status',1)
              ->where('registration.is_member','!=',1);

              if (!empty($rtype)) {
                $query->where(function($q) use ($rtype){
                    $q->whereIn('regpaymentmaster.regpaymentid',$rtype);
                  });
              }

              if ($fdate != "") {

                    $from = date($fdate);
                    //$to = date($to);
                    if (!empty($tdate)) {
                        $to = date($tdate);
                    }else{
                        $to = date('Y-m-d');
                    }

                    $query->where(function($q) use ($fdate,$from,$to){
                      $q->whereBetween('registration.starting_date',[$from,$to]);
                    });

                  }

                  if ($tdate != "") {

                              $to = date($tdate);

                              if (!empty($fdate)) {
                                  $from = date($fdate);
                              }else{
                                  $from = '';
                              }

                              $query->where(function($q) use ($fdate,$from,$to){
                                $q->whereBetween('registration.starting_date',[$from,$to]);
                              });

                  }

                  if ($smsmale == 'male' && $smsfemale == 'female') {

            // $d = ['m' => 'Male','f'=>'Female'];

                    //$query->where('member.gender','Male')->orwhere('member.gender','Female');

                    $query->where(function($q) use ($smsmale,$smsfemale){
                        $q->where('registration.gender','Male')
                          ->orwhere('registration.gender','Female');
                    });


                      }else{

                           // dd($smsmale);
                      if ($smsmale == 'male') {

                                   $query->where('registration.gender','Male');


                      }

                      if ($smsfemale == 'female') {

                                   $query->where('registration.gender','Female');

                      }

                    }


                  $query1 = $query->get()->all();
                  $mobileno = $query->pluck('mobileno');

                  if (!empty($selectedmsg)) {

                         // dd($rrg);
                        // exit;


                      $q1 = array($query1,$selectedmsgid,$selectedmsg,$rtype,$rrg);

                      $wp = $this->sendwhatsapp($mobileno,$selectedmsg);
                       $this->sendsmsinquirytouser($q1);
                    }


                   return Redirect::back()->with(array('smsmale'=>$smsmale ,'rtype'=>$rtype ,'fdate'=>$fdate ,'tdate'=>$tdate ,'smsfemale'=>$smsfemale ,'query1' => $query1,'rrg'=>$rrg));

                   // dd($query1);

                   exit;

                   $msg = Message::where('messagesid',$selectedmsgid)->first();
                    if ($msg) {

                    // $msg = $msg->message;
                    $msg = $selectedmsg;

                    if (strpos($msg, '[FirstName]') !== false && strpos($msg, '[LastName]') !== false) {

                    $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
                    $emailsetting =  Emailsetting::where('status',1)->first();

                }

                if ($smssetting) {

                    foreach ($query1 as $q) {

                      $fname = $q->firstname;
                      $lname = $q->lastname;
                      $mobileno = $q->phone_no;
                      $email = $q->email_id;

                       // print_r($fname);echo "<br/>";
                       // print_r($lname);echo "<br/>";


                      $rmsg = str_replace(array('[FirstName]','[LastName]'),array($fname, $lname),$msg);
                      $msg2 = $rmsg;
                      $rmsg = urlencode($rmsg);


                       $u = $smssetting->url;
                       $url= str_replace('$mobileno', $mobileno, $u);
                       $url=str_replace('$msg', $rmsg, $url);

                       // print_r($url);echo "<br/>";

                         $otpsend = Curl::to($url)->get();

                      $action = new Notificationmsgdetails();
                      $action->user_id = session()->get('admin_id');
                      $action->mobileno = $mobileno;
                      $action->smsmsg = $msg2;
                      $action->smsrequestid = $otpsend;
                      $action->subject = 'Send Custom Inquiry SMS';
                      $action->save();


                      $data = [
                             //'data' => 'Rohit',
                           'msg' => $msg2,
                           'mail'=> $email,
                           'subject' => $emailsetting->hearder,
                           'senderemail'=> $emailsetting->senderemailid,
                        ];

                        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                          $message->from($data['senderemail'], 'Registration Custom Mail');
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
                        $action->messagefor = 'Send Registration Custom Email';
                        $action->save();



                    }

                  }
              }

              return Redirect::back()->with('msg','Message Send Successfully');


            }else{

               return Redirect::back()->withErrors('Please Select Search Parameter');
            }

          }

          return view('admin.sms.sendregistrationsms',compact('messagetemp','registrationscheme'));

         }

         public function directmessage(Request $request)

         {

          $messagetemp = Message::where('editablestatus',1)->get()->all();

          $loginuser = Session::get('username');
          $method = $request->method();

          $username = $request->get('username');
          $MobileNo = $request->get('MobileNo');


          $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->where('users.userstatus', 'mem')->whereIn('member.status',[1,2,0])->get()->all();


          if ($request->isMethod('post'))
           {

            $mobileno = $request->get('mobileno');
              $username = $request->get('username');
            $selectedmsgid = $request->get('msgid');
            $msg2 = $request->get('textareasms');
            $msg = urlencode($msg2);
            if($mobileno != '' || $username != ''){
                if ($msg2 != '') {

                  $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

                  if ($smssetting) {

                    $u = $smssetting->url;
                     if($mobileno){

                         $url= str_replace('$mobileno', $mobileno, $u);
                     }else{
                        $url= str_replace('$mobileno', $username, $u);
                     }
                      // $url= str_replace('$username', $username, $u);
                    $url=str_replace('$msg', $msg, $url);

                      $wp = $this->sendwhatsapp(array($mobileno),$msg2); //send WhatsApp Message

                //   dd($url);

                    $otpsend = Curl::to($url)->get();
//                    $otpsend = 0;

                    $action = new Notificationmsgdetails();
                    $action->user_id = session()->get('admin_id');
                    if($mobileno){
                       $action->mobileno = $mobileno;

                    }
                    else{   $action->mobileno = $username;}


                    $action->smsmsg = $msg2;
                    $action->smsrequestid = $otpsend;
                    $action->subject = 'Direct Message';
                    $action->save();

                  }

                  return Redirect::back()->with('msg','Message Send Successfully');

                }
                else{

                   return Redirect::back()->withErrors('You Sould Enter Message');

                }
            }else{
                 return Redirect::back()->withErrors('You Sould Enter Mobileno/Username');
            }

          }

          return view('admin.sms.senddirectsms',compact('messagetemp','users'));


         }

        public function sendwhatsapp($mobileno,$message)
    {
        $res = array();
        foreach ($mobileno as $value) {
//                 $fields = [
//                     'key' =>'9662a7a892efc6a3e7055dcfc9fc22a1321dbb072684b9032fdb4f3b0ae1879a',
////                     'instance_id' => '61A226A67E4AA',
//                     'type' => 'text',
//                     'number' => '91' . str_replace('+91','', $value),
//                     'message' => $message
//                 ];
            $fields = [
                'apikey' =>'e83f25cccd984109843b4505147f887e',
                'mobile' => str_replace('+91','', $value),
                'msg' => $message
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://waw.vr4creativity.com/wapp/api/send?".http_build_query($fields),
//                     CURLOPT_URL => "http://wapi.smsinsta.com/api",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 40,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
//                CURLOPT_POSTFIELDS => $fields,
//                CURLOPT_HTTPHEADER => array(
//                    "cache-control: no-cache",
//                    "content-type: multipart/form-data"
//                ),
            ));

            $response = curl_exec($curl);
//            dd($response);

            $err = curl_error($curl);

            curl_close($curl);


            if ($err) {
                $res['error'][] = "cURL Error #:" . $err;
            } else {
                $res['success'][] = $response;
            }
        }
        return $res;
    }

     }





