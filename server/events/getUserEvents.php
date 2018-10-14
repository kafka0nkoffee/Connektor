<?php
include "../authorize/auth.php";
include "../db/connect.php";

$userId = $_SESSION['userId'];
$query = "select * from events where ownerId = " . $userId;
$result=$mysqli->query($query);
$rows = array();
if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		 $rows[] = $row;
	}    
    $result->close();
}
print json_encode($rows);

?>