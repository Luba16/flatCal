<?php

/**
 * @module flatCal | frontend
 * index
 *
 * $mod_slug -> for example
 *		/22/ -> integer show article
 *		/$fc_prefs['prefs_url_split_cats']/example/ -> show archive from category
 *
 */

include("info.inc.php");
include("frontend/functions.php");


$mod_db = $mod['database'];
$dbh = new PDO("sqlite:$mod_db");
$sql = "SELECT * FROM fc_prefs WHERE prefs_status = 'active' ";
$fc_prefs = $dbh->query($sql);
$fc_prefs = $fc_prefs->fetch(PDO::FETCH_ASSOC);
$dbh = null;

$tpl_folder = 'default';

if($fc_prefs['prefs_template'] != 'use_standard') {
	$tpl_folder = $fc_prefs['prefs_template'];
}

/* include stylesheets for this modul */
$tpl_styles = file_get_contents('modules/flatCal.mod/styles/'.$tpl_folder.'/styles.css');
$styles = '<style type="text/css">'.$tpl_styles.'</style>';

$modul_head_enhanced = "$styles";



$a_mod_slug = explode("/", $mod_slug);

$display_mode = 'list_archive'; // default mode

if($a_mod_slug[0] == $fc_prefs['prefs_url_split_cats'] AND $a_mod_slug[1] != "") {
	$cat = strip_tags($a_mod_slug[1]);
	$display_mode = 'list_archive_by_category';	
}


if(is_numeric($a_mod_slug[0])) {
	$display_mode = 'show_entry';
	$cal_id = (int) $a_mod_slug[0];
}


if($id != "") {
	$cal_id = (int) $id;
	$display_mode = 'show_entry';
}



if(is_file("$mod[database]")) {

	switch ($display_mode) {
    case "show_entry":
        include("frontend/show_entry.php");
        break;
    case "list_archive_by_category":
        include("frontend/list_cals.php");
        break;
   default:
        include("frontend/list_cals.php");
}

} else {

	$modul_content = "<p class='notice'>Es sind noch keine Termine gespeichert...</p>";

}


?>