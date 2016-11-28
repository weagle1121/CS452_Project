<!DOCTYPE html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Photo Gallery</title>
	<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
	<link href="drop_menu/drop_menu.css" rel="stylesheet">
	<link href="nucor_main_page.css" rel="stylesheet">
	<script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/js/carousel.js"></script>




<!-- Redundant <script src="bootstrap/js/bootstrap.min.js"></script> -->
<!-- CSS is not a script! <script src="bootstrap/css/bootstrap.min.css"></script> -->
  <style type="text/css">

  /*background image, should work across web browsers except internet explorer*/

  body {
  background-image: URL(pictures/photo_bkgr.png);
  background-repeat: no-repeat;
  background-position: center center fixed;	
  background-attachment: fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size:cover;
  }
  
/*
  /* 	affects position of more albums button*/
/*
  .dropdown {
  padding-top: 4%;
  }
*/

  /* 	affects position of slideshow */
/*
  .carousel-inner {

  padding-top: 2%;
  padding-left: 15%;
  padding-bottom: 15%;
  }
*/
*/
  </style>
<?php include 'Nucor_Header.php';?>
</head>
<body>
<div style="margin-left: 12%; padding-top: 10%; padding-right: 2%; color:#ffffff">
  <div class="space">
    Select Event:
	<form>
      <select id="selectedAlbum" onchange="selectAlbum()">
<?php
require_once 'backend/_db.php';
$stmt = $db->prepare("SELECT DISTINCT images.imageALBUM FROM images WHERE imageACTIVE = TRUE");
	$stmt->execute();
	$result = $stmt->fetchAll();
 if($stmt->rowCount())
 {
	 foreach($result as $row)
	 {
		 echo '        <option value="'.$row["imageALBUM"].'">'.$row["imageALBUM"].'</option>
';
	 }
 }
?>
      </select>
    </form>
  </div>
</div>
<div id="slide_show">
<!--Data populated by JS Function--></div>
<script>
  $(document).ready(function()
    {
    $.post("backend/backend_photos.php", 
      {
      // variable_name:data
      selectedAlbum:"SampleAlbum"
      },
      function(data)
	  {
        // returned data from php goes into the specified div
        document.getElementById("slide_show").innerHTML = data;
      });
    });
  function selectAlbum()
    {
    selectedAlbum = document.forms[0].selectedAlbum.value;
    $.post("backend/backend_photos.php",
      {
      // variable_name:data
      selectedAlbum:selectedAlbum
      }, 
      function(data)
	    {
        // returned data from php goes into the specified div
        document.getElementById("slide_show").innerHTML = data;
        });
    }
</script>
</body>
</html>