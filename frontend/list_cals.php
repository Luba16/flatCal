<?php

/**
 * @module flatCal | frontend
 * list entries
 */
$show_archive = true;

$entries_tpl_cont_current = file_get_contents('modules/flatCal.mod/styles/'.$tpl_folder.'/entries_container_current.tpl');
$entries_tpl_cont_archive = file_get_contents('modules/flatCal.mod/styles/'.$tpl_folder.'/entries_container_archive.tpl');
$entries_tpl_current = file_get_contents('modules/flatCal.mod/styles/'.$tpl_folder.'/entries_current.tpl');
$entries_tpl_archive = file_get_contents('modules/flatCal.mod/styles/'.$tpl_folder.'/entries_archive.tpl');

$today_ts = time()-86400;
$filter_current = "WHERE cal_enddate > '$today_ts' ";
$filter_archive = "WHERE cal_enddate < '$today_ts' ";


if($cat != "") {
	$cat_filter = strip_tags($cat);
	$filter_current = "WHERE cal_categories LIKE '%$cat_filter%' AND cal_enddate > '$today_ts' ";
	$entries_tpl_cont_current = str_replace('{category}', $cat, $entries_tpl_cont_current);
	$show_archive = false;
} else {
	$entries_tpl_cont_current = str_replace('{category}', '', $entries_tpl_cont_current);
}

$dbh = new PDO("sqlite:$mod[database]");

$count_entries = $dbh->query("Select Count(*) FROM fc_cals $filter_current ")->fetch();
$count_entries = $count_entries[0];


$sql_current = "SELECT * FROM fc_cals $filter_current ORDER BY cal_startdate ASC";
$sql_archive = "SELECT * FROM fc_cals $filter_archive ORDER BY cal_startdate DESC";

foreach ($dbh->query($sql_current) as $row) {
	$cals_current[] = $row;
}

foreach ($dbh->query($sql_archive) as $row) {
	$cals_archive[] = $row;
}

$dbh = null;

$cnt_current = count($cals_current);
$cnt_archive = count($cals_archive);
$now = time();


$list_current_cals = list_cals($cals_current,'current');
$entries_tpl_cont_current = str_replace('{entries_list}', $list_current_cals, $entries_tpl_cont_current);

if($show_archive == true) {
	$list_archive_cals = list_cals($cals_archive,'archive');
	$entries_tpl_cont_archive = str_replace('{entries_list}', $list_archive_cals, $entries_tpl_cont_archive);
} else {
	$entries_tpl_cont_archive = '';
}


if(count($cal) < 1) {
	$articles_tpl = "<div class='alert alert-info'>Es sind noch keine Nachrichten gespeichert...</div>";
}


$modul_content = "$entries_tpl_cont_current $entries_tpl_cont_archive";




?>