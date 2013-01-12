<?php
/**
 * @modul flatCal
 * header file
 */

if(!defined('FC_INC_DIR')) {
	die("No access");
}

?>

<link rel="stylesheet" href="../modules/flatCal.mod/styles/acp.css" type="text/css" media="screen, projection">

<script type="text/javascript" src="../modules/flatCal.mod/js/datepicker.js"></script>

<script type="text/javascript">
/* <![CDATA[ */

window.addEvent('load', function() {
	new DatePicker('.dp', { months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
	days: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
	format: 'd.m.Y',
	allowEmpty: true,
	positionOffset: { x: 0, y: 5 }});
});

/* ]]> */
</script>