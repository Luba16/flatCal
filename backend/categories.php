<?php
/*
@modul flatCal
edit categories
*/

if(!defined('FC_INC_DIR')) {
	die("No access");
}


echo"<h3>$mod_name <small>Rubriken bearbeiten</small></h3>";

$dbh = new PDO("sqlite:$mod_db");


if($_POST['delete_cat']) {
	$cat_id = (int) $_POST['cat_id'];
	$delete_sql = "DELETE FROM fc_calscats WHERE cat_id = $cat_id";
	$cnt_changes = $dbh->exec($delete_sql);
}




if($_POST['save_cat']) {

	$new_cat_name = $dbh -> quote($_POST['cat_name']);
	$new_cat_description = $dbh -> quote($_POST['cat_description']);
	
	$new_sql = "INSERT INTO fc_calscats
										(	cat_id ,
											cat_name ,
											cat_description 
										) VALUES (
											NULL,
											$new_cat_name,
											$new_cat_description ) ";
	
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

	$cat_name = $dbh -> quote($_POST[cat_name]);
	$cat_description = $dbh -> quote($_POST[cat_description]);

$update_sql = "UPDATE fc_calscats
									SET cat_name = $cat_name,
										cat_description = $cat_description
									WHERE cat_id = $cat_id ";

$cnt_changes = $dbh->exec($update_sql);

if($cnt_changes > 0) {
	print_sysmsg("{OKAY} Rubrik wurde aktualisiert");
} else {
	print_sysmsg("{error} Es ist ein Fehler aufgetreten");
	print_r($dbh->errorInfo());
}

$_REQUEST[editcat] = $editcat;

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



if($_REQUEST[editcat] != "") {
	$editcat = (int) $_REQUEST[editcat];
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

echo'<div class="row">';
echo'<div class="col-md-6">';

echo '<div class="form-group">';
echo"<label>Rubrik</label>";
echo"<input type='text' class='form-control' name='cat_name' value='$cat_name'>";
echo '</div>';

echo '<div class="form-group">';
echo"<label>Beschreibung</label>";
echo"<textarea class='form-control' rows='4' name='cat_description'>$cat_description</textarea>";
echo '</div>';

echo"</div>";
echo'<div class="col-md-6">';

echo"<h4>Vorhandene Rubriken:</h4>";

for($i=0;$i<count($cats);$i++) {

	$cat_id = $cats[$i]['cat_id'];
	$cat_name = $cats[$i]['cat_name'];
	$cat_description = $cats[$i]['cat_description'];
	$cat_counter = $cats[$i]['cat_counter'];
	
	if(!$cat_counter) {
		$cat_counter = 0;
	}
	
	echo"<div style='margin:4px 0; border-bottom: 1px solid #ccc;'>";
	echo"<b>$cat_name</b><br />$cat_description<br />";
	echo"<a href='acp.php?tn=moduls&sub=flatCal.mod&a=categories&editcat=$cat_id' class='btn btn-xs btn-default'>Bearbeiten</a>";
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