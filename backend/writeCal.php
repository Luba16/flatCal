<?php
/**
 * @modul flatCal
 * save and update
 */

if(!defined('FC_INC_DIR')) {
	die("No access");
}

if(isset($_REQUEST['id'])) {
	$id = (int) $_REQUEST['id'];
}

$cal_startdate = strtotime($_POST['cal_startdate'] . ' UTC');
$cal_enddate = strtotime($_POST['cal_enddate'] . ' UTC');

if($cal_enddate < $cal_startdate) {
	$cal_enddate = $cal_startdate;
}

$cal_categories = @implode("<->", $_POST['cal_categories']);
$files_images_string = @implode("<->", $_POST['cals_banner']);

$dbh = new PDO("sqlite:$mod_db");

$sql = "INSERT INTO fc_cals (
			cal_id, cal_title, cal_startdate, cal_enddate, cal_text, cal_categories, cal_author, cal_image
			) VALUES (
			NULL, :cal_title, $cal_startdate, $cal_enddate, :cal_text, :cal_categories, :cal_author, :cal_image) ";

if($_REQUEST['modus'] == "update") {

	$sql = "UPDATE fc_cals
					SET	cal_title = :cal_title,
						cal_startdate = '$cal_startdate',
						cal_enddate = '$cal_enddate',
						cal_text = :cal_text,
						cal_categories = :cal_categories,
						cal_author = :cal_author,
						cal_image = :cal_image
					WHERE cal_id = $id ";
}

				
if(!$sth = $dbh->prepare($sql)) {
	print_r($dbh->errorInfo());
} else {
	$sth->bindParam(':cal_title', $_POST['cal_title'], PDO::PARAM_STR);
	$sth->bindParam(':cal_text', $_POST['cal_text'], PDO::PARAM_STR);
	$sth->bindParam(':cal_author', $_POST['cal_author'], PDO::PARAM_STR);
	$sth->bindParam(':cal_categories', $cal_categories, PDO::PARAM_STR);
	$sth->bindParam(':cal_image', $files_images_string, PDO::PARAM_STR);
	$cnt_changes = $sth->execute();
}




if($cnt_changes == TRUE){
	$sys_message = "{OKAY} Der Eintrag wurde gespeichert";
	record_log("$_SESSION[user_nick]","cal ($modus) <i>$_POST[cal_title]</i>","0");
} else {
	$sys_message = "{error} Der Eintrag wurde nicht gespeichert";
}

print_sysmsg("$sys_message");


?>