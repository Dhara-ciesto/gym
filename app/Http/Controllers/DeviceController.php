<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registration;
use DB;
use Carbon\Carbon;
use App\Member;
use App\User;
use App\Deviceuser;
use Ixudra\Curl\Facades\Curl;
use App\MemberEnrollment;
use App\DeviceEvent;
use App\Deviceseqcount;
use App\Employee;
use App\Actionlog;
use App\ApiTrack;
use App\Assigncardhistory;
use App\AnyTimeAccessBelt;
use App\ApiCronJob;
use App\MemberPackages;
use App\Scheme;
use App\Apischedule;
use App\Notify;

class DeviceController extends Controller
{

    public function index(Request $request){

        $ipdata = DB::table('deviceinfo')->get()->all();

        return view('admin.device.addstaticip',compact('ipdata'));
    
    }

    

   public function addstaticip(Request $request){

        $box1 = $request->input('box1');
        $box2 = $request->input('box2');
        $box3 = $request->input('box3');
        $box4 = $request->input('box4');
        $portno = $request->input('portno');
        $devicename = $request->input('devicename');
        $serialno = $request->input('serialno');

        $ip = $box1.".".$box2.".".$box3.".".$box4; 

        $data = [
                    'ipaddress' => $ip,
                    'portno'  => $portno,
                    'devicename' => $devicename,
                    'serialno'  => $serialno,

                ];   

        DB::table('deviceinfo')->insert($data);

         return redirect('staticip/index');
   
  
   }

   public function enrollment(){

    $ipdata = DB::table('deviceinfo')->get()->all();

 
    return view('admin.device.enrollment',compact('ipdata'));
   

   }


   public function devicestatus(Request $request){

     $deviceinfo = DB::table('deviceinfo')
                               // ->where('devicetype','independent')
                               // ->where('reader','no')
                              ->get()->all();

      if ($request->isMethod('post')) {

                return redirect('devicestatus');

            }
         
 if (!empty($deviceinfo)) {



      foreach ($deviceinfo as $dinfo) {
  
           try {

                    $url = $dinfo->ipaddress.':'.$dinfo->portno.'';
                    $deviceinfo_status = DB::table('device_status')->where('ip', 'like', $url)->pluck('status')->first();
                    if(!empty($deviceinfo_status)){
                      $dinfo->device_status = $deviceinfo_status;
                    }else{
                      $dinfo->device_status = '';

                    }
                  
                    
            
             } catch (\Exception $e) {

                    return url('dashboard');
            }
      }
        return view('admin.device.devicestatus',compact('deviceinfo'));      
        

 }else{

     

     return view('admin.device.devicestatus',compact('deviceinfo'));
      }
                
   }

   public function fetchlogs(Request $request){
    $portno_const = config('constants.port');
                     try {

                            $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;

                    $deviceevent =   DB::table('deviceevent')->get()->last();
                    $deviceseqcountid = DB::table('deviceseqcount')->get()->last();

                     if (!empty($deviceseqcountid)) {

                        $deviceseqcounts = $deviceseqcountid->seqno;
                       

                                $ch = curl_init($url);
                                                                 
                                curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/command?action=geteventcount&format=xml');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($ch);
                                // print_r($response);

                                $xml_file = simplexml_load_string($response);
                                $json = json_encode($xml_file);
                                $array = json_decode($json,TRUE);

                                $seqcount = $array['Seq-Number'];
                                
                                if($deviceseqcounts != $seqcount) {
                                     
                                      $deviceseqcount = [
                                            'rollovercount'  => $array['Roll-Over-Count'],
                                            'seqno'          => $array['Seq-Number'],
                                        ];

                                        Deviceseqcount::insert($deviceseqcount);
                                        return redirect('vfl');
                                }
                     }else{
                          $ch = curl_init($url);                               
                                
                                curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                curl_setopt($ch, CURLOPT_URL,"http://".$deviceinfo->ipaddress.':'.$deviceinfo->portno."/device.cgi/command?action=geteventcount&format=xml");
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($ch);                

                                $xml_file = simplexml_load_string($response);
                                $json = json_encode($xml_file);
                                $array = json_decode($json,TRUE);

                                $seqcount = $array['Seq-Number'];

                                  $deviceseqcount = [
                                            'rollovercount'  => $array['Roll-Over-Count'],
                                            'seqno'          => $array['Seq-Number'],
                                        ];

                                    Deviceseqcount::insert($deviceseqcount);
                                    return redirect('vfl');
                                }
                                
                   
                    }catch (\Exception $e) {

                                echo "Your Device Not connected !";
        }
        // dump('aaaaaa');
        // exit;
        return redirect('viewfetchlogs');

   }

   public function viewfetchlogs(Request $request){
    

        $fdate =$request->get('fdate');
        $tdate =$request->get('tdate');
        $seqno=$request->get('seqno');
        $keyword =$request->get('keyword');
        /*for pass to bladefile */
        $query=[];
        $query['fdate']=$fdate ;
        $query['tdate']=$tdate ;
        $query['seqno']=$seqno;
        $query['keyword']= $keyword;
        
        $seqnos= DeviceEvent::get()->all();
        if ($request->isMethod('post')) {
   
           $deviceevent1 =  DeviceEvent::
           leftjoin('users', 'deviceevent.detail1', 'users.userid')
           ->where('deviceevent.created_at','!=',null);
      

           if ($fdate != "") 
           {
              $from = date($fdate);
               //$to = date($to);
              if (!empty($tdate)) {
                $to = date($tdate);
              }else{
                $to = date('Y-m-d');
              }

              $deviceevent1->whereBetween('deviceevent.date', [$from, $to]);
           
            }
            if ($tdate != "") {
               $to = date($tdate);
               if (!empty($fdate)) {
                   $from = date($fdate);
               }else{
                   $from = '';
               }
                 $deviceevent1->whereBetween('deviceevent.date', [$from, $to]);
            }
             if ($seqno != ""){

               $deviceevent1->where('deviceevent.seqno',$seqno);
          }
             if ($keyword != ""){
               $deviceevent1->where ( 'deviceevent.seqno', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'deviceevent.detail1', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'users.username', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'deviceevent.detail2', 'LIKE', '%' . $keyword . '%' );
          }


                 $deviceevent=$deviceevent1->paginate(8);
               

        return view('admin.device.viewfetchlogs',compact('deviceevent','query','seqnos'));

        }

        $deviceevent =  DeviceEvent::leftjoin('users', 'deviceevent.detail1', 'users.userid')->paginate(8)->appends('query');
        return view('admin.device.viewfetchlogs',compact('deviceevent','query','seqnos'));

   }

