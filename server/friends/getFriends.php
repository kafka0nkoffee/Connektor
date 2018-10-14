<?php

//make connnection 
include("../db/connect.php");
include("../authorize/auth.php");

//select db
$userId = $_SESSION['userId'];
//$friend = $_POST['Friendname']

//$query = "select * from friends where userId1 = '" . $userId ."' or userId2 = '" . $userId ."';";

$query = "SELECT m1.userId1, m1.userId2, m1.dateCreated, m1.status, u1.firstName as fromUserName, u1.lastName as fromLastName, u1.profilepic as fromProfilePic,  u2.firstName as friend, u2.lastName as friendLastName, u2.profilepic as friendProfilePic FROM friends m1 inner join user u1 on u1.userId = m1.userId1 inner join user u2 on u2.userId = m1.userId2 WHERE userId1 = '" . $userId ."' or userId2 = '" . $userId ."';";

//echo $query;
$rows = array();

if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		 $rows[] = $row;
	}    
    $result->close();
}


print json_encode($rows);
?>