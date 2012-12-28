<?php

/*
Falls nicht vorhanden,
Datenbank für Termine erzeugen
*/

if(!is_file("$mod_db")) {

$sql_news_table = file_get_contents("../modules/flatCal.mod/supplies/fc_cals.sql");
$sql_cats_table = file_get_contents("../modules/flatCal.mod/supplies/fc_calscats.sql");

$dbh = new PDO("sqlite:$mod_db");

$dbh->query($sql_news_table);
$dbh->query($sql_cats_table);


$dbh = null;

}

?>