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
 $did = strip_tags($_POST['did']);
 $dname = strip_tags($_POST['dname']);
 $query = "UPDATE divisions SET dname = '$dname'	WHERE divisions.did=".$did;
 if ($db->query($query)) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; User information updated Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while updating user information!
     </div>";
  }
}
if (isset($_POST['btn-add'])) {
 $did = strip_tags($_POST['did']);
 $dname = strip_tags($_POST['dname']);
 $query = "INSERT INTO divisions (did, dname)
					VALUES	  (NULL, '$dname')";
 if ($db->query($query)) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; User created Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while creating user!
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
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div id="navbar" class="navbar-collapse collapse">
    <ul class = "nav nav-pills navbar-left">
      <li class="active"><a href="site_users.php">SITE</a></li>
      <li><a href="teams.php">TEAMS</a></li>
      <li><a href="profile.php">MY PROFILE</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['email'];?></a></li>
      <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
    </ul>
  </div>
  <div class="navbar-collapse collapse">
      <ul class="nav nav-pills">
	    <li><a href="site_users.php">Users</a></li>
		<li><a href="site_adminteamassign.php">Admins/Teams</a></li>
		<li class="active"><a href="site_divisions.php">Divisions</a></li>
		<li><a href="site_teams.php">Teams</a></li>
		<li><a href="site_teamrosters.php">Team Rosters</a></li>
		<li><a href="site_anouncements.php">Anouncements</a></li>
		<li><a href="site_events.php">Events</a></li>
		<li><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>
</nav>
<div class="container" style="margin-top:150px;">
<form class="form-inline" method="post">
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Division Name>" name="dname">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add">
<span class="glyphicon glyphicon-plus"></span>&nbsp;Add Division</button>
</div> 
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">
<?php
$stmt = $db->prepare('SELECT * FROM divisions');
$stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);

if (isset($msg)) {
   echo $msg;
  }
		 foreach($result as $divisionRow)
			{
				echo '
<form class="form-inline" method="post">
<div class="form-group">
    <input type="text" class="form-control" value="'.$divisionRow["DNAME"].'" name="dname">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update">
<span class="glyphicon glyphicon-save"></span>&nbsp;Save Update</button>
</div> 
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$divisionRow["DID"].'" name="did">
</div>
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">';
			}
//STILL NEED TO CODE "DELETE DIVISION" (Will need to make sure no teams are associated with it)
?>


</div>

</body>
</html>
<?php
$db = null;
?>