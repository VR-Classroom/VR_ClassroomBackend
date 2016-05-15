<?php
//Sample Database Connection Syntax for PHP and MySQL.

//Connect To Database
$hostname="localhost";
//$hostname="52.38.66.127";
$username="ubuntu";
$password="1234";
$dbname="VR_CLASSROOM";

$connection = mysql_connect($hostname, $username, $password);

mysql_select_db($dbname, $connection);

// Check If Record Exists

$query = "SELECT * FROM USERS";

$result = mysql_query($query);
$res = array();
$cnt = array();

echo '<p>checking result</p>';
if($result)
{


	echo '<table>';
	$first = true;
	while($row = mysql_fetch_assoc($result))
	{
		if($first){
			$first = false;

			echo '<tr>';
			foreach($row as $key => $field){
				echo '<td>' . htmlspecialchars($key) . '</td>';
			}
			echo '</tr>';
		}
		echo '<tr>';
		foreach($row as $key => $field){
			echo '<td>' . htmlspecialchars($field) . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo json_encode($res);
}
else
echo "<p>SOMETHING WENT WRONG</p>";
?>

