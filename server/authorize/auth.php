<?php
session_start();
if(empty($_SESSION['userId']))
{
$home_url = 'http://' . $_SERVER['HTTP_HOST'] .'/connektor/index.php'; //Change this URL where you want to point un-authorized users
header('Location: '.$home_url);
}
?>