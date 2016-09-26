<!DOCTYPE html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Photo Gallery</title>
    <link href="Nucor_Main_Page.css" rel="stylesheet">
	<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
	<link href="drop_menu/drop_menu.css" rel="stylesheet">
	<script src="Bootstrap/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>
	<script src="Bootstrap/bootstrap-3.0.0/assets/js/jquery.js"></script>
<!-- Redundant <script src="bootstrap/js/bootstrap.min.js"></script> -->
<!-- CSS is not a script! <script src="bootstrap/css/bootstrap.min.css"></script> -->
	<?php include 'Nucor_Header.php';?>
</head>

<body>
 <div class="dropdown">
  <button class="dropbtn">More Albums</button>
  <div class="dropdown-content">
    <img class="banner2" src="drop_menu/Pictures_Black.png" alt="logo">
	</br>
	<img class="banner2" src="drop_menu/Pictures_Black.png" alt="logo">
	</br>
	<img class="banner2" src="drop_menu/Pictures_Black.png" alt="logo">
  </div>
</div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="drop_menu/Chrysanthemum.jpg" alt="Chrysanthemum">
      <div class="carousel-caption">
        <h3>Chrysanthemum</h3>
        <p>Sample_Quote.</p>
      </div>
    </div>

    <div class="item">
      <img src="drop_menu/Desert.jpg" alt="Desert">
      <div class="carousel-caption">
        <h3>Desert</h3>
        <p>Sample_Quote.</p>
      </div>
    </div>

    <div class="item">
      <img src="drop_menu/Hydrangeas.jpg" alt="Hydrangeas">
      <div class="carousel-caption">
        <h3>Flowers</h3>
        <p>Sample_Quote.</p>
      </div>
    </div>

    <div class="item">
      <img src="drop_menu/Tulips.jpg" alt="Tulips">
      <div class="carousel-caption">
        <h3>Toulips</h3>
        <p>Sample_Quote.</p>
      </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

</body>
</html>