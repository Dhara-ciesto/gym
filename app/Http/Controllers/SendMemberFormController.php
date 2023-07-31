<?php

namespace App\Http\Controllers;

use App\Http\Controllers\sms\NotificationController;
use Illuminate\Http\Request;
use App\ShortLink;
use App\Smssetting;
use Ixudra\Curl\Facades\Curl;
use App\MemberData;
use App\Message;

class SendMemberFormController extends Controller
{
   public function sendmemberform(Request $request)
    {
        if($request->isMethod('post')){
            $id=$request->mobileno;

    	    $link_send = url('/').'/'.$id.'/addmember';
           $msg= Message::where('messagesid',18)->get()->first();
           $msg=$msg->message;
           $firstname=$request->firstname;

            $lastname=$request->lastname;
            $msg ='Dear '.$firstname.' '.$lastname.' '.$msg;

            $bitlylink = app('bitly')->getUrl($link_send);
            ShortLink::create([
                'code'=>$id,
                'firstname'=>$firstname,
                'lastname'=>$lastname,
                'link'=>$link_send,
                'shortenlink'=>$bitlylink,
                'status'=>1
            ]);
             $msg2= str_replace("[url]", $bitlylink,$msg);
            // $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

            $msg = urlencode($msg2);

            $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
            $otpsend='';
            if ($smssetting) {

            $u = $smssetting->url;
            $url= str_replace('$mobileno', $id, $u);
            $url=str_replace('$msg', $msg, $url);
            $whatsappmsg =  NotificationController::instance()->sendwhatsapp(array($id),$msg2);
            $otpsend = Curl::to($url)->get();
			}
            return redirect()->back()->withSuccess('Form SuccesFully Send');
        }
    }
    public function addmeber(Request $request,$id){
        $shortlink=ShortLink::where('code',$id)->get()->last();
        if($shortlink){
            if($shortlink->status==1){
                  include public_path().'/addmember.php';
            }else{
                include public_path().'/alreadysubmitted.php';
            }

        }
        else{
                return abort(404);
            }

    }
     public function viewrequests(Request $request){
        $memberdata=MemberData::where('status',1)->where('answer',2)->orderBy('memberid','desc')->get()->all();
        return view('admin.Memberform.allrequests',compact('memberdata'));

    }
    public function sendformtonumber(Request $request){

            return view('admin.Memberform.sendformtonumber');


    }
    public function changeMemberStatus(Request $request){
        $memberdata=MemberData::where('memberid',$request->id)->get()->first();
        $memberdata->status=1;
        $memberdata->save();
        return 'success';
    }
    public function rejectrequest(Request $request,$id){
        $memberdata=MemberData::where('memberid',$request->id)->get()->first();
        $memberdata->answer=3;
        $memberdata->save();
        return  redirect()->back()->withSuccess('SuccesFully Rejected');
    }
    public function viewsentforms(Request $request){
        $sentforms = ShortLink::orderBy('id','desc')->get()->all();
        return view('admin.Memberform.viewsendform',compact('sentforms'));
    }



}
