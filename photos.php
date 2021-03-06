<!DOCTYPE html>
<!--
CS452 Capstone Project Fall 2016
Lia Brannon
Shaun Dyer
Andrew Jordan
Shannon LaMar
Adam Moses
-->
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Photo Gallery</title>
   <!-- Bootstrap core CSS -->
    <link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">

	<link href="drop_menu/drop_menu.css" rel="stylesheet">
	<!-- Custom styles for this site -->
	<link href="main_page.css" rel="stylesheet">


  <!-- Custom styles for this page -->
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
  

  </style>
<?php include 'header.php';?>
</head>
<body>
<div style="margin-left: 12%; padding-top: 10%; padding-right: 2%; color:#ffffff">
  <div class="space">
    Select Event:
	<form>
      <select id="selectedAlbum" onchange="selectAlbum()">
<?php
require_once 'backend/_db.php';
$stmt = $db->prepare('SELECT * FROM albums WHERE id IN (SELECT imageALBUM FROM images WHERE imageACTIVE = TRUE) ORDER BY date DESC');
	$stmt->execute();
	$result = $stmt->fetchAll();
	var_dump ($result);
 if($stmt->rowCount())
 {
	 foreach($result as $albumRow)
	 {
		 echo '        <option value="'.$albumRow['id'].'">'.$albumRow['date'].' - '.$albumRow['name'].'</option>
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
	<script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/js/carousel.js"></script>
<script>
  $(document).ready(function()
    {
    $.post("backend/backend_photos.php", 
      {
      // variable_name:data
      selectedAlbum:<?php echo $result[0]['id']; ?>
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
<!-- 	Bootstrap core JavaScript -->
</body>
</html>