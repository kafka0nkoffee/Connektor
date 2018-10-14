<?php
include "../authorize/auth.php";
include "../db/connect.php";
$eventId = $_POST['eventId'];
$userId = $_SESSION['userId'];
$query = "delete from events where eventId = " . $eventId . " and ownerId = " . $userId;
if(!$mysqli->query($query)) {
	printf("Error message: %s\n", $mysqli->error);
	die();
}
$query = "delete from event_attendees where eventId = " . $eventId;
if(!$mysqli->query($query)) {
	printf("Error message: %s\n", $mysqli->error);
	die();
}
echo "Event deleted succesfully";
?>