<?php
include "../authorize/auth.php";
include "../db/connect.php";

$userId = $_SESSION['userId'];
foreach($_POST as $key => $value) {
	${$key} = $value;
}

if($username == '' || $firstname == '' || $lastname == '' || $phone == '' || $classes == '' || $website == '') {
	die('Please fill all the required fields');
}

if (!preg_match("/^[a-zA-Z]*$/",$firstname)) {
  die("Only letters allowed in First Name"); 
}

if (!preg_match("/^[a-zA-Z]*$/",$lastname)) {
 die("Only letters allowed in Last Name"); 
}

if (!preg_match("/^[0-9]*$/",$username)) {
  die("Use your student ID for username"); 
}

if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
  die("Invalid URL for website"); 
}

 if(!preg_match('/^\d{10}$/',$phone)) // phone number is valid
    {
    	die("Invalid Phone number");
    }

if($profilepic=='') {
	$profilepic = 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png';
}



if (!preg_match("/^\d+(,\d+)*$/",$classes)) {
  die("Invalid Class format"); 
}


if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$profilepic)) {
  die("Invalid Profile Pic"); 
}


$classes = explode(",", $classes);


$queryUserUpdate = "UPDATE user SET firstName = '" . $firstname . "', lastName = '" . $lastname . "', phone = '" . $phone . "', password = '" . $password . "', website = '" . $website . "', profilepic = '" . $profilepic . "'  WHERE user.userId = " . $userId;
if(!$mysqli->query($queryUserUpdate)) {
	printf("Error message: %s\n", $mysqli->error);
}

$queryClassDrop = "Delete from classes where userId = " . $userId;

if(!$mysqli->query($queryClassDrop)) {
	printf("Errormessage: %s\n", $mysqli->error);
}

foreach ($classes as $class) {
	$classAddQuery = "INSERT INTO classes (userId, classNbr) VALUES  (" . $userId . "," . $class . ")";
	if(!$mysqli->query($classAddQuery)) {
		printf("Errormessage: %s\n", $mysqli->error);
	}
}
$mysqli->close();
echo "Success";

?>