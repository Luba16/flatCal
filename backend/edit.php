<?php
/**
 * @modul flatCal
 * edit entries
*/


if(!defined('FC_INC_DIR')) {
	die("No access");
}

if($_REQUEST['id'] != "") {
	$title_add = 'Termin bearbeiten';
} else {
	$title_add = 'Termin einstellen';
}

echo '<h3>'.$mod_name.' <small>'.$title_add.'</small></h3>';


include("functions.php");

if($_POST['save_cal']) {
	include("writeCal.php");
}


if(isset($_REQUEST['id'])) {
	$modus = "update";
	$id = (int) $_REQUEST['id'];
	$btn_value = 'Aktualisieren';
	
	$dbh = new PDO("sqlite:$mod_db");	
	$sql = "SELECT * FROM fc_cals WHERE cal_id = $id";
	$result = $dbh->query($sql);
	$result= $result->fetch(PDO::FETCH_ASSOC);
	$dbh = null;
	
	foreach($result as $k => $v) {
	   $$k = stripslashes($v);
	}

} else {
	$modus = "new";
	$btn_value = 'Speichern';
}

if($cal_startdate > 0) {
	$cal_startdate = date("Y-m-d",$cal_startdate);
} else {
	$cal_startdate = date("Y-m-d");
}

if($cal_enddate > 0) {
	$cal_enddate = date("Y-m-d",$cal_enddate);
} else {
	$cal_enddate = date("Y-m-d");
}

if($cal_author == "") {
	$cal_author = $_SESSION['user_firstname'] .' '. $_SESSION['user_lastname'];
}

/* generate categories list */
$cats = get_all_cal_categories();
$cats_str = '<ul class="list-unstyled">';
for($i=0;$i<count($cats);$i++) {
	$category = $cats[$i]['cat_name'];
	
	$array_categories = explode("<->", $cal_categories);
	$checked = "";
	if(in_array("$category", $array_categories)) {
	    $checked = "checked";
	}
	$cats_str .= "<li><div class='checkbox'><label><input type='checkbox' name='cal_categories[]' value='$category' $checked> $category</label></div></li>";
}
$cats_str .= '</ul>';


/* gerate image selection widget */
$images = list_images();
$select_images = '<select multiple="multiple" class="image-picker show-html" name="cals_banner[]">';

for($i=0;$i<count($images);$i++) {
	
	$image_name = $images[$i];
	$imgsrc = "../$img_path/$images[$i]";

	$selected_img = '';
	if(strpos($cal_image, $image_name) !== false) { $selected_img = 'selected'; }
	$select_images .= '<option data-img-src="../content/images/'.$image_name.'" value="'.$image_name.'" '.$selected_img.'>'.$image_name.'</option>';
}

$select_images .= '</select>';

$images_widget = '<div class="images-list scrollbox">'.$select_images.'</div>';


$form_tpl = file_get_contents('../modules/flatCal.mod/templates/edit_form.tpl');
$form_tpl = str_replace('{cal_title}', $cal_title, $form_tpl);
$form_tpl = str_replace('{cal_author}', $cal_author, $form_tpl);
$form_tpl = str_replace('{cal_startdate}', $cal_startdate, $form_tpl);
$form_tpl = str_replace('{cal_enddate}', $cal_enddate, $form_tpl);
$form_tpl = str_replace('{cal_text}', $cal_text, $form_tpl);
$form_tpl = str_replace('{categories_list}', $cats_str, $form_tpl);
$form_tpl = str_replace('{images_list}', $images_widget, $form_tpl);
$form_tpl = str_replace('{modus}', $modus, $form_tpl);
$form_tpl = str_replace('{id}', $id, $form_tpl);
$form_tpl = str_replace('{btn_value}', $btn_value, $form_tpl);
$form_tpl = str_replace('{form_action}', "acp.php?tn=moduls&sub=flatCal.mod&a=edit", $form_tpl);


echo $form_tpl;







?>