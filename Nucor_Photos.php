<!DOCTYPE html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Photo Gallery</title>
	<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
	<link href="drop_menu/drop_menu.css" rel="stylesheet">
	<link href="Nucor_Main_Page.css" rel="stylesheet">
	<script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/js/carousel.js"></script>
<!-- Redundant <script src="bootstrap/js/bootstrap.min.js"></script> -->
<!-- CSS is not a script! <script src="bootstrap/css/bootstrap.min.css"></script> -->
<!-- 	<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
	<style type="text/css">

	/*background image, should work across web browsers except internet explorer*/

	body {
	background-image: URL(Photo_BkGr.png);
/* 	background-repeat: no-repeat; */
	background-position: center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size:cover;
	}
	
	/* 	affects position of more albums button*/
	.dropdown {
		padding-top: 4%;
	}
	
/* 	affects position of slideshow */
	.carousel-inner {
	
		padding-top: 2%;
		padding-left: 15%;
		padding-bottom: 15%;
	}
	</style>
	
	<?php include 'Nucor_Header.php';?>
</head>

<body>
<script>
		var year = 2016;
		$(document).ready(function(){
			$.post("backend/backend_photos.php", 
                    {
					// variable_name:data
						year:year
                    }, 
                    function(data) {
						// returned data from php goes into the specified div
						document.getElementById("slide_show").innerHTML = data;
                    });
		});
</script>

 <div style="margin-left: 12%; padding-top: 10%; padding-right: 2%; color:#ffffff">
                <div class="space">
                    Select Event: <select id="theme">
                        <!-- value will be changed later! -->
						<option value="calendar_default">Fun Run</option>
                        <option value="calendar_white">Super Short 10K</option>                        
                        <option value="calendar_g">Zombie Sprint</option>                        
                        <option value="calendar_green">Green Skin Awareness</option>                        
                    </select>
                </div>
</div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <!-- Data is sent from backend_photos.php here -->
  <div class="carousel-inner" role="listbox" id = "slide_show"></div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

</body>
</html>
