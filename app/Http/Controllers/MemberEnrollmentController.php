<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registration;
use DB;
use Carbon\Carbon;
use App\Member;
use App\User;
use Alert;
use Ixudra\Curl\Facades\Curl;
use App\MemberEnrollment;
use App\Deviceuser;
use App\DeviceEvent;
use App\Deviceseqcount;

class MemberEnrollmentController extends Controller
{
  
    public function assessment(Request $request){

        Alert::message('Thanks for comment!')->persistent('Close');

         $users=User::where('active','=',1)->get()->all();
          $ipdata = DB::table('deviceinfo')->get()->all();

        if ($request->isMethod('post')) {

            $userid = $request->get('selectmobileno');
     

            $memberid = Member::where('userid',$userid)->where('status',1)->first();
                  // print_r($memberid->memberid);exit;
            
           

                 return view('admin.device.enrollment',compact('users','ipdata'));
            }

       

        return view('admin.device.enrollment',compact('users','ipdata'));

    }

     public function assessmentajax(Request $request){

            $method = $request->method();
        
            $username = $request->get('username');
            $MobileNo = $request->get('MobileNo');

            $user = User::where('userid','=', $username)->get()->first();
          
   
            echo json_encode($user);
        
    }

     public function sweetalert(){



        //Alert::info('Robots are working!');
        Alert::message('Thanks for comment!')->persistent('Close');
        //Alert::info('Random lorempixel.com : <img src="http://lorempixel.com/150/150/">')->html();

        return redirect('device/enrollment')->with('success', 'Login Successfully!');
     }

