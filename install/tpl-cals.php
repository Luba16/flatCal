<?php

/**
 * flatCal Database-Scheme
 * install/update the table for entries
 * 
 */

$database = "flatCal";
$table_name = "fc_cals";

$cols = array(
	"cal_id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"cal_startdate"  => 'VARCHAR',
	"cal_enddate" => 'VARCHAR',
	"cal_title" => 'VARCHAR',
	"cal_image" => 'VARCHAR',
	"cal_teaser" => 'VARCHAR',
	"cal_text" => 'VARCHAR',
	"cal_categories" => 'VARCHAR',
  "cal_author" => 'VARCHAR'
  );
?>