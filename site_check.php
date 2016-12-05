<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: index.php");
}
$query = $db->query("SELECT * FROM admins WHERE user_id=".$_SESSION['userSession']);
$userRow = $query->fetch();

function valdate($data)
{
	$parts = explode('-', $data);
	if(count($parts) == 3) 
	{
		list($y, $m, $d) = $parts;
		$checkyear = is_numeric($y);
		$checkday = is_numeric($d);
		$checkmonth = is_numeric($m);
	if ($checkyear && $checkday && $checkmonth)
	{
		if($y >= 2000 && $m >=1 && $m <=12 && $d>=1 && $d<=31)
		{
			if(checkdate($m, $d, $y))
				return true;
			else
				return false;
		}
		else
			return false;
	}
	else
	  return false;
}
	else {return false;}
}
?>
