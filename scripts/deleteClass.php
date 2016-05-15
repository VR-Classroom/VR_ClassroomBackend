<?php

$UID=$_REQUEST['UID'];
$CID=$_REQUEST['CID'];

$servername = "localhost";
//$servername = "52.38.66.127";
$username = "ubuntu";
$password = "1234";
$dbName = "VR_CLASSROOM";


if (! ($CID && $UID)){
	die ('missing required: CID,UID');
}

//Make Connection
$conn = new mysqli($servername,$username,$password,$dbName);

//check connection
if(mysqli_connect_errno()){
	die("Connection Failed. " . mysqli_connect_error());
}


$sql = "DELETE FROM CLASSES where CID = ? and teacherID = ?";

if($stmt = $conn->prepare($sql)){

	/*
	   Binds variables to prepared statement

	   i    corresponding variable has type integer
	   d    corresponding variable has type double
	   s    corresponding variable has type string
	   b    corresponding variable is a blob and will be sent in packets
	 */

	$stmt->bind_param('ii',$CID,$UID);
	//$stmt->bind_param("s", $EMAIL); 

	//echo 'executing query';
	if(!$stmt->execute()){
		die('failed: ' . $sql);
	}

	$stmt->close();
}
else{
	die(' failed to create stmt');
}
echo 'success';

$conn->close();



?>

