<?php
 
// Importing DBConfig.php file.
include 'DBConfig.php';
 
// Connecting to MySQL Database.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
 // Populate Student ID from JSON $obj array and store into $S_Name.
$firstname = $obj['firstname'];
 // $firstname = 'akash';

$lastname = $obj['lastname'];
 // $lastname = 'thoriya';

 $email = $obj['email'];
 // $email = 'akash@gmail.com';

 $profession = $obj['profession'];
 // $profession = 'Jr developer';
 
$mobileno = $obj['mobileno'];
 // $mobileno = '7874853188';

 $mobileSelect = $obj['mobileSelect'];
 // $mobileSelect = '9409713240';

 // Creating SQL query and insert the record into MySQL database table.

$Sql_Query = "SELECT memberid from member where mobileno = '$mobileSelect' ";
$checkselect = mysqli_fetch_array(mysqli_query($con,$Sql_Query));

$Sql_Query1 = "UPDATE member SET firstname= '$firstname', lastname = '$lastname', email = '$email', profession = '$profession' WHERE mobileno = '$mobileSelect' "; 
$checkupdate = mysqli_fetch_array(mysqli_query($con,$Sql_Query1));

if(isset($check1)){
 
// $SuccessLoginMsg = 'Data Matched';
 
// Converting the message into JSON format.
$SuccessLoginJson = json_encode($SuccessLoginMsg);

$check1 = json_encode($check1);
// Echo the message.
 echo $check1 ; 
 
 }
 else{
 
 // If the record inserted successfully then show the message.
$InvalidMSG = 'abortive' ;
 
// Converting the message into JSON format.
$InvalidMSGJSon = json_encode($InvalidMSG);
 
// Echo the message.
 echo $InvalidMSGJSon ;
 
 }
 mysqli_close($con);
?>