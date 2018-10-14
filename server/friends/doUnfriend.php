 <?php
include(dirname(__FILE__)."/../authorize/auth.php");
include(dirname(__FILE__)."/../db/connect.php");

$userId = $_SESSION['userId'];
$userId1 = $_POST["userId1"];

    $query = "DELETE FROM `friends` WHERE userId1= " .$userId1. " AND userId2= " .$userId. ' OR userId1=' .$userId.' AND userId2=' .$userId1 .";";

if(!$mysqli->query($query)) {
	printf("Error message: %s\n", $mysqli->error);
	die();
}else{

	echo "Success";

}

?>