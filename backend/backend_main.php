<?php  

/* Start connection to database */
require_once '_db.php';
/* This code uses PHP Data Objects. PDO is a lean, consistent way to access databases.
$insert - string to query database
$stmt (cant be any variable name) - receives data from database query
$stmt->execute() - queries the database
$stmt->rowCount() - returns number of rows received from the query, execute() precedes this
$stmt->fetchAll() - returns all the rows recieved from the query, execute() precedes this
$result = $stmt->fetchAll() - $result is used to access the data received from the database

java script on Nucor_Main.php:
$(document).ready(function(){
			$.post("calendar_lib/backend_main.php", 
                    {
						curr:curr
                    }, 
                    function(data) {
						document.getElementById("announcements").innerHTML = data;
                    });
		});

Data sent to php from javascript will be in the form  
$_POST['curr']

MYSQL function DATE() - returns datetime in form year-month-day ex: 2016-10-24

*/


$insert = "SELECT * FROM `anouncements` WHERE DATE(end) >= :curr ";
$stmt = $db->prepare($insert);
$stmt->bindParam(':curr', $_POST['curr']);
$stmt->execute();
$row_count = $stmt->rowCount();
$result = $stmt->fetchAll();


/*
Steps:
1. In Nucor_Main.php create empty div with id = "announcements" to hold announcements and events
2. Create container div for all announcements called A1,  it has the CSS of "container" class
3. foreach loop creates sub divs inside of announce div called SUB_A1
4. To change CSS element use ids:
		announcement div wrapper - A1
		header - h3 
		text - SUB_A1
*/
echo '<div class="container" id ="A1">';
 if ( $row_count > 0)
 {
	echo'<h2>This Weeks Anouncements:</h2>';
	foreach($result as $row)  
				{  
					echo ' 
							<div id = "sub_A1" >
								<h3><center>'.$row["name"].'</center></h3>
								<p><center>'.$row["details"].'</center></p> 					 
							</div>'; 
				}
 }
 else
	echo '<h2>There are no current anouncements.</h2>';
echo '</div>';


/*
Query selects events that are happening on the current day from the database
*/

$insert = "SELECT * FROM `events` WHERE DATE(start)<= :curr AND DATE(end) >= :curr ";
$stmt = $db->prepare($insert);
$stmt->bindParam(':curr', $_POST['curr']);
$stmt->execute();
$row_count = $stmt->rowCount();
$result = $stmt->fetchAll();
 
 /*
Steps:
1. In Nucor_Main.php create empty div with id = "announcements" to hold announcements and events
2. Create container div for all events called event_div, it has the CSS of "container" class
3. The foreach loop creates sub divs inside of event_div called sub_event_div and fills them with data
4. To change CSS element use ids:
		event div wrapper - event_div
		header - h3 
		text - sub_event_div		
*/
 
echo'<div class="container" id = "event_div">';
 if($row_count > 0)  
 {  
    echo '<h2>Todays Events:</h2>';
	
	foreach($result as $row)  
				{  
					echo ' 
							<div id = "sub_event_div" >
								<h3><center>'.$row["name"].'</center></h3>
								<p><center>'.$row["details"].'</center></p> 					 
							</div>';
				}
  }  
 else  
       echo '<h2>There are no events scheduled today!</h2>';
echo '</div>';
$db = null;
 ?> 
