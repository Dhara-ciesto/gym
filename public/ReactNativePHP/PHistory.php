<?php
// Importing DBConfig.php file.
include 'DBConfig.php';
 
// Creating connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
// Populate column from JSON $obj array and store into $coulmn.
// $mobileno ='7874853188';
 $mobileno = $obj['mobile'];

//Applying User Login query with mobile number match.
$Sql_Query = "select memberid, firstname,lastname from member where mobileno = '$mobileno' ";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));

$memberid = $check["memberid"];
// echo $firstname = $check["firstname"];
// echo $lastname = $check["lastname"];

// $Sql_Query1 = "select paymentdate, mode, actualamount, amount, tax, discount, receiptno from payments where memberid= '$memberid' ";
//echo $row['paymentdate'],$row['mode'],$row['actualamount'],$row['amount'],$row['tax'],$row['discount'],$row['receiptno']."<br>";
// $check1 = mysqli_fetch_array(mysqli_query($con,$Sql_Query1));

		$data = array();
		$result_set = $con->query("select paymentdate, mode, actualamount, amount, tax, discount, receiptno from payments where memberid= '$memberid' ");

		while($row = mysqli_fetch_assoc($result_set))

		{
			$data[] = $row;
		}
		// for($no=0 ;$no<count($data); $no++)
		// {

		// 	echo $data[$no]['paymentdate'];

		// }

if(isset($check)){
// $SuccessLoginMsg = 'Data Matched';
  // Converting the message into JSON format.
$SuccessLoginJson = json_encode($SuccessLoginMsg);


$check = json_encode($check);
// Echo the message.
echo $check ; 
 }
 
 else{
 
 // If the record inserted successfully then show the message.
$InvalidMSG = 'Try again' ;
 
// Converting the message into JSON format.
$InvalidMSGJSon = json_encode($InvalidMSG);
 
// Echo the message.
 echo $InvalidMSGJSon ;
 
 }
 
 mysqli_close($con);
?>