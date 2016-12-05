<?php 
//Set up albums as table
//Set up images as table

require_once '_db.php';
//For testing uncomment the following line and then comment the one below it and then do the same below in the other two query spots
//$insert = "SELECT * FROM images WHERE imageALBUM = 'SampleAlbum'";
$insert = "SELECT * FROM images WHERE imageALBUM = :selectedAlbum";
$stmt = $db->prepare($insert);
$stmt->bindParam(':selectedAlbum', $_POST['selectedAlbum']);
$stmt->execute();
$row_count = $stmt->rowCount();
if ($row_count) {
echo
'  <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
    <ol class="carousel-indicators">
';
//      $stmt = $db->prepare("SELECT COUNT(*) AS thisAlbumImageCount FROM images WHERE images.imageALBUM = 'SampleAlbum'");
    $stmt = $db->prepare("SELECT COUNT(*) AS thisAlbumImageCount FROM images WHERE images.imageALBUM = :selectedAlbum AND imageACTIVE = TRUE");
	$stmt->bindParam(':selectedAlbum', $_POST['selectedAlbum']);
	$stmt->execute();
	$result = $stmt->fetch();
	$imageCount=$result["thisAlbumImageCount"];
	$slide_to=0;
 if($imageCount)
 { 
	while ($imageCount)
		{ 
		if ($slide_to==0)
		{ echo '      <li data-target="#myCarousel" data-slite-to="'.$slide_to.'" class="active"></li> 
';
		}
		else
		{ echo '      <li data-target="#myCarousel" data-slite-to="'.$slide_to.'"></li> 
';
		}
		$slide_to++;
		$imageCount--;
 }
 }
echo '    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
'; 
//$insert = "SELECT * FROM images WHERE imageALBUM = 'SampleAlbum'";
$insert = "SELECT * FROM images WHERE imageALBUM = :selectedAlbum AND imageACTIVE = TRUE";
$stmt = $db->prepare($insert);
$stmt->bindParam(':selectedAlbum', $_POST['selectedAlbum']);
$stmt->execute();
$row_count = $stmt->rowCount();
$result = $stmt->fetchAll();
$counter = 1;

 if ( $row_count > 0 )
 {
	foreach($result as $row)  
				{  
					if ($counter == 1)
					{
						echo '      <div class="item active">
        <img src="'.$row["imagePATH"].'" alt="'.$row['imageTITLE'].'">
        <div class="carousel-caption">
          <h3>'.$row["imageTITLE"].'</h3>
          <p>'.$row["imageCAP"].'</p>
        </div>
      </div>
';
					}
					if (($row['imageTITLE'] != "error") && $counter!=1)
					{
						echo '      <div class="item">
        <img src="'.$row["imagePATH"].'" alt="'.$row['imageTITLE'].'">
        <div class="carousel-caption">
          <h3>'.$row["imageTITLE"].'</h3>
          <p>'.$row["imageCAP"].'</p>
        </div>
      </div>
';
					}
				$counter++;
				}
 echo '    </div>
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
';
 }
}

else {
   echo
'  <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error retrieving the requested album!
  </div>
';
  }
$db = null;
?>