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

<script type="text/javascript" src="../modules/flatCal.mod/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
$(function(){
	$('.dp').datepicker({format:'yyyy-mm-dd'})
});
</script>