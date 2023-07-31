<?php

namespace App\Http\Controllers;

use App\Http\Controllers\sms\NotificationController;
use Illuminate\Http\Request;
use App\Inquiry;
use App\Followup;
use App\Reason;
use DB;
use Carbon;
use Curl;
use App\Notification;
use App\Followupcalldetails;
use App\Smssetting;
use App\Notificationmsgdetails;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;
use App\Emailnotificationdetails;


class FollowupController extends Controller
{
  public function index(Request $request,$id=null){

        $fdate = $request->get('fdate');
        $tdate = $request->get('tdate');
        $status = $request->get('status');
        $username = $request->get('username');
        $fromremider  = $request->get('fromremider');
        $toreminder= $request->get('toreminder');
        $keyword =$request->get('keyword');
       if($id){
        $username=$id;
      }
       $smsmale = '';
       $smsfemale = '';
       $query=[];
       $query['fdate']=$fdate ;
       $query['tdate']=$tdate ;
       $query['status']=$status ;
       $query['username']=$username ;
       $query['fromremider']=$fromremider ;
       $query['toreminder']=$toreminder ;
       $query['keyword']= $keyword;

       // $smstag = $request->get('smstag');
       // $fdate = $request->get('fdate');
       // $tdate = $request->get('tdate');
       $users = Inquiry::where('status','1')->get()->all();
        DB::enableQueryLog();
        $followups = Followupcalldetails::
        leftJoin('inquiries','inquiries.inquiriesid','=','followupcalldetails.inquiriesid');
       if ($fdate != "") {
                   $from = date($fdate);
                   //$to = date($to);
                   if (!empty($tdate)) {
                       $to = date($tdate);
                   }else{
                       $to = date('Y-m-d');
                   }
                   // ->whereBetween('followupdays', [$from, $to])
                   $followups->whereBetween(DB::raw("DATE_FORMAT(calldate,'%Y-%m-%d')"),[$from,$to]);
       }
       if ($tdate != "") {
                   $to = date($tdate);
                   if (!empty($fdate)) {
                       $from = date($fdate);
                   }else{
                       $from = date('Y-m-d');
                   }
                   $followups->whereBetween(DB::raw("DATE_FORMAT(calldate,'%Y-%m-%d')"),[$from,$to]);
       }
       if ($fromremider != "") {
        $from = date($fromremider);
        //$to = date($to);
        if (!empty($toreminder)) {
            $to = date($toreminder);
        }else{
            $to = date('Y-m-d');
        }
        // ->whereBetween('followupdays', [$from, $to])
                $followups->whereBetween(DB::raw("DATE_FORMAT(schedulenextcalldate,'%Y-%m-%d')"),[$from,$to]);
        }
        if ($toreminder != "") {
                $to = date($toreminder);
                if (!empty($fromremider)) {
                    $from = date($fromremider);
                }else{
                    $from = date('Y-m-d');
                }
                $followups->whereBetween(DB::raw("DATE_FORMAT(schedulenextcalldate,'%Y-%m-%d')"),[$from,$to]);
        }
       if ($status != "") {
                    $followups->where('inquiries.status',$status);
       }
       if ($keyword != "") {
        $followups->where(function ($query) use ($keyword){
          $query->where( 'inquiries.packagename','Like',"%".$keyword."%" )
          ->orwhere ( 'followupcalldetails.callrating','Like',"%".$keyword."%" )
          ->orwhere ( 'inquiries.gender','Like',"%".$keyword."%" )
          ->orwhere ( 'followupcalldetails.callnotes','Like',"%".$keyword."%" );
          });
        }
       if ($username != "") {
                $followups->where('followupcalldetails.inquiriesid',$username);
       }
       if ($smsmale == "true") {
                    $followups->where('inquiries.gender','male');
       }
       if ($smsfemale == "true") {
                    $followups->orWhere('inquiries.gender','female');
       }

        $followups =  $followups->select('followupcalldetails.*','inquiries.*','inquiries.status as istatus')
        ->orderBy('followupcalldetails.created_at','desc')->paginate(15);
        //  dd(DB::getQueryLog());


         return view('admin.followup',compact('followups','users','query'));

  }
  public function index23(Request $request)
  {
    if($request->isMethod('post'))
    {

      if($request->get('from')!="")
      {
         $status='';
        $from = date($request->get('from'));
        if($request->get('to')){
          if($request->get('status')){
              $status=$request->get('status');

          }
          $to = date($request->get('to'));
        }
        else{
          $to = date('Y-m-d');
        }

        $followups = Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')->whereBetween('followupdays', [$from, $to])->select(['followup.status as fstatus','followup.*','inquiries.*'])->paginate(8);

        return view('admin.followup',compact('followups'));
      }
      elseif($request->get('status')!=""){
        $status=$request->get('status');
        // dd($status);

        $followups = Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')->where('followup.status',$status)->select(['followup.status as fstatus','followup.*','inquiries.*'])->paginate(8);
        return view('admin.followup',compact('followups'));
      }

      $followups = Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')->select(['followup.status','followup.*','inquiries.*'])->paginate(8);



      return view('admin.followup',compact('followups'));

    }
    $followups = Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')->select(['followup.status as fstatus','followup.*','inquiries.*'])->paginate(8);



    return view('admin.followup',compact('followups'));
  }
  public function addfollowup($id,Request $request){

    $followup= Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')->where('followup.inquiryid','=',$id)->get()->first();

    $method = $request->method();

    if ($request->isMethod('post')){

     $followupcomplete =  Followup::where('inquiryid',$id)->get()->all();
     foreach ($followupcomplete as $key => $followupcomplete) {
               # code...

      $followupcomplete->reason =  $request['Reason'];
      $followupcomplete->status = 'Completed';
      $followupcomplete->followuptakendate = Carbon\Carbon::today()->format('Y-m-d');

      $followupcomplete->save();
    }
    $data = [
      'inquiriesid'=> $id,
      'userid'=> $followup->UserId,
      'followuptime'=> $request['ftime'],
      'remarks'=> $request['stime'],
      'followupdays' => $request['FollowUpDays'],
      'status'=> 'Pending',
    ];

    DB::table('followup')->insert($data);

    $followup = Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiriesid')->select(['followup.status as fStatus','followup.reason as fReason','followup.*','inquiries.*'])->get()->all();
    return view('admin.followup',compact('followup'));
  }
  return view('admin.addFollowup',compact('followup'));
}

public function viewfollowup($id,Request $request){

  $followup = Followup::where('inquiryid',$id)->get()->all();

  $followupid= Followup::
  leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')
  ->where('followup.inquiryid','=',$id)->get()->first();

  $package = DB::table('schemes')->get()->all();
  $poc=DB::table('employee')->select('username')->where('role','!=','trainer')->get()->all();
  $pocarray=[];
  if($poc){

    foreach ($poc as $key => $value) {
     array_push($pocarray, $value->username);
   }
 }


       // return view('admin.viewfollowupmodel',compact('followup','id'));

 return view('admin.viewfollowupmodel',compact('followup','id','followupid','package','pocarray'));

}

public function editfollowupmodel($id,Request $request){

 $followup = Followup::where('inquiryid',$id)->get()->all();
 $followupid= Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')->where('followup.inquiryid','=',$id)->get()->first();
 $package = DB::table('schemes')->get()->all();

 $followupCallDetails = Followupcalldetails::where('inquiriesid',$followupid->inquiryid)->max('followupcalldetailsid');

 $fcd = Followupcalldetails::where('followupcalldetailsid',$followupCallDetails)->get();


 if($request->isMethod('post')){

   $v = $request->validate([
    'callcompletedby' => 'required',
    'callresponse' => 'required',
    'callduration' => 'required',
    'callqulity' => 'required',
    'package' => 'required',
  ]);


   $data = [

    'callcompletedby' => $request->input('callcompletedby'),
    'callresponse' => $request->input('callresponse'),
    'calldate' => $request->input('calldate'),
    'callduration' => $request->input('callduration'),
    'callnotes' => $request->input('notes'),
    'callrating' => $request->input('callqulity'),
    'schemeid' => $request->input('package'),

    'schedulenextcalldate' => date('Y-m-d', strtotime($request->input('scheduledate'))),
    'scheduleassign' => $request->input('assign'),
    'trainer' => $request->input('trainer'),
    'freetrial' => date('Y-m-d', strtotime($request->input('freetrialdate'))),
    'freetrialpackage' => $request->input('ftp'),
    'created_at'     => date('Y-m-d  H:i:s'),
    'updated_at'     => date('Y-m-d  H:i:s'),

  ];


  DB::table('followupcalldetails')->where('followupcalldetailsid',$fcd['0']->followupcalldetailsid)->update($data);

  return redirect('followup');

}

return view('admin.editfollowupmodel',compact('followup','id','followupid','package','followupCallDetails','fcd'));

}


public function viewfollowupcall($id,Request $request){


  $followupid= Followup::
  leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')
  ->where('followup.inquiryid','=',$id)->get()->first();


  $viewfollowupcallid = $followupid->inquiriesid;
  $mobileno = $followupid->mobileno;
  $email = $followupid->email;

  $dnd = DB::table('notification')->where('mobileno','=',$mobileno)->get()->first();


  if ($request->isMethod('post')){

            // $data = [

            //             $callcompletedby = $request->input('callcompletedby'),
            //             $callresponse = $request->input('callresponse'),
            //             $date = $request->input('calldate'),
            //             $notes = $request->input('notes'),
            //             $callqulity = $request->input('callqulity'),
            //             $package = $request->input('package'),
            //             $scheduledate = $request->input('scheduledate'),
            //             $assign = $request->input('assign'),
            //             $trainer = $request->input('trainer'),
            //             $freetrialdate = $request->input('freetrialdate'),
            //             $ftp = $request->input('ftp'),

            //         ];

    $v = $request->validate([
      'callcompletedby' => 'required',
      'callresponse' => 'required',
      'callduration' => 'required',
      'callqulity' => 'required',
      'package' => 'required',
    ]);


    $data = [

      'inquiriesid'   => $viewfollowupcallid,
      'callcompletedby' => $request->input('callcompletedby'),
      'callresponse' => $request->input('callresponse'),
      'calldate' => $request->input('calldate'),
      'callduration' => $request->input('callduration'),
      'callnotes' => $request->input('notes'),
      'callrating' => $request->input('callqulity'),
      'scheme' => $request->input('package'),
      'schedulenextcalldate' => ($request->input('scheduledate')) ? date('Y-m-d', strtotime($request->input('scheduledate')))    : NULL,
      'scheduleassign' => $request->input('assign'),
      'trainer' => $request->input('trainer'),
      'freetrial' => ($request->input('freetrialdate')) ? date('Y-m-d', strtotime($request->input('freetrialdate')))    : NULL,
      'freetrialpackage' => $request->input('ftp'),
      'created_at'     => date('Y-m-d  H:i:s'),
      'updated_at'     => date('Y-m-d  H:i:s'),

    ];

    DB::table('followupcalldetails')->insert($data);

    if ($request->input('callresponse') == "Can't_Pick_up_Your_Call") {
            $Followup_Response = 'We are Trying to Connect You';
          }
      if ($request->input('callresponse') == 'Asked_To_Call_Later') {
            $Followup_Response = 'We Get Response to Connect You Later';
          }
      if ($request->input('callresponse') == 'Interested_To_Visit_GYM') {
            $Followup_Response = 'We are glade That You Are Interested';
          }
      if ($request->input('callresponse') == 'Not_Interested_In_GYM') {
            $Followup_Response = 'We glade to call you';
          }
      if ($request->input('callresponse') == 'Other') {
            $Followup_Response = 'We glade to take your response';
          }

    if($dnd->sms == 1){


      $packages = $request->input('package');
      $package = DB::table('schemes')->where('schemename',$packages)->get()->first();
      $mem = Inquiry::where('inquiriesid',$viewfollowupcallid)->get()->first();
      $fname=$mem->firstname;
      $lname=$mem->lastname;
      $mobileno =$mem->mobileno;
      $packagename = $package->schemename;
      $date =  $request->input('scheduledate');
      $poc = $request->input('assign');

                  //$msgid=   DB::table('message')->where('id','15')->select('id')->first();
                  //$msgid= $msgid->id;

      $msg=   DB::table('messages')->where('messagesid','15')->get()->first();

      $msg =$msg->message;
      $msg = str_replace("[FirstName]",$fname,$msg);
      $msg= str_replace("[LastName]",$lname,$msg);
      $msg= str_replace("[Packge]",$packagename,$msg);
      $msg= str_replace("[Date]",$date,$msg);
      $msg= str_replace("[POC]",$poc,$msg);
      $msg= str_replace("[Followup_Response]",$Followup_Response,$msg);


      $msg2 = $msg;
      $msg = urlencode($msg);

      $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

       if ($smssetting) {

           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);

          $otpsend = Curl::to($url)->get();
//          $otpsend = 0;
           $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($mobileno),$msg2);

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msg;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Take Followup';
          $action->save();

        }

      }

      // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get();


      // DB::table('notoficationmsgdetails')->insert($nmd);

      $emailsetting =  Emailsetting::where('status',1)->first();

      if($dnd->email == 1){

      if ($emailsetting && $email) {

        $data = [
                             //'data' => 'Rohit',
               'msg' => $msg2,
               'mail'=> $email,
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
            ];


        // Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

        //         $message->from($data['senderemail'], 'Followup Message');
        //         $message->to($data['mail']);
        //         $message->subject($data['subject']);

        //   });

          $action = new Emailnotificationdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->message = $msg2;
          $action->emailform = $data['senderemail'];
          $action->emailto = $data['mail'];
          $action->subject = $data['subject'];
          $action->messagefor = 'Followup Mail';
          $action->save();

        }
    }

    return redirect('inquiry');
  }

}


public function viewfollowupprofile($id,Request $request){

 $method = $request->method();
          //$f=Followup::findOrFail($id);


 $info= Followup::leftJoin('inquiries','inquiries.inquiriesid','=','followup.inquiryid')->where('followup.inquiryid','=',$id)->first();



 $followup_call_details = DB::table('followupcalldetails')->where('inquiriesid','=',$id)->orderBy('created_at','desc')->take(5)->get()->all();

 $callnotes = DB::table('followupcalldetails')->select('callnotes')->where('inquiriesid','=',$id)->get()->last();



 $schedule = DB::table('followupcalldetails')->select('schedulenextcalldate','scheduleassign')->where('inquiriesid','=',$id)->get()->last();


 $freetiral = DB::table('followupcalldetails')
 ->where('inquiriesid','=',$id)
 ->where('freetrial','!=',NULL)
 ->where('freetrial','!=','1970-01-01')

 ->select('trainer','freetrial','freetrialpackage','created_at')
 ->take(5)->get()->all();
 $package =DB::table('followupcalldetails')
 ->leftJoin('schemes','schemes.schemename','=','followupcalldetails.scheme')
 ->select('followupcalldetails.*','schemes.schemename','schemes.actualprice')
 ->where('followupcalldetails.inquiriesid','=',$id)->latest()->first();

 return view('admin.viewfollowupprofile',compact('package','followup_call_details','freetiral','info','schedule','callnotes'));


}

