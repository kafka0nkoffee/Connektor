<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Connektor - Register</title>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" href="css/start.css"/>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   <script>
  UPLOADCARE_LOCALE = "en";
  UPLOADCARE_TABS = "file url facebook gdrive dropbox instagram evernote flickr skydrive";
  UPLOADCARE_PUBLIC_KEY = "58fbe45b38528f97b40a";
</script>
<script charset="utf-8" src="//ucarecdn.com/widget/2.10.1/uploadcare/uploadcare.full.min.js"></script>
<link rel="stylesheet" href="css/style.login.css"/>
</head>

<body>



<div id="main">
<div id="box">
<center><h4>Sign up! | <a href="index.php">Login</a></h4></center>

<form action="" method="post">
	<label>Username</label> 
	<input type="text" name="username" class="input" autocomplete="off" id="username"/>
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
       data-images-only="true" />
	<br/><br />
	<input type="submit" class="button button-primary" value="Register" id="register"/> 
	<span class='msg'></span>
	<div id="error">
	</div>	
	
</form>
</div>	
</div>



<script type="text/javascript">

			$(document).ready(function() {

		
			
			$('#register').click(function()
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
            url: "server/user/doRegister.php",
            data: dataString,
            cache: false,
            beforeSend: function(){ $("#edit").val('Registering...');},
            success: function(data){
            if(data=="Success")
            {
                       window.location.href = "index.php";

            }
            else
            {
			 $("#edit").val('Register')
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