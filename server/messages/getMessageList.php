<?php
include(dirname(__FILE__)."/../authorize/auth.php");
include(dirname(__FILE__)."/../db/connect.php");

$userId = $_SESSION['userId'];
$query = "SELECT t1.msgId, t1.fromUserId, t1.toUserId, t1.msgData, t1.msgTime, u1.firstName as fromUserName, u2.firstName as toUserName, u1.profilepic as fromUserNamePic , u2.profilepic as toUserNamePic FROM messages t1, user u1, user u2 WHERE msgTime IN (select Max(msgTime) from messages t2 where t1.fromUserId = " . $userId . " or t1.toUserId = " .$userId . " group by toUserId, fromUserId ) and t1.fromUserId = u1.userId and t1.toUserId = u2.userId Order by msgTime DESC";


$rows = array();

if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		 $rows[] = $row;
	}    
    $result->close();
}




print json_encode($rows);

?>