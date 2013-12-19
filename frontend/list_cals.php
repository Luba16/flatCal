<?php

/**
 * @module flatCal | frontend
 * list entries
 */
 

$today_ts = time()-86400;
$filer_sql = "WHERE cal_enddate > '$today_ts' ";

if($_GET[start] != "") {
	$start = (int) $_GET[start];
}

if($cat != "") {
	$filter = sqlite_escape_string($cat);
	$filer_sql = "WHERE cal_categories LIKE '%$filter%' AND cal_enddate > '$today_ts' ";
}



$dbh = new PDO("sqlite:$mod[database]");

$count_entries = $dbh->query("Select Count(*) FROM fc_cals $filer_sql ")->fetch();
$count_entries = $count_entries[0];


$sql = "SELECT cal_id, cal_startdate, cal_enddate, cal_title, cal_text, cal_categories
		FROM fc_cals
		$filer_sql
		ORDER BY cal_startdate ASC";

foreach ($dbh->query($sql) as $row) {
			$cal[] = $row;
	}


$dbh = null;


$count_cals = count($cal);
$now = time();

for($i=0;$i<$count_cals;$i++) {

	$cal_id = $cal[$i]['cal_id'];
	$cal_title = stripslashes($cal[$i]['cal_title']);
	$cal_text = stripslashes($cal[$i]['cal_text']);
	$cal_startdate = $cal[$i]['cal_startdate'];
	$cal_enddate = $cal[$i]['cal_enddate'];
	
	$showdays = days_to_start($cal_startdate);
	
	$cal_startdate = date("d.m.Y",$cal_startdate);
	$cal_enddate = date("d.m.Y",$cal_enddate);
	
	$s_day = substr("$cal_startdate", 0, 2);
	$s_mon = substr("$cal_startdate", 3, 2);
	$s_year = substr("$cal_startdate", 6, 4);
	
	$s_mon = $arr_month[$s_mon];
	
	$array_categories = explode("<->", $cal[$i][cal_categories]);
	unset($cat_links);
	foreach ($array_categories as $value) {	    
	    if($fc_mod_rewrite == "permalink") {
	    	$cat_url = FC_INC_DIR . "/$fct_slug" . "$mod[url_categories]" . "/$value/";
		  	$cat_links .= "<a href='$cat_url'>" . "$value</a> ";
		  } else {
			  $cat_links .= "<a href='$_SERVER[PHP_SELF]?p=$p&cat=$value'>$value</a> ";
			}
	}
	
	if($fc_mod_rewrite == "permalink") {
		$link = FC_INC_DIR . "/$fct_slug" . "$cal_id" . "/";	
	} else {
		$link = "$_SERVER[PHP_SELF]?p=$p&id=$cal_id";
	}
	
	$tpl = file_get_contents("modules/flatCal.mod/templates/entries.tpl");
	$tpl = str_replace("{cal_link}", "$link", $tpl);
	$tpl = str_replace("{cal_title}", $cal_title, $tpl);
	$tpl = str_replace("{cal_text}", "$cal_text", $tpl);
	$tpl = str_replace("{cal_startdate}", "$cal_startdate", $tpl);
	$tpl = str_replace("{showdays}", "$showdays", $tpl);
	$tpl = str_replace("{s_day}", "$s_day", $tpl);
	$tpl = str_replace("{s_mon}", "$s_mon", $tpl);
	$tpl = str_replace("{s_year}", "$s_year", $tpl);
	
	if($cal[$i][cal_categories] != "") {
		$tpl = str_replace("{cal_cats}", "abgelegt unter: $cat_links", $tpl);
	} else {
		$tpl = str_replace("{cal_cats}", "", $tpl);
	}
	
	if($cal_enddate == $cal_startdate) {
		$tpl = str_replace("{cal_enddate}", "", $tpl);
	} else {
		$tpl = str_replace("{cal_enddate}", "&rarr; $cal_enddate", $tpl);
	}
	
	$articles_list .= "$tpl";
	unset($tpl);

} // eol $i



if(count($cal) < 1) {
	$articles_tpl = "<div class='alert alert-info'>Es sind noch keine Nachrichten gespeichert...</div>";
}


$modul_content = "$articles_list";




?>