   public function test(){


    $portno_const = config('constants.port');
     $deviceevent =   DB::table('deviceevent')->get()->last();
     $deviceseqcountid = DB::table('deviceseqcount')->get()->last();
     $portno_const = config('constants.port');
     // dd($deviceevent);

    if (!empty($deviceevent)) {


                            $cou = [];
                            $seqnumber = $deviceevent->seqno;
                            $seqrollovercount = $deviceevent->rollovercount;
                            $dscrolloc = $deviceseqcountid->rollovercount;
                            $dscrollocseq3 = $deviceseqcountid->seqno;
                            $deviceinfo = DB::table('deviceinfo')
                                                  ->where('devicetype','independent')
                                                  ->where('portno', $portno_const)
                                                  ->first();

                            for($i = 0; $i < 2; $i++)
                            {

                               
                                if($seqnumber > 49999)
                                {
                                    //echo "fsdfsdfsdfds";exit;
                                    for($r = $seqnumber; $r <= 50000; $r++)
                                    {
                                        // $first = 50000;
                                        // array_push($cou, $first);
                                             $seqnumber = 1;
                                         $dscrolloc = $dscrolloc + 1;
                                        // print_r($dscrolloc);
                    

                                        $url = 'http://'.$deviceinfo->ipaddress.'';
                                         $username = $deviceinfo->username;
                                         $password = $deviceinfo->password;

                                         $ch = curl_init($url);

                                 
                                
                                curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                curl_setopt($ch, CURLOPT_URL,"http://".$deviceinfo->ipaddress.":".$deviceinfo->portno."/device.cgi/events?action=getevent&roll-over-count=".$dscrolloc."&seq-number=".$seqnumber."&no-of-events=1&format=xml");
                           
                              
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                            $response = curl_exec($ch);
                                            $xml_file = simplexml_load_string($response);
                                            $json = json_encode($xml_file);
                                            $array = json_decode($json,TRUE);
                                            $serialize =serialize($array);
                                           $dated = str_replace('/', '-', $array['Events']['date']);
                                           // !empty($array['Events']['roll-over-count']) ? $array['Events']['roll-over-count'] : ''
                                            // exit;
                                            $deviceeventdata = [

                                                'rollovercount'  => $array['Events']['roll-over-count'],
                                                'seqno'          => !empty($array['Events']['seq-No']) ? $array['Events']['seq-No'] : '',
                                                'date'           => !empty(date('Y-m-d', strtotime($dated))) ? date('Y-m-d', strtotime($dated)) : '' ,
                                                'time'           => !empty(date('H:i:s', strtotime($array['Events']['time']))) ? date('H:i:s', strtotime($array['Events']['time'])) : '' ,
                                                'eventid'        => !empty($array['Events']['event-id']) ? $array['Events']['event-id'] : '' ,
                                                'detail1'        => !empty($array['Events']['detail-1']) ? $array['Events']['detail-1'] : '' ,
                                                'detail2'        => !empty($array['Events']['detail-2']) ? $array['Events']['detail-2'] : '' ,
                                                'detail3'        => !empty($array['Events']['detail-3']) ? $array['Events']['detail-3'] : '' ,
                                                'detail4'        => !empty($array['Events']['detail-4']) ? $array['Events']['detail-4'] : '' ,
                                                'detail5'        => !empty($array['Events']['detail-5']) ? $array['Events']['detail-5'] : '' ,

                                            ]; 
                                            // dd($deviceeventdata);                                      
                                               DeviceEvent::insert($deviceeventdata);
                                                $seqnumber++; 
                                    }

                                }

                                else 
                                {

                                     $lastec = DeviceEvent::get()->last();

                                    if ($lastec->seqno != $dscrollocseq3) {

                                            
                                        for($k = $lastec->seqno; $k<$dscrollocseq3; $k++)
                                        {
                                              $second = $k;
                                              $second = $second + 1;
                                              
                                            // array_push($cou, $second);
                                             

                                             $url = 'http://'.$deviceinfo->ipaddress.'';
                                         $username = $deviceinfo->username;
                                         $password = $deviceinfo->password;


                                             $ch = curl_init($url);                               
                                
                                            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                       
                                            curl_setopt($ch, CURLOPT_URL,"http://".$deviceinfo->ipaddress.":".$deviceinfo->portno."/device.cgi/events?action=getevent&roll-over-count=".$dscrolloc."&seq-number=".$second."&no-of-events=1&format=xml");
                                       
                                          
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                            $response = curl_exec($ch);
                                            $xml_file = simplexml_load_string($response);
                                            $json = json_encode($xml_file);
                                            $array = json_decode($json,TRUE);
                                            // dd($array);
                                            // $serialize =serialize($array);

                                            //dd($array['Events']['roll-over-count']);
                                           $dated = str_replace('/', '-', $array['Events']['date']);
                                           // $rl = $array['Events']['roll-over-count'];
                                            // exit;
                                            $deviceeventdata = [

                                                'rollovercount'  =>  $array['Events']['roll-over-count'],
                                                'seqno'          => !empty($array['Events']['seq-No']) ? $array['Events']['seq-No'] : '',
                                                'date'           => !empty(date('Y-m-d', strtotime($dated))) ? date('Y-m-d', strtotime($dated)) : '' ,
                                                'time'           => !empty(date('H:i:s', strtotime($array['Events']['time']))) ? date('H:i:s', strtotime($array['Events']['time'])) : '' ,
                                                'eventid'        => !empty($array['Events']['event-id']) ? $array['Events']['event-id'] : '' ,
                                                'detail1'        => !empty($array['Events']['detail-1']) ? $array['Events']['detail-1'] : '' ,
                                                'detail2'        => !empty($array['Events']['detail-2']) ? $array['Events']['detail-2'] : '' ,
                                                'detail3'        => !empty($array['Events']['detail-3']) ? $array['Events']['detail-3'] : '' ,
                                                'detail4'        => !empty($array['Events']['detail-4']) ? $array['Events']['detail-4'] : '' ,
                                                'detail5'        => !empty($array['Events']['detail-5']) ? $array['Events']['detail-5'] : '' ,

                                            ];                                        
                                             // dd($deviceeventdata);  

                                              DeviceEvent::insert($deviceeventdata);
                                                // $second++;
   
                                            }

                                           return redirect('viewfetchlogs');
                                    
                                          }
                                       }
                                       // -------else complited----
                                    }
                                    // ----for complited------
                                  }
                                  //if completed
                                  else{

                                     $seqnumber = $deviceseqcountid->seqno;
                                      $seqrollovercount = $deviceseqcountid->rollovercount;
                                      $dscrolloc = $deviceseqcountid->rollovercount;
                                      $dscrollocseq3 = $deviceseqcountid->seqno;
                                      $deviceinfo = DB::table('deviceinfo')
                                                  ->where('devicetype','independent')
                                                  ->where('portno', $portno_const)
                                                  ->first();

                                    for($i = 0; $i < 2; $i++)
                                    {
                                     
                                      if($seqnumber > 49999)
                                      {
                                          //echo "fsdfsdfsdfds";exit;
                                          for($r = $seqnumber; $r <= 50000; $r++)
                                          {
                                              // $first = 50000;
                                              // array_push($cou, $first);
                                                   $seqnumber = 1;
                                               $dscrolloc = $dscrolloc + 1;
                                              // print_r($dscrolloc);
                          

                                              $url = 'http://'.$deviceinfo->ipaddress.'';
                                               $username = $deviceinfo->username;
                                               $password = $deviceinfo->password;

                                               $ch = curl_init($url);
                                       
                                      
                                      curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                                      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                      curl_setopt($ch, CURLOPT_URL,"http://".$deviceinfo->ipaddress.":".$deviceinfo->portno."/device.cgi/events?action=getevent&roll-over-count=".$dscrolloc."&seq-number=".$seqnumber."&no-of-events=1&format=xml");
                                 
                                    
                                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                                  $response = curl_exec($ch);
                                                  $xml_file = simplexml_load_string($response);
                                                  $json = json_encode($xml_file);
                                                  $array = json_decode($json,TRUE);
                                                  $serialize =serialize($array);
                                                 $dated = str_replace('/', '-', $array['Events']['date']);
                                                  // exit;
                                                  $deviceeventdata = [

                                                      'rollovercount'  => $array['Events']['roll-over-count'],
                                                      'seqno'          => !empty($array['Events']['seq-No']) ? $array['Events']['seq-No'] : '',
                                                      'date'           => !empty(date('Y-m-d', strtotime($dated))) ? date('Y-m-d', strtotime($dated)) : '' ,
                                                      'time'           => !empty(date('H:i:s', strtotime($array['Events']['time']))) ? date('H:i:s', strtotime($array['Events']['time'])) : '' ,
                                                      'eventid'        => !empty($array['Events']['event-id']) ? $array['Events']['event-id'] : '' ,
                                                      'detail1'        => !empty($array['Events']['detail-1']) ? $array['Events']['detail-1'] : '' ,
                                                      'detail2'        => !empty($array['Events']['detail-2']) ? $array['Events']['detail-2'] : '' ,
                                                      'detail3'        => !empty($array['Events']['detail-3']) ? $array['Events']['detail-3'] : '' ,
                                                      'detail4'        => !empty($array['Events']['detail-4']) ? $array['Events']['detail-4'] : '' ,
                                                      'detail5'        => !empty($array['Events']['detail-5']) ? $array['Events']['detail-5'] : '' ,

                                                  ];                                        
                                                    DeviceEvent::insert($deviceeventdata);
                                                      $seqnumber++; 
                                          }
                                          // for loop completed
                                      }
                                      // if completed
                                      else 
                                {
                                     $lastec = $deviceseqcountid->seqno;

                                    if ($lastec == $dscrollocseq3) {
                                            

                                        for($k = $lastec - 1; $k<$dscrollocseq3; $k++)
                                        {
                                              $second = $k;
                                              $second = $second + 1;
                                              
                                            // array_push($cou, $second);
                                             

                                             $url = 'http://'.$deviceinfo->ipaddress.'';
                                         $username = $deviceinfo->username;
                                         $password = $deviceinfo->password;


                                             $ch = curl_init($url);                               
                                
                                            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                       
                                            curl_setopt($ch, CURLOPT_URL,"http://".$deviceinfo->ipaddress.":".$deviceinfo->portno."/device.cgi/events?action=getevent&roll-over-count=".$dscrolloc."&seq-number=".$second."&no-of-events=1&format=xml");
                                       
                                          
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                            $response = curl_exec($ch);
                                            $xml_file = simplexml_load_string($response);
                                            $json = json_encode($xml_file);
                                            $array = json_decode($json,TRUE);
                                            $serialize =serialize($array);

                                             // print_r($array);
                                           $dated = str_replace('/', '-', $array['Events']['date']);
                                             // print_r($dated);exit;
                                            $deviceeventdata = [

                                                'rollovercount'  => $array['Events']['roll-over-count'],
                                                'seqno'          => !empty($array['Events']['seq-No']) ? $array['Events']['seq-No'] : '',
                                                'date'           => !empty(date('Y-m-d', strtotime($dated))) ? date('Y-m-d', strtotime($dated)) : '' ,
                                                'time'           => !empty(date('H:i:s', strtotime($array['Events']['time']))) ? date('H:i:s', strtotime($array['Events']['time'])) : '' ,
                                                'eventid'        => !empty($array['Events']['event-id']) ? $array['Events']['event-id'] : '' ,
                                                'detail1'        => !empty($array['Events']['detail-1']) ? $array['Events']['detail-1'] : '' ,
                                                'detail2'        => !empty($array['Events']['detail-2']) ? $array['Events']['detail-2'] : '' ,
                                                'detail3'        => !empty($array['Events']['detail-3']) ? $array['Events']['detail-3'] : '' ,
                                                'detail4'        => !empty($array['Events']['detail-4']) ? $array['Events']['detail-4'] : '' ,
                                                'detail5'        => !empty($array['Events']['detail-5']) ? $array['Events']['detail-5'] : '' ,

                                            ];                                        
                                              // dd($deviceeventdata);

                                              DeviceEvent::insert($deviceeventdata);
                                                // $second++;
   
                                                }

                                            return redirect('viewfetchlogs');
                                    
                                          }
                                       }
                                    }
                                    //for completed
                                  }
                                  //else completed
                         }




