<?php

/**
 * @module flatCal | frontend
 * index
 *
 * $mod_slug -> for example
 *		/22/ -> integer show article
 *		/$mod[url_categories]/example/ -> show archive from category
 *
 */

include("info.inc.php");
include("frontend/functions.php");

$tpl = file_get_contents("modules/flatCal.mod/styles/styles.css");

$styles = "<style type='text/css'>$tpl</style>";
$modul_head_enhanced = "$styles";



$a_mod_slug = explode("/", $mod_slug);

$display_mode = 'list_archive'; // default mode

if($a_mod_slug[0] == "$mod[url_categories]" AND $a_mod_slug[1] != "") {
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