     public function setusertodevice(Request $request){

// ---------------------------------------------------------------------------------------------------------        // $data = [

        //            $deviceuserid = $request->input('deviceuserid'),
        //            $deviceuserreferenceid = $request->input('deviceuserreferenceid'),
        //            $username = $request->input('username'),
        //            $pin = $request->input('pin'),
        //            $date = $request->input('date'),
        //            $status = $request->input('status'),

        //        ];
    
         // Deviceuser::insert($test);
               //$date = explode('-', $date);
               // $r =  implode(",",$request->input('devicename'));
         //       $r = $request->input('devicename');

         //       foreach ($r as $v) {
         //           # code...
         //           $data = ['devicename' => $v,'deviceusersid' => $request->input('deviceuserid'),];

         //           DB::table('deviceuserenrollment')->insert($data);

         //       }
               


            

         // print_r($r);  
         // exit; 

// ----------------------------------------------------------------------------------------------------------
               // $deviceuser = Deviceuser::create(

               //           [
               //              'username' => $username,
               //              'pin'   =>  $pin,
               //          ]

               //  );
              
               //  $date = explode('-', $date);
// ----------------------------------------------------------------------------------------------------------

        $url = 'http://192.168.1.50';
                    $username = 'admin';
                    $password = '1234';
                     

                    $ch = curl_init($url);
                     
                    
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                    curl_setopt($ch, CURLOPT_URL,"http://192.168.1.50/device.cgi/command?action=geteventcount&format=xml");
               
                  
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                     
                  
                    $response = curl_exec($ch);
                    
                    //$j = json_encode($response);
                    //$s = json_decode($j);

                    $xml_file = simplexml_load_string($response);
                    $json = json_encode($xml_file);
                    $array = json_decode($json,TRUE);

                    


         $deviceseqcount = [
                                'rollovercount'  => $array['Roll-Over-Count'],
                                'seqno'          => $array['Seq-Number'],
                            ];

                   
                    //Deviceseqcount::insert($deviceseqcount);

                    $deviceevent =   DB::table('deviceevent')->get()->last();
                    
                    $deviceseqcountid = DB::table('deviceseqcount')->get()->last();
                    $deviceseqcountid = $deviceseqcountid->seqno;


                    $url = 'http://192.168.1.50';
                    $username = 'admin';
                    $password = '1234';
                     

                    $ch = curl_init($url);

                    $seqnumber = $deviceevent->seqno;


                    for($i=$seqnumber;$i<=$deviceseqcountid;$i++){

                        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                    curl_setopt($ch, CURLOPT_URL,"http://192.168.1.50/device.cgi/events?action=getevent&roll-over-count=0&seq-number=".$i."&no-of-events=1&format=xml");
               
                  
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                
                    $response = curl_exec($ch);
                    //$j = json_encode($response);
                    //$s = json_decode($j);

                    $xml_file = simplexml_load_string($response);
                    $json = json_encode($xml_file);
                    $array = json_decode($json,TRUE);


         $deviceeventdata = [
                                'rollovercount'  => $array['Events']['roll-over-count'],
                                'seqno'          => $array['Events']['seq-No'],
                                'date'           => $array['Events']['date'],
                                'time'           => $array['Events']['time'],
                                'eventid'        => $array['Events']['event-id'],
                                'detail1'        => $array['Events']['detail-1'],
                                'detail2'        => $array['Events']['detail-2'],
                                'detail3'        => $array['Events']['detail-3'],
                                'detail4'        => $array['Events']['detail-4'],
                                'detail5'        => $array['Events']['detail-5'],

                            ];

                print_r($deviceeventdata);
                echo "<br/>";

                    DeviceEvent::insert($deviceeventdata);
                    }
exit;
                     
                    
         //            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
         //            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
         //            curl_setopt($ch, CURLOPT_URL,"http://192.168.1.50/device.cgi/events?action=getevent&roll-over-count=0&seq-number=".$seqnumber."&no-of-events=1&format=xml");
               
                  
         //            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                
         //            $response = curl_exec($ch);
         //            //$j = json_encode($response);
         //            //$s = json_decode($j);

         //            $xml_file = simplexml_load_string($response);
         //            $json = json_encode($xml_file);
         //            $array = json_decode($json,TRUE);


         // $deviceeventdata = [
         //                        'rollovercount'  => $array['Events']['roll-over-count'],
         //                        'seqno'          => $array['Events']['seq-No'],
         //                        'date'           => $array['Events']['date'],
         //                        'time'           => $array['Events']['time'],
         //                        'eventid'        => $array['Events']['event-id'],
         //                        'detail1'        => $array['Events']['detail-1'],
         //                        'detail2'        => $array['Events']['detail-2'],
         //                        'detail3'        => $array['Events']['detail-3'],
         //                        'detail4'        => $array['Events']['detail-4'],
         //                        'detail5'        => $array['Events']['detail-5'],

         //                    ];

         //            //DeviceEvent::insert($deviceeventdata);


         //            print_r($deviceeventdata);exit;

                    //$response = explode(',', $response);


                    // $data = simplexml_load_string($response);
                    // $configdata   = json_encode($data);

                    // return view('admin.device',array('response' => $configdata ));


                    // $response = explode("", $response);

          //           $xml = simplexml_load_string($response);
          //               $json = json_encode($xml);
          //               $arr = json_decode($json,true);

          //               $temp = array();
          //               foreach($arr as $k=>$v) {
          //                 foreach($v as $k1=>$v1) {
          //                   $temp[$k][$k1] = $v1;
          //                 }
          //               }

          //               echo "<pre>";print_r($temp);echo "</pre>";
                      
          // exit;
          //           if(curl_errno($ch)){
                        
          //               throw new Exception(curl_error($ch));
          //           }
                     
                   
                   


                    // $response = explode('=', $response);
                    // // print_r($response[1]);exit;

                    // if ($response[1] == 0) {
                    //     print_r($response);
                    // }



                    //  $deviceevent = DeviceEvent::all();
                    // print_r($deviceevent);exit;
                    
                    
     }


     public function getxml(Request $request){

        //The URL of the resource that is protected by Basic HTTP Authentication.
                    $url = 'http://192.168.1.50';
                     
                    //Your username.
                    $username = 'admin';
                     
                    //Your password.
                    $password = '1234';
                     
                    //Initiate cURL.
                    $ch = curl_init($url);
                     
                    //Specify the username and password using the CURLOPT_USERPWD option.
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password); 
                    $fetch = curl_setopt($ch, CURLOPT_URL,"http://192.168.1.50/device.cgi/users?action=get&user-id=1");
                     
                    //Tell cURL to return the output as a string instead
                    //of dumping it to the browser.
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                     
                    //Execute the cURL request.
                    $response = curl_exec($ch);
                    //$fetch = curl_exec($fetch);
                     
                    //Check for errors.
                    if(curl_errno($ch)){
                        //If an error occured, throw an Exception.
                        throw new Exception(curl_error($ch));
                    }
                     
                    //Print out the response.
                    echo  $response;
                    //curl_close($ch);
                    //echo $fetch;


         //return view('admin.device');
     }



  
}
