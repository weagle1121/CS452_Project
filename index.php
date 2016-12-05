<!DOCTYPE html>
<!--
CS452 Capstone Project Fall 2016
Lia Brannon
Shaun Dyer
Andrew Jordan
Shannon LaMar
Adam Moses
-->
<html>
<head lang="en">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nucor Relay for Life</title>
   <!-- Bootstrap core CSS -->
    <link href="bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
   <!-- Custom styles for this site -->
    <link href="main_page.css" rel="stylesheet">
   <!-- Custom styles for this page -->
	<style type="text/css">
	/*background image, should work across web browsers except internet explorer*/
	body {
	background-image: URL(pictures/main_bkgr.png);
	background-position: center center fixed;
	background-attachment: fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size:cover;
	}
	/* 	creates blurred affect */
	.container {
		background: url(pictures/leaderboard_blurred.png) no-repeat fixed;
		width: 75%; 
		margin: 40px auto;
		margin-top: 15%;
	    min-height: 400px;
		border-radius: 30px;
		-moz-border-radius: 30px; 
		-webkit-border-radius: 30px;
	}
	</style>
	
	<?php include 'header.php';?>
</head>

<body>
<!-- This div receives html once the javascript has run and data is returned from backend_main.php -->
	<div class = "container" id = "announcements"></div>	
	<!-- 	Bootstrap core JavaScript -->
    <script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
    <script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>  

	<script>
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
		   with the name $_POST['curr']
		   
		*/
		$(document).ready(function(){
			$.post("backend/backend_main.php", 
                    {
					// variable_name:data
						curr:curr
                    }, 
                    function(data) {
						// returned data from php goes into the specified div
						document.getElementById("announcements").innerHTML = data;
                    });
		});
	</script>
	
</body>
</html>
