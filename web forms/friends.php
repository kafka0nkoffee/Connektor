<?php include "server/authorize/auth.php";
?>

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
  <link rel="stylesheet" href="css/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>

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
    <div class = 'body'>
        <header>
    <h2 class='title'>
      <a>Friends List</a>
    </h2>
  </header>
      <ul>
        <li id ='chatconvo'>
        </li>
      </ul>
    </div>
  </div>


   <script type="text/javascript">
    function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
    });
    return vars;
    }
    
  // var userId = getUrlVars()["userId"];
  
    
    var userId = <?php echo $_SESSION['userId'] ?>;

  $(document).ready(function() {
    $.ajax({
      type: "POST",
      url: "server/friends/getFriends.php",
      cache: false,
      success: function(data){
        var entry = '';
        if(data)
        {
          var parsedData=JSON.parse(data);  
          var friend;
          var status;
          var fromuser;
          var touser;
          var myuserId;
          var friendId;
          var friendlastname;
          var friendsince;
          var listrequests = '<h3>Pending Requests</h3>';
          var listfriends = '<h3>Current Friends</h3>'
          var friendprofilepic;

          for (var i = 0; i < parsedData.length; i++) {

            friendsince = parsedData[i].dateCreated;


            if(parsedData[i].userId1 == userId) {
              friend = parsedData[i].friend;
              friendlastname = parsedData[i].friendLastName;
              friendprofilepic = parsedData[i].friendProfilePic;
              friendId = parsedData[i].userId2;
              myuserId = parsedData[i].userId1;

            }else{

              friend = parsedData[i].fromUserName;
              friendlastname = parsedData[i].fromLastName;
              friendprofilepic = parsedData[i].fromProfilePic;
              friendId =parsedData[i].userId1;
              myuserId = parsedData[i].userId2;

            }

             
            status = parsedData[i].status;
            if(status == 0 & parsedData[i].userId1 == friendId){
              listrequests = listrequests + "<li>"
              listrequests = listrequests +"<div class='content'>" + "<a href='publicprofile.php?userId=" + friendId + "'>" + "<a class='thumbnail' href='publicprofile.php?userId=" + friendId + "'>" + "<img src='" + friendprofilepic + "''>" + "</a>" +"<h4 id='publicprofile' name ='"  + friendId + "''>" + friend + " " + friendlastname +  "</h4>" + '</a>';
              listrequests = listrequests + '<input type="submit" class="button" value="Accept" id = "addFriend" name= "userId1= ' + friendId + "&userId2=" + friendId + '"/>' + " " + '<input type="submit" class="button" value="Reject" id = "unFriend" name= "userId1= ' + friendId + "&userId2=" + friendId + '"/>';
              listrequests = listrequests + '<a href=' + 'messagethread.php?userId=' + friendId +'> <input type="submit" class="button" value ="Chat"/>  </a>';
              listrequests = listrequests +  "</div></li>" 

            }else if (status ==1){
              listfriends = listfriends + "<li>"
              listfriends = listfriends +"<div class='content'>" + "<a href='publicprofile.php?userId=" + friendId + "'>" + "<a class='thumbnail' href='publicprofile.php?userId=" + friendId + "'>" + "<img src='" + friendprofilepic + "''>" + "</a>" +"<h4 id='publicprofile' name ='"  + friendId + "''>" + friend + " " + friendlastname +  "</h4>" + '</a>' +  "<h3>" + "--Friends Since:" + friendsince + "</h3>";
              listfriends = listfriends + '<input type="submit" class="button" value="Unfriend" id = "unFriend" name = "userId1= ' + friendId + "&userId2=" + friendId + '"/>';
              listfriends = listfriends + '<a href=' + 'messagethread.php?userId=' + friendId +'>  <input type="submit" class="button" value ="Chat"/> </a>';
              listfriends = listfriends +  "</div></li>" 
            } 
          }
        }
        entry = listfriends + listrequests;
        $('#chatconvo').html(entry);
      }
    });


$(document).on('click', '#unFriend', function() 
{

  var userinfo = this.name
  $("#Hint").html('Cancelling friendship..');
  $.ajax({
    type: "POST",
    url: "server/friends/doUnfriend.php",
    cache: false,
    data: userinfo,
    success: function(data){
      $("#Hint").html(data); 
    }

  });
      window.location.reload();
});


$(document).on('click', '#addFriend', function() 
{

  var userinfo = this.name
  $("#Hint").html('Cancelling friendship..');
  $.ajax({
    type: "POST",
    url: "server/friends/doAccept.php",
    cache: false,
    data: userinfo,
    success: function(data){
      $("#Hint").html(data); 
    }
  });
     window.location.reload();
});


});
</script>
</body>
</html>