<?php
include "../authorize/auth.php";
include "../functions/functions.events.php";
include "../db/connect.php";

$userId = $_SESSION['userId'];
$eventId = $_REQUEST['eventId'];
$action = $_POST['action'];

if($action == "getAttendStatus") {
	if(isAttending($userId, $eventId,$mysqli)) {
		echo "Click to unattend.";
	} else {
		echo "Attend this event";
	}

} else if($action == "handleAttend") {
	if(isAttending($userId, $eventId,$mysqli)) {
		removeUserFromEvent($userId, $eventId,$mysqli);
		echo "Unattended! Click to attend";
		
	} else {
		addUserToEvent($userId, $eventId,$mysqli);
		echo "Click to unattend.";
	}
}

?>
