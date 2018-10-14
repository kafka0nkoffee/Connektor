<?php
include(dirname(__FILE__)."/../authorize/auth.php");
include(dirname(__FILE__)."/../db/connect.php");



$userId = $_SESSION['userId'];
$friendId = $_POST["friendUserId"];
$action = $_POST['action'];
if($action == "getName") {
	$query = "select firstName from user where userId = " . $friendId;
	
	$result = $mysqli->query($query);
	$row = mysqli_fetch_row($result);
	echo $row[0];
	$result->close();

} else if ($action = "getMessages") {


$query = "SELECT m1.msgId, m1.fromUserId, m1.toUserId, m1.msgData, m1.msgTime, u1.firstName as fromUserName, u2.firstName as toUserName FROM messages m1 inner join user u1 on u1.userId = m1.fromUserID inner join user u2 on u2.userId = m1.toUserId WHERE (m1.fromUserID = "  .$userId.  " and m1.toUserId =  " .$friendId.  " ) or (m1.fromUserID = " .$friendId.  " and m1.toUserId = "  .$userId. " ) Order by m1.msgTime;" ;


$rows = array();

if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		 $rows[] = $row;
	}    
    $result->close();
}

print json_encode($rows);
}

?>