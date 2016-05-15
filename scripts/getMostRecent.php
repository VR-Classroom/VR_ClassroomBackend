<?php
clearstatcache();
if (0 == filesize("../voiceData/lastUpload.txt")) {
	echo '0';
}
else {
	$myfile = fopen("../voiceData/lastUpload.txt", r);
	echo fgets($myfile);
	fclose($myfile);
}
?>
