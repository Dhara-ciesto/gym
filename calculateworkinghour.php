<?php
    $sumdiff =0;
    $total=0;
    $conn= mysqli_connect("localhost", "root", "","gmslive");
    // $conn= mysqli_connect("localhost", "root", "","gms_new");

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    /******calculate for whose status is 0 means not calculated********/
	$query = "SELECT * from hr_device_emplog WHERE status = 0";
    $result = $conn->query($query);
    $deviceevents = array();
    while($row=mysqli_fetch_assoc($result)){
           $deviceevents[]=$row;
    }
    foreach ($deviceevents as $key => $value) {

    $diff=0;
    /******calculate for 3 interval TI/TO-1 TI/TO-2 TI/TO-3 ********/
    for ($i=1;$i<=3;$i++){

        $time1 = strtotime($value['timein'.$i]);
        $time2 = strtotime($value['timeout'.$i]);
        $diff = $diff +  round(abs($time2 - $time1) / 60,2);
        
    }
        $hours = floor($diff / 60).':'.($diff -   floor($diff / 60) * 60);
      
        $rty="UPDATE hr_device_emplog set totalworkinghours = '".$hours."' WHERE dateid = '".$value['dateid']."' AND empid='".$value['empid']."' LIMIT 1";
      
        $rtyresult = $conn->query($rty);
 
    
}

						
?>