<?php  
/* Start connection to database */
require_once '_db.php';
$insert = "SELECT * FROM images WHERE imageYEAR = :year";
$stmt = $db->prepare($insert);
$stmt->bindParam(':year', $_POST['year']);
$stmt->execute();
$row_count = $stmt->rowCount();
$result = $stmt->fetchAll();
$counter = 1;
 
 if ( $row_count > 0)
 {
	foreach($result as $row)  
				{  
					if ($counter == 1)
					{
						echo '<div class="item active">
								<img src='.$row["imagePATH"].' alt=" '.$row["imageYEAR"].' ">
								<div class="carousel-caption">
										<h3>'.$row["imageTITLE"].'</h3>
										<p>'.$row["imageCAP"].'</p>
									</div>
								</div>';
						$counter++;
					}
					if ($row['imageTITLE'] != "error")
					{
						echo '<div class="item">
									<img src='.$row["imagePATH"].' alt="'.$row["imageYEAR"].'">
									<div class="carousel-caption">
										<h3><center>'.$row["imageTITLE"].'</h3>
										<p>'.$row["imageCAP"].'</p>
									</div>
								</div>';
					}
				}
 }
 else 
 {
	echo '<div class="item active">
			<img src="" alt="">
				<div class="carousel-caption">
					<h3>Error: Database is down</h3>
					<p>Please check back later</p>
				</div>
		</div>';
}