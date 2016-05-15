<?php

$userid=$_REQUEST['UID'];
$ppt=$_REQUEST['PPT'];

//$userid=$argv[1];
//$ppt=$argv[2];


$target_dir = "../users/" . $userid . "/" . $ppt ."/";

try{
$execute=shell_exec("/home/ubuntu/public_html/scripts/handle-presentation-size.sh $target_dir");
print_r($execute);

} catch (RuntimeException $e) {

	echo '</br>'. $e->getMessage();

}

?>
