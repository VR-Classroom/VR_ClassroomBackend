<?php

//$userid=$argv[1];
$userid=$_REQUEST['UID'];
$target_dir = "../users/" . $userid . "/";

try{
$execute=shell_exec("/home/ubuntu/public_html/scripts/handle-presentation-list.sh $target_dir");
echo $execute;

} catch (RuntimeException $e) {
	echo '</br>'. $e->getMessage();
}

?>
