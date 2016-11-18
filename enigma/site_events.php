<?php
session_start();
//Need to include code to set expiration time, currently a session is set up at infinite length, this is not good.
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: index.php");
}

$query = $db->query("SELECT * FROM admins WHERE user_id=".$_SESSION['userSession']);
$userRow = $query->fetch();

//Redirect the user if they have a valid session but they do not have site admin rights.
if ($userRow["site_admin"]==FALSE) {
 header("Location: teams.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enigma Admin</title>
<link href="../bootstrap/bootstrap-3.0.0/dist/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../bootstrap/bootstrap-3.0.0/dist/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
    	<link type="text/css" rel="stylesheet" href="../backend/media/layout.css" />    
        <link type="text/css" rel="stylesheet" href="../backend/themes/calendar_g.css" />    
        <link type="text/css" rel="stylesheet" href="../backend/themes/calendar_green.css" />    
        <link type="text/css" rel="stylesheet" href="../backend/themes/calendar_traditional.css" />    
        <link type="text/css" rel="stylesheet" href="../backend/themes/calendar_transparent.css" />    
        <link type="text/css" rel="stylesheet" href="../backend/themes/calendar_white.css" />    

		<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
		<!--May need elements from the stylesheet below
		<link href="Nucor_Main_Page.css" rel="stylesheet">-->
<style>
  /* Controls Pop-up box for the Calendar */
 #event_pop_up{
		top: 0; 
		left: 0; 
		position: fixed; 
		width: 100%; 
		height: 120%;
		background-color: rgba(0,0,0,0.7); 
		display: none;
		}
	.popupBoxWrapper{
		width: 350px; 
		height: 80%;
		overflow: auto;
		margin: 150px auto; 
		text-align: center;
		}
	.popupBoxContent{
		background-color: #FFF; 
		padding: 15px;
		}
</style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div id="navbar" class="navbar-collapse collapse">
    <ul class = "nav nav-pills navbar-left">
      <li class="active"><a href="site_users.php">SITE</a></li>
      <li><a href="teams.php">TEAMS</a></li>
      <li><a href="profile.php">MY PROFILE</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username'];?></a></li>
      <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
    </ul>
  </div>
  <div class="navbar-collapse collapse">
      <ul class="nav nav-pills">
	    <li><a href="site_users.php">Users</a></li>
		<li><a href="site_divisions.php">Divisions</a></li>
		<li><a href="site_teams.php">Teams</a></li>
		<li><a href="site_teamrosters.php">Team Rosters</a></li>
		<li><a href="site_anouncements.php">Anouncements</a></li>
		<li class="active"><a href="site_events.php">Events</a></li>
		<li><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>
</nav>
<div class="container" style="margin-top:150px;">
<div>
  <div id="nav" style="float:left; width: 150px;">
    <!--mini nav calendar lives here-->
  </div>
  <div id="dp" style="margin-left: 150px; margin-top: 60px;">
  <!--Calendar body (week display) lives here-->
  </div>
</div>
  <div id="event_pop_up">
    <div class="popupBoxWrapper">
      <div class="popupBoxContent" id="event_content">
        <h1 id="popup_header"></h1>
        <div id="date_div"></div>
          <p>
		    <button type="button" href="javascript:void(0)" onclick="toggle_visibility('event_pop_up');">Close Event
          </p>
        </div>
      </div>
    </div>
</div>
</body>
	<!-- helper libraries -->
		<script src="../backend/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<!-- daypilot libraries -->
		<script src="../backend/js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
            <script type="text/javascript">
			   var nav = new DayPilot.Navigator("nav");
                nav.showMonths = 3;
                nav.skipMonths = 1;
                nav.selectMode = "week";
                nav.onTimeRangeSelected = function(args) {
					dp.startDate = args.day;
                    dp.update();
                    loadEvents();
                };
                nav.init();
                				
                var dp = new DayPilot.Calendar("dp");
                dp.viewType = "Week";
				dp.init();
				loadEvents();
				
                dp.onEventMoved = function (args) {
                    $.post("../backend/backend_move.php", 
                            {
                                id: args.e.id(),
                                newStart: args.newStart.toString(),
                                newEnd: args.newEnd.toString()
                            }, 
                            function() {
                                console.log("Moved.");
                            });
                };
				
				dp.onEventResized = function (args) {
                    $.post("../backend/backend_resize.php", 
                            {
                                id: args.e.id(),
                                newStart: args.newStart.toString(),
                                newEnd: args.newEnd.toString()
                            }, 
                            function() {
                                console.log("Resized.");
                            });
                };

                // event creating
                dp.onTimeRangeSelected = function (args) {
                    var name = prompt("New event name:", "Event");
                    dp.clearSelection();
                    if (!name) return;
                    var e = new DayPilot.Event({
                        start: args.start,
                        end: args.end,
                        id: DayPilot.guid(),
                        resource: args.resource,
                        text: name
                    });
                    dp.events.add(e);

                    $.post("../backend/backend_create.php", 
                            {
                                start: args.start.toString(),
                                end: args.end.toString(),
                                name: name
                            }, 
                            function() {
                                console.log("Created.");
                            });

                };

               // Clicking on an event
			   // Creates pop up window that will display the Event name,Start time,End time
			   // Calls function toggle_visibility
			   // Toggles the CSS of event_pop_up on or off
			   // Sources used : http://www.w3schools.com/js/js_htmldom_html.asp
			   //		   : https://css-tricks.com/snippets/javascript/showhide-element/
			   
				dp.onEventClick = function(args) {
     
					var divID = "event_pop_up";
					var name = args.e.text();
					var id = args.e.id();
					var date = new Date(args.e.start());
					console.log(args.e.start());
					console.log(date);
					date.setHours(date.getHours()+(date.getTimezoneOffset()/60));
					var slocal = date.toString();
					console.log(slocal);
					var Sday = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
					var Stime = convert_hour(date.getHours(),date.getMinutes());
					
					date = new Date(args.e.end());
					date.setHours(date.getHours()+(date.getTimezoneOffset()/60));
					var Eday = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
					var Etime = convert_hour(date.getHours(),date.getMinutes());
					
					$.post("../backend/backend_details.php", 
                    {
                        id:id
                    }, 
                    function(data) {
						toggle_visibility(divID,id,data,name,Sday,Eday,Stime,Etime);
                    });

                }; 

			// Creates Pop-up window to view event 
			// Changes the visibility of the div html element by changing the CSS
			// Displays Name
			//			Details
			//			Start Time
			//			End Time
				
				function toggle_visibility(eID,id,details,event_name,start,end,start_time,end_time) {

				// Get Id of the div you want to show/hide
				 var e = document.getElementById(eID);
				 
				 // Get Id of inner div header to display event information
				 var new_header = document.getElementById("popup_header");
					new_header.innerHTML = event_name;
			       
				 // Changes date_div to display start/end: day/time
					maincontent = "<p>" + details + "</p><p> Event Start: " + start + " @ " + start_time + 
								  "<br> Event End: " + end + " @ " + end_time + "</p>";
					document.getElementById("date_div").innerHTML = maincontent;
				 
				 // Show/Hide pop-up  
				 if(e.style.display == 'block')
			       e.style.display = 'none';
			     else
			       e.style.display = 'block';
			    }

                function loadEvents() {
                    var start = dp.visibleStart();
                    var end = dp.visibleEnd();

                    $.post("../backend/backend_events.php", 
                    {
                        start: start.toString(),
                        end: end.toString()
                    }, 
                    function(data) {
                        //console.log(data);
                        dp.events.list = data;
                        dp.update();
                    });
                }
				
			  // Converts time to readable format
			  // Accepts date from dp.onEventClick()
			  // Written by Andrew Jordan
			 function convert_hour(hour,min)
			 {
					var period= "AM";
					if (hour >= 12) {
						
						if (hour > 12)
							hour = hour - 12;
						else
							hour = 12;
						period = "PM";
					 } //What about single digit hours?
					 if (hour == 0)
						hour = 12;
					
					if (min == 0)
						min = "00";
					
					if (min >= 1 && min <=9)
						min = "0"+min;
					
					var converted_time = hour + ":" + min + " " + period;
					return converted_time;
			 }
            </script>
</html>
<?php
$db = null;
?>