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
    <link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this page -->
    <link href="Nucor_Main_Page.css" rel="stylesheet">
        <style type="text/css">

	/*background image, should work across web browsers except internet explorer*/

	body {
	background-image: URL(Leaderboard_BkGr.png);
/* 	background-repeat: no-repeat; */
	background-position: center center fixed;
	background-attachment: fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	}
	/* 	changes color/font of headline */
	h2{
		text-align: center;
		font-size: 40px;
		color:#02501e;
		font-weight: bold;
	}
	/* 	creates blurred affect */
	.container {
		background: url(Leaderboard_Blurred.png) no-repeat fixed;
		width: 75%; 
		margin: 40px auto;
		margin-top: 15%;
	    min-height: 400px;
		-moz-border-radius: 30px; 
		-webkit-border-radius: 30px;
		-o-border-radius: 30px;
	}
	


.table-bordered
{
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;

    border-collapse: inherit;
}
/*
	.table {
		
		-webkit-border-radius: 20px;
		-moz-border-radius: 20px;
		border-top-right-radius: 10em;
		  border-top-left-radius: 10em;
		  border-bottom-right-radius: 5em;
		  border-bottom-left-radius: 2em;
		padding: 10%;
		width: 100%;
		height: 50%;
	}
*/


		
		
	
	
	</style>
<?php include 'Nucor_Header.php';?>
</head>

<body>
	
	
<div class="container">
  <h2>LEADER BOARD</h2>
  <!-- 	  this div creates a horizontal scroll bar if the screen is too small to display the full content -->
<!--   <div class="table-responsive"> -->
  <div style="overflow-x:auto;">
  <table class="table table-striped" id ="t1" >
	      
  </table>
  </div>
<!--   </div> -->
</div>	
	
<!-- 	Bootstrap core JavaScript -->
    <script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
    <script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>   
    <div class = "table"> 
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
    </div>
</body>
</html>
