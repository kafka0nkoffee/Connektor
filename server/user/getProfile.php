<?php
include "../authorize/auth.php";
include "../db/connect.php";

$userId = $_SESSION['userId'];
$query = "select * from user where userId = '" . $userId ."';";

$rows = array();

if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		 $rows[] = $row;
	}    
    $result->close();
}

$query = "select classNbr from classes where userId = " . $userId;
$classes = array();
if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_assoc()) {
		 array_push($classes, $row['classNbr']);
	}    
    $result->close();
}
$rows[0]['classes'] = implode(',',$classes);
print json_encode($rows);

?>