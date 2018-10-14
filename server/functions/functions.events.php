<?php

function isAttending($userId, $eventId, $mysqli) {
	$query = "select * from event_attendees where eventId = " . $eventId . " and userId = " . $userId;
	$result = $mysqli->query($query);
	$numRows = $result->num_rows;
	$result->close();
	return $numRows;
}

function addUserToEvent($userId, $eventId, $mysqli) {
	$query = "insert into event_attendees (userId, eventId) VALUES (" . $userId . "," . $eventId . ")";
	if(!$mysqli->query($query)) {
	printf("Error message 2: %s\n", $mysqli->error);
	die();
	}	 

}

function removeUserFromEvent($userId, $eventId, $mysqli) {
	$query = "delete from event_attendees where userId = " . $userId . " and eventId = " . $eventId;
	if(!$mysqli->query($query)) {
	printf("Error message 3: %s\n", $mysqli->error);
	die();
	}
}
?>