<?php

/**
 * @module flatCal | frontend
 * basic functions
 */



function days_to_start($start) {

	$now = time();
	
	$rnd_cal_startdate = ceil($start/86400)*86400; 
	$rnd_now = ceil($now/86400)*86400; 

	$dif_date = $rnd_cal_startdate-$rnd_now;
	$days = ceil($dif_date/86400);

	$showdays = "in $days Tagen";
	
	if($days < 0) { $showdays = ""; }
	if($days > 0) { $showdays = "in $days Tagen"; }
	
	if($days == 0) { $showdays = "heute"; }
	if($days == 1) { $showdays = "morgen"; }
	if($days == 2) { $showdays = "übermorgen"; }
	
	return $showdays;
	
}


?>