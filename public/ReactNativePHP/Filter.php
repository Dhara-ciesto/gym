<?php
 
// Importing DBConfig.php file.
include 'DBConfig.php';
 
// Creating connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
 // Populate ID from JSON $obj array and store into $ID.
$ID = $obj['paymentdate'];

//Fetching the selected record.
$CheckSQL = "SELECT paymentdate, mode, actualamount, amount, tax, discount, receiptno FROM payments WHERE paymentdate='$ID'";

$result = $con->query($CheckSQL);

if ($result->num_rows >0) {
 
 while($row[] = $result->fetch_assoc()) {
 
 $Item = $row;
 
 $json = json_encode($Item);
 
 }
 
}else {
	
 echo "No Results Found.";
 
}

echo $json;

$con->close();
?>