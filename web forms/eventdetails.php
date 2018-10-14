<?php include "server/authorize/auth.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connektor - Event</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" href="css/start.css"/>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


 
   <script type="text/javascript">

   function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
    });
    return vars;
    }

   loadEventDetails(getUrlVars()["id"]);
   loadEventAttendStatus(getUrlVars()["id"]);

   function loadEventAttendStatus(eventId) {

      var dataString = 'eventId=' + eventId + '&action=getAttendStatus';
        $.ajax({

                type: "POST",
                url: "server/events/doAttend.php",
                data: dataString,
                cache: false,
                success: function(data){
                     $("#attendButton").html(data);
                }
        });

   }

       function loadEventDetails(eventId) {

       	var dataString = 'eventId=' + eventId;
  	    $.ajax({

  	            type: "POST",
  	            url: "server/events/getEventDetails.php",
  	            data: dataString,
  	            cache: false,
  	            dataType: 'json',
  	            success: function(data){
  	                 var entry = '';
  	            
  	                 var title = data[0].title;
  	                 var startTime = data[0].startTime;
  	                 var endTime = data[0].endTime;
  	                 var location = data[0].location;
  	                 var link = data[0].link;
  	                 var id = data[0].id;
  	            
  	                 $('#eventTitle').html(title);
                     $('#startsAt').html('Starts at: ' + startTime);
                     $('#endsAt').html('Ends at: ' + endTime);
                     if(!(location==null)) {
                      $('#location').html('Location: ' + location);
                      } else {
                      $('#location').html("Location: Unavailable. Please visit event link.");
                      } 
                     $('#website').html('Website: <a href="' + link + '">' + link + '</a>');

                     if(data.length>1) {
                      for (var i = 1; i < data.length; i++) {
                        entry = entry + ' <li class="list-group-item"><a href="publicprofile.php?userId=' + data[i].userId + '">' + data[i].firstName + ' ' + data[i].lastName + '</a></li>'
                      } 
                     } else {
                        entry = '<li class="list-group-item">Be the first one to attend this event!</li>';
                     }
                     $('#attendees').html(entry);

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

    <div class="container">

      <div class="starter-template">
        <div class="container">
        	<div class="row">
        	<div class="col-md-6">
     		<div class="panel panel-primary ">
     			<div class="panel-heading">
			    	<h3 id="eventTitle" class="panel-title">Event title</h3>
			  	</div>
			 
			  <ul class="list-group">
			    <li id="startsAt" class="list-group-item">Starts at: </li>
			    <li id="endsAt" class="list-group-item">Ends at: </li>
			    <li id="location" class="list-group-item">Located: </li>
			    <li id="website" class="list-group-item">Event website</li>
			  </ul>
     		</div>
     		</div>
     		<div class="col-md-6">
     		<div class="panel panel-info">
     			<div class="panel-heading">
			    	<h3 class="panel-title">Attending...</h3>
			  	</div>
			 
			  <ul id="attendees" class="list-group">
			  </ul>
			  <!-- <div class="panel-footer">Load more</div> -->
     		</div>
     		</div>
     		</div>
     		<button id="attendButton" type="button" class="btn btn-primary">Attend this event</button>


      </div>
        
      </div>

      

    </div>

    <script type="text/javascript">
        $( "#attendButton" ).click(function() {
            var dataString = 'eventId=' + getUrlVars()["id"] + '&action=handleAttend';
             $('#attendButton').val('Sending..');
        $.ajax({

                type: "POST",
                url: "server/events/doAttend.php",
                data: dataString,
                cache: false,
                success: function(data){
                  if(data) {
                    loadEventDetails(getUrlVars()["id"]);
                    $('#attendButton').html(data);
                  } else {
                    $('#attendButton').html('value', 'Error! Please try again.');
                  }
                }
        });

        });
    </script>
    
  </body>
</html>

