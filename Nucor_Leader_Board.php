<!DOCTYPE html>
<!--Shannon LaMar   
  9/2/1016
  Nucor RFL LEADER BOARD-->
<html>
<head lang="en">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nucor Relay for Life</title>
    <!-- Bootstrap core CSS -->
<!--     <link href="Bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet"> -->
    <link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this site -->
    <link href=" nucor_main_page.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <style type="text/css">

	/*background image, should work across web browsers except internet explorer*/

	body {
	background-image: URL(pictures/leaderboard_bkgr.png);
/* 	background-repeat: no-repeat; */
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
		-moz-border-radius: 30px; -webkit-border-radius: 30px;
	}
	
	</style>
<?php include 'Nucor_Header.php';?>
</head>

<body>
	
	
<div class="container">
  <h2>LEADER BOARD</h2>
  <table class="table table-striped" id ="t1" >
  </table>
</div>	
	
<!-- 	Bootstrap core JavaScript -->


	<script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>

<!--     <script src="Bootstrap/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>    -->

	<script>
		var id = 2;
		$(document).ready(function(){
			$.post("backend/backend_boards.php", 
                    {
                        id:id
                    }, 
                    function(data) {
						document.getElementById("t1").innerHTML = data;
                    });
		});
	</script> 
</body>
</html>
