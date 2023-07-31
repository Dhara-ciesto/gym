<?php
 
// Importing DBConfig.php file.
require '../admin/config.php';
 
// Creating connection.
$con = mysqli_connect($database['host'],$database['user'], $database['pass'], $database['db']) 
or die("An unexpected error has occurred in the database connection");
 
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
//$Birthdate = $obj['BirthDate'];
 $Anniversary = date('Y-m-d',strtotime($obj['Anniversary']));
 
$mobileno = $obj['mobileno'];
//$mobileno = '7874853188';


 // Creating SQL query and insert the record into MySQL database table.

$Sql_Query1 = "UPDATE member SET anniversary = '$Anniversary' WHERE mobileno = '$mobileno' "; 
//echo $Sql_Query1;
if(mysqli_query($con,$Sql_Query1)){
 
 $SuccessLoginMsg = 'Updated';
 // Converting the message into JSON format.
$SuccessLoginJson = json_encode($SuccessLoginMsg);

// Echo the message.
 echo $SuccessLoginJson ; 
 
 }
 else{
 
 // If the record inserted successfully then show the message.
$InvalidMSG = 'Update Successfully' ;
 
// Converting the message into JSON format.
$InvalidMSGJSon = json_encode($InvalidMSG);
 
// Echo the message.
 echo $InvalidMSGJSon ;
 
 }
 mysqli_close($con);
?>