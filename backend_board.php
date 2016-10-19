<?php  
require_once '_db.php';  
$stmt = $db->prepare('SELECT * FROM `LEADERBOARD` WHERE NOT STATUS = 0 ORDER BY RANK');
$stmt->execute();
$row_count = $stmt->rowCount();
$result = $stmt->fetchAll();
 
 echo '<thead>';
 echo '
					<tr>
					<th>Rank</th>
					<th>Team Name</th>
					<th>Money Raised</th>
					</tr>';
echo '</thead>'; 
 
 
 if($row_count > 0)  
 {  
      echo '<tbody>';
	  
	  foreach($result as $row)  
      {  
           echo ' 
				<tr>  
                     <td>'.$row["RANK"].'</td>  
                     <td>'.$row["TEAM_NAME"].'</td>  
                     <td>'.$row["MONEY_RAISED"].'</td>  
                </tr>  
           ';  
      }      
 }  
 else  
 {  
      echo '<tbody>
				<tr>  
                   <td colspan="4">Data not Found</td>  
                 </tr>';  
 }  
echo '</tbody>';    
 ?> 