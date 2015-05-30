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




/* list template folders */

function list_template_folders() {

	$tpl_folders = array();
	
	$directory = "../modules/flatCal.mod/styles";
	
	if(is_dir($directory)) {
	
		$all_folders = glob("$directory/*");
		
		foreach($all_folders as $v) {
			if((is_dir("$v") && $v != "$directory/default")) {
				$tpl_folders[] = basename($v);
			}
		}
	
	 }
	 
	 return $tpl_folders;
}


/* list all images */

function list_images($prefix='') {

	global $img_path;
	$images = array();
	
	$directory = "../$img_path";
	
	if(is_dir($directory)) {
	
		$images_jpg = glob("$directory/*.jpg");
		$images_gif = glob("$directory/*.gif");
		$images_png = glob("$directory/*.png");
		
		$img = @array_merge($images_jpg, $images_png, $images_gif);
		
		foreach ($img as $v) {
			$images[] = basename($v);
		}
	
	 }
	 
	 return $images;
}

?>