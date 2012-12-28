<?php
/*
@modul flatCal
edit entries
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


/* fill vars with data
example: $news_title = stripslashes($result[news_title]); */

foreach($result as $k => $v) {
   $$k = stripslashes($v);
}



} else {
$modus = "new";
$save_button = "<input type='submit' class='btn btn-success' name='save_cal' value='Speichern'>";
}



echo"<form action='$_SERVER[PHP_SELF]?tn=moduls&sub=flatCal.mod&a=edit' method='POST'>";

// fancytabs
echo"<div id='tabsBlock'>";



/* tab_info */
echo"<h4>Einstellungen</h4>";

echo"<div>";


echo'<div class="row-fluid">';
echo'<div class="span8">';

echo"<h5>Überschrift</h5>
<input class='input-block-level' type='text' name='cal_title' value='$cal_title'>";

echo'<div class="row-fluid">';

echo'<div class="span6">';
if($cal_startdate == "") {
	$cal_startdate = date("d.m.Y");
}

if($cal_enddate == "") {
	$cal_enddate = date("d.m.Y");
}

echo"<h5>Beginn:</h5>";
echo"<input name='cal_startdate' type='text' value='$cal_startdate' class='date dp input-block-level' />";

echo'</div>'; // span6
echo'<div class="span6">';

echo"<h5>Ende (optional):</h5>";
echo"<input name='cal_enddate' type='text' value='$cal_enddate' class='date dp input-block-level' />";

echo'</div>'; // span6
echo'</div>'; // row-fluid

if($news_author == "") {
	$news_author = "$_SESSION[user_firstname] $_SESSION[user_lastname]";
}

echo"<h5>Author</h5>
<input class='input-block-level' type='text' name='news_author' value='$news_author'>";

echo'</div>'; // span8

echo'<div class="span4">';


echo"<h5>Rubriken</h5>";

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





echo"<div class='clear'></div>";

echo"</div>";
/* EOL tab_info ### ### ### */



/* tab_info */
echo"<h4>Text</h4>";

echo"<div>";

echo'<h5>Text</h5>';
echo"<textarea name='cal_text' class='mceEditor'>$cal_text</textarea>";

echo"</div>";
/* EOL tab_info ### ### ### */





echo"</div>";
// EOL fancytabs

//submit form to save data
echo"<div class='formfooter'>";
echo"<input type='hidden' name='modus' value='$modus'>";
echo"<input type='hidden' name='id' value='$id'>";
echo"$save_button";
echo"</div>";

echo"</form>";





?>