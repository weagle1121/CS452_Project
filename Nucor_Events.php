<!DOCTYPE html>
<html>
<head>
    <title>Nucor Events</title>
	<!-- demo stylesheet -->
    	<link type="text/css" rel="stylesheet" href="media/layout.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_g.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_green.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_traditional.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_transparent.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_white.css" />    
		
	<!-- Formatting -->
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Nucor Events</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
		<link href="Nucor_Main_Page.css" rel="stylesheet">

	<!-- helper libraries -->
		<script src="calendar_lib/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<!-- daypilot libraries -->
		<script src="calendar_lib/js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
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
		<?php include 'Nucor_Header.php';?>
		
	
</head>
<body>
       
        <div class="main">
<!--             css affects spacing/location of mini calendars -->

<!--
            <div style="float: left; 
					width: 160px; padding-top: 80px;">
-->


                <div id="nav"></div>
            </div>
<!--             css affects spacing/location of large calendar -->
            <div style="margin-left: 12%; padding-top: 10%; padding-right: 2%;">
                
                <div class="space">
                    Theme: <select id="theme">
                        <option value="calendar_default">Default</option>
                        <option value="calendar_white">White</option>                        
                        <option value="calendar_g">Google-Like</option>                        
                        <option value="calendar_green">Green</option>                        
                        <option value="calendar_traditional">Traditional</option>                        
                        <option value="calendar_transparent">Transparent</option>                        
                    </select>
                </div>
                
                <div id="dp"></div>
            </div>

            <script type="text/javascript">
                
                var nav = new DayPilot.Navigator("nav");
                nav.showMonths = 3;
                nav.skipMonths = 3;
                nav.selectMode = "week";
                nav.onTimeRangeSelected = function(args) {
                    dp.startDate = args.day;
                    dp.update();
                    loadEvents();
                };
                nav.init();
                
                var dp = new DayPilot.Calendar("dp");
                dp.viewType = "Week";

                dp.onEventMoved = function (args) {
                    $.post("backend_move.php", 
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
                    $.post("backend_resize.php", 
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

                    $.post("backend_create.php", 
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
			   //			   : https://css-tricks.com/snippets/javascript/showhide-element/
			   
				dp.onEventClick = function(args) {
     
					var date = new Date(args.e.start());
					var start_day = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
					var start_time = convert_hour(date.getHours(),date.getMinutes());
					
					date = new Date(args.e.end());
					var end_day = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
					var end_time = convert_hour(date.getHours(),date.getMinutes());
					
					toggle_visibility('event_pop_up',args.e.text(),start_day,end_day,start_time,end_time);
                }; 

                
				dp.init();

                loadEvents();

                function loadEvents() {
                    var start = dp.visibleStart();
                    var end = dp.visibleEnd();

                    $.post("backend_events.php", 
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
			// Creates Pop-up window to view event details
			// Changes the visibility of the div html element by changing the CSS
			// Displays Event Information
			//			Start Time
			//			End Time
				
				function toggle_visibility(id,event_name,start,end,start_time,end_time) {
			     
				 // Get Id of the div you want to show/hide
				 var e = document.getElementById(id);
				 
				 // Get Id of inner div header to display event information
				 var new_header = document.getElementById("popup_header");
					new_header.innerHTML = event_name;
			       
				 // Changes date_div to display start/end: day/time
				 var date_content = "";
					maincontent = "<p> Event Start: " + start + " @ " + start_time + "</p> Event End: " + end + " @ " + end_time;
					document.getElementById("date_div").innerHTML = maincontent;
				 
				 // Show/Hide pop-up  
				 if(e.style.display == 'block')
			       e.style.display = 'none';
			     else
			       e.style.display = 'block';
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
					var converted_time = hour + ":" + min + " " + period;
					return converted_time;
			 }
				
            </script>
            
            <script type="text/javascript">
            $(document).ready(function() {
                $("#theme").change(function(e) {
                    dp.theme = this.value;
                    dp.update();
                });
            });  
            </script>

<!--         </div> -->
        <div class="clear">
        </div>
        
		<div id="event_pop_up">
			<div class="popupBoxWrapper">
				<div class="popupBoxContent" id="event_content">
					<h1 id="popup_header"></h1>
						<div id="date_div"></div>
					<p><a href="javascript:void(0)" onclick="toggle_visibility('event_pop_up');">Close Event</p>
				</div>
			</div>
		</div>
		
		</body>

</html>

