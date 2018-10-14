<?php
include("../db/connect.php");
session_start();
if(isSet($_POST['username']) && isSet($_POST['password']))
{
	$username=$_POST['username']; 
	$password=$_POST['password']; 

	$query="SELECT userId,firstName FROM user WHERE userId='$username' and password='$password'";

	$result = $mysqli->query($query);
	$row_cnt = $result->num_rows;



if($row_cnt==1)
{
	$row = mysqli_fetch_row($result);
	$_SESSION['userId']=$username;
	$_SESSION['userName']=$row[1];
	echo "Success";
}

$result->close();
}
?>