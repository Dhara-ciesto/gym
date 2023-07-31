<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Smssetting;
use App\Notificationmsgdetails;
use Ixudra\Curl\Facades\Curl;

class SendPaymentSMSController extends Controller
{
    public function sendsmsyes(Request $request){

        $msg=$request->get('msg');
        $mobileno=$request->get('mobileno');
        

        $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
 
        if ($smssetting) {
          
            $u = $smssetting->url;
            $url= str_replace('$mobileno', $mobileno, $u);
            $url=str_replace('$msg', $msg, $url);
            
            $otpsend = Curl::to($url)->get();
    
            $action = new Notificationmsgdetails();
            $action->user_id = session()->get('admin_id');
            $action->mobileno = $mobileno;
            $action->smsmsg = $msg;
            $action->smsrequestid = $otpsend;
            $action->subject = 'Remaing Payment';
            $action->save();
            return 'success';
        }
    }

}
