<?php

//$EMAIL='fake@fake.com';
//$PASS='1234';
$UID=$_REQUEST['UID'];

$CNAME=$_REQUEST['CNAME'];
$SDATE=$_REQUEST['SDATE'];
$EDATE=$_REQUEST['EDATE'];
$TIME=$_REQUEST['TIME'];
$DAYS=$_REQUEST['DAYS'];
$MAXENROLL=$_REQUEST['MAXENROLL'];


$servername = "localhost";
//$servername = "52.38.66.127";
$username = "ubuntu";
$password = "1234";
$dbName = "VR_CLASSROOM";


if( !$UID){
	die('UID NOT PASSED');
}
else if (! ($CNAME && $DAYS)){
	die ('missing required: CNAME, DAYS');
}

//Make Connection
$conn = new mysqli($servername,$username,$password,$dbName);

//check connection
if(mysqli_connect_errno()){
	die("Connection Failed. " . mysqli_connect_error());
}


$sql = "SELECT privilege from USERS where UID = ?";

if($stmt = $conn->prepare($sql)){

	/*
	   Binds variables to prepared statement

	   i    corresponding variable has type integer
	   d    corresponding variable has type double
	   s    corresponding variable has type string
	   b    corresponding variable is a blob and will be sent in packets
	 */

	$stmt->bind_param('i',$UID);
	//$stmt->bind_param("s", $EMAIL); 

	//echo 'executing query';
	if(!$stmt->execute()){
		die('failed: ' . $sql);
	}

	$stmt->bind_result($privilege);


	if ($stmt->fetch()) {
		//	echo "<pre>";
		//	echo "priv: $privilege\n";
		//	echo "</pre>";
	}


	$stmt->close();

	//echo 'checking: ' . $privilege;

	$sql = "INSERT INTO CLASSES (teacherID, courseName, startDate, endDate, timeFrame, daysTaught, maxEnrolled) VALUES (?,?,?,?,?,?,?)";

	if($privilege && $privilege == 'T' && $stmt = $conn->prepare($sql)){




		$stmt->bind_param('isssssi',$UID, $CNAME, $SDATE, $EDATE, $TIME, $DAYS, $MAXENROLL);
		//$stmt->bind_param("s", $EMAIL); 

		if(!$stmt->execute()){
			die('ERROR: ' . mysqli_error($conn));
		}

		//$stmt->bind_result($privilege);


		//		if ($stmt->fetch()) {
		//			echo "<pre>";
		//			echo "priv: $privilege\n";
		//			echo "</pre>";
		//		}


		$stmt->close();



	}
	else{
		die('cannot create class for UID: '. $UID);
	}

}
else{
	die(' failed to create stmt');
}
echo 'success';

$conn->close();



?>

