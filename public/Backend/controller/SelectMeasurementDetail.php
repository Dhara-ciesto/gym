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
// $MobileNo ='7874853188';
// $toDateHolder = '2019-09-25 00:00:00';
// $fromDateHolder = '2019-09-27 00:00:00';
$MobileNo = $obj['MobileNo'];
$toDateHolder = $obj['toDateHolder'];
$fromDateHolder = $obj['fromDateHolder'];
$sql = "SELECT memberid FROM member WHERE mobileno = '".$MobileNo."' ";
//query to fetch

$memberid = mysqli_fetch_array(mysqli_query($con,$sql));

$Sql_Query1="SELECT * FROM measurement WHERE memberid = '".$memberid['memberid']."' AND todaydate = '".$toDateHolder."' ";

// Executing SQL Query.
$result=mysqli_query($con,$Sql_Query1);
$resultset=array();
// Associative array
while($row=mysqli_fetch_assoc($result))
{
  $resultset[]=$row;
}

$Sql_Query2="SELECT * FROM measurement WHERE memberid = '".$memberid['memberid']."' AND todaydate = '".$fromDateHolder."' ";

// Executing SQL Query.
$result2=mysqli_query($con,$Sql_Query2);
$resultset2=array();
// Associative array
while($row2=mysqli_fetch_assoc($result2))
{
  $resultset2[]=$row2;
}


$details = array_merge($resultset,$resultset2);
// echo "<pre>";
// print_r($details);



if(isset($details)){

// $SuccessLoginMsg = 'Data Matched';
 
//  // Converting the message into JSON format.
// $SuccessLoginJson = json_encode($SuccessLoginMsg);


$details = json_encode($details);
// Echo the message.
echo $details; 
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