<?php include "server/authorize/auth.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connektor - Schedule</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" href="css/timeline.css"/>
   <link rel="stylesheet" href="css/start.css"/>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
      $( "#datepicker" ).datepicker({
        
        showOn: "button",
        altFormat: "yy-mm-dd",
        altField: "#alt-date",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        onSelect: function(date) {
          $('#schedule').html("Loading...");
           loadSchedule($('#alt-date').val());
        },
      });
    } );
  </script>
 
   <script type="text/javascript">
    
    var today = getCurrentDate();
    loadSchedule(today);
    $('datepicker').val(today);

    function getCurrentDate() {
      var d = new Date();

      var month = d.getMonth()+1;
      var day = d.getDate();

      var output = d.getFullYear() + '-' +
          (month<10 ? '0' : '') + month + '-' +
          (day<10 ? '0' : '') + day;

      return output;
    }

    function loadSchedule(date) {
    var dataString = 'date=' + date;
    $.ajax({
            type: "POST",
            url: "server/schedule/getSchedule.php",
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function(data){
                 var entry = '';
            for (var i = 0; i < data.length; i++) {
                entry = entry + '<li>' +
                    '<div class="timeline-description"><p>';
                 var title = data[i].title;
                 var startTime = data[i].startTime;
                 var endTime = data[i].endTime;
                 var location = data[i].location;
                 var link = data[i].link;
                 var id = data[i].id;

                 if(!(link==null)) {
                   entry = entry + ' <a href="eventdetails.php?id=' + id + '">' + title + '</a> | ' + startTime + ' - ' + endTime ;
                   if(!(location==null)) {
                      entry = entry + ' | ' + location;
                   }
                 } else {
                  entry = entry + ' ' + title + ' | ' + startTime + ' - ' + endTime ;
                   if(!(location==null)) {
                      entry = entry + ' | ' + location;
                   }
                 }
                 entry = entry + '</p></div>' +
                '</li>';
            }
            
            $('#schedule').html(entry);

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
            <h2>Class and Event schedule</h2>
            <p>Date: <input class="date" type="text" id="datepicker" ><input type="hidden" id="alt-date" ></p>
            <ul class="timeline" id="schedule">
                <li><div class="timeline-description" id="loading"><p>Loading...</p></div></li>
              </ul>
          </div>
      </div>
        
      </div>

      

    </div>
    
  </body>
</html>
