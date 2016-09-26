<!doctype html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Nucor Events</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="Bootstrap/bootstrap-3.0.0/dist/css/bootstrap.css" rel="stylesheet">
    <link href="Nucor_Main_Page.css" rel="stylesheet">
	<script src="codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
	<?php include 'Nucor_Header.php';?>
</head>
	


<script type="text/javascript" charset="utf-8">
	function init() {
		scheduler.config.start_on_monday=true;
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.hour_date="%h:%i %A";
		scheduler.init('scheduler_here',new Date(2016,8,1),"month");
	}
</script>

<body onload="init();">
	<div id="scheduler_here" class="dhx_cal_container">
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
			<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>
</body>
