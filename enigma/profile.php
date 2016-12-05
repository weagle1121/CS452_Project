<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: index.php");
}

$query = $db->query("SELECT * FROM admins WHERE user_id=".$_SESSION['userSession']);
$userRow = $query->fetch();

if(isset($_POST['btn-details'])) {
 $name = strip_tags($_POST['name']);
 $email = strip_tags($_POST['email']);

 $query = "UPDATE admins SET name = '$name', email = '$email' WHERE admins.user_id =".$_SESSION['userSession'];
  if ($db->query($query)) {
   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; User information updated Successfully!
     </div>";
  }else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while updating user information!
     </div>";
  }
	//User row data has changed, need to re-read.
  $query = $db->query("SELECT * FROM admins WHERE user_id=".$_SESSION['userSession']);
  $userRow = $query->fetch();
}

if(isset($_POST['btn-pass'])) {
 if ($_POST['thesauce'] == $_POST['thesauce2'])
 {
 $rawpassword = strip_tags($_POST['thesauce']);
 $hashed_password = password_hash($rawpassword, PASSWORD_DEFAULT);
 $query = "UPDATE admins SET password = '$hashed_password' WHERE admins.user_id =".$_SESSION['userSession'];
  if ($db->query($query)) {
   $pmsg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Password updated successfully!
     </div>";
  }
  else {
   $pmsg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while updating password!
     </div>";
  }
 }
 else {
	 $pmsg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Passwords do not match!
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
      <li><a href="teams.php">TEAMS</a></li>
      <li class="active"><a href="profile.php">MY PROFILE</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username'];?></a></li>
      <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
    </ul>
  </div>
  <!--
  <div class="navbar-collapse collapse">
      <ul class="nav nav-pills">
	    <li class="active"><a href="site_users.php">Users</a></li>
		<li><a href="site_divisions.php">Divisions</a></li>
		<li><a href="site_teams.php">Teams</a></li>
		<li><a href="site_teamrosters.php">Team Rosters</a></li>
		<li><a href="site_anouncements.php">Anouncements</a></li>
		<li><a href="site_events.php">Events</a></li>
		<li><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>-->
</nav>
<div class="container" style="margin-top:150px;">
<?php
  if (isset($msg)) {
   echo $msg;
  }
  ?>
  <h3 class="form-signin-heading">Update info:</h3>
  
<form class="form-horizontal" method="post">
    <div class="form-group">
	  <label for="pUName" class="col-sm-2 control-label">Username</label>
	    <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $userRow["username"] ?>" name="username" required id="pUName" readonly />
		</div>
	</div>
    <div class="form-group">
	  <label for="pName" class="col-sm-2 control-label">Name</label>
	    <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $userRow["name"] ?>" name="name" required id="pName" maxlength="64" />
		</div>
	</div>
	<div class="form-group">
	  <label for="pEmail" class="col-sm-2 control-label">Email</label>
	  <div class="col-sm-10">
	    <input type="email" class="form-control" value="<?php echo $userRow["email"] ?>" name="email" required id="pEmail" maxlength="60" />
	  </div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10">
	    <button type="submit" class="btn btn-default" name="btn-details">Update</button> 
	  </div>
	</div>
</form>
<hr />
<?php
  if (isset($pmsg)) {
   echo $pmsg;
  }
  ?>
<h3 class="form-signin-heading">Update password:</h3>
<form class="form-horizontal" method="post">
	<div class="form-group">
	  <label for="pPass" class="col-sm-2 control-label">Enter New Password</label>
	  <div class="col-sm-10">
	    <input type="password" class="form-control" name="thesauce" placeholder="<New Password>" required id="pPass" maxlength="32" />
	  </div>
	</div>
	<div class="form-group">
	  <label for="pPassConfirm" class="col-sm-2 control-label">Re-enter New Password</label>
	  <div class="col-sm-10">
	    <input type="password" class="form-control" name="thesauce2" placeholder="<Confirm Password>" required id="pPassConfirm" maxlength="32" />
	  </div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10">
	    <button type="submit" class="btn btn-default" name="btn-pass">Update</button> 
	  </div>
	</div>
</form>
	<hr />
</div>
</body>
</html>
<?php
$db = null;
?>