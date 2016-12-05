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


function merge_Date_Time($date,$time,$type)
{
	$parts = explode(':', $time);
	list($hour, $minute) = $parts;
	
	if($minute < 10)
	{
		$minute = '0'+ (string)$minute;
	}
	
	if ($type == 'pm')
	{
		if ($hour == 12)
			$hour =12;
		else
		   $hour = $hour+=12;	
	}
	if ($type =='am')
	{
		if($hour<10)
			$hour = '0'+(string)$hour;	
	}

	$newtime = $date.' '.(string)$hour.':'.(string)$minute.':00';
	return $newtime;
	
}

function valtime($data)
{
	$parts = explode(':', $data);
	if(count($parts) == 2) 
	{
		list($h, $m) = $parts;
		$checkh = is_numeric($h);
		$checkm= is_numeric($m);
			if ($checkh && $checkm)
				{
					if($h >= 1 && $h<=12 && $m >=0 && $m <=59)
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

//Example:
//$date = '2016-12-04';
//$time= '8:30';
//$type= 'pm';

//returns a bool
//valtime($time);

//returns a bool
//valdate($date);

//returns a string like 2016-12-05 15:30:00
//merge_Date_Time($date,$time,$type);
//Example:
//$start_day_time = '2016-12-05T15:16:00';
//list($newdate,$newtime) = Date_Time_In($start_day_time);
//$newdate now has the date in the form 2016-12-05
//$newtime now has the form 3:15
//echo $newdate;
//echo $newtime;

function Date_Time_In($data)
{
	$blank = array("Error:Database down","Error:database down");
	$parts = explode('T', $data);
	
	if(count($parts) == 2) 
	{
		list($date, $time) = $parts;
		  $parts = explode(':',$time);
		    if (count($parts)==3)
			{ 
		       list($hour, $minute,$second) = $parts;
			   $checkhour = is_numeric($hour);
		       $checkminute = is_numeric($minute);
			   $checksecond = is_numeric($second);
			   if ($checkhour && $checkminute && $checksecond)
			   {
				   if ($hour >12)
					   $hour -= 12;
				   
				   $hour = (string)$hour;
				   $minute = (string)$minute;
				   $newtime = $hour.':'.$minute;
				   $data = array($date,$newtime);
				   return $data;
			   }
			   else
				   return $blank;
			}
		    else
				   return $blank;	
	}
	else 
		return $blank;	
}
?>
