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
	
	
<div class="container">
  <h2>LEADERBOARD</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Rank</th>
        <th>Team Name</th>
        <th>Money Raised</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Angry Armadillos</td>
        <td>1111</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Crazy Cats</td>
        <td>222</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Bashful Badgers</td>
        <td>33</td>
      </tr>
    </tbody>
  </table>
</div>	
	
<!-- 	Bootstrap core JavaScript -->
    <script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
    <script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>    
	
</body>
</html>