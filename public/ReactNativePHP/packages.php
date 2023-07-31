<?php
// Importing DBConfig.php file.
include 'DBConfig.php';
// Creating connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
 $mobile = $obj['mobile'];

$sql = "SELECT memberpackages.joindate, memberpackages.expiredate, schemes.schemename from memberpackages left join schemes on schemes.schemeid=memberpackages.schemeid where memberpackages.status = 1 AND  memberpackages.userid=(select userid from member where mobileno = '$mobile')";

$check4 = mysqli_fetch_assoc(mysqli_query($con,$sql));

if(isset($check4)){
 
 // Converting the message into JSON format.
$check4 = json_encode($check4);

 echo $check4 ; 
 }
 
 else{
 
 // If the record inserted successfully then show the message.
$InvalidMSG = 'fetch unsuccessful' ;
 
// Converting the message into JSON format.
$InvalidMSGJSon = json_encode($InvalidMSG);
 
// Echo the message.
 echo $InvalidMSGJSon ;
 
 }
 
 mysqli_close($con);
?>