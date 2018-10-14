<?php
include(dirname(__FILE__)."/../authorize/auth.php");
include(dirname(__FILE__)."/../db/connect.php");



$userId = $_SESSION['userId'];
$friend = $_POST["friendname"];
$msg = $_POST["msg"];

print_r($_POST);

//echo $msg;

$query = "INSERT INTO messages (fromUserId, toUserId, msgData) VALUES (" .$userId. "," .$friend. ",'" .$msg."');";

//$query = "INSERT INTO messages (fromUserId, toUserId, msgData, msgTime) VALUES (1234, 1, 'Hello', CURRENT_TIMESTAMP);";

echo $query;
if(!$mysqli->query($query)) {
	printf("Error message: %s\n", $mysqli->error);
	die();
}

echo "Success";
?>

