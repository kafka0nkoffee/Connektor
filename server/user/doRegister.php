<?php
include "../db/connect.php";
include "../authorize/auth.php";

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
$queryUserInsert = "INSERT INTO user (userId, firstName, lastName, phone, password, website, profilepic) VALUES (" . $username . ",'" . $firstname . "','" . $lastname . "'," . $phone . ",'" . $password . "','" . $website . "','". $profilepic . "')";


if(!$mysqli->query($queryUserInsert)) {
	printf("Error message: %s\n", $mysqli->error);
	die();
}

foreach ($classes as $class) {
	$classAddQuery = "INSERT INTO classes (userId, classNbr) VALUES  (" . $username . "," . $class . ")";
	if(!$mysqli->query($classAddQuery)) {
		printf("Errormessage: %s\n", $mysqli->error);
		die();
	}
}
$mysqli->close();

echo "Success";

?>