<?php
/**
 * @modul flatCal
 * edit entries
*/

if(!defined('FC_INC_DIR')) {
	die("No access");
}

echo"<div class='header-bc'><span>$mod_name</span>";

if($_REQUEST[id] != "") {
	echo"<span>Termin bearbeiten</span>";
} else {
	echo"<span>Termin einstellen</span>";
}

echo"</div>";

include("functions.php");

if($_POST[save_cal]) {
	include("writeCal.php");
}


if($_REQUEST[id] != "") {
	$modus = "update";
	$id = (int) $_REQUEST[id];
	$save_button = "<input type='submit' class='btn btn-success' name='save_cal' value='Aktualisieren'>";
	
	
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
	$save_button = "<input type='submit' class='btn btn-success' name='save_cal' value='Speichern'>";
}



echo"<form action='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=edit' method='POST'>";


echo'<div class="row-fluid">';
echo'<div class="span8">';

echo"<label>Überschrift</label>
<input class='input-block-level' type='text' name='cal_title' value='$cal_title'>";

echo'<div class="row-fluid">';

echo'<div class="span6">';

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

echo"<label>Beginn:</label>";
echo"<input name='cal_startdate' type='text' value='$cal_startdate' class='dp input-block-level' />";

echo'</div>'; // span6
echo'<div class="span6">';

echo"<label>Ende (optional):</label>";
echo"<input name='cal_enddate' type='text' value='$cal_enddate' class='dp input-block-level' />";

echo'</div>'; // span6
echo'</div>'; // row-fluid

if($news_author == "") {
	$news_author = "$_SESSION[user_firstname] $_SESSION[user_lastname]";
}

echo"<label>Author</label>
<input class='input-block-level' type='text' name='news_author' value='$news_author'>";

echo'</div>'; // span8

echo'<div class="span4">';


echo"<label>Rubriken</h5>";

$cats = get_all_cal_categories();

echo'<ul class="unstyled">';
for($i=0;$i<count($cats);$i++) {
	$category = $cats[$i][cat_name];
	
	$array_categories = explode("<->", $cal_categories);
	$checked = "";
	if(in_array("$category", $array_categories)) {
	    $checked = "checked";
	}
	echo"<li><input type='checkbox' name='cal_categories[]' value='$category' $checked> $category</li>";
}
echo'</ul>';




echo'</div>'; // span4

echo'</div>'; // row-fluid




echo"<textarea name='cal_text' class='mceEditor'>$cal_text</textarea>";




//submit form to save data
echo"<div class='formfooter'>";
echo"<input type='hidden' name='modus' value='$modus'>";
echo"<input type='hidden' name='id' value='$id'>";
echo"$save_button";
echo"</div>";

echo"</form>";





?>