<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;
use App\MemberEnrollment;
use App\Deviceuser;
use App\DeviceEvent;
use App\Deviceseqcount;

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

                   
                    $deviceevent = DeviceEvent::get()->last();

                    
                    $deviceseqcountid = Deviceseqcount::get()->last();
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

?>