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
 $adminArray = array();
 foreach($_POST as $key=>$value) {
	 if ('admin_' == substr($key,0,6)) {
			$adminArray[] = substr($key,6);
	 }
 }
 $admin_ids = implode(',', $adminArray);
  
  $query = $db->prepare("SELECT admin_ids FROM teams WHERE teams.TID = :tid");
  $query->bindValue(':tid', $tid, PDO::PARAM_STR);
  $query->execute();
  $current_Admins = $query->fetch();
  if ($current_Admins['admin_ids'] == $admin_ids)
	  $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span>No changes made!</div>";
  else {
  $query = $db->prepare("UPDATE teams SET admin_ids = :admin_ids WHERE teams.TID = :tid");
  $query->bindValue(':admin_ids', $admin_ids, PDO::PARAM_STR);
  $query->bindValue(':tid', $tid, PDO::PARAM_STR);
  $query->execute();

 if ($query->rowCount()) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Assignments updated successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while updating assignment!
     </div>";
  }
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
<style>
th.rotate {
  /* Something you can count on */
  height: 160px;
  white-space: nowrap;
  border: none;
}

th.rotate > div {
  transform: 
    /* Magic Numbers*/
    translate(25px, 51px)
    /* 45 is really 360 - 45 */
    rotate(315deg);
	width: 30px;
	position: relative;
	left: -15px;
}
th.rotate > div > span {
  border-bottom: 1px solid #ccc;
  padding: 5px 10px;
}
th.noborder {
	border: none;
}
th {
	border: 1px solid #eee;
}
td {
	text-align: center;
	border: 1px solid #eee;
}
</style>
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
		<li class="active"><a href="site_adminteamassign.php">Admins/Teams</a></li>
		<li><a href="site_divisions.php">Divisions</a></li>
		<li><a href="site_teams.php">Teams</a></li>
		<li><a href="site_teamrosters.php">Team Rosters</a></li>
		<li><a href="site_anouncements.php">Anouncements</a></li>
		<li><a href="site_events.php">Events</a></li>
		<li><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>
</nav>
<div class="container" style="margin-top:100px;">
<?php
$stmt = $db->prepare('SELECT TID, TNAME, admin_ids FROM teams WHERE 1 ORDER BY TNAME');
$stmt->execute();
$teamList = $stmt->fetchall(PDO::FETCH_ASSOC);
$adminMap = array();
foreach ($teamList as $teamRow) {
	$adminMap[$teamRow['TID']] = array_map('intval', explode(',',$teamRow['admin_ids']));
}
$stmt = $db->prepare("SELECT user_id, name FROM admins WHERE 1 ORDER BY name");
$stmt->execute();
$adminList = $stmt->fetchall(PDO::FETCH_ASSOC);

if (isset($msg)) {
   echo $msg;
  }
echo '<table class="table-striped">
  <tr>
    <th class="noborder"></th>
';
		foreach($adminList as $adminRow) {
			echo '    <th class="rotate"><div><span>'.$adminRow['name'].'</span></div></th>
'; }
echo '  <th class="noborder"></th></tr>
';
	foreach($teamList as $teamRow)
	{
		echo '
  <tr>
    <th>'.$teamRow['TNAME'].'</th>
	<form class="form-inline" method="post">
	<div class="form-group">
      <input type="hidden" class="form-control" value="'.$teamRow['TID'].'" name="tid">
    </div>
';
	foreach($adminList as $adminRow) {
		echo '	<td><label class="form-check-inline"><input class="form-check-input" type="checkbox" name="admin_'.$adminRow['user_id'].'"';
		if (in_array($adminRow['user_id'], $adminMap[$teamRow['TID']])) {
			echo ' checked';
		}
		echo ' ></label></td>
';
	}
	echo'	<td>
	    <button type="submit" class="btn btn-default btn-sm" name="btn-update">
          <span class="glyphicon glyphicon-save"></span>Update
		</button>
	</td>
	</form>
  </tr>
	'; }
	echo '  </table>
';
?>

</div>
</body>
</html>
<?php
$db = null;
?>