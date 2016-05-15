<?php

$myfile = fopen("butt" . (string)(intval(($_FILES['file']['name']) % 20)) . ".txt", w);

fwrite($myfile, "They want to upload a voice");

if (!empty($_GET) || !empty($_POST)) {
	fwrite($myfile, "I got a get request!\n");
} else {
	fwrite($myfile, "\nWhat the literal shit\n");
}

if (!empty($_FILES)) {
	fwrite($myfile, "I GOT SOMETHINGGGGGGG\n");

	$uploadfile = '../voiceData/zzz' . (string)(intval(($_FILES['file']['name']) % 20));
	if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
		fwrite($myfile, "" . $_FILES["file"]["error"]. "\n");
	}
	else {
		$myfile2 = fopen("../voiceData/lastUpload.txt", w);
		fwrite($myfile2, "" . $_FILES['file']['name']);
		fclose($myfile2);
	}
}
else {
	fwrite($myfile, "Ooops");
}

fclose($myfile);

?>
