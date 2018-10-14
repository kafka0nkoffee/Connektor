<?php
include "../authorize/auth.php";
include "../db/connect.php";

foreach($_POST as $key => $value) {
	${$key} = $value;
}

$ownerId = $_SESSION['userId'];
$dateFormat = 'd F Y - h:i a';
$phpStartTime = DateTime::createFromFormat($dateFormat, $startTime);
$phpEndTime = DateTime::createFromFormat($dateFormat, $endTime);
$mysqlStartTime = date ("Y-m-d H:i:s", $phpStartTime->getTimestamp());
$mysqlEndTime = date ("Y-m-d H:i:s", $phpEndTime->getTimestamp());


if(isset($_POST['eventId']) && $_POST['eventId'] != '') {
	$queryToUpdate = "UPDATE events SET eventTitle = '" . $eventTitle . "', eventLocation = '" . $eventLocation . "', startTime = '" . $mysqlStartTime . "', endTime = '" . $mysqlEndTime . "', eventUrl = '" . $eventUrl ."', eventType = '" . $eventType . "' WHERE eventId = " . $_POST['eventId'];

	if(!$mysqli->query($queryToUpdate)) {
	printf("Error message: %s\n", $mysqli->error);
	die();
	}
	$mysqli->close();
	echo "Event updated successfully";
} else {
$queryEventInsert = "INSERT INTO events (eventTitle, eventLocation, startTime, endTime, eventUrl, eventType, ownerId) VALUES ('" . $eventTitle . "','" . $eventLocation . "','" . $mysqlStartTime . "','" . $mysqlEndTime . "','" . $eventUrl . "'," . $eventType . "," . $ownerId . ")";
if(!$mysqli->query($queryEventInsert)) {
	printf("Error message: %s\n", $mysqli->error);
	die();
}

$mysqli->close();

echo "Event added successfully"; 
}

?>