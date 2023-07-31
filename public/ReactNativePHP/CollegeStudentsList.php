<?php
include 'DBConfig.php';

// Create connection
$conn = new mysqli($HostName, $HostUser, $HostPass, $DatabaseName);

// Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
$mobile = $obj['mobilenumber'];

$Sql_Query = "select memberid from member where mobileno = '$mobile'";

$check = mysqli_fetch_array(mysqli_query($conn,$Sql_Query));

$memberid = $check["memberid"];

// Creating SQL command to fetch all records from Table.
$sql = "select paymentdate, mode, actualamount, amount, tax, discount, receiptno from payments where memberid = '$memberid'";

$result = $conn->query($sql);

if ($result->num_rows >0) {
 
 
 while($row[] = $result->fetch_assoc()) {
 
 $item = $row;
 
 $json = json_encode($item);
 
 }
 
} 

else {
 echo "No Results Found.";
}
echo $json;

$conn->close();

?>