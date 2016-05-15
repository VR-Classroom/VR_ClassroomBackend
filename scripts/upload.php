<?php

$email=$_POST["email"];
$pass=$_POST["password"];

$output=shell_exec("php /home/ubuntu/public_html/scripts/getUser.php $email $pass");

if(! isset($output) || trim($output) == ''){
	echo 'invalid credentials';
	return;
}

function getStringBetween($str,$from,$to)
{
	$sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
	return substr($sub,0,strpos($sub,$to));
}

$userid = getStringBetween($output,"UID:","|");

$target_dir = "../users/" . $userid . "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual presentation or not
try{
	if (
			!isset($_FILES['fileToUpload']['error']) ||
			is_array($_FILES['fileToUpload']['error'])
	   ) {
		throw new RuntimeException('Invalid parameters.');
	}

	switch ($_FILES['fileToUpload']['error']) {
		case UPLOAD_ERR_OK:
			break;
		case UPLOAD_ERR_NO_FILE:
			throw new RuntimeException('No file sent.');
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			throw new RuntimeException('Exceeded filesize limit.');
		default:
			throw new RuntimeException('Unknown errors.');
	}

	if(isset($_POST["submit"])) {
		//echo '</br>check:'.$_FILES["fileToUpload"]["tmp_name"];
		//    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		//    if($check !== false) {
		//        echo "File is a presentation - " . $check["mime"] . ".";
		//        $uploadOk = 1;
		//    } else {
		//        echo "</br>File is not a presentation." . $target_file;
		//	
		//        $uploadOk = 0;
		//    }
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		echo "</br>File already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "</br>File is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "pdf" ) {
		echo "</br>Files not allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "</br>File was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$oldmask = umask(0);
			chmod($target_file, 0777);	
			umask($oldmask);
			echo "</br>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			$execute=shell_exec("/home/ubuntu/public_html/scripts/handle-presentation.sh $target_file");
		} else {
			echo "</br>Error uploading file.";
		}
	}

} catch (RuntimeException $e) {

	echo '</br>'. $e->getMessage();

}


?>
