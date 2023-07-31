<?php

  //$conn= mysqli_connect("localhost", "gym_weybee", "gymweybee@123","gym_weybee");
  $conn= mysqli_connect("localhost", "admin_fitness5", "fitness5@123","admin_fitness5");


  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM hr_deviceevent where eventid='101'";
$result = $conn->query($sql);
$deviceevents=array();
while($row=mysqli_fetch_assoc($result)){
       $deviceevents[]=$row;
     }

     foreach ($deviceevents as $deviceevent) {
      $dte='"'.$deviceevent['date'].'"';
          $query = "SELECT * from hr_device_emplog WHERE dateid =  '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";
     	
          $result1 = $conn->query($query);
		 //	print_r($result1);
		 
          $qq=array();
          while($row=mysqli_fetch_assoc($result1)){
            $qq[]=$row;
          }
          
		 if($qq){
	
       for ($i=1;$i<=3;$i++){
        if(($qq[0]['timein'.$i] > '00:00:00' )){

        }else{
          $timeinrow='timein'.$i;
          $rty="UPDATE hr_device_emplog set $timeinrow = '".$deviceevent['time']."' WHERE dateid = '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";
     
          $rtyresult = $conn->query($rty);
          break;

        }
        if(($qq[0]['timeout'.$i] > '00:00:00')){

        }else{
          $timeoutrow='timeout'.$i.'';
          $rty="UPDATE hr_device_emplog set $timeoutrow = '".$deviceevent['time']."' WHERE dateid = '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";
       
          $rtyresult = $conn->query($rty);
          $timeoutrow='';
        break;

        }

       }

      	 }
           
     }


?>