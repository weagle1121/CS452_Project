<?php
/*  
PHP file is sent an id variable from the 
$.post() function when an event is clicked on.
Variables sent from jquery are accessed in PHP as $_POST['sample_variable']
fetch() returns an array from a PDO query
return variables are echoed and then used by the anon function in $.post()
*/

require_once '_db.php';
$insert = "SELECT details FROM events WHERE id =:id";
$stmt = $db->prepare($insert);
$stmt->bindParam(':id', $_POST['id']);
$stmt->execute();
$row = $stmt -> fetch();
echo $row['details'];
$db = null;
?>