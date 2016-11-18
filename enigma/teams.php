<?php
//Need to build in checks to make sure the admin has permission to edit the members that they are posting for.
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: index.php");
}

$query = $db->query("SELECT * FROM admins WHERE user_id=".$_SESSION['userSession']);
$userRow = $query->fetch();

if (isset($_POST['btn-update-mem'])) {
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $email = strip_tags($_POST['email']);
 $phone = strip_tags($_POST['phone']);

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
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Team member information updated Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while updating team member information!
     </div>";
  }
}
if (isset($_POST['btn-add-mem'])) {
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $email = strip_tags($_POST['email']);
 $phone = strip_tags($_POST['phone']);
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
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Team member created successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while creating team member!
     </div>";
  }
}
if (isset($_POST['btn-upd-announce'])) {
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $start = strip_tags($_POST['start']);
 $end = strip_tags($_POST['end']);
 $details = strip_tags($_POST['details']);

 $query = $db->prepare('UPDATE anouncements SET name = :name, start = :start, end = :end, details = :details WHERE id = :id');
  $query->bindValue(':name', $name, PDO::PARAM_STR);
  $query->bindValue(':start', $start, PDO::PARAM_STR);
  $query->bindValue(':end', $end, PDO::PARAM_STR);
  $query->bindValue(':details', $details, PDO::PARAM_STR);
  $query->bindValue(':id', $id, PDO::PARAM_STR);
  $query->execute();
  
 if ($query->rowCount()) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Announcement updated Successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while updating announcement!
     </div>";
  }
}
if (isset($_POST['btn-add-announce'])) {
 $name = strip_tags($_POST['name']);
 $start = strip_tags($_POST['start']);
 $end = strip_tags($_POST['end']);
 $tid = strip_tags($_POST['tid']);
 $details = strip_tags($_POST['details']);

 $query = "INSERT INTO anouncements (id, TID, name, start, end, details)
					VALUES	  (NULL, :name, :start, :end, :tid, :details)";
  $query->bindValue(':name', $name, PDO::PARAM_STR);
  $query->bindValue(':start', $start, PDO::PARAM_STR);
  $query->bindValue(':end', $end, PDO::PARAM_STR);
  $query->bindValue(':tid', $tid, PDO::PARAM_STR);
  $query->bindValue(':details', $details, PDO::PARAM_STR);
  $query->execute();

 if ($db->rowCount()) {
	   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Announcement created successfully!
     </div>";
  } else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while creating announcement!
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
      <?php if ($userRow["site_admin"]==TRUE)
	  { echo '
      <li><a href="site_users.php">SITE</a></li>
'; } ?>
      <li class="active"><a href="teams.php">TEAMS</a></li>
      <li><a href="profile.php">MY PROFILE</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username'];?></a></li>
      <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
    </ul>
  </div>
</nav><div class="container" style="margin-top:150px;">
<?php
$stmt = $db->prepare('SELECT TID, TNAME, TRAISED FROM teams WHERE find_in_set(:user_id, admin_ids) ORDER BY TNAME');
$stmt->bindValue('user_id', $userRow['user_id'], PDO::PARAM_INT);
$stmt->execute();
$teamList = $stmt->fetchall(PDO::FETCH_ASSOC);
if (isset($msg)) {
   echo $msg;
  }
if ($stmt->rowCount()) {
		//Now we have each active team in array $teamList, each active team will be listed as its own TID in $teamRow
		foreach($teamList as $teamRow)
			{
			$stmt = $db->prepare('SELECT * FROM members WHERE MEMBEROF = :currTeam ORDER BY name');
			$stmt->bindValue(':currTeam',$teamRow['TID'],PDO::PARAM_STR);
			$stmt->execute();
			$memberList = $stmt->fetchall(PDO::FETCH_ASSOC);
			$memberCount = $stmt->rowCount();

			$stmt = $db->prepare('SELECT * FROM anouncements WHERE TID = :currTeam ORDER BY start');
			$stmt->bindValue(':currTeam',$teamRow['TID'],PDO::PARAM_STR);
			$stmt->execute();
			$announceList = $stmt->fetchall(PDO::FETCH_ASSOC);
			$announceCount = $stmt->rowCount();
			
			echo '<h2>'.$teamRow['TNAME'].'</h2>
<h3>Amount raised</h3>
<form class="form-inline" method="post">
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$teamRow['TID'].'" name="tid">
</div>
<div class="form-group">
    <input type="number" class="form-control" value="'.$teamRow['TRAISED'].'" name="name">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-upd-traised">
<span class="glyphicon glyphicon-save"></span>&nbsp;Update</button>
</div> 
</form>
<h3>'.$memberCount.' Member';
if ($memberCount == 0 OR $memberCount > 1) {
	echo 's';
}
echo ' !Add active/inactive</h3>
<form class="form-inline" method="post" autocomplete="off">
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$teamRow['TID'].'" name="tid">
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
<button type="submit" class="btn btn-default" name="btn-add-mem">
<span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button>
</div> 
</form>
';
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
    <label class="checkbox-inline">
	<input type="checkbox" ';
	if ($memberRow["active"]==TRUE) { echo 'checked '; }
	echo 'name="active">
	</label>
</div>
<div class="checkbox">
    <label class="checkbox-inline">
	<input type="checkbox" ';
	if ($memberRow["captain"]==TRUE) { echo 'checked '; }
	echo 'name="captain">
	</label>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update-mem">
<span class="glyphicon glyphicon-save"></span>&nbsp;Update</button>
</div> 
</form>
';
			}
echo '<h3>'.$announceCount.' Announcement';
if ($announceCount == 0 OR $announceCount > 1) {
	echo 's';
}
echo ' !Add active/inactive</h3>
<form class="form-inline" method="post">
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
    <input type="hidden" class="form-control" value="'.$teamRow['TID'].'" name="tid">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add-announce">
<span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button>
</div> 
<div class="form-group">
    <textarea class="form-control" placeholder="<Anouncement Text>" name="details" maxlength="600" rows="3" cols="132"></textarea>
</div>
</form>
';
		foreach($announceList as $aRow)
		{
			echo'<form class="form-inline" method="post">
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$aRow['id'].'" name="id">
</div>
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
<button type="submit" class="btn btn-default" name="btn-upd-announce">
<span class="glyphicon glyphicon-save"></span>&nbsp;Update</button>
</div> 
<div class="form-group">
    <textarea class="form-control" name="details" maxlength="600" rows="3" cols="132">'.$aRow['details'].'</textarea>
</div>
</form>';
			}
			echo '<hr>
';
			}
			}
else {
	echo '<p>You are currently not assigned any teams, please contact a site administrator to assign a team to you.</p>
</div>
</body>
</html>';
}
$db = null;
?>