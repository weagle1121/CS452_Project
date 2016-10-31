<?php
session_start();
require_once 'dbconnect.php';

if (isset($_SESSION['userSession'])!="") {
 header("Location: teams.php");
 exit;
}

if (isset($_POST['btn-login'])) {
//Sanitize user input 
 $email = strip_tags($_POST['email']);
 $password = strip_tags($_POST['password']);
//Prepare and execute DB Lookup
$stmt = $db->prepare('SELECT user_id, email, password FROM admins WHERE email=?');
$stmt->bindValue(1, $email, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
//Results are in $row and $count
 if (password_verify($password, $row['password']) && $count==1) {
  $_SESSION['userSession'] = $row['user_id'];
  header("Location: teams.php");
 } else {
  $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
    </div>";
 }
 $db = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html"	charset="utf-8" />
	<title>Login</title>
	<link href="../bootstrap/bootstrap-3.0.0/dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../bootstrap/bootstrap-3.0.0/dist/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
	<div class="signin-form">
		<div class="container">
			<form class="form-signin" method="post" id="login-form">
				<h2 class="form-signin-heading">Enigma Sign In</h2>
				<hr />
					<?php
					if(isset($msg)){echo $msg;}
					?>
					<div class="form-group">
						<input type="email" class="form-control" placeholder="Email address" name="email" required />
						<span id="check-e"></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" name="password" required />
					</div>
					<hr />
					<div class="form-group">
					<button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
						<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In</button> 
					</div>
			</form>
		</div>
    </div>
</body>
</html>