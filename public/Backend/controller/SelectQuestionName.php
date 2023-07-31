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

$Sql_Query1="SELECT qustionname,questionmasterid FROM questionmaster";

// Executing SQL Query.
$result=mysqli_query($con,$Sql_Query1);
$resultset=array();
// Associative array
while($row=mysqli_fetch_assoc($result))
{
  $resultset[]=$row;
}

//print_r($check);
if(isset($resultset)){


// $SuccessLoginMsg = 'Data Matched';
 

 // Converting the message into JSON format.
$SuccessLoginJson = json_encode($SuccessLoginMsg);


$check = json_encode($resultset);
// Echo the message.
echo $check; 
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