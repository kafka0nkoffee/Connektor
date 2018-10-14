<?php
include "../authorize/auth.php";
include "../db/connect.php";

$userId1= $_SESSION['userId'];
$userId2 = $_POST['userId2'];
$dateString = date("Y-m-d");
//$currentDate = date_format($dateString,"Y-m-d");
$status=0;
$query = "insert into friends (userId1, userId2, dateCreated, status) values ('" . $userId1 ."', '".$userId2."', '".$dateString."', '".$status."')";
$result = $mysqli->query($query);
if(!$result) {
	printf("Error message: %s\n", $mysqli->error);
	die();
}

if ($result==TRUE) {

	echo "Success";
}    

   

?>