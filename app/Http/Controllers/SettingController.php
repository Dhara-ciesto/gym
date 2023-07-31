<?php

namespace App\Http\Controllers;
use App\AdminMaster;
use Illuminate\Http\Request;
use Curl;
use DB;
use Session;
use App\Emailsetting;
use App\Smssetting;
use App\Actionlog;
use App\Notificationmsgdetails;
use App\TaxChange_log;

class SettingController extends Controller
{
      public function index(Request $request)
    {
             $settings = AdminMaster::get()->all();
            return view('admin.adminsettings',compact('settings'));
    }

    public function  editsetting($id, Request $request)
    {
       
      $method = $request->method();
       $setting=AdminMaster::findOrFail($id);
        
            if ($request->isMethod('post')){

            $request->validate([
            'title' => 'required',
            'description' => 'required|min:0|max:255',
            ]);

               DB::beginTransaction();
    try {
            $setting->title=$request->title;
              $setting->description=$request->description;
            $setting->save();
            
            $taxchange= new  TaxChange_log();
            $taxchange->title=$request->title;
            $taxchange->oldtax=$request->oldtax;
            $taxchange->newtax=$request->description;
            $taxchange->update_by= session()->get('admin_id');
            $taxchange->updateon=date('Y-m-d H:i:s');
            $taxchange->save();
            
              DB::commit();
        $success = true;

        
   return redirect('settings')->with('message','Succesfully Edited');

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

       return view('admin.editsetting', compact('setting'));
    }

     public function adddevice(Request $request){

      if ($request->isMethod('post')) {
            $request->validate([

              'deviceip_1' => 'required',
              'deviceip_2' => 'required',
              'deviceip_3' => 'required',
              'deviceip_4' => 'required',
              'device_port' => 'required',
              'devicename' => 'required',
              'username' => 'required',
              'password' => 'required',
            ]);
    
              $dip1 = $request->input('deviceip_1');
              $dip2 = $request->input('deviceip_2');
              $dip3 = $request->input('deviceip_3');
              $dip4 = $request->input('deviceip_4');
              $device_port = $request->input('device_port');
              $dtype = $request->input('dtype'); 
              $location = $request->input('location');
              $devicename = $request->input('devicename');
              $username = $request->input('username');
              $password = $request->input('password');
              $reader = $request->input('reader');

       $data1 = [ 

              'ipaddress' => $dip1.'.'.$dip2.'.'.$dip3.'.'.$dip4,
              'portno'      => $device_port,
              'devicename'   => $devicename,
              'devicetype' => $dtype,
              'location' => $location,
              'username' => $username,
              'password' => $password,
              'reader'   => $reader,

                 ];
                 // print_r($data1);exit;

       DB::table('deviceinfo')->insert($data1);

       if ($dtype == 'panellitev2') {
         
        $i = $request->input('i');
       
        $paneldeviceip_1 = $request->input('paneldeviceip_1');
        $paneldeviceip_2 = $request->input('paneldeviceip_2');
        $paneldeviceip_3 = $request->input('paneldeviceip_3');
        $paneldeviceip_4 = $request->input('paneldeviceip_4');
        $plvdevice_port  = $request->input('plvdevice_port');

       $data2 = [
              'ipaddress' => $paneldeviceip_1.'.'.$paneldeviceip_2.'.'.$paneldeviceip_3.'.'.$paneldeviceip_4,
              'portno'      => $device_port,
              'devicetype' => $dtype,
              'devicename'   => $devicename,
              'location' => $location,
              'username' => $username,
              'password' => $password,
              'reader'   => $reader,
            ];
       DB::table('deviceinfo')->insert($data2);
        

        for ($n=1; $n <=$i; $n++) {

          $paneldeviceip_1 = $request->input('paneldeviceip_1'.$n);
          $paneldeviceip_2 = $request->input('paneldeviceip_2'.$n);
          $paneldeviceip_3 = $request->input('paneldeviceip_3'.$n);
          $paneldeviceip_4 = $request->input('paneldeviceip_4'.$n);
          $plvdevice_port  = $request->input('plvdevice_port'.$n);

          $data3 = [
                'ipaddress' => $paneldeviceip_1.'.'.$paneldeviceip_2.'.'.$paneldeviceip_3.'.'.$paneldeviceip_4,
              'portno'      => $device_port,
              'devicetype' => $dtype,
              'devicename'   => $devicename,
              'location' => $location,
              'username' => $username,
              'password' => $password,
              'reader'   => $reader,
            ];
       

          DB::table('deviceinfo')->insert($data3);
        }
        // print_r($paneldeviceip_1);
       }
        
        return redirect('viewdevice');
      }

      return view('admin.settings.adddevice');
    }

    public function viewdevice(){

     $dinfo =  DB::table('deviceinfo')->get()->all();

      return view('admin.viewdevice',compact('dinfo'));

    }
    // Notification Settings ( SMS Setting ) function Start

    public function msgsettings(Request $request){

        if ($request->isMethod('post')) {
          
          
        }

        return view('admin.settings.msgsettings');
    }

        // Notification Settings ( SMS Setting ) function End


    public function smsbalance(Request $request){

      $transation_balance = Curl::to('http://sms.weybee.in/api/balance.php?auth_key=2169KrEMnx2ZgAqSfavSSC&type=0')->get();

      echo $transation_balance;

    }

    public function emailsettings(Request $request){

        if ($request->get('emailinsert') == 1 || $request->get('emailupdate') == 1) {

         $emailsettingsvalidate = $request->validate([
                                'heardername' => 'required',
                                'senderemailid' => 'required|email',
                              ]);
        // print_r( $emailsettingsvalidate);

        $heardername = $request->get('heardername');
        $senderemailid = $request->get('senderemailid');
        $status =  $request->get('emailstatusupdate');
      
      }

      
  
      $emailsetting =  Emailsetting::all();

      if ($emailsetting  == '[]') {
      
        $data = [

                  'hearder' => $heardername,
                  'senderemailid'=> $senderemailid,
                  'status' => 1,

                ];

              print_r("Save Change Successfully");

          Emailsetting::insert($data);

      }else{

          $emailsettinglastid =  Emailsetting::get()->last();

          if ($request->get('getemaildata') == 1) {
            
            echo json_encode($emailsettinglastid);
          }

          if (!empty($heardername)  && !empty($senderemailid)) {
            
            $data = [

                    'hearder' => $heardername,
                    'senderemailid'=> $senderemailid,
                    'status'=> $status,

                  ];

            print_r("Save Change Successfully");

            Emailsetting::where('emailsettingid',$emailsettinglastid->emailsettingid)->update($data);

          }
        
      }
      
    }

    public function cardread(Request $request){

      $loginuser = Session::get('username');
      $cardno = '123456';

      $cn =DB::table('deviceusers')
                          ->leftJoin('rfid', 'deviceusers.userid', '=', 'rfid.userid')
                          ->where('deviceusers.rfidcardno1',$cardno)
                          ->first();

       $deviceinfo = DB::table('deviceinfo')
          ->where('devicetype','independent')
          ->where('reader','yes')
          ->first();
          

      if($request->isMethod('post')){

       try {

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;

                    // $test = get_headers($url);
                    //  $test = 'connected';
                     
                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/card-read-write?action=read&format=xml');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    
                
                     $xml_file = simplexml_load_string($response);
                     $json = json_encode($xml_file);
                    $array = json_decode($json,TRUE);
                    //print_r($array);exit;


                    
                    $cardno = [ 'cardno' => $array['card-no'],];
                    $cardno = $cardno['cardno'];


                    $cn =DB::table('deviceusers')
                          ->leftJoin('rfid', 'deviceusers.userid', '=', 'rfid.userid')
                          ->where('deviceusers.rfidcardno1',$cardno)
                          ->where('deviceusers.status','1')
                          ->first();

                      // print_r($cn);exit;
                    


                    // if ($cn) { 
                      
                    // }else{

                    //   DB::table('rfid')->insert($cardno);

                    // }


                    if ($response['1'] == 0) {

                        return view('admin.cardread',compact('cn','deviceinfo','cardno'));
                    }

                     

         } catch (\Exception $e) {

                $test = 'Disconnected';
   
        }
      }

      return view('admin.cardread',compact('cn','deviceinfo','cardno'));


    }

    // SMS Setting Function Start

    public function smssettings(Request $request){

      if ($request->isMethod('post')) {

         $data = ['status'=> 0,
         'smsonoff'=> 'Deactive' ];

         $smssetting = Smssetting::where('status',1)->update($data);

         $i = $request->input('i');
         $maddpn = $request->input('addpn');
         $maddv = $request->input('addv');
                  $urlstatus = $request->input('urlstatus');

         $urlbyuser = $request->input('url');
         $pfmobile = $request->input('pfmobile');
         $pfmessage = $request->input('pfmessage');
         $mobileno = $request->input('vfmobile');
         $msg = $request->input('vfmessage');
         $addpn = $request->input('addpn1');
         $addv = $request->input('addv1');
         $url = '';
         $originalurl = '';
         $pfmo = $pfmobile.'='.$mobileno;
         $pfm  = $pfmessage.'='.$msg;
         $madd = $maddpn.'='.$maddv;

         $v = $request->validate([
            'url' => 'required',
            'pfmobile' => 'required',
            'vfmobile' => 'required|numeric|min:10',
            'pfmessage' => 'required',
            'addpn' =>'required',
            'addv' =>'required',
            'addpn1' =>'required',
            'addv1' =>'required',
          ]);

          if (empty(!$addpn) && empty(!$addv)) {

         for ($n=1; $n<=$i; $n++) {

            $addpn = $request->input('addpn'.$n);
            $addv = $request->input('addv'.$n);

            $url1[] = ''.$addpn.'='.$addv.'';
            $urlstore[] = $url1;

          }
          // $urlstore = ['p1'=>$maddpn];
          // $urlstore += ['v1'=>$maddv];
           $urlstore = $url1;

          // $urlstore = serialize($urlstore);
          $r = '';
            $urlstore = implode(',', $urlstore);
           

            $urlstore = $pfmo.','.$pfm.','.$madd.','.$urlstore;

          // $urlstore = implode(',', $urlstore);

            if (strpos($urlstore, ',=') !== false) {
            for ($n=1; $n<=$i; $n++) {
              $urlstore= str_replace(',=', $r, $urlstore);
             }
              // echo $urlstore;
           }

          $url = $urlbyuser.'?'.$pfmobile.'='.$mobileno.'&'.$pfmessage.'='.$msg.'&'.$maddpn.'='.$maddv.'';
          $originalurl = $urlbyuser.'?'.$pfmobile.'='.'$mobileno'.'&'.$pfmessage.'='.'$msg'.'&'.$maddpn.'='.$maddv.'';


           for ($i=0; $i <$n-1 ; $i++) {
 
            $url = $url.'&'.$url1[$i].'';

            if (strpos($url, '=&') !== false) {
                for ($n=1; $n<=$i; $n++) {
              $url = str_replace('=&', $r, $url);
                }
              }
            
           }



           for ($i=0; $i <$n-1 ; $i++) {
 
            $originalurl = $originalurl.'&'.$url1[$i].'';

            if (strpos($originalurl, '=&') !== false) {
                for ($n=1; $n<=$i; $n++) {
              $originalurl = str_replace('=&', $r, $originalurl);
                }
              }
            
           }

         
           // echo $originalurl;
           // exit();
          $data = [

                    'domailname' =>$urlbyuser,
                    'parameters'=> $urlstore,
                    'testurl' => $url,
                     'url' => $originalurl,
                    'status' => '1', 
                     'smsonoff' => $urlstatus,
                  ];

            Smssetting::insert($data);
            
           // print_r($data);
           // exit();

           $action = new Actionlog();
                  $action->user_id = session()->get('admin_id');
                  $action->ip = $request->ip();
                  $action->action_type = 'insert';
                  $action->action = 'Sms Settings';
                  $action->save();

        }else{
                echo "<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('SMS Url Format is Wrong! Please Enter SMS Url Again With Proper Parameter.');
                      </SCRIPT>";

             return redirect('msgsettings');
        }

        //  $urlstatus = 'done';

       return view('admin.settings.smsurltest',compact('url','urlstatus'));
      }

      if ($url == '') {

              echo "<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('SMS Url Format is Wrong! Please Enter SMS Url Again With Proper Parameter.');
                      </SCRIPT>";

             return redirect('msgsettings');

           }else{

            return view('admin.settings.smsurltest',compact('url'));

           }

      return redirect('msgsettings');

    }

        // SMS Setting Function End




    // Edit SMS Function editsmssettings Start


    public function editsmssettings(Request $request){

      $edit = Smssetting::all();

      if ($request->isMethod('post'))
       {
     
        
         $i = $request->input('i');

         $urlbyuser = $request->input('url');
         $pfmobile = $request->input('pfmobile');

         $pfmessage = $request->input('pfmessage');
         $mobileno = $request->input('vfmobile');
         $msg = $request->input('vfmessage');
         $hid = $request->input('hid');
         $url = '';
                  $originalurl = '';

         $urlstatus = $request->input('urlstatus');
         $pfmo = $pfmobile.'='.$mobileno;
         $pfm  = $pfmessage.'='.$msg;

           // dd($urlstatus);
         
           

         $v = $request->validate([
            'url' => 'required',
            'pfmobile' => 'required',
            'vfmobile' => 'required|numeric|min:10',
            'pfmessage' => 'required',
            // 'addpn1' =>'required',
            // 'addv1' =>'required',
          ]);

          for ($n=1; $n<=$i; $n++) {   
          
            $addpn = $request->input('addpn'.$n);
            $addv = $request->input('addv'.$n);
            

            $url1[] = ''.$addpn.'='.$addv.'';
            //$urlstore[] = $url1;

          }
         

          $urlstore = implode(',', $url1);
          $urlstore=trim($urlstore,',=');
          $urlstore = $pfmo.','.$pfm.','.$urlstore;

          if (strpos($urlstore, ',=') !== false) {
            for ($n=1; $n<=$i; $n++) {
              $urlstore= str_replace(',=','', $urlstore);
             }
              // echo $urlstore;
          }

          $urlstore=trim($urlstore,',=');

         
          $url = $urlbyuser.'?'.$pfmobile.'='.$mobileno.'&'.$pfmessage.'='.$msg.'';

          $originalurl = $urlbyuser.'?'.$pfmobile.'='.'$mobileno'.'&'.$pfmessage.'='.'$msg'.'';


          // echo $originalurl;
          // exit();
          $url=trim($url,'&=');
            $originalurl=trim($originalurl,'&=');


           for ($i=2; $i <$n-1 ; $i++)
            {
 
            $url = $url.'&'.$url1[$i].'';

            if (strpos($url, '=&') !== false) 
            {
                for ($n=1; $n<=$i; $n++) 
                {
              $url = str_replace('=&','', $url);
                }
             }
           }


           for ($i=2; $i <$n-1 ; $i++)
            {
 
            $originalurl = $originalurl.'&'.$url1[$i].'';

            if (strpos($originalurl, '=&') !== false) 
            {
                for ($n=1; $n<=$i; $n++) 
                {
              $originalurl = str_replace('=&','', $originalurl);
                }
             }
            }





            
         
           $url=trim($url,'&=');
                      $originalurl=trim($originalurl,'&=');


          //      echo $originalurl;
          // exit();

           $data = [

                    'domailname' =>$urlbyuser,
                    'parameters'=> $urlstore,
                    'testurl' => $url,
                     'url' => $originalurl,
                    'smsonoff' => $urlstatus,
                  ];
               

          Smssetting::where('smssettingid',$hid)->update($data);

                  $action = new Actionlog();
                  $action->user_id = session()->get('admin_id');
                  $action->ip = $request->ip();
                  $action->action_type = 'Update';
                  $action->action = 'Update Sms Settings';
                  $action->save();

          return view('admin.settings.smsurltest',compact('url','urlstatus'));

      }

     return view('admin.settings.editmsgsettings',compact('edit'));

    }

          // Edit SMS Function editsmssettings Start



     // Edit SMS Function Settings geteditsmssettings Start

    public function geteditsmssettings(Request $request){

      // $domainnameid = $request->get('domainname');

      $editsms = Smssetting::where('status',1)->get()->first();

      if ($editsms) {

         echo $editsms;
       
      }else{

          $editsms = "1";

         echo $editsms;

      }

     

      json_encode($editsms);

    }
     // Edit SMS Function Settings geteditsmssettings End


    public function urltest(Request $request){

      $testurl = $request->get('testurl');
      $saveurl = $request->get('saveurl');
      $turl = $request->get('turl');



      $data = [ 'testurl' => $turl ];

      $smssetting2 = Smssetting::where('status',1)->update($data);
      $smssetting = Smssetting::where('status',1)->first();

     

      if ($testurl)
       {
        // echo $testurl;
        // exit();
        //  $testurlsms = Curl::to($url)->get();
        $testurlsms = Curl::to(''.$smssetting->testurl.'')->get();


        $urlreplace = $smssetting->testurl;


        $rmmobile=substr($urlreplace,52,10);
      

        $action = new Notificationmsgdetails();
        $action->user_id = session()->get('admin_id');
       // $acc=session()->get('admin_id');
       
        $action->mobileno = $rmmobile;
        $action->smsmsg = $smssetting->testurl;

        $action->smsrequestid = $testurlsms;
        $action->subject = 'Test Url From Sms Settings';
        $action->save();

        $smsresponse = Notificationmsgdetails::where('mobileno',$rmmobile)->latest()->first();

        echo json_encode($smsresponse);

      }

    }

    public function urltestdemo(Request $request){

       $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

       if ($smssetting) {
        


        $mobileno = "8200406933";
        $msg = 'sdffdfs';
         
      $u = $smssetting->url;
      $url= str_replace('$mobileno', $mobileno, $u);
      $url=str_replace('$msg', $msg, $url);
       
     //http://sms.weybee.in/api/sendapi.php?mobiles='.$mobileno.'&message='.$msg.'&auth_key=2169KrEMnx2ZgAqSfavSSC&sender=PYOFIT&route=4
      

       $testurlsms = Curl::to($url)->get();

       echo $testurlsms;

        }
      
    }

    public function urltestsave(Request $request){

       $saveurl = $request->get('saveurl');


       $smssetting = Smssetting::where('status',1)->first();

       if ($saveurl) {


        $mobilenos = '$mobileno';
        $msg = '$msg';

        $urlreplace = $smssetting->testurl;
     
        $rmmobile=substr($urlreplace,45,10);
        $rmmobile1=substr($urlreplace,64,7);
        $urlsave= str_replace($rmmobile, $mobilenos, $urlreplace);
        $urlsave2= str_replace($rmmobile1, $msg, $urlsave);
        
        //print_r($urlreplace);
        $saveurlstatus = Smssetting::where('status',1)->update(['url'=> $urlsave2,'smsonoff'=>'Active']);

        $smsresponse = "SMS Url Save Successfully.";

         echo json_encode($smsresponse);

      } 

    }

}