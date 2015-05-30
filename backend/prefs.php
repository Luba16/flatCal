<?php

if(!defined('FC_INC_DIR')) {
	die("No access");
}

// all incoming data -> strip_tags
foreach($_REQUEST as $key => $val) {
	$$key = @strip_tags($val); 
}

include("functions.php");




/* write prefs */

if(isset($_POST['saveprefs'])) {
	
	$dbh = new PDO("sqlite:$mod_db");
	
	$sql = "UPDATE fc_prefs
					SET prefs_template = '$fc_prefs_template', prefs_url_split_cats = '$prefs_url_split_cats', prefs_url_split_pager = '$prefs_url_split_pager'
					WHERE prefs_status = 'active' ";
	
	$cnt_changes = $dbh->exec($sql);
	
	if($cnt_changes > 0){
		$sys_message = "{OKAY} $lang[db_changed]";
	} else {
		$sys_message = "{ERROR} $lang[db_not_changed]";
	}
	
	$dbh = null;
}


/* read the prefs */

$dbh = new PDO("sqlite:$mod_db");

$sql = "SELECT * FROM fc_prefs WHERE prefs_status = 'active' ";

$fc_prefs = $dbh->query($sql);
$fc_prefs = $fc_prefs->fetch(PDO::FETCH_ASSOC);

$dbh = null;


if($sys_message != ""){
	print_sysmsg("$sys_message");
}


echo '<h3>'.$mod_name.' '.$mod_version.' <small>| Einstellungen</small></h3>';


echo'<form action="acp.php?tn=moduls&sub=flatCal.mod&a=prefs" class="" method="POST">';

echo '<div class="row">';
echo '<div class="col-md-4">';

$tpl_folders = list_template_folders();

echo '<div class="form-group">';
echo '<label>Template</label>';
echo '<select class="form-control" name="fc_prefs_template">';
echo '<option value="use_standard">'.$lang['use_standard'].'</option>';

foreach ($tpl_folders as $tpl) {
	unset($sel);
	if($fc_prefs['prefs_template'] == $tpl) {
		$sel = "selected";
	}					
	echo "<option $sel value='$tpl'>$tpl</option>";
}
echo '</select>';
echo '</div>';

echo '</div>'; // col
echo '<div class="col-md-4">';

echo '<div class="form-group">';
echo '<label>Url (Pager)</label>';
echo '<input name="prefs_url_split_pager" type="text" class="form-control" value="'.$fc_prefs['prefs_url_split_pager'].'">';
echo '</div>';

echo '</div>'; // col
echo '<div class="col-md-4">';

echo '<div class="form-group">';
echo '<label>URL (Rubriken)</label>';
echo '<input name="prefs_url_split_cats" type="text" class="form-control" value="'.$fc_prefs['prefs_url_split_cats'].'">';
echo '</div>';

echo '</div>'; // col
echo '</div>'; // row



echo '<div class="formfooter">';
echo '<input type="submit" class="btn btn-success" name="saveprefs" value="' . $lang['save'] . '">';
echo '</div>';


echo '</form>';


echo '<hr><div class="well well-sm"><h5><span class="glyphicon glyphicon-info-sign"></span> '.$mod_name.'</h5>';
echo '<dl class="dl-horizontal">';
foreach($mod as $k => $v) {
	echo '<dt>'.$k.'</dt><dd>'.$v.'</dd>';
}
echo '</dl>';
echo '</div>';


?>