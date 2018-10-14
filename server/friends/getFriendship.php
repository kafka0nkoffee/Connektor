<?php
include "../authorize/auth.php";
include "../db/connect.php";

$userId1 = $_SESSION['userId'];
$userId2 = $_POST['userId2'];
/*$flag = 0; // flag for friendship state of userid1-userid2
$query1 = "select * from friends where userId1 = '" . $userId1 ."';";
$query2 = "select * from friends where userId1 = '" . $userId2 ."';"; */

if($userId1==$userId2) {
	die("ownprofile");
}

$query = "select * from friends where (userId1 = " . $userId1 . " and userId2 = " . $userId2 . ") or (userId1 = " . $userId2 . " and userId2 = " . $userId1 . ")";
$result = $mysqli->query($query);
if($result->num_rows>0) {
	while($row = $result->fetch_array(MYSQL_ASSOC)) {
		if($row['userId1']==$userId1 && $row['status']==0) {
			echo "Awaiting";
		} elseif ($row['userId1']==$userId2  && $row['status']==0) {
			echo "Accept";
		} elseif($row['status']==1) {
			echo $row['dateCreated']; 
		}
		break;
	}

} else {
	echo "Success1";
}

/*$row1 = array();
$row2 = array();
$result = $mysqli->query($query1);
$result2 = $mysqli->query($query2);
if(!$result->num_rows){
	if(!$result2->num_rows){
	echo "Success1"; //there exist no friend reqs from either user to each other
		}
	else{
		//userid2 has some friendships and we need to test if EITHER userid2 has already sent a friend req to userid1 OR users are already friends with userid2 having initiated the friendship
		
		while($row1 = $result2->fetch_array(MYSQL_ASSOC)) {
		 if($row1['userId2']==$userId1){
		 	if($row1['status']==0){
				 	$flag=1;
				 	echo "Accept"; // friend req sent by userid1 already and current user i.e. userid1 needs to accept it
		 		}
		 	else {
		 		//i.e. status=1 which means they are already friends
		 		$flag=1;
		 		echo $row1['dateCreated'];
		 	}
		}
	}    
   $result2->close();	
    if($flag==0)
	echo "Success1"; //this is the case that UserId2 exists in the table but he/she is not friends with UserId1
	
	} 
}
else{

	while($row2 = $result->fetch_array(MYSQL_ASSOC)) {
		 if($row2['userId2']==$userId2){
		 	if($row2['status']==0){
				 	$flag=1;
				 	echo "Awaiting"; // friend req sent but still awaiting response
		 		}
		 	else {
		 		//i.e. status=1 which means they are already friends
		 		$flag=1;
		 		echo $row2['dateCreated'];
		 	}
		}
	}    
   $result->close();
    if($flag==0)
	echo "Success2"; //this is the case that UserId1 exists in the table but he/she is not friends with UserId2

}*/

?>