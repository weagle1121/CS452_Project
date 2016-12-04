<?php  
require_once '_db.php';
$stmt = $db->prepare('SELECT * FROM `TEAMS` WHERE NOT STATUS = 0 ORDER BY TRAISED DESC');
$stmt->execute();
$row_count = $stmt->rowCount();
$result = $stmt->fetchAll();

 $rankposition=1;

 echo'<thead><tr>
	<th>Rank</th>
	<th>Team Name</th>
	<th>Money Raised</th>
	</tr></thead>';

 if($row_count > 0)  
 {  
      echo '<tbody>';
	
			foreach($result as $row)  
				{  
					echo ' 
					<tr>  
                     <td>'.$rankposition.'</td>  
                     <td>'.$row["TNAME"].'</td>  
                     <td>'.$row["TRAISED"].'</td>  
					</tr>  
				';
				$rankposition++;   
				}	 
 }  
 else  
 {  
      echo '<tbody><tr><td colspan="4">Error: Data not Found</td></tr>';  
 }  
echo '</tbody>';    

$db = null;
?> 