<?php

namespace App\Http\Controllers\sms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Message;
use DB;
use Response;
use App\RootScheme;
use App\Scheme;
use App\ExerciseLevel;
use App\MemberPackages;
use App\Member;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\Actionlog;
use Ixudra\Curl\Facades\Curl;
use App\Notificationmsgdetails;
use App\Emailnotificationdetails;
use App\Smssetting;
use Datatables;
use App\Emailsetting;

 
class NotificationControllerajax extends Controller
{
   

    public function smssearch(Request $request){
        // echo "string";exit();

        $rootschemeid = $request->get('rootschemeid');
        $schemeid = $request->get('schemeid');
        $mstatus = $request->get('mstatus');
        $smsmale = $request->get('smsmale');
        $smsfemale = $request->get('smsfemale');
        $smstag = $request->get('smstag');
        $fdate = $request->get('fdate');
        $tdate = $request->get('tdate');

        // if ($rootschemeid == "" || $schemeid == "" || $fdate == "" || $tdate == "" || $mstatus == "" || $smstag == "" || $smsmale != "true" || $smsfemale != "true") {
        //         # code...
        //     echo "string";
        //     }

        if ($rootschemeid != "" || $schemeid != "" || $fdate != "" || $tdate != "" || $mstatus != "" || $smstag != "" || $smsmale == "true" || $smsfemale == "true") {
          
        

        DB::enableQueryLog();
        $query = DB::table('member')
                ->leftjoin('memberpackages','member.userid','=','memberpackages.userid')
                ->leftjoin('memberworkout','member.memberid','=','memberworkout.memberid')
                ->leftjoin('workouttags','memberworkout.workoutid','=','workouttags.workoutid')
                ->leftjoin('schemes','memberpackages.schemeid','=','schemes.schemeid')
                ->leftjoin('rootschemes','schemes.rootschemeid','=','rootschemes.rootschemeid');
                // ->select('member.firstname','member.mobileno','member.email')
                  // ->get()->all();
                
             # code...
        


  // dd($query);exit;

        if($rootschemeid != ""){
             

            // for($i=0;$i<count($rootschemeid);$i++)
            //     {
            //         $rr[] = $rootschemeid[$i];
            //     }
                     // dd($rr);

            //$rootschemeid = implode(',',$rr);
            // dd($rootschemeid);

                    // $query->where('rootschemes.rootschemeid','like','%'.$rootschemeid.'%');

             $query->where(function($q) use ($rootschemeid){
                $q->whereIn('rootschemes.rootschemeid',$rootschemeid);
             });
                        
                         
        }

        if($schemeid != ""){

                     $query->where(function($q) use ($schemeid){
                        $q->whereIn('schemes.schemeid',$schemeid);
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
                      $q->whereBetween('member.created_at',[$from,$to]);  
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
                      $q->whereBetween('member.created_at',[$from,$to]);  
                    });
                     
        }

        if ($mstatus != "") {

                     $query->where(function($q) use ($mstatus){
                        $q->whereIn('member.status',$mstatus);
                     });
            
                     
                     
        }

        if ($smstag != "") {
            
                     $query->where(function($q) use ($smstag){
                        $q->whereIn('workouttags.tagid',$smstag);
                     });
                     
        }

        if ($smsmale == "true" && $smsfemale == "true") {

            // $d = ['m' => 'Male','f'=>'Female'];
            
                    //$query->where('member.gender','Male')->orwhere('member.gender','Female');

                    $query->where(function($q) use ($smsmale,$smsfemale){
                        $q->where('member.gender','Male')
                          ->orwhere('member.gender','Female');
                    });

                     
        }else{

             // dd($smsmale);
        if ($smsmale == "true") {
            
                     $query->where('member.gender','Male');

                     
        }

        if ($smsfemale == "true") {
            
                     $query->where('member.gender','Female');
                     
        }

        }

         
       
            // $query1->toSql();
       $query1 =  $query->distinct()->get(['member.mobileno','member.firstname','member.lastname','member.email'])->all();
          // $queryy->get()->all();


                // dd(DB::getQueryLog());
                        
                      
        echo json_encode($query1);

    }else{
        echo "1";
    }

         // dd($query1); 

    }

     public function sendsmsuser(Request $request){

        $fname = $request->get('ajaxmlist');
        $mobileno = $request->get('mobileno');
        $memail = $request->get('memail');
        $lname = $request->get('lastname');
        // print_r($memail);exit;


        $msg = $request->get('textareasmsotp');

        $member = Member::where('mobileno',$mobileno)->first();

         $action = new Actionlog();
              $action->user_id = session()->get('admin_id');
              $action->ip = $request->ip();
              $action->action_type = 'send';
              $action->action = 'Send sms to member';
              // $action->action_on = $ajaxmlist;
              $action->save();
        
            // $msg = urlencode($msg);

         $dnd =  DB::table('notification')->where('mobileno',$mobileno)->first();
        
         if ($dnd) {
             
             if ($dnd->sms == 1) {

                 $msg = str_replace("[FirstName]",$fname,$msg);
                 $msg = str_replace("[LastName]",$lname,$msg);
                 $msg2 = $msg;
                 $msg = urlencode($msg);

                 // dd($msg);

                 $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
                 
                 if ($smssetting)
                  {
                 
                   $u = $smssetting->url;
                   $url= str_replace('$mobileno', $mobileno, $u);
                   $url=str_replace('$msg', $msg, $url);
         
                    // echo $mobileno;
                    $otpsend='';
                 
                 $otpsend = Curl::to($url)->get();

                  $action = new Notificationmsgdetails();
                  $action->user_id = session()->get('admin_id');
                  $action->mobileno = $mobileno;
                  $action->smsmsg = $msg2;
                  $action->smsrequestid = $otpsend;
                  $action->subject = 'Send Custom SMS To Member';
                  $action->save();
                      # code...
                 }

                 $response = json_decode($otpsend,true);
                

                 if(!empty($response['ErrorCode'] == '000')) 
                 {
                    if ($response) {
                       echo "Success";
                    }else{
                        echo "Failure";
                    }
                 }else{
                    echo 'Failure';
                 }


                 
             }

             if ($dnd->email == 1) {

                 $emailsetting =  Emailsetting::where('status',1)->first();

                if ($emailsetting) {
                   

                    $data = [
                             //'data' => 'Rohit',
                           'msg' => $msg,
                           'mail'=> $memail,
                           'subject' => $emailsetting->hearder,
                           'senderemail'=> $emailsetting->senderemailid,
                        ];

//dd($data);
                Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                    // $file = public_path("/images/consentform.pdf");

                       // print_r($file);exit;

                    $message->from($data['senderemail'], 'Inquiry Message');
                    $message->to($data['mail']);
                    $message->subject($data['subject']);
                    // $message->attach($file, [
                    //                     'as' => 'consentform.pdf',
                    //                     'mime' => 'application/pdf',
                    //                 ]);
                });

                                $action = new Emailnotificationdetails();
                                $action->user_id = session()->get('admin_id');
                                $action->mobileno = $mobileno;
                                $action->message = $msg;
                                $action->emailform = $data['senderemail'];
                                $action->emailto = $data['mail'];
                                $action->subject = $data['subject'];
                                $action->messagefor = 'Send Custom Email';
                                $action->save();
                }
                 
             }
         }

        
    }

    public function smsresponse(Request $request){

        $mobileno = $request->get('mobileno');

        $smsresponse = Notificationmsgdetails::where('mobileno',$mobileno)->get()->last();

        echo json_encode($smsresponse);
    }

}
