<?php
session_start();

include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: index.php");
}
$query = $db->query("SELECT * FROM admins WHERE admins.user_id = ".$_SESSION['userSession']);
$userRow = $query->fetch();
//Redirect the user if they have a valid session but they do not have site admin rights.
if ($userRow["site_admin"]==FALSE) {
 header("Location: teams.php");
}
if (isset($_POST['btn-update'])) {
 //Consider the other tools for validation/stripping http://www.w3schools.com/php/php_form_url_email.asp
 //Consider email validation here with (filter_var($email, FILTER_VALIDATE_EMAIL)) RETURNS BOOL
 //Definitely convert this into a function
 $user_id = strip_tags($_POST['user_id']);
 $name = strip_tags($_POST['name']);
 $email = strip_tags($_POST['email']);
 //We've got almost all the data from the post stripped- need to make active and site_admin usable
 //Need to convert the following lines to a function
 if (isset($_POST['active']) && $_POST['active']=="on")
 { $active=TRUE; }
 else
 { $active=FALSE; }
 if (isset($_POST['site_admin']) && $_POST['site_admin']=="on")
 { $site_admin=TRUE; }
 else
 { $site_admin=FALSE; }

 if (isset($_POST['thesauce']) || isset($_POST['secsauce'])) {
	if ($_POST['thesauce'] == $_POST['secsauce'])
	{
		$hashed_password = password_hash($_POST['thesauce'], PASSWORD_DEFAULT);
		$query = $db->prepare('UPDATE admins SET name = :name, email = :email, active = :active, site_admin = :site_admin, password = :hashed_password WHERE admins.user_id = :user_id');
		$query->bindValue(':name', $name, PDO::PARAM_STR);
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->bindValue(':active', $active, PDO::PARAM_INT);
		$query->bindValue(':site_admin', $site_admin, PDO::PARAM_INT);
		$query->bindValue(':hashed_password', $hashed_password, PDO::PARAM_STR);
		$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();
	}
	else
	{
		$msg = '<div class="alert alert-danger">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Passwords do not match!
     </div>';
	}
}
else
{
  //THIS IS THE RIGHT WAY! IT HANDLES ' and " properly!!
  $query = $db->prepare('UPDATE admins SET name = :name, email = :email, active = :active, site_admin = :site_admin WHERE admins.user_id = :user_id');
  $query->bindValue(':name', $name, PDO::PARAM_STR);
  $query->bindValue(':email', $email, PDO::PARAM_STR);
  $query->bindValue(':active', $active, PDO::PARAM_INT);
  $query->bindValue(':site_admin', $site_admin, PDO::PARAM_INT);
  $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $query->execute();
 if ($query->rowCount()) {
	   $msg = '<div class="alert alert-success">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; User information updated Successfully!
     </div>';
  } else {
   $msg = '<div class="alert alert-danger">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error while updating user information!
     </div>';
  }
}
  }
