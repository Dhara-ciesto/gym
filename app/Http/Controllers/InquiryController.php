<?php

namespace App\Http\Controllers;

use App\Http\Controllers\sms\NotificationController;
use Illuminate\Http\Request;
use App\Inquiry;
use App\Followup;
use App\Reason;
use DB;
use Carbon\Carbon;
use App\RootScheme;
use App\User;
use App\PaymentType;
use App\Company;
use Ixudra\Curl\Facades\Curl;
use App\OTPVerify;
use App\Smssetting;
use App\Notificationmsgdetails;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;
use App\Notification;


class InquiryController extends Controller
{
  public function index(Request $request)
  {

    if($request->isMethod('post'))
    {
      if($request->get('firstname')!="")
      {
        $firstname=$request->get('firstname');
            //$members = Inquiry::where('inquiriesid','=',$firstname)->where('status','1')->get();
        $users = Inquiry::where('status','1')->get()->all();

        $followid=array();
        for($i=0;$i<count($users);$i++) {
          $inquiryid = $users[$i]['inquiriesid'];

          $x= DB::table('followupcalldetails')->where('inquiriesid',$inquiryid)->MAX('followupcalldetailsid');

          if($x!='')
            $followid[] =  $x;

        }

        $members = DB::select( DB::raw("select  inquiries.*,followupcalldetails.*  from  `inquiries` left Join followupcalldetails on followupcalldetails.inquiriesid = inquiries.inquiriesid AND followupcalldetails.followupcalldetailsid IN(".implode(',', $followid).") where inquiries.inquiriesid=$firstname"));

        return view('admin.viewinquiry',compact('members','users'));
      }
      if($request->get('mobileno')!="")
      {
        $mobileno=$request->get('mobileno');
          //$members = Inquiry::where('inquiriesid','=',$mobileno)->where('status','1')->get();
        $users = Inquiry::where('status','1')->get()->all();
        $users = Inquiry::where('status','1')->get()->all();

        $followid=array();
        for($i=0;$i<count($users);$i++) {
          $inquiryid = $users[$i]['inquiriesid'];

          $x= DB::table('followupcalldetails')->where('inquiriesid',$inquiryid)->MAX('followupcalldetailsid');

          if($x!='')
            $followid[] =  $x;

        }

        $members = DB::select( DB::raw("select  inquiries.*,followupcalldetails.*  from  `inquiries` left Join followupcalldetails on followupcalldetails.inquiriesid = inquiries.inquiriesid AND followupcalldetails.followupcalldetailsid IN(".implode(',', $followid).") where inquiries.inquiriesid=$mobileno"));

        return view('admin.viewinquiry',compact('members','users'));
      }
      elseif($request->get('inquirydate')!="")
      {

        $inquirydate=$request->get('inquirydate');

        $members = Inquiry::where('createddate', 'LIKE', '%' . $inquirydate . '%')->where('status','1')->get();
        $users = Inquiry::where('status','1')->get()->all();
        return view('admin.viewinquiry',compact('members','users'));
      }
      elseif($request->get('keyword')!="")
      {
        $userid=$request->get('keyword');
        $members = Inquiry::leftJoin('followup','followup.inquiryid','=','inquiries.inquiriesid')->where('inquiries.status','1')->where( 'inquiries.firstname', 'LIKE', '%' . $userid . '%' )->orWhere ('inquiries.email', 'LIKE', '%' . $userid . '%' )->orWhere('inquiries.lastname', 'LIKE', '%' . $userid . '%' )->get()->all();
        $users = Inquiry::where('status','1')->get()->all();
        if (count ($members ) > 0){
          return view('admin.viewinquiry',compact('members','users'));
        }else{
          $members='';
          return view('admin.viewinquiry',compact('users','members'));
        }
      }
      elseif($request->get('rating')!="")
      {

        $rating=$request->get('rating');
        $members = Inquiry::where('rating',$rating)->where('status','1')->get();
        $users = Inquiry::where('status','1')->get()->all();
        return view('admin.viewinquiry',compact('members','users'));
      }
      elseif($request->get('followupdate')!="")
      {

       $followupdate=$request->get('followupdate');
       $members = Inquiry::leftJoin('followup','followup.inquiryid','=','inquiries.inquiriesid')->where('inquiries.status','1')->where('followup.followuptakendate','=',$followupdate)->get()->all();



       $users = Inquiry::where('status','1')->get()->all();

       return view('admin.viewinquiry',compact('members','users'));
      }
      elseif($request->get('hearabout')!="")
      {
        $hearabout=$request->get('hearabout');
        $members = Inquiry::where('hearabout',$hearabout)->get();
        $users = Inquiry::get()->all();
        return view('admin.viewinquiry',compact('members','users'));
      }
      else
      {
        $members =Inquiry::where('status','1')->get()->all();
        $users = Inquiry::where('status','1')->get()->all();

        return view('admin.viewinquiry',compact('members','users'));
      }
    }

    $users = Inquiry::where('status','1')->get()->all();

    $followid=array();
    $members=array();
    for($i=0;$i<count($users);$i++) {
      $inquiryid = $users[$i]['inquiriesid'];

      $x= DB::table('followupcalldetails')->where('inquiriesid',$inquiryid)->MAX('followupcalldetailsid');

      if($x!='')
        $followid[] =  $x;
    }


    $members = DB::select(DB::raw("SELECT inquiries.*, subquery1.max_id, (select calldate as calldate from followupcalldetails where followupcalldetails.followupcalldetailsid = subquery1.max_id) as calldate
      FROM inquiries  LEFT JOIN
      (SELECT inquiriesid, MAX(inquiriesid) AS max_id
      FROM followupcalldetails
      GROUP BY inquiriesid ) subquery1 ON
      subquery1.inquiriesid = inquiries.inquiriesid where inquiries.status = 1
      ORDER BY `subquery1`.`max_id` ASC"));

    return view('admin.viewinquiry',compact('members','users'));
  }

  public function closeinquiry($id, Request $request)
  {

    $method = $request->method();

    if ($request->isMethod('post'))
    {

      $inquiry=Inquiry::findOrFail($id);

      $inquiry->status = '0';
      $inquiry->reason = $request['reason'];
               //$inquiry->reasondescription = $request['description'];

      $inquiry->save();
      if(Followup::where('inquiryid',$id)->get()->first()){
        $followup=Followup::where('inquiryid',$id)->get()->first();

        $followup->status = '4';
        $followup->reason = 'Close Inquiry';
        $followup->save();
    }

      return redirect('inquiry')->with('message', 'inquiry is closed');
    }

    $Reasons = Reason::get(['reasonid','reason'])->all();
    return view('admin.closeinquiry',compact('Reasons','id'));
  }

  public function confirminquiry($id)
  {

    $inquiry=Inquiry::findOrFail($id);

    $inquiry->status = '2';
    $inquiry->save();

    if(Followup::where('inquiryid',$id)->get()->first()){
      $followup=Followup::where('inquiryid',$id)->get()->first();

      $followup->status = '3';
      $followup->reason = 'Confirm Inquiry';
      $followup->save();
    }



            return view('admin.addinquiry',compact('packages','pocarray'));

  }
  public function add_inquiry()
  {
    $packages = DB::table('schemes')->select('schemeid','schemename')->get()->all();

    $users = Inquiry::where('status','1')->get()->all();
    $members = Inquiry::where('status','1')->get()->all();

                // return view('admin.viewinquiry',compact('users','members'));
    return redirect('viewconfirmedinquiry');
  }


  public function editinquiry($id,Request $request)
  {
    $method = $request->method();
    $f=Inquiry::findOrFail($id);
    $fd = Followup::findOrFail($id);

    if($request->isMethod('post')){

      $v = $request->validate([
        'firstname' => 'required',
        'lastname' => 'required',
        'gender' => 'required',
        'email' => 'required|email',
        'mobileno' =>'required|max:10',
      ]);


     $f->firstname=$request->input('firstname');
     $f->lastname=$request->input('lastname');
     $f->gender=$request->input('gender');
     $f->email=$request->input('email');
     $f->mobileno=$request->input('mobileno');
     $f->profession=$request->input('profession');
     $f->referenceby=$request->input('reference');
     $f->alreadymember=$request->input('alreaygymmember');
     $f->remarks=$request->input('remarks');
     $f->hearabout = $request->input('howknowaboutus');
     $f->save();



      return redirect('inquiry')->with('message','Succesfully Edited');
    }

    $inquiry = Inquiry::find($id);
    $followup = Followup::findOrFail($id);


    return view('admin.editInquiry',compact('inquiry','id','followup'));
  }

  public function viewconfirmedinquiry(Request $request){
    $inqs = Inquiry::leftjoin('followup','followup.inquiryid','=','inquiries.inquiriesid')->where('inquiries.status' ,2)->get()->all();

    return view('admin.viewconfirmedinquiry',compact('inqs'));
  }

  public function convertmember($id){
    $member = Inquiry::findOrFail($id);

    $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
    $RootScheme = RootScheme::get()->all();
    $users = User::get()->all();
    $PaymentTypes = PaymentType::get()->all();
    $company = Company::get()->all();
    return view('admin.addMemberfromconfirminquiry',compact('member','exerciseprogram','RootScheme','users','PaymentTypes','company'));
  }

  public function add()
  {

    $packages = DB::table('schemes')->select('schemeid','schemename')->get()->all();

    $poc=DB::table('employee')->select('username')->where('role','!=','trainer')->get()->all();
    $pocarray=[];
    if($poc){

      foreach ($poc as $key => $value) {
       array_push($pocarray, $value->username);
     }
   }


   return view('admin.addinquiry',compact('packages','pocarray'));
  }

  public function inquiryotpverify(Request $request){

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

  public function otpverify(Request $request){



   $mobileno = $request->get('mobileno');
   $email = $request->get('email');

   $rndno=rand(1000, 999999);

   $otpgenerate = [
    'mobileno'      => $mobileno,
    'email'         => $email,
    'code'          => $rndno,
    'isexpired'    =>'0',
    'created_at'     => date('Y-m-d  H:i:s'),
    'updated_at'     => date('Y-m-d  H:i:s'),
    ];

    DB::table('otpverify')->insert($otpgenerate);

    $your = "Your";
    $is = "is:".$rndno;
    $fit = "FITNESS5";
    $otp="OTP";
  }

  public function postverify(Request $request){

   $inquiry_mobile_no = DB::table('inquiries')->get()->last();

   $code = $request->get('otp');

   $mobileno = $request->get('mobileno');
   $mobile_no = $inquiry_mobile_no->mobileno;


   if ($code == '') {

    $skipotp = DB::table('otpverify')->get()->last();

    $data = [
      'isexpired' => '2',
    ];

    DB::table('otpverify')->where('mobileno','=',$mobile_no)->update($data);

    return redirect('inquiry');
            // return redirect('viewconfirmedinquiry');

    }


    $q=OTPVerify::where('code',$code)->where('isexpired','!=','1')->where('created_at', '>',
     Carbon::now()->subMinute(30)->toDateTimeString())->first();


    if($q){
      $q->isexpired = 1;
      $q->save();

      if($q){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('OTP Verified');
          </SCRIPT>");
      }

      return redirect('inquiry');
    }
    else{
      echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Worng OTP !! please redend OTP');
        </SCRIPT>");

      return view('admin.otpresend',compact('inquiry_mobile_no'));
    }
  }

  public function inquiryotpsend(Request $request){

   $mobileno = $request->get('mobileno');

   $email = $request->get('email');

   $rndno=rand(1000, 999999);

   $otpgenerate = [
    'mobileno'      => $mobileno,
    'email'         => $email,
    'code'          => $rndno,
    'isexpired'    =>'0',
    'created_at'     => date('Y-m-d  H:i:s'),
    'updated_at'     => date('Y-m-d  H:i:s'),
    ];

    DB::table('otpverify')->insert($otpgenerate);

    $msg=   DB::table('messages')->where('messagesid','19')->get()->first();


          $msg =$msg->message;
          $msg= str_replace("[otp]",$rndno,$msg);
          $msg2 = $msg;
          $msg = urlencode($msg);

           $smssetting = Smssetting::where('status',1)->first();
           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);

          $otpsend = Curl::to($url)->get();
//          $otpsend = 0;
      $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($mobileno),$msg2);

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msg2;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Inquiry Otp Send';
          $action->save();


    // $your = "Your";
    // $is = "is:".$rndno;
    // $fit = "FITNESS5";
    // $otp="OTP";


    // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$your.'+'.$fit.'+'.$otp.'+'.$is.'&route=6')->get();
    echo 'yes';

    // $emailsetting =  Emailsetting::where('status',1)->first();

    //  $data = [
    //                          //'data' => 'Rohit',
    //            'msg' => $msg2,
    //            'mail'=> $mp->memail,
    //            'subject' => $emailsetting->hearder,
    //            'senderemail'=> $emailsetting->senderemailid,
    //         ];
  }

  public function create(Request $request){

    //dd($request->toArray());

    if ($request->isMethod('post'))
    {
      $v = $request->validate([
        'firstname' => 'required|max:255',
        'lastname' => 'required|max:255',
        'gender' => 'required',
        'email' => 'required|email|max:255',
        'phoneno' =>'required|max:10',
        'menberinothergym' => 'required',
        'hereaboutus' => 'required',
        'reference' => 'required',
        'package'  => 'required',
        'poc' => 'required',
        'inquirytype' => 'required',
        'inquiryrate' => 'required',
        'readytomember' => 'required',
      ]);

      $usr = Inquiry::where('mobileno', $request['phoneno'])->where('status','1')->get()->all();
      if($usr){
        return redirect('inquiry')->with('message','Inquiry Already Exists');
      }

      $mobileno = $request->get('phoneno');
      $firstname = $request->input('firstname');
      $lastname = $request->input('lastname');

      if($request['nextstep'] == '3'){
        $msg=   DB::table('messages')->where('messagesid','1')->get()->first();
        $msg =$msg->message;
        $msg = str_replace("[FirstName]",$firstname,$msg);
        $msg= str_replace("[LastName]",$lastname,$msg);

        // $nmd = [
        //   'mobileno' => $mobileno,
        //   'smsmsg' => $msg,
        //   'mailmsg' => '0',
        //   'callnotes' => '0',
        // ];
        $msg2=$msg;
        $msg = urlencode($msg);

         $smssetting = Smssetting::where('status',1)->first();
           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);

          $otpsend = Curl::to($url)->get();
//          $otpsend = 0;
          $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($mobileno),$msg2);



        // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get();


        $followup_call_details = DB::table('notoficationmsgdetails')->where('mobileno','=',$mobileno)->get()->first();
        //dd($followup_call_details);

        if(!$followup_call_details){

         $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msg;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Inquiry Create';
          $action->save();
        }
      }

      if($request['nextstep'] == '2'){
      }

      if($request['nextstep'] == '1'){
      }


      if($request->input('readytomember') == 'Member'){
        $member = $request->all();
        $data = [
          $firstname = $request->input('firstname'),
          $lastname = $request->input('lastname'),
          $email = $request->input('email'),
          $phoneno = $request->input('phoneno'),
          $gender = $request->input('gender'),
          $profession = $request->input('profession'),
          $menberinothergym = $request->input('menberinothergym'),
          $hereaboutus = $request->input('hereaboutus'),
          $reference = $request->input('reference'),
          $remark = $request->input('remark'),
          $readytomember = $request->input('readytomember'),
          $fdate = $request->input('fdate'),
          $ftime = $request->input('ftime'),
          $stime = $request->input('stime'),
          $packages = $request->input('package'),
          $poc = $request->input('poc'),
          $inquirytype = $request->input('inquirytype'),
          $inquiryrate = $request->input('inquiryrate'),
          $note = $request->input('note'),

        ];



        $createddate = Carbon::now()->toDateString();

        $inquiry_table_data = [
          'createddate' => $createddate,
          'firstname' => $firstname,
          'lastname'  => $lastname,
          'gender'  => $gender,
          'email'  => $email,
          'mobileno' => $phoneno,
          'profession' => $profession,
          'referenceby' => $reference,
          'alreadymember' => $menberinothergym,
          'remarks' => $remark,
          'hearabout' => $hereaboutus,
          'packagename' => $packages,
          'poc' => $poc,
          'rating' => $inquiryrate,
          'inquirytype' => $inquirytype,
          'note' => $note,
          'status' => '3',
          'reason' => 'Convert Into Member',

        ];

        $id =  DB::table('inquiries')->insertGetId($inquiry_table_data);

        $inquiry=Inquiry::findOrFail($id);

        $inquiry->status = '0';
        $inquiry->save();

        $followup_table_data =[
          'inquiryid'=> $id,
          'userid'=> '2',
          'followuptime'=> $request['ftime'],
          'remarks'=> $remark,
          'followupdays'=> $request['FollowUpDays'],
          'status'=> '2',
          'reason' => 'Convert Into Member',
        ];

        DB::table('followup')->insert($followup_table_data);

        if(Followup::where('inquiryid',$id)->get()->first()){
          $followup=Followup::where('inquiryid',$id)->get()->first();

          $followup->status = '4';
          $followup->reason = 'Close Inquiry';
          $followup->save();
        }

        $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
        //dd($exerciseprogram);
        $RootScheme = RootScheme::get()->all();
        $users = User::get()->all();
        $PaymentTypes = PaymentType::get()->all();
        $company = Company::get()->all();
        return view('admin.addMemberfrominquiry',compact('member','exerciseprogram','RootScheme','users','PaymentTypes','company'));
      }


      $createddate   = Carbon::now()->toDateString();

      $inquiries_id = DB::table('inquiries')->select('inquiriesid')->get()->last();

      $data = [
        $firstname = $request->input('firstname'),
        $lastname = $request->input('lastname'),
        $email = $request->input('email'),
        $phoneno = $request->input('phoneno'),
        $gender = $request->input('gender'),
        $profession = $request->input('profession'),
        $menberinothergym = $request->input('menberinothergym'),
        $hereaboutus = $request->input('hereaboutus'),
        $reference = $request->input('reference'),
        $remark = $request->input('remark'),
        $readytomember = $request->input('readytomember'),
        $fdate = $request->input('FollowUpDays'),
        $ftime = $request->input('ftime'),
        $stime = $request->input('stime'),
        $packages = $request->input('package'),
        $poc = $request->input('poc'),
        $inquirytype = $request->input('inquirytype'),
        $inquiryrate = $request->input('inquiryrate'),
        $note = $request->input('note'),
      ];

      $inquiry_table_data = [
        'createddate' => $createddate,
        'firstname' => $firstname,
        'lastname'  => $lastname,
        'gender'  => $gender,
        'email'  => $email,
        'mobileno' => $phoneno,
        'profession' => $profession,
        'referenceby' => $reference,
        'alreadymember' => $menberinothergym,
        'remarks' => $remark,
        'hearabout' => $hereaboutus,
        'status' => '1',
        'packagename' => $packages,
        'poc' => $poc,
        'rating' => $inquiryrate,
        'inquirytype' => $inquirytype,
        'note' => $note,
      ];

      $id =  DB::table('inquiries')->insertGetId($inquiry_table_data);

      $followup_table_data =[
        'inquiryid'=> $id,
        'userid'=> '2',
        'followuptime'=> $request['ftime'],
        'followupspecifictime' => $request['stime'],
        'remarks'=> $remark,
        'followupdays'=> $request['FollowUpDays'],
        'status'=> '1',
        'reason' => 'pending',
      ];

      $followupcalldetails = [
        'inquiriesid' => $id,
        'calldate' => $fdate,
        'callcompletedby'=>'vicky shah',
        'callnotes' => 'Followup Added !',
        'scheme' =>$packages,
        'callrating'=>$inquiryrate,
        'created_at'   => date('Y-m-d  H:i:s'),
        'updated_at'  => date('Y-m-d  H:i:s'),
      ];




      DB::table('followupcalldetails')->insert($followupcalldetails);
      DB::table('followup')->insert($followup_table_data);

      $inquiry_mobile_no = DB::table('inquiries')->get()->last();

      $notification = [

        'mobileno' => $mobileno,
        'sms'  =>'1',
        'email' => '1',
        'call' => '1',
      ];

      DB::table('notification')->insert($notification);



      return redirect('inquiry')->with('message', 'Succesfully added');
    }


  }


}
