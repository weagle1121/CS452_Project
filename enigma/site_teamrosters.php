<?php
function displayCreateMemberForm($teamRow_TID) {
echo '
<form class="form-inline" method="post" autocomplete="off">
<!--Need to hide ID fields-->
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$teamRow_TID.'" name="tid">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Name>" name="name">
</div>
<div class="form-group">
    <input type="email" class="form-control" placeholder="<E-Mail>" name="email">
</div>
<div class="form-group">
    <input type="tel" class="form-control" placeholder="<Phone>" name="phone">
</div>
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" name="active" checked>
	</label>
</div>
<div class="checkbox">
    <label class="checkbox-inline">Captain?
	<input type="checkbox" name="captain">
	</label>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add">
<span class="glyphicon glyphicon-plus"></span> &nbsp; Create Member</button>
</div> 
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">';
}
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
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $email = strip_tags($_POST['email']);
 $phone = strip_tags($_POST['phone']);
 $active = strip_tags($_POST['active']);
 $captain = strip_tags($_POST['captain']);

 if (isset($_POST['active']) && $_POST['active']=="on")
 { $active=TRUE; }
 else
 { $active=FALSE; }

 if (isset($_POST['captain']) && $_POST['captain']=="on")
 { $captain=TRUE; }
 else
 { $captain=FALSE; }

  $query = $db->prepare("UPDATE members SET name = :name, email = :email, phone = :phone, active = :active, captain = :captain WHERE members.id = :id");
  $query->bindValue(':name', $name, PDO::PARAM_STR);
  $query->bindValue(':email', $email, PDO::PARAM_STR);
  $query->bindValue(':phone', $phone, PDO::PARAM_STR);
  $query->bindValue(':active', $active, PDO::PARAM_STR);
  $query->bindValue(':captain', $captain, PDO::PARAM_STR);
  $query->bindValue(':id', $id, PDO::PARAM_STR);
  $query->execute();

 if ($query->rowCount()) {
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
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $email = strip_tags($_POST['email']);
 $phone = strip_tags($_POST['phone']);
 $active = strip_tags($_POST['active']);
 $captain = strip_tags($_POST['captain']);
 $tid = strip_tags($_POST['tid']);

 if (isset($_POST['active']) && $_POST['active']=="on")
 { $active=TRUE; }
 else
 { $active=FALSE; }

 if (isset($_POST['captain']) && $_POST['captain']=="on")
 { $captain=TRUE; }
 else
 { $captain=FALSE; }
 $query = "INSERT INTO members (id, name, email, phone, active, captain, memberof)
					VALUES	  (NULL, '$name', '$email', '$phone', '$active', '$captain', '$tid')";
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
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['email'];?></a></li>
      <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
    </ul>
  </div>
  <div class="navbar-collapse collapse">
      <ul class="nav nav-pills">
	    <li><a href="site_users.php">Users</a></li>
		<li><a href="site_adminteamassign.php">Admins/Teams</a></li>
		<li><a href="site_divisions.php">Divisions</a></li>
		<li><a href="site_teams.php">Teams</a></li>
		<li class="active"><a href="site_teamrosters.php">Team Rosters</a></li>
		<li><a href="site_anouncements.php">Anouncements</a></li>
		<li><a href="site_events.php">Events</a></li>
		<li><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>
</nav>
<div class="container" style="margin-top:150px;">
<?php
$stmt = $db->prepare('SELECT TID, TNAME FROM teams WHERE 1 ORDER BY TNAME');
$stmt->execute();
$teamList = $stmt->fetchall(PDO::FETCH_ASSOC);
if (isset($msg)) {
   echo $msg;
  }
			//Now we have each active team in array $teamList, each active team will be listed as its own TID in $teamRow
		foreach($teamList as $teamRow)
			{
			$stmt = $db->prepare("SELECT * FROM members WHERE MEMBEROF = :currTeam ORDER BY name");
			$stmt->bindValue(':currTeam',$teamRow['TID'],PDO::PARAM_STR);
			$stmt->execute();
			$memberList = $stmt->fetchall(PDO::FETCH_ASSOC);
			echo '<h3>'.$teamRow['TNAME'].' - '.$stmt->rowCount().' member(s)</h3>';
			displayCreateMemberForm($teamRow['TID']);
			foreach($memberList as $memberRow)
			{
				echo '
<form class="form-inline" method="post">
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$memberRow['ID'].'" name="id">
</div>
<div class="form-group">
    <input type="text" class="form-control" value="'.$memberRow["name"].'" name="name">
</div>
<div class="form-group">
    <input type="email" class="form-control" value="'.$memberRow["email"].'" name="email">
</div>
<div class="form-group">
    <input type="tel" class="form-control" value="'.$memberRow["phone"].'" name="phone">
</div>
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" ';
	if ($memberRow["active"]==TRUE) { echo 'checked '; }
	echo 'name="active">
	</label>
</div>
<div class="checkbox">
    <label class="checkbox-inline">Captain?
	<input type="checkbox" ';
	if ($memberRow["captain"]==TRUE) { echo 'checked '; }
	echo 'name="captain">
	</label>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update">
<span class="glyphicon glyphicon-save"></span> &nbsp; Save Update</button>
</div> 
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">';
			}
			}
//STILL NEED TO CODE "DELETE TEAM"
?>


</div>

</body>
</html>
<?php
$db = null;
?>