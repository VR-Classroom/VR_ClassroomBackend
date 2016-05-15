<?php

//$EMAIL='fake@fake.com';
//$PASS='1234';

if(php_sapi_name() == "cli"){
	$EMAIL=$argv[1];
	$PASS=$argv[2];
}

else{
	$EMAIL=$_REQUEST['EMAIL'];
	$PASS=$_REQUEST['PASS'];
}
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

$sql = "SELECT UID, firstName, lastName, gender, privilege, email from USERS where email = ? and password = ?";

if($stmt = $conn->prepare($sql)){

	/*
	   Binds variables to prepared statement

	   i    corresponding variable has type integer
	   d    corresponding variable has type double
	   s    corresponding variable has type string
	   b    corresponding variable is a blob and will be sent in packets
	 */

	$stmt->bind_param('ss',$EMAIL,$PASS);
	//$stmt->bind_param("s", $EMAIL); 

	if(!$stmt->execute()){
		die('failed: ' . $sql);
	}

	$stmt->bind_result($UID,$firstName, $secondName,$gender,$privilege,$email);


	while ($stmt->fetch()) {
echo "UID:".$UID. "|firstName:".$firstName . "|lastName:".$secondName. "|gender:" . $gender . "|privilege:".$privilege."|email:".$email;
//		echo "<pre>";
//		echo "name: $name\n";
//		echo "countryCode: $countryCode\n";
//		echo "</pre>";
	}

	$stmt->close();
}
else{
	echo ' failed to create stmt';
}

$conn->close();



?>

