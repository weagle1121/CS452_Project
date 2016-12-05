<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: index.php");
}

$query = $db->query("SELECT * FROM admins WHERE user_id=".$_SESSION['userSession']);
$userRow = $query->fetch();

//Redirect the user if they have a valid session but they do not have site admin rights.
if ($userRow["site_admin"]==FALSE) {
 header("Location: teams.php");
}
if (isset($_POST['btn-update'])) {
 $tid = strip_tags($_POST['tid']);
 $status = strip_tags($_POST['status']);
 $tname = strip_tags($_POST['tname']);
 $tdivision = strip_tags($_POST['tdivision']);
 $tyear = strip_tags($_POST['tyear']);
 $turl = strip_tags($_POST['turl']);
 $traised = strip_tags($_POST['traised']);
 
 if (isset($_POST['status']) && $_POST['status']=="on")
 { $status=TRUE; }
 else
 { $status=FALSE; }
 $query = "UPDATE teams SET 	STATUS = '$status',
								TNAME = '$tname',
								TDIVISION = '$tdivision',
								TYEAR = '$tyear',
								TURL = '$turl',
								TRAISED = '$traised'
			WHERE teams.TID=".$tid;
 if ($db->query($query)) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Team information updated Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while updating team information!
     </div>";
  }
}
if (isset($_POST['btn-add'])) {
 $tid = strip_tags($_POST['tid']);
 $status = strip_tags($_POST['status']);
 $tname = strip_tags($_POST['tname']);
 $tdivision = strip_tags($_POST['tdivision']);
 $tyear = strip_tags($_POST['tyear']);
 $turl = strip_tags($_POST['turl']);
 $traised = strip_tags($_POST['traised']);
 
 if (isset($_POST['status']) && $_POST['status']=="on")
 { $status=TRUE; }
 else
 { $status=FALSE; }
 $query = "INSERT INTO teams (TID, STATUS, TNAME, TDIVISION, TYEAR, TURL, TRAISED)
					VALUES	  (NULL, '$status', '$tname', '$tdivision', '$tyear', '$turl', '$traised')";
 if ($db->query($query)) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Team created Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while creating Team!
     </div>";
  }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enigma Admin</title>
<link href="../bootstrap/bootstrap-3.0.0/dist/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../bootstrap/bootstrap-3.0.0/dist/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div id="navbar" class="navbar-collapse collapse">
    <ul class = "nav nav-pills navbar-left">
      <li class="active"><a href="site_users.php">SITE</a></li>
      <li><a href="teams.php">TEAMS</a></li>
      <li><a href="profile.php">MY PROFILE</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username'];?></a></li>
      <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
    </ul>
  </div>
  <div class="navbar-collapse collapse">
      <ul class="nav nav-pills">
	    <li><a href="site_users.php">Users</a></li>
		<li><a href="site_adminteamassign.php">Admins/Teams</a></li>
		<li><a href="site_divisions.php">Divisions</a></li>
		<li class="active"><a href="site_teams.php">Teams</a></li>
		<li><a href="site_teamrosters.php">Team Rosters</a></li>
		<li><a href="site_anouncements.php">Anouncements</a></li>
		<li><a href="site_events.php">Events</a></li>
		<li><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>
</nav>
<div class="container" style="margin-top:150px;">
<form class="form-inline" method="post" autocomplete="off">
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Team Name>" name="tname">
</div>
<div class="form-group">
  <select class="form-control" name="did">
    <option selected value="0">Select Division</option>
<?php
$stmt = $db->prepare('SELECT DID, DNAME FROM divisions');
$stmt->execute();
$divisionList = $stmt->fetchall(PDO::FETCH_ASSOC);

		foreach($divisionList as $division)
		{
			echo '    <option value="'.$division['DID'].'">'.$division['DNAME'].'</option>
';
		}
?>
  </select>
</div>
<div class="form-group">
    <input type="number" class="form-control" placeholder="<Year>" name="tyear" style="width:7em" min="1940" max="2100">
</div>
<div class="form-group">
    <input type="url" class="form-control" placeholder="<ACS URL>" name="turl">
</div>
<div class="form-group">
    <input type="number" class="form-control" placeholder="<Amount Raised>" name="traised" style="width:7em" min="0"><!-- Consider prepending the dollar sign -->
</div>
<!-- Add team admins!? -->
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" name="status" checked>
	</label>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add">
<span class="glyphicon glyphicon-plus"></span> &nbsp; Create Team</button>
</div> 
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">
<?php
$stmt = $db->prepare('SELECT * FROM teams');
$stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
if (isset($msg)) {
   echo $msg;
  }
		 foreach($result as $teamRow)
			{
				echo '
<form class="form-inline" method="post">
<div class="form-group">
    <input type="text" class="form-control" value="'.$teamRow["TNAME"].'" name="tname">
</div>
<div class="form-group">
  <select class="form-control" name="tdivision">
';
	foreach($divisionList as $division) {
		echo '    <option ';
		if ($teamRow['TDIVISION'] == $division['DID']) {
			echo 'selected ';
		}
		echo 'value="'.$division['DID'].'">'.$division['DNAME'].'</option>
';
	}
echo '  </select>
</div>
<div class="form-group">
    <input type="number" class="form-control" value="'.$teamRow["TYEAR"].'" name="tyear" min="1940" max="2100">
</div>
<div class="form-group">
    <input type="url" class="form-control" value="'.$teamRow["TURL"].'" name="turl">
</div>
<div class="form-group">
    <input type="number" class="form-control" value="'.$teamRow["TRAISED"].'" style="width:7em" name="traised" min="0">
</div>
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" ';
	if ($teamRow["STATUS"]==TRUE) { echo 'checked '; }
	echo 'name="status">
	</label>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update">
<span class="glyphicon glyphicon-save"></span> &nbsp; Save Update</button>
</div> 
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$teamRow['TID'].'" name="tid">
</div>
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">';
			}
//STILL NEED TO CODE "DELETE TEAM"
?>


</div>

</body>
</html>
<?php
$db = null;
?>