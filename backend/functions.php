<?php

if(!defined('FC_INC_DIR')) {
	die("No access");
}

/**
 * get all categories
 * return as array
 */

function get_all_cal_categories() {

	global $mod_db;
	
	$dbh = new PDO("sqlite:$mod_db");
	$sql = "SELECT cat_name FROM fc_calscats ORDER BY cat_id ASC";
	
 foreach ($dbh->query($sql) as $row) {
   $cats[] = $row;
 }
	
 $dbh = null;
	
 return($cats);
}



?>