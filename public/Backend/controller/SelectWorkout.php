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
// $currentDayNumber = '2';
$mobileno = $obj['mobileno'];
$currentDayNumber = $obj['currentDayNumber'];


$Sql_Query = "SELECT memberexercise.memberexerciseid, memberexercise.memberexerciseins, memberexercise.memberexercisetime,memberexercise.memberexerciseset,memberexercise.memberexerciserep, exercise.exercisename FROM memberexercise ,exercise,member WHERE memberexercise.exerciseid=exercise.exerciseid AND memberexercise.memberid=member.memberid AND member.mobileno='".$mobileno."' AND memberexercise.assignday = '".$currentDayNumber."'";

$result=mysqli_query($con,$Sql_Query);
$resultset=array();
// Associative array
while($row=mysqli_fetch_assoc($result))
{
  $resultset[]=$row;
}

if(isset($resultset)){

$data = json_encode($resultset);
// Echo the message.
echo $data; 
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