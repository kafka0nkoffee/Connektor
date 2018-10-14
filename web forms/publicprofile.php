<?php include "server/authorize/auth.php"; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connektor - User Profile</title>
     <script src="http://code.jquery.com/jquery-2.0.3.min.js" type="text/javascript"></script>
     <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script><!-- Tether for Bootstrap -->      
	 <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/start.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/style-userProfile.css">
    <script type="text/javascript">
    	function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
    });
    return vars;
    }
    var userId2 = getUrlVars()["userId"];
    var dataString = 'userId2=' + userId2;
    var userDetails;
    $.ajax({ //open1
				            type: "POST",
				            url: "server/user/getPublicProfile.php",
				            data: dataString,
				            cache: false,
				            success: function(data){
					            	var parsedData=JSON.parse(data);
					            	userDetails=parsedData[0];
					            	$("#fnm").html("First Name");
									$("#firstname").html(userDetails.firstName);
									$("#lnm").html("Last Name");
									$("#lastname").html(userDetails.lastName);
									document.getElementById("profilepic").src=(userDetails.profilepic);
									loadFriendshipButton();
									$("#loadingMsg").html("");
									$("#userFooter").css("display", "block");
									$("#profile-info").css("display", "block");

									
									

				            }
		            }); //close1
    </script>

 
   
</head>

