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
    <link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
<!--     <link href="Bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet"> -->
    <!-- Custom styles for this site-->
    <link href="nucor_main_page.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <style type="text/css">
	/*background image, should work across web browsers except internet explorer*/
	body {
	background-image: URL(pictures/team_listing_bkgr.png);
	background-repeat: no-repeat;
	background-position: center center fixed;
	background-attachment: fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size:cover;

	}

	/* 	creates blurred affect */
	.container {
		background: url(pictures/team_listing_blurred.png) no-repeat fixed;
		width: 75%; 
		margin: 40px auto;
		margin-top: 15%;
	    min-height: 400px;
	    border-radius: 30px;
		-moz-border-radius: 30px; 
		-webkit-border-radius: 30px;
	}
/* 	changes team name link color */
	a {
    color: #02501e;
	}
		</style>
<!--     header file -->
<?php include 'Nucor_Header.php';?>
</head>
<body>
<div class="container">
  <h2>RELAY TEAMS</h2>
<?php 
require_once 'backend/_db.php';
$stmt = $db->prepare("SELECT teams.TID, teams.TNAME, teams.TYEAR, teams.TURL, teams.TRAISED, divisions.DNAME FROM teams JOIN divisions on teams.TDIVISION=divisions.DID WHERE teams.STATUS=1 ORDER BY teams.TNAME");
	$stmt->execute();
	$result = $stmt->fetchAll();
 if($stmt->rowCount())  
 {  
			echo
'  <table class="table table-hover table-responsive" id ="t1">
    <tbody>';
			foreach($result as $team)  
				{  
					echo
'
    <tr class="warning">
      <td><a href="'.$team["TURL"].'">'.$team["TNAME"].'</a></td>
      <td>'.$team["DNAME"].'</td>
      <td>'.$team["TYEAR"].'</td>
      <td>'.$team["TRAISED"].'</td>
    </tr>';  
	$stmt2 = $db->prepare("SELECT members.name, members.captain FROM members WHERE members.active = 1 AND members.memberof = :teamid ORDER BY members.captain DESC, members.name");
	$stmt2->bindParam(':teamid',$team['TID'],PDO::PARAM_INT);
	$stmt2->execute();
	$members = $stmt2->fetchAll();
	$stmt3 = $db->prepare("SELECT COUNT(*) AS captainCount FROM members WHERE members.memberof = :teamid AND members.captain = '1' LIMIT 1");
	$stmt3->bindParam(':teamid',$team['TID'],PDO::PARAM_INT);
	$stmt3->execute();
	$captainCountResult = $stmt3->fetch();
	$captainCount=$captainCountResult['captainCount'];
				if($captainCount>1)
					{ $cocaptains = TRUE; }
				else
					{ $cocaptains = FALSE; }
				foreach($members as $memberRow)
				{
					if ($captainCount) //Not while, only want this to run once per row
					{
						if ($cocaptains)
						{ echo '
    <tr>
	  <td class="text-right">Co-Captain:</td>
	  <td colspan="3">'.$memberRow["name"].'</td>
	</tr>'; }
						else
						{ echo '
    <tr>
	  <td class="text-right">Captain:</td>
	  <td colspan="3">'.$memberRow["name"].'</td>
	</tr>'; }
					$captainCount--;
					}
					else
					{
						echo '
    <tr>
	  <td></td>
	  <td colspan="3">'.$memberRow["name"].'</td>
	</tr>';
					}
				}
				}
				echo
'    </tbody>
  </table>
';
}  
 else  
 {  
      echo '<h3>Error: Team data not found</h3>';
 }  
$db = null;
//Name, Division, YEAR, raised, URL
 ?>
</div>		
<!-- 	Bootstrap core JavaScript -->
<!--     <script src="Bootstrap/bootstrap-3.3.7-dist/js/jquery.js"></script> -->
<!--     <script src="Bootstrap/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>    -->


    <script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
    <script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>