<?php

/**
 * flatCal Database-Scheme
 * install/update the table for categories
 */

$database = "flatCal";
$table_name = "fc_calscats";

$cols = array(
	"cat_id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"cat_description"  => 'VARCHAR',
	"cat_counter" => 'VARCHAR'
  );
 
?>
