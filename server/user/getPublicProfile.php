<?php
include "../authorize/auth.php";
include "../db/connect.php";

$userId = $_POST['userId2'];

$query = "select * from user where userId = '" . $userId ."';";

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


$rows = array();

if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		 $rows[] = $row;
	}    
    $result->close();
}

$query = "select classNbr from classes where userId = " . $userId;
$classes = array();
if ($result = $mysqli->query($query)) {

	while($row = $result->fetch_assoc()) {
		curl_setopt($curl, CURLOPT_URL, 'https://api.uwaterloo.ca/v2/courses/' . $row['classNbr'] . '/schedule.json?key=0fab63ce8009f0d4deb68db0c514683c');
		$classObj = json_decode(curl_exec($curl), TRUE);
		$classTitle = '';
		if($classObj['meta']['status']!=204) {	
			$classTitle = $classObj['data'][0]['title'];
		}

		 array_push($classes, $classTitle);
	}    
    $result->close();
}
$rows[0]['classes'] = implode(',',$classes);
print json_encode($rows);

?>