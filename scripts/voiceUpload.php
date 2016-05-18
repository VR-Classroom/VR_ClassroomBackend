<?php

$myfile = fopen("../voiceData/butt.txt", w);

fwrite($myfile, "They want to upload a voice");

echo "Dear Lord";

if (!empty($_GET) || !empty($_POST)) {
	fwrite($myfile, "I got a get request!\n");
} else {
	fwrite($myfile, "\nWhat the literal shit\n");
}

if (!empty($_FILES)) {
	fwrite($myfile, "I GOT SOMETHINGGGGGGG\n");

	$filename = $_FILES['file']['name'];

	$uploadfile = '../voiceData/' . $filename;
	if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
		fwrite($myfile, "" . $_FILES["file"]["error"]. "\n");
	}
	else {
		fwrite($myfile, "I UPLOAD\n");

		$output = exec("echo $filename | cut -d'-' -f4 | head -c-5");
		fwrite($myfile, $output);
		if (strcmp($output, "0")) {
			exec("sox ../voiceData/total.wav $uploadfile ../voiceData/temp.wav");
			exec("mv ../voiceData/temp.wav ../voiceData/total.wav");
		}
		else {
			exec("cp $uploadfile ../voiceData/total.wav");
		}
	}
}
else {
	fwrite($myfile, "Ooops");
}

fclose($myfile);

?>
