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
 
// Populate column from JSON $obj array and store into $coulmn.
// $mobileno ='7874853188';
$MobileNo = $obj['MobileNo'];
$Question = $obj['Question'];
$DetailQuestion = $obj['DetailQuestion'];

$Sql_Query1="INSERT into userrequest (mobileno, requestsub, requestdetail) values ('$MobileNo','$Question','$DetailQuestion')";

// Executing SQL Query.
$result=mysqli_query($con,$Sql_Query1);

//print_r($check);
if(isset($result)){

 // If the record inserted successfully then show the message.
$validMSG = 'inserted' ;
 
// Converting the message into JSON format.
$validMSGJSon = json_encode($validMSG);
 
// Echo the message.
 echo $validMSGJSon ;
 }
 
 else{
 
 // If the record inserted successfully then show the message.
$InvalidMSG = 'SomethingWentWrong' ;
 
// Converting the message into JSON format.
$InvalidMSGJSon = json_encode($InvalidMSG);
 
// Echo the message.
 echo $InvalidMSGJSon ;
 
 }
 
 mysqli_close($con);
?>