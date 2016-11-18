<?php  
$PAGE_ID = $_POST['id'];
require_once '_db.php';
$insert = "SELECT * FROM LABELS WHERE PAGE_ID = :id";
$stmt = $db->prepare($insert);
$stmt->bindParam(':id', $_POST['id']);
$stmt->execute();
$column_count = $stmt->columnCount();
$column = $stmt -> fetch();


 if ( $column_count > 0)
 {
	echo '<thead>
			<tr>';
			for ($x = 1; $x < $column_count; $x++) {
				if ($column["label$x"] != "")
				echo '<th>'.$column["label$x"].'</th>';
			}
	echo '</tr>
		</thead>';
 }
 else
	 echo'<thead><tr><th>Error: No Data Found</th></tr></thead>';

	if ($PAGE_ID == 1)
		$stmt = $db->prepare('SELECT * FROM `TEAMS` WHERE NOT STATUS = 0 ORDER BY TNAME');
	
	if ($PAGE_ID == 2)
		$stmt = $db->prepare('SELECT * FROM `TEAMS` WHERE NOT STATUS = 0 ORDER BY TRAISED DESC');

	$stmt->execute();
	$row_count = $stmt->rowCount();
	$result = $stmt->fetchAll();
 
 
 if($row_count > 0)  
 {  
      echo '<tbody>';
	  if ($PAGE_ID == 1)
	 {
			foreach($result as $row)  
				{  
					echo ' 
					<tr>  
						<td><a href="'.$row["TURL"].'">'.$row["TNAME"].'</a></td>';
						$divisionNameQuery = "SELECT DNAME FROM DIVISIONS WHERE DID = :tdiv LIMIT 1";
						$divisionNameSTMT = $db->prepare($divisionNameQuery);
						$params = array( 'tdiv' => $row["TDIVISION"] );
						$divisionNameSTMT->execute($params);
						$divisionNameRow = $divisionNameSTMT->fetch();
						$divisionName = $divisionNameRow["DNAME"];
						echo '
						<td>'.$divisionName.'</td>
						<td>'.$row["TYEAR"].'</td>
						<td>'.$row["TRAISED"].'</td>
					</tr>';  
				}
	}

	if($PAGE_ID == 2)
	 {
		 $rankposition=1;
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
	 
 }  
 else  
 {  
      echo '<tbody><tr><td colspan="4">Error: Data not Found</td></tr>';  
 }  
echo '</tbody>';    

$db = null;
?> 