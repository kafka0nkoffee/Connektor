<?php
include "../authorize/auth.php";
include "../db/connect.php";

function getEventTime($time) {
	$time = (preg_split('/[A-Z]/', $time));
	$parsedTime = $time[0] . " - " . substr($time[1], 0, -9); //2016-11-14 - 00:00

	$dateFormat = 'Y-m-d - G:i';
	$dateObject = DateTime::createFromFormat($dateFormat, $parsedTime);
	return date ("d F Y - h:i a", $dateObject->getTimestamp());
}

function getEventTimeFromMysql($time) {
	

	$dateFormat = 'Y-m-d H:i:s';
	$dateObject = DateTime::createFromFormat($dateFormat, $time);
	return date ("d F Y - h:i a", $dateObject->getTimestamp());
}

$eventId = $_REQUEST['eventId'];
$ownerId = $_SESSION['userId'];
$output = array();

$query = "select * from events where eventId = " . $eventId;
$result = $mysqli->query($query);
if($result->num_rows>0) {
	$event = mysqli_fetch_row($result);
	$eventTitle = $event[1];
	$eventLink = $event[5];
	$eventLocation = $event[2];
	$eventStartTime = getEventTimeFromMysql($event[3]);
	$eventEndTime = getEventTimeFromMysql($event[4]);
	$eventType = $event[6];
	$entry = array(
			"title" => $eventTitle,
			"startTime" => $eventStartTime,
			"endTime"=> $eventEndTime,
			"location"=> $eventLocation,
			"link" => $eventLink,
			"type" => $eventType,
			"id" => $eventId
		);
	array_push($output, $entry);
	$result->close();
 } else { 


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.uwaterloo.ca/v2/feds/events.json?key=0fab63ce8009f0d4deb68db0c514683c');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resultEvents = curl_exec($curl);
$eventObj = json_decode($resultEvents, TRUE);
$eventDetails = $eventObj['data'];


foreach ($eventDetails as $event) {
	$currEventId = $event['id'];
	if($currEventId == $eventId) {
		$eventTitle = $event['title'];
		$eventLink = $event['url'];
		$eventLocation = $event['location'];
		$eventStartTime = getEventTime($event['start']);
		$eventEndTime = getEventTime($event['end']);
		$entry = array(
				"title" => $eventTitle,
				"startTime" => $eventStartTime,
				"endTime"=> $eventEndTime,
				"location"=> $eventLocation,
				"link" => $eventLink,
				"id" => $currEventId
			);
		array_push($output, $entry);
		break;
	}
}
}
$queryGetAttendees = "select user.userId, user.firstName, user.lastName from event_attendees, user where user.userId = event_attendees.userId and event_attendees.eventId = " . $eventId;
$executedQuery = $mysqli->query($queryGetAttendees);
$rowCount = mysqli_num_rows($executedQuery);
    
if($rowCount > 0) { 
    while($row = mysqli_fetch_assoc($executedQuery)){ 
        $userId = $row['userId'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $entry = array(
				"userId" => $userId,
				"firstName" => $firstName,
				"lastName"=> $lastName
			);
		array_push($output, $entry);

    }
}
print json_encode($output);


?>
