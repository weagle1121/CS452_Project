<?php
$db = new PDO('mysql:host=localhost;dbname=nucor;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>