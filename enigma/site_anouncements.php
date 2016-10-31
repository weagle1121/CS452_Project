<?php
// CRITICAL 
// Need to work on removal of quotes, it is currently not operating as expected.
// CRITICAL
//
//

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

 $query = "UPDATE anouncements SET name = '$name',
								start = '$start',
								end = '$end',
								details = '$details'
			WHERE anouncements.id=".$id;
 if ($db->query($query)) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Anouncement updated Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error updating anouncement!
     </div>";
  }
}
if (isset($_POST['btn-add'])) {
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $start = strip_tags($_POST['start']);
 $end = strip_tags($_POST['end']);
 $details = strip_tags($_POST['details']);
 
 $tinsert = $db->prepare('INSERT INTO anouncements (id, name, start, end, details) VALUES (NULL, :name, :start, :end, :details)');
 $tinsert->execute(array(':name' => $name, ':start' => $start, ':end' => $end, ':details' => $details));
 $affected_rows = $tinsert->rowCount();
 if ($affected_rows) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Anouncement created Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while creating Anouncement!
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
    <ul class = "nav navbar-nav navbar-left">
      <li><a href="site.php">SITE</a></li>
      <li><a href="teams.php">TEAMS</a></li>
      <li><a href="profile.php">MY PROFILE</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username'];?></a></li>
      <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
    </ul>
  </div>
  <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
	    <li><a href="site_users.php">Users</a></li>
		<li><a href="site_divisions.php">Divisions</a></li>
		<li><a href="site_teams.php">Teams</a></li>
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
    <input type="text" class="form-control" value="AUTO" name="id" style="width:5em" readonly>
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Anouncement Name>" name="name">
</div>
<div class="form-group">
    <input type="date" class="form-control" name="start">
</div>
<div class="form-group">
    <input type="date" class="form-control" name="end">
</div>
<div class="form-group">
    <input type="textarea" class="form-control" placeholder="<Anouncement Text>" name="details">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add">
<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Anouncement</button>
</div> 
</form>
<hr>
<?php
$stmt = $db->prepare('SELECT * FROM anouncements');
$stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
if (isset($msg)) {
   echo $msg;
  }
		 foreach($result as $aRow)
			{
				echo '
<form class="form-inline" method="post">
<div class="form-group">
    <input type="number" class="form-control" value="'.$aRow['id'].'" name="id" style="width:5em" readonly>
</div>
<div class="form-group">
    <input type="text" class="form-control" value="'.$aRow["name"].'" name="name">
</div>
<div class="form-group">
    <input type="date" class="form-control" value="'.$aRow["start"].'" name="start">
</div>
<div class="form-group">
    <input type="date" class="form-control" value="'.$aRow["end"].'" name="end">
</div>
<div class="form-group">
    <input type="textarea" class="form-control" value="'.$aRow["details"].'" name="details">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update">
<span class="glyphicon glyphicon-log-in"></span> &nbsp; Save Update</button>
</div> 
</form>
<hr>';
			}
//STILL NEED TO CODE "DELETE Anouncement" Also need to consider a mechanism that shows anouncments that have expired in a different section/color?
?>


</div>

</body>
</html>
<?php
$db = null;
?>