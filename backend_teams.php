<?php  
require_once '_db.php';  
$stmt = $db->prepare('SELECT * FROM `TEAMS` WHERE NOT STATUS = 0 ORDER BY TNAME');
$stmt->execute();
$row_count = $stmt->rowCount();
$result = $stmt->fetchAll();
 
 echo '<thead>';
 echo '
					<tr>
					<th>Team Name</th>
					<th>Team Captain</th>
					<th>Phone Number</th>
					<th>Email Address</th>
					</tr>';
echo '</thead>'; 
 
 
 if($row_count > 0)  
 {  
      echo '<tbody>';
	  
	  foreach($result as $row)  
      {  
           echo ' 
				<tr>  
                     <td>'.$row["TNAME"].'</td>  
                     <td>'.$row["TCAPTAIN"].'</td>  
                     <td>'.$row["TPHONE"].'</td>
					 <td>'.$row["TEMAIL"].'</td>  					 
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