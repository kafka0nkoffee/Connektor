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
  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700'>
  <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
<div class='chat'>
  <header>
    <h2 class='title'>
      <a>Messages</a>
  </h2>
  <ul class='tools'>
</ul>
</header>

<div class='body'>
    <ul>
      <li id ='chatconvo'>

      </li>
  </ul>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {

   $.ajax({
      type: "POST",
      url: "server/messages/getMessageList.php",
      cache: false,
      success: function(data){
        if(data)
        {
          var parsedData=JSON.parse(data);

          console.log(data);
          var entry = '';

          //This Loop will print out a list of the most recent messages. The loops find the most recent message amongst friends
          for (var i = 0; i < parsedData.length; i++) {

             for( var j = i +1; j < parsedData.length; j++){
                if(parsedData[i].fromUserId === parsedData[j].toUserId && parsedData[i].toUserId === parsedData[j].fromUserId){
                    parsedData[i]["singlemsg"] = false;
                    parsedData[j]["singlemsg"] = false;

                    var friend;
                    var friendId;
                    var friendprofilepic;
                    if(parsedData[i].msgTime > parsedData[j].msgTime){
                        var fromuser = parsedData[i].fromUserId;
                        var touser = parsedData[i].toUserId;
                        var msgcontent = parsedData[i].msgData;
                        var fromusername = parsedData[i].fromUserName;
                        var tousername =parsedData[i].toUserName;
                        var datetime = parsedData[i].msgTime;
                        var tousernamepic = parsedData[i].toUserNamePic;
                        var fromusernamepic = parsedData[i].fromUserNamePic;
                    }else{
                        msgcontent = parsedData[j].msgData;
                        touser = parsedData[j].toUserId;
                        fromuser = parsedData[j].fromUserId;
                        fromusername = parsedData[i].fromUserName;
                        tousername =parsedData[i].toUserName;
                        datetime = parsedData[i].msgTime;
                        tousernamepic = parsedData[i].toUserNamePic;
                        fromusernamepic = parsedData[i].fromUserNamePic;

                    }
                    if(fromuser == <?php echo $_SESSION['userId'] ?>){
                        friend = tousername;
                        friendId = touser;
                        friendprofilepic = tousernamepic;

                    }else{
                     friend = fromusername;
                     friendId = fromuser;
                     friendprofilepic = fromusernamepic;

                 }

                 entry = entry + "<li>" + "<a class='thumbnail' href='publicprofile.php?userId=" + friendId + "'>" + "<img src='" + friendprofilepic + "''>" + "</a>"
                 +"<a href='messagethread.php?userId=" + friendId + "'><div class='content'>"
                 +"<h3>" + friend + "</h3>"
                 + "<span class = 'preview'>" + msgcontent + "-" + datetime + "</span>"
                 +"</div></li></a>";
             }


         }

     }
     //Below is required if there is only 1 message between users
          for (var i = 0; i < parsedData.length; i++) {
                  if(parsedData[i].singlemsg != false){
                msgcontent = parsedData[i].msgData;
                touser = parsedData[i].toUserId;
                fromuser = parsedData[i].fromUserId;
                fromusername = parsedData[i].fromUserName;
                tousername =parsedData[i].toUserName;
                datetime = parsedData[i].msgTime;
                tousernamepic = parsedData[i].toUserNamePic;
                fromusernamepic = parsedData[i].fromUserNamePic;

                if(fromuser == <?php echo $_SESSION['userId'] ?>){
                    friend = tousername;
                    friendId = touser;
                    friendprofilepic = tousernamepic;

                }else{
                 friend = fromusername;
                 friendId = fromuser;
                 friendprofilepic = fromusernamepic;

             }

                 entry = entry + "<li>" + "<a class='thumbnail' href='publicprofile.php?userId=" + friendId + "'>" + "<img src='" + friendprofilepic + "''>"  + "</a>"
             +"<a href='messagethread.php?userId=" + friendId + "'><div class='content'>"
             +"<h3>" + friend + "</h3>"
             + "<span class = 'preview'>" + msgcontent + "-" + datetime + "</span>"
             +"</div></li></a>";
            }
 }
 $('#chatconvo').html(entry);
}
else
{
 $("#error").html("<span style='color:#cc0000'>Error:</span> Error fetching profile info! ");
}
}
});

$(document).on('click', '#messageConvo', function() 
{

  var convoinfo = this.name;
  $("#edit").val('Updated!');
  $("body").load("messagethread.php", {'param1' : convoinfo}).hide().fadeIn(1500).delay(6000);
  return false;
});


});


</script>
</body>
</html>