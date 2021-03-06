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
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $start = strip_tags($_POST['start']);
 $end = strip_tags($_POST['end']);
 $details = strip_tags($_POST['details']);

 $query = "UPDATE announcements SET name = '$name',
								start = '$start',
								end = '$end',
								details = '$details'
			WHERE announcements.id=".$id;
 if ($db->query($query)) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Announcement updated Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error updating announcement!
     </div>";
  }
}
if (isset($_POST['btn-add'])) {
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $start = strip_tags($_POST['start']);
 $end = strip_tags($_POST['end']);
 $details = strip_tags($_POST['details']);
 
 $tinsert = $db->prepare('INSERT INTO announcements (id, name, start, end, details) VALUES (NULL, :name, :start, :end, :details)');
 $tinsert->execute(array(':name' => $name, ':start' => $start, ':end' => $end, ':details' => $details));
 $affected_rows = $tinsert->rowCount();
 if ($affected_rows) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Announcement created Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while creating Announcement!
     </div>";
  }
}
if (isset($_POST['btn-delete'])) {
 $id = strip_tags($_POST['id']);
 $query = $db->prepare('DELETE FROM announcements WHERE ID = :id');
 $query->bindValue(':id', $id, PDO::PARAM_INT);
 $query->execute();
 if ($query->rowCount()) {
		   $deletemsgpass = '<div class="alert alert-success">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Announcement removed Successfully!
     </div>';
  } else {
   $deletemsg = '<div class="alert alert-danger">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error removing announcement!
     </div>';
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
		<li><a href="site_teamrosters.php">Team Rosters</a></li>
		<li class="active"><a href="site_announcements.php">Announcements</a></li>
		<li><a href="site_events.php">Events</a></li>
		<li><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>
</nav>
<div class="container" style="margin-top:150px;">
<?php if (isset($deletemsgpass)) {echo $deletemsgpass;} ?>
<form class="form-inline" method="post" autocomplete="off">
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Announcement Name>" name="name">
</div>
<div class="form-group">
    <input type="date" class="form-control" name="start">
</div>
<div class="form-group">
    <input type="date" class="form-control" name="end">
</div>
<div class="form-group">
  <select class="form-control" name="team_or_site">
    <option selected value="0">Site</option>
<?php
$stmt = $db->prepare('SELECT TID, TNAME FROM teams');
$stmt->execute();
$teamlist = $stmt->fetchall(PDO::FETCH_ASSOC);

		foreach($teamlist as $team)
		{
			echo '    <option value="'.$team['TID'].'">'.$team['TNAME'].'</option>
';
		}
?>
  </select>
</div>

<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add">
<span class="glyphicon glyphicon-plus"></span> &nbsp; Create Announcement</button>
</div> 
<div class="form-group">
    <textarea class="form-control" placeholder="<Announcement Text>" name="details" maxlength="600" rows="3" cols="132"></textarea>
</div>
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">
<?php
$stmt = $db->prepare('SELECT * FROM announcements');
$stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);

		 foreach($result as $aRow)
			{
				if ($_POST && $aRow['id'] == $id && isset($msg)) {
					echo $msg;
				}
				echo '
<form class="form-inline" method="post">
<div class="form-group">
    <input type="text" class="form-control" value="'.$aRow['name'].'" name="name">
</div>
<div class="form-group">
    <input type="date" class="form-control" value="'.$aRow['start'].'" name="start">
</div>
<div class="form-group">
    <input type="date" class="form-control" value="'.$aRow['end'].'" name="end">
</div>
<div class="form-group">
  <select class="form-control" name="team_or_site">
    <option value="0">Site</option>
';
		foreach($teamlist as $team)
		{
			echo '    <option ';
			if ($aRow['TID'] == $team['TID']) {
				echo 'selected ';
			}
			echo 'value="'.$team['TID'].'">'.$team['TNAME'].'</option>
';
		}
echo '  </select>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update">
<span class="glyphicon glyphicon-save"></span> &nbsp; Save Update</button>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-delete">
<span class="glyphicon glyphicon-trash"></span>&nbsp;Delete</button>
</div>
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$aRow['id'].'" name="id">
</div>
<div class="form-group">
    <textarea class="form-control" name="details" maxlength="600" rows="3" cols="132">'.$aRow['details'].'</textarea>
</div>
</form>
';
if (isset($deletemsg) && $id == $aRow['id']) {
   echo $deletemsg;
  }
echo '<hr style="margin-top: 10px; margin-bottom: 10px;">';
			}
//STILL NEED TO CODE "DELETE Announcement" Also need to consider a mechanism that shows anouncments that have expired in a different section/color?
?>


</div>

</body>
</html>
<?php
$db = null;
?>