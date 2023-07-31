<?php
namespace App\Http\Controllers\sms;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use DB;
use Session;
use Curl;
use App\Notificationmsgdetails;
use App\Emailnotificationdetails;
use App\Smssetting;
use App\Inquiry;
use App\Emailsetting;

class InquirySMSController extends Controller
{
    public function inqsms(Request $request){
        $messagetemp = Message::where('editablestatus',1)->get()->all();

        $fdate =$request->get('fdate');
        $tdate =$request->get('tdate');
        $ratting=$request->get('ratting');
        $status=$request->get('status');
        $keyword =$request->get('keyword');
        $smsmale = $request->get('smsmale');
        $smsfemale = $request->get('smsfemale');
        $query=[];
        $query['fdate']=$fdate ;
        $query['tdate']=$tdate ;
        $query['ratting']=$ratting;
        $query['status']=$status;
        $query['keyword']= $keyword;
        $query['smsmale']=$smsmale;
        $query['smsfemale']= $smsfemale;

        $inquiry ='';
        if($request->isMethod('post'))
        {

            DB::enableQuerylog();
            $inquiry =  Inquiry::leftjoin('notification','notification.mobileno','=','inquiries.mobileno');

            if ($fdate != "") {
                    $from = date($fdate);
                    //$to = date($to);
                    if (!empty($tdate)) {
                        $to = date($tdate);
                    }else{
                        $to = date('Y-m-d');
                    }
                    $inquiry->whereBetween('inquiries.created_at', [$from, $to]);

            }
            if ($tdate != "") {
                        $to = date($tdate);
                        if (!empty($fdate)) {
                            $from = date($fdate);
                        }else{
                            $from = '';
                        }
                        $inquiry->whereBetween('inquiries.created_at',[$from,$to]);
            }
            if ($keyword != ""){
                $inquiry->where(function ($query) use ($keyword){
                    $query->where( 'inquiries.inquiryid', 'LIKE', '%' . $keyword . '%' )
                    ->orwhere ( 'inquiries.companyname', 'LIKE', '%' . $keyword . '%' )
                    ->orwhere ( 'inquiries.tenderno', 'LIKE', '%' . $keyword . '%' )
                    ->orwhere ( 'inquiries.tendername', 'LIKE', '%' . $keyword . '%' )
                    ->orwhere ( 'inquiries.sldno', 'LIKE', '%' . $keyword . '%' )
                    ->orwhere ( 'inquiries.gano', 'LIKE', '%' . $keyword . '%' )
                    ->orWhere ('inquiries.cityname', 'LIKE', '%' . $keyword . '%' );
                });

            }

            if($status != ""){

                $inquiry->whereIn('inquiries.status',$status);
            }
            if(!(empty($ratting))){
                $inquiry->whereIn('inquiries.rating',$ratting);
            }
            if ($smsmale == 'male') {
                $inquiry->where('inquiries.gender','male');
            }
            if ($smsfemale == 'female') {
                $inquiry->where('inquiries.gender','female');
            }
            $inquiry=$inquiry->orderBy('inquiries.created_at', 'desc')
            ->get()->all();
            $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
           $successcount=0;
            if($request->sendsms && $smssetting){
                if((!empty($inquiry))){

                    if($request->textareasms){
                        $msgtobesend = $request->textareasms;
                    }elseif($request->msgid){
                        $msgtobesend = Message::where('messagesid',$request->msgid)->pluck('message')->first();
                    }else{
                        return redirect()->back();
                    }

                    // $emailsetting =  Emailsetting::where('status',1)->first();

                        foreach ($inquiry as $key => $value) {
                            $mobileno = $value->mobileno;
                            $fname = $value->firstname;
                            $lname = $value->lastname;
                            if ($value->sms == 1) {
                                $msg =$msgtobesend;
                                $msg = str_replace("[FirstName]",$fname,$msg);
                                $msg = str_replace("[LastName]",$lname,$msg);

                                $msg2 = $msg;
                                $msg = urlencode($msg);

                                $u = $smssetting->url;
                                $url= str_replace('$mobileno', $mobileno, $u);
                                $url=str_replace('$msg', $msg, $url);

                                $url_send = str_replace(' ', '%20', $url);
                                $otpsend = Curl::to($url_send)->get();
                                if($otpsend){
                                    $successcount++;
                                    $action = new Notificationmsgdetails();
                                    $action->user_id = session()->get('admin_id');
                                    $action->mobileno = $mobileno;
                                    $action->smsmsg = $msg2;
                                    $action->smsrequestid = $otpsend;
                                        $action->subject = 'Send Custom Inquiry SMS';
                                    $action->save();
                                }


                            }
                        }

                }
                return redirect('sendinquirysms')->withSuccess($successcount.'  Meassages Send SuccessFully');
            }


            // dd(DB::getQueryLog());
        }
        return view('admin.sms.sendinquirysms',compact('messagetemp','query','inquiry'));
        // where('inquiriesid')->
    }
}
