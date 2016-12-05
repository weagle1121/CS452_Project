<?php
$dsn = 'mysql:dbname=nucor;host=localhost;charset=utf8';
$user = 'root';
$password = '';
try {
	$db = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//	$db = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (PDOException $e) {
	$dbfailmsg = '<h1>Database connection unavailable.</h1>';
	echo $dbfailmsg;
	exit;
}
/*
$db = new PDO('mysql:host=localhost;dbname=nucor;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
*/
?>