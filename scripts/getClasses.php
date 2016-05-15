<?php


$UID=$_REQUEST['UID'];

$servername = "localhost";
//$servername = "52.38.66.127";
$username = "ubuntu";
$password = "1234";
$dbName = "VR_CLASSROOM";


function getStudentInfo($conn){


	$sql = "SELECT CID, courseName, startDate, endDate, daysTaught, maxEnrolled, teacherID from CLASSES ";

	if($stmt = $conn->prepare($sql)){

		/*
		   Binds variables to prepared statement

		   i    corresponding variable has type integer
		   d    corresponding variable has type double
		   s    corresponding variable has type string
		   b    corresponding variable is a blob and will be sent in packets
		 */

		//$stmt->bind_param('ss',$EMAIL,$PASS);
		//$stmt->bind_param("s", $EMAIL); 

		if(!$stmt->execute()){
			die('failed: ' . $sql);
		}

		$stmt->store_result();
		$stmt->bind_result($cid, $courseName, $startDate, $endDate, $daysTaught, $maxEnrolled,$teacherID);

		while ($stmt->fetch()) {
			$sql = "SELECT firstName, lastName from USERS where UID = ?";
			if($stmt2 = $conn->prepare($sql)){
				$stmt2->bind_param("i",$teacherID);
				if(!$stmt2->execute()){
					die('failed: ' . $sql);
				}
				$stmt2->bind_result($firstName,$secondName);
				if($stmt2->fetch()){
					echo "firstName:$firstName|lastName:$secondName|";
				}
				$stmt2->close();
			}
			echo "CID:".$cid. "|courseName:".$courseName . "|startDate:".$startDate . "|endDate:" . $endDate . "|daysTaught:" . $daysTaught ."|maxEnrolled:".$maxEnrolled . ";";
		}

		$stmt->close();
	}
	else{
		echo ' failed to create stmt for student';
	}
}


function getTeacherInfo($conn,$uid){


	$sql = "SELECT CID, courseName, startDate, endDate, daysTaught, maxEnrolled from CLASSES where teacherID = ? ";

	if($stmt = $conn->prepare($sql)){

		/*
		   Binds variables to prepared statement

		   i    corresponding variable has type integer
		   d    corresponding variable has type double
		   s    corresponding variable has type string
		   b    corresponding variable is a blob and will be sent in packets
		 */

		//$stmt->bind_param('ss',$EMAIL,$PASS);
		$stmt->bind_param("i", $uid); 

		if(!$stmt->execute()){
			die('failed: ' . $sql);
		}

		$stmt->store_result();
		$stmt->bind_result($cid, $courseName, $startDate, $endDate, $daysTaught, $maxEnrolled);

		$sql = "SELECT firstName, lastName from USERS where UID = ?";
		if($stmt2 = $conn->prepare($sql)){
			$stmt2->bind_param("i",$uid);
			if(!$stmt2->execute()){
				die('failed: ' . $sql);
			}
			$stmt2->bind_result($firstName,$secondName);
			if($stmt2->fetch()){
			}
		}

		while ($stmt->fetch()) {
			echo "firstName:$firstName|lastName:$secondName|CID:".$cid. "|courseName:".$courseName . "|startDate:".$startDate . "|endDate:" . $endDate . "|daysTaught:" . $daysTaught ."|maxEnrolled:".$maxEnrolled . ";";
		}

		$stmt->close();
		$stmt2->close();
	}
	else{
		echo ' failed to create stmt for teacher';
	}
}


//Make Connection
$conn = new mysqli($servername,$username,$password,$dbName);

//check connection
if(mysqli_connect_errno()){
	die("Connection Failed. " . mysqli_connect_error());
}

$sql = "SELECT privilege from USERS where UID=?";

if($stmt = $conn->prepare($sql)){

	$stmt->bind_param('s',$UID);

	if(!$stmt->execute()){
		die('failed: ' . $sql);
	}
	$stmt->bind_result($privilege);

	if ($stmt->fetch()) {
		if($privilege == "T"){
			$stmt->close();
			getTeacherInfo($conn,$UID);
		}
		elseif($privilege == "S"){
			$stmt->close();
			getStudentInfo($conn);
		}
		else{
			echo 'uid is not a teacher or student';
		}
	}

}
else{
	echo ' failed to create stmt';
}



$conn->close();



?>

