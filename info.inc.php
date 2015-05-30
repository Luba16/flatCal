<?php
/*
 * @module flatCal | configuration
 *
 */


$mod['name'] 				= "flatCal";
$mod['version'] 			= "0.4";

$mod['author']			= "Patrick Konstandin";
$mod['description']		= "Veröffentlichen von Terminen.";

$mod['database']			= "content/SQLite/flatCal.sqlite3";

/* url design */
$mod['url_categories'] = "rubrik";
$mod['url_pages'] = "seite";


$arr_month['01'] = "JAN";
$arr_month['02'] = "FEB";
$arr_month['03'] = "MRZ";
$arr_month['04'] = "APR";
$arr_month['05'] = "MAI";
$arr_month['06'] = "JUN";
$arr_month['07'] = "JUL";
$arr_month['08'] = "AUG";
$arr_month['09'] = "SEP";
$arr_month['10'] = "OKT";
$arr_month['11'] = "NOV";
$arr_month['12'] = "DEZ";



$modnav[0]['link']		= "Übersicht";
$modnav[0]['title']		= "Allen Termine auf einen Blick";
$modnav[0]['file']		= "start";

$modnav[1]['link']		= "Neuer Termin";
$modnav[1]['title']		= "Termin verfassen";
$modnav[1]['file']		= "edit";

$modnav[2]['link']		= "Rubriken";
$modnav[2]['title']		= "Rubriken verfassen, bearbeiten oder löschen";
$modnav[2]['file']		= "categories";

$modnav[3]['link']		= "Einstellungen";
$modnav[3]['title']		= "Einstellungen verfassen, bearbeiten oder löschen";
$modnav[3]['file']		= "prefs";

?>