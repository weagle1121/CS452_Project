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
<!--     <link href="Bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet"> -->
    <link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this site -->
    <link href="main_page.css" rel="stylesheet">
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
	    border-radius: 30px;
		-moz-border-radius: 30px; 
		-webkit-border-radius: 30px;
	}
	
	</style>
<?php
include 'header.php';
include 'backend/_db.php';
?>
</head>

<body>
	
	
<div class="container">
  <h2>LEADER BOARD</h2>
  <table class="table table-striped table-responsive" id ="t1" >
  <thead>
    <tr>
	  <th>Rank</th>
	  <th>Team Name</th>
	  <th>Money Raised</th>
	</tr>
  </thead>
<?php
	$stmt = $db->prepare('SELECT * FROM `TEAMS` WHERE NOT STATUS = 0 ORDER BY TRAISED DESC');
	$stmt->execute();
	$result = $stmt->fetchAll();
 if ($stmt->rowCount())
 {  
      echo '<tbody>';
	  $rankposition=1;
		 foreach($result as $row)  
			{  
				echo ' 
				<tr>  
                     <td>'.$rankposition.'</td>  
                     <td>'.$row["TNAME"].'</td>  
                     <td>$ ';
					 echo number_format($row["TRAISED"], 2, '.', ',');
					 echo '</td>  
                </tr>  
				';
				$rankposition++;
			}
 }
 else
 {
	 echo '<tr><td colspan="3">No team data!</td></tr>';
 }
?>
 </tbody>
  </table>
</div>	
<!-- 	Bootstrap core JavaScript -->
	<script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
</body>
</html>
