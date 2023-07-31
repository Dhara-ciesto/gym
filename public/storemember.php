
<?php
 include 'global.php';

 $servername = "localhost";
 $username = "admin_fitness5";
 $password = "fitness5@123";
 $dbname = "admin_fitness5";

//  $username = "root";
//  $password = "";
//  $dbname = "f5master";
// echo $_POST["code"];
// echo $GLOBALS["addmember"];exit;

// print_r($_SESSION);
// exit;
// if(isset($_SESSION['addmember'])){
// echo yes;
// exit;
// }
// exit;
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());
}
$today=date('Y-m-d');
 $mpin=rand(1000, 9999);
 $workinghourfrom = date("Y-m-d H:i:s", strtotime($_POST["working_hour_from_1"]));
 $workinghourto = date("Y-m-d H:i:s", strtotime($_POST["working_hour_to_1"]));

$photo='';
 if ($_FILES['profileimage']['name'] != "") {
	 $photo=$_FILES['profileimage']['name'];
	 $photo=$_POST["firstname"].$photo;
 	}
 $countfiles = count($_FILES['attachments']['name']);

 // Looping all files

 for($i=0;$i<$countfiles;$i++){

   $filename = $_FILES['attachments']['name'][$i];
   if($filename){
	$filename=$_POST["firstname"].time().$filename;
	$data[] = $filename;
   }


   // Upload file


 }



$files = implode(',', $data);
$sql = "INSERT INTO memberdata(memberid, userid, firstname, lastname, username,address, city, gender, email, createddate, hearabout, bloodgroup, other, formno, mobileno, homephonenumber, officephonenumber, profession, birthday,anniversary, emergancyname, emergancyrelation,emergancyaddress, emergancyphonenumber, workinghourfrom, workinghourto, amount,companyid, photo, files,memberpin, extra1, extra2, status, created_at, updated_at) VALUES

	(NULL,
	NULL,
	'".mysqli_real_escape_string($conn,$_POST["firstname"]) ."',
	'".mysqli_real_escape_string($conn,$_POST["lastname"])."',
	'".mysqli_real_escape_string($conn,$_POST["username"])."',

 	'".mysqli_real_escape_string($conn,$_POST["Address"]) ."',
 	 	'".mysqli_real_escape_string($conn,$_POST["City"]) ."',
 	 	 	 	'".mysqli_real_escape_string($conn,$_POST["gender"]) ."',

 	'".mysqli_real_escape_string($conn,$_POST["email"]) ."',

 '".$today."',
 	'".mysqli_real_escape_string($conn,$_POST["HearAbout"]) ."',

 	'".mysqli_real_escape_string($conn,$_POST["bloodgroup"]) ."',

		'NULL', 'NULL',

 	'".mysqli_real_escape_string($conn,$_POST["CellPhoneNumber"]) ."',
 	 	'".mysqli_real_escape_string($conn,$_POST["HomePhoneNumber"]) ."',

 	'".mysqli_real_escape_string($conn,$_POST["OfficePhoneNumber"]) ."',

 	'".mysqli_real_escape_string($conn,$_POST["profession"]) ."',
 	'".$_POST["birthday"]."',
 	  	'".$_POST["anniversary"]."',
 	'".mysqli_real_escape_string($conn,$_POST["emergancyname"]) ."',
 	'".mysqli_real_escape_string($conn,$_POST["emergancyrelation"]) ."',
 	'".mysqli_real_escape_string($conn,$_POST["emergancyaddress"]) ."',
 	 	'".mysqli_real_escape_string($conn,$_POST["EmergancyPhoneNumber"]) ."',
 	 		'".mysqli_real_escape_string($conn,$workinghourfrom) ."',
 	 			'".mysqli_real_escape_string($conn,$workinghourto) ."',
 	 			'NULL', 'NULL',
 	 			 '".$photo."','".$files."',
 	 				'".mysqli_real_escape_string($conn,$mpin) ."',
 	 				 NULL, NULL, '1', '".$today."', NULL)";

echo $sql;
// exit;

if ($_FILES['profileimage']['name'] != "") {
	$name=$_FILES['profileimage']['name'];
	$name=$name.$_POST["firstname"];
	$target_path = "files/";
	$target_path = $target_path.$name;
	echo $target_path;

	if(move_uploaded_file($_FILES['profileimage']['tmp_name'], $target_path)) {
		echo "File uploaded successfully!";
	} else{
		echo "Sorry, file not uploaded, please try again!";
	}


   }
	for($i=0;$i<$countfiles;$i++){

	$filename = $_FILES['attachments']['name'][$i];
	$filename=$_POST["firstname"].time().$filename;

	// Upload file


	move_uploaded_file($_FILES['attachments']['tmp_name'][$i],'files/'.$filename);
	}



 // '".$_POST["CellPhoneNumber"]."', '".$_POST["HomePhoneNumber"]."', '".$_POST["OfficePhoneNumber"]."', '".$_POST["profession"]."', '".$_POST["birthday"]."', '".$_POST["anniversary"]."', '".$_POST["emergancyname"]."', '".$_POST["emergancyrelation"]."', '".$_POST["emergancyaddress"]."', '".$_POST["EmergancyPhoneNumber"]."', '".$workinghourfrom."', '". $workinghourto."', NULL, NULL, '".$photo."','".$files."', '".$mpin."', NULL, NULL, '1', '".$today."', NULL)";
if (mysqli_query($conn, $sql))
{

    echo "New record created successfully";
    $sql2 = "UPDATE `short_links` SET `status` = '0' WHERE  code='".$_POST["code"]."'";
		if (mysqli_query($conn, $sql2)) {

			$_POST='';
			mysqli_close($conn);
			  header("Location: success.php");
		}
		else{
			$_POST='';
			mysqli_close($conn);
				  header("Location: failer.php");
		}


} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



?>