public function editfollowup($id,Request $request)
{
 $method = $request->method();
 $f=Followup::findOrFail($id);
 if ($request->isMethod('post')){
  $f->Reason=$request->reason;
  $f->followupdays=$request->FollowUpDays;
  $f->followuptime=$request->FollowUpTime;
  $f->remarks=$request->Specifictime;
  $f->save();


  return redirect('viewfollowup/'.$f->inquiryid)->with('message','Succesfully Edited');
}

return view('admin.editfollowup',compact('f'));


}

public function notificationvia(Request $request){

  $mobile_no = $request->input('mobileno');

  $sms  = $request->input('sms');
  $mail  = $request->input('mail');
  $call  = $request->input('call');

  $moblastdigit =  substr($mobile_no, 4, 6);
  $moblastdigit = 'xxxxxx';

  $inquiry = DB::table('notification')->where('mobileno','=',$mobile_no)->first();

          //$inquiry = DB::table('notification')->select('inquiry_id')->get();

  if ($call == '') {
    echo "string";
  }

  $data = [

    'sms'  => $sms,
    'email' => $mail,
    'call' => $call,

  ];



  if ($inquiry) {

    DB::table('notification')->where('mobileno','=',$mobile_no)->update($data);
  }
  else{

   $datainsert = [
    'mobileno' => $mobile_no,
    'sms'  => $sms,
    'email' => $mail,
    'call' => $call,

  ];

  DB::table('notification')->insert($datainsert);
}

}

public function ajaxgetnotification(Request $request){

 $mobile_no = $request->input('notificationid');

 $q = DB::table('notification')->where('mobileno','=',$mobile_no)->get();

 echo json_encode($q);
}



}
