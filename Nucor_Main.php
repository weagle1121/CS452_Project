<!DOCTYPE html>
<!--Shannon LaMar   
  9/2/1016
  Andrew Jordan
  10/24/2016
  Nucor RFL Main-->
  <!--test-->
<html>
<head lang="en">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nucor Relay for Life</title>
   <!-- Bootstrap core CSS -->
    <link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this page -->
    <link href="Nucor_Main_Page.css" rel="stylesheet">
	
	<style type="text/css">

	/*background image, should work across web browsers except internet explorer*/

	body {
	background-image: URL(Leaderboard_BkGr.png);
	background-repeat: no-repeat;
	background-position: center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size:cover;
	}
	/* 	changes color/font of headline */
	h2{
		text-align: center;
		font-size: 40px;
		color:#02501e;
		font-weight: bold;
	}
	h3{
		text-align: center;
		font-size: 30px;
		color:#02501e;
		font-weight: bold;
	}
	#sub_A1{
		color:#ffffff;	
	}
	#sub_event_div{
		color:#ffffff;
	}

	/* 	creates blurred affect */

	.container {
		background: url(Leaderboard_Blurred.png) no-repeat fixed;
		width: 75%; 
		margin: 40px auto;
		margin-top: 15%;
	    min-height: 400px;
		-moz-border-radius: 30px; -webkit-border-radius: 30px;
	}
	</style>
	
	<?php include 'Nucor_Header.php';?>
</head>

<body>
<!-- This div receives html once the javascript has run and data is returned from backend_main.php -->
	<div class = "container" id = "announcements"></div>	

<!-- 	Bootstrap core JavaScript -->
    <script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
    <script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>  

	<script>
		// gets current day and time
		var curr = new Date();
		
		// gets the first day of the curent week 
		var f = new Date(curr.setDate(curr.getDate() - curr.getDay()));
		// stores the first day of the week as a string in the form y-m-d, chops off time
		var firstday = f.getFullYear() + '-' + (f.getMonth() + 1) + '-' + f.getDate();
		
		// gets the last day of the week
		var l = new Date(curr.setDate(curr.getDate() - curr.getDay()+6));
		// stores the last day of the week as a string in the forom y-m-d, chops off time
		var lastday = l.getFullYear() + '-' + (l.getMonth() + 1) + '-' + l.getDate();
		
		// gets the current days date and time
		var d = new Date();		
		// stores the current day in the form y-m-d, chops off time
		var curr = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
		
		/* The date must be in the form year-month-day to use 
		   mysql DATE() function during query as DATE() takes the 
		   datetime format stored in the mysql table and chops off the 
		   time to return only y-m-d
		   javascript function sends backend_main.php the start,end, and current
		   dates and html is returned to the div with the id = "announcements".
		   The variables start,end,and curr can be accessed in the php
		   with the name $_POST['start'],$_POST['end'],$_POST['curr']
		   
		*/
		$(document).ready(function(){
			$.post("calendar_lib/backend_main.php", 
                    {
					// variable_name:data
						start:firstday,
						end:lastday,
						curr:curr
                    }, 
                    function(data) {
						// returned data from php file goes into the specified div
						document.getElementById("announcements").innerHTML = data;
                    });
		});
	</script>	
	
</body>
</html>
