<!DOCTYPE html>
<html>
<head>
    <title>Nucor Events</title>
	<!-- demo stylesheet -->
    	<link type="text/css" rel="stylesheet" href="backend/media/layout.css" />    
        <link type="text/css" rel="stylesheet" href="backend/themes/calendar_g.css" />    
        <link type="text/css" rel="stylesheet" href="backend/themes/calendar_green.css" />    
        <link type="text/css" rel="stylesheet" href="backend/themes/calendar_traditional.css" />    
        <link type="text/css" rel="stylesheet" href="backend/themes/calendar_transparent.css" />    
        <link type="text/css" rel="stylesheet" href="backend/themes/calendar_white.css" />    
		
	<!-- Formatting -->
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Nucor Events</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
		<link href="Nucor_Main_Page.css" rel="stylesheet">

	<!-- helper libraries -->
		<script src="backend/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<!-- daypilot libraries -->
		<script src="backend/js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
	<!-- Header for the page -->	
	<style type="text/css">

	/*background image, should work across web browsers except internet explorer*/

		body {
		background-image: URL(Events_BkGr.png);
		background-repeat: no-repeat;
		background-position: center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size:cover;
		
		}
		

		.main{
			float: left; 
			width: 160px; 
			padding-top: 10%;
/* 			padding-left: 80px; */
		}
		
/*

		.space{
			margin-left: 160px; 
			padding-top: 100px; 
			padding-right: 80px;
		}
*/

		
</style>

</head>
<body>
<?php include 'Nucor_Header.php';?>
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
</body>
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
				dp.eventClickHandling = "Disabled";
				dp.eventMoveHandling = "Disabled";
				dp.eventResizeHandling = "Disabled";
                /*dp.onEventMoved = function (args) {
                    $.post("backend/backend_move.php", 
                            {
                                id: args.e.id(),
                                newStart: args.newStart.toString(),
                                newEnd: args.newEnd.toString()
                            }, 
                            function() {
                                console.log("Moved.");
                            });
                };*/
				dp.init();
                loadEvents();

/*				    dp.bubble = new DayPilot.Bubble({
        cssOnly: true,
        cssClassPrefix: "bubble_default",
        onLoad: function(args) {
            var ev = args.source;
            args.async = true;  // notify manually using .loaded()
            
            // simulating slow server-side load
            setTimeout(function() {
                args.html = "testing bubble for: <br>" + ev.text();
                args.loaded();
            }, 500);
        }
    });*/
				
				
                /*
				dp.onEventResized = function (args) {
                    $.post("backend/backend_resize.php", 
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

                    $.post("backend/backend_create.php", 
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
			   */
				dp.onEventClick = function(args) {
     
					var divID = "event_pop_up";
					var name = args.e.text();
					var id = args.e.id();
					var date = new Date(args.e.start());
					var Sday = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
					var Stime = convert_hour(date.getHours(),date.getMinutes());
					
					date = new Date(args.e.end());
					var Eday = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
					var Etime = convert_hour(date.getHours(),date.getMinutes());
					
					$.post("backend/backend_details.php", 
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

                    $.post("backend/backend_events.php", 
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
					 }
					 if (hour == 0)
						hour = 12;
					
					if (min == 0)
						min = "00";
					
					if (min >= 1 && min <=9)
						min = "0"+min;
					
					var converted_time = hour + ":" + min + " " + period;
					return converted_time;
			 }
			/*
			 $(document).ready(function() {
                $("#theme").change(function(e) {
                    dp.theme = this.value;
                    dp.update();
                });
            });*/ //This will not be in the final version
            </script>
</html>