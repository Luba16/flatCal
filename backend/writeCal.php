<?php
/*
@modul flatCal
save and update
*/

if(!defined('FC_INC_DIR')) {
	die("No access");
}

// all incoming data -> sqlite_escape_string
foreach($_POST as $key => $val) {
	$$key = @sqlite_escape_string($val); 
}

$cal_startdate = strtotime($_POST['cal_startdate'] . ' UTC');
$cal_enddate = strtotime($_POST['cal_enddate'] . ' UTC');

if($cal_enddate < $cal_startdate) {
	$cal_enddate = $cal_startdate;
}


$cal_categories = @implode("<->", $_POST[cal_categories]);

$dbh = new PDO("sqlite:$mod_db");

$sql_new = "INSERT INTO fc_cals (
			cal_id, cal_title, cal_startdate, cal_enddate, cal_text, cal_categories, cal_author
			) VALUES (
			NULL, '$cal_title', $cal_startdate, $cal_enddate, '$cal_text', '$cal_categories', '$cal_author' ) ";

$sql_update = "UPDATE fc_cals
				SET	cal_title = '$cal_title',
					cal_startdate = '$cal_startdate',
					cal_enddate = '$cal_enddate',
					cal_text = '$cal_text',
					cal_categories = '$cal_categories',
					cal_author = '$cal_author'
				WHERE cal_id = $id ";

if($modus == "new")	{									
	$cnt_changes = $dbh->exec($sql_new);
	$sys_message = "{OKAY} Termin wurde gespeichert";
}

if($modus == "update") {
	$cnt_changes = $dbh->exec($sql_update);
	$sys_message = "{OKAY} Termin wurde aktualisiert";
}

if($cnt_changes > 0){
	print_sysmsg("$sys_message");
} else {
	print_sysmsg("{error} Es ist ein Fehler aufgetreten");
}




?>