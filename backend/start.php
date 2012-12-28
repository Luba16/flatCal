<?php

/**
 * @modul flatCal | frontend
 * startpage
*/

if(!defined('FC_INC_DIR')) {
	die("No access");
}

echo"<div class='header-bc'><span>$mod_name</span></div>";



if(!is_file("$mod_db")) {
	echo"Die Datenbank existiert nicht...<br />";
	include("../modules/flatCal.mod/supplies/createDB.php");
}


/* change settings */
if($_POST[change_settings]) {

	if($_POST[show_expired] == "show") {
		$_SESSION[show_expired] = "show";
	} else {
		unset($_SESSION[show_expired]);
	}

}



$dbh = new PDO("sqlite:$mod_db");


if(is_numeric($_REQUEST[delete])){
	$delete = (int) $_REQUEST[delete];
	$sql = "DELETE FROM fc_cals WHERE cal_id = $delete";
	$cnt_changes = $dbh->exec($sql);
	
	if($cnt_changes > 0) {
		$sys_message = "{OKAY} Der Termin wurde gelöscht";
	}
	
	print_sysmsg("$sys_message");

}


if($_SESSION[show_expired]) {
	$filer_sql = "";
} else {
	$today_ts = time() - 86400;
	$filer_sql = "WHERE cal_enddate >= $today_ts ";
}

$count_entries = $dbh->query("Select Count(*) FROM fc_cals $filer_sql ")->fetch();
$count_entries = $count_entries[0];

$articles_per_page = 10;
$start = 0;

$show_start = $start+1;

$nbr_pages = ceil($count_entries/$articles_per_page);


if($_GET[start] != "") {
	$start = (int) $_GET[start];
}

$end = $start+$articles_per_page;

if($end > $count_entries) {
	$end = $count_entries;
}


$nextstart = $end;
$prevstart = $start-$articles_per_page;


$older_link = "<a href='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=start&start=$nextstart'>Weiter &rarr;</a>";
$newer_link = "<a href='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=start&start=$prevstart'>&larr; Zurück</a>";

if($prevstart < 0) {
	$prevstart = 0;
	$newer_link = "&larr; Zurück";
}

if($nextstart == $count_entries) {
	$older_link = "Weiter &rarr;";
}

/* current page */
$cp = ceil(($count_entries-$start)/$articles_per_page);
$cp = $nbr_pages-$cp+1;








$sql = "SELECT cal_id, cal_startdate, cal_enddate, cal_title, cal_text
		FROM fc_cals
		$filer_sql
		ORDER BY cal_startdate ASC
		LIMIT $start , $articles_per_page";

   foreach ($dbh->query($sql) as $row) {
     $result[] = $row;
   }




$dbh = null;



echo"<p style='padding:4px;background-color:#ccc;text-align:center;'>
		Eintrag $show_start bis $end von $count_entries Terminen (Seite $cp von $nbr_pages)<br />$newer_link $older_link
	 </p>";


for($i=0;$i<count($result);$i++) {

$cal_id = $result[$i][cal_id];
$cal_title = stripslashes($result[$i][cal_title]);
$cal_text = stripslashes($result[$i][cal_text]);

/* timestamps */
$cal_startdate = $result[$i][cal_startdate];
$cal_enddate = $result[$i][cal_enddate];
$now = time();


/* round timestamps */
$rnd_cal_startdate = ceil($cal_startdate/86400)*86400; 
$rnd_now = ceil($now/86400)*86400; 

$dif_date = $rnd_cal_startdate-$rnd_now;
$days = ceil($dif_date/86400);

$showdays = "in $days Tagen";

if($days == 0) { $showdays = "heute"; }
if($days == 1) { $showdays = "morgen"; }
if($days == 2) { $showdays = "übermorgen"; }




$cal_startdate = date("d.m.Y",$cal_startdate);
$cal_enddate = date("d.m.Y",$cal_enddate);




$link_edit = "<a class='btn btn-success btn-mini' href='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=edit&id=$cal_id'>Bearbeiten</a>";
$link_delete = "<a class='btn btn-danger btn-mini' href='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=start&delete=$cal_id' onclick=\"return confirm('$lang[confirm_delete_data]')\">Löschen</a>";


$tpl = file_get_contents("../modules/flatCal.mod/templates/acp_cals_list.tpl");
$tpl = str_replace("{cal_id}", $cal_id, $tpl);
$tpl = str_replace("{cal_title}", $cal_title, $tpl);
$tpl = str_replace("{cal_text}", "$cal_text", $tpl);
$tpl = str_replace("{cal_startdate}", "$cal_startdate", $tpl);
$tpl = str_replace("{cal_enddate}", "$cal_enddate", $tpl);
$tpl = str_replace("{showdays}", "$showdays", $tpl);
$tpl = str_replace("{edit_cal}", "$link_edit", $tpl);
$tpl = str_replace("{delete_cal}", "$link_delete", $tpl);





echo "$tpl";

}


if($_SESSION[show_expired]) {
$checked_show_expired = "checked";
} else {
$checked_show_expired = "";
}

echo"<br /><hr><br /><form action='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=start' method='POST'>";

echo"<input type='checkbox' name='show_expired' value='show' $checked_show_expired> Abgelaufene Termine anzeigen<br />";
echo"<input type='submit' class='btn btn-mini' value='Übernehmen' name='change_settings'>";
echo"</form>";



?>