   public function setemployee(Request $request){

     $susername = $request->get('setusername');
     $sdate = $request->get('setuserexpiry');
     $sdate = explode('-', $sdate);
     $setuserstatus = $request->get('setuserstatus');
     $deviceaccess =  $request->get('deviceaccess');
     $devicemobileno = $request->get('devicemobileno');

     /*echo $susername."<br>";
     echo $setuserstatus."<br>";
     echo $deviceaccess."<br>";
     dd($devicemobileno);*/


     $deuser = Employee::where('employeeid',$deviceaccess)->get()->first();

     if(!empty($deuser)){
      $fname = substr($deuser->first_name, 0, 3);
      $lname = substr($deuser->last_name, 0, 3);
      $apiusername = $fname.$lname.$deviceaccess;
     }
 
     $duser = User::where('usermobileno',$devicemobileno)->get()->first();
     

     $action = new Actionlog();
     $action->user_id = session()->get('admin_id');
     $action->ip = $request->ip();
     $action->action_type = 'insert';
     $action->action = 'Set Employee into Device';
     $action->action_on = $duser->userid;
     $action->save();

     $setuserexpiry = $request->get('setuserexpiry');
     $portno_const = config('constants.port');
     try {

       $deviceinfo = DB::table('deviceinfo')
       ->where('devicetype','independent')
       ->where('portno', $portno_const)
       ->first();

       $url = 'http://'.$deviceinfo->ipaddress.'';
       $username = $deviceinfo->username;
       $password = $deviceinfo->password;

       $if_exist = Deviceuser::where('userid', $duser->userid)->first();
       if(empty($if_exist)){


       $emp_api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$duser->userid.'&name='.$apiusername.'&ref-user-id='.$duser->userid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

       $cronjob = new ApiCronJob();
       $cronjob->apiuserid = $duser->userid;
       $cronjob->apitype = 'emp upload';
       $cronjob->api = $emp_api;
       $cronjob->response_code = '';
       $cronjob->status = 0;
       $cronjob->save();

       $deviceuser = new Deviceuser();
       $deviceuser->userid = $duser->userid; 
       $deviceuser->username = $susername; 
       $deviceuser->userrefid = $duser->userid; 
       $deviceuser->mobileno = $devicemobileno; 
       $deviceuser->rfidcardno1 = 0; 
       $deviceuser->expirydate = date('Y-m-d', strtotime($setuserexpiry)); 
       $deviceuser->enroll = 0; 
       $deviceuser->status = 2;
       $deviceuser->save();

       return 201;
      }else{
        return 201;
      }

     } catch (\Exception $e) {

      return 203;

    }


   }

