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
  <link rel="stylesheet" href="css/normalize.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript">
    function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
    });
    return vars;
    }
    
    var currentUserId;
    var friendUserId = getUrlVars()["userId"];
    var friendUserName;
    loadMessages(friendUserId);

   function loadMessages(friendUserId) {
     var dataString = 'friendUserId=' + friendUserId;
        $("#messages").html("Loading...");
        $.ajax({

                type: "POST",
                url: "server/messages/getMessages.php",
                data: dataString + '&action=getName',
                cache: false,
                success: function(data){
                  friendUserName = data;
                 $("#convoinfo").html("You and <a href='publicprofile.php?userId=" + friendUserId + "'>" + data + "</a>");
                }
        });

        $.ajax({

                type: "POST",
                url: "server/messages/getMessages.php",
                data: dataString + '&action=getMessages',
                cache: false,
                success: function(data){
                  var entry = '<div id="conversation" class="conversation">';
                 if(data) {
                  var parsedData=JSON.parse(data);
                  if(parsedData.length>0) {
                   for (var i = 0; i < parsedData.length; i++) {
                      var fromUserId = parsedData[i].fromUserId;
                      var toUserId = parsedData[i].toUserId;
                      var msgData = parsedData[i].msgData;
                      var fromUserName = parsedData[i].fromUserName;
                      var toUserName =parsedData[i].toUserName;   
                      if(fromUserId==friendUserId) {
                        entry = entry + '<div class="friend"><div class="content">'+msgData+'</div></div>';
                      } else {
                        entry = entry + '<div class="user"><div class="content">'+msgData+'</div></div>';
                      }
                    }
                    entry = entry + '</div>';
                    $("#messages").html(entry);
                  } else {
                  }
                 }
                }
        });

   }

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


<div id="main">
<div class ="heading"><div id="convoinfo" class="convn-info"></div></div>
  <div id="boxChat">
    <form id="myform" action="" method="post">

     <ul id="messages">
     <div id="conversation" class="conversation"></div>
    </ul>
    <label>Send Message</label>
    <input type="text" class="input" autocomplete="off" id="message"/>
    <input type="button" class="button button-primary" value="Send Message" id="sendmsg"/>
  </form>	
</div>
</div>



<script type="text/javascript">

$("#message").keyup(function(event) {
  if(event.keyCode == 13) {
    var msg = $("#message").val();
  var datastring = "&msg=" + msg + "&friendname=" + friendUserId; 
  $.ajax({
    type: "POST",
    url: "server/messages/doMessage.php",
    cache: false,
    data: datastring,
    success: function(data){
                $("#conversation").append('<div class="user"><div class="content">'+msg+'</div></div>');
                $('#myform')[0].reset();
              }
            });
  return false;
  }
  });

 

$('#sendmsg').click(function(){
  var msg = $("#message").val();
  var datastring = "&msg=" + msg + "&friendname=" + friendUserId; 
  $.ajax({
    type: "POST",
    url: "server/messages/doMessage.php",
    cache: false,
    data: datastring,
    success: function(data){
                //loadMessages(friendUserId);
                $("#conversation").append('<div class="user"><div class="content">'+msg+'</div></div>')
                //$("body").load("messagethread.php?userId=" + friendUserId).hide().fadeIn(1500).delay(6000);
              }


            });
  return false;
});
</script>
</body>
</html>