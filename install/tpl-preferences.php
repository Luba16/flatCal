<?php

/**
 * flatCal Database-Scheme
 * install/update the table for preferences
 * 
 */

$database = "flatCal";
$table_name = "fc_prefs";

$cols = array(
	"prefs_id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"prefs_status"  => 'VARCHAR',
	"prefs_template"  => 'VARCHAR',
	"prefs_url_split_cats"  => 'VARCHAR',
	"prefs_url_split_pager"  => 'VARCHAR',
	"prefs_version" => 'VARCHAR'
  );
?>