   public function enrollemployee(Request $request){

    $deviceaccess = $request->get('deviceaccess');
    $devicemobileno = $request->get('devicemobileno');
    $portno_const = config('constants.port');

    $duserenroll = User::where('usermobileno',$devicemobileno)->get()->first();

    $en = Deviceuser::where('userid',$duserenroll->userid)->get()->first();

    $action = new Actionlog();
         $action->user_id = session()->get('admin_id');
         $action->ip = $request->ip();
         $action->action_type = 'insert';
         $action->action = 'Enroll Employee into Device';
         $action->action_on = $deviceaccess;
         $action->save();

      if ($en){
      if ($en->enroll == 0) {

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
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/enrolluser?action=enroll&user-id='.$duserenroll->userid.'&type=1');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = explode('=', $response);
                    
                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);
                    // dd($response);
                     
                    if ($response[1] == 0) {



                      // curl_setopt($ch, CURLOPT_URL,'http://192.168.1.50/device.cgi/users?action=get&user-id='.$setuserid.'');
                      // $response = curl_exec($ch);
                      // print_r($response);exit;
                      // if () {
                      //   # code...
                      // }
                      $d = ['enroll' => 1,'status'=>3];

                      $n = Deviceuser::where('userid',$duserenroll->userid)->update($d);
                      //echo "User Enroll Success In Device";

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

   public function enrollemployeecard($id,Request $request){

      //$enrollemployeecard = Deviceuser::findOrFail($id);
      // $enrollemployeecard->rfidcardno1 = $request->input('');

      $duserid = $id;
      $deuser = Employee::where('employeeid',$duserid)->get()->first();
      $duser = User::where('usermobileno',$deuser->mobileno)->get()->first();
      $portno_const = config('constants.port');
      $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'insert';
           $action->action = 'Enroll Card into Device';
           $action->action_on = $duser->userid;
           $action->save();

      // print_r($id);
      // print_r('sfth');
      // print_r($duser->userid);exit;

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
                    if ($response[1] == 0) {

                      echo "enroll card Successfully and id is :";
                                        }

                     // print_r($response);exit; 

         } catch (\Exception $e) {

                echo "User Already Enrolled !";
   
        }


          return redirect('users');



   }

   public function deactivedeviceemployee(Request $request){

      $setuserid = $request->get('setuserid');
      $devicemobileno = $request->get('devicemobileno');

      // dd($devicemobileno);

      $duser = User::where('usermobileno',$devicemobileno)->get()->first();
      $en = Deviceuser::where('userid',$duser->userid)->get()->first();
      $portno_const = config('constants.port');
      
      $newdate =  date("Y-m-d");
      $newdate = explode('-', $newdate);
       // print_r($newdate);exit;
      $empstatus = Employee::where('mobileno',$devicemobileno)->update(['status' => 2]);

      $action = new Actionlog();
      $action->user_id = session()->get('admin_id');
      $action->ip = $request->ip();
      $action->action_type = 'update';
      $action->action = 'Deactive Employee';
      $action->action_on = $duser->userid;
      $action->save();
           
      try {
        $deviceinfo = DB::table('deviceinfo')
                  ->where('devicetype','independent')
                  ->where('portno', $portno_const)
                  ->first();
        if($deviceinfo){
          $url = 'http://'.$deviceinfo->ipaddress.'';
    
          $username = $deviceinfo->username;
          $password = $deviceinfo->password;
          //Initiate cURL.
          $emp_api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$duser->userid.'&ref-user-id='.$duser->userid.'&validity-enable=1&validity-date-dd='.$newdate[2].'&validity-date-mm='.$newdate[1].'&validity-date-yyyy='.$newdate[0].'';

          $cronjob = new ApiCronJob();
          $cronjob->apiuserid= $duser->userid;
          $cronjob->apitype= 'deactive employee';
          $cronjob->api= $emp_api;
          $cronjob->response_code= '';
          $cronjob->status= 0;
          $cronjob->save();
          $status = Deviceuser::where('userid',$duser->userid)->update(['status' => 0]);
        }
        
      
        echo "User Deactiveted !";
                    
        } catch (\Exception $e) {
              
                 echo "Your Device Not connected !";
   
        }

    }

    public function activedeviceemployee(Request $request){

      $devicemobileno = $request->get('devicemobileno');

      // dd($devicemobileno);
      $portno_const = config('constants.port');




      $duser = User::where('usermobileno',$devicemobileno)->get()->first();
            // dd($devicemobileno);

      $status = Deviceuser::where('userid',$duser->userid)->update(['status' => 1]);
      $empstatus = Employee::where('mobileno',$devicemobileno)->update(['status' => 1]);

      $deviceuser_data = Deviceuser::where('userid',$duser->userid)->get()->first();
      if($deviceuser_data){

     
          $newdate = explode('-', date('Y-m-d', strtotime($deviceuser_data->expirydate)));
       // print_r($newdate);exit;

          $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'update';
           $action->action = 'Deactive Employee';
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
                     
                    //Initiate cURL.
                   $emp_api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$duser->userid.'&ref-user-id='.$duser->userid.'&validity-enable=1&validity-date-dd='.$newdate[2].'&validity-date-mm='.$newdate[1].'&validity-date-yyyy='.$newdate[0].'';

                    $cronjob = new ApiCronJob();
                    $cronjob->apiuserid= $duser->userid;
                    $cronjob->apitype= 'active employee';
                    $cronjob->api= $emp_api;
                    $cronjob->response_code= '';
                    $cronjob->status= 0;
                    $cronjob->save();

                      $status = Deviceuser::where('userid',$duser->userid)->update(['status' => 1]);
                      $empstatus = Employee::where('mobileno',$devicemobileno)->update(['status' => 1]);
                      echo "User Activeted !";
                    
         } catch (\Exception $e) {
              
                 echo "Your Device Not connected !";
   
        }
      }else{
          echo 'User Activated But Can\'t set in device caues of not enroll in device';
      }

    }

    public function setuserfromsummary_old(Request $request){

     $specify = $request->get('specify');


       if (!empty($request['for'])) {
      
      $userid = $request['deviceid'];
      $sdate = explode('-', $request['validity']);
      $fusername = $request['beltusername'];
      $joindate = date('Y-m-d');

    }
    
     if (!empty($specify)) {
      
      $userid = $request->get('userid');
      // $userid = '504';
      $joindate = $request->get('joindate');
      $joindate = date('Y-m-d',strtotime($joindate));
      $enddate = $request->get('enddate');
      $fusername = $request->get('fusername');
      $fusername = str_replace(' ', '', $fusername);
      $mobileno = $request->get('mobileno');
      $sdate = explode('-',$joindate);
      $setuserexpiry = $request->get('setuserexpiry');

     }

     if (!empty($request->setuserforfreezemembershipdevice['freezemembershipuserid'])){
      $userid = $request->setuserforfreezemembershipdevice['freezemembershipuserid'];
      $fusername = $request->setuserforfreezemembershipdevice['freezemembershipname'];
      $fusername = str_replace(' ', '', $fusername);
      $mobileno = $request->setuserforfreezemembershipdevice['freezemembershipmobileno'];
      $sdate = explode('-', date('Y-m-d'));
      $setuserexpiry = date('Y-m-d');

     }
      $portno_const = config('constants.port');

  $deviceinfo = DB::table('deviceinfo')
          ->where('devicetype','independent')
          ->where('portno', $portno_const)
          //->where('reader','no')
          ->first();


     try {  


            if ($deviceinfo) {
                     
 
                    $url = 'http://'.$deviceinfo->ipaddress.''; 
                    //Your username.
                    $username = $deviceinfo->username;
                     
                    //Your password.
                    $password = $deviceinfo->password;

                    $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&name='.$fusername.'&ref-user-id='.$userid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';


              if (!empty($specify)) {

                if (date('Y-m-d') == $joindate) {

                    $sdate = explode('-', date('Y-m-d'));
                 
                  $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&name='.$fusername.'&ref-user-id='.$userid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

                }else{

                  $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&ref-user-id='.$userid.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

                    $data = ['userid'=>$userid,'apiset'=>$api,'startdate'=>$joindate,'status'=> 0];

                    Apischedule::insert($data);

                }

              }



                    // $test = get_headers($url);
                    //  $test = 'connected';
                     
                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,$api);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);

                     $action = new Actionlog();
                     $action->user_id = session()->get('admin_id');
                     $action->ip = $request->ip();
                     $action->action_type = 'insert';
                     $action->action = 'Set into Device';
                     $action->save();

                    $response = explode('=', $response);
                    
                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);

                   

                    if ($response[1] == 0) {


                      // return response()->with('message','ok');     
                      // echo "User Set Success In Device Plese Go To Enroll User and Put Your RFID Card Near To Reader !";

                      if (!empty($specify) || !empty($request->setuserforfreezemembershipdevice['freezemembershipuserid'])) {
                      
                          $data = [

                                'userrefid' => $userid,
                                'userid' => $userid,
                                'username' => $fusername,
                                'status' => 2,
                                'mobileno' => $mobileno,
                                'expirydate' => $setuserexpiry,

                              ];

                             $deviceuser =  Deviceuser::where('userid',$userid)->first();

                             if (!empty($deviceuser)) {
                                Deviceuser::where('userid',$userid)->update(['status' => 2,]);
                             }else{
                                 DB::table('deviceusers')->insert($data);
                             }
                          }
                        
                       $apistatus = 'Success';

                    }else{
                       $apistatus = 'Failure';
                    }

                    if (!empty($request['for'])) {
                      $request->request->add(['setapistatus' => $apistatus]);
                    }

                    if (!empty($request->setuserforfreezemembershipdevice)) {
                      $request->request->add(['freezemembershipapistatus' => $apistatus]);
                    }

                      $apitrack = new ApiTrack();
                      $apitrack->userid = $userid;
                      $apitrack->apitype = 'Set User';
                      $apitrack->api = $api;
                      $apitrack->apiresponse = $response[1];
                      $apitrack->save();

                     echo json_encode($apistatus);


                    
                   // sleep(10);  
                }


         } catch (\Exception $e) {

                echo "Your Device Not connected !";
   
        }

  }

  public function setuserfromsummary(Request $request){
      $specify = $request->get('specify');
      $portno_const = config('constants.port');
      $useralready_set = 0;

      //any time access start
      if (!empty($request['for'])) {

        $userid = $request['deviceid'];
        $sdate = explode('-', $request['validity']);
        $fusername = $request['beltusername'];
        $joindate = date('Y-m-d');

      }

      //any time access end

      //payment summary start
      if (!empty($specify)) {

        $userid = $request->get('userid');
        $joindate = $request->get('joindate');
        $joindate = date('Y-m-d',strtotime($joindate));
        $enddate = $request->get('enddate');
        $fusername = $request->get('fusername');
        $fusername = str_replace(' ', '', $fusername);
        $mobileno = $request->get('mobileno');
        $sdate = explode('-',$joindate);
        $setuserexpiry = $request->get('setuserexpiry');

        $memberpackages_exp_date = MemberPackages::where('userid', $userid)->where('status', 1)->max('expiredate');

      }
      //payment summary end

      // freezemembership start
      if (!empty($request->setuserforfreezemembershipdevice['freezemembershipuserid'])){
        $userid = $request->setuserforfreezemembershipdevice['freezemembershipuserid'];
        $fusername = $request->setuserforfreezemembershipdevice['freezemembershipname'];
        $fusername = str_replace(' ', '', $fusername);
        $mobileno = $request->setuserforfreezemembershipdevice['freezemembershipmobileno'];
        $sdate = explode('-', date('Y-m-d'));
        $setuserexpiry = date('Y-m-d');
      }
      // freezemembership end

      //deviceuser start
      $deviceuser_data = Deviceuser::where('userid', $userid)->first();
      if(!empty($deviceuser_data)){
        $useralready_set = 1;
      }
      //deviceuser end
      /// Get Firstname and lastname start

      $member_data = Member::where('userid', $userid)->first();
      if(!empty($member_data)){
        $fname = substr($member_data->firstname, 0, 3);
        $lname = substr($member_data->lastname, 0, 3);
        $fusername = $fname.$lname.$userid;
        $fusername = str_replace(' ', '', $fusername);
      }


      /// Get Firstname and lastname end
      $deviceinfo = DB::table('deviceinfo')
      ->where('devicetype','independent')
      ->where('portno', $portno_const)
      ->first();

        try{
    
            if ($deviceinfo) {
                     
 
                    $url = 'http://'.$deviceinfo->ipaddress.''; 
                    //Your username.
                    $username = $deviceinfo->username;
                     
                    //Your password.
                    $password = $deviceinfo->password;
                    
                  // payment summary start  
                    if (!empty($specify)) {
                        $sdate = explode('-', date('Y-m-d', strtotime($memberpackages_exp_date)));
                        //dd($joindate);
                      if (date('Y-m-d', strtotime($joindate)) <= date('Y-m-d')) {
                        
                        if($useralready_set == 1){

                          $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&ref-user-id='.$userid.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

                        }else{

                          $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&name='.$fusername.'&ref-user-id='.$userid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';
                        }

                        $cronjob = new ApiCronJob();
                        $cronjob->apiuserid = $userid;
                        $cronjob->api = $api;
                        if($useralready_set == 1){
                          $cronjob->apitype = 'expiry set';
                        }else{
                          $cronjob->apitype = 'user upload';
                        }
                        $cronjob->response_code = '';
                        $cronjob->status = 0;
                        $cronjob->save();

                        if($useralready_set == 0){
                          $deviceusers = new Deviceuser();
                          $deviceusers->userid = $userid;
                          $deviceusers->userrefid = $userid;
                          $deviceusers->mobileno = $mobileno;
                          $deviceusers->username = $fusername;
                          $deviceusers->rfidcardno1 = 0;
                          $deviceusers->expirydate = date('Y-m-d', strtotime($memberpackages_exp_date));
                          $deviceusers->enroll = 0;
                          $deviceusers->status = 2;
                          $deviceusers->save();
                        }
                        
                        if($useralready_set == 0){
                          return 201;
                        }else{
                          return 203;
                        }

                      }else{
                        // store in apicronjob for today access start
                        $sdate_today = explode('-', date('Y-m-d'));
                        if($useralready_set == 0){

                          $api_today = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&name='.$fusername.'&ref-user-id='.$userid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate_today[2].'&validity-date-mm='.$sdate_today[1].'&validity-date-yyyy='.$sdate_today[0].'';

                            $cronjob = new ApiCronJob();
                            $cronjob->apiuserid = $userid;
                            $cronjob->apitype = 'user upload';
                            $cronjob->api = $api_today;
                            $cronjob->response_code = '';
                            $cronjob->status = 0;
                            $cronjob->save();
                        }

                        // store in apicronjob for today access end

                        // store in apischedule for max expiry start
                        $enddate_schedule = date('Y-m-d', strtotime($memberpackages_exp_date));
                        $sdate = explode('-',$enddate_schedule);
                        $api_schedule = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&ref-user-id='.$userid.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';
                        $data = ['apiset'=>$api_schedule,'startdate'=>$joindate,'status'=> 0, 'userid' => $userid];
                        Apischedule::insert($data);

                        

                        $deviceusers = Deviceuser::where('userid', $userid)->first();
                        if(empty($deviceusers)){

                          $deviceusers_new = new Deviceuser();
                          $deviceusers_new->userid = $userid;
                          $deviceusers_new->userrefid = $userid;
                          $deviceusers_new->username = $fusername;
                          $deviceusers_new->mobileno = $mobileno;
                          $deviceusers_new->rfidcardno1 = 0;
                          $deviceusers_new->expirydate = date('Y-m-d', strtotime($memberpackages_exp_date));
                          $deviceusers_new->enroll = 0;
                          $deviceusers_new->status = 2;
                          $deviceusers_new->save();

                        }else{

                          $deviceusers->expirydate = date('Y-m-d', strtotime($memberpackages_exp_date));
                          $deviceusers->save();

                        }

                        if($useralready_set == 0){
                          return 201;
                        }else{
                          return 203;
                        }
                        // store in apischedule for max expiry end                 
                      }
                    }
                  // payment summary end


                    //anttime access start
                    if (!empty($request['for'])) {

                      $api_anytimeaccess = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&name='.$fusername.'&ref-user-id='.$userid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

                      $cronjob = new ApiCronJob();
                      $cronjob->apiuserid = $userid;
                      $cronjob->apitype = 'any time access';
                      $cronjob->api = $api_anytimeaccess;
                      $cronjob->response_code = '';
                      $cronjob->status = 0;
                      $cronjob->save();


                      
                      $apistatus = 'Success';
                      $request->request->add(['setapistatus' => $apistatus]);
                     

                    }
                    //anytime access end

                     /*$action = new Actionlog();
                     $action->user_id = session()->get('admin_id');
                     $action->ip = $request->ip();
                     $action->action_type = 'insert';
                     $action->action = 'Set into Device';
                     $action->save();


                    
                
                   
                      $apitrack = new ApiTrack();
                      $apitrack->userid = $userid;
                      $apitrack->apitype = 'Set User';
                      $apitrack->api = $api;
                      $apitrack->save();
                     echo json_encode($apistatus);*/
                    
                   // sleep(10);  
                }else{
                  return 205;
                }
              } catch(\Exception $e) {
                return 204;
              }
       
  }


   public function enrolluserfromsummary(Request $request){

    $specify = $request->get('specify');
    $portno_const = config('constants.port');
    $reassigncard = $request->get('reassigncard');

    if (!empty($request['for'])) {

     $userid = $request->get('deviceid');
    // $userid = '504';

    }
    // dd($userid);

     if (!empty($specify)) {

       $userid = $request->get('userid');
     }

     
     
              try {
                    
                    $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              //->where('reader','no')
                              ->first();

                if ($deviceinfo) {

                   $url = 'http://'.$deviceinfo->ipaddress.'';
                     
                    //Your username.
                    $username = $deviceinfo->username;
                     
                    //Your password.
                    $password = $deviceinfo->password;

                    $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/enrolluser?action=enroll&user-id='.$userid.'&type=1';



                    if (!empty($reassigncard)) {
                      $this->reassigncard1details($request);
                    }
                     
                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/enrolluser?action=enroll&user-id='.$userid.'&type=1');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    // dd($response);

                   $action = new Actionlog();
                   $action->user_id = session()->get('admin_id');
                   $action->ip = $request->ip();
                   $action->action_type = 'insert';
                   $action->action = 'Enroll Card';
                   $action->save();
  
                    
                    $response = explode('=', $response);
                    
                    
                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);

                      

                    if ($response[1] == 0) {

                       sleep(10);
                       // dd($request);
                       $this->fetchdeviceuserconfig($request);
                       
                       
                       $cardno = $request->fetchdeviceuserconfigfromenroll['card1'];
 
                        if ($cardno != '0') {

                          if (!empty($specify)) {
                         
                          $ach = Deviceuser::where('userid',$userid)->where('enroll',1)->first();

                          if ($ach) {

                           $achlog = new Assigncardhistory();
                           $achlog->userid = $userid;
                           $achlog->action = 'Reassign';
                           $achlog->save();

                          }else{

                           $achlog = new Assigncardhistory();
                           $achlog->userid = $userid;
                           $achlog->action = 'Assign';
                           $achlog->save();

                          }

                          $status = Deviceuser::where('userid',$userid)->update(['status' => 3,'enroll' => 1]);

                           # code...
                         
                        }else{

                          if (!empty($request['for'])) {
                          $status = AnyTimeAccessBelt::where('deviceid',$userid)->update(['enrollstatus' => 1]);
                         }
                        }

                    }else{

                        if (!empty($request['for'])) {
                        $request->request->add(['enrollapistatus' => $cardno]);
                        }

                        echo 0;

                    }

                        $apitrack = new ApiTrack();
                        $apitrack->userid = $userid;
                        $apitrack->apitype = 'Enroll User Api';
                        $apitrack->api = $api;
                        $apitrack->apiresponse = $response[1];
                        $apitrack->save();

                        $apistatus = 'Success';

                    }else{

                       $apistatus = 'Failure';
                    }

                    echo  json_encode($apistatus);

                     // sleep(10);          

                }

                     // print_r($response);exit; 

         } catch (\Exception $e) {

                echo "Your Device Not connected !";
   
        }

   

  }

  public function enrollcardcomman(Request $request){
      $portno_const = config('constants.port');
      if (!empty($request['for'])) {
         $userid = $request->get('deviceid');
        }

        $specify = $request->get('specify');

        if (!empty($specify)) {
          $userid = $request->get('userid');
        }

        $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              //->where('reader','no')
                              ->first();

                              // sleep(10);

      
       try {
                    

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;


                    $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=get&user-id='.$userid.'&format=xml';

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,$api);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                  
                    $xml_file = simplexml_load_string($response);
                    $json = json_encode($xml_file);
                    $array = json_decode($json,TRUE);

                    $cuserdata = [
                                    'rfidcardno1'   => $array['card1'],
                                  ];


                       if (!empty($request['for'])) {

                       AnyTimeAccessBelt::where('deviceid', $userid)->update($cuserdata);

                      }else{

                        Deviceuser::where('userid', $userid)->update($cuserdata);

                      }


                        $action = new Actionlog();
                         $action->user_id = session()->get('admin_id');
                         $action->ip = $request->ip();
                         $action->action_type = 'insert';
                         $action->action = 'Enroll Card into Device';
                         $action->action_on = $duser->userid;
                         $action->save();


                    if ($response[1] == 0) {

                        $apitrack = new ApiTrack();
                        $apitrack->userid = $userid;
                        $apitrack->apitype = 'Enroll Card';
                        $apitrack->api = $api;
                        $apitrack->apiresponse = 0;
                        $apitrack->save();

                       $apistatus = 'Success';   
                            
                      }else{
                         $apistatus = 'Failure';
                      }

                      echo json_encode($apistatus);

         }catch (\Exception $e){

                echo "User Already Enrolled !";
   
        }

      

    }


    public function extendexpiry(Request $request){

      // dd($request);
      $portno_const = config('constants.port');
      $today = explode('-', date('Y-m-d'));
      $isalreadyenroll = 0;
      $extendexpiry =  $request->get('extendexpiry');
      $upgradepackageextendexpiry = $request->get('upgradepackageextendexpiry');

      if (!empty($request['for'])) {
      $userid = $request['deviceid'];
      $sdate = explode('-', $request['validity']);
      $fusername = $request['beltusername'];  
     }

    if (!empty($request->TransferMembership)) {

      $tmefuser = MemberPackages::where('userid',$request->TransferMembership['TransferMembershipfromuser'])->where('status',1)->max('expiredate');


      $tmetuser = MemberPackages::where('userid',$request->TransferMembership['TransferMembershiptouser'])->where('status',1)->max('expiredate');

       
      if (!empty($tmefuser)) {
        $TMfuser = $request->TransferMembership['TransferMembershipfromuser'];
        $sdate = explode('-', $tmefuser);
      }else{
        $TMfuser = $request->TransferMembership['TransferMembershipfromuser'];
      }

      if (!empty($tmetuser)) {
        $TMtouser = $request->TransferMembership['TransferMembershiptouser'];
        $sdate2 = explode('-', $tmetuser);
      }
    }

    if (!empty($request->setuserforfreezemembershipdevice['freezemembershipuserid'])) {
      $userid = $request->setuserforfreezemembershipdevice['freezemembershipuserid'];
      $freezemsetexpiry = $request->setuserforfreezemembershipdevice['freezemembershipdate'];
      $sdate = explode('-', $freezemsetexpiry);
    }

    if (!empty($request->unfreezemembershipdevice['unfreezemembershipuserid'])) {
      $userid = $request->unfreezemembershipdevice['unfreezemembershipuserid'];
      $unfreezesetexpiry = $request->unfreezemembershipdevice['unfreezemembershippdate'];
      $sdate = explode('-', $unfreezesetexpiry);
    }

    if (!empty($extendexpiry)) {
      $userid = $request->get('userid');
      $setextendexpiry = $request->get('setextendexpiry');
      $sdate = explode('-', $setextendexpiry);
    }    

    if (!empty($upgradepackageextendexpiry)){
      $userid = $request['upgradepackageuserid'];
      $upgradepackageexpirydate = $request['upgradepackageexpirydate'];
      $memberpackages_exp_date = MemberPackages::where('userid', $userid)->where('status', 1)->max('expiredate');
      $sdate = explode('-', date('Y-m-d', strtotime($memberpackages_exp_date)));
    }

    if(empty($request->TransferMembership)){
      $deviceusers = Deviceuser::where('userid', $userid)->first();
      if(!empty($deviceusers)){
        $isalreadyenroll = 1;
      } 
    }

     // dd($sdate);

      $deviceinfo = DB::table('deviceinfo')
        ->where('devicetype','independent')
        ->where('portno', $portno_const)
        ->first();


      try {
                  if ($deviceinfo) {
                   
                    $url = 'http://'.$deviceinfo->ipaddress.'';                
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;

                    if (empty($request->TransferMembership['TransferMembershipfromuser']) && empty($request->TransferMembership['TransferMembershiptouser'])) {

                     $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&ref-user-id='.$userid.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

                   }

                      if (!empty($extendexpiry) || !empty($request->setuserforfreezemembershipdevice['freezemembershipuserid']) || !empty($request->unfreezemembershipdevice['unfreezemembershipuserid']) || !empty($upgradepackageextendexpiry) || !empty($request['for'])) {

                        if(!empty($extendexpiry)){
                          $apitype = 'extend expiry set';
                        }else if(!empty($request->setuserforfreezemembershipdevice['freezemembershipuserid'])){
                          $apitype = 'freezemembership expiry set';

                        }else if(!empty($request->unfreezemembershipdevice['unfreezemembershipuserid'])){
                          $apitype = 'unfreezemembership expiry set';

                        }else if(!empty($request['for'])){
                          $apitype = 'accesscard expiry extend';

                        }else{
                          $apitype = 'upgradepackage expiry set';

                        }
                     

                          $data = ['api' => $api, 'status'=> 0, 'apiuserid' => $userid, 'apitype' => $apitype, 'response_code' => ''];
                         
                         ApiCronJob::insert($data);

                         $message = 'Success';

                         $request->request->add(['messagestatus' => $message]);

                         return $message;
                      }

                      if (!empty($request->TransferMembership['TransferMembershipfromuser']) && !empty($request->TransferMembership['TransferMembershiptouser'])) {

                        if (!empty($tmefuser) && !empty($request->TransferMembership['TransferMembershipfromuser'])) {

                        $api1 = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$TMfuser.'&ref-user-id='.$TMfuser.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';
                        }else{

                          $api1 = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$TMfuser.'&ref-user-id='.$TMfuser.'&validity-enable=1&validity-date-dd='.$today[2].'&validity-date-mm='.$today[1].'&validity-date-yyyy='.$today[0].'';

                        }


                        if (!empty($tmetuser) && !empty($request->TransferMembership['TransferMembershiptouser'])) {

                          $api2 = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$TMtouser.'&ref-user-id='.$TMtouser.'&validity-enable=1&validity-date-dd='.$sdate2[2].'&validity-date-mm='.$sdate2[1].'&validity-date-yyyy='.$sdate2[0].'';
                        }

                        $transmfb = new ApiCronJob();
                        $transmfb->apiuserid = $TMfuser;
                        $transmfb->api = $api1;
                        $transmfb->apitype = 'transfermembership expiry set';
                        $transmfb->response_code = '';
                        $transmfb->status = 0;
                        $transmfb->save();

                        $transmfb = new ApiCronJob();
                        $transmfb->apiuserid = $TMtouser;
                        $transmfb->api = $api2;
                        $transmfb->apitype = 'transfermembership expiry set';
                        $transmfb->response_code = '';
                        $transmfb->status = 0;
                        $transmfb->save();

                        $message = 'Success';

                        return $message;

                      }

                      /*$apitrack = new ApiTrack();
                      $apitrack->userid = $userid;
                      $apitrack->apitype = 'Extend Expiry';
                      $apitrack->api = $api;
                      $apitrack->apiresponse = 0;
                      $apitrack->save();
*/
                      $action = new Actionlog();
                      $action->user_id = session()->get('admin_id');
                      $action->ip = $request->ip();
                      $action->action_type = 'update';
                      $action->action = 'Extend Expiry';
                      $action->action_on = $userid;
                      $action->save();
                     
                    //Initiate cURL.
                   /* $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,$api);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = explode('=', $response);*/

                    // dd($response);
                    
                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);

                     
                    
                  }



         } catch (\Exception $e) {

              
                 echo "Your Device Not connected !";
   
        }

    
    }

    public function reassigncard1details(Request $request){

       // $action = new Actionlog();
       //     $action->user_id = session()->get('admin_id');
       //     $action->ip = $request->ip();
       //     $action->action_type = 'insert';
       //     $action->action = 'Reassign Card into Device';
       //     $action->action_on = $duser->userid;
       //     $action->save();
      $userid = $request['userid'];
      $portno_const = config('constants.port');

      $deviceinfo = DB::table('deviceinfo')
        ->where('devicetype','independent')
        ->where('portno', $portno_const)
        //->where('reader','no')
        ->first();


         try {

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;
                     
                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&card1=0');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = explode('=', $response);
                    
                    //  $xml_file = simplexml_load_string($response);
                    //  $json = json_encode($xml_file);
                    // $array = json_decode($json,TRUE);
                    
                     
                    if ($response[1] == 0) {

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


    public function enrolldevicecomman(Request $request){

       $users = User::join('memberpackages', 'users.userid', 'memberpackages.userid')->where('userstatus','mem')->where('memberpackages.status', '!=', 0)->get()->all();


        if ($request->isMethod('post')) {
          
        }
        return view('admin.device.enrollforall',compact('users'));
    }

    public function enrolldevicecommanemp(Request $request){

      $users = User::where('userstatus','emp')->get()->all();

        if ($request->isMethod('post')) {
          
        }
        return view('admin.device.enrollforemployee',compact('users'));
    }

    public function getuserajax(Request $request){

      $uid =  $request->get('uid');

       // print_r($uid);

      $user = User::leftjoin('memberpackages','memberpackages.userid','=','users.userid')
              ->where('users.userid',$uid)
              ->where('users.userstatus','mem')
              ->addSelect('memberpackages.userid as muserid','memberpackages.*','users.*')
              ->first();

        // dd($user);

      echo json_encode($user);
    }

    public function userenrollstatus(Request $request){

      $uid =  $request->get('uid');

      // $deviceuser = Deviceuser::leftjoin('memberpackages','memberpackages.userid','=','deviceusers.userid')
      //               ->where('deviceusers.userid',$uid)
      //               ->addSelect('memberpackages.userid as muserid','memberpackages.*','deviceusers.*')
      //               ->first();

      $deviceuser = MemberPackages::leftjoin('deviceusers','memberpackages.userid','=','deviceusers.userid')
                    ->where('memberpackages.userid',$uid)
                    ->addSelect('memberpackages.userid as muserid','memberpackages.*','deviceusers.*')
                    ->first();

        // dd($deviceuser);

      echo json_encode($deviceuser);

    }

    public function userenrollmemberpackagesdetails(Request $request){

       $uid =  $request->get('uid');

       $packagedetails = MemberPackages::leftjoin('schemes','schemes.schemeid','=','memberpackages.schemeid')
                    ->where('memberpackages.userid',$uid)
                    ->where('memberpackages.status',1)
                    ->get()
                    ->all();

        $maxex = MemberPackages::leftjoin('schemes','schemes.schemeid','=','memberpackages.schemeid')
                    ->where('memberpackages.userid',$uid)
                    ->where('memberpackages.status',1)
                    ->max('expiredate');

        // dd($maxex);
        $uempd = [ 'packagedetails' => $packagedetails, 'maxex'=>$maxex ];

      echo json_encode($uempd);

    }


    public function devicedatabackup(Request $request){

      $d = Carbon::now()->toDateString();
      $sdate = explode('-', $d);
      // dd($sdate);
      $portno_const = config('constants.port');
       $deviceinfo = DB::table('deviceinfo')
          ->where('devicetype','independent')
          ->where('portno', $portno_const)
          //->where('reader','no')
          ->first();

          // $card = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&card1=0';


      for ($i=1; $i<=500 ; $i++) {

        $user = 'User'.$i;
        $card = '100'.$i;

         $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$i.'&name='.$user.'&ref-user-id='.$i.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'&card2='.$card.'';

          // print_r($api);echo "<br/>";

           // $data = ['api'=> $api, ];

          // DB::table('apibackuptest')->insert($data);

            try {  

                    if ($deviceinfo) {
                     
 
                    $url = 'http://'.$deviceinfo->ipaddress.''; 
                    //Your username.
                    $username = $deviceinfo->username;
                     
                    //Your password.
                    $password = $deviceinfo->password;


                    // print_r($api);



                    // $test = get_headers($url);
                    //  $test = 'connected';
                     
                    //Initiate cURL.
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,$api);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);

                 
                  }

                      // print_r($response);

              } catch (\Exception $e) {

                echo "Your Device Not connected !";
   
        
            }

      }

      // $data = ['api'=> $api]

      // DB::table('apibackuptest')->insert($data);

    }

    public function fetchdeviceuserconfig(Request $request){

      // dd($request->userid);

      $portno_const = config('constants.port');
      $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              //->where('reader','no')
                              ->first();
            try {

                ;

            $url = 'http://'.$deviceinfo->ipaddress.'';
            $username = $deviceinfo->username;
            $password = $deviceinfo->password;



             if (!empty($request['for'])) {

                 $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=get&user-id='.$request['deviceid'].'&format=xml';

              }else{

                $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=get&user-id='.$request->userid.'&format=xml';
              }

              // $ch = curl_init($url);
              //       curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
              //       curl_setopt($ch, CURLOPT_URL,$api);
              //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              //       $response = curl_exec($ch);
              //       // curl_close($ch);
              //       // $response = explode('=', $response);

              //         $xml_file = simplexml_load_string($response);
              //         $json = json_encode($xml_file);
              //         $array = json_decode($json,TRUE);

                      // $arraytest = [

                      //               'user-id' => $array['user-id'],
                      //               'user-index' => $array['user-index'],
                      //               'ref-user-id' => $array['ref-user-id'],
                      //               'name' => $array['name'],
                      //               'user-active' => $array['user-active'],
                      //               'vip' => $array['vip'],
                      //               'validity-enable' => $array['validity-enable'],
                      //               'validity-date-dd' => $array['validity-date-dd'],
                      //               'validity-date-mm' => $array['validity-date-mm'],
                      //               'validity-date-yyyy' => $array['validity-date-yyyy'],
                      //               'user-pin' => $array['user-pin'],
                      //               'card1' => $array['card1'],
                      //               'card2' => $array['card2'],
                      //              ];



            // dd($api);


            $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_URL,$api);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    // $response = explode('=', $response);

                     $xml_file = simplexml_load_string($response);
                      $json = json_encode($xml_file);
                     $array = json_decode($json,TRUE);

                 $request->request->add(['fetchdeviceuserconfigfromenroll' => $array,]);
 
             // dd($request);
              
            } catch (Exception $e) {
              
            }   

    }

    public function apischedual(){

      return view('script_apischedule');
    }


    public function summarymaxexpiry(Request $request){

      $userid = $request->get('userid');
      $enddate = date('Y-m-d',strtotime($request->get('enddate')));

      $maxpexpiry = MemberPackages::where('userid',$userid)->get()->max('expiredate');

      if (!empty($maxpexpiry)) {

          if ($maxpexpiry >= $enddate) {
            
            echo json_encode($maxpexpiry);

          }else{

            $maxpexpiry1 = 'small';

            echo json_encode($maxpexpiry1);

        }
      }

    }

    ///////////////////////////////////////////// device status start /////////////////////////////////////////
      public function devicestatusheader(Request $request){

       $deviceinfo = DB::table('deviceinfo')
                                 
       ->get()->all();
       $output = '';
       $result = '';

      if (!empty($deviceinfo)) {



        foreach ($deviceinfo as $dinfo) {

         try {

          

          $url = 'http://'.$dinfo->ipaddress.':'.$dinfo->portno.'';
          $username = $dinfo->username;
          $password = $dinfo->password;

                      //Initiate cURL.
          $ch = curl_init($url);
          $test_responseed = get_headers($url);
          $dinfo->status = 'connected'; 

          return 201;


        } catch (\Exception $e) {

          $dinfo->status= 'Disconnected';
          return 202;


        }
      }




    }else{
      return 201;

    }

  }
    ///////////////////////////////////////////// device status end ///////////////////////////////////////////

  ///////////////////////////////////////////////// user exist ///////////////////////////////////////////////

  public function ifuserset(){

    $userid = $_REQUEST['userid'];
    $joindate = $_REQUEST['joindate'];
    $sdate = explode('-',$joindate);
    $portno_const = config('constants.port');
    $if_userset = Deviceuser::where('userid', $userid)->first();
    if(!empty($if_userset)){

      $deviceinfo = DB::table('deviceinfo')
          ->where('devicetype','independent')
          ->where('portno', $portno_const)
          //->where('reader','no')
          ->first();

      if ($deviceinfo) {

        if (date('Y-m-d') == $joindate) {

          $sdate = explode('-', date('Y-m-d'));

          $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&name='.$fusername.'&ref-user-id='.$userid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

          return 201;

        }else{

          $api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&ref-user-id='.$userid.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

          $data = ['apiset'=>$api,'startdate'=>date('Y-m-d', strtotime($joindate)),'status'=> 0];

          Apischedule::insert($data);

          return 201;

        }

      }else{
        return 203;//device not found
      }

    }else{
      return 202;
    }



  }

  ///////////////////////////////////////////////// user exist end///////////////////////////////////////////////

  public function cardexist(){

    $cardno = $_REQUEST['cardno'];
    $empcard = !empty($_REQUEST['empcard']) ? $_REQUEST['empcard'] : 0 ;
    $fullname = '';
    $img = '';
    $iscardexist = Deviceuser::where('rfidcardno1',  $cardno)->first();
    //dd($iscardexist);
    if(empty($iscardexist)){
      $anytime = AnyTimeAccessBelt::where('rfidcardno1', $cardno)->first();
      if(empty($anytime)){
        return 201;
      }else{
        $fullname = 'Anytime Access';
        $img = null;
        return [$fullname, $img];
      }
    }else{

      $memberdata = Member::where('userid', $iscardexist->userid)->first();
      if(!empty($memberdata)){
        $img = $memberdata->photo;
        $fullname = ucfirst($memberdata->firstname).' '.ucfirst($memberdata->lastname);
      }else{
        $empdata = Employee::where('userid', $iscardexist->userid)->first();
        if(!empty($empdata)){
          $img = $empdata->photo;
          if(empty($img)){
            $img = null;
          }
          $fullname = ucfirst($empdata->first_name).' '.ucfirst($empdata->last_name);
        }
      }

      return [$fullname, $img];
    }

  }

  public function enrollfinalcard(){

    $cardno = $_REQUEST['finalcard'];
    //$reassigncard = $_REQUEST['reassigncard'];

    
    $mobileno = !empty($_REQUEST['mobileno']) ? $_REQUEST['mobileno'] : '';

    if(!empty($mobileno)){
      $duser = User::where('usermobileno',$mobileno)->get()->first();
      $userid = $duser->userid;
    }else{
      $userid = $_REQUEST['userid'];
    }

    $memberpackages = MemberPackages::where('userid', $userid)->where('status', 1)->max('expiredate');
   
      $expirydate = $memberpackages;
  
    $portno_const = config('constants.port');
    $sdate = explode('-', $expirydate);

    $deviceinfo = DB::table('deviceinfo')
    ->where('devicetype','independent')
    ->where('portno', $portno_const)
    ->first();


    /*try {*/

      /*if(!empty($reassigncard)){

        $deviceusers_data = Deviceuser::where('userid', $userid)->first();

        $old_card = $deviceusers_data->rfidcardno1;

        $old_card_api = 'http://192.168.1.79/device.cgi/users?action=set&user-id=12&card1=0';

      }*/

      $url = 'http://'.$deviceinfo->ipaddress.'';

      $username = $deviceinfo->username;
      $password = $deviceinfo->password;

      $card_api = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&card1='.$cardno.'';

      $cronjob = new ApiCronJob();
      $cronjob->apiuserid = $userid;
      $cronjob->api = $card_api;
      $cronjob->apitype = 'enroll card';
      $cronjob->response_code = '';
      $cronjob->status = 0;
      $cronjob->save();

      $ach = Deviceuser::where('userid',$userid)->where('enroll',1)->first();

      if ($ach) {

       $achlog = new Assigncardhistory();
       $achlog->userid = $userid;
       $achlog->action = 'Reassign';
       $achlog->save();

     }else{

       $achlog = new Assigncardhistory();
       $achlog->userid = $userid;
       $achlog->action = 'Assign';
       $achlog->save();

     }

      $admin = session()->get('username');
      $actionbyid =  session()->get('employeeid');
      Notify::create([
        'userid' =>  $userid,
        'details' => 'Card assign by '.$admin,
        'actionby'=>$actionbyid,
      ]);


      /*$userexpiry_date = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$userid.'&ref-user-id='.$userid.'&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'';

      $cronjob = new ApiCronJob();
      $cronjob->apiuserid = $userid;
      $cronjob->api = $userexpiry_date;
      $cronjob->response_code = '';
      $cronjob->status = 0;
      $cronjob->save();*/

      $deviceusers = Deviceuser::where('userid', $userid)->first();
      if(!empty($deviceusers)){
        $deviceusers->rfidcardno1 = $cardno;
        $deviceusers->status = 3;
        $deviceusers->enroll = 1;
        $deviceusers->save();
      }

      return 201;
      

    /*}catch(\Exception $e){
      return 202;
    }*/
  }

    public function cardfree(){
      $portno_const = config('constants.port');
      $deviceinfo = DB::table('deviceinfo')
                              ->where('devicetype','independent')
                              ->where('portno', $portno_const)
                              ->first();

                    $url = 'http://'.$deviceinfo->ipaddress.'';
                    $username = $deviceinfo->username;
                    $password = $deviceinfo->password;

      for($i = 1100; $i <= 1200; $i++){

        $exp = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$i.'&card1=0';
        dd($exp);
       
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_URL,$exp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        print_r($response);

      }

    }

    public function devicestatusheadercheck(){

      $device_data = DB::table('device_status')->get()->first();
      
      if($device_data->status == 1){
        return 201;
      }else{
        return 202;
      }


    }

    public function apilist(){


      $apilist = ApiCronJob::with('user', 'anytimeaccess')->orderBy('apicronjobid', 'desc')->paginate(10);
      //dd($apilist);
      return view('admin.device.apilist')->with(compact('apilist'));

    }

    public function searchapi(){

      $fromdate = $request->fromdate;
      $todate = $request->todate;

      if(empty($fromdate)){
        $fromdate = date('Y-m-d');
      }

      if(empty($todate)){
        $todate = date('Y-m-d');
      }

      $apilist = ApiCronJob::with('user', 'anytimeaccess')->whereBetween('created_at', [$fromdate, $todate])->orderBy('apicronjobid', 'desc')->paginate(10);
      
      return view('admin.device.apilist')->with(compact('apilist'));


    }

    public function internetstatus(){

      $internetstatus = DB::table('internetstatus')->orderBy('internetid', 'desc')->paginate(10);

      return view('admin.device.internet')->with(compact('internetstatus'));

    }



}
