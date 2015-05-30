<?php

/**
 * @module flatCal | frontend
 * basic functions
 */



function days_to_start($start) {

	$now = time();
	
	$diff = $start-$now;
	$days = ceil($diff/86400);

	$showdays = "in $days Tagen";
	
	if($days < 0) { $showdays = ""; }
	if($days > 0) { $showdays = "in $days Tagen"; }
	
	if($days == 0) { $showdays = "heute"; }
	if($days == 1) { $showdays = "morgen"; }
	if($days == 2) { $showdays = "übermorgen"; }
	
	return $showdays;
	
}


function list_cals($cals,$mode) {
	
	global $fc_prefs;
	global $fct_slug;
	global $entries_tpl_current;
	global $entries_tpl_archive;
	global $arr_month;
	global $tpl_folder;
	
	$cnt_cals = count($cals);

	for($i=0;$i<$cnt_cals;$i++) {
		
		$cal_id = $cals[$i]['cal_id'];
		$cal_title = stripslashes($cals[$i]['cal_title']);
		$cal_text = stripslashes($cals[$i]['cal_text']);
		$cal_startdate = $cals[$i]['cal_startdate'];
		$cal_enddate = $cals[$i]['cal_enddate'];
		$cal_image = $cals[$i]['cal_image'];
		
		if($cals[$i]['cal_image'] != '') {
			$cal_image = '/content/images/'.$cals[$i]['cal_image'];
		} else {
			$cal_image = '/modules/flatCal.mod/styles/'.$tpl_folder.'/blank.gif';
		}
		
		$showdays = days_to_start($cal_startdate);
		
		$cal_startdate = date("d.m.Y",$cal_startdate);
		$cal_enddate = date("d.m.Y",$cal_enddate);
		$s_day = substr("$cal_startdate", 0, 2);
		$s_mon = substr("$cal_startdate", 3, 2);
		$s_year = substr("$cal_startdate", 6, 4);
		$s_mon = $arr_month[$s_mon];
		
		$array_categories = explode("<->", $cals[$i]['cal_categories']);
		unset($cat_links);
		foreach ($array_categories as $value) {
			$cat_url = FC_INC_DIR . "/$fct_slug" . $fc_prefs['prefs_url_split_cats'] . "/$value/";
			$cat_links .= "<a href='$cat_url'>" . "$value</a> ";
		}
		
		$link = FC_INC_DIR . "/$fct_slug" . "$cal_id" . "/";

		$tpl = $entries_tpl_current;
		if($mode == 'archive') {
			$tpl = $entries_tpl_archive;
		}
		$tpl = str_replace("{cal_link}", "$link", $tpl);
		$tpl = str_replace("{cal_title}", $cal_title, $tpl);
		$tpl = str_replace("{cal_text}", "$cal_text", $tpl);
		$tpl = str_replace("{cal_startdate}", "$cal_startdate", $tpl);
		$tpl = str_replace("{showdays}", "$showdays", $tpl);
		$tpl = str_replace("{s_day}", "$s_day", $tpl);
		$tpl = str_replace("{s_mon}", "$s_mon", $tpl);
		$tpl = str_replace("{s_year}", "$s_year", $tpl);
		$tpl = str_replace("{cal_image}", $cal_image, $tpl);
		
		if($cals[$i]['cal_categories'] != "") {
			$tpl = str_replace("{cal_cats}", "abgelegt unter: $cat_links", $tpl);
		} else {
			$tpl = str_replace("{cal_cats}", "", $tpl);
		}
		
		if($cal_enddate == $cal_startdate) {
			$tpl = str_replace("{cal_enddate}", "", $tpl);
		} else {
			$tpl = str_replace("{cal_enddate}", "&rarr; $cal_enddate", $tpl);
		}
		
		$cals_list .= $tpl;
		
	}
	
	return $cals_list;
	
}



?>