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

//Applying User Login query with mobile number match.
$Sql_Query = "SELECT memberdiet.memberdietid, memberdiet.diettime, memberdiet.compulsary, memberdiet.remark, memberdiet.dietitemid, mealmaster.mealname FROM memberdiet , member,mealmaster WHERE member.mobileno='".$mobileno."' AND memberdiet.dietday = '".$currentDayNumber."' AND memberdiet.status='1' AND member.memberid=memberdiet.memberid AND mealmaster.mealmasterid = memberdiet.mealid";

$result=mysqli_query($con,$Sql_Query);
$resultset=array();
// Associative array
while($row=mysqli_fetch_assoc($result))
{
  	$resultset[]=$row;
}
	
for($no=0;$no<count($resultset);$no++)
{
	$dataload=array();
	$diteitem=explode(',', $resultset[$no]['dietitemid']);

	for($i=0;$i<count($diteitem);$i++)
	{
		$query1="SELECT dietitem FROM dietitems where dietitemid='".$diteitem[$i]."'";
		// echo $query1;
		$executeQuery = mysqli_query($con,$query1);
		//print_r($executeQuery);
		$secondResult=mysqli_fetch_array($executeQuery);
		$dataload[] = $secondResult['dietitem'];
		// print_r($datai);exit;
	}
	$dataload1=implode(',', $dataload);
	$resultset[$no]['dietitem']= $dataload1;
	
}
// $check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));

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
$InvalidMSG = 'Something Went Wrong' ;
 
// Converting the message into JSON format.
$InvalidMSGJSon = json_encode($InvalidMSG);
 
// Echo the message.
 echo $InvalidMSGJSon ;
 
 }
 
 mysqli_close($con);
?>