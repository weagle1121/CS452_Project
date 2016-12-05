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
if (isset($_POST['btn-update-album'])) {
 $id = strip_tags($_POST['id']);
 $name = strip_tags($_POST['name']);
 $date = strip_tags($_POST['date']);
 $tid = strip_tags($_POST['team_or_site']);

 $query = "UPDATE albums SET name = '$name',
								date = '$date',
								tid = '$tid'
			WHERE albums.id=".$id;
 if ($db->query($query)) {
	   $albummsg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Album updated Successfully!
     </div>";
  } else {
   $albummsg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error updating album!
     </div>";
  }
}
if (isset($_POST['btn-update-image'])) {
 $id = strip_tags($_POST['id']);
 $title = strip_tags($_POST['title']);
 $caption = strip_tags($_POST['caption']);
 if (isset($_POST['active']) && $_POST['active']=="on")
 { $active=TRUE; }
 else
 { $active=FALSE; }

 $query = "UPDATE images SET imageTITLE = '$title',
								imageCAP = '$caption',
								imageACTIVE = '$active'
			WHERE images.imageID=".$id;
 if ($db->query($query)) {
	   $imagemsg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Image info updated Successfully!
     </div>";
  } else {
   $imagemsg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error updating image!
     </div>";
  }
}
if (isset($_POST['btn-add-album'])) {
 $name = strip_tags($_POST['name']);
 $date = strip_tags($_POST['date']);
 $tid = strip_tags($_POST['team_or_site']);
 
 $tinsert = $db->prepare('INSERT INTO albums (id, name, date, tid) VALUES (NULL, :name, :date, :tid)');
 $tinsert->execute(array(':name' => $name, ':date' => $date, ':tid' => $tid));
 if ($tinsert->rowCount()) {
	   $addmsg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Album created Successfully!
     </div>";
  } else {
   $addmsg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error while creating album!
     </div>";
  }
}

if (isset($_POST['btn-add-image'])) {
 $target_dir = "../backend/photos/";
 $target_file = $target_dir . basename($_FILES['imageFile']['name']);
 //$uploadOk = 1;
 $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
 // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['imageFile']['tmp_name']);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
		$filemsg = 'File is not an image.';
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $filemsg = 'File already exists.';
	$uploadOk = 0;
}
// Check file size
if ($_FILES['imageFile']['size'] > 2097152) {
    //echo "Sorry, your file is too large.";
    $filemsg = 'File is too large. 2MB is the maximum size allowed';
	$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$filemsg = 'File is not a supported type';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $target_file)) {
        //echo "The file ". basename( $_FILES['imageFile']['name']). " has been uploaded.";
		$filemsg = 'The file '. basename( $_FILES['imageFile']['name']).' has been uploaded.';
    } else {
        //echo "Sorry, there was an error uploading your file.";
		$filemsg = 'There was an error uploading your file.';
    }
}

 $albumid = strip_tags($_POST['albumid']);

 if ($uploadOk == 1) {
 $title = strip_tags($_POST['title']);
 $caption = strip_tags($_POST['caption']);
// $albumid = strip_tags($_POST['albumid']);
 if (isset($_POST['active']) && $_POST['active']=='on')
 { $active=TRUE; }
 else
 { $active=FALSE; }
 
 $tinsert = $db->prepare('INSERT INTO images (imageID, imageALBUM, imagePATH, imageTITLE, imageCAP, imageACTIVE) VALUES (NULL, :albumid, :path, :title, :caption, :active)');
 $tinsert->execute(array(':albumid' => $albumid, ':title' => $title, ':path' => 'backend/photos/'.$_FILES['imageFile']['name'], ':caption' => $caption, ':active' => $active));
 if ($tinsert->rowCount()) {
	   $addimagemsg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Image added successfully!
     </div>";
  } else {
   $addimagemsg = '<div class="alert alert-danger">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error while adding image!
     </div>';
  }
}
else {
	   $addimagemsg = '<div class="alert alert-danger">
      <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error while adding image! "'.$filemsg.'"
     </div>';
}
}


/*
<?php
$target_dir = "../backend/photos/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>*/

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
		<li><a href="site_teams.php">Teams</a></li>
		<li><a href="site_teamrosters.php">Team Rosters</a></li>
		<li><a href="site_anouncements.php">Anouncements</a></li>
		<li><a href="site_events.php">Events</a></li>
		<li class="active"><a href="site_albums.php">Albums</a></li>
	  </ul>
	</div>
  </div>
