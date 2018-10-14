<?php
include "../authorize/auth.php";
include "../db/connect.php";

$dayMap = array(
	"1" => "M",
	"2" => "T",
	"3" => "W",
	"4" => "Th",
	"5" => "F",
	"6" => "Sat",
	"7" => "Sun"
	);

function getEventTime($time) {
	$time = (preg_split('/[A-Z]/', $time));
	return str_replace(":00-05:00", "", $time[1]);
}

function getEventDate($date) {
	$date = (preg_split('/[A-Z]/', $date));
	return $date[0];
}

function getEventTimeFromMysql($time) {
	$dateFormat = 'Y-m-d H:i:s';
	$dateObject = DateTime::createFromFormat($dateFormat, $time);
	return date ("H:i", $dateObject->getTimestamp());
}

function getEventDateFromMysql($date) {
	$dateFormat = 'Y-m-d H:i:s';
	$dateObject = DateTime::createFromFormat($dateFormat, $date);
	return date ("Y-m-d", $dateObject->getTimestamp());
}

function date_compare($a, $b)
{
    $t1 = strtotime($a['startTime']);
    $t2 = strtotime($b['startTime']);
    return $t1 - $t2;
}  

$userId = $_SESSION['userId'];

$query = "select classNbr from classes where userId = '" . $userId ."';";

$classNumberArray = array();

if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_assoc()) {
		 array_push($classNumberArray,$row['classNbr']);
	}    
    $result->close();
}

$dateString = $_POST['date'];
$date = DateTime::createFromFormat("Y-m-d", $dateString);
$dateDay = $date->format("N");

$output = array();

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.uwaterloo.ca/v2/feds/events.json?key=0fab63ce8009f0d4deb68db0c514683c');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resultEvents = curl_exec($curl);
$eventObj = json_decode($resultEvents, TRUE);
$eventDetails = $eventObj['data'];

foreach ($eventDetails as $event) {
	$eventTitle = $event['title'];
	$eventId = $event['id'];
	$eventLink = $event['url'];
	$eventLocation = $event['location'];
	$eventStartTime = getEventTime($event['start']);
	$eventEndTime = getEventTime($event['end']);
	$eventDate = getEventDate($event['start']);

	if(!strcmp($dateString, $eventDate)) {
		$entry = array(
				"title" => $eventTitle,
				"startTime" => $eventStartTime,
				"endTime"=> $eventEndTime,
				"location"=> $eventLocation,
				"link" => $eventLink,
				"id" => $eventId
			);
		array_push($output, $entry);
	}
	


}

$query = "select * from events where eventType = 2 or ownerId in (select userId1 as userId from friends where userId2 = " . $userId . " union select userId2 as userId from friends where userId1 = " . $userId . ") or ownerId = " . $userId;
$result = $mysqli->query($query);
while($row = mysqli_fetch_assoc($result)){ 

		$eventTitle = $row['eventTitle'];
        $eventId = $row['eventId'];
        $eventLink = $row['eventUrl'];
        $eventLocation = $row['eventLocation'];
        $eventStartTime = getEventTimeFromMysql($row['startTime']);
        $eventEndTime = getEventTimeFromMysql($row['endTime']);
        $eventDate = getEventDateFromMysql($row['startTime']);
        if(!strcmp($dateString, $eventDate)) {
        $entry = array(
				"title" => $eventTitle,
				"startTime" => $eventStartTime,
				"endTime"=> $eventEndTime,
				"location"=> $eventLocation,
				"link" => $eventLink,
				"id" => $eventId
			);
		array_push($output, $entry);
		}

    }


foreach ($classNumberArray as $classNumber) {
	
	curl_setopt($curl, CURLOPT_URL, 'https://api.uwaterloo.ca/v2/courses/' . $classNumber . '/schedule.json?key=0fab63ce8009f0d4deb68db0c514683c');
	
	$result = curl_exec($curl);

	$classObj = json_decode($result, TRUE);
	if($classObj['meta']['status']!=204) {
	$classDetails = $classObj['data'][0];
	
	$classTitle = $classDetails['title'];
	$classTimings = $classDetails['classes'][0]['date'];
	$startTime = $classTimings['start_time'];
	$endTime = $classTimings['end_time'];
	$days = $classTimings['weekdays'];
	$location = $classDetails['classes'][0]['location']['building'] . " " . $classDetails['classes'][0]['location']['room'];
	$dayLetters = preg_split('/(?=[A-Z])/',$days);

		if(in_array($dayMap[$dateDay], $dayLetters)) {
			$entry = array(
					"title" => $classTitle,
					"startTime" => $startTime,
					"endTime"=> $endTime,
					"location"=> $location
				);

			//var_dump($entry);
			array_push($output, $entry);
		}
	}

}
  
usort($output, 'date_compare'); 

print json_encode($output);

?>