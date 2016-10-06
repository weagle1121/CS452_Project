<!doctype html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Nucor Events</title>
	
	<link href="Nucor_Main_Page.css" rel="stylesheet">
	<link rel="stylesheet" href="codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
	<script src="codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	<script src="codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
	
	<style type="text/css" media="screen">
    html, body {
        margin: 0px;
        padding: 0px;
        height: 100%;
        overflow: hidden;
    }
</style>

</head>
	

<script type="text/javascript" charset="utf-8">
	function init() {
		
		scheduler.locale.labels.section_custom = "Section";
        scheduler.config.details_on_create = true;
        scheduler.config.details_on_dblclick = true;
		scheduler.config.multi_day = true;
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		
		scheduler.config.lightbox.sections = [
                {name: "description", height: 130, map_to: "text", type: "textarea", focus: true},
                {name: "location", height: 43, type: "textarea", map_to: "details"},
                {name: "time", height: 72, type: "time", map_to: "auto"}
            ]
		
		scheduler.init('scheduler_here',new Date(),"month");
		
		void scheduler.load("cc.php",function(){
		alert("Data has been successfully loaded");
		});
		
		var dp = new dataProcessor("cc.php");
		dp.init(scheduler);
		
		}
		
		
		
		function show_minical(){
		if (scheduler.isCalendarVisible())
			scheduler.destroyCalendar();
		else
			scheduler.renderCalendar({
				position:"dhx_minical_icon",
				date:scheduler._date,
				navigation:true,
				handler:function(date,calendar){
					scheduler.setCurrentView(date);
					scheduler.destroyCalendar()
				}
			});
	}
</script>

<body onload="init();">
	<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
      <div class="dhx_cal_navline">
         <div class="dhx_cal_prev_button">&nbsp;</div>
         <div class="dhx_cal_next_button">&nbsp;</div>
         <div class="dhx_cal_today_button"></div>
         <div class="dhx_cal_date"></div>
         <div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>
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