<?php

/**
 * @module flatCal | frontend
 * show entry by id
 */


$dbh = new PDO("sqlite:$mod[database]");

$sql = "SELECT * FROM fc_cals WHERE cal_id = '$cal_id' ";

$result = $dbh->query($sql);
$result= $result->fetch(PDO::FETCH_ASSOC);

$dbh = null;

foreach($result as $k => $v) {
   $$k = stripslashes($v);
}


if(!is_array($result)) {
	$show_404 = "true";
}



if($fc_mod_rewrite == "permalink") {
	$backlink = FC_INC_DIR . "/$fct_slug";	
} else {
	$backlink = "$_SERVER[PHP_SELF]?p=$p";
}

$showdays = days_to_start($cal_startdate);

$cal_startdate = date("d.m.Y",$cal_startdate);
$cal_enddate = date("d.m.Y",$cal_enddate);

$s_day = substr("$cal_startdate", 0, 2);
$s_mon = substr("$cal_startdate", 3, 2);
$s_year = substr("$cal_startdate", 6, 4);

$s_mon = $arr_month[$s_mon];

$array_categories = explode("<->", $cal_categories);
unset($cat_links);
foreach ($array_categories as $value) {
    $cat_links .= "<a href='$_SERVER[PHP_SELF]?p=$p&cat=$value'>$value</a> ";
}

if($fc_mod_rewrite == "permalink") {
	$backlink = FC_INC_DIR . "/$fct_slug";	
} else {
	$backlink = "$_SERVER[PHP_SELF]?p=$p";
}

$tpl = file_get_contents("modules/flatCal.mod/templates/entry.tpl");
$tpl = str_replace("{cal_title}", $cal_title, $tpl);
$tpl = str_replace("{cal_text}", "$cal_text", $tpl);
$tpl = str_replace("{cal_startdate}", "$cal_startdate", $tpl);
$tpl = str_replace("{showdays}", "$showdays", $tpl);
$tpl = str_replace("{s_day}", "$s_day", $tpl);
$tpl = str_replace("{s_mon}", "$s_mon", $tpl);
$tpl = str_replace("{s_year}", "$s_year", $tpl);
$tpl = str_replace("{backlink}", "$backlink", $tpl);

if($cal_categories != "") {
	$tpl = str_replace("{cal_cats}", "abgelegt unter: $cat_links", $tpl);
} else {
	$tpl = str_replace("{cal_cats}", "", $tpl);
}

if($cal_enddate == $cal_startdate) {
	$tpl = str_replace("{cal_enddate}", "", $tpl);
} else {
	$tpl = str_replace("{cal_enddate}", "&rarr; $cal_enddate", $tpl);
}




/* send data string to the template */
$modul_content = "$tpl";



?>