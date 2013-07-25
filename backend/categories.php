<?php
/*
@modul flatCal
edit categories
*/

if(!defined('FC_INC_DIR')) {
	die("No access");
}


echo"<div class='header-bc'><span>$mod_name</span><span>Rubriken bearbeiten</span></div>";

$dbh = new PDO("sqlite:$mod_db");


if($_POST[delete_cat]) {

$cat_id = (int) $_POST[cat_id];

$delete_sql = "DELETE FROM fc_calscats
			   WHERE cat_id = $cat_id";

$cnt_changes = $dbh->exec($delete_sql);

}




/*
Neue Rubrik speichern
*/
if($_POST[save_cat]) {

$new_cat_name = sqlite_escape_string($_POST[cat_name]);
$new_cat_description = sqlite_escape_string($_POST[cat_description]);

$new_sql = "INSERT INTO fc_calscats
									(	cat_id ,
										cat_name ,
										cat_description 
									) VALUES (
										NULL,
										'$new_cat_name',
										'$new_cat_description' ) ";

$cnt_changes = $dbh->exec($new_sql);

if($cnt_changes > 0) {
	print_sysmsg("{OKAY} Rubrik wurde gespeichert");
} else {
	print_sysmsg("{error} Es ist ein Fehler aufgetreten");
}


}

/*
EOL - Neue Rubrik speichern
*/


/*
Update Rubrik
*/
if($_POST[update_cat]) {

$cat_id = (int) $_POST[cat_id];
$cat_name = sqlite_escape_string($_POST[cat_name]);
$cat_description = sqlite_escape_string($_POST[cat_description]);

$update_sql = "UPDATE fc_calscats
									SET cat_name = '$cat_name',
										cat_description = '$cat_description'
									WHERE cat_id = $cat_id ";

$cnt_changes = $dbh->exec($update_sql);

if($cnt_changes > 0) {
	print_sysmsg("{OKAY} Rubrik wurde aktualisiert");
} else {
	print_sysmsg("{error} Es ist ein Fehler aufgetreten");
}

}

/*
EOL - Update Rubrik
*/



/*
Alle Rubriken aus der Datenbank holen
*/
$sql = "SELECT * FROM fc_calscats ORDER BY cat_id ASC";

   foreach ($dbh->query($sql) as $row) {
     $cats[] = $row;
   }




/* Datenbank schließen */
$dbh = null;




$submit_button = "<input type='submit' class='btn btn-success' name='save_cat' value='$lang[save]'>";
$delete_button = "";



if($_GET[editcat] != "") {
	$editcat = (int) $_GET[editcat];
	$submit_button = "<input type='submit' class='btn btn-success' name='update_cat' value='$lang[update]'>";
	$delete_button = "<input type='submit' class='btn btn-danger' name='delete_cat' value='$lang[delete]' onclick=\"return confirm('$lang[confirm_delete_data]')\">";
	$hidden_field = "<input type='hidden' name='cat_id' value='$editcat'>";
	
	$cat_name = $cats[$editcat-1][cat_name];
	$cat_description = $cats[$editcat-1][cat_description];
}



/*
FORM // EDIT GROUPS
*/


echo"<fieldset>";
echo"<legend>Rubrik bearbeiten</legend>";

echo"<form action='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=categories' method='POST'>";

echo'<div class="row-fluid">';
echo'<div class="span6">';

echo"<label>Rubrik</label>";
echo"<input type='text' class='input-block-level' name='cat_name' value='$cat_name'>";

echo"<label>Beschreibung</label>";
echo"<textarea class='input-block-level' rows='4' name='cat_description'>$cat_description</textarea>";

echo"</div>";
;
echo'<div class="span6">';

echo"<h5>Vorhandene Rubriken:</h5>";



for($i=0;$i<count($cats);$i++) {

	$cat_id = $cats[$i][cat_id];
	$cat_name = $cats[$i][cat_name];
	$cat_description = $cats[$i][cat_description];
	$cat_counter = $cats[$i][cat_counter];
	
	if(!$cat_counter) {
		$cat_counter = 0;
	}
	
	echo"<div style='margin:4px 0; border-bottom: 1px solid #ccc;'>";
	echo"<b>$cat_name</b><br />$cat_description<br />";
	echo"<a href='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=categories&editcat=$cat_id'>Bearbeiten</a>";
	echo"</div>";

}


echo"</div>";

echo"</div>";

echo"<div class='formfooter'>";
echo"$hidden_field $delete_button $submit_button";
echo"</div>";

echo"</form>";

echo"</fieldset>";


?>