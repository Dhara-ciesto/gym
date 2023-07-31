<?php

  //$conn= mysqli_connect("localhost", "gym_weybee","gymweybee@123","gym_weybee");
  //$conn= mysqli_connect("localhost", "admin_fitness5mumbai", "fitness5mumbai@123","admin_fitness5mumbai");
  $conn= mysqli_connect("localhost", "admin_fitness5", "fitness5@123","admin_fitness5");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM hr_deviceinfo where portno='5000'";
$result = $conn->query($sql);
$result = $result->fetch_assoc();
$ipaddress = $result['ipaddress'];
$username = $result['username'];
$password =  $result['password'];
$portno = $result['portno'];

$device_status = "SELECT * FROM hr_device_status where status='1' ORDER BY device_status DESC LIMIT 1";
$device_status_result = $conn->query($device_status);
$device_status_result_ex = $device_status_result->fetch_assoc();

// dd($device_status_result_ex);


$apicronjob = "SELECT * From hr_apicronjob where status='0'";
$apicronjobresult = $conn->query($apicronjob);
$data=array();

$sms = "SELECT * From smssetting where status='1' And smsonoff='Active'";
$smsresult = $conn->query($sms);
$smsresult = $smsresult->fetch_assoc();


while($row=mysqli_fetch_assoc($apicronjobresult)){
       $data[]=$row;
     }
// $apicronjobresult = $apicronjobresult->fetch_assoc();

// print_r($data); echo "<br/>";

     
// $connection = @fsockopen(''.$ipaddress.'', ''.$portno.'');
// if (is_resource($connection))
// {
//    $sts = "connected";
//    fclose($connection);
// }
// else
// {
//    $sts = 'Disconnected';
// }

   if (!empty($device_status_result_ex['status']) == 1) {
     $sts = 'connected';
   }else{
     $sts = 'disconnected';
   }

     
if (!empty($sts == 'connected')) {
	if (!empty($data)) {
    $url = ''.$ipaddress.':'.$portno.'';
			for($i=0;$i<count($data);$i++)
			    {
			     $apicronjobid = $data[$i]['apicronjobid'];
			     $api = $data[$i]['api'];

                   $ch = curl_init($url);
                   curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                   curl_setopt($ch, CURLOPT_URL,$api);
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                   $response = curl_exec($ch);
                   $response = explode('=', $response);

                   if ($response[1] == 0 && $response[0] == "Response-Code") {
                        
                    $sql= "UPDATE hr_apicronjob SET status='1',response_code='".$response[1]."' where apicronjobid ='".$apicronjobid."'";

                    mysqli_query($conn,$sql);

                  }else{

                  	$sql= "UPDATE hr_apicronjob SET status='2',response_code='".$response[1]."' where apicronjobid ='".$apicronjobid."'";

                    mysqli_query($conn,$sql);

                  }
			             
			    }

				}else{
					echo "No data Found !";
				}         
    	}else{

    // 	 	$connection = 'Disconnected';
	   //    	$msg = "Device Not connected Properly !";
	 	 //  	$mobileno = '8200406933';
	
	 		// $u = $smsresult['url'];
	 		// $url= str_replace('$mobileno', $mobileno, $u);
	   //  	$url=str_replace('$msg', $msg, $url);
	   //  	$url_send = str_replace(' ', '%20', $url);

    //     $ch = curl_init($url_send);
    //     curl_setopt($ch, CURLOPT_URL,$url_send);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $otpsend = curl_exec($ch);
	   //  	// $otpsend = Curl::to($url_send)->get();

	   //  	$sql= "INSERT INTO notoficationmsgdetails (`mobileno`,`smsmsg`,`subject`,`smsrequestid`) VALUES (".$mobileno.",'".$msg."','Device Not Connected','".$otpsend."')";

	   //  	$sqlinsert = $conn->query($sql);

    //     echo 'success';

    }

$conn->close();
echo 'success';

?>