</nav>
<div class="container" style="margin-top:150px;">
<?php
if (isset($addmsg)) {
	echo $addmsg;
}
?>
<form class="form-inline" method="post" autocomplete="off">
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Album Name>" name="name">
</div>
<div class="form-group">
    <input type="date" class="form-control" name="date">
</div>
<div class="form-group">
  <select class="form-control" name="team_or_site">
    <option value="0" selected>Site</option>
<?php
$stmt = $db->prepare('SELECT TID, TNAME FROM teams');
$stmt->execute();
$teamlist = $stmt->fetchall(PDO::FETCH_ASSOC);

		foreach($teamlist as $team)
		{
			echo '    <option value="'.$team['TID'].'">'.$team['TNAME'].'</option>
';
		}
echo '</select>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add-album">
<span class="glyphicon glyphicon-plus"></span> &nbsp; Create Album</button>
</div> 
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">
';

$stmt = $db->prepare('SELECT * FROM albums');
$stmt->execute();
$albums = $stmt->fetchall(PDO::FETCH_ASSOC);
	 foreach($albums as $albumRow)
			{
				echo '
<form class="form-inline" method="post">
<div class="form-group">
    <input type="text" class="form-control" value="'.$albumRow["name"].'" name="name">
</div>
<div class="form-group">
    <input type="date" class="form-control" value="'.$albumRow["date"].'" name="date">
</div>
<div class="form-group">
  <select class="form-control" name="team_or_site">
    <option value="0">Site</option>
';

		foreach($teamlist as $team)
		{
			echo '    <option ';
			if ($albumRow['tid'] == $team['TID']) {
				echo 'selected ';
			}
			echo 'value="'.$team['TID'].'">'.$team['TNAME'].'</option>
';
		}
echo '  </select>
</div>
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$albumRow['id'].'" name="id">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update-album">
<span class="glyphicon glyphicon-save"></span>&nbsp;Update Album</button>
</div> 
</form>';
if (isset($addimagemsg) && $albumid == $albumRow['id']) {
   echo $addimagemsg;
  }
echo '
<br>
<form class="form-inline" method="post" enctype="multipart/form-data">
<span class="glyphicon glyphicon-picture"></span> &nbsp;
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Image Title>" name="title">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="<Caption>" name="caption">
</div>
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" checked name="active">
	</label>
</div>
<div class="form-group">
    <input type="file" name="imageFile" id="imageFile">
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-add-image">
<span class="glyphicon glyphicon-plus"></span>&nbsp;Add Image</button>
</div>
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$albumRow['id'].'" name="albumid">
</div>
</form>
<hr style="margin-top: 10px; margin-bottom: 10px;">';

$stmt = $db->prepare('SELECT * FROM images WHERE imageALBUM = :imageALBUM');
$stmt->bindValue(':imageALBUM',$albumRow['id'],PDO::PARAM_STR);
$stmt->execute();
$images = $stmt->fetchall(PDO::FETCH_ASSOC);
if (isset($albummsg) && $id == $albumRow['id']) {
   echo $albummsg;
  }
		 foreach($images as $imageRow)
			{
				echo '
<form class="form-inline" method="post">
<span class="glyphicon glyphicon-picture"></span> &nbsp;
<div class="form-group">
    <input type="text" class="form-control" value="'.$imageRow["imageTITLE"].'" name="title">
</div>
<div class="form-group">
    <input type="text" class="form-control" value="'.$imageRow["imageCAP"].'" name="caption">
</div>
<div class="checkbox">
    <label class="checkbox-inline">Active?
	<input type="checkbox" ';
	if ($imageRow['imageACTIVE']==TRUE) { echo 'checked '; }
	echo 'name="active">
	</label>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="btn-update-image">
<span class="glyphicon glyphicon-save"></span>&nbsp;Update Image</button>
</div> 
<div class="form-group">
    <input type="hidden" class="form-control" value="'.$imageRow['imageID'].'" name="id">
</div>
</form>';
if (isset($imagemsg) && $id == $imageRow['imageID']) {
   echo $imagemsg;
  }
echo '
<hr style="margin-top: 10px; margin-bottom: 10px;">';
			}
			}
?>

</div>
</body>
</html>
<?php
$db = null;
?>