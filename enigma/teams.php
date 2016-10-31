<?php include '_enigma_header.php'; ?>

<div class="container" style="margin-top:150px;">
<?php if ($userRow['site_admin']==TRUE)
{ echo "<p>We have a site admin!</p>"; }
?>
<?php
$stmt = $db->prepare('SELECT TID, TNAME FROM teams WHERE TADMINS=?');
$stmt->bindValue(1, $userRow["user_id"], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		 echo '<table>';
		 foreach($result as $teamRow)
			{
				echo '
				<tr>
                     <td>'.$teamRow["TID"].'</td>
                     <td>'.$teamRow["TNAME"].'</td>
                </tr>
				';
			}
echo '</table>';
?>
</div>

</body>
</html>
<?php
$db = null;
?>