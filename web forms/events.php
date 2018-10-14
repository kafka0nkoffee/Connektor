<?php include "server/authorize/auth.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connektor - Events</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" href="css/start.css"/>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">


 
   <script type="text/javascript">

   function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
    });
    return vars;
    }

    loadEvents();

   

    function loadEvents() {
    $.ajax({
            type: "POST",
            url: "server/events/getUserEvents.php",
            data: '',
            cache: false,
            dataType: 'json',
            success: function(data){
            var entry = '';
            for (var i = 0; i < data.length; i++) {
                 entry += '<tr>'
                 var title = data[i].eventTitle;
                 var startTime = data[i].startTime;
                 var endTime = data[i].endTime;
                 var location = data[i].eventLocation;
                 var link = data[i].eventUrl;
                 var id = data[i].eventId;
                 var type = data[i].eventType;
                 if(type=='1') {
                 	type = 'Public';
                 } else if(type=='2') {
                 	type = 'Private';
                 }

                 entry += '<td>'+title+'</td>';
                 entry += '<td><button type="button" class="btn btn-default" data-toggle="modal" data-eventid="'+id+'" data-target="#addEventModal"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></td>';
                 entry += '<td><button type="button" id="deleteEvent_'+id+'" value="'+id+'" class="btn btn-default" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>';
                 entry += '</tr>';
                 
            }
            $('#eventList').html(entry);

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

<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading">
  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addEventModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</button>
  </div>
  	<div id="status"></div>
  <!-- Table -->
  <div class="table-responsive">
  <table class="table table-hover">
  <thead class="thead-default">
    <tr>	
      <th>Name</th>
      
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody id="eventList">
    <tr>
    
      <td>My Event</td>
      <td><button type="button" class="btn btn-default" data-toggle="modal" data-eventid="3" data-target="#addEventModal"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></td>
      <td><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>
    </tr>
  </tbody>
</table>
</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog"  id="addEventModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Event details</h4>
      </div>
      <div class="modal-body">
        
      		<form id="addEventForm">
			  <div class="form-group">
			    
			    <label for="eventTitle">Event name</label>
			    <input type="text" class="form-control" id="eventTitle" >

			  </div>
			  
			  <div class="form-group">
			    
			    <label for="startTime">Starts At</label>
			     <div class="input-group date form_datetime col-md-5" data-date-format="dd MM yyyy - HH:ii p" data-link-field="startsAt">
                    <input class="form-control" size="16" type="text" value="" id="startTime" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
				<input type="hidden" id="startsAt" value="" />

				<label for="endTime">Ends At</label>
			     <div class="input-group date form_datetime col-md-5" data-date-format="dd MM yyyy - HH:ii p" data-link-field="endsAt">
                    <input class="form-control" size="16" type="text" value="" id="endTime" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
				<input type="hidden" id="endsAt" value="" />

				</div>
				<div class="form-group">
				<label for="eventLocation">Location</label>
			    <input type="text" class="form-control" id="eventLocation">
			    </div>
			    <div class="form-group">
			    <label for="eventUrl">Url</label>
			    <input type="text" class="form-control" id="eventUrl" placeholder="http://">
			    </div>
				<div class="form-group">
				  <label for="eventType">Type:</label>
				  <select class="form-control" id="eventType">
				    <option selected value="1">Public</option>
				    <option value="2">Private</option>
				  </select>
				</div>		
				<input type="hidden" id="eventId">	  
			</form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="addEventButton" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
      </div>
        
      </div>
    </div>

    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>

    <script type="text/javascript">




    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });

     $("tbody").on('click', '[id^=deleteEvent]' , function () {

    	
	    
	    if (!confirm("Are you sure you want to delete this event?")){
	      return false;
	    }
		var eventId = $(this).val(); 
	    var dataString = 'eventId=' + eventId;
	    $.ajax({
	    	type: "POST",
	            url: "server/events/deleteUserEvent.php",
	            data: dataString,
	            cache: false,
	            success: function(data){
		          if(data) {
		          	
		          	$('#addEventModal').modal('hide');
		          	var statusHtml = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>'+data+'</div>'
		          	$("#status").html(statusHtml);
		          }
            	}
	    });

	    loadEvents();
	    


	  });

    $('#addEventButton').click(function()
			{

			var eventTitle=$("#eventTitle").val();
			var eventLocation=$("#eventLocation").val();
			var startTime=$("#startTime").val();
			var endTime=$("#endTime").val();
			var eventUrl=$("#eventUrl").val();
			var eventType=$("#eventType").val();
			var eventId = $("#eventId").val();

		    var dataString = 'eventTitle='+eventTitle+'&eventLocation='+eventLocation+'&startTime='+startTime+'&endTime='+endTime+'&eventUrl='+eventUrl+'&eventType='+eventType;
			if(eventId!=null) {
				dataString += '&eventId='+eventId;
			}
 
			$.ajax({
	            type: "POST",
	            url: "server/events/doAddEvent.php",
	            data: dataString,
	            cache: false,
	            success: function(data){
		          if(data) {
		          	
		          	$('#addEventModal').modal('hide');
		          	var statusHtml = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>'+data+'</div>'
		          	$("#status").html(statusHtml);
                loadEvents();
		          }
            	}
	            });
				
				loadEvents();
				return false;
			});

    	$('#addEventModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget); // Button that triggered the modal
		  var eventId = button.data('eventid'); // Extract info from data-* attributes
		  if(eventId) {
		  

	       	var dataString = 'eventId=' + eventId;
	  	    $.ajax({

	  	            type: "POST",
	  	            url: "server/events/getEventDetails.php",
	  	            data: dataString,
	  	            cache: false,
	  	            dataType: 'json',
	  	            success: function(data){
	  	            
	  	                 var title = data[0].title;
	  	                 var startTime = data[0].startTime;
	  	                 var endTime = data[0].endTime;
	  	                 var location = data[0].location;
	  	                 var link = data[0].link;
	  	                 var type = data[0].type;
	  	            
	  	            	$("#eventTitle").val(title);
						$("#eventLocation").val(location);
						$("#startTime").val(startTime);
						$("#endTime").val(endTime);
						$("#eventUrl").val(link);
						$("#eventType").val(type);
						$("#eventId").val(eventId);
	  	            }
	  	    });
  	
		  } 
		});

		$('#addEventModal').on('hidden.bs.modal', function(){
		    $(this).find('form')[0].reset();
		    $("#eventId").val(null);
		});


      
    </script>
    
  </body>
</html>

