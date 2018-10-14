<?php include "server/authorize/auth.php"; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connektor - Edit Profile</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" href="css/start.css"/>
   <link rel="stylesheet" href="css/style.css"/>


   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   <script>
  UPLOADCARE_LOCALE = "en";
  UPLOADCARE_TABS = "file url facebook gdrive dropbox instagram evernote flickr skydrive";
  UPLOADCARE_PUBLIC_KEY = "58fbe45b38528f97b40a";
</script>
<script charset="utf-8" src="//ucarecdn.com/widget/2.10.1/uploadcare/uploadcare.full.min.js"></script>
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


        <div id="main">
		<h3>Account Settings</h3>
		<div id="boxEditProfile">
		<form action="" method="post">
			<label>Username</label> 
			<input type="text" name="username" class="input" autocomplete="off" id="username" readonly="" />
			<label>Password</label>
			<input type="password" name="password" class="input" autocomplete="off" id="password"/>
			<label>First Name </label>
			<input type="text" name="firstname" class="input" autocomplete="off" id="firstname"/>
			<label>Last Name</label>
			<input type="text" name="lastname" class="input" autocomplete="off" id="lastname"/>
			<label>Phone</label>
			<input type="text" name="phone" class="input" autocomplete="off" id="phone"/>
			<label>Website</label>
			<input type="text" name="website" class="input" autocomplete="off" id="website"/>
			<label>Class Numbers</label>
			<input type="text" name="classes" class="input" autocomplete="off" id="classes"/>
			<label>Profile Pic</label>
			<input id="profilepic" type="hidden" role="uploadcare-uploader"
			       data-crop="disabled"
			       data-images-only="true" />			<br/><br />
			<input type="submit" class="button button-primary" value="Edit Profile" id="edit"/> 
			<span class='msg'></span>
			<div id="error">
			</div>	

		</form>	
			</div>
		</div>
       


<script type="text/javascript">
			$(document).ready(function() {

			$.ajax({
            type: "POST",
            url: "server/user/getProfile.php",
            cache: false,
            success: function(data){
            if(data)
	            {
	            	var parsedData=JSON.parse(data);
	            	userDetails=parsedData[0];
	            	var widget = uploadcare.Widget('#profilepic');
	
	            	console.log(data);
	            	console.log(userDetails.userId);
	            	$("#username").val(userDetails.userId);
					$("#password").val(userDetails.password);
					$("#firstname").val(userDetails.firstName);
					$("#lastname").val(userDetails.lastName);
					$("#phone").val(userDetails.phone);
					$("#website").val(userDetails.website);
					$("#classes").val(userDetails.classes);
					widget.value(userDetails.profilepic)
	            }
	            else
	            {
				 $("#error").html("<span style='color:#cc0000'>Error:</span> Error fetching profile info! ");
	            }
            }
            });
			
			$('#edit').click(function()
			{
				// var dataString = $(this).serializeArray();
			var username=$("#username").val();
			var password=$("#password").val();
			var firstname=$("#firstname").val();
			var lastname=$("#lastname").val();
			var phone=$("#phone").val();
			var website=$("#website").val();
			var classes=$("#classes").val();
			var profilepic=$("#profilepic").val();

		    var dataString = 'username='+username+'&password='+password+'&firstname='+firstname+'&lastname='+lastname+'&phone='+phone+'&website='+website+'&classes='+classes+'&profilepic='+profilepic;
			if($.trim(username).length>0 && $.trim(password).length>0)
			{
			
 
			$.ajax({
            type: "POST",
            url: "server/user/doEditProfile.php",
            data: dataString,
            cache: false,
            beforeSend: function(){ $("#edit").val('Updating...');},
            success: function(data){
            if(data=="Success")
            {
            $("#edit").val('Updated!');
            }
            else
            {
			 $("#edit").val('Edit Profile')
			 $("#error").html("<span style='color:#cc0000'>Error:</span> " + data);
            }
            }
            });
			
			}
			return false;
			});
			
				
			});
		</script>
</body>
</html>