if (isset($_POST['btn-add'])) {
 $name = strip_tags($_POST['name']);
 $email = strip_tags($_POST['email']);
 $rawpassword = strip_tags($_POST['thesauce']);
 $hashed_password = password_hash($rawpassword, PASSWORD_DEFAULT);
 if (isset($_POST['active']) && $_POST['active']=="on")
 { $active=TRUE; }
 else
 { $active=FALSE; }
 if (isset($_POST['site_admin']) && $_POST['site_admin']=="on")
 { $site_admin=TRUE; }
 else
 { $site_admin=FALSE; }
 $query = $db->prepare('INSERT INTO admins (user_id, name, email, password, site_admin, active) VALUES (NULL, :name, :email, :hashed_password, :site_admin, :active)');
  $query->bindValue(':name', $name, PDO::PARAM_STR);
  $query->bindValue(':email', $email, PDO::PARAM_STR);
  $query->bindValue(':hashed_password', $hashed_password, PDO::PARAM_STR);
  $query->bindValue(':site_admin', $site_admin, PDO::PARAM_INT);
  $query->bindValue(':active', $active, PDO::PARAM_INT);
  $query->execute();
 if ($query->rowCount()) {
	   $msg = '<div class="alert alert-success">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; User created Successfully!
     </div>';
  } else {
   $msg = '<div class="alert alert-danger">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error while creating user!
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
	    <li class="active"><a href="site_users.php">Users</a></li>
		<li><a href="site_adminteamassign.php">Admins/Teams</a></li>
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
<div class="container" style="margin-top:150px;">
<form class="form-inline" method="post" autocomplete="off">
<div class="row">
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Name>" name="name">
</div>
<div class="form-group">
	<!-- The 'onfocus' hack below is to keep Chrome from trying to be too helpful with entering default credentials for this site. -->
    <input type="email" class="form-control" placeholder="<Email>" name="email" onfocus="this.removeAttribute('readonly');" readonly>
</div>
<div class="form-group">
    <input type="hidden" class="form-control" value="NULL" name="user_id">
</div>
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" name="active" checked>
	</label>
</div>
<div class="checkbox">
    <label class="checkbox-inline">Site Admin?
    <input type="checkbox" name="site_admin">
	</label>
</div>
</div>
<div class="row">
<div class="form-group">
    <input id="sauce1" type="password" class="form-control" placeholder="<Password>" name="thesauce" onfocus="this.removeAttribute('readonly');" readonly>
</div>
<div class="form-group">
    <input id="sauce2" type="password" class="form-control" placeholder="<Confirm Password>" name="secsauce" onfocus="this.removeAttribute('readonly');" onkeyup="compareFields(document.getElementById('sauce1').value, document.getElementById('sauce2').value, document.getElementById('pwMsg'));" readonly>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add">
<span class="glyphicon glyphicon-plus"></span> Create User</button>
</div> 
<div id="pwMsg"></div>
</div>
</form>

<hr style="margin-top: 10px; margin-bottom: 10px;">
<?php
$stmt = $db->prepare('SELECT * FROM admins');
$stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);

if (isset($msg)) {
   echo $msg;
  }
		 foreach($result as $adminRow)
			{
				echo '
<form class="form-inline" method="post">
<div class="row">
<div class="form-group">
    <input type="text" class="form-control" value="'.$adminRow["name"].'" name="name">
</div>
<div class="form-group">
    <input type="email" class="form-control" value="'.$adminRow["email"].'" name="email">
</div>
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$adminRow["user_id"].'" name="user_id">
</div>
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" ';
	if ($adminRow["active"]==TRUE) { echo 'checked '; }
	echo 'name="active">
	</label>
</div>
<div class="checkbox">
    <label class="checkbox-inline">Site Admin?
    <input type="checkbox" ';
	if ($adminRow["site_admin"]==TRUE) { echo 'checked '; }
	echo 'name="site_admin">
	</label>
</div>
</div>
<div class="row">
<div class="form-group">
    <input id="sauce1'.$adminRow['user_id'].'" type="password" class="form-control" placeholder="<Password>" name="thesauce" onfocus="this.removeAttribute(\'readonly\');" readonly>
</div>
<div class="form-group">
    <input id="sauce2'.$adminRow['user_id'].'" type="password" class="form-control" placeholder="<Confirm Password>" name="secsauce" onfocus="this.removeAttribute(\'readonly\');" onkeyup="compareFields(document.getElementById(\'sauce1'.$adminRow['user_id'].'\').value, document.getElementById(\'sauce2'.$adminRow['user_id'].'\').value, document.getElementById(\'pwMsg'.$adminRow['user_id'].'\'));" readonly>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update">
<span class="glyphicon glyphicon-save"></span> Update</button>
</div>
<div id="pwMsg'.$adminRow['user_id'].'"></div>
</div>
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">';
			}
//STILL NEED TO CODE "DELETE USER"
?>
</div>
</body>
<script>
function compareFields(val1, val2, msg) {
    if (val1 == val2) {
        msg.innerHTML = '<div class="alert alert-success">\
  <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Passwords match!\
</div>';
    }
	else msg.innerHTML = '<div class="alert alert-danger">\
  <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Passwords do not match!\
</div>';
}

</script>
</html>
<?php
$db = null;
?>