<body>

 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Connektor</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li ><a href="schedule.php">Schedule</a></li>
            <li ><a href="events.php">Events</a></li>
            <li ><a href="friends.php">Friends</a></li>
            <li ><a href="message.php">Messages</a></li>
            <li ><a href="editprofile.php">Account</a></li>
            <li ><a href="logout.php">Logout</a></li>
          </ul>
          
        </div><!--/.nav-collapse -->
      </div>
    </nav>



 <div class="container">
          <div class="row">
          <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
               <p id="time"></p>
          </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
       
       
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 id="panelTitle" class="panel-title">Hello <?php echo $_SESSION['userName']; ?>!</h3>
                </div>
                <div class="panel-body">
                <div id="loadingMsg">Loading user info...</div>
                  <div id="profile-info" style="display: none;" class="row">

                  <div class="col-md-3 col-lg-3 " align="center"> <img id = "profilepic" src="images/user-icon.png" class="image-circle" style="width: 128px; height:128px;"> </div>                    
                  
                    <div class=" col-md-9 col-lg-9 "> 
                          <form action="" method="post">
                          <table class="table table-user-information">
                                <tbody>
						            <tr>
									<td><label id="usrnm"></label></td> 
									<td><div id="username"></div></td>
									</tr>
									<tr>
									<td><label id="fnm"> </label></td>
									<td><div id="firstname"></div></td>
									</tr>
									<tr>
									<td><label id="lnm"></label></td>
									<td><div id="lastname"></div></td>
									</tr>
									<tr>
									<td><label id="ph"></label></td>
									<td><div id="phone"></div></td>
									</tr>
									<tr>
									<td><label id="web"></label></td>
									<td><div id="website"></div></td>
									</tr>
									<tr>
									<td><label id="cls"></label></td>
									<td><div id="classes"></div></td>
									</tr>
                                </tbody>
                          </table>
                      </form>
                       <input type="submit" class="button button-primary" value="Send Friend Request" id="addfriend"/>
                      <div id="error"></div>
                    </div>
                  </div>
                </div>
                     <div class="panel-footer" id="userFooter" style="display: none;">
                            <a  id="sndMsg" href="messagethread.php" onclick="location.href=this.href+'?userId='+userId2;return false;" data-original-title="Send a Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                            <span class="pull-right">
                                <a id="unf" data-original-title="Unfriend User OR Cancel Request" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                            </span>
                        </div>
                
              </div>
            </div>
          </div>
        </div>





    

		<script type="text/javascript">

		var friendshipFlag = 0;

    	

    	function clearPrivateDetails() {
											$("#ph").html("");
											$("#phone").html("");
											$("#web").html("");
											$("#website").html("");
											$("#cls").html("");
											$("#classes").html("");
    	}

    	 function loadFriendshipButton() {
   	    	var userString = 'userId2=' + userId2;
	    	$.ajax({ //open11
							            type: "POST",
							            url: "server/friends/getFriendship.php",
							            data: userString,
							            cache: false,
							            success: function(data){
							            if(data=="ownprofile") {
							            	$("#ph").html("Phone");
											$("#phone").html(userDetails.phone);
											$("#web").html("Website");
											$("#website").html(userDetails.website);
											$("#cls").html("Courses Attending");
											$("#classes").html(userDetails.classes);
							            	$("#addfriend").val("Edit Profile");
							            	$("#unf").css("display", "none");
							            	$("#sndMsg").css("display", "none");
							            	friendshipFlag = 3;

							            } else if(data=="Success1" || data=="Success2")
							            {
							            	$("#addfriend").val('Send Friend Request');
							            	$("#unf").css("display", "none");
							            	friendshipFlag=2;
							        	}
							            else if (data=="Awaiting") {
							            	$("#addfriend").val('Awaiting');
							            	$("#unf").css("display", "block");
							            }
							            else if (data=="Accept") {
							            	$("#addfriend").val('Accept Request');
							            	$("#unf").css("display", "block");
							           		friendshipFlag=1;	
							            }
							            else
							            {
							            	//this option means they are already friends hence we simply display dateSinceFriends
							   
											$("#ph").html("Phone");
											$("#phone").html(userDetails.phone);
											$("#web").html("Website");
											$("#website").html(userDetails.website);
											$("#cls").html("Courses Attending");
											$("#classes").html(userDetails.classes);
											var friendSnc = 'Friend Since ' + data;
							            	$("#addfriend").val(friendSnc);
							            	$("#unf").css("display", "block");

							            	friendshipFlag=1;
										 	//$("#error").html("<span style='color:#cc0000'>Error:</span> Error updating! ");
							            }
							            }
					            });
	    }

    	 $("#unf").click(function () {

    	
	    
	    if (!confirm("Are you sure you want to unfriend?")){
	      return false;
	    }
	    var dataString = 'userId1=' + userId2;
	    $.ajax({
	    	type: "POST",
	            url: "server/friends/doUnfriend.php",
	            data: dataString,
	            cache: false,
	            success: function(data){
		          	loadFriendshipButton();
		          	clearPrivateDetails();
            	}
	    });
	});

	   
			
			$(document).ready(function() {

					$(function () {
  						$('[data-toggle="tooltip"]').tooltip()
					})

					

          			


	$('#addfriend').click(function(){ //open2

														if(friendshipFlag==2){//openIf1

																friendshipFlag=0;

																$.ajax({ //open3
													            type: "POST",
													            url: "server/friends/doAddFriend.php",
													            data: dataString,
													            cache: false,
													            success: function(data){
													           if(data=="Success")
													            {
													            $("#addfriend").val('Awaiting Response!'); 
													            loadFriendshipButton();
																$("#unf").css("display", "block");

													            // this should ideally be "Awaiting for Response on sent friend req." :: waiting for team mate to finish module.
													            }
													            else
													            {
													            	alert(dataString);
													            	$("#error").html("<span style='color:#cc0000'>Error:</span> Error updating! ");
													            }
													            }
													            }); //close3
															}//closeIf1
															else if(friendshipFlag==1){//openIf2
																		// dont have robert's moduel for now so blank click will ocuur
																friendshipFlag=0;
																$.ajax({ //open3
													            type: "POST",
													            url: "server/friends/doAccept.php",
													            data: "userId1="+userId2,
													            cache: false,
													            success: function(data){
													           if(data=="Success")
													            loadFriendshipButton();
													        	$("#unf").css("display", "block");
													            }
													            });

															} else if(friendshipFlag==3) {
																friendshipFlag=0;
																window.location.replace("editprofile.php");

															}else{
															; //BECAUSE this button shouldn't work outside of the two scenarios: 1. users are not friends 2. current user has not sent any req to user2 3. current user dooesn't have any pednign req from user2
														}
													}); // close2	



			});
					

			
		</script>

      
</body>
</html>