<?php
session_start();
if(!empty($_SESSION['userId']))
{
$_SESSION['userId']='';
}
header("Location:index.php");

?>
