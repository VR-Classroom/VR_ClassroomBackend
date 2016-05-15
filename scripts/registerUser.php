<?php

//$EMAIL='fake@fake.com';
//$PASS='1234';

$FNAME=$_REQUEST['FNAME'];
$LNAME=$_REQUEST['LNAME'];
$GENDER=$_REQUEST['GENDER'];
$PRIV=$_REQUEST['PRIV'];
$BIRTH=$_REQUEST['BIRTH'];
$EMAIL=$_REQUEST['EMAIL'];
$PASS=$_REQUEST['PASS'];

$servername = "localhost";
//$servername = "52.38.66.127";
$username = "ubuntu";
$password = "1234";
$dbName = "VR_CLASSROOM";

//Make Connection
$conn = new mysqli($servername,$username,$password,$dbName);

//check connection
if(mysqli_connect_errno()){
	die("Connection Failed. " . mysqli_connect_error());
}

if(! ($FNAME && $LNAME && $PRIV && $EMAIL && $PASS) ){
	die('not all paramaters passed... (FNAME,LNAME,PRIV,EMAIL,PASS)');
}


$sql = "INSERT INTO USERS (firstName,lastName,gender,privilege,birthDay,email,password,creationDate) VALUES (?,?,?,?,?,?,?,NOW())";

if($stmt = $conn->prepare($sql)){

	/*
	   Binds variables to prepared statement

	   i    corresponding variable has type integer
	   d    corresponding variable has type double
	   s    corresponding variable has type string
	   b    corresponding variable is a blob and will be sent in packets
	 */

	$stmt->bind_param('sssssss',$FNAME,$LNAME,$GENDER,$PRIV,$BIRTH,$EMAIL,$PASS);
	//$stmt->bind_param("s", $EMAIL); 

	if(!$stmt->execute()){
		die('ERROR: ' . mysqli_error($conn));
	}

	$stmt->close();

	$sql = "SELECT LAST_INSERT_ID()";
	if($stmt = $conn->prepare($sql)){
		if(!$stmt->execute()){
			die('ERROR: ' . mysqli_error($conn));
		}
		$stmt->bind_result($uid);
		while($stmt->fetch()){
			//echo 'ID:'.$uid;
			$userFolder="/home/ubuntu/public_html/users/".$uid;
			if(! file_exists($userFolder)){
				$oldmask = umask(0);
				mkdir($userFolder, 0777);
				chown($userFolder,"ubuntu");
				umask($oldmask);
			}
		}
	}

	//$stmt->bind_result($name, $countryCode);


	//	while ($stmt->fetch()) {
	//		echo "<pre>";
	//		echo "name: $name\n";
	//		echo "countryCode: $countryCode\n";
	//		echo "</pre>";
	//	}

	echo 'success';
	$stmt->close();
}
else{
	echo ' failed to create stmt';
}

$conn